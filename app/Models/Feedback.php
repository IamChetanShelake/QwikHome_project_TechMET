<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $guarded = [];
    protected
        $table = 'feedbacks';

    protected $casts = [
        'rating_service' => 'integer',
        'rating_employee' => 'integer',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    // Helper method to render stars
    public static function renderStars($rating)
    {
        $stars = '';
        for ($i = 1; $i <= 5; $i++) {
            $stars .= ($i <= $rating) ? '★' : '☆';
        }
        return $stars . ' (' . $rating . ')';
    }
}
