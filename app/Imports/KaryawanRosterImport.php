<?php

namespace App\Imports;

use App\Models\KaryawanRoster;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class KaryawanRosterImport implements ToCollection, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $collection)
    {
        $datas = [];
        foreach ($collection as $collect) {
            $datas[] = array(
                'nik_karyawan' => $collect['nik_karyawan'],
                'periode_id' => $collect['periode_id'],
                'minggu_pertama' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intVal($collect['i']))) ?? null,
                'minggu_kedua' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intVal($collect['ii']))) ?? null,
                'minggu_ketiga' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intVal($collect['iii']))) ?? null,
                'minggu_keempat' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intVal($collect['iv']))) ?? null,
                'minggu_kelima' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intVal($collect['v']))) ?? null,
            );
        }
        foreach (array_chunk($datas, 100) as $chunk) {
            KaryawanRoster::insert($chunk);
        }
    }

    public function rules(): array
    {
        return [
            'nik_karyawan' => 'required',
            'periode_id' => 'required',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'nik_karyawan.required' => 'NIK karyawan harus diisi',
            'periode_id.required' => 'ID Periode Tahun harus diisi',

        ];
    }
}
