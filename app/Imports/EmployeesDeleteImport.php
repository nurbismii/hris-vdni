<?php

namespace App\Imports;

use App\Models\employee;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class EmployeesDeleteImport implements ToCollection, WithHeadingRow, WithValidation
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

            if ($data) :
                $data->where('nik', $collect['nik'])->delete();
            endif;
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
