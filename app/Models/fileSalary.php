<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fileSalary extends Model
{
    use HasFactory;

    protected $table = 'file_salaries';
    protected $guarded = [];

    public function user()
    {
        return $this->hasOne(User::class, 'employee_id', 'user_id');
    }
}
