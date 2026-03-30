<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'description', 'price', 'stock_quantity', 'category_id',
        'is_featured', 'image', 'weight', 'dimensions', 'shipping_class',
        'rating_avg', 'total_reviews', 'sold_count', 'status',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'price' => 'decimal:2',
        'weight' => 'decimal:2',
        'rating_avg' => 'decimal:2',
    ];
}
