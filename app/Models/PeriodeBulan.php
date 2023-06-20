<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodeBulan extends Model
{
    use HasFactory;
    protected $table = 'periode_bulans';
    protected $guarded = [];

    public function periode_tahun()
    {
        return $this->belongsTo(PeriodeTahun::class, 'periode_tahun_id', 'id');
    }
}
