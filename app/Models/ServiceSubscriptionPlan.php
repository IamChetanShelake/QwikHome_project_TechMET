<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Service;
use App\Models\ServiceFrequency;
use App\Models\ServiceAddon;
use App\Models\Cart;

class ServiceSubscriptionPlan extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'description' => 'json',
        'base_price' => 'decimal:2',
        'setup_fee' => 'decimal:2',
        'discount_percentage' => 'decimal:2',
        'included_addons' => 'json',
        'custom_configurations' => 'json',
        'auto_renew' => 'boolean',
    ];

    // Relationships
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function billingFrequency()
    {
        return $this->belongsTo(ServiceFrequency::class, 'billing_frequency_id');
    }

    // Included add-ons
    public function addOns()
    {
        return $this->belongsToMany(ServiceAddon::class, 'subscription_plan_included_addons', 'subscription_plan_id', 'addon_id');
    }

    // Cart items
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Accessors
    public function getTranslatedNameAttribute()
    {
        return $this->description && isset($this->description[app()->getLocale()]) ?
            $this->description[app()->getLocale()]['name'] ?? $this->name : $this->name;
    }

    public function getTranslatedDescriptionAttribute()
    {
        return $this->description && isset($this->description[app()->getLocale()]) ?
            $this->description[app()->getLocale()]['description'] ?? '' : '';
    }

    public function getComputedTotalPriceAttribute()
    {
        $price = $this->base_price;
        if ($this->discount_percentage > 0) {
            $price -= ($price * $this->discount_percentage / 100);
        }
        return $price;
    }

    // Check if plan is expired
    public function isExpired()
    {
        // Implementation based on business logic
        return false; // Customize based on requirements
    }
}
