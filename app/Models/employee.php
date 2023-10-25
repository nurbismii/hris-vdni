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
        return $this->hasMany(DetailAbsensi::class, 'nik_karyawan', 'nik')->orderBy('akhir_periode', 'ASC');
    }

    public function keteranganAbsen()
    {
        return $this->hasMany(KeteranganAbsensi::class, 'nik_karyawan', 'nik');
    }

    public function provinsi()
    {
        return $this->hasOne(Provinsi::class, 'id', 'provinsi_id');
    }

    public function kabupaten()
    {
        return $this->hasOne(Kabupaten::class, 'id', 'kabupaten_id');
    }

    public function kecamatan()
    {
        return $this->hasOne(Kecamatan::class, 'id', 'kecamatan_id');
    }

    public function kelurahan()
    {
        return $this->hasOne(Kelurahan::class, 'id', 'kelurahan_id');
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'nik_karyawan', 'nik');
    }

    public function cutiIzin()
    {
        return $this->hasMany(CutiIzin::class, 'nik_karyawan', 'nik');
    }

    public function gajiKaryawan()
    {
        return $this->hasOne(GajiKaryawan::class, 'nik_karyawan', 'nik');
    }

    public function spreport()
    {
        return $this->hasOne(SpReport::class, 'nik_karyawan', 'nik')->orderBy('no_sp', 'desc');
    }
}
