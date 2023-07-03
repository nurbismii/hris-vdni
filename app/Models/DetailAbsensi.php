<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailAbsensi extends Model
{
    use HasFactory;
    protected $table = 'detail_absensis';
    protected $guarded = [];

    public function periodeBulan()
    {
        return $this->hasOne(PeriodeBulan::class, 'id', 'periode_bulan_id');
    }
}