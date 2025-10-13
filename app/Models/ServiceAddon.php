<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceAddon extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'description' => 'json',
        'price' => 'decimal:2',
        'is_required' => 'boolean',
        'is_active' => 'boolean',
        'quantity_limit' => 'integer',
        'options' => 'json',
    ];

    // Relationship with service
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    // Relationship with frequency
    public function frequency()
    {
        return $this->belongsTo(ServiceFrequency::class, 'frequency_id');
    }

    // Relationship with subscription plans that include this addon
    public function subscriptionPlans()
    {
        return $this->belongsToMany(ServiceSubscriptionPlan::class, 'subscription_plan_included_addons', 'addon_id', 'subscription_plan_id');
    }

    // Get translated name and description
    public function getTranslatedNameAttribute()
    {
        return $this->description && isset($this->description[app()->getLocale()]) ?
            $this->description[app()->getLocale()]['name'] ?? $this->name : $this->name;
    }

    public function getTranslatedDescriptionAttribute()
    {
        return $this->description && isset($this->description[app()->getLocale()]) ?
            $this->description[app()->getLocale()]['description'] ?? null : null;
    }

    // Scope for active add-ons
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope for required add-ons
    public function scopeRequired($query)
    {
        return $query->where('is_required', true);
    }

    // Get computed price (considering frequency if applicable)
    public function getComputedPriceAttribute()
    {
        if ($this->frequency && $this->frequency->days_multiplier) {
            // For recurring add-ons, calculate monthly equivalent
            return $this->price * (30 / $this->frequency->days_multiplier);
        }
        return $this->price;
    }

    // Check if quantity is valid
    public function isValidQuantity($quantity)
    {
        if ($this->quantity_limit && $quantity > $this->quantity_limit) {
            return false;
        }
        return $quantity > 0;
    }
}
