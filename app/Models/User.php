<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // ✅ tambah
        'nim',
        'angkatan'  // ✅ tambah
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * ✅ Relasi: 1 user punya 1 data HIMA (jika user adalah pemilik HIMA)
     */
    public function hima()
    {
        return $this->hasOne(\App\Models\Hima::class, 'owner_user_id');
    }
}