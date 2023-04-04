<?php

namespace App\Imports;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Ramsey\Uuid\Uuid;

class UsersImport implements ToCollection, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $collection)
    {
        $datas = array();
        foreach ($collection as $collect) {
            $datas[] = array(
                'id' => Uuid::uuid4()->getHex(),
                'name' => $collect['name'],
                'email' => $collect['email'],
                'password' => Hash::make($collect['password']),
                'status' => $collect['status'],
                'employee_id' => $collect['nik'],
            );
        }
        foreach (array_chunk($datas, 1000) as $chunk) {
            User::insert($chunk);
        }
    }

    public function rules(): array
    {
        return [
            'nik' => 'required',
            'email' => 'required|unique:users,email',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'nik.required' => 'NIK must filled',
            'email.required' => 'NIK must be filled',
            'email.unique' => 'NIK has been registration'
        ];
    }
}
