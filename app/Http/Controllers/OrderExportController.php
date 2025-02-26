<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class OrderExportController extends Controller
{
    public function exportPDF(Order $order)
    {
        $pdf = Pdf::loadView('pages.exports.order', compact('order'))
            ->setPaper('a5', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isPhpEnabled' => false,
                'isRemoteEnabled' => true, // Aktifkan agar bisa menangani gambar dari URL
                'dpi' => 96,
                'defaultFont' => 'sans-serif' // Menggunakan font yang lebih optimal
            ]);

        return $pdf->stream("Order_{$order->order_number}.pdf"); // Tampilkan di browser sebelum download
    }
}
