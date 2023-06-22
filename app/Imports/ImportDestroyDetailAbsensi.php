<?php

namespace App\Imports;

use App\Models\DetailAbsensi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ImportDestroyDetailAbsensi implements ToModel, WithHeadingRow, WithValidation
{
    protected $detail_absensi;

    public function __construct()
    {
        $this->detail_absensi = DetailAbsensi::select('nik_karyawan', 'periode_bulan_id')->get();
    }

    public function model(array $row)
    {
        DetailAbsensi::where('periode_bulan_id', $row['bulan_id'])->chunkById(1000, function ($detail_absensi) {
            foreach ($detail_absensi as $data) {
                $data->delete();
            }
        });
    }


    public function rules(): array
    {
        return array(
            'bulan_id' => 'required',
        );
    }

    public function customValidationMessages()
    {
        return array(
            'bulan_id.required' => 'ID Periode bulan harus diisi.',
        );
    }
}
