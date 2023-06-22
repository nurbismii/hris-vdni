<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeteranganAbsensi extends Model
{
    use HasFactory;
    protected $table = 'keterangan_absensis';
    protected $guarded = [];

    public function periodeBulan()
    {
        return $this->hasOne(PeriodeBulan::class, 'periode_bulan_id', 'id');
    }
}
