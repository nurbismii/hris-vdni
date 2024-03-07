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
            'nik' => '15040001',
            'no_sk_pkwtt' => '',
            'nama_karyawan' => 'Administrator',
            'nama_ibu_kandung' => 'Dummy mom',
            'agama' => 'Islam',
            'no_ktp' => '7402211501930002',
            'no_kk' => '7402211501930022',
            'jenis_kelamin' => 'L',
            'status_perkawinan' => 'Belum Kawin',
            'status_karyawan' => 'PWKT',
            'no_telp' => '085282810040',
            'tgl_lahir' => '1993-01-15',
            'area_kerja' => 'VDNI',
            'golongan_darah' => 'AB',
            'entry_date' => '2015-09-16',
            'npwp' => '760777268811000',
            'bpjs_kesehatan' => '0002302217392',
            'bpjs_tk' => '15030419160',
            'vaksin' => '3',
            'jam_kerja' => '08.00 - 17.00',
        ]);
    }
}
