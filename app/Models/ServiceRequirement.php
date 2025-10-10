<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceRequirement extends Model
{
    protected $guarded = [];

    protected $appends = ['image_url'];

    // Accessor to get full image URL
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('Service_requirement_images/' . $this->image) : null;
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
