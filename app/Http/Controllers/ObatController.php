<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ObatRequest;
use App\Models\BentukObat;
use Illuminate\Support\Facades\Storage;
use App\Models\JenisObat;
use Illuminate\Support\Facades\Log;
use App\Notifications\KetersediaanObatNotification;
use Illuminate\Support\Facades\Notification;

class ObatController extends Controller
{
    public function index()
    {
        $obats = Obat::latest()->paginate(10);
        $kategoris = Kategori::all();
        $jenis_obat = JenisObat::all();
        $bentuk_obat = BentukObat::all();
        return view('pages.admin.obat', compact('obats', 'kategoris', 'jenis_obat', 'bentuk_obat'))->with('title', 'Manage Obat');
    }

    public function create()
    {
        $kategoris = Kategori::all();
        $jenis_obat = JenisObat::all();
        $bentuk_obat = BentukObat::all();
        return view('obat.create', compact('kategoris', 'jenis_obat', 'bentuk_obat'));
    }



    public function store(Request $request)
    {
        // dd($request);
        // Validasi input
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nie' => 'required|string|max:255',
            'kategori_id' => 'nullable|exists:kategoris,id',
            'jenis_obat_id' => 'nullable|exists:jenis_obat,id',
            'bentuk_obat_id' => 'nullable|exists:bentuk_obat,id',
            'deskripsi_obat' => 'required|string',
            'dosis_obat' => 'nullable|string',
            'kekuatan_obat' => 'nullable|string',
            'komposisi_obat' => 'nullable|string',
            'banyak' => 'required|integer',
            'harga' => 'required|numeric',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'tanggal_kedaluwarsa' => 'required|date',
            'is_available' => 'required|boolean',
        ]);

        // Cek jika ada file yang diupload
        if ($request->hasFile('foto')) {
            // Simpan file ke storage/app/public/obat
            $fotoPath = $request->file('foto')->store('obat', 'public');

            // Ubah path agar bisa diakses melalui "storage/..."
            $validated['foto'] = str_replace('public/', '', $fotoPath);
        } else {
            $validated['foto'] = null;
        }
        // Simpan data obat ke database
        Obat::create($validated);

        return redirect()->route('obat.index')->with('success', 'Obat berhasil ditambahkan!');
    }

    public function edit(Obat $obat)
    {
        $kategoris = Kategori::all();
        $jenis_obat = JenisObat::all();
        $bentuk_obat = BentukObat::all();
        return view('pages.admin.obat', compact('kategoris', 'jenis_obat', 'bentuk_obat', 'obat'));
    }

    public function update(Request $request, Obat $obat)
    {
        $request->validate([
            'nama' => 'required|string',
            'nie' => 'required|string|max:255',
            'kategori_id' => 'nullable|exists:kategoris,id',
            'jenis_obat_id' => 'nullable|exists:jenis_obat,id',
            'bentuk_obat_id' => 'nullable|exists:bentuk_obat,id',
            'deskripsi_obat' => 'required',
            'dosis_obat' => 'required',
            'kekuatan_obat' => 'required',
            'komposisi_obat' => 'required',
            'banyak' => 'required|integer',
            'harga' => 'required|integer',
            'foto' => 'nullable|image|max:2048',
            'tanggal_kedaluwarsa' => 'required|date',
            'is_available' => 'boolean',
        ]);

        if ($request->hasFile('foto')) {
            if ($obat->foto && Storage::exists($obat->foto)) {
                Storage::delete($obat->foto);
            }
            $fotoPath = $request->file('foto')->store('obat', 'public');
            $obat->foto = str_replace('images/', '', $fotoPath);
        }
        $obat->update($request->except('foto'));
        return redirect()->route('obat.index')->with('success', 'Obat berhasil diperbarui.');
    }

    public function destroy(Obat $obat)
    {
        $obat->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('obat.index')->with('success', 'Obat berhasil dihapus.');
    }


    public function updateStock(Request $request, $id)
    {
        $obat = Obat::findOrFail($id);
        $obat->banyak = $request->banyak;
        $obat->save();

        if ($obat->banyak > 0) {
            Notification::send(auth()->user(), new KetersediaanObatNotification($obat));
        }

        return back()->with('success', 'Stok berhasil diperbarui!');
    }
}
