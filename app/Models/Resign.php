<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resign extends Model
{
    use HasFactory;

    protected $table = 'resign';
    protected $guarded = [];

    public function employee()
    {
        return $this->hasOne(employee::class, 'nik', 'nik_karyawan');
    }
}
