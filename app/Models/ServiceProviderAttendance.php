<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServiceProviderAttendance extends Model
{
    use HasFactory;
    
  protected $table = 'serviceprovider_attendances';
//   protected $guarded = ['punchIn_time'];
protected $fillable = [
    'serviceProviderId',
    'bookingId',
    'status',
    'punchIn_time',
    'punchOut_time',
    'startImage',
    'startNotes',
    'midImage',
    'midNotes',
    'completionImage',
    'completionNotes',
    'totalTime',
    'startLatitude',
    'startLongitude',
    'completionLatitude',
    'completionLongitude',
    'additionalData',
];


    protected $casts = [
        'punchIn_time' => 'datetime',
        'punchOut_time' => 'datetime',
        'totalTime' => 'decimal:2',
        'startLatitude' => 'decimal:8',
        'startLongitude' => 'decimal:8',
        'completionLatitude' => 'decimal:8',
        'completionLongitude' => 'decimal:8',
        'additionalData' => 'array',
    ];

    protected $appends = [
        'start_image_url',
        'mid_image_url',
        'completion_image_url',
        'formatted_total_time',
    ];

    // Relationships
    public function serviceProvider()
    {
        return $this->belongsTo(User::class, 'serviceProviderId');
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class,'bookingId');
    }

    // Accessors for image URLs
    public function getStartImageUrlAttribute()
    {
        return $this->startImage ? asset('attendance_images/' . $this->startImage) : null;
    }

    public function getMidImageUrlAttribute()
    {
        return $this->midImage ? asset('attendance_images/' . $this->midImage) : null;
    }

    public function getCompletionImageUrlAttribute()
    {
        return $this->completionImage ? asset('attendance_images/' . $this->completionImage) : null;
    }

    public function getFormattedTotalTimeAttribute()
    {
        if (!$this->totalTime) {
            return null;
        }

        $hours = floor($this->totalTime);
        $minutes = ($this->totalTime - $hours) * 60;

        if ($hours > 0) {
            return sprintf('%dh %dm', $hours, round($minutes));
        } else {
            return sprintf('%dm', round($minutes));
        }
    }

    // Helper methods
    public function punchIn($startImage, $startNotes = null, $latitude = null, $longitude = null)
    {
        $this->update([
            'status' => 'punchedIn',
            'punchIn_time' => now(),
            'startImage' => $startImage,
            'startNotes' => $startNotes,
            'startLatitude' => $latitude,
            'startLongitude' => $longitude,
        ]);

        // Update booking status to ongoing
        $this->booking->update(['status' => 'ongoing']);

        return $this;
    }

    public function updateMidProgress($midImage = null, $midNotes = null)
    {
        $this->update([
            'status' => 'inProgress',
            'midImage' => $midImage,
            'midNotes' => $midNotes,
        ]);

        return $this;
    }

    public function punchOut($completionImage, $completionNotes = null, $latitude = null, $longitude = null)
    {
        $punchOutTime = now();
        $totalTime = abs($punchOutTime->diffInMinutes($this->punchIn_time)) / 60; // Convert to hours

        $this->update([
            'status' => 'punchedOut',
            'punchOut_time' => $punchOutTime,
            'completionImage' => $completionImage,
            'completionNotes' => $completionNotes,
            'completionLatitude' => $latitude,
            'completionLongitude' => $longitude,
            'totalTime' => round($totalTime, 2),
        ]);

        // Update booking status to completed
        $this->booking->update(['status' => 'completed']);

        return $this;
    }

    // Scopes
    public function scopeForProvider($query, $providerId)
    {
        return $query->where('serviceProviderId', $providerId);
    }

    public function scopeForBooking($query, $bookingId)
    {
        return $query->where('bookingId', $bookingId);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', ['punchedIn', 'inProgress']);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}
