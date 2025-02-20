<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function index()
    {
        // Ambil data dari database
        $data = [
            ['Kategori', 'Jumlah'],
            ['Obat Terjual', 120],
            ['Total Income', 5000000],
            ['Total Pengunjung', 800],
            ['Stok Barang', 300]
        ];

        return view('chart', compact('data'));
    }
}
