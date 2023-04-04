<?php

namespace App\Imports;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToCollection, WithHeadingRow
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
}
