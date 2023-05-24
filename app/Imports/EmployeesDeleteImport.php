<?php

namespace App\Imports;

use App\Models\employee;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class EmployeesDeleteImport implements ToModel, WithHeadingRow, WithValidation
{
    protected $employee;

    public function __construct()
    {
        $this->employee = employee::select('nik', 'no_ktp')->get();
    }

    public function model(array $row)
    {
        employee::where('nik', $row['nik'])->chunkById(1000, function ($employees) {
            foreach ($employees as $employee) {
                $employee->delete();
            }
        });
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
