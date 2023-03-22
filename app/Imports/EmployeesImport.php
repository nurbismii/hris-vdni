<?php

namespace App\Imports;

use App\Models\employee;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class EmployeesImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        return new employee([
            'nik' => $row['nik'],
            'no_ktp' => $row['no_ktp'],
            'name' => $row['name'],
            'company_name' => $row['company_name'],
            'date_of_birth' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['date_of_birth'])),
            'npwp' => $row['npwp'],
            'bpjs_ket' => $row['bpjs_kes'],
            'bpjs_tk' => $row['bpjs_tk'],
            'vaccine' => $row['vaccine'],
            'entry_date' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['entry_date']))
        ]);
    }

    public function rules(): array
    {
        return [
            'nik' => 'required|unique:employees,nik',
            'no_ktp' => 'required|unique:employees,no_ktp',
            // 'npwp' => ['unique:employees,npwp'],
            // 'bpjs_ket' => ['unique:employees,bpjs_ket'],
            // 'bpjs_tk' => ['unique:employees,bpjs_tk'],
        ];
    }

    public function customValidationMessages()
    {
        return [
            'nik.unique' => 'NIK has been registered',
            'nik.required' => 'NIK must be filled',
            'no_ktp.unique' => 'KTP has been registered',
            'no_ktp.required' => 'KTP must be filled',
        ];
    }
}
