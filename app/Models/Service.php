<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $guarded = [];


    protected $casts = [
        'whats_include' => 'array',
        'price_onetime' => 'decimal:2',
        'price_weekly' => 'decimal:2',
        'price_monthly' => 'decimal:2',
        'price_yearly' => 'decimal:2',
        'is_arabic' => 'boolean',
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
}
