<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'provider',
        'is_default',
        'is_active',
        'card_last_four',
        'card_brand',
        'card_exp_month',
        'card_exp_year',
        'card_token',
        'bank_name',
        'account_number',
        'routing_number',
        'iban',
        'wallet_type',
        'wallet_identifier',
        'billing_name',
        'billing_email',
        'billing_phone',
        'billing_address',
        'billing_city',
        'billing_state',
        'billing_zip',
        'billing_country',
        'metadata',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'is_active' => 'boolean',
        'card_exp_month' => 'integer',
        'card_exp_year' => 'integer',
        'metadata' => 'array',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function paymentTransactions()
    {
        return $this->hasMany(PaymentTransaction::class);
    }

    public function userSubscriptions()
    {
        return $this->hasMany(UserSubscription::class);
    }

    public function recurringPayments()
    {
        return $this->hasMany(RecurringPayment::class);
    }

    // Scopes
    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // Helper methods
    public function isCreditCard()
    {
        return in_array($this->type, ['credit_card', 'debit_card']);
    }

    public function isBankTransfer()
    {
        return $this->type === 'bank_transfer';
    }

    public function isDigitalWallet()
    {
        return $this->type === 'digital_wallet';
    }

    public function getMaskedCardNumber()
    {
        if ($this->isCreditCard() && $this->card_last_four) {
            return '**** **** **** ' . $this->card_last_four;
        }
        return null;
    }

    public function getBillingAddressAttribute()
    {
        $address = [];
        if ($this->billing_address) $address[] = $this->billing_address;
        if ($this->billing_city) $address[] = $this->billing_city;
        if ($this->billing_state) $address[] = $this->billing_state;
        if ($this->billing_zip) $address[] = $this->billing_zip;
        if ($this->billing_country) $address[] = $this->billing_country;

        return implode(', ', $address);
    }
}