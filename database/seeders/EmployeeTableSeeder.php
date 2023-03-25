<?php

namespace Database\Seeders;

use App\Models\employee;
use Illuminate\Database\Seeder;

class EmployeeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        employee::Create([
            'nik' => '73737411311960004',
            'no_ktp' => '7402211501930002',
            'name' => 'Dummy Employee',
            'date_of_birth' => '1993-01-15',
            'company_name' =>  'VDNI',
            'npwp' => '760777268811000',
            'bpjs_ket' => '0002302217392',
            'bpjs_tk' => '15030419160',
            'vaccine' => '3',
            'entry_date' => '2015-09-16'
        ]);
    }
}
