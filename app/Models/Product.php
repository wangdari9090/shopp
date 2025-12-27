<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'product_title',
        'product_description',
        'product_quantity',
        'product_price',
        'product_image',
        'is_popular',
        'category_id',
    ];
    protected $casts = [
    'product_image' => 'array',
    ];
public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function getIsNewAttribute()
    {
        return $this->created_at >= now()->subMinutes(1);
    }

}

