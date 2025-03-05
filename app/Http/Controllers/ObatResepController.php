<?php
// ObatResepController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resep;
use App\Models\User;
use App\Models\Obat;
use App\Models\ObatResep;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;



class ObatResepController extends Controller
{
    public function index()
    {

        $user = Auth::user();

        // Ambil hanya resep milik pelanggan yang sedang login
        $resepsQuery = Resep::with(['dokter', 'pasien'])
            ->where('pasien_id', $user->id)
            ->latest();

        // Ambil data resep berdasarkan status
        $resepsMenunggu = (clone $resepsQuery)->where('status', 'Menunggu Verifikasi')->get();
        $resepsTerverifikasi = (clone $resepsQuery)->where('status', 'Terverifikasi')->get();
        $resepsDitolak = (clone $resepsQuery)->where('status', 'Ditolak')->get();
        $resepsSelesai = (clone $resepsQuery)->where('status', 'Ditebus')->get();

        // Hitung jumlah resep
        $totalResep = $resepsQuery->count();
        $menunggu = $resepsMenunggu->count();
        $terverifikasi = $resepsTerverifikasi->count();
        $ditolak = $resepsDitolak->count();
        $selesai = $resepsSelesai->count();

        // Ubah data menjadi format JSON yang sesuai
        $ubahJson = function ($reseps) {
            return $reseps->map(function ($resep) {
                $resep->obats = collect($resep->obats)->filter()->all();
                return $resep;
            });
        };

        $resepsMenunggu = $ubahJson(collect($resepsMenunggu));
        $resepsTerverifikasi = $ubahJson(collect($resepsTerverifikasi));
        $resepsDitolak = $ubahJson(collect($resepsDitolak));
        $resepsSelesai = $ubahJson(collect($resepsSelesai));

        $obats = Obat::all();


        return view('pages.admin.obat-resep', compact(
            'resepsMenunggu',
            'resepsTerverifikasi',
            'resepsDitolak',
            'resepsSelesai',
            'totalResep',
            'menunggu',
            'terverifikasi',
            'ditolak',
            'obats',
            'selesai'
        ))->with(['title' => 'Verification']);
    }

    public function verify(Request $request, $id)
    {
        // **Tambahkan log untuk melihat data yang diterima**
        Log::info('Data diterima:', $request->all());

        $request->validate([
            'obat' => 'required|array',
            'obat.*' => 'exists:obats,id',
            'dosis' => 'required|array',
            'dosis.*' => 'string',
        ]);

        $resep = Resep::findOrFail($id);

        // Simpan data obat langsung ke kolom 'obats' dalam format JSON
        $dataObat = [];
        foreach ($request->obat as $index => $obatId) {
            $obat = Obat::find($obatId);
            if ($obat) {
                $dataObat[] = [
                    'id' => $obat->id,
                    'nama' => $obat->nama,
                    'dosis' => $request->dosis[$index],
                ];
            }
        }

        $resep->update([
            'status' => 'Terverifikasi',
            'catatan' => $request->input('catatan'),
        ]);

        foreach ($request->obat as $index => $obatId) {
            ObatResep::updateOrCreate(
                [
                    'resep_id' => $resep->id,
                    'obat_id' => $obatId,
                ],
                [
                    'dosis' => $request->dosis[$index],
                ]
            );
        }

        return response()->json(['success' => true, 'message' => 'Resep berhasil diverifikasi']);
    }

    public function reject(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $resep = Resep::findOrFail($id);

            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda harus login untuk melakukan aksi ini.'
                ], 401);
            }

            if (Auth::user()->role_id !== 2) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki izin untuk menolak resep.'
                ], 403);
            }

            // Check if prescription is already processed
            if ($resep->status !== 'Menunggu Verifikasi') {
                return response()->json([
                    'success' => false,
                    'message' => 'Resep ini sudah diproses sebelumnya.'
                ], 422);
            }

            $resep->status = 'Ditolak';
            // Fix: Remove extra $ from $resep variable
            $resep->catatan = $request->catatan ?? 'Tidak ada catatan.';

            $resep->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Resep berhasil ditolak!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Rejection Error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menolak resep.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function fetch(Request $request)
    {
        $status = $request->query('status', 'Menunggu Verifikasi');

        $reseps = Resep::where('status', $status)
            ->with(['dokter', 'pasien'])
            ->latest()
            ->paginate(12);

        $reseps->getCollection()->transform(function ($resep) {
            try {
                if (is_string($resep->obats)) {
                    $resep->obats = json_decode($resep->obats, true) ?? [];
                }

                if (is_array($resep->obats)) {
                    $resep->obats = collect($resep->obats) // Langsung pakai array dari model
                        ->filter()
                        ->values()
                        ->all();
                }
            } catch (\Exception $e) {
                Log::error('Error decoding obats: ' . $e->getMessage());
                $resep->obats = [];
            }

            return $resep;
        });

        return response()->json($reseps);
    }
}
