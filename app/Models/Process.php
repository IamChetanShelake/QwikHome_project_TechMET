<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Process extends Model
{
    protected $guarded = [];

    protected $appends = ['image_url'];

    // Accessor to get full image URL
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('Process_images/' . $this->image) : null;
    }

    /**
     * Get the service that owns the process.
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
