<?php

namespace App\Imports;

use App\Models\Resign;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ResignImportUpdate implements ToCollection, WithHeadingRow, WithValidation
{
    protected $resign;

    public function __construct()
    {
        $this->resign = Resign::select('nik_karyawan')->get();
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $collect) {

            $data = $this->resign->where('nik_karyawan', $collect['nik_karyawan'])->first();
            $data->where('nik_karyawan', $collect['nik_karyawan'])->update([
                'no_surat' => $collect['no_surat'],
                'nik_karyawan' => $collect['nik_karyawan'],
                'no_ktp' => $collect['no_ktp'],
                'tanggal_pengajuan' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intVal($collect['tanggal_pengajuan']))),
                'tanggal_keluar' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intVal($collect['tanggal_keluar']))),
                'alasan_keluar' => $collect['alasan_keluar'],
                'tipe' => strtoupper($collect['tipe']),
                'periode_awal' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intVal($collect['periode_awal']))),
                'periode_akhir' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intVal($collect['periode_akhir']))),
            ]);
        }
    }

    public function rules(): array
    {
        return [];
    }

    public function customValidationMessages()
    {
        return [];
    }
}
