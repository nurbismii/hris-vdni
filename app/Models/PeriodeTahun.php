<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodeTahun extends Model
{
    use HasFactory;
    protected $table = 'periode_tahuns';
    protected $guarded = [];

    public function periode_bulan()
    {
        return $this->hasMany(PeriodeBulan::class, 'periode_tahun_id', 'id');
    }
}
