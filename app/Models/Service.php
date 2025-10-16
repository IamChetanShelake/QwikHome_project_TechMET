<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\ServiceFrequencyOption;
use App\Models\ServiceRequirement;
use App\Models\Process;
use App\Models\User;
use App\Models\Wishlist;
use App\Models\Faq;
use App\Models\Feedback;
use App\Models\ServiceReview;

class Service extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['image_url', 'media_urls'];

    // Accessor to get full image URL (backward compatibility - returns first image)
    public function getImageUrlAttribute()
    {
        if ($this->media) {
            $mediaArray = is_array($this->media) ? $this->media : json_decode($this->media, true);
            if (is_array($mediaArray) && !empty($mediaArray)) {
                return asset('Service_images/' . $mediaArray[0]);
            }
        }
        return null;
    }

    // Accessor to get all media URLs
    public function getMediaUrlsAttribute()
    {
        if ($this->media) {
            $mediaArray = is_array($this->media) ? $this->media : json_decode($this->media, true);
            if (is_array($mediaArray)) {
                return array_map(function ($image) {
                    return asset('Service_images/' . $image);
                }, $mediaArray);
            }
        }
        return [];
    }

    protected $casts = [
        'whats_include' => 'array',
        'media' => 'array',
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
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class, 'service_id');
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

    // Materials relationship
    public function materials()
    {
        return $this->hasMany(ServiceMaterial::class);
    }

    // Offers relationship
    public function offers()
    {
        return $this->hasMany(ServiceOffer::class);
    }

    // Active offers
    public function activeOffers()
    {
        return $this->hasMany(ServiceOffer::class)->active();
    }

    // Frequency options relationship
    public function frequencyOptions()
    {
        return $this->hasMany(ServiceFrequencyOption::class);
    }

    // Get frequency options by type
    public function weeklyOptions()
    {
        return $this->frequencyOptions()->ofType('weekly');
    }

    public function monthlyOptions()
    {
        return $this->frequencyOptions()->ofType('monthly');
    }

    public function yearlyOptions()
    {
        return $this->frequencyOptions()->ofType('yearly');
    }

    // Average rating calculation
    public function getAverageRatingAttribute($value)
    {
        return (float) $value;
    }

    public function faq()
    {
        return $this->hasMany(Faq::class);
    }

    public function subscriptionPlans()
    {
        return $this->hasMany(ServiceFrequencyOption::class, 'service_id');
    }
}
