<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class BookingApiController extends Controller
{
    /**
     * POST API: Get booking options (dates, times, and service providers)
     */
    public function getBookingOptions(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user' => 'required|exists:users,id',
                'service' => 'required|exists:services,id'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'status_code' => 400,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 400);
            }

            $customerId = $request->user;
            $serviceId = $request->service;

            // Generate available dates (next 30 days)
            $dates = [];
            $currentDate = Carbon::now();
            for ($i = 0; $i <= 30; $i++) {
                $date = $currentDate->copy()->addDays($i);
                $dates[] = [
                    'date' => $date->format('Y-m-d'),
                    'day' => $date->format('l'), // Full day name
                    'formatted' => $date->format('M j, Y') // e.g., "Oct 19, 2025"
                ];
            }

            // Generate available time slots (9 AM to 6 PM, hourly)
            $times = [];
            $startTime = Carbon::createFromTime(9, 0); // 9:00 AM
            $endTime = Carbon::createFromTime(18, 0); // 6:00 PM

            while ($startTime <= $endTime) {
                $times[] = [
                    'time' => $startTime->format('H:i'),
                    'formatted' => $startTime->format('h:i A') // e.g., "09:00 AM"
                ];
                $startTime->addHour();
            }

            // Get service providers who previously served this customer for this specific service
            $serviceProviders = User::where('role', 'serviceprovider')
                ->whereHas('bookingsAsServiceProvider', function ($query) use ($customerId, $serviceId) {
                    $query->where('customer_id', $customerId)
                        ->where('service_id', $serviceId)
                        ->where('status', '!=', 'cancelled');
                })
                ->with(['bookingsAsServiceProvider' => function ($query) use ($customerId, $serviceId) {
                    $query->where('customer_id', $customerId)
                        ->where('service_id', $serviceId)
                        ->where('status', '!=', 'cancelled')
                        ->select('service_provider_id', 'scheduled_date', 'status', 'created_at')
                        ->orderBy('created_at', 'desc');
                }])
                ->select('id', 'name', 'email', 'phone', 'image', 'average_rating')
                ->get();

            // Format service providers data
            $providersData = $serviceProviders->map(function ($provider) {
                $latestBooking = $provider->bookingsAsServiceProvider->first();

                return [
                    'id' => $provider->id,
                    'name' => $provider->name,
                    'email' => $provider->email,
                    'phone' => $provider->phone,
                    'image' => $provider->image_url,
                    'average_rating' => $provider->average_rating ?? 0,
                    'last_service_date' => $latestBooking ? $latestBooking->scheduled_date : null,
                    'last_booking_status' => $latestBooking ? $latestBooking->status : null,
                    'total_services_for_customer' => $provider->bookingsAsServiceProvider->count()
                ];
            });

            // Add real service providers from users table if no providers with history found
            if ($providersData->isEmpty()) {
                $fallbackProviders = User::where('role', 'serviceprovider')
                    ->select('id', 'name', 'email', 'phone', 'image', 'average_rating')
                    ->take(10) // Limit to 10 providers for performance
                    ->get();

                $providersData = $fallbackProviders->map(function ($provider) {
                    return [
                        'id' => $provider->id,
                        'name' => $provider->name,
                        'email' => $provider->email,
                        'phone' => $provider->phone,
                        'image' => $provider->image_url,
                        'average_rating' => $provider->average_rating ?? 0,
                        'last_service_date' => null, // No history with this customer yet
                        'last_booking_status' => null, // No history with this customer yet
                        'total_services_for_customer' => 0 // No history with this customer yet
                    ];
                });
            }

            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Booking options retrieved successfully',
                'data' => [
                    'dates' => $dates,
                    'times' => $times,
                    'service_providers' => $providersData
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'message' => 'Failed to retrieve booking options',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    /**
     * POST API: Create a new booking with cart integration
     */
    public function createBooking(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user' => 'required|exists:users,id', // Customer
                'cartid' => 'required|exists:cart_items,id',
                'scheduledDate' => 'required|date|after_or_equal:today',
                'preferredTime' => 'required|date_format:H:i',
                'serviceProviderId' => 'nullable|exists:users,id',
                'customerNotes' => 'nullable|string|max:1000',
                'bookingType' => 'nullable|in:onetime,subscription',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'status_code' => 400,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 400);
            }

            $customerId = $request->user;

            // Fetch the specific cart item and ensure it belongs to the user
            $cartItem = \App\Models\CartItem::with(['cart', 'serviceFrequency', 'service.vendor'])
                ->where('id', $request->cartid)
                ->whereHas('cart', function ($query) use ($customerId) {
                    $query->where('user_id', $customerId);
                })
                ->first();

            if (!$cartItem) {
                return response()->json([
                    'success' => false,
                    'status_code' => 400,
                    'message' => 'Cart item not found or does not belong to user'
                ], 400);
            }

            // Get the cart reference for later use
            $cart = $cartItem->cart;

            // Optional: Validate service_provider availability if provided
            if ($request->serviceProviderId) {
                $existingBooking = Booking::where('service_provider_id', $request->serviceProviderId)
                    ->where('scheduled_date', $request->scheduledDate)
                    ->where('start_time', $request->preferredTime)
                    ->where('status', '!=', 'cancelled')
                    ->first();

                if ($existingBooking) {
                    return response()->json([
                        'success' => false,
                        'status_code' => 409,
                        'message' => 'Selected service provider is not available at this time slot'
                    ], 409);
                }
            }

            // Calculate totals from the specific cart item
            $totalAmount = $cartItem->total_price ?? 0;
            $totalDiscount = $cartItem->discount_amount ?? 0;
            $totalTax = $cartItem->tax_amount ?? 0;

            // Create booking record
            $booking = Booking::create([
                'service_id' => $cartItem->item_id, // Add the missing service_id from cart item
                'customer_id' => $customerId,
                'service_provider_id' => $request->serviceProviderId,
                'vendor_id' => $cartItem->service->vendor_id ?? null, // Get vendor_id from service
                'scheduled_date' => $request->scheduledDate,
                'start_time' => $request->preferredTime,
                'end_time' => Carbon::parse($request->preferredTime)->addHour()->format('H:i'), // assuming 1 hr
                'status' => 'pending',
                'payment_status' => 'pending',
                'price' => $totalAmount - $totalDiscount - $totalTax, // optional breakdown
                'discount_amount' => $totalDiscount,
                'tax_amount' => $totalTax,
                'total_amount' => $totalAmount,
                'currency' => 'AED', // default currency
                'booking_type' => $request->bookingType ?? 'onetime',
                'customer_notes' => $request->customerNotes,
                'booking_reference' => 'BOOK-' . strtoupper(uniqid()), // generate reference
            ]);

            // Store cart item data for response before deletion
            $bookedItemData = [
                'id' => $cartItem->id,
                'item_name' => $cartItem->item_name,
                'total_price' => $cartItem->total_price,
            ];

            // Delete the specific cart item from database
            $cartItem->delete();

            // Check if cart is now empty and delete it if so
            $remainingItems = $cart->items()->count();
            if ($remainingItems === 0) {
                $cart->delete();
                $cartDeleted = true;
            } else {
                $cartDeleted = false;
            }

            return response()->json([
                'success' => true,
                'status_code' => 201,
                'message' => 'Booking created successfully',
                'data' => [
                    'booking' => $booking,
                    'booked_item' => $bookedItemData,
                    'cart_deleted' => $cartDeleted
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'message' => 'Failed to create booking',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * POST API: booking history for a user
     */
    public function bookingHistory(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user' => 'required|exists:users,id', // Customer
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'status_code' => 400,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 400);
            }

            $customerId = $request->user;

            // Fetch bookings for the user
            $bookings = Booking::with(['service', 'serviceProvider'])
                ->where('customer_id', $customerId)
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Booking history retrieved successfully',
                'data' => $bookings
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'message' => 'Failed to retrieve booking history',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
