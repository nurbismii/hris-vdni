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
        return employee::select('nik', 'no_ktp', 'name', 'date_of_birth', 'company_name', 'npwp', 'bpjs_ket', 'bpjs_tk', 'vaccine', 'entry_date')->take(0)->get();
    }

    public function headings(): array
    {
        return array(
            'Nik',
            'No_ktp',
            'Name',
            'Date_of_birth',
            'Company_name',
            'Npwp',
            'Bpjs_kes',
            'Bpjs_tk',
            'Vaccine',
            'Entry_date'
        );
    }
}
