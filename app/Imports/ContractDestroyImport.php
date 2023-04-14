<?php

namespace App\Imports;

use App\Models\Contract;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ContractDestroyImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        Contract::where('nik', $row['nik'])->chunkById(1000, function ($contracts) {
            foreach ($contracts as $contract) {
                $contract->delete();
            }
        });
    }
}
