<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'payment_transaction_id',
        'amount',
        'is_refund',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'is_refund' => 'boolean',
    ];

    // Relationships
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function paymentTransaction()
    {
        return $this->belongsTo(PaymentTransaction::class);
    }

    // Scopes
    public function scopePayments($query)
    {
        return $query->where('is_refund', false);
    }

    public function scopeRefunds($query)
    {
        return $query->where('is_refund', true);
    }

    public function scopeForBooking($query, $bookingId)
    {
        return $query->where('booking_id', $bookingId);
    }

    // Helper methods
    public function isRefund()
    {
        return $this->is_refund;
    }

    public function isPayment()
    {
        return !$this->is_refund;
    }
}