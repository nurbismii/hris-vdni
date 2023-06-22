<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class employee extends Model
{
    use HasFactory;

    protected $table = 'employees';
    protected $primaryKey = 'nik';
    protected $guarded = [];

    public function user()
    {
        return $this->hasOne(user::class, 'nik_karyawan', 'nik');
    }

    public function divisi()
    {
        return $this->hasOne(Divisi::class, 'id', 'divisi_id');
    }

    public function detailAbsen()
    {
        return $this->hasMany(DetailAbsensi::class, 'nik_karyawan', 'nik');
    }

    public function keteranganAbsen()
    {
        return $this->hasMany(KeteranganAbsensi::class, 'nik_karyawan', 'nik');
    }
}
