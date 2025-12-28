<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model {
    protected $fillable = ['user_id', 'total_price', 'status', 'receiver_address', 'receiver_phone'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id')
                    ->withDefault([
                        'product_title' => 'Deleted Product',
                        'product_price' => 0,
                        'product_image' => [] 
                    ]);
    }

    public function items() {
        return $this->hasMany(OrderItem::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
