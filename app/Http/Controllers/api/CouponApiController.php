<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\CartItem;
use Illuminate\Support\Facades\Validator;

class CouponApiController extends Controller
{
    /**
     * Apply coupon to a cart item
     */
    public function applyCoupons(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'user' => 'required|exists:users,id',
            'cartid' => 'required|exists:cart_items,id',
            'couponCode' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Find the cart item
        $cartItem = CartItem::where('user_id',$request->user)->find($request->cartid);
        if (!$cartItem) {
            return response()->json([
                'status' => false,
                'message' => 'Cart item not found'
            ], 404);
        }

        // Find the coupon by code
        $coupon = Coupon::where('code', $request->couponCode)
            ->where('status', 1)
            ->where('expiry_date', '>', now())
            ->first();

        if (!$coupon) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid or expired coupon code'
            ], 400);
        }

        // Check usage limit
        if ($coupon->usage_limit && $coupon->used_count >= $coupon->usage_limit) {
            return response()->json([
                'status' => false,
                'message' => 'Coupon usage limit exceeded'
            ], 400);
        }

        // Check if applicable to the service
        $serviceId = $cartItem->item_id;
        if ($coupon->applicable_to === 'specific_services') {
            if (!$coupon->service_ids || !in_array($serviceId, $coupon->service_ids)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Coupon not applicable to this service'
                ], 400);
            }
        }
        
        
        
       // --------- NEW COUPON ARRAY LOGIC ----------
    // Get already applied coupons (JSON column)
    $appliedCoupons = $cartItem->coupons ?? [];

    // Check if already applied
    if (in_array($coupon->code, $appliedCoupons)) {
        return response()->json([
            'status'  => false,
            'message' => 'This coupon is already applied'
        ], 400);
    }

    // Add coupon code to array
    $appliedCoupons[] = $coupon->code;

    // Save immediately
    $cartItem->coupons = $appliedCoupons;
    $cartItem->save();

        // Calculate discount
        $discountAmount = 0;
        if ($coupon->discount_type === 'percentage') {
            $discountAmount = ($cartItem->total_price * $coupon->discount_value) / 100;
        } elseif ($coupon->discount_type === 'flat') {
            $discountAmount = min($coupon->discount_value, $cartItem->total_price); // Ensure not more than total
        }

        // Update cart item discount
        $cartItem->update([
            'discount_amount' => $discountAmount,
            'total_price' => max(0, $cartItem->total_price - $discountAmount), // Ensure not negative
            'coupons_applied'=>1,
        ]);

        // Increment coupon usage
        $coupon->increment('used_count');

        // Recalculate cart totals
        $cart = $cartItem->cart;
        if ($cart) {
            $cart->recalculateTotals(); // Assuming this method exists
        }

        return response()->json([
            'status' => true,
            'message' => 'Coupon applied successfully',
            'data' => [
                'cart_item' => [
                    'id' => $cartItem->id,
                    'discount_amount' => $discountAmount,
                    'new_total_price' => $cartItem->total_price,
                ],
                'cart_totals' => $cart ? [
                    'total_amount' => $cart->total,
                    'total_items' => $cart->total_items,
                ] : null,
            ]
        ]);
    }
    
    /**
     * Remove coupon from a cart item
     */
    public function removeCoupon(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
             'user' => 'required|exists:users,id',
            'cartid' => 'required|exists:cart_items,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Find the cart item
        $cartItem = CartItem::where('user_id',$request->user)->find($request->cartid);
        if (!$cartItem) {
            return response()->json([
                'status' => false,
                'message' => 'Cart item not found'
            ], 404);
        }

        // Check if there's a discount applied
        if ($cartItem->discount_amount == 0) {
            return response()->json([
                'status' => false,
                'message' => 'No coupon discount applied to this item'
            ], 400);
        }

        // Remove the discount and restore original price
        $cartItem->update([
            'discount_amount' => 0,
            'total_price' => $cartItem->unit_price * $cartItem->quantity + $cartItem->addons_price + $cartItem->tax_amount,
        ]);

        // Recalculate cart totals
        $cart = $cartItem->cart;
        if ($cart) {
            $cart->recalculateTotals(); // Assuming this method exists
        }

        return response()->json([
            'status' => true,
            'message' => 'Coupon removed successfully',
            'data' => [
                'cart_item' => [
                    'id' => $cartItem->id,
                    'discount_amount' => 0,
                    'new_total_price' => $cartItem->total_price,
                ],
                'cart_totals' => $cart ? [
                    'total_amount' => $cart->total,
                    'total_items' => $cart->total_items,
                ] : null,
            ]
        ]);
    }
}