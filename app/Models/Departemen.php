<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departemen extends Model
{
    use HasFactory;

    protected $table = 'departemens';
    protected $guarded = [];

    public function perusahaan()
    {
        return $this->hasOne(Perusahaan::class, 'id', 'perusahaan_id');
    }
}
