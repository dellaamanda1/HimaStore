<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'hima_id',
        'name',
        'price',
        'stock',
        'description',
        'is_internal_only',
        'restricted_angkatan',
        'image_path',
    ];

    protected $casts = [
        'is_internal_only' => 'boolean',
    ];

    /**
     * Produk ini milik HIMA mana
     */
    public function hima()
    {
        return $this->belongsTo(Hima::class);
    }
}