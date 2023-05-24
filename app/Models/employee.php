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
}
