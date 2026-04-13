<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'scheduled_date' => 'datetime:Y-m-d H:i:s',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'completed_at' => 'datetime',
        'price' => 'decimal:2',
    ];

    // Relationships
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

     public function selectedFrequencyOption()
    {
        return $this->belongsTo(ServiceFrequencyOption::class, 'selected_frequency_option_id');
    }
    
    public function serviceProvider()
    {
        return $this->belongsTo(User::class, 'service_provider_id');
    }

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }
    
     public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function subscription()
    {
        return $this->belongsTo(UserSubscription::class, 'subscription_id');
    }

    public function parentBooking()
    {
        return $this->belongsTo(Booking::class, 'parent_booking_id');
    }

    public function childBookings()
    {
        return $this->hasMany(Booking::class, 'parent_booking_id');
    }

    public function bookingPayments()
    {
        return $this->hasMany(BookingPayment::class);
    }

    public function paymentTransactions()
    {
        return $this->hasManyThrough(PaymentTransaction::class, BookingPayment::class, 'booking_id', 'id', 'id', 'payment_transaction_id');
    }


    // Scope for filtering by status
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Scope for filtering by vendor
    public function scopeForVendor($query, $vendorId)
    {
        return $query->where('vendor_id', $vendorId);
    }

    // Scope for completed bookings
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    // Feedback relationship
    public function feedback()
    {
        return $this->hasOne(Feedback::class);
    }
    
     // Attendance relationship
    public function attendance()
    {
        return $this->hasOne(ServiceProviderAttendance::class);
    }

    // Generate booking reference
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            $booking->booking_reference = 'BK' . strtoupper(uniqid());
        });
    }
}
