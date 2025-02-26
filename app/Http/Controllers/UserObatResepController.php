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
            ->with(['dokter', 'pasien'])
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

        // Calculate statistics
        $totalResep = $reseps->count();
        $menunggu = $resepsMenunggu->count();
        $terverifikasi = $resepsTerverifikasi->count();
        $ditolak = $resepsDitolak->count();

        return view('pages.user.resep.index', compact(
            'resepsMenunggu',
            'resepsTerverifikasi',
            'resepsDitolak',
            'resepsDariDokter',
            'totalResep',
            'menunggu',
            'terverifikasi',
            'ditolak',
            'obats'
        ))->with(['title' => 'Verifikasi Resep']);
    }
    public function fetch(Request $request)
    {
        $status = $request->query('status');
        $query = Resep::where('pasien_id', Auth::id())
            ->with(['dokter', 'pasien'])
            ->latest();

        if ($status === 'dokter') {
            $query->whereNotNull('dokter_id')->where('pasien_id', Auth::id());
        } elseif ($status === 'pending') {
            $query->whereNull('status')
                ->orWhere('status', '')
                ->orWhere('status', 'pending')
                ->orWhere('status', 'Menunggu Verifikasi');
        } elseif ($status !== null) {
            $query->where('status', $status);
        }

        $reseps = $query->paginate(12);

        return response()->json([
            'data' => $reseps->map(function ($resep) {
                return [
                    'id' => $resep->id,
                    'pasien_nama' => $resep->pasien->name ?? '-',
                    'dokter' => $resep->dokter->name ?? 'Resep Upload',
                    'sumber' => $resep->dokter_id ? 'dokter' : 'upload',
                    'obats' => json_decode($resep->obats ?? '[]', true), // Pastikan didecode dengan fallback ke array kosong
                    'status' => $resep->status,
                    'foto_resep' => $resep->foto_resep,
                    'created_at' => $resep->created_at->format('Y-m-d H:i:s'),
                ];
            }),
            'links' => $reseps->links()->elements,
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
