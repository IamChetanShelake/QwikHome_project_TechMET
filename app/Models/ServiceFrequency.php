<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceFrequency extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    protected $casts = [
        'description' => 'json',
        'days_multiplier' => 'integer',
    ];

    // Relationship with service addons
    public function serviceAddons()
    {
        return $this->hasMany(ServiceAddon::class, 'frequency_id');
    }

    // Relationship with subscription plans
    public function subscriptionPlans()
    {
        return $this->hasMany(ServiceSubscriptionPlan::class, 'billing_frequency_id');
    }

    // Relationship with cart items
    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'service_frequency_id');
    }

    // Scope for active frequencies
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Get translated name
    public function getTranslatedNameAttribute()
    {
        return $this->description ? $this->description[app()->getLocale()] ?? $this->name : $this->name;
    }

    // Get translated description
    public function getTranslatedDescriptionAttribute()
    {
        return $this->description ? $this->description[app()->getLocale()] ?? null : null;
    }
}
