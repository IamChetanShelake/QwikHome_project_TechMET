<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total' => 'decimal:2',
        'expires_at' => 'datetime',
        'applied_coupons' => 'json',
        'cart_metadata' => 'json',
    ];

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with Cart Items
    public function items()
    {
        return $this->hasMany(CartItem::class)->orderBy('created_at');
    }

    // Active items only
    public function activeItems()
    {
        return $this->items()->where('status', 'active');
    }

    // Scope for active carts
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Scope for user carts (authenticated users)
    public function scopeUserCarts($query, $userId = null)
    {
        return $query->where('user_id', $userId ?? auth()->id());
    }

    // Scope for guest carts
    public function scopeGuestCarts($query, $sessionId)
    {
        return $query->where('session_id', $sessionId)->whereNull('user_id');
    }

    // Calculate totals
    public function recalculateTotals()
    {
        $items = $this->activeItems;

        $subtotal = $items->sum('total_price');
        $discountAmount = $items->sum('discount_amount');
        $taxAmount = $items->sum('tax_amount');

        $this->update([
            'subtotal' => $subtotal,
            'discount_amount' => $discountAmount,
            'tax_amount' => $taxAmount,
            'total' => $subtotal - $discountAmount + $taxAmount,
        ]);

        return $this;
    }

    // Check if cart is expired
    public function isExpired()
    {
        if (!$this->expires_at) return false;
        return now()->isAfter($this->expires_at);
    }

    // Get total items count
    public function getTotalItemsAttribute()
    {
        return $this->activeItems->sum('quantity');
    }

    // Transfer guest cart to user
    public function transferToUser($userId)
    {
        if ($this->user_id) return $this; // Already assigned to a user

        // Check if user already has a cart
        $existingCart = self::where('user_id', $userId)->where('status', 'active')->first();

        if ($existingCart) {
            // Merge items from this cart to existing cart
            foreach ($this->items as $item) {
                // Logic to merge or add items (you'd need to implement deduplication logic)
                $existingItem = $existingCart->items()
                    ->where('item_type', $item->item_type)
                    ->where('item_id', $item->item_id)
                    ->first();

                if ($existingItem) {
                    $existingItem->increment('quantity', $item->quantity);
                } else {
                    $item->update(['cart_id' => $existingCart->id]);
                }
            }

            // Recalculate totals for the merged cart
            $existingCart->recalculateTotals();

            // Delete this cart
            $this->delete();

            return $existingCart;
        } else {
            // Assign this cart to the user
            $this->update(['user_id' => $userId]);
            return $this->fresh();
        }
    }
}
