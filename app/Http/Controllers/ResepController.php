<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resep;
use App\Models\User;
use App\Models\Obat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;



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

        $reseps = $query->where('tipe', 'dokter')->latest()->paginate(10);
        $dokters = User::where('role_id', 4)->get();
        $pasiens = User::where('role_id', 5)->get();
        $obats = Obat::all();

        // Konversi data obat dari JSON ke array sebelum dikirim ke view
        $reseps->transform(function ($resep) {
            $resep->obats = $resep->obats ? json_decode($resep->obats, true) : [];
            return $resep;
        });

        return view('pages.admin.resep', compact('reseps', 'dokters', 'pasiens', 'obats'))
            ->with(['title' => 'Recipes']);
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
                'kekuatan_obat' => $obatModel->kekuatan_obat,
                'dosis' => $obat['dosis'],
            ];
        });

        Resep::create([
            'dokter_id' => Auth::id(),
            'pasien_id' => $pasien->id,
            'tipe' => 'dokter', // Default dokter karena dibuat secara digital
            'pasien_nama' => $pasien->name, // Simpan nama pasien
            'obats' => json_encode($obatDetails),
        ]);

        return back()->with('success', 'Resep berhasil ditambahkan!');
    }


    public function edit($id)
    {
        $resep = Resep::find($id);

        if (!$resep) {
            return redirect()->route('admin.resep.index')->with('error', 'Resep tidak ditemukan.');
        }

        // Jika relasi obat ada, ambil data obat terkait
        $obats = $resep->obats()->get();

        return response()->json([
            'id' => $resep->id,
            'pasien_id' => $resep->pasien_id,
            'obats' => $obats
        ]);

        return view('admin.resep.edit', compact('resep'));
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
                'kekuatan_obat' => $obatModel->kekuatan_obat,
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

    public function showUploadForm()
    {
        // Return the view that contains your form
        return view('pages.upload-resep')->with(['title' => 'Upload Recipe']);
    }

    // Modify your existing upload method to properly redirect
    public function upload(Request $request)
    {
        $request->validate([
            'foto_resep.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'final_photos' => 'nullable|string',
        ]);

        $pasienNama = $request->has('pasien_nama') && !empty($request->pasien_nama)
            ? $request->pasien_nama
            : Auth::user()->name;

        $pasienId = $request->has('pasien_nama') && !empty($request->pasien_nama)
            ? null
            : Auth::user()->id;
        $filePaths = [];

        // Simpan file yang diunggah langsung
        if ($request->hasFile('foto_resep')) {
            foreach ($request->file('foto_resep') as $file) {
                $originalName = $file->getClientOriginalName();
                $path = storage_path('app/public/resep/');

                // Cek apakah file dengan konten yang sama sudah ada
                $existingFile = glob($path . "*"); // Ambil semua file dalam folder
                $isDuplicate = false;

                foreach ($existingFile as $existing) {
                    if (md5_file($existing) === md5_file($file)) {
                        $isDuplicate = true;
                        break;
                    }
                }

                if (!$isDuplicate) {
                    $fileName = time() . '_' . $originalName;
                    $file->move($path, $fileName);
                    $filePaths[] = 'resep/' . $fileName;
                }
            }
        }

        // Proses foto dari kamera
        if ($request->filled('final_photos')) {
            try {
                $photos = json_decode($request->final_photos, true);

                if (is_array($photos)) {
                    foreach ($photos as $photo) {
                        if (preg_match('/^data:image\/(\w+);base64,/', $photo, $type)) {
                            $data = substr($photo, strpos($photo, ',') + 1);
                            $type = strtolower($type[1]); // jpg, png, gif

                            if (in_array($type, ['jpg', 'jpeg', 'png', 'gif'])) {
                                $decodedImage = base64_decode($data);

                                if ($decodedImage !== false) {
                                    $imageName = 'resep/' . uniqid() . '.' . $type;
                                    if (Storage::disk('public')->put($imageName, $decodedImage)) {
                                        $filePaths[] = $imageName;
                                    }
                                }
                            }
                        }
                    }
                }
            } catch (\Exception $e) {
                Log::error('Error processing photos:', ['error' => $e->getMessage()]);
                return redirect()->route('resep.form')->with('error', 'Gagal memproses foto: ' . $e->getMessage());
            }
        }

        // Simpan ke database jika ada file
        if (!empty($filePaths)) {
            try {
                $resep = Resep::create([
                    'pasien_id' => $pasienId,
                    'pasien_nama' => $pasienNama,
                    'tipe' => 'pasien',
                    'dokter_id' => null,
                    'foto_resep' => $filePaths,
                    'status' => 'Menunggu Verifikasi',
                    'catatan' => $request->catatan ?? null
                ]);

                Log::info('Resep saved:', [
                    'resep_id' => $resep->id,
                    'file_paths' => $filePaths
                ]);

                // Redirect to the form page with success message
                return redirect()->route('resep.form')->with('success', 'Resep berhasil diunggah! Menunggu verifikasi apoteker.');
            } catch (\Exception $e) {
                Log::error('Database error:', ['error' => $e->getMessage()]);
                return redirect()->route('resep.form')->with('error', 'Gagal menyimpan ke database: ' . $e->getMessage());
            }
        }

        return redirect()->route('resep.form')->with('error', 'Tidak ada file yang berhasil diunggah. Pastikan file atau foto dari kamera sudah valid.');
    }
}
