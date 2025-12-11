<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
    'title',
    'description',
    'quantity',
    'price',
    'category',
    'image',
];
public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

}
