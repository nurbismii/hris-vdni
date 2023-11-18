<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mutasi extends Model
{
    use HasFactory;
    protected $table = 'mutasi';
    protected $guarded = [];

    public function employee()
    {
        return $this->hasOne(employee::class, 'nik', 'nik_karyawan');
    }

    public function posisi_lama()
    {
        return $this->hasOne(PosisiLama::class, 'mutasi_id', 'id');
    }
}
