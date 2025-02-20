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
        $cartItems = [];
        $totalAmount = 0;
        $address = auth()->user()?->address ?? null; // Gunakan null-safe operator

        if (auth()->check()) {
            $user = auth()->user();
            $cartItems = $user->cart()->with('obat')->get();
            $totalAmount = $cartItems->sum(fn($item) => $item->obat->harga * $item->quantity);
        }

        return view('pages.checkout.index', compact('cartItems', 'totalAmount', 'address'))
            ->with(['title' => 'Checkout']);
    }

    public function process(Request $request)
    {
        $request->validate([
            'address' => ['required', 'string', function ($attribute, $value, $fail) use ($request) {
                if ($value === 'new' && empty($request->new_address)) {
                    $fail('The address field is required.');
                }
            }],
            'new_address' => 'nullable|string|max:255', // Tambahkan validasi untuk alamat baru
            'payment_method' => 'required|in:cop,cod,transfer',
            'notes' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            $user = auth()->user();
            $cartItems = $user->cart()->with('obat')->get();

            if ($cartItems->isEmpty()) {
                return back()->with('error', 'Keranjang Anda kosong.');
            }

            // Validasi stok obat
            foreach ($cartItems as $item) {
                if ($item->quantity > $item->obat->banyak) {
                    return back()->with('error', "Stok tidak cukup untuk {$item->obat->nama}.");
                }
            }

            // Hitung total harga
            $totalAmount = $cartItems->sum(fn($item) => $item->obat->harga * $item->quantity);

            // Gunakan alamat baru jika user memilih "new", atau gunakan alamat lama
            $address = $request->address === 'new' ? $request->new_address : $request->address;

            // Simpan order
            $order = Order::create([
                'order_number' => 'ORD-' . strtoupper(Str::random(10)),
                'user_id' => $user->id,
                'shipping_address' => $address,
                'total_amount' => $totalAmount,
                'payment_method' => $request->payment_method,
                'status' => 'pending',
                'payment_status' => 'pending',
                'notes' => $request->notes
            ]);

            // Simpan order items & update stok
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'obat_id' => $item->obat_id,
                    'quantity' => $item->quantity,
                    'price' => $item->obat->harga,
                    'subtotal' => $item->obat->harga * $item->quantity
                ]);

                $item->obat->decrement('banyak', $item->quantity);
            }

            // Kosongkan keranjang
            $user->cart()->delete();

            DB::commit();

            return redirect()->route('checkout.success', ['order' => $order->id])
                ->with('success', 'Order berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout failed: ' . $e->getMessage()); // Logging error
            return back()->with('error', 'Gagal memproses order. Silakan coba lagi.');
        }
    }

    public function success(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('pages.checkout.success', compact('order'))
            ->with(['title' => 'Checkout Success']);
    }
}
