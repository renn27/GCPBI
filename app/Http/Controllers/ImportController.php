<?php

namespace App\Http\Controllers;

use App\Imports\AssignmentImport;
use App\Models\Assignment;
use App\Models\Import;
use App\Models\Petugas;
use App\Models\Wilayah;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    private array $requiredColumns = [
        'level_1_full_code', 'level_1_name',
        'level_2_full_code', 'level_2_name',
        'level_3_full_code', 'level_3_name',
        'level_4_full_code', 'level_4_name',
        'email_pencacah', 'assignment_status_alias', 'jumlah_dokumen',
    ];

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls|max:10240',
            'password' => 'required|in:gcpbi2026',
        ], [
            'file.required' => 'File Excel wajib dipilih.',
            'file.mimes'    => 'File harus berformat .xlsx atau .xls.',
            'file.max'      => 'Ukuran file maksimal 10MB.',
            'password.required' => 'Password wajib diisi.',
            'password.in' => 'Password yang Anda masukkan salah.',
        ]);

        try {
            $rows = Excel::toArray(
                new class implements \Maatwebsite\Excel\Concerns\ToArray,
                    \Maatwebsite\Excel\Concerns\WithHeadingRow {
                    public function array(array $array): array { return $array; }
                },
                $request->file('file')
            );

            $firstSheet = $rows[0] ?? [];
            if (empty($firstSheet)) {
                return back()->withErrors(['file' => 'File Excel kosong atau tidak memiliki data.']);
            }

            $availableColumns = array_keys($firstSheet[0] ?? []);
            $missingColumns   = array_diff($this->requiredColumns, $availableColumns);

            if (!empty($missingColumns)) {
                $columnMapping = [
                    'level_1_full_code'       => 'level_1_full_code',
                    'level_1_name'            => 'level_1_name',
                    'level_2_full_code'       => 'level_2_full_code',
                    'level_2_name'            => 'level_2_name',
                    'level_3_full_code'       => 'level_3_full_code',
                    'level_3_name'            => 'level_3_name',
                    'level_4_full_code'       => 'level_4_full_code',
                    'level_4_name'            => 'level_4_name',
                    'email_pencacah'          => 'email_pencacah',
                    'assignment_status_alias' => 'assignment_status_alias',
                    'jumlah_dokumen'          => 'Jumlah Dokumen',
                ];
                $missingDisplay = array_map(fn($col) => $columnMapping[$col] ?? $col, $missingColumns);
                return back()->withErrors([
                    'file' => 'Upload gagal. Kolom berikut tidak ditemukan di file Excel: ' .
                              implode(', ', $missingDisplay) .
                              '. Pastikan format file sesuai template.'
                ]);
            }
        } catch (\Exception $e) {
            return back()->withErrors(['file' => 'File tidak dapat dibaca. Pastikan file tidak rusak dan formatnya benar.']);
        }

        Assignment::query()->delete();
        Wilayah::query()->delete();
        Petugas::query()->delete();
        Import::query()->delete();

        $file         = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $storedName   = time() . '_' . $originalName;
        $file->storeAs('imports', $storedName);

        $import = Import::create([
            'filename'      => $storedName,
            'original_name' => $originalName,
            'imported_at'   => now(),
            'status'        => 'processing',
        ]);

        try {
            $importer = new AssignmentImport($import->id);
            Excel::import($importer, storage_path('app/private/imports/' . $storedName));

            $import->update([
                'total_rows' => $importer->getSuccessCount(),
                'status'     => 'done',
            ]);

            return redirect()->route('dashboard')
                ->with('success', "Import berhasil! {$importer->getSuccessCount()} baris data berhasil diimport dari file \"{$originalName}\".");

        } catch (\Exception $e) {
            Assignment::query()->delete();
            Wilayah::query()->delete();
            Petugas::query()->delete();
            $import->update([
                'status' => 'failed',
                'notes'  => $e->getMessage(),
            ]);

            return redirect()->route('dashboard')
                ->with('error', 'Import gagal saat memproses data: ' . $e->getMessage());
        }
    }
}
