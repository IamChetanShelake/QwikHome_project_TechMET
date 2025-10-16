<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServiceOfferFrequencyOptionDiscount extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_offer_id',
        'frequency_option_id',
        'discounted_price',
    ];

    protected $casts = [
        'discounted_price' => 'decimal:2',
    ];

    public function serviceOffer()
    {
        return $this->belongsTo(ServiceOffer::class);
    }

    public function frequencyOption()
    {
        return $this->belongsTo(ServiceFrequencyOption::class);
    }
}
