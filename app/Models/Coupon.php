<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $guarded = [];

    protected $casts = [
        'expiry_date' => 'datetime',
        'discount_value' => 'decimal:2',
        'used_count' => 'integer',
        'usage_limit' => 'integer',
        'status' => 'boolean',
    ];
}
