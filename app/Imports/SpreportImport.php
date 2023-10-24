<?php

namespace App\Imports;

use App\Models\SpReport;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class SpreportImport implements ToCollection, WithHeadingRow, WithValidation
{
    public function collection(Collection $collection)
    {
        foreach ($collection as $collect) {
            $datas[] = [
                'nik_karyawan' => $collect['nik'],
                'no_sp' => $collect['no_sp'],
                'level_sp' => $collect['level_sp'],
                'tgl_mulai' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intVal($collect['tgl_mulai']))),
                'tgl_berakhir' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intVal($collect['tgl_berakhir']))),
                'keterangan' => $collect['keterangan'],
                'pelapor' => $collect['pelapor'],
            ];
        }

        foreach (array_chunk($datas, 300) as $chunk) {
            SpReport::insert($chunk);
        }
    }

    public function rules(): array
    {
        return [
            'nik' => 'required',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'nik.required' => 'NIK must be filled in',
        ];
    }
}
