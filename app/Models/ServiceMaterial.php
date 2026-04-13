<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'material_name',
        'material_description',
        'applicable_to',
        'material_price',
        'material_image'
    ];

    protected $casts = [
        'material_price' => 'decimal:2',
    ];

    /**
     * Get the service that owns the material.
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Get the material image URL.
     */
    public function getImageUrlAttribute()
    {
        if ($this->material_image && file_exists(public_path('Material_images/' . $this->material_image))) {
            return asset('Material_images/' . $this->material_image);
        }
        return asset('images/default-material.png');
    }

    /**
     * Get human readable label for applicable_to field.
     */
    public function getApplicableToLabelAttribute()
    {
        return match($this->applicable_to) {
            
            'onetime' => 'One Time Service',
            'weekly' => 'Weekly Subscription',
            'monthly' => 'Monthly Subscription',
            'yearly' => 'Yearly Subscription',
            'all' => 'All Service Subscriptions',
            default => 'Unknown',
            
        };
    }
}
