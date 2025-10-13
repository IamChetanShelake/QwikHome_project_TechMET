<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceFrequencyOption extends Model
{
    use HasFactory;
    
    protected $guarded = [];
    
    protected $casts = [
        'price_per_time' => 'decimal:2',
        'no_of_times' => 'integer',
        'duration' => 'integer',
    ];
    
    // Relationship with service
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    
    // Scope for frequency type
    public function scopeOfType($query, $type)
    {
        return $query->where('frequency_type', $type);
    }
}
