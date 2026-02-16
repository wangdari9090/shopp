<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model {
    protected $fillable = [
    'user_id', 
    'user_order_number',
    'total_price', 
    'status', 
    'payment_method',
    'receiver_address', 
    'receiver_phone'];

    public function payment(): HasOne
        {
            return $this->hasOne(Payment::class);
        }
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
