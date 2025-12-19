<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hima extends Model
{
    protected $fillable = [
        'owner_user_id',
        'name',
        'university',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_user_id');
    }
}