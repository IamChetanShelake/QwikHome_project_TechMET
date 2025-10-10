<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceProviderReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'reviewer_id',
        'service_provider_id',
        'rating',
        'comment'
    ];

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function serviceProvider()
    {
        return $this->belongsTo(User::class, 'service_provider_id');
    }
}
