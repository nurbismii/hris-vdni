<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpReport extends Model
{
    use HasFactory;
    protected $table = 'sp_report';
    protected $guarded = [];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'nik_karyawan', 'nik');
    }
}
