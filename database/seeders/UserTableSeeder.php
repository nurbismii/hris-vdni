<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Ramsey\Uuid\Uuid;

class UserTableSeeder extends Seeder
{
    public function run()
    {
        user::create([
            'id' => Uuid::uuid4()->getHex(),
            'nik_karyawan' =>  '15040001',
            'email' => 'hr-site@vdni.my.id',
            'password' => Hash::make('vdni678910'),
            'status' => 'aktif',
        ]);
    }
}
