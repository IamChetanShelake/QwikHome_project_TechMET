<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentStatusHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_transaction_id',
        'old_status',
        'new_status',
        'changed_by',
        'change_reason',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    // Relationships
    public function paymentTransaction()
    {
        return $this->belongsTo(PaymentTransaction::class);
    }

    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }

    // Scopes
    public function scopeForTransaction($query, $transactionId)
    {
        return $query->where('payment_transaction_id', $transactionId);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('new_status', $status);
    }

    // Helper methods
    public function getStatusChange()
    {
        return $this->old_status . ' → ' . $this->new_status;
    }

    public function wasStatusChangedFrom($status)
    {
        return $this->old_status === $status;
    }

    public function wasStatusChangedTo($status)
    {
        return $this->new_status === $status;
    }
}