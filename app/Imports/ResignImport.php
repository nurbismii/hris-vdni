<?php

namespace App\Imports;

use App\Models\Resign;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ResignImport implements ToCollection, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $collect) {
            $check_exist = Resign::where('nik_karyawan', $collect['nik_karyawan'])->first();
            if (!$check_exist) {
                $datas[] = [
                    'no_surat' => $collect['no_surat'],
                    'nik_karyawan' => $collect['nik_karyawan'],
                    'no_ktp' => $collect['no_ktp'],
                    'tanggal_pengajuan' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intVal($collect['tanggal_pengajuan']))),
                    'tanggal_keluar' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intVal($collect['tanggal_keluar']))),
                    'alasan_keluar' => $collect['alasan_keluar'],
                    'tipe' => strtoupper($collect['tipe']),
                    'periode_awal' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intVal($collect['periode_awal']))),
                    'periode_akhir' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intVal($collect['periode_akhir']))),
                    'created_at' =>  Carbon::now()->format('Y-m-d H:i:s'),
                ];
            }
        }

        foreach (array_chunk($datas, 300) as $chunk) {
            Resign::insert($chunk);
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
            'nik_karywan.required' => 'NIK Karyawan wajib diisi'
        ];
    }
}
