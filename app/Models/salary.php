<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class salary extends Model
{
    use HasFactory;

    protected $table = 'salaries';
    protected $guarded = [];

    protected $casts = [
        'id' => 'string'
    ];

    public function employee()
    {
        return $this->hasOne(employee::class, 'nik', 'created_by');
    }
}
