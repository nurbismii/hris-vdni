<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KaryawanRoster extends Model
{
    use HasFactory;
    protected $table = 'karyawan_rosters';
    protected $guarded = [];

    public function periode()
    {
        return $this->hasOne(PeriodeRoster::class);
    }

    public function karyawan()
    {
        return $this->hasOne(employee::class, 'nik', 'nik_karyawan');
    }
}
