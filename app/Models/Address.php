<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'contact_details' => 'json',
        'address_details' => 'json',
        'is_default' => 'boolean',
    ];

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scope for default addresses
    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    // Accessor for full address string
    public function getFullAddressAttribute()
    {
        $address = $this->address_details;
        if (!$address) return '';

        $parts = [];
        if (isset($address['street'])) $parts[] = $address['street'];
        if (isset($address['city'])) $parts[] = $address['city'];
        if (isset($address['state'])) $parts[] = $address['state'];
        if (isset($address['zip'])) $parts[] = $address['zip'];
        if (isset($address['country'])) $parts[] = $address['country'];

        return implode(', ', $parts);
    }

    // Get contact name
    public function getContactNameAttribute()
    {
        return $this->contact_details['name'] ?? '';
    }

    // Get contact phone
    public function getContactPhoneAttribute()
    {
        return $this->contact_details['phone'] ?? '';
    }
}
