<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Import;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $latestImport = Import::where('status', 'done')->latest('imported_at')->first();
        if (!$latestImport) {
            return view('dashboard.index', ['hasData' => false]);
        }

        $hasData = true;
        $importId = $latestImport->id;

        $totalTarget = Assignment::where('import_id', $importId)->sum('jumlah_dokumen');
        $totalSubmitted = Assignment::where('import_id', $importId)
            ->where('assignment_status_alias', 'SUBMITTED BY Pencacah')
            ->sum('jumlah_dokumen');

        $persenSelesai = $totalTarget > 0 ? round(($totalSubmitted / $totalTarget) * 100, 1) : 0;
        $totalPetugas = Assignment::where('import_id', $importId)->distinct('petugas_id')->count('petugas_id');
        $totalDesa = Assignment::where('import_id', $importId)->distinct('wilayah_id')->count('wilayah_id');

        $rekapKecamatan = DB::table('assignments')
            ->join('wilayah', 'assignments.wilayah_id', '=', 'wilayah.id')
            ->where('assignments.import_id', $importId)
            ->select(
                'wilayah.level_3_code',
                'wilayah.level_3_name as kecamatan',
                DB::raw('COUNT(DISTINCT assignments.petugas_id) as total_petugas'),
                DB::raw('COUNT(DISTINCT assignments.wilayah_id) as total_desa'),
                DB::raw('SUM(assignments.jumlah_dokumen) as total_target'),
                DB::raw('SUM(CASE WHEN assignments.assignment_status_alias = "OPEN" THEN assignments.jumlah_dokumen ELSE 0 END) as total_open'),
                DB::raw('SUM(CASE WHEN assignments.assignment_status_alias = "SUBMITTED BY Pencacah" THEN assignments.jumlah_dokumen ELSE 0 END) as total_submitted'),
                DB::raw('SUM(CASE WHEN assignments.assignment_status_alias = "REJECTED BY Admin Kabupaten" THEN assignments.jumlah_dokumen ELSE 0 END) as total_rejected')
            )
            ->groupBy('wilayah.level_3_code', 'wilayah.level_3_name')
            ->orderBy('kecamatan')
            ->get();

        $desaPerKecamatan = DB::table('assignments')
            ->join('wilayah', 'assignments.wilayah_id', '=', 'wilayah.id')
            ->where('assignments.import_id', $importId)
            ->select(
                'wilayah.level_3_code',
                'wilayah.level_4_name as desa',
                DB::raw('SUM(assignments.jumlah_dokumen) as total_target'),
                DB::raw('SUM(CASE WHEN assignment_status_alias = "OPEN" THEN assignments.jumlah_dokumen ELSE 0 END) as total_open'),
                DB::raw('SUM(CASE WHEN assignment_status_alias = "SUBMITTED BY Pencacah" THEN assignments.jumlah_dokumen ELSE 0 END) as total_submitted'),
                DB::raw('SUM(CASE WHEN assignment_status_alias = "REJECTED BY Admin Kabupaten" THEN assignments.jumlah_dokumen ELSE 0 END) as total_rejected')
            )
            ->groupBy('wilayah.level_3_code', 'wilayah.level_4_name')
            ->orderBy('desa')
            ->get()
            ->groupBy('level_3_code');

        $rekapPetugas = DB::table('assignments')
            ->join('petugas', 'assignments.petugas_id', '=', 'petugas.id')
            ->join('wilayah', 'assignments.wilayah_id', '=', 'wilayah.id')
            ->where('assignments.import_id', $importId)
            ->select(
                'petugas.id as petugas_id',
                'petugas.nama',
                'petugas.email',
                DB::raw('COUNT(DISTINCT wilayah.level_3_code) as total_kecamatan'),
                DB::raw('COUNT(DISTINCT assignments.wilayah_id) as total_desa'),
                DB::raw('SUM(assignments.jumlah_dokumen) as total_target'),
                DB::raw('SUM(CASE WHEN assignments.assignment_status_alias = "OPEN" THEN assignments.jumlah_dokumen ELSE 0 END) as total_open'),
                DB::raw('SUM(CASE WHEN assignments.assignment_status_alias = "SUBMITTED BY Pencacah" THEN assignments.jumlah_dokumen ELSE 0 END) as total_submitted'),
                DB::raw('SUM(CASE WHEN assignments.assignment_status_alias = "REJECTED BY Admin Kabupaten" THEN assignments.jumlah_dokumen ELSE 0 END) as total_rejected')
            )
            ->groupBy('petugas.id', 'petugas.nama', 'petugas.email')
            ->orderBy('total_target', 'desc')
            ->get();

        // Data for charts
        $chartData = [
            'open' => Assignment::where('import_id', $importId)->where('assignment_status_alias', 'OPEN')->sum('jumlah_dokumen'),
            'submitted' => $totalSubmitted,
            'rejected' => Assignment::where('import_id', $importId)->where('assignment_status_alias', 'REJECTED BY Admin Kabupaten')->sum('jumlah_dokumen'),
        ];

        return view('dashboard.index', compact(
            'hasData', 'latestImport', 'totalTarget', 'totalSubmitted', 'persenSelesai',
            'totalPetugas', 'totalDesa', 'rekapKecamatan', 'desaPerKecamatan', 'rekapPetugas', 'chartData'
        ));
    }
}
