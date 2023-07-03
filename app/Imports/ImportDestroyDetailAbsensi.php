<?php

namespace App\Imports;

use App\Models\DetailAbsensi;
use App\Models\KeteranganAbsensi;
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
        DetailAbsensi::where('awal_periode', $row['awal_periode'])->where('akhir_periode', $row['akhir_periode'])->where('nik_karyawan', $row['nik_karyawan'])->chunkById(1000, function ($detail_absensi) {
            foreach ($detail_absensi as $data) {
                $data->delete();
            }
        });
        KeteranganAbsensi::where('awal_periode', $row['awal_periode'])->where('akhir_periode', $row['akhir_periode'])->where('nik_karyawan', $row['nik_karyawan'])->chunkById(1000, function ($ket_absensi) {
            foreach ($ket_absensi as $data) {
                $data->delete();
            }
        });
    }


    public function rules(): array
    {
        return array(
            'nik_karyawan' => 'required',
        );
    }

    public function customValidationMessages()
    {
        return array(
            'nik_karyawan.required' => 'NIK karyawan harus diisi.',
        );
    }
}
