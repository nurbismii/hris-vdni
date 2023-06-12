<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LokasiAbsen extends Model
{
    use HasFactory;
    protected $table = 'lokasi_absens';
    protected $guarded = [];

    public function divisi()
    {
        return $this->hasOne(Divisi::class, 'id', 'divisi_id');
    }
}
