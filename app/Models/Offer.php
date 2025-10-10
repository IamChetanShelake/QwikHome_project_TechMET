<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $guarded = [
       
    ];

    protected $appends = ['image_url'];

    // Accessor to get full image URL
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('offer_images/' . $this->image) : null;
    }
}
