<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Severancepay extends Model
{
    use HasFactory;
    protected $table = 'severance_pay';
    protected $guarded = [];

    public function employee()
    {
        return $this->hasOne(employee::class, 'nik', 'nik_karyawan');
    }

    public function spreport()
    {
        return $this->hasOne(SpReport::class, 'nik_karyawan', 'nik')->orderBy('no_sp', 'desc');
    }
}
