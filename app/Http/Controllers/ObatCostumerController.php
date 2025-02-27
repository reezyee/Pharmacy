<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Obat;
use Illuminate\Http\Request;

class ObatCostumerController extends Controller
{
    public function index(Request $request)
    {
        $query = Obat::with(['kategori', 'jenisObat', 'bentukObat']);

        // Filter berdasarkan kategori
        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        // Filter berdasarkan search term
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                    ->orWhere('deskripsi_obat', 'like', '%' . $request->search . '%');
            });
        }

        // Filter berdasarkan ketersediaan
        if ($request->filled('availability')) {
            $query->where('is_available', $request->availability);
        }

        // Filter berdasarkan range harga
        if ($request->filled('harga_min')) {
            $query->where('harga', '>=', $request->harga_min);
        }
        if ($request->filled('harga_max') && $request->harga_max > 0) {
            $query->where('harga', '<=', $request->harga_max);
        }

        // Ambil data obat dengan paginasi
        $obats = $query->latest()->paginate(10);

        // Jika permintaan AJAX
        if ($request->ajax()) {
            return response()->json([
                'html' => view('pages.partials.list', compact('obats'))->render(),
                'pagination' => $obats->links()->toHtml(),
                'total' => $obats->total(),
                'debug' => [
                    'count' => $obats->count(),
                    'filters' => $request->all()
                ]
            ]);
        }

        $kategoris = Kategori::all();
        return view('pages.shop', compact('obats', 'kategoris'))
            ->with('title', 'Belanja Obat');
    }

        public function show($id)
    {
        $obat = Obat::findOrFail($id);
        
        return view('pages.detail', compact('obat'))->with(['title' => 'Detail Obat']);
    }
}
