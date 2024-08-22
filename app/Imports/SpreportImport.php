<?php

namespace App\Imports;

use App\Models\employee;
use App\Models\SpReport;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\Importable;

class SpreportImport implements ToCollection, WithValidation, SkipsOnFailure
{
    use Importable, SkipsFailures;

    public function collection(Collection $collection)
    {
        $datas = array();

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
            }
        }

        if (!empty($datas)) {
            foreach (array_chunk($datas, 300) as $chunk) {
                SpReport::insert($chunk);
            }
        }
    }

    public function rules(): array
    {
        return [
            'nik' => 'required',
            'no_sp' => 'required',
            'level_sp' => 'required',
            'tgl_mulai' => 'required|date',
            'tgl_berakhir' => 'required|date|after:tgl_mulai',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'nik.required' => 'NIK karyawan harus wajib diisi',
            'no_sp.required' => 'Nomor SP harus diisi',
            'level_sp.required' => 'Level SP harus diisi',
            'tgl_mulai.required' => 'Tanggal mulai harus diisi',
            'tgl_mulai.date' => 'Tanggal mulai harus dalam format tanggal yang benar',
            'tgl_berakhir.required' => 'Tanggal berakhir harus diisi',
            'tgl_berakhir.date' => 'Tanggal berakhir harus dalam format tanggal yang benar',
            'tgl_berakhir.after' => 'Tanggal berakhir harus setelah tanggal mulai',
        ];
    }
}
