<?php

namespace App\Http\Controllers;

use App\Exports\RekapPetugasExport;
use App\Exports\RekapWilayahExport;
use App\Models\Import;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function wilayah()
    {
        $latestImport = Import::where('status', 'done')->latest('imported_at')->first();
        
        if (!$latestImport) {
            return back()->with('error', 'Tidak ada data untuk di-export.');
        }

        $filename = 'rekap_wilayah_' . date('YmdHis') . '.xlsx';
        return Excel::download(new RekapWilayahExport($latestImport->id), $filename);
    }

    public function petugas()
    {
        $latestImport = Import::where('status', 'done')->latest('imported_at')->first();
        
        if (!$latestImport) {
            return back()->with('error', 'Tidak ada data untuk di-export.');
        }

        $filename = 'rekap_petugas_' . date('YmdHis') . '.xlsx';
        return Excel::download(new RekapPetugasExport($latestImport->id), $filename);
    }
}
