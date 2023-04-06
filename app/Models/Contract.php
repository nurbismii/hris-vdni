<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $table = 'contracts';
    protected $primaryKey = 'no_pkwt';
    protected $guarded = [];

    protected $casts = [
        'no_pkwt' => 'string',
        'email_verified_at' => 'datetime',
    ];
}
