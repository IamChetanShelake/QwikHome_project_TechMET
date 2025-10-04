<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Process extends Model
{
    protected $fillable = [
        'service_id',
        'title',
        'description',
        'image',
        'order'
    ];

    /**
     * Get the service that owns the process.
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
