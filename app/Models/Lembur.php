<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lembur extends Model
{
    use HasFactory;
    protected $table = 'lembur';
    protected $guarded = [];

    public function karyawan()
    {
        return $this->hasOne(employee::class, 'nik', 'nik_karyawan');
    }
}
