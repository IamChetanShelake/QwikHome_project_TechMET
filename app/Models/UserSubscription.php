<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSubscription extends Model
{
    use HasFactory;

    protected $table = 'user_subscriptions';
    protected $fillable = [
        'user_id',
        'subscription_plan_id',
        'service_id',
        'subscription_number',
        'status',
        'start_date',
        'end_date',
        'trial_end_date',
        'cancelled_at',
        'cancellation_reason',
        'billing_cycle',
        'billing_day',
        'base_price',
        'discount_amount',
        'tax_amount',
        'total_amount',
        'auto_renew',
        'next_billing_date',
        'failed_payment_count',
        'max_failed_payments',
        'payment_method_id',
        'last_payment_date',
        'last_payment_amount',
        'metadata',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'trial_end_date' => 'date',
        'cancelled_at' => 'datetime',
        'next_billing_date' => 'date',
        'last_payment_date' => 'date',
        'base_price' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'last_payment_amount' => 'decimal:2',
        'auto_renew' => 'boolean',
        'failed_payment_count' => 'integer',
        'max_failed_payments' => 'integer',
        'billing_day' => 'integer',
        'metadata' => 'array',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscriptionPlan()
    {
        return $this->belongsTo(ServiceSubscriptionPlan::class, 'subscription_plan_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'subscription_id');
    }

    public function paymentTransactions()
    {
        return $this->hasMany(PaymentTransaction::class, 'subscription_id');
    }

    public function recurringPayments()
    {
        return $this->hasMany(RecurringPayment::class);
    }

    public function billingCycles()
    {
        return $this->hasMany(SubscriptionBillingCycle::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    public function scopeExpired($query)
    {
        return $query->where('status', 'expired');
    }

    public function scopePaused($query)
    {
        return $query->where('status', 'paused');
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeDueForBilling($query)
    {
        return $query->where('next_billing_date', '<=', now()->toDateString())
                    ->where('auto_renew', true)
                    ->where('status', 'active');
    }

    // Helper methods
    public function isActive()
    {
        return $this->status === 'active';
    }

    public function isCancelled()
    {
        return $this->status === 'cancelled';
    }

    public function isExpired()
    {
        return $this->status === 'expired' || ($this->end_date && $this->end_date < now()->toDateString());
    }

    public function canBeCancelled()
    {
        return in_array($this->status, ['active', 'paused']);
    }

    public function canBePaused()
    {
        return $this->isActive() && $this->subscriptionPlan->pause_resume_allowed;
    }

    public function canBeResumed()
    {
        return $this->status === 'paused' && $this->subscriptionPlan->pause_resume_allowed;
    }

    public function getDaysUntilNextBilling()
    {
        return now()->diffInDays($this->next_billing_date, false);
    }

    public function cancel($reason = null)
    {
        $this->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
            'cancellation_reason' => $reason,
        ]);
    }

    public function pause()
    {
        if ($this->canBePaused()) {
            $this->update(['status' => 'paused']);
        }
    }

    public function resume()
    {
        if ($this->canBeResumed()) {
            $this->update(['status' => 'active']);
        }
    }

    public function incrementFailedPayments()
    {
        $newCount = $this->failed_payment_count + 1;
        $this->update(['failed_payment_count' => $newCount]);

        // Auto-cancel if too many failed payments
        if ($newCount >= $this->max_failed_payments) {
            $this->cancel('Too many failed payment attempts');
        }
    }

    public function resetFailedPayments()
    {
        $this->update(['failed_payment_count' => 0]);
    }
}