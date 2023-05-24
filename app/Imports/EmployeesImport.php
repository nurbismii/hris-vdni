<?php

namespace App\Imports;

use App\Models\employee;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class EmployeesImport implements ToCollection, WithHeadingRow, WithValidation
{
    public function collection(Collection $collection)
    {
        $datas = array();
        foreach ($collection as $collect) {
            $datas[] = array(
                'nik' => $collect['nik'],
                'no_sk_pkwtt' => $collect['no_sk_pkwtt'],
                'nama_karyawan' => $collect['nama_karyawan'],
                'nama_ibu_kandung' => $collect['nama_ibu_kandung'],
                'agama' => $collect['agama'],
                'no_ktp' => $collect['no_ktp'],
                'no_kk' => $collect['no_kk'],
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
                'status_resign' => $collect['status_resign']
            );
        }
        foreach (array_chunk($datas, 1000) as $chunk) {
            employee::insert($chunk);
        }
    }

    public function rules(): array
    {
        return [
            'nik' => 'required|unique:employees,nik',
            'no_ktp' => 'required|unique:employees,no_ktp',
            'area_kerja' => 'required|in:VDNI,VDNIP'
        ];
    }

    public function customValidationMessages()
    {
        return [
            'nik.unique' => 'NIK Karyawan telah digunakan',
            'nik.required' => 'NIK karyawan harus diisi',
            'no_ktp.unique' => 'No KTP telah digunakan',
            'no_ktp.required' => 'No KTP harus diisi',
            'area_kerja.required' => 'Area Kerja harus diisi',
            'area_kerja.in' => 'Area Kerja hanya bisa diisi VDNI atau VDNIP'
        ];
    }
}
