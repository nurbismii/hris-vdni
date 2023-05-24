<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'id',
        'nik_karyawan',
        'email',
        'password',
        'status',
        'terakhir_login'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'id' => 'string',
        'email_verified_at' => 'datetime',
    ];

    public function employee()
    {
        return $this->hasOne(employee::class, 'nik', 'nik_karyawan');
    }

    public function job()
    {
        return $this->hasOne(role::class, 'id', 'role_id');
    }

    public function salary()
    {
        return $this->hasOne(salary::class);
    }
}
