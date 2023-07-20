<?php

namespace App\Imports;

use App\Models\KeteranganAbsensi;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ImportKeteranganAbsen implements ToCollection, WithHeadingRow, WithValidation
{
    public function collection(Collection $collection)
    {
        $datas = [];
        foreach ($collection as $collect) {
            $datas[] = array(
                'periode' => strtolower($collect['periode']),
                'nik_karyawan' => $collect['nik_karyawan'],
                'tanggal_mulai_izin' =>  Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intVal($collect['tanggal_mulai']))),
                'tanggal_selesai_izin' =>  Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intVal($collect['tanggal_selesai']))),
                'total_izin' =>  str_replace(['hari', 'HARI', 'Hari'], '', $collect['total_izin']),
                'keterangan_izin' =>  $collect['keterangan_izin'],
                'status_izin' =>  strtolower($collect['status_izin']),
                'awal_periode' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intVal($collect['awal_periode']))),
                'akhir_periode' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intVal($collect['akhir_periode']))),
            );
        }
        foreach (array_chunk($datas, 300) as $chunk) {
            KeteranganAbsensi::insert($chunk);
        }
    }

    public function rules(): array
    {
        return [
            'nik_karyawan' => 'required',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'nik_karyawan.required' => 'NIK harus diisi',
        ];
    }
}
