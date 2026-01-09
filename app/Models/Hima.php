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
        'plan',
        'payment_status',
        'trial_expires_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_user_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}