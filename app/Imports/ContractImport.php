<?php

namespace App\Imports;

use App\Models\Contract;
use Maatwebsite\Excel\Concerns\ToModel;

class ContractImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Contract([
            //
        ]);
    }
}
