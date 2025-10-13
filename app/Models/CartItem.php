<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'item_description' => 'json',
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
        'scheduled_date' => 'date',
        'preferred_time' => 'datetime:H:i',
        'auto_renew' => 'boolean',
        'combo_services_config' => 'json',
        'combo_discount_applied' => 'json',
        'selected_addons' => 'json',
        'addon_details' => 'json',
        'base_price' => 'decimal:2',
        'addons_price' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'custom_configurations' => 'json',
        'customer_notes' => 'json',
        'special_requirements' => 'json',
        'item_metadata' => 'json',
    ];

    // Relationship with Cart
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    // Relationship with Service Frequency
    public function serviceFrequency()
    {
        return $this->belongsTo(ServiceFrequency::class, 'service_frequency_id');
    }

    // Relationship with Subscription Plan
    public function subscriptionPlan()
    {
        return $this->belongsTo(ServiceSubscriptionPlan::class, 'subscription_plan_id');
    }

    // Relationship with Combo Offer
    public function comboOffer()
    {
        return $this->belongsTo(ComboOffer::class, 'combo_offer_id');
    }

    // Relationship with Preferred Service Provider
    public function preferredServiceProvider()
    {
        return $this->belongsTo(User::class, 'preferred_service_provider_id');
    }

    // Polymorphic relationship with the actual item
    public function item()
    {
        return $this->morphTo(null, 'item_type', 'item_id');
    }

    // Scope for active items
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Get the actual service/subscription/combo model
    public function getServiceAttribute()
    {
        if ($this->item_type === 'service') {
            return Service::find($this->item_id);
        }
        return null;
    }

    public function getSubscriptionAttribute()
    {
        if ($this->item_type === 'subscription_plan') {
            return ServiceSubscriptionPlan::find($this->item_id);
        }
        return null;
    }

    public function getComboAttribute()
    {
        if ($this->item_type === 'combo_offer') {
            return ComboOffer::find($this->item_id);
        }
        return null;
    }

    // Calculate total price
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($cartItem) {
            $cartItem->total_price = ($cartItem->unit_price * $cartItem->quantity)
                                   + $cartItem->addons_price
                                   - $cartItem->discount_amount
                                   + $cartItem->tax_amount;
        });
    }

    // Check if item is valid
    public function isValid()
    {
        // Check if the referenced item still exists
        switch ($this->item_type) {
            case 'service':
                return Service::where('id', $this->item_id)->exists();
            case 'subscription_plan':
                return ServiceSubscriptionPlan::where('id', $this->item_id)->exists();
            case 'combo_offer':
                return ComboOffer::where('id', $this->item_id)->exists();
            default:
                return false;
        }
    }
}
