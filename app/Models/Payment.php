<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'method',
        'bank_name',
        'account_number',
        'status',
        'transaction_id',
        'amount',
        'payload'
    ];
    protected $casts = [
        'payload' => 'array',
    ];
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
