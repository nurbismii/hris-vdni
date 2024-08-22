<?php

namespace App\Imports;

use App\Models\employee;
use App\Models\SpReport;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class SpreportImport implements ToCollection, WithHeadingRow, WithValidation
{
    public function collection(Collection $collection)
    {
        $datas = array();

        foreach ($collection as $collect) {

            $check_exist = employee::select('nik')->where('nik', $collect['nik'])->first();

            if ($check_exist) {
                $sp_exist = SpReport::where('nik_karyawan', $check_exist->nik)->where('no_sp', $collect['no_sp'])->first();

                if ($sp_exist) {
                    Log::info($sp_exist);
                } else {
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
            }
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
            'nik.required' => 'NIK karyawan harus wajib diisi',
        ];
    }
}
