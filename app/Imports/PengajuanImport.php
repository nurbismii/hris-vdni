<?php

namespace App\Imports;

use App\Models\CutiIzin;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class PengajuanImport implements ToCollection, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $collection)
    {
        $current_time = date('Y-m-d H:i:s', strtotime(Carbon::now()));
        foreach ($collection as $collect) {
            $datas[] = [
                'nik_karyawan' => $collect['nik_karyawan'],
                'tanggal' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intVal($collect['tanggal']))),
                'keterangan' => $collect['keterangan'],
                'jumlah' => $collect['jumlah'],
                'tanggal_mulai' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intVal($collect['tanggal_mulai']))),
                'tanggal_berakhir' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intVal($collect['tanggal_berakhir']))),
                'tipe' => strtolower($collect['tipe']),
                'status_pemohon' => 'ya',
                'status_hrd' => 'Diterima',
                'status_hod' => 'Diterima',
                'status_penanggung_jawab' => 'Diterima',
                'created_at' =>  Carbon::now()->format('Y-m-d H:i:s'),
            ];
        }

        foreach (array_chunk($datas, 300) as $chunk) {
            CutiIzin::insert($chunk);
        }
    }

    public function rules(): array
    {
        return [];
    }
}
