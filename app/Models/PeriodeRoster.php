<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodeRoster extends Model
{
    use HasFactory;
    protected $table = 'periode_rosters';
    protected $guarded = [];

    public function karyawanRoster()
    {
        return $this->hasMany(KaryawanRoster::class, 'periode_id', 'id');
    }

    public function pengingat()
    {
        return $this->hasOne(Pengingat::class, 'periode_id', 'id');
    }
}
