<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfileChangeRequest extends Model
{
    protected $guarded = [];

    protected $casts = [
        'requested_data' => 'array',
        'approved_at' => 'datetime'
    ];
    
     protected $appends = ['image_url'];

    // Accessor to get full image URL
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('user_images/' . $this->image) : null;
    }

    // Relationship with service provider
    public function serviceProvider()
    {
        return $this->belongsTo(User::class, 'service_provider_id');
    }

    // Relationship with admin who approved/rejected
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
