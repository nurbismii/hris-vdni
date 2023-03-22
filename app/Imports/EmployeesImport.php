<?php

namespace App\Imports;

use App\Models\employee;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EmployeesImport implements ToModel, WithHeadingRow
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
            '*.nik' => ['required', 'unique:employee,nik'],
            '*.no_ktp' => ['required', 'unique:employee,no_ktp'],
            'company_name' => function ($attribute, $value, $onFailure) {
                if($value != 'VDNI' or $value != 'FHNI'){
                    $onFailure('Company is not VDNI or FHNI');
                }
            }
        ];
    }
}
