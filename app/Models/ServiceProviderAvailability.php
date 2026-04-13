<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceProviderAvailability extends Model
{
    protected $guarded = [];

    protected $casts = [
        'available_date' => 'datetime:Y-m-d H:i:s',
        'available_time' => 'datetime:H:i',
        'is_available' => 'boolean'
    ];

    public function serviceProvider()
    {
        return $this->belongsTo(User::class, 'service_provider_id');
    }
}
