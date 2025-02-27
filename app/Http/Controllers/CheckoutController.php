<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function index()
    {
        // Pastikan user sudah login
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to continue checkout.');
        }

        $cartItems = [];
        $totalAmount = 0;
        $address = auth()->user()->address;

        $user = auth()->user();
        $cartItems = $user->cart()->with('obat')->get();
        $totalAmount = $cartItems->sum(fn($item) => $item->obat->harga * $item->quantity);

        if ($cartItems->isEmpty()) {
            return redirect()->route('obat.pelanggan')->with('error', 'Your cart is empty.');
        }

        return view('pages.checkout.index', compact('cartItems', 'totalAmount', 'address'))
            ->with(['title' => 'Checkout']);
    }

    public function process(Request $request)
    {
        // Validasi request
        $request->validate([
            'address' => ['required', 'string', function ($attribute, $value, $fail) use ($request) {
                if ($value === 'new' && empty($request->new_address)) {
                    $fail('New address is required when selecting new address option.');
                }
            }],
            'new_address' => 'nullable|string|max:255',
            'payment_method' => 'required|in:cop,cod,transfer',
            'notes' => 'nullable|string|max:1000'
        ]);

        try {
            DB::beginTransaction();

            $user = auth()->user();
            if (!$user) {
                throw new \Exception('User not authenticated');
            }

            $cartItems = $user->cart()->with('obat')->get();

            if ($cartItems->isEmpty()) {
                throw new \Exception('Cart is empty');
            }

            // Validasi stok
            foreach ($cartItems as $item) {
                $obat = DB::table('obats')
                    ->where('id', $item->obat_id)
                    ->lockForUpdate()
                    ->first();

                if (!$obat || $item->quantity > $obat->banyak) {
                    throw new \Exception("Insufficient stock for product: {$item->obat->nama}");
                }
            }

            // Hitung total
            $totalAmount = $cartItems->sum(fn($item) => $item->obat->harga * $item->quantity);
            $shippingCost = ($request->payment_method === 'cop') ? 0 : 10000;
            $handlingFee = ($request->payment_method === 'cod') ? 1000 : 0;

            // Tentukan alamat
            $shippingAddress = $request->address === 'new' ? $request->new_address : $request->address;

            // Buat order
            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => 'ORD-' . strtoupper(Str::random(10)),
                'total_amount' => $totalAmount + $shippingCost + $handlingFee,
                'shipping_cost' => $shippingCost,
                'handling_fee' => $handlingFee,
                'status' => 'pending',
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
                'shipping_address' => $shippingAddress,
                'notes' => $request->notes,
                'cart_token' => Str::random(32)
            ]);

            // Buat order items dan update stok
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'obat_id' => $item->obat_id,
                    'quantity' => $item->quantity,
                    'price' => $item->obat->harga,
                    'subtotal' => $item->obat->harga * $item->quantity
                ]);

                // Update stok
                DB::table('obats')
                    ->where('id', $item->obat_id)
                    ->decrement('banyak', $item->quantity);
            }

            // Hapus cart
            $user->cart()->delete();
            
            DB::commit();

            // Return response based on request type
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Order created successfully',
                    'redirect' => route('checkout.success', ['order' => $order->id])
                ]);
            }

            return redirect()->route('checkout.success', ['order' => $order->id])
                ->with('success', 'Order created successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout failed: ' . $e->getMessage());

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to process order. Please try again.'
                ], 422);
            }

            return back()
                ->withInput()
                ->with('error', 'Failed to process order. Please try again.');
        }
    }

    public function success(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        return view('pages.checkout.success', compact('order'))
            ->with(['title' => 'Checkout Success']);
    }
}