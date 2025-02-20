<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resep;
use App\Models\User;
use App\Models\Obat;
use Illuminate\Support\Facades\Auth;

class ResepController extends Controller
{
    public function index(Request $request)
    {
        $query = Resep::with(['dokter', 'pasien']);

        // Filter dan search
        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('pasien', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhereHas('dokter', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $reseps = $query->latest()->paginate(10);
        $dokters = User::where('role_id', 4)->get();
        $pasiens = User::where('role_id', 5)->get();
        $obats = Obat::all();

        // Pastikan variabel tersedia agar tidak undefined
        $resepObats = [];

        return view('pages.admin.resep', compact('reseps', 'dokters', 'pasiens', 'obats', 'resepObats'))
            ->with(['title' => 'Resep Obat']);
    }



    public function store(Request $request)
    {
        $request->validate([
            'pasien' => 'required|exists:users,id',
            'obats' => 'required|array',
            'obats.*.id' => 'required|exists:obats,id',
            'obats.*.dosis' => 'required',
        ]);

        $pasien = User::find($request->pasien); // Ambil nama pasien

        $obatDetails = collect($request->obats)->map(function ($obat) {
            $obatModel = Obat::find($obat['id']);
            return [
                'id' => $obatModel->id,
                'nama' => $obatModel->nama,
                'dosis' => $obat['dosis'],
            ];
        });

        Resep::create([
            'dokter_id' => Auth::id(),
            'pasien_id' => $pasien->id,
            'pasien_nama' => $pasien->name, // Simpan nama pasien
            'obats' => json_encode($obatDetails),
        ]);

        return back()->with('success', 'Resep berhasil ditambahkan!');
    }


    public function edit($id)
    {
        $resep = Resep::find($id);

        if (!$resep) {
            return response()->json(['error' => 'Resep tidak ditemukan'], 404);
        }

        // Jika relasi obat ada, ambil data obat terkait
        $obats = $resep->obats()->get();

        return response()->json([
            'id' => $resep->id,
            'pasien_id' => $resep->pasien_id,
            'obats' => $obats
        ]);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'pasien' => 'required|exists:users,id',
            'obats' => 'required|array',
            'obats.*.id' => 'required|exists:obats,id',
            'obats.*.dosis' => 'required',
        ]);

        $resep = Resep::findOrFail($id);
        $pasien = User::find($request->pasien);

        $obatDetails = collect($request->obats)->map(function ($obat) {
            $obatModel = Obat::find($obat['id']);
            return [
                'id' => $obatModel->id,
                'nama' => $obatModel->nama,
                'dosis' => $obat['dosis'],
            ];
        });

        $resep->update([
            'pasien_id' => $pasien->id,
            'pasien_nama' => $pasien->name,
            'obats' => json_encode($obatDetails),
        ]);

        return back()->with('success', 'Resep berhasil diperbarui!');
    }




    public function destroy($id)
    {
        $resep = Resep::findOrFail($id);
        $resep->delete();

        return back()->with('success', 'Resep berhasil dihapus!');
    }
}
