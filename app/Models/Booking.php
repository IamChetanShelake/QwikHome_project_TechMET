<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'scheduled_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'completed_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'price' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'refund_amount' => 'decimal:2',
        'cancellation_fee' => 'decimal:2',
        'payment_due_date' => 'date',
        'next_booking_date' => 'date',
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

    public function serviceProvider()
    {
        return $this->belongsTo(User::class, 'service_provider_id');
    }

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    // New payment and subscription relationships
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

    // Generate booking reference
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            $booking->booking_reference = 'BK' . strtoupper(uniqid());
        });
    }
}
