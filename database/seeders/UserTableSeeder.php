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
            'name' =>  'Administrator',
            'employee_id' => '123123123',
            'email' => 'hrdevelopment@vdni.com',
            'password' => Hash::make('vdni@200303!'),
            'status' => 'ACTIVE',
        ]);
    }
}
