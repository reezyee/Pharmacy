<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Obat;
use App\Models\Pharmacy;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page with categories and featured products.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        // Get all categories
        $kategoris = Kategori::take(6)->get();

        $pharmacies = Pharmacy::get();

        // Get medicines grouped by category for carousels
        $obatsByKategori = [];
        
        foreach ($kategoris as $kategori) {
            // Get up to 4 medicines for each category
            $obats = Obat::where('kategori_id', $kategori->id)
                        ->where('is_available', true)
                        ->take(4)
                        ->get();
            
            if ($obats->count() > 0) {
                $obatsByKategori[$kategori->id] = $obats;
            }
        }
        
        return view('pages.index', [
            'title' => 'Apotek Amanah',
            'kategoris' => $kategoris,
            'obatsByKategori' => $obatsByKategori,
            'pharmacies' => $pharmacies,
        ]);
    }
}