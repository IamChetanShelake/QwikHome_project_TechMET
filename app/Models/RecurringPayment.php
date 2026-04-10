<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecurringPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'subscription_id',
        'booking_id',
        'amount',
        'currency',
        'status',
        'scheduled_date',
        'processed_date',
        'failed_date',
        'attempt_count',
        'max_attempts',
        'next_retry_date',
        'failure_reason',
        'transaction_id',
        'payment_method_id',
        'metadata',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'scheduled_date' => 'date',
        'processed_date' => 'date',
        'failed_date' => 'date',
        'next_retry_date' => 'date',
        'attempt_count' => 'integer',
        'max_attempts' => 'integer',
        'metadata' => 'array',
    ];

    // Relationships
    public function subscription()
    {
        return $this->belongsTo(UserSubscription::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function paymentTransaction()
    {
        return $this->belongsTo(PaymentTransaction::class, 'transaction_id');
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    // Scopes
    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    public function scopeProcessing($query)
    {
        return $query->where('status', 'processing');
    }

    public function scopeDueToday($query)
    {
        return $query->where('scheduled_date', now()->toDateString())
                    ->where('status', 'scheduled');
    }

    public function scopeOverdue($query)
    {
        return $query->where('scheduled_date', '<', now()->toDateString())
                    ->where('status', 'scheduled');
    }

    public function scopeForSubscription($query, $subscriptionId)
    {
        return $query->where('subscription_id', $subscriptionId);
    }

    // Helper methods
    public function isDue()
    {
        return $this->scheduled_date <= now()->toDateString() && $this->status === 'scheduled';
    }

    public function isOverdue()
    {
        return $this->scheduled_date < now()->toDateString() && $this->status === 'scheduled';
    }

    public function canRetry()
    {
        return $this->status === 'failed' && $this->attempt_count < $this->max_attempts;
    }

    public function markAsCompleted()
    {
        $this->update([
            'status' => 'completed',
            'processed_date' => now()->toDateString(),
        ]);
    }

    public function markAsFailed($reason = null)
    {
        $this->update([
            'status' => 'failed',
            'failed_date' => now()->toDateString(),
            'failure_reason' => $reason,
            'attempt_count' => $this->attempt_count + 1,
        ]);

        // Schedule retry if possible
        if ($this->canRetry()) {
            $this->scheduleRetry();
        }
    }

    public function scheduleRetry()
    {
        $retryDate = now()->addDays($this->attempt_count + 1); // Exponential backoff
        $this->update(['next_retry_date' => $retryDate->toDateString()]);
    }

    public function incrementAttempt()
    {
        $this->update(['attempt_count' => $this->attempt_count + 1]);
    }
}