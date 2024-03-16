<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosisiLama extends Model
{
    use HasFactory;
    protected $table = 'posisi_lama';
    protected $guarded = [];

    public function departemen()
    {
        return $this->hasOne(Departemen::class, 'id', 'departemen_id');
    }
}
