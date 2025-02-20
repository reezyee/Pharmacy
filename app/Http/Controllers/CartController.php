<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function mergeCartWithDatabase()
    {
        if (Auth::check()) {
            $sessionCart = session()->get('cart', []);

            foreach ($sessionCart as $obatId => $item) {
                Cart::updateOrCreate(
                    ['user_id' => Auth::id(), 'obat_id' => $obatId],
                    ['quantity' => $item['quantity']]
                );
            }

            session()->forget('cart');
        }
    }

    private function getCartItems()
    {
        if (Auth::check()) {
            $cartItems = Cart::where('user_id', Auth::id())
                ->with('obat')
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->obat_id,
                        'name' => $item->obat->nama,
                        'price' => $item->obat->harga,
                        'quantity' => $item->quantity,
                        'image' => $item->obat->foto
                    ];
                })
                ->keyBy('id')
                ->toArray();
            return $cartItems;
        }

        return session()->get('cart', []);
    }

    public function getCount()
    {
        $cartItems = $this->getCartItems();
        $items = [];

        foreach ($cartItems as $id => $item) {
            $items[] = [
                'obat_id' => $id,
                'quantity' => $item['quantity']
            ];
        }

        return response()->json([
            'count' => array_sum(array_column($cartItems, 'quantity')),
            'items' => $items
        ]);
    }

    public function getCartContents()
    {
        $cartItems = $this->getCartItems();
        $totalPrice = 0;

        foreach ($cartItems as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        return response()->json([
            'items' => $cartItems,
            'totalPrice' => $totalPrice
        ]);
    }

    public function update(Request $request)
    {
        $obat = Obat::findOrFail($request->obat_id);

        // Validate quantity against stock
        if ($request->quantity > $obat->banyak) {
            return response()->json([
                'success' => false,
                'message' => "Maksimal pembelian {$obat->banyak} unit"
            ]);
        }

        if (Auth::check()) {
            Cart::where('user_id', Auth::id())
                ->where('obat_id', $request->obat_id)
                ->update(['quantity' => $request->quantity]);

            $cartItems = $this->getCartItems();
        } else {
            $cart = session()->get('cart', []);
            if (isset($cart[$request->obat_id])) {
                $cart[$request->obat_id]['quantity'] = $request->quantity;
                session()->put('cart', $cart);
            }
            $cartItems = $cart;
        }

        $totalPrice = 0;
        foreach ($cartItems as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        return response()->json([
            'success' => true,
            'cartCount' => array_sum(array_column($cartItems, 'quantity')),
            'totalPrice' => $totalPrice,
            'message' => 'Jumlah produk berhasil diperbarui'
        ]);
    }

    public function remove(Request $request)
    {
        if (Auth::check()) {
            Cart::where('user_id', Auth::id())
                ->where('obat_id', $request->obat_id)
                ->delete();

            $cartItems = $this->getCartItems();
        } else {
            $cart = session()->get('cart', []);
            if (isset($cart[$request->obat_id])) {
                unset($cart[$request->obat_id]);
                session()->put('cart', $cart);
            }
            $cartItems = $cart;
        }

        $totalPrice = 0;
        foreach ($cartItems as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        return response()->json([
            'success' => true,
            'cartCount' => array_sum(array_column($cartItems, 'quantity')),
            'totalPrice' => $totalPrice,
            'message' => 'Produk berhasil dihapus dari keranjang'
        ]);
    }

    public function add(Request $request)
    {
        $obat = Obat::findOrFail($request->obat_id);

        // Check if there's enough stock
        if ($obat->banyak <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Stok produk tidak tersedia'
            ]);
        }

        $currentQuantity = 0;

        if (Auth::check()) {
            $cartItem = Cart::firstOrNew([
                'user_id' => Auth::id(),
                'obat_id' => $request->obat_id
            ]);

            $currentQuantity = $cartItem->quantity ?? 0;

            if (($currentQuantity + 1) > $obat->banyak) {
                return response()->json([
                    'success' => false,
                    'message' => "Maksimal pembelian {$obat->banyak} unit"
                ]);
            }

            $cartItem->quantity = $currentQuantity + 1;
            $cartItem->save();

            $cartItems = $this->getCartItems();
        } else {
            $cart = session()->get('cart', []);
            $currentQuantity = isset($cart[$request->obat_id]) ? $cart[$request->obat_id]['quantity'] : 0;

            if (($currentQuantity + 1) > $obat->banyak) {
                return response()->json([
                    'success' => false,
                    'message' => "Maksimal pembelian {$obat->banyak} unit"
                ]);
            }

            if (isset($cart[$request->obat_id])) {
                $cart[$request->obat_id]['quantity']++;
            } else {
                $cart[$request->obat_id] = [
                    'id' => $obat->id,
                    'name' => $obat->nama,
                    'price' => $obat->harga,
                    'quantity' => 1,
                    'image' => $obat->foto
                ];
            }
            session()->put('cart', $cart);
            $cartItems = $cart;
        }

        $totalPrice = 0;
        foreach ($cartItems as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        return response()->json([
            'success' => true,
            'cartCount' => array_sum(array_column($cartItems, 'quantity')),
            'quantity' => $cartItems[$request->obat_id]['quantity'],
            'totalPrice' => $totalPrice,
            'message' => 'Produk berhasil ditambahkan ke keranjang'
        ]);
    }


    public function clearCart()
    {
        if (Auth::check()) {
            Cart::where('user_id', Auth::id())->delete();
        } else {
            session()->forget('cart');
        }

        return response()->json([
            'success' => true,
            'message' => 'Keranjang berhasil dikosongkan',
            'cartCount' => 0,
            'totalPrice' => 0
        ]);
    }

    public function checkout()
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'requireLogin' => true,
                'message' => 'Please login to continue checkout'
            ]);
        }

        // Verify stock availability
        $cartItems = $this->getCartItems();
        foreach ($cartItems as $item) {
            $obat = Obat::find($item['id']);
            if (!$obat || $item['quantity'] > $obat->banyak) {
                return response()->json([
                    'success' => false,
                    'message' => "Insufficient stock for {$obat->nama}"
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'redirect' => route('checkout.index')
        ]);
    }

    public function checkQuantity($obatId)
    {
        $quantity = 0;

        if (Auth::check()) {
            $cartItem = Cart::where('user_id', Auth::id())
                ->where('obat_id', $obatId)
                ->first();
            $quantity = $cartItem ? $cartItem->quantity : 0;
        } else {
            $cart = session()->get('cart', []);
            $quantity = isset($cart[$obatId]) ? $cart[$obatId]['quantity'] : 0;
        }

        return response()->json(['quantity' => $quantity]);
    }
}
