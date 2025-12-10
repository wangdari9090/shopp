<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
    'title',
    'description',
    'category_id',
    'price',
    'discount_price',
    'quantity',
    'sku',
    'tags',
    'status',
    'image',
];

}
