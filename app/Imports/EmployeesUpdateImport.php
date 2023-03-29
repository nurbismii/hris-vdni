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
            ]);
        }
    }

    public function rules(): array
    {
        return array(
            'nik' => 'required',
            'no_ktp' => 'required',
        );
    }

    public function customValidationMessages()
    {
        return array(
            'nik.required' => 'NIK must be filled',
            'no_ktp.required' => 'KTP must be filled',
        );
    }
}
