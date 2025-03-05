<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Models\Obat;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->input('bulan', Carbon::now()->month);
        $tahun = $request->input('tahun', Carbon::now()->year);

        // Ambil data transaksi berdasarkan bulan & tahun
        $penjualan = OrderItem::whereHas('order', function ($query) use ($bulan, $tahun) {
            $query->whereYear('created_at', $tahun)->whereMonth('created_at', $bulan);
        })->get();

        // Total pendapatan per minggu
        $weeklySales = OrderItem::selectRaw("strftime('%W', created_at) as minggu, SUM(subtotal) as total")
            ->whereHas('order', function ($query) use ($bulan, $tahun) {
                $query->whereYear('created_at', $tahun)->whereMonth('created_at', $bulan);
            })
            ->groupBy('minggu')
            ->get();

        // Distribusi penjualan berdasarkan kategori
        $salesByCategory = Obat::selectRaw('kategori_id, COUNT(*) as total')
            ->whereHas('orderItems.order', function ($query) use ($bulan, $tahun) {
                $query->whereYear('created_at', $tahun)->whereMonth('created_at', $bulan);
            })
            ->groupBy('kategori_id')
            ->with('kategori')
            ->get();

        // Stok hampir habis
        $stokHampirHabis = Obat::where('banyak', '<=', 10)->count();

        // Pendapatan bulanan
        $monthlySales = OrderItem::selectRaw("strftime('%m', created_at) as bulan, SUM(subtotal) as total")
            ->whereHas('order', function ($query) use ($tahun) {
                $query->whereYear('created_at', $tahun);
            })
            ->groupBy('bulan')
            ->get();

        // Performa penjualan harian
        $dailySales = OrderItem::selectRaw("strftime('%w', created_at) as hari, COUNT(*) as transaksi")
            ->whereHas('order', function ($query) use ($bulan, $tahun) {
                $query->whereYear('created_at', $tahun)->whereMonth('created_at', $bulan);
            })
            ->groupBy('hari')
            ->get();

        $bulanLalu = Carbon::now()->subMonth()->month;
        $tahunLalu = Carbon::now()->year;

        // Ambil data penjualan bulan lalu
        $penjualanBulanLalu = OrderItem::whereHas('order', function ($query) use ($bulanLalu, $tahunLalu) {
            $query->whereYear('created_at', $tahunLalu)->whereMonth('created_at', $bulanLalu);
        })->get();

        // Ambil data stok bulan lalu
        $obatBulanLalu = Obat::all();

        return view('pages.admin.laporan', compact(
            'penjualan',
            'weeklySales',
            'salesByCategory',
            'stokHampirHabis',
            'monthlySales',
            'dailySales',
            'bulan',
            'tahun',
            'bulanLalu',
            'tahunLalu',
            'penjualanBulanLalu',
            'obatBulanLalu'
        ))->with(['title' => 'Reports']);
    }
}
