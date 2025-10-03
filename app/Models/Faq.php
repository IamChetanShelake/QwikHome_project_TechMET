<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Faq extends Model
{
    protected $fillable = [
        'service_id',
        'question',
        'answer',
        'status'
    ];

    /**
     * Relationship with Service model
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
