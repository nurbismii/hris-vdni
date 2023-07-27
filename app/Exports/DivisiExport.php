<?php

namespace App\Exports;

use App\Models\Divisi;
use Maatwebsite\Excel\Concerns\FromCollection;

class DivisiExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Divisi::all();
    }
}
