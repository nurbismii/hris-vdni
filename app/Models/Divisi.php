<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Divisi extends Model
{
    use HasFactory;

    protected $table = 'divisis';
    protected $guarded = [];

    public function departemen()
    {
        return $this->hasOne(departemen::class, 'id', 'departemen_id');
    }
}
