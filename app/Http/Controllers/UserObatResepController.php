<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resep;
use Illuminate\Support\Facades\Auth;
use App\Models\Obat;

class UserObatResepController extends Controller
{
    public function index()
    {
        // Get all recipes for the authenticated user
        $reseps = Resep::where('pasien_id', Auth::id())
            ->with(['dokter', 'pasien', 'obatReseps.obat']) // Tambahkan relasi obat_reseps
            ->latest()
            ->get();

        // Get available medicines
        $obats = Obat::all();

        // Get prescriptions from doctors
        $resepsDariDokter = Resep::whereNotNull('dokter_id')
            ->where('pasien_id', Auth::id())
            ->with(['dokter', 'pasien'])
            ->latest()
            ->get();

        // Filter prescriptions by status
        $resepsMenunggu = $reseps->where('status', 'Menunggu Verifikasi');
        $resepsTerverifikasi = $reseps->where('status', 'Terverifikasi');
        $resepsDitolak = $reseps->where('status', 'Ditolak');
        $resepDitebus = $reseps->where('status', 'Ditebus');

        // Calculate statistics
        $totalResep = $reseps->count();
        $menunggu = $resepsMenunggu->count();
        $terverifikasi = $resepsTerverifikasi->count();
        $ditolak = $resepsDitolak->count();
        $ditebus = $resepDitebus->count();

        return view('pages.user.resep.index', compact(
            'resepsMenunggu',
            'resepsTerverifikasi',
            'resepsDitolak',
            'resepsDariDokter',
            'resepDitebus',
            'totalResep',
            'menunggu',
            'terverifikasi',
            'ditolak',
            'ditebus',
            'obats'
        ))->with(['title' => 'Recipes']);
    }

    public function fetch(Request $request)
    {
        $status = $request->query('status');

        $query = Resep::where('pasien_id', Auth::id())
            ->with([
                'dokter:id,name',
                'pasien:id,name',
                'obatReseps.obat:id,nama'
            ])
            ->select(['id', 'pasien_id', 'dokter_id', 'status', 'foto_resep', 'obats', 'created_at'])
            ->latest();

        if ($status === 'dokter') {
            // Pastikan resep dokter tetap muncul
            $query->whereNotNull('dokter_id');
        } elseif ($status === 'pending') {
            // Sesuaikan dengan kondisi yang lebih fleksibel
            $query->where(function ($q) {
                $q->whereNull('status')
                    ->orWhere('status', '')
                    ->orWhere('status', 'pending')
                    ->orWhere('status', 'Menunggu Verifikasi');
            });
        } elseif ($status !== null) {
            $query->where('status', $status);
        }

        $reseps = $query->paginate(12);

        return response()->json([
            'data' => $reseps->map(function ($resep) {
                return [
                    'id' => $resep->id,
                    'pasien_nama' => optional($resep->pasien)->name ?? '-',
                    'dokter' => optional($resep->dokter)->name ?? 'Resep Upload',
                    'sumber' => $resep->dokter_id ? 'dokter' : 'upload',
                    'status' => $resep->status,
                    'foto_resep' => is_array($resep->foto_resep) ? $resep->foto_resep : json_decode($resep->foto_resep, true) ?? [],
                    'created_at' => $resep->created_at->format('Y-m-d H:i:s'),
                    'obats' => $resep->dokter_id
                        ? collect(json_decode($resep->obats, true) ?? [])->map(function ($obat) {
                            return [
                                'id' => $obat['id'] ?? null,
                                'nama' => $obat['nama'] ?? 'Obat Tidak Ditemukan',
                                'dosis' => $obat['dosis'] ?? '-',
                            ];
                        })
                        : $resep->obatReseps->map(function ($obatResep) {
                            return [
                                'id' => optional($obatResep->obat)->id,
                                'nama' => optional($obatResep->obat)->nama ?? 'Obat Tidak Ditemukan',
                                'dosis' => $obatResep->dosis ?? '-',
                            ];
                        }),
                ];
            }),
            'links' => [
                'first' => $reseps->url(1),
                'last' => $reseps->url($reseps->lastPage()),
                'prev' => $reseps->previousPageUrl(),
                'next' => $reseps->nextPageUrl(),
            ],
            'current_page' => $reseps->currentPage(),
            'last_page' => $reseps->lastPage(),
        ]);
    }


    public function verifikasi($id, Request $request)
    {
        $resep = Resep::find($id);

        if (!$resep) {
            return response()->json(['error' => 'Resep tidak ditemukan!'], 404);
        }

        if ($resep->status !== 'pending') {
            return response()->json(['error' => 'Resep sudah diverifikasi atau ditolak'], 400);
        }

        $resep->status = $request->status;
        $resep->save();

        return response()->json(['success' => 'Resep berhasil diajukan untuk verifikasi']);
    }
}
