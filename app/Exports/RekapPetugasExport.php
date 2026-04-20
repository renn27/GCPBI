<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RekapPetugasExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $importId;

    public function __construct($importId)
    {
        $this->importId = $importId;
    }

    public function collection()
    {
        return DB::table('assignments')
            ->join('petugas', 'assignments.petugas_id', '=', 'petugas.id')
            ->where('assignments.import_id', $this->importId)
            ->select(
                'petugas.nama',
                'petugas.email',
                DB::raw('COUNT(DISTINCT assignments.wilayah_id) as total_desa'),
                DB::raw('SUM(assignments.jumlah_dokumen) as total_target'),
                DB::raw('SUM(CASE WHEN assignment_status_alias = "OPEN" THEN assignments.jumlah_dokumen ELSE 0 END) as total_open'),
                DB::raw('SUM(CASE WHEN assignment_status_alias = "SUBMITTED BY Pencacah" THEN assignments.jumlah_dokumen ELSE 0 END) as total_submitted'),
                DB::raw('SUM(CASE WHEN assignment_status_alias = "REJECTED BY Admin Kabupaten" THEN assignments.jumlah_dokumen ELSE 0 END) as total_rejected')
            )
            ->groupBy('petugas.id', 'petugas.nama', 'petugas.email')
            ->orderBy('total_target', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Nama Petugas',
            'Email',
            'Total Desa',
            'Target',
            'OPEN',
            'SUBMITTED',
            'REJECTED',
            '% Selesai'
        ];
    }

    public function map($row): array
    {
        $persenSelesai = $row->total_target > 0 ? round(($row->total_submitted / $row->total_target) * 100, 1) : 0;
        
        return [
            $row->nama,
            $row->email,
            $row->total_desa,
            $row->total_target,
            $row->total_open,
            $row->total_submitted,
            $row->total_rejected,
            $persenSelesai . '%'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
