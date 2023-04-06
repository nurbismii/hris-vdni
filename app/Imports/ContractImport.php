<?php

namespace App\Imports;

use App\Models\Contract;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ContractImport implements ToCollection, WithHeadingRow, WithValidation
{
    public function collection(Collection $collection)
    {
        $datas = [];
        foreach ($collection as $collect) {
            $datas[] = [
                'no_pkwt' => $collect['no_pkwt'],
                'jenis_kelamin' => $collect['jenis_kelamin'],
                'nik' => $collect['nik'],
                'nama' => $collect['nama'],
                'alamat' => $collect['alamat'],
                'no_ktp' => $collect['no_ktp'],
                'jabatan' => $collect['jabatan'],
                'lama_kontrak' => $collect['lama_kontrak'],
                'status_perkawinan' => $collect['status_permenikahan'],
                'tanggal_mulai_kontrak' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($collect['tanggal_mulai_kontrak'])),
                'tanggal_berakhir_kontrak' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($collect['tanggal_berakhir_kontrak'])),
                'gaji' => $collect['gaji'],
                'uang_makan' => $collect['uang_makan'],
                'tunjangan_jabatan' => $collect['tunjangan_jabatan'],
                'keterangan_kontrak' => $collect['keterangan_kontrak'],
                'status' => $collect['status'],
            ];
        }
        foreach (array_chunk($datas, 1000) as $contract) {
            Contract::insert($contract);
        }
    }

    public function rules(): array
    {
        return [
            'no_pkwt' => 'required|unique:contracts,no_pkwt',
            'nik'  => 'required',
            'tanggal_mulai_kontrak' => 'required'
        ];
    }

    public function customValidationMessages()
    {
        return [
            'no_pkwt.required' => 'No PKWT must be filled',
            'nik.required' => 'NIK must be filled',
            'tanggal_mulai_kontrak.required' => 'Contract start date must be filled',
        ];
    }
}
