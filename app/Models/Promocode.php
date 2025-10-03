<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promocode extends Model
{
    protected $fillable = [
        'code',
        'discount',
        'for_active_subscription',
        'is_used',
        'expiry_date',
    ];

    protected $casts = [
        'discount' => 'decimal:2',
        'for_active_subscription' => 'boolean',
        'is_used' => 'boolean',
        'expiry_date' => 'datetime',
    ];
}
