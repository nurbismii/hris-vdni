<?php

namespace App\Imports;

use App\Models\employee;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EmployeesImport implements ToModel, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function model(array $row)
    {
        return new employee([
            'employee_nik' => $row['Nik'],
            'no_ktp' => $row['No_KTP'],
            'name' => $row['Nama'],
            'npwp' => $row['No_NPWP'],
            'no_ktp' => $row['Tanggal_lahir'],
            'company_name' => $row['Nm_perusahaan'],
            'vaccine' => $row['Vaksin'],
            'bpjs_tk' => $row['NO_BPJS_TK'],
            'bpjs_ket' => $row['NO_BPJS_KES'],
            'entry_date' => $row['Tanggal_join'],
        ]);
    }
}
