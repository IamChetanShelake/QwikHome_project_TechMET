<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\ServiceRequirement;
use App\Models\Process;
use App\Models\User;
use App\Models\Feedback;
use App\Models\ServiceReview;

class Service extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['image_url'];

    // Accessor to get full image URL
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('Service_images/' . $this->image) : null;
    }

    protected $casts = [
        'whats_include' => 'array',
        'price_onetime' => 'decimal:2',
        'price_weekly' => 'decimal:2',
        'price_monthly' => 'decimal:2',
        'price_yearly' => 'decimal:2',
        'is_arabic' => 'boolean',
        'qwikpick' => 'boolean',
        'beauty_and_easy' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function requirements()
    {
        return $this->hasMany(ServiceRequirement::class);
    }

    public function processes()
    {
        return $this->hasMany(Process::class)->orderBy('order');
    }

    // Many-to-many relationship with users (service providers and vendors)
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_services')->withTimestamps();
    }

    // Feedback relationships
    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }

    // Reviews relationships
    public function serviceReviews()
    {
        return $this->hasMany(ServiceReview::class);
    }

    // Average rating calculation
    public function getAverageRatingAttribute()
    {
        return $this->serviceReviews()->avg('rating') ?? 0;
    }
}
