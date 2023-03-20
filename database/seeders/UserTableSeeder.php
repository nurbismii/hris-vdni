<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    public function run()
    {
        user::create([
            'name' =>  'Administrator',
            'employee_id' => '123123123',
            'email' => 'hrdevelopment@vdni.com',
            'password' => Hash::make('vdni@200303!'),
            'status' => 'ACTIVE',
        ]);
    }
}
