<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laptop extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'brand',
        'processor',
        'ram',
        'storage',
        'display',
        'graphics',
        'operating_system',
        'color',
        'stock_quantity',
        'image',
        'images',
        'is_featured',
        'is_active'
    ];

    protected $casts = [
        'images' => 'array',
        'price' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_active' => 'boolean'
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock_quantity', '>', 0);
    }
}
