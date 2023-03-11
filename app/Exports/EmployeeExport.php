<?php

namespace App\Exports;

use App\Models\employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeeExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return employee::all();
    }

    public function headings(): array
    {
        return array(
            'NIK',
            'NO_KTP',
            'NAME',
            'DATE_OF_BIRTH',
            'COMPANY_NAME',
            'NPWP',
            'BPJS',
            'VACCINE',
        );
    }
}
