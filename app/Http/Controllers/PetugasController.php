<?php

namespace App\Http\Controllers;

use App\Models\Import;
use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PetugasController extends Controller
{
    public function show($id)
    {
        $petugas = Petugas::findOrFail($id);
        $latestImport = Import::where('status', 'done')->latest('imported_at')->first();
        if (!$latestImport) {
            return redirect()->route('dashboard')->with('error', 'Belum ada data import.');
        }
        $importId = $latestImport->id;

        $stats = DB::table('assignments')
            ->where('import_id', $importId)
            ->where('petugas_id', $petugas->id)
            ->select(
                DB::raw('SUM(jumlah_dokumen) as total_target'),
                DB::raw('SUM(CASE WHEN assignment_status_alias = "OPEN" THEN jumlah_dokumen ELSE 0 END) as total_open'),
                DB::raw('SUM(CASE WHEN assignment_status_alias = "SUBMITTED BY Pencacah" THEN jumlah_dokumen ELSE 0 END) as total_submitted'),
                DB::raw('SUM(CASE WHEN assignment_status_alias = "REJECTED BY Admin Kabupaten" THEN jumlah_dokumen ELSE 0 END) as total_rejected'),
                DB::raw('COUNT(DISTINCT wilayah_id) as total_desa')
            )
            ->first();

        $detailPerDesa = DB::table('assignments')
            ->join('wilayah', 'assignments.wilayah_id', '=', 'wilayah.id')
            ->where('assignments.import_id', $importId)
            ->where('assignments.petugas_id', $petugas->id)
            ->select(
                'wilayah.level_3_name as kecamatan',
                'wilayah.level_3_code',
                'wilayah.level_4_name as desa',
                'wilayah.level_4_code',
                DB::raw('SUM(assignments.jumlah_dokumen) as total_target'),
                DB::raw('SUM(CASE WHEN assignment_status_alias = "OPEN" THEN assignments.jumlah_dokumen ELSE 0 END) as total_open'),
                DB::raw('SUM(CASE WHEN assignment_status_alias = "SUBMITTED BY Pencacah" THEN assignments.jumlah_dokumen ELSE 0 END) as total_submitted'),
                DB::raw('SUM(CASE WHEN assignment_status_alias = "REJECTED BY Admin Kabupaten" THEN assignments.jumlah_dokumen ELSE 0 END) as total_rejected')
            )
            ->groupBy('wilayah.level_3_name', 'wilayah.level_3_code', 'wilayah.level_4_name', 'wilayah.level_4_code')
            ->orderBy('kecamatan')
            ->orderBy('desa')
            ->get()
            ->groupBy('kecamatan');

        $persenSelesai = $stats && $stats->total_target > 0 ? round(($stats->total_submitted / $stats->total_target) * 100, 1) : 0;

        return view('petugas.show', compact('petugas', 'stats', 'detailPerDesa', 'persenSelesai'));
    }
}
