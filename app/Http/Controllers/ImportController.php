<?php

namespace App\Http\Controllers;

use App\Imports\AssignmentImport;
use App\Models\Assignment;
use App\Models\Import;
use App\Models\Petugas;
use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    private array $requiredColumns = [
        'level_1_full_code',
        'level_1_name',
        'level_2_full_code',
        'level_2_name',
        'level_3_full_code',
        'level_3_name',
        'level_4_full_code',
        'level_4_name',
        'email_pencacah',
        'assignment_status_alias',
        'jumlah_dokumen',
    ];

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls|max:10240',
            'password' => 'required|in:gcpbi2026',
        ], [
            'file.required' => 'File Excel wajib dipilih.',
            'file.mimes' => 'File harus berformat .xlsx atau .xls.',
            'file.max' => 'Ukuran file maksimal 10MB.',
            'password.required' => 'Password wajib diisi.',
            'password.in' => 'Password yang Anda masukkan salah.',
        ]);

        // Validasi struktur kolom
        try {
            $rows = Excel::toArray(
                new class implements
                    \Maatwebsite\Excel\Concerns\ToArray,
                    \Maatwebsite\Excel\Concerns\WithHeadingRow {
                public function array(array $array): array
                {
                    return $array;
                }
                },
                $request->file('file')
            );

            $firstSheet = $rows[0] ?? [];
            if (empty($firstSheet)) {
                return back()->withErrors(['file' => 'File Excel kosong atau tidak memiliki data.']);
            }

            // Hitung jumlah baris data
            $totalRows = count($firstSheet);
            if ($totalRows > 50000) {
                return back()->withErrors(['file' => 'File terlalu besar. Maksimal 50.000 baris data.']);
            }

            $availableColumns = array_keys($firstSheet[0] ?? []);
            $missingColumns = array_diff($this->requiredColumns, $availableColumns);

            if (!empty($missingColumns)) {
                $columnMapping = [
                    'level_1_full_code' => 'level_1_full_code',
                    'level_1_name' => 'level_1_name',
                    'level_2_full_code' => 'level_2_full_code',
                    'level_2_name' => 'level_2_name',
                    'level_3_full_code' => 'level_3_full_code',
                    'level_3_name' => 'level_3_name',
                    'level_4_full_code' => 'level_4_full_code',
                    'level_4_name' => 'level_4_name',
                    'email_pencacah' => 'email_pencacah',
                    'assignment_status_alias' => 'assignment_status_alias',
                    'jumlah_dokumen' => 'Jumlah Dokumen',
                ];
                $missingDisplay = array_map(fn($col) => $columnMapping[$col] ?? $col, $missingColumns);
                return back()->withErrors([
                    'file' => 'Upload gagal. Kolom berikut tidak ditemukan: ' . implode(', ', $missingDisplay)
                ]);
            }
        } catch (\Exception $e) {
            return back()->withErrors(['file' => 'File tidak dapat dibaca. Pastikan file tidak rusak.']);
        }

        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $storedName = time() . '_' . $originalName;

        // Simpan file
        $file->storeAs('imports', $storedName);

        // Gunakan transaction untuk rollback jika terjadi error
        DB::beginTransaction();

        try {
            // Hapus data lama
            Assignment::query()->delete();
            Wilayah::query()->delete();
            Petugas::query()->delete();
            Import::query()->delete();

            // Buat record import
            $import = Import::create([
                'filename' => $storedName,
                'original_name' => $originalName,
                'imported_at' => now(),
                'status' => 'processing',
                'total_rows' => $totalRows ?? 0,
            ]);

            // Import data
            $importer = new AssignmentImport($import->id);
            Excel::import($importer, storage_path('app/private/imports/' . $storedName));

            // Update status import
            $import->update([
                'total_rows' => $importer->getSuccessCount(),
                'status' => 'done',
                'imported_at' => now(),
            ]);

            DB::commit();

            // Hitung statistik untuk pesan sukses
            $petugasCount = Petugas::count();
            $wilayahCount = Wilayah::count();

            return redirect()->route('dashboard')
                ->with('success', "✅ Import berhasil! {$importer->getSuccessCount()} baris data, {$petugasCount} petugas, dan {$wilayahCount} wilayah berhasil diimport dari file \"{$originalName}\".");

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            DB::rollBack();

            $failures = $e->failures();
            $errorMessages = [];

            foreach ($failures as $failure) {
                $errorMessages[] = "Baris " . $failure->row() . ": " . implode(', ', $failure->errors());
            }

            // Simpan error ke notes
            if (isset($import)) {
                $import->update([
                    'status' => 'failed',
                    'notes' => implode("\n", array_slice($errorMessages, 0, 10)),
                ]);
            }

            return redirect()->route('dashboard')
                ->with('error', 'Import gagal karena kesalahan validasi data. ' . $errorMessages[0] ?? '')
                ->with('validation_errors', array_slice($errorMessages, 0, 5));

        } catch (\Exception $e) {
            DB::rollBack();

            // Rollback data jika ada error
            Assignment::query()->delete();
            Wilayah::query()->delete();
            Petugas::query()->delete();

            if (isset($import)) {
                $import->update([
                    'status' => 'failed',
                    'notes' => $e->getMessage(),
                ]);
            }

            \Log::error('Import Error: ' . $e->getMessage(), [
                'file' => $originalName,
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('dashboard')
                ->with('error', '❌ Import gagal: ' . $e->getMessage());
        }
    }
}