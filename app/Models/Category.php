<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['image_url'];

    // Accessor to get full image URL
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('Category_images/' . $this->image) : null;
    }

    public function subcategories()
    {
        return $this->hasMany(Subcategory::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }
}
