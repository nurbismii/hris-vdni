<?php

namespace App\Exports;

use App\Models\divisi;
use Maatwebsite\Excel\Concerns\FromCollection;

class DivisiExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return divisi::all();
    }
}
