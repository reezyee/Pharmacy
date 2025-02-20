<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\BentukObat;
use App\Models\ChildKategori;
use App\Models\SubchildKategori;
use Illuminate\Http\Request;

class KategorisController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::take(7)->get(); // Fetch categories with their relationships
        $bentukObat = BentukObat::all(); // Fetch all BentukObat records
    
        // Pass $range, $bentukObat, and $kategoris to the view
        return view('pages.index', compact('bentukObat', 'kategoris'))->with(['title' => 'Home']);
    }

    public function create()
    {
        return view('kategoris.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        Kategori::create($validated);

        return redirect()->route('kategoris.index')->with('success', 'Kategori created successfully.');
    }

    public function createChild($parentId)
    {
        $parentKategori = Kategori::findOrFail($parentId);
        return view('child_kategoris.create', compact('parentKategori'));
    }

    public function storeChild(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'parent_kategori_id' => 'required|exists:kategoris,id',
        ]);

        ChildKategori::create($validated);

        return redirect()->route('kategoris.index')->with('success', 'Child Kategori created successfully.');
    }

    public function createSubchild($childId)
    {
        $parentChildKategori = ChildKategori::findOrFail($childId);
        return view('subchild_kategoris.create', compact('parentChildKategori'));
    }

    public function storeSubchild(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'parent_child_kategori_id' => 'required|exists:child_kategoris,id',
        ]);

        SubchildKategori::create($validated);

        return redirect()->route('kategoris.index')->with('success', 'Subchild Kategori created successfully.');
    }
}
