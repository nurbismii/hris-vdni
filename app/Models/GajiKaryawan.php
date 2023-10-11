<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GajiKaryawan extends Model
{
    use HasFactory;

    protected $table = 'gaji_karyawan';
    protected $guarded = [];
    protected $primaryKey = 'nik_karyawan';

    public function employee()
    {
        return $this->hasOne(employee::class, 'nik', 'nik_karyawan');
    }

    public function precense()
    {
        return $this->hasMany(Absensi::class, 'nik', 'nik_karyawan');
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'nik_karyawan', 'nik');
    }

    public function cutiIzin()
    {
        return $this->hasMany(CutiIzin::class, 'nik_karyawan', 'nik');
    }
}
