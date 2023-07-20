<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CutiIzin extends Model
{
    use HasFactory;

    protected $table = 'cuti_izin';
    protected $guarded = [];

    public function karyawan()
    {
        return $this->hasOne(employee::class, 'nik', 'nik_karyawan');
    }
}
