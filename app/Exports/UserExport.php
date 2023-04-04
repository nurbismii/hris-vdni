<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return User::select('name', 'email', 'password', 'status', 'employee_id')->take(0)->get();
    }

    public function headings(): array
    {
        return array(
            'NAME',
            'EMAIL',
            'PASSWORD',
            'STATUS',
            'NIK',
        );
    }
}
