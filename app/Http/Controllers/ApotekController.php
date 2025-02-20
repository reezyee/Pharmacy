<?php

namespace App\Http\Controllers;

use App\Models\Apotek;

class ApotekController extends Controller
{
    public function page()
    {
        
        $apotek = Apotek::all();

        return view('profile', compact('apotek'), ['title' => 'Profil']);
    }
}
