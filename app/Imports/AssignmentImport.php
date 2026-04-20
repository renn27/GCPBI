<?php
namespace App\Imports;

use App\Models\Assignment;
use App\Models\Petugas;
use App\Models\Wilayah;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class AssignmentImport implements ToCollection, WithHeadingRow
{
    protected int $importId;
    protected int $successCount = 0;

    public function __construct(int $importId)
    {
        $this->importId = $importId;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            if (empty($row['email_pencacah'])) continue;

            $emailRaw = strtolower(trim($row['email_pencacah']));
            $namaDariExcel = isset($row['nama_pencacah']) ? trim($row['nama_pencacah']) : '';
            if (empty($namaDariExcel)) {
                $namaDariExcel = explode('@', $emailRaw)[0];
            }

            $wilayah = Wilayah::firstOrCreate(
                ['level_4_code' => (string) $row['level_4_full_code']],
                [
                    'level_1_code' => (string) $row['level_1_full_code'],
                    'level_1_name' => trim($row['level_1_name']),
                    'level_2_code' => (string) $row['level_2_full_code'],
                    'level_2_name' => trim($row['level_2_name']),
                    'level_3_code' => (string) $row['level_3_full_code'],
                    'level_3_name' => trim($row['level_3_name']),
                    'level_4_name' => trim($row['level_4_name']),
                ]
            );

            $petugas = Petugas::firstOrCreate(
                ['email' => $emailRaw],
                ['nama'  => $namaDariExcel]
            );

            // Update nama jika sebelumnya fallback dari email dan sekarang mendapatkan nama asli dari excel
            if ($petugas->wasRecentlyCreated === false && str_contains($namaDariExcel, ' ')) {
                $namaSekarang = $petugas->nama;
                if (!str_contains($namaSekarang, ' ')) {
                    $petugas->update(['nama' => $namaDariExcel]);
                }
            }

            Assignment::create([
                'import_id'               => $this->importId,
                'wilayah_id'              => $wilayah->id,
                'petugas_id'              => $petugas->id,
                'assignment_status_alias' => trim($row['assignment_status_alias']),
                'jumlah_dokumen'          => (int) ($row['jumlah_dokumen'] ?? 0),
            ]);

            $this->successCount++;
        }
    }

    public function getSuccessCount(): int
    {
        return $this->successCount;
    }
}
