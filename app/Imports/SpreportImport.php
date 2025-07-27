<?php

namespace App\Imports;

use App\Models\SpReport;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Illuminate\Contracts\Queue\ShouldQueue;

class SpreportImport implements
    ToCollection,
    WithValidation,
    WithHeadingRow,
    WithChunkReading,
    WithBatchInserts,
    ShouldQueue
{
    use Importable;

    public function collection(Collection $collection)
    {
        $datas = [];

        foreach ($collection as $collect) {
            $sp_exist = SpReport::where('nik_karyawan', $collect['nik'])
                ->where('no_sp', $collect['no_sp'])
                ->exists();

            if (!$sp_exist) {
                $datas[] = [
                    'nik_karyawan' => $collect['nik'],
                    'no_sp' => $collect['no_sp'],
                    'level_sp' => $collect['level_sp'],
                    'tgl_mulai' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject((int) $collect['tgl_mulai'])),
                    'tgl_berakhir' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject((int) $collect['tgl_berakhir'])),
                    'keterangan' => $collect['keterangan'],
                    'pelapor' => $collect['pelapor'],
                ];
            }
        }

        if (!empty($datas)) {
            SpReport::insert($datas); // will be chunked and batched
        }
    }

    public function rules(): array
    {
        return [
            'nik' => 'required',
            'no_sp' => 'required',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'nik.required' => 'NIK karyawan harus wajib diisi',
            'no_sp.required' => 'Nomor SP harus diisi',
        ];
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function batchSize(): int
    {
        return 1000;
    }
}
