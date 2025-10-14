<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceOffer extends Model
{
    protected $guarded = [];

    protected $casts = [
        'discount_value' => 'decimal:2',
        'discounted_price_onetime' => 'decimal:2',
        'discounted_price_weekly' => 'decimal:2',
        'discounted_price_monthly' => 'decimal:2',
        'discounted_price_yearly' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active')
                    ->where(function ($q) {
                        $q->where('start_date', '<=', now())
                          ->orWhereNull('start_date');
                    })
                    ->where(function ($q) {
                        $q->where('end_date', '>=', now())
                          ->orWhereNull('end_date');
                    });
    }

    public function calculateDiscountedPrice($originalPrice, $frequencyType)
    {
        if ($this->discount_type === 'percentage') {
            return $originalPrice * (1 - ($this->discount_value / 100));
        } else {
            return max(0, $originalPrice - $this->discount_value);
        }
    }

    public function getDiscountedPriceForFrequency($frequencyType)
    {
        return match($frequencyType) {
            'onetime' => $this->discounted_price_onetime,
            'weekly' => $this->discounted_price_weekly,
            'monthly' => $this->discounted_price_monthly,
            'yearly' => $this->discounted_price_yearly,
            default => null
        };
    }
}
