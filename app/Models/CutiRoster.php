<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CutiRoster extends Model
{
  use HasFactory;

  protected $table = 'cuti_roster';
  protected $guarded = [];

  public function karyawan()
  {
    return $this->hasOne(employee::class, 'nik', 'nik_karyawan');
  }

  public function periode_kerja()
  {
    return $this->hasOne(PeriodeKerjaRoster::class, 'cuti_roster_id', 'id');
  }
}
