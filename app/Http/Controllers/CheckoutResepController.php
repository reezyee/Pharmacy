<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ObatResep;
use App\Models\Resep;
use App\Models\Obat;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class CheckoutResepController extends Controller
{
    public function index($resepId)
    {
        $user = auth()->user();
        $resep = Resep::with('obatReseps.obat')->where('id', $resepId)
            ->where('status', 'Terverifikasi')
            ->firstOrFail();

        $totalAmount = $resep->obatReseps->sum(fn($item) => optional($item->obat)->harga * (int) preg_replace('/\D/', '', $item->dosis));

        // Ambil alamat pengguna jika tersedia
        $address = $user->address ?? null;

        return view('pages.checkout.resep', compact('resep', 'totalAmount', 'address'))->with(['title' => 'Checkout Resep']);
    }


    public function process(Request $request)
    {

        $request->validate([
            'resep_id' => 'required|exists:reseps,id',
            'payment_method' => 'required|in:cop,cod,transfer',
            'address' => 'nullable|string|required_if:payment_method,cod,transfer',
            'new_address' => 'sometimes|nullable|string|min:10',
        ]);

        DB::beginTransaction();
        try {
            $user = auth()->user();
            $resep = Resep::where('id', $request->resep_id)
                ->where('status', 'Terverifikasi')
                ->firstOrFail();

            $totalAmount = $resep->obatReseps->sum(fn($item) => optional($item->obat)->harga * (int) preg_replace('/\D/', '', $item->dosis));

            $gratisOngkirMin = 100000; // Minimal belanja untuk gratis ongkir
            $shippingCost = ($totalAmount >= $gratisOngkirMin) ? 0 : 10000;
            $handlingFee = ($request->payment_method === 'cod') ? 1000 : 0;

            // Hitung total akhir
            $grandTotal = $totalAmount + $shippingCost + $handlingFee;

            // Pastikan semua obat memiliki stok cukup sebelum checkout
            foreach ($resep->obatReseps as $item) {
                $jumlahDosis = (int) preg_replace('/\D/', '', $item->dosis);
                if ($item->obat && $item->obat->banyak < $jumlahDosis) {
                    throw new \Exception("Stok untuk {$item->obat->nama} tidak mencukupi.");
                }
            }

            // Simpan order
            $order = Order::create([
                'user_id' => $user->id,
                'resep_id' => $request->resep_id,
                'total_amount' => $grandTotal,
                'payment_method' => $request->payment_method,
                'status' => 'pending',
                'order_type' => 'resep',
                'shipping_address' => $request->address === 'new' ? $request->new_address : $request->address,
            ]);

            // Simpan order items dan update stok obat
            foreach ($resep->obatReseps as $item) {
                $jumlahDosis = (int) preg_replace('/\D/', '', $item->dosis);

                if ($item->obat) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'obat_id' => $item->obat->id,
                        'price' => $item->obat->harga,
                        'quantity' => $jumlahDosis,
                        'subtotal' => $item->obat->harga * $jumlahDosis,
                    ]);

                    // Kurangi stok obat
                    $item->obat->decrement('banyak', $jumlahDosis);
                }
            }

            // Tandai resep sebagai "Ditebus"
            $resep->update(['status' => 'Ditebus']);

            DB::commit();

            return response()->json([
                'success' => true,
                'redirect' => route('checkout.resep.success', ['order' => $order->id])
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                ], 500);
            }

            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function checkoutPage($id)
    {
        $user = auth()->user();
        $resep = Resep::with('obatReseps.obat')->findOrFail($id);

        if ($resep->status !== 'Terverifikasi') {
            return redirect()->back()->with('error', 'Resep belum diverifikasi.');
        }

        $title = 'Checkout Resep';
        $address = $user->address ?? null;

        return view('pages.checkout.resep', compact('resep', 'title', 'address'));
    }

    public function success(Order $order)
    {
        $order->load('resep.obatReseps.obat'); // Pakai nama relasi sesuai model

        if (!$order->resep) {
            return redirect()->route('home')->with('error', 'Resep tidak ditemukan.');
        }

        return view('pages.checkout.success_resep', compact('order'))->with(['title' => 'Checkout Success']);
    }
}
