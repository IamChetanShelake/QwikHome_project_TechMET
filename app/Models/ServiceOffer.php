<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceOffer extends Model
{
    protected $guarded = [];
    
      protected $appends = ['image_url'];

    // Accessor to get full image URL (backward compatibility - returns first image)
     public function getImageUrlAttribute()
    {
        if ($this->image) {
            // If media column stores the image filename
            return asset('offer_images/' . $this->image);
        }
       
       else{
           return asset('offer_images/defaultOffer.jpg');
       }
    }

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

    public function frequencyOptionDiscounts()
    {
        return $this->hasMany(ServiceOfferFrequencyOptionDiscount::class);
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

    // Calculate discount for frequency option
    public function calculateDiscountedPriceForFrequencyOption($frequencyOption)
    {
        if ($this->discount_type === 'percentage') {
            return $frequencyOption->price_per_time * (1 - ($this->discount_value / 100));
        } else {
            return max(0, $frequencyOption->price_per_time - $this->discount_value);
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

    // Get discount price for a specific frequency option
    public function getDiscountedPriceForFrequencyOption($frequencyOption)
    {
        // First, check if there's a specific discount for this frequency option
        $frequencyOptionDiscount = $this->frequencyOptionDiscounts()
            ->where('frequency_option_id', $frequencyOption->id)
            ->first();

        if ($frequencyOptionDiscount) {
            return $frequencyOptionDiscount->discounted_price;
        }

        // Fallback to the old system for backward compatibility
        $frequencyType = $frequencyOption->frequency_type;
        return $this->getDiscountedPriceForFrequency($frequencyType);
    }

    // Get all discounted prices grouped by frequency type
    public function getDiscountedPricesByFrequencyType()
    {
        $result = [];

        // Get the new discount records
        foreach ($this->frequencyOptionDiscounts as $discount) {
            $frequencyType = $discount->frequencyOption->frequency_type;
            if (!isset($result[$frequencyType])) {
                $result[$frequencyType] = [];
            }
            $result[$frequencyType][] = [
                'frequency_option_id' => $discount->frequency_option_id,
                'original_price' => $discount->frequencyOption->price_per_time,
                'discounted_price' => $discount->discounted_price,
                'no_of_times' => $discount->frequencyOption->no_of_times,
                'duration' => $discount->frequencyOption->duration
            ];
        }

        // Add any old format discounts that might still exist
        $oldDiscounts = [
            'onetime' => $this->discounted_price_onetime,
            'weekly' => $this->discounted_price_weekly,
            'monthly' => $this->discounted_price_monthly,
            'yearly' => $this->discounted_price_yearly,
        ];

        foreach ($oldDiscounts as $type => $price) {
            if ($price !== null && !isset($result[$type])) {
                $result[$type] = $price;
            }
        }

        return $result;
    }
}
