<?php

namespace App\Imports;

use App\Models\employee;
use App\Models\KaryawanRoster;
use App\Models\Pengingat;
use App\Models\salary;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class EmployeesDeleteImport implements ToModel, WithHeadingRow, WithValidation
{
    protected $employee;

    public function __construct()
    {
        $this->employee = employee::select('nik', 'no_ktp')->get();
    }

    public function model(array $row)
    {
        employee::where('nik', $row['nik'])->chunkById(1000, function ($employees) {
            foreach ($employees as $employee) {
                $employee->delete();
            }
        });
        User::where('nik_karyawan', $row['nik'])->chunkById(1000, function ($users){
            foreach($users as $user){
                $user->delete();
            }
        });
        salary::where('employee_id', $row['nik'])->chunkById(1000, function ($salary){
            foreach($salary as $salary){
                $salary->delete();
            }
        });
        Pengingat::where('nik_karyawan', $row['nik'])->chunkById(1000, function ($reminders){
            foreach($reminders as $reminder){
                $reminder->delete();
            }
        });
        KaryawanRoster::where('nik_karyawan', $row['nik'])->chunkById(1000, function ($karyawanRoster){
            foreach($karyawanRoster as $kr){
                $kr->delete();
            }
        });
    }


    public function rules(): array
    {
        return array(
            'nik' => 'required',
        );
    }

    public function customValidationMessages()
    {
        return array(
            'nik.required' => 'NIK must be filled',
        );
    }
}
