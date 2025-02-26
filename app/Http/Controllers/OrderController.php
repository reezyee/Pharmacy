<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'status' => 'nullable|in:pending,processing,completed,cancelled',
            'date'   => 'nullable|date',
            'search' => 'nullable|string|max:255',
        ]);

        $user = auth()->user(); // Ambil user yang sedang login

        // Jika user adalah pelanggan, hanya ambil pesanan miliknya
        if ($user->role->name === 'Pelanggan') {
            $query = Order::where('user_id', $user->id)->with('user')->orderBy('created_at', 'desc');
        } else {
            // Jika Admin atau Kasir, ambil semua pesanan
            $query = Order::with('user')->orderBy('created_at', 'desc');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $orders = $query->paginate(10);

        // Sesuaikan view berdasarkan role
        if ($user->role->name === 'Pelanggan') {
            return view('pages.user.pesanan', compact('orders'))->with(['title' => 'Pesanan Saya']);
        } else {
            return view('pages.admin.pesanan', compact('orders'))->with(['title' => 'Order Non-Resep']);
        }
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        try {
            DB::beginTransaction();

            $oldStatus = $order->status;
            $newStatus = $request->status;

            // If order is being cancelled, restore stock
            if ($newStatus === 'cancelled' && $oldStatus !== 'cancelled') {
                foreach ($order->items as $item) {
                    DB::table('obats')
                        ->where('id', $item->obat_id)
                        ->increment('banyak', $item->quantity);
                }
            }

            // Update order status
            $order->update(['status' => $newStatus]);

            // If order is completed, update payment status
            if ($newStatus === 'completed') {
                $order->update(['payment_status' => 'paid']);
            }

            DB::commit();

            return back()->with('success', 'Order status has been updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update order status: ' . $e->getMessage());
            return back()->with('error', 'Failed to update order status. Please try again.');
        }
    }
    public function cancelOrder(Order $order)
    {
        if (auth()->id() !== $order->user_id) {
            return back()->with('error', 'Anda tidak memiliki izin untuk membatalkan pesanan ini.');
        }

        if ($order->status !== 'pending') {
            return back()->with('error', 'Pesanan hanya bisa dibatalkan jika masih pending.');
        }

        try {
            DB::beginTransaction();

            // Kembalikan stok jika pesanan dibatalkan
            foreach ($order->items as $item) {
                $item->obat->increment('banyak', $item->quantity);
            }

            // Update status pesanan menjadi 'cancelled'
            $order->update(['status' => 'cancelled']);

            DB::commit();

            return back()->with('success', 'Pesanan berhasil dibatalkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Gagal membatalkan pesanan: " . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan, coba lagi nanti.');
        }
    }
}
