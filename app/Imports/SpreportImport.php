<?php

namespace App\Imports;

use App\Models\employee;
use App\Models\SpReport;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\Importable;

class SpreportImport implements ToCollection, WithValidation, SkipsOnFailure, WithHeadingRow
{
    use Importable, SkipsFailures;

    public function collection(Collection $collection)
    {
        $datas = [];

        foreach ($collection as $collect) {

            $sp_exist = SpReport::where('nik_karyawan', $collect['nik'])
                ->where('no_sp', $collect['no_sp'])
                ->first();

            if (!$sp_exist) {
                $datas[] = [
                    'nik_karyawan' => $collect['nik'],
                    'no_sp' => $collect['no_sp'],
                    'level_sp' => $collect['level_sp'],
                    'tgl_mulai' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intVal($collect['tgl_mulai']))),
                    'tgl_berakhir' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intVal($collect['tgl_berakhir']))),
                    'keterangan' => $collect['keterangan'],
                    'pelapor' => $collect['pelapor'],
                ];
            } else {
                Log::info($sp_exist);
            }
        }

        if (count($datas) > 0) {
            Log::info("Ready to import...");
            Log::info($datas);
            foreach (array_chunk($datas, 500) as $chunk) {
                SpReport::insert($chunk);
            }
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
}
