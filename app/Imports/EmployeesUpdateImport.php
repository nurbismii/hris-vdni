<?php

namespace App\Imports;

use App\Models\employee;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class EmployeesUpdateImport implements ToCollection, WithHeadingRow, WithValidation
{
    protected $employee;

    public function __construct()
    {
        $this->employee = employee::select('nik', 'no_ktp')->get();
    }

    public function collection(Collection $collection)
    {
        foreach ($collection as $collect) {

            $data = $this->employee->where('nik', $collect['nik'])->first();
            $data->where('nik', $collect['nik'])->update([
                'no_sk_pkwtt' => $collect['no_sk_pkwtt'],
                'nama_karyawan' => $collect['nama_karyawan'],
                'nama_ibu_kandung' => $collect['nama_ibu_kandung'],
                'agama' => $collect['agama'],
                'no_ktp' => str_replace(["'", "`"], "", $collect['no_ktp']),
                'no_kk' => str_replace(["'", "`"], "", $collect['no_kk']),
                'jenis_kelamin' => $collect['jenis_kelamin'],
                'status_perkawinan' => $collect['status_perkawinan'],
                'status_karyawan' => $collect['status_karyawan'],
                'tgl_resign' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intVal($collect['tgl_resign']))) ?? null,
                'no_telp' => $collect['no_telp'],
                'tgl_lahir' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intVal($collect['tgl_lahir']))),
                'area_kerja' => $collect['area_kerja'],
                'golongan_darah' => $collect['golongan_darah'],
                'entry_date' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intVal($collect['entry_date']))),
                'npwp' => $collect['npwp'],
                'bpjs_kesehatan' => $collect['bpjs_kesehatan'],
                'bpjs_tk' => $collect['bpjs_tk'],
                'vaksin' => $collect['vaksin'],
                'jam_kerja' => $collect['jam_kerja'],
                'status_resign' => $collect['status_resign'],
                'posisi' => $collect['posisi'],
                'jabatan' => $collect['jabatan'],
                'divisi_id' => $collect['divisi_id']
            ]);
        }
    }

    public function rules(): array
    {
        return array(
            'nik' => 'required',
            'no_ktp' => 'required|min:15|max:16',
            'no_kk' => 'min:15|max:16'
        );
    }

    public function customValidationMessages()
    {
        return array(
            'nik.required' => 'NIK Karyawan tidak boleh kosong',
            'no_ktp.required' => 'NO KTP tidak boleh kosong',
            'no_kk.min' => 'NO KTP tidak boleh kurang dari 15 angka',
            'no_kk.max' => 'NO KK tidak boleh lebih dari 16 angka'
        );
    }
}
