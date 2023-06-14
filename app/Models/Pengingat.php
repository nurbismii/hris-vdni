<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengingat extends Model
{
    use HasFactory;
    protected $table = 'pengingats';
    protected $guarded = [];

    public function periode()
    {
        return $this->hasOne(PeriodeRoster::class, 'id', 'periode_id');
    }
}
