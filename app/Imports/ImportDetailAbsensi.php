<?php

namespace App\Imports;

use App\Models\DetailAbsensi;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ImportDetailAbsensi implements ToCollection, WithHeadingRow, WithValidation
{
    public function collection(Collection $collection)
    {
        $datas = [];
        foreach ($collection as $collect) {
            $datas[] = array(
                'awal_periode' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intVal($collect['awal_periode']))),
                'akhir_periode' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intVal($collect['akhir_periode']))),
                'nik_karyawan' => $collect['nik_karyawan'],
                'total_alpa' => $collect['total_alpa'],
                'paid_leave' => $collect['paid_leave'],
                'unpaid_leave' => $collect['unpaid_leave'],
                'total_sakit' => $collect['total_sakit'],
                'total_off' => $collect['total_off'],
                'total_cuti' => $collect['total_cuti'],
                'total_libur' => $collect['total_libur'],
                'total_workdays' => $collect['total_workdays'],
                'total_absen' => $collect['total_absen'],
            );
        }
        foreach (array_chunk($datas, 500) as $chunk) {
            DetailAbsensi::insert($chunk);
        }
    }

    public function rules(): array
    {
        return [
            'nik_karyawan' => 'required'
        ];
    }

    public function customValidationMessages()
    {
        return [
            'nik.required' => 'NIK karyawan harus diisi',

        ];
    }
}
