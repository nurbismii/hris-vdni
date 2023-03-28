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
                'no_ktp' => $collect['no_ktp'],
                'name' => $collect['name'],
                'company_name' => $collect['company_name'],
                'date_of_birth' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($collect['date_of_birth'])),
                'npwp' => $collect['npwp'],
                'bpjs_ket' => $collect['bpjs_kes'],
                'bpjs_tk' => $collect['bpjs_tk'],
                'vaccine' => $collect['vaccine'],
                'entry_date' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($collect['entry_date']))
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
            'company_name' => 'required|in:VDNI,VDNIP'
        ];
    }

    public function customValidationMessages()
    {
        return [
            'nik.unique' => 'NIK has been registered',
            'nik.required' => 'NIK must be filled',
            'no_ktp.unique' => 'KTP has been registered',
            'no_ktp.required' => 'KTP must be filled',
            'company_name.required' => 'Company name must be filled',
            'company_name.in' => 'Company name must be filled VDNI or VDNIP'
        ];
    }
}
