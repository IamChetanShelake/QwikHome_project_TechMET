<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use App\Models\ServiceProviderAvailability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Notifications\BookingNotification;
    
class BookingApiController extends Controller
{
    /**
     *  POST API: Get booking options (dates, times, and service providers)
     */
     public function getBookingOptions(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user' => 'required|exists:users,id',
                'service' => 'required|exists:services,id',
                'serviceProvider' => 'nullable|exists:users,id',
                'date' => 'nullable|date|after_or_equal:today'
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
            $serviceProviderId = $request->serviceProvider;
            $selectedDate = $request->date ?? Carbon::now()->format('Y-m-d');

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

            // Generate available time slots (9 AM to 6 PM, hourly) with availability check
            $times = [];
            $startTime = Carbon::createFromTime(9, 0); // 9:00 AM
            $endTime = Carbon::createFromTime(18, 0); // 6:00 PM

            while ($startTime <= $endTime) {
                $timeSlot = $startTime->format('H:i');

                // If no service provider specified, all times are available
                if (!$serviceProviderId) {
                    $isAvailable = true;
                } else {
                    // Check if service provider is available for this date and time
                    $isAvailable = ServiceProviderAvailability::where('service_provider_id', $serviceProviderId)
                        ->where('available_date', $selectedDate)
                        ->where('available_time', $timeSlot)
                        ->where('is_available', true)
                        ->exists();
                }

                $times[] = [
                    'time' => $timeSlot,
                    'formatted' => $startTime->format('h:i A'), // e.g., "09:00 AM"
                    'available' => $isAvailable
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
    
//   public function getBookingOptions(Request $request)
//     {
//         try {
//             $validator = Validator::make($request->all(), [
//                 'user' => 'required|exists:users,id',
//                 'service' => 'required|exists:services,id'
//             ]);

//             if ($validator->fails()) {
//                 return response()->json([
//                     'success' => false,
//                     'status_code' => 400,
//                     'message' => 'Validation error',
//                     'errors' => $validator->errors()
//                 ], 400);
//             }

//             $customerId = $request->user;
//             $serviceId = $request->service;

//             // Generate available dates (next 30 days)
//             $dates = [];
//             $currentDate = Carbon::now();
//             for ($i = 0; $i <= 30; $i++) {
//                 $date = $currentDate->copy()->addDays($i);
//                 $dates[] = [
//                     'date' => $date->format('Y-m-d'),
//                     'day' => $date->format('l'), // Full day name
//                     'formatted' => $date->format('M j, Y') // e.g., "Oct 19, 2025"
//                 ];
//             }

//             // Generate available time slots (9 AM to 6 PM, hourly)
//             $times = [];
//             $startTime = Carbon::createFromTime(9, 0); // 9:00 AM
//             $endTime = Carbon::createFromTime(18, 0); // 6:00 PM

//             while ($startTime <= $endTime) {
//                 $times[] = [
//                     'time' => $startTime->format('H:i'),
//                     'formatted' => $startTime->format('h:i A') // e.g., "09:00 AM"
//                 ];
//                 $startTime->addHour();
//             }

//             // Get service providers who previously served this customer for this specific service
//             $serviceProviders = User::where('role', 'serviceprovider')
//                 ->whereHas('bookingsAsServiceProvider', function ($query) use ($customerId, $serviceId) {
//                     $query->where('customer_id', $customerId)
//                           ->where('service_id', $serviceId)
//                           ->where('status', '!=', 'cancelled');
//                 })
//                 ->with(['bookingsAsServiceProvider' => function ($query) use ($customerId, $serviceId) {
//                     $query->where('customer_id', $customerId)
//                           ->where('service_id', $serviceId)
//                           ->where('status', '!=', 'cancelled')
//                           ->select('service_provider_id', 'scheduled_date', 'status', 'created_at')
//                           ->orderBy('created_at', 'desc');
//                 }])
//                 ->select('id', 'name', 'email', 'phone', 'image', 'average_rating')
//                 ->get();

//             // Format service providers data
//             $providersData = $serviceProviders->map(function ($provider) {
//                 $latestBooking = $provider->bookingsAsServiceProvider->first();

//                 return [
//                     'id' => $provider->id,
//                     'name' => $provider->name,
//                     'email' => $provider->email,
//                     'phone' => $provider->phone,
//                     'image' => $provider->image_url,
//                     'average_rating' => $provider->average_rating ?? 0,
//                     'last_service_date' => $latestBooking ? $latestBooking->scheduled_date : null,
//                     'last_booking_status' => $latestBooking ? $latestBooking->status : null,
//                     'total_services_for_customer' => $provider->bookingsAsServiceProvider->count()
//                 ];
//             });

//             // Add sample service providers for testing if no real providers found
//             if ($providersData->isEmpty()) {
//                  $fallbackProviders = User::where('role', 'serviceprovider')
//                     ->select('id', 'name', 'email', 'phone', 'image', 'average_rating')
//                     ->take(2) // Limit to 10 providers for performance
//                     ->get();

//                 $providersData = $fallbackProviders->map(function ($provider) {
//                     return [
//                         'id' => $provider->id,
//                         'name' => $provider->name,
//                         'email' => $provider->email,
//                         'phone' => $provider->phone,
//                         'image' => $provider->image_url,
//                         'average_rating' => $provider->average_rating ?? 0,
//                         'last_service_date' => null, // No history with this customer yet
//                         'last_booking_status' => null, // No history with this customer yet
//                         'total_services_for_customer' => 0 // No history with this customer yet
//                     ];
//                 });
//             }

//             return response()->json([
//                 'success' => true,
//                 'status_code' => 200,
//                 'message' => 'Booking options retrieved successfully',
//                 'data' => [
//                     'dates' => $dates,
//                     'times' => $times,
//                     'service_providers' => $providersData
//                 ]
//             ], 200);
//         } catch (\Exception $e) {
//             return response()->json([
//                 'success' => false,
//                 'status_code' => 500,
//                 'message' => 'Failed to retrieve booking options',
//                 'error' => $e->getMessage()
//             ], 500);
//         }
//     }

    /**
     * POST API: Create a new booking
     */
     public function createBooking(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user' => 'required|exists:users,id',
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
            $cartItem = \App\Models\CartItem::with(['cart', 'serviceFrequency'])
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
            
            // Update the cart item with preferred time and date
            $cartItem->update([
                'scheduled_date' => $request->scheduledDate,
                'preferred_time' => $request->preferredTime,
            ]);

            // Get the cart reference for later use
            $cart = $cartItem->cart;
            
            // Check if this is a subscription-based booking
            $isSubscriptionBooking = false;
            $subscriptionId = null;

            if ($cartItem->service_frequency_id) {
                // Load the ServiceFrequencyOption to check its type
                $serviceFrequencyOption = \App\Models\ServiceFrequencyOption::find($cartItem->service_frequency_id);
                if ($serviceFrequencyOption && $serviceFrequencyOption->frequency_type !== 'onetime') {
                    $isSubscriptionBooking = true;

                    // Create a UserSubscription for recurring services
                    $subscription = \App\Models\UserSubscription::create([
                        'user_id' => $customerId,
                        'subscription_plan_id' => $cartItem->service_frequency_id, // May be null for frequency-based subscriptions
                        'service_id' => $cartItem->item_id,
                        'subscription_number' => 'SUB-' . strtoupper(uniqid()),
                        'status' => 'active',
                        'start_date' => now()->toDateString(),
                        'billing_cycle' => $serviceFrequencyOption->frequency_type, // weekly, monthly, yearly
                        'billing_day' => now()->day, // Use current day, can be customized later
                        'base_price' => $cartItem->base_price,
                        'discount_amount' => $cartItem->discount_amount ?? 0,
                        'tax_amount' => $cartItem->tax_amount ?? 0,
                        'total_amount' => $cartItem->total_price,
                        'auto_renew' => true,
                        'next_billing_date' => $this->calculateNextBillingDate($serviceFrequencyOption->frequency_type),
                        'payment_method_id' => 1, // Default payment method, should be passed or selected
                        'metadata' => [
                            'cart_item_id' => $cartItem->id,
                            'frequency_option_id' => $serviceFrequencyOption->id,
                            'providers_count' => $cartItem->providers_count,
                            'include_material' => $cartItem->include_material,
                            'selected_addons' => $cartItem->selected_addons,
                        ]
                    ]);

                    $subscriptionId = $subscription->id;
                }
            }

            // Optional: Validate service_provider availability if provided
            if ($request->serviceProviderId) {
                
                // Check if the service provider has set availability for this specific date and time
                $availabilityCheck = ServiceProviderAvailability::where('service_provider_id', $request->serviceProviderId)
                    ->where('available_date', $request->scheduledDate)
                    ->where('available_time', $request->preferredTime)
                    ->where('is_available', true)
                    ->exists();

                if (!$availabilityCheck) {
                    return response()->json([
                        'success' => false, 
                        'status_code' => 409,
                        'message' => 'Selected service provider is not available at this time slot'
                    ], 409);
                }

                // Check if service provider already has a conflicting booking
                $existingBooking = Booking::where('service_provider_id', $request->serviceProviderId)
                ->where('scheduled_date', $request->scheduledDate)
                    ->where('preferred_time', $request->preferredTime)
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
            $scheduledDate = $cartItem->scheduled_date ;
            $preferredTime = $cartItem->preferred_time ;

            // Create booking record
            
            $booking = Booking::create([
                 'service_id' => $cartItem->item_id, 
                 'selected_frequency_option_id' => $cartItem->service_frequency_id,
                'customer_id' => $customerId,
                'service_provider_id' => $request->serviceProviderId,
                  'vendor_id' => $cartItem->service->vendor_id ?? null, // Get vendor_id from service
                'scheduled_date' =>$scheduledDate,
                'preferred_time' => $preferredTime,
                // 'end_time' => Carbon::parse($request->preferredTime)->addHour()->format('H:i'), // assuming 1 hr
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'price' => $totalAmount - $totalDiscount - $totalTax, // optional breakdown
                'discount_amount' => $totalDiscount,
                'tax_amount' => $totalTax,
                'total_amount' => $totalAmount,
                'currency' => 'AED', // default currency
                'booking_type' => $request->bookingType ?? 'onetime',
                'subscription_id' => $cartItem->subscription_plan_id ?? null,
                'customer_notes' => $request->customerNotes,
                'booking_reference' => 'BOOK-' . strtoupper(uniqid()), // generate reference
                'created_at' => now()->format('Y-m-d H:i:s'),
                'updated_at' => now()->format('Y-m-d H:i:s'),
                
            ]);
            
            if($booking){
                
                $user = User::find($booking->customer_id);
                
            //       return response()->json([
            //     'success' => true,
            //     'status_code' => 200,
            //     'message' => 'user',
            //     'data' => $user,
            // ], 200);
            
                $user->notify(new BookingNotification(
                    'Booking Confirmed',                     // $title
                    'Your booking has been confirmed successfully!', // $description
                    $booking->id,                               // $bookingId
                    'booking_update'        //type
                    
                    ));
            }

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
            
            // Check service provider availability status if provided
            $isProviderAvailable = null;
            if ($request->serviceProviderId) {
                $isProviderAvailable = ServiceProviderAvailability::where('service_provider_id', $request->serviceProviderId)
                    ->where('available_date', $scheduledDate)
                    ->where('available_time', $preferredTime)
                    ->where('is_available', true)
                    ->exists();
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
                 'type' => 'nullable|in:all,upcoming,assigned,ongoing,completed,cancelled',
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
            $type = $request->type;

            // Fetch bookings for the user
            $query = Booking::with(['service', 'serviceProvider'])
                ->where('customer_id', $customerId);
                
                 $currentDate = Carbon::now()->format('Y-m-d');
                $currentTime = Carbon::now()->format('H:i:s');

            if ($type) {
                 
                switch ($type) {
                   case 'upcoming':
                      
                         $query->where(function ($q) {
                            $now = Carbon::now();
                            $today = $now->format('Y-m-d');
                            $currentTime = $now->format('H:i');
                             
                            // Future dates OR today with future times (regardless of status for provider's assigned bookings)
                            $q->where('scheduled_date', '>', $today)
                              ->orWhere(function ($subQ) use ($today, $currentTime) {
                                  $subQ->where('scheduled_date', $today)
                                       ->where('preferred_time', '>', $currentTime);
                              });
                              
                              //this means
                              //WHERE (
                              //scheduled_date > '2025-10-28'
                              //OR (scheduled_date = '2025-10-28' AND preferred_time > '15:00')
                              //)

                             
                        });
                    break;
                    case 'ongoing':
                        $query->where('status', 'ongoing');
                        break;
                    case 'completed':
                        $query->where('status', 'completed');
                        break;
                    case 'cancelled':
                        $query->where('status', 'cancelled');
                        break;
                }
            }

            $bookings = $query->orderBy('created_at', 'desc')->get();

            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Booking history retrieved successfully',
                'totalBookings'=>$bookings->count(),
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
    
    /**
     * POST API: List available bookings for a service provider
     */
    public function listAvailableBookings(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'serviceProvider' => 'required|exists:users,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'status_code' => 400,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 400);
            }

            $serviceProviderId = $request->serviceProvider;

            // Get services that this provider is assigned to
            $providerServices = \DB::table('user_services')
                ->where('user_id', $serviceProviderId)
                ->pluck('service_id');

            // Fetch available bookings (pending, no service provider assigned)
            $bookings = Booking::with([
                'customer' => function ($query) {
                    $query->select('id', 'name', 'email', 'phone', 'image')
                        ->with(['addresses' => function ($q) {
                            $q->default(); // Get default address
                        }]);
                },
                'service' => function ($query) {
                    $query->select('id', 'name', 'description', 'media', 'price_onetime', 'price_weekly', 'price_monthly', 'price_yearly');
                }
            ])
                ->where('status', 'pending')
                ->whereNull('service_provider_id')
                ->whereIn('service_id', $providerServices)
                ->orderBy('scheduled_date', 'asc')
                ->orderBy('preferred_time', 'asc')
                ->get();

            // Format the response data
            $formattedBookings = $bookings->map(function ($booking) {
                $defaultAddress = $booking->customer->addresses->first();

                return [
                    'booking_id' => $booking->id,
                    'booking_reference' => $booking->booking_reference,
                    'scheduled_date' => $booking->scheduled_date->format('y-m-d'),
                    'preferred_time' => $booking->preferred_time,
                    'total_price' => $booking->total_amount,
                    'currency' => $booking->currency,
                    'booking_type' => $booking->booking_type,
                    'customer_notes' => $booking->customer_notes,
                    'user_details' => [
                        'id' => $booking->customer->id,
                        'name' => $booking->customer->name,
                        'email' => $booking->customer->email,
                        'phone' => $booking->customer->phone,
                        'image' => $booking->customer->image_url,
                    ],
                    'service_details' => [
                        'id' => $booking->service->id,
                        'name' => $booking->service->name,
                        'description' => $booking->service->description,
                        'image' => $booking->service->image_url,
                        'price_onetime' => $booking->service->price_onetime,
                        'price_weekly' => $booking->service->price_weekly,
                        'price_monthly' => $booking->service->price_monthly,
                        'price_yearly' => $booking->service->price_yearly,
                    ],
                    'default_address' => $defaultAddress ? [
                        'id' => $defaultAddress->id,
                        'full_address' => $defaultAddress->full_address,
                        'contact_name' => $defaultAddress->contact_name,
                        'contact_phone' => $defaultAddress->contact_phone,
                        'address_details' => $defaultAddress->address_details,
                    ] : null,
                ];
            });

            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Available bookings retrieved successfully',
                'data' => $formattedBookings
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'message' => 'Failed to retrieve available bookings',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * POST API: List assigned bookings for a service provider
     */
    public function listMyBookings(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'serviceProvider' => 'required|exists:users,id',
                'type' => 'nullable|in:all,assigned,ongoing,completed,cancelled',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'status_code' => 400,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 400);
            }

            $serviceProviderId = $request->serviceProvider;
            $type = $request->type;

            // Fetch assigned bookings for the provider
            $query = Booking::with([
                'customer' => function ($query) {
                    $query->select('id', 'name', 'email', 'phone', 'image')
                        ->with(['addresses' => function ($q) {
                            $q->default();
                        }]);
                },
                'service' => function ($query) {
                    $query->select('id', 'name', 'description', 'media', 'price_onetime', 'price_weekly', 'price_monthly', 'price_yearly');
                }
            ]);
               

            if ($type) {
                switch ($type) {
                     case 'all' : 
                          // Show bookings assigned to this provider OR cancelled bookings from other providers
                          $query->where(function($q) {
        $q->where('status', 'pending')
          ->whereNull('service_provider_id');
    });
                         break;
                    case 'assigned':
                        $query->whereIn('status', ['accepted', 'assigned'])->where('service_provider_id', $serviceProviderId);
                        break;
                    case 'ongoing':
                        $query->where('status', 'ongoing')->where('service_provider_id', $serviceProviderId);
                        break;
                    case 'completed':
                        $query->where('status', 'completed')->where('service_provider_id', $serviceProviderId);
                        break;
                    case 'cancelled':
                        $query->where('status', 'cancelled');
                        break;
                   
                }
            }

            $bookings = $query->orderBy('scheduled_date', 'desc')
                ->orderBy('preferred_time', 'desc')
                ->get();

            // Format the response data (same as available bookings)
            $formattedBookings = $bookings->map(function ($booking) {
                $defaultAddress = $booking->customer->addresses->first();

                return [
                    'booking_id' => $booking->id,
                    'booking_reference' => $booking->booking_reference,
                    'scheduled_date' => $booking->scheduled_date->format('y-m-d'),
                    'preferred_time' => $booking->preferred_time,
                    'total_price' => $booking->total_amount,
                    'currency' => $booking->currency,
                    'status' => $booking->status,
                    'booking_type' => $booking->booking_type,
                    'customer_notes' => $booking->customer_notes,
                    'user_details' => [
                        'id' => $booking->customer->id,
                        'name' => $booking->customer->name,
                        'email' => $booking->customer->email,
                        'phone' => $booking->customer->phone,
                        'image' => $booking->customer->image_url,
                    ],
                    'service_details' => [
                        'id' => $booking->service->id,
                        'name' => $booking->service->name,
                        'description' => $booking->service->description,
                        'image' => $booking->service->image_url,
                        'price_onetime' => $booking->service->price_onetime,
                        'price_weekly' => $booking->service->price_weekly,
                        'price_monthly' => $booking->service->price_monthly,
                        'price_yearly' => $booking->service->price_yearly,
                    ],
                    'default_address' => $defaultAddress ? [
                        'id' => $defaultAddress->id,
                        'full_address' => $defaultAddress->full_address,
                        'contact_name' => $defaultAddress->contact_name,
                        'contact_phone' => $defaultAddress->contact_phone,
                        'address_details' => $defaultAddress->address_details,
                    ] : null,
                ];
            });

            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'My bookings retrieved successfully',
                'totalBookings' => $bookings->count(),
                'data' => $formattedBookings
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'message' => 'Failed to retrieve my bookings',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * POST API: Accept a booking by service provider
     */
        public function acceptBooking(Request $request)
        {
            try {
                $validator = Validator::make($request->all(), [
                    'serviceProvider' => 'required|exists:users,id',
                    'bookingId' => 'required|exists:bookings,id',
                ]);
    
                if ($validator->fails()) {
                    return response()->json([
                        'success' => false,
                        'status_code' => 400,
                        'message' => 'Validation error',
                        'errors' => $validator->errors()
                    ], 400);
                }
    
                $serviceProviderId = $request->serviceProvider;
                $bookingId = $request->bookingId;
    
                // Find the booking and verify it's available
                $booking = Booking::find($bookingId);
    
                if (!$booking) {
                    return response()->json([
                        'success' => false,
                        'status_code' => 404,
                        'message' => 'Booking not found'
                    ], 404);
                }
    
                // Check if booking is pending and unassigned
                if ($booking->status !== 'pending' || $booking->service_provider_id !== null) {
                    return response()->json([
                        'success' => false,
                        'status_code' => 409,
                        'message' => 'Booking is no longer available or already Accepted'
                    ], 409);
                }
    
                // Check if service provider is assigned to this service
                
                // $isAssignedToService = \DB::table('user_services')
                //     ->where('user_id', $serviceProviderId)
                //     ->where('service_id', $booking->service_id)
                //     ->exists();
    
                // if (!$isAssignedToService) {
                //     return response()->json([
                //         'success' => false,
                //         'status_code' => 403,
                //         'message' => 'You are not authorized to accept this booking'
                //     ], 403);
                // }
               
    
                // Accept the booking
                $booking->update([
                    'service_provider_id' => $serviceProviderId,
                    'status' => 'accepted',
                ]);
    
                // Notify customer if needed
                if ($booking->customer) {
                
                      $user = User::find($booking->customer->id);
                      $serviceProvider = User::find($serviceProviderId);
                      
                    //notification to serviceProvider
                    $user->notify(new BookingNotification(
                        'Booking Accepted',
                        'Your booking has been accepted by a service provider!',
                        $booking->id,
                        'booking_accepted'
                    ));
                    
                    //notification to serviceProvider
                    $serviceProvider->notify(new BookingNotification(
                        'Accepted',
                        'You Have Accepted a Booking !',
                        $booking->id,
                        'booking_accepted'
                    ));
                }
    
                return response()->json([
                    'success' => true,
                    'status_code' => 200,
                    'message' => 'Booking accepted successfully',
                    'data' => [
                        'booking_id' => $booking->id,
                        'status' => $booking->status,
                        'service_provider_id' => $booking->service_provider_id,
                    ]
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'status_code' => 500,
                    'message' => 'Failed to accept booking',
                    'error' => $e->getMessage()
                ], 500);
            }
        }

    /**
     * POST API: Cancel a booking by service provider
     */
    public function cancelBooking(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'serviceProvider' => 'required|exists:users,id',
                'bookingId' => 'required|exists:bookings,id',
                'cancellationReason' => 'nullable|string|max:1000',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'status_code' => 400,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 400);
            }

            $serviceProviderId = $request->serviceProvider;
            $bookingId = $request->bookingId;

            // Find the booking
            $booking = Booking::find($bookingId);

            if (!$booking) {
                return response()->json([
                    'success' => false,
                    'status_code' => 404,
                    'message' => 'Booking not found'
                ], 404);
            }
            
            

            // Check if booking belongs to this service provider and can be cancelled
            // if ($booking->service_provider_id != $serviceProviderId) {
            //     return response()->json([
            //         'success' => false,
            //         'status_code' => 403,
            //         'message' => 'You are not authorized to cancel this booking'
            //     ], 403);
            // }

            // Only allow cancellation if not completed or already cancelled
            if (in_array($booking->status, ['completed', 'cancelled'])) {
                return response()->json([
                    'success' => false,
                    'status_code' => 409,
                    'message' => 'Cannot cancel a completed or already cancelled booking'
                ], 409);
            }

            // Cancel the booking and make it available again
            $booking->update([
                'status' => 'cancelled',
                'service_provider_id' => null, // Make it available for other providers
                 'cancelled_by' => $serviceProviderId,
                'cancellation_type' => 'serviceprovider',
                'cancellation_reason' => $request->cancellationReason,
                'cancelled_at' => now(),
            ]);


            // Notify customer if needed
                if ($booking->customer) {
                     $user = User::find($booking->customer->id);
                      
                    //notification to user
                    $user->notify(new BookingNotification(
                        'Booking Accepted',
                        'Your booking has been accepted by a service provider!',
                        $booking->id,
                        'booking_accepted'
                    ));
                    
                }
                
            // if ($booking->customer) {
            //      $user = User::find($booking->customer->id);
                 
            //     $user->notify(new BookingNotification(
            //         'Booking Cancelled',
            //         'Your booking has been cancelled by the service provider.',
            //         $booking->id,
            //         'booking_cancelled'
            //     ));
            // }
            

            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Booking cancelled successfully',
                'data' => [
                    'booking_id' => $booking->id,
                    'status' => $booking->status,
                    'cancelled_at' => $booking->cancelled_at,
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'message' => 'Failed to cancel booking',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * POST API: Get all customer bookings for a service provider with filtering
     */
    public function getServiceProviderBookings(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user' => 'required|exists:users,id',
                'type' => 'required|in:all,inProgress,completed',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'status_code' => 400,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 400);
            }

            $userId = $request->user;
            $type = $request->type;

            // Check if user exists and is a serviceprovider
            $user = User::find($userId);
            if (!$user || $user->role !== 'serviceprovider') {
                return response()->json([
                    'success' => false,
                    'status_code' => 403,
                    'message' => 'User is not a valid service provider'
                ], 403);
            }

            // Build query for bookings assigned to this service provider
            $query = Booking::with([
                'customer' => function ($query) {
                    $query->select('id', 'name', 'email', 'phone', 'image');
                },
                'service' => function ($query) {
                    $query->select('id', 'name', 'description', 'media', 'price_onetime', 'price_weekly', 'price_monthly', 'price_yearly');
                }
            ])
            ->where('service_provider_id', $userId);

            // Apply status filtering based on type
            switch ($type) {
                case 'inProgress':
                    $query->whereIn('status', ['pending', 'accepted', 'ongoing']);
                    break;
                case 'completed':
                    $query->where('status', 'completed');
                    break;
                case 'all':
                    // No additional filtering for 'all'
                    break;
            }

            $bookings = $query->orderBy('created_at', 'desc')->get();

            // Format the response data
            $formattedBookings = $bookings->map(function ($booking) {
                return [
                    'booking_id' => $booking->id,
                    'booking_reference' => $booking->booking_reference,
                    'scheduled_date' => $booking->scheduled_date,
                    'preferred_time' => $booking->preferred_time,
                    'status' => $booking->status,
                    'total_amount' => $booking->total_amount,
                    'currency' => $booking->currency,
                    'booking_type' => $booking->booking_type,
                    'customer_notes' => $booking->customer_notes,
                    'created_at' => $booking->created_at,
                    'customer_details' => [
                        'id' => $booking->customer->id,
                        'name' => $booking->customer->name,
                        'email' => $booking->customer->email,
                        'phone' => $booking->customer->phone,
                        'image' => $booking->customer->image_url,
                    ],
                    'service_details' => [
                        'id' => $booking->service->id,
                        'name' => $booking->service->name,
                        'description' => $booking->service->description,
                        'image' => $booking->service->image_url,
                        'price_onetime' => $booking->service->price_onetime,
                        'price_weekly' => $booking->service->price_weekly,
                        'price_monthly' => $booking->service->price_monthly,
                        'price_yearly' => $booking->service->price_yearly,
                    ],
                ];
            });

            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Service provider bookings retrieved successfully',
                'data' => [
                    'total_bookings' => $formattedBookings->count(),
                    'type' => $type,
                    'bookings' => $formattedBookings
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'message' => 'Failed to retrieve service provider bookings',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * POST API: Get availability options for service provider (dates and time slots)
     */
    public function getAvailabilityOptions(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'serviceProvider' => 'required|exists:users,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'status_code' => 400,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 400);
            }

            $serviceProviderId = $request->serviceProvider;

            // Check if user exists and is a serviceprovider
            $user = User::find($serviceProviderId);
            if (!$user || $user->role !== 'serviceprovider') {
                return response()->json([
                    'success' => false,
                    'status_code' => 403,
                    'message' => 'User is not a valid service provider'
                ], 403);
            }

            // Generate available dates (next 30 days from today)
            $dates = [];
            $currentDate = Carbon::now();
            for ($i = 0; $i <= 30; $i++) {
                $date = $currentDate->copy()->addDays($i);
                $dates[] = [
                    'date' => $date->format('Y-m-d'),
                    'day' => $date->format('l'), // Full day name
                    'formatted' => $date->format('M j, Y') // e.g., "Oct 30, 2025"
                ];
            }

            // Generate available time slots (6 AM to 12 AM/midnight, hourly)
            $times = [];
            $startTime = Carbon::createFromTime(6, 0); // 6:00 AM
            $endTime = Carbon::createFromTime(0, 0)->addDay(); // 12:00 AM (midnight) next day

            while ($startTime < $endTime) {
                $times[] = [
                    'time' => $startTime->format('H:i'),
                    'formatted' => $startTime->format('h:i A') // e.g., "06:00 AM"
                ];
                $startTime->addHour();
            }

            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Availability options retrieved successfully',
                'data' => [
                    'dates_title' => 'Choose the days and time slots you are available for bookings. Update anytime to manage your schedule',
                    'dates' => $dates,
                    'times_title' => 'Choose a time slot',
                    'times' => $times
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'message' => 'Failed to retrieve availability options',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
     /**
     * POST API: Get accepted bookings for a specific date for service provider
     */
    public function getBookingsByDate(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'serviceProvider' => 'required|exists:users,id',
                'date' => 'required|date|after_or_equal:today',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'status_code' => 400,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 400);
            }

            $serviceProviderId = $request->serviceProvider;
            $selectedDate = $request->date;

            // Check if user exists and is a serviceprovider
            $user = User::find($serviceProviderId);
            if (!$user || $user->role !== 'serviceprovider') {
                return response()->json([
                    'success' => false,
                    'status_code' => 403,
                    'message' => 'User is not a valid service provider'
                ], 403);
            }

            // Get accepted bookings for the specified date for this service provider
            $acceptedBookings = Booking::with([
                'customer' => function ($query) {
                      $query->select('id', 'name', 'email', 'phone', 'image')
                        ->with(['addresses' => function ($q) {
                            $q->default(); // Get default address
                        }]);
                },
                'service' => function ($query) {
                    $query->select('id', 'name', 'description', 'media', 'price_onetime', 'price_weekly', 'price_monthly', 'price_yearly');
                }
            ])
                ->where('service_provider_id', $serviceProviderId)
                ->where('status', 'accepted')
                ->where('scheduled_date', $selectedDate)
                ->orderBy('preferred_time', 'asc')
                ->get();

            // Format the accepted bookings
            $formattedBookings = $acceptedBookings->map(function ($booking) {
                return [
                    'booking_id' => $booking->id,
                    'booking_reference' => $booking->booking_reference,
                    'scheduled_date' => $booking->scheduled_date->format('y-m-d'),
                    'preferred_time' => $booking->preferred_time,
                    'total_amount' => $booking->total_amount,
                    'currency' => $booking->currency,
                    'booking_type' => $booking->booking_type,
                    'customer_notes' => $booking->customer_notes,
                    'customer_details'=> $booking->customer,
                    // 'customer_details' => [
                    //     'id' => $booking->customer->id,
                    //     'name' => $booking->customer->name,
                    //     'email' => $booking->customer->email,
                    //     'phone' => $booking->customer->phone,
                    //     'image' => $booking->customer->image_url,
                    // ],
                    'service_details' => [
                        'id' => $booking->service->id,
                        'name' => $booking->service->name,
                        'description' => $booking->service->description,
                        'image' => $booking->service->image_url,
                      
                    ],
                ];
            });

            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Accepted bookings for date retrieved successfully',
                'data' => [
                    'date' => $selectedDate,
                    'total_bookings' => $formattedBookings->count(),
                    'accepted_bookings' => $formattedBookings
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'message' => 'Failed to retrieve accepted bookings for date',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    
     /**
     * POST API: Get service provider's schedule (dates and today's accepted bookings)
     */
     public function mySchedule(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'serviceProvider' => 'required|exists:users,id',
            ]);
            

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'status_code' => 400,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 400);
            }

            $serviceProviderId = $request->serviceProvider;

            // Check if user exists and is a serviceprovider
            $user = User::find($serviceProviderId);
            if (!$user || $user->role != 'serviceprovider') {
                return response()->json([
                    'success' => false,
                    'status_code' => 403,
                    'message' => 'User is not a valid service provider'
                ], 403);
            }

            // Generate available dates from today (next 30 days)
            $dates = [];
            $currentDate = Carbon::now();
            for ($i = 0; $i <= 30; $i++) {
                $date = $currentDate->copy()->addDays($i);
                $dates[] = [
                    'id' => $i,
                    'date' => $date->format('Y-m-d'),
                    'day' => $date->format('D'), // Full day name
                    'month' => $date->format('M'), // Month name
                    'formatted' => $date->format('M j, Y') // e.g., "Oct 30, 2025"
                ];
            }

            // Get today's accepted bookings for this service provider
            if ($request->date) {
                $date = $request->date;
            } else {
                $date = Carbon::now()->format('Y-m-d');
            }

            $todaysAcceptedBookings = Booking::with([
                'customer' => function ($query) {
                    $query->select('id', 'name', 'email', 'phone', 'image')
                        ->with(['addresses' => function ($q) {
                            $q->default(); // Get default address
                        }]);
                },
                'service' => function ($query) {
                    $query->select('id', 'name', 'description', 'media', 'price_onetime', 'price_weekly', 'price_monthly', 'price_yearly');
                }
            ])
                ->where('service_provider_id', $serviceProviderId)
                ->where('status', 'accepted')
                ->where('scheduled_date', $date)
                ->orderBy('preferred_time', 'asc')
                ->get();
                //  return response()->json([
                //     'message' => $todaysAcceptedBookings,
                // ] );

            // Format today's accepted bookings
            $formattedTodaysBookings = $todaysAcceptedBookings->map(function ($booking) {
                return [
                    'booking_id' => $booking->id,
                    'booking_reference' => $booking->booking_reference,
                    'scheduled_date' => $booking->scheduled_date->format('Y-m-d'),
                    'preferred_time' => $booking->preferred_time,
                    'total_amount' => $booking->total_amount,
                    'currency' => $booking->currency,
                    'booking_type' => $booking->booking_type,
                    'customer_notes' => $booking->customer_notes,
                    'customer_details' => [
                        'id' => $booking->customer->id,
                        'name' => $booking->customer->name,
                        'email' => $booking->customer->email,
                        'phone' => $booking->customer->phone,
                        'image' => $booking->customer->image_url,
                        'addresses' => $booking->customer->addresses,
                    ],
                    'service_details' => [
                        'id' => $booking->service->id,
                        'name' => $booking->service->name,
                        'description' => $booking->service->description,
                        'image' => $booking->service->image_url,
                        'price_onetime' => $booking->service->price_onetime,
                        'price_weekly' => $booking->service->price_weekly,
                        'price_monthly' => $booking->service->price_monthly,
                        'price_yearly' => $booking->service->price_yearly,
                    ],
                ];
            });

            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'My schedule retrieved successfully',
                'data' => [
                    'dates' => $dates,
                    'todays_accepted_bookings' => $formattedTodaysBookings
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'message' => 'Failed to retrieve my schedule',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    //   public function mySchedule(Request $request)
    // {
    //     try {
    //         $validator = Validator::make($request->all(), [
    //             'serviceProvider' => 'required|exists:users,id',
    //             'date' => 'nullable|date|after_or_equal:today',
                
    //         ]);

    //         if ($validator->fails()) {
    //             return response()->json([
    //                 'success' => false,
    //                 'status_code' => 400,
    //                 'message' => 'Validation error',
    //                 'errors' => $validator->errors()
    //             ], 400);
    //         }

    //         $serviceProviderId = $request->serviceProvider;

    //         // Check if user exists and is a serviceprovider
    //         $user = User::find($serviceProviderId);
    //         if (!$user || $user->role != 'serviceprovider') {
    //             return response()->json([
    //                 'success' => false,
    //                 'status_code' => 403,
    //                 'message' => 'User is not a valid service provider'
    //             ], 403);
    //         }

    //         // Generate available dates from today (next 30 days)
    //         $dates = [];
    //         $currentDate = Carbon::now();
    //          for ($i = 0; $i <= 30; $i++) {
    //             $date = $currentDate->copy()->addDays($i);
    //             $dates[] = [
    //                 'id'=>$i,
    //                 'date' => $date->format('Y-m-d'),
    //                 'day' => $date->format('D'), // Full day name
    //                 'month' => $date->format('M'), // Month name
    //                 'formatted' => $date->format('M j, Y') // e.g., "Oct 30, 2025"
    //             ];
    //         }

    //         // Get today's accepted bookings for this service provider
    //         if($request->date){
    //              $date = $request->date;
    //         }
    //          else{
    //              $date = Carbon::now()->format('Y-m-d');
    //         }
            
           
    //         $todaysAcceptedBookings = Booking::with([
    //             'customer' => function ($query) {
    //                   $query->select('id', 'name', 'email', 'phone', 'image')
    //                     ->with(['addresses' => function ($q) {
    //                         $q->default(); // Get default address
    //                     }]);
    //             },
    //             'service' => function ($query) {
    //                 $query->select('id', 'name', 'description', 'media', 'price_onetime', 'price_weekly', 'price_monthly', 'price_yearly');
    //             }
    //         ])
    //             ->where('service_provider_id', $serviceProviderId)
    //             ->where('status', 'accepted')
    //             ->where('scheduled_date', $date)
    //             ->orderBy('preferred_time', 'asc')
    //             ->get();
            
           

    //         // Format today's accepted bookings
    //         $formattedTodaysBookings = $todaysAcceptedBookings->map(function ($booking) {
    //             return [
    //                 'booking_id' => $booking->id,
    //                 'booking_reference' => $booking->booking_reference,
    //                 'scheduled_date' => $booking->scheduled_date->format('Y-m-d'),
    //                 'preferred_time' => $booking->preferred_time,
    //                 'total_amount' => $booking->total_amount,
    //                 'currency' => $booking->currency,
    //                 'booking_type' => $booking->booking_type,
    //                 'customer_notes' => $booking->customer_notes,
    //                 'customer_details' => [
    //                     'id' => $booking->customer->id,
    //                     'name' => $booking->customer->name,
    //                     'email' => $booking->customer->email,
    //                     'phone' => $booking->customer->phone,
    //                     'image' => $booking->customer->image_url,
    //                 ],
    //                 'service_details' => [
    //                     'id' => $booking->service->id,
    //                     'name' => $booking->service->name,
    //                     'description' => $booking->service->description,
    //                     'image' => $booking->service->image_url,
    //                     'price_onetime' => $booking->service->price_onetime,
    //                     'price_weekly' => $booking->service->price_weekly,
    //                     'price_monthly' => $booking->service->price_monthly,
    //                     'price_yearly' => $booking->service->price_yearly,
    //                 ],
    //             ];
    //         });

    //         return response()->json([
    //             'success' => true,
    //             'status_code' => 200,
    //             'message' => 'My schedule retrieved successfully',
    //             'data' => [
    //                 'dates' => $dates,
    //                 'todays_accepted_bookings' => $formattedTodaysBookings
    //             ]
    //         ], 200);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'status_code' => 500,
    //             'message' => 'Failed to retrieve my schedule',
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }
    // }
    
     /**
     * POST API: Set service provider availability
     */
    public function setAvailability(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'serviceProvider' => 'required|exists:users,id',
                'date' => 'required|date|after_or_equal:today',
                'times' => 'required|array|min:1',
                'times.*' => 'required|date_format:H:i',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'status_code' => 400,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 400);
            }

            $serviceProviderId = $request->serviceProvider;
            $date = $request->date;
            $times = $request->times;

            // Check if user exists and is a serviceprovider
            $user = User::find($serviceProviderId);
            if (!$user || $user->role !== 'serviceprovider') {
                return response()->json([
                    'success' => false,
                    'status_code' => 403,
                    'message' => 'User is not a valid service provider'
                ], 403);
            }

            // Delete existing availability for this date and provider
            ServiceProviderAvailability::where('service_provider_id', $serviceProviderId)
                ->where('available_date', $date)
                ->delete();

            // Create new availability records
            $availabilityRecords = [];
            foreach ($times as $time) {
                $availabilityRecords[] = [
                    'service_provider_id' => $serviceProviderId,
                    'available_date' => $date,
                    'available_time' => $time,
                    'is_available' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }

            ServiceProviderAvailability::insert($availabilityRecords);

            return response()->json([
                'success' => true,
                'status_code' => 201,
                'message' => 'Availability set successfully',
                'data' => [
                    'date' => $date,
                    'times' => $times,
                    'total_slots' => count($times)
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'message' => 'Failed to set availability',
                'error' => $e->getMessage()
            ], 500);
        }
    }   
    
    
    /**
     * POST API: Get service provider available dates
     */
     public function getProviderAvailableDates(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'serviceProvider' => 'required|exists:users,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'status_code' => 400,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 400);
            }

            $serviceProviderId = $request->serviceProvider;

            // Check if user exists and is a serviceprovider
            $user = User::find($serviceProviderId);
            if (!$user || $user->role !== 'serviceprovider') {
                return response()->json([
                    'success' => false,
                    'status_code' => 403,
                    'message' => 'User is not a valid service provider'
                ], 403);
            }

            // Get all available dates and their times for this service provider from today onwards
            $availableDates = ServiceProviderAvailability::where('service_provider_id', $serviceProviderId)
                ->where('available_date', '>=', Carbon::now()->toDateString())
                ->where('is_available', true)
                ->select('available_date', 'available_time')
                ->orderBy('available_date', 'asc')
                ->orderBy('available_time', 'asc')
                ->get()
                ->groupBy('available_date')
                ->map(function ($timesForDate, $date) {
                    $dateObj = Carbon::parse($date);
                    return [
                        'date' => $date,
                        'day' => $dateObj->format('l'), // Full day name
                        'formatted' => $dateObj->format('M j, Y'), // e.g., "Oct 30, 2025"
                        'available_times' => $timesForDate->map(function ($timeSlot) {
                            $time = Carbon::parse($timeSlot->available_time);
                            return [
                                'time' => $timeSlot->available_time,
                                'formatted' => $time->format('h:i A') // e.g., "10:00 AM"
                            ];
                        })->values()
                    ];
                })
                ->values();

            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Service provider available dates and times retrieved successfully',
                'data' => [
                    'total_available_dates' => $availableDates->count(),
                    'available_dates' => $availableDates
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'message' => 'Failed to retrieve service provider available dates',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * POST API: Reschedule an existing booking (date and time only)
     */
    public function rescheduleBooking(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user' => 'required|exists:users,id',
                'bookingId' => 'required|exists:bookings,id',
                'newDate' => 'required|date|after_or_equal:today',
                'newTime' => 'required|date_format:H:i',
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
            $bookingId = $request->bookingId;
            $newDate = $request->newDate;
            $newTime = $request->newTime;

            // Find the booking and verify ownership
            $booking = Booking::with(['serviceProvider', 'service'])->find($bookingId);

            if (!$booking) {
                return response()->json([
                    'success' => false,
                    'status_code' => 404,
                    'message' => 'Booking not found'
                ], 404);
            }

            // Check if customer owns this booking
            if ($booking->customer_id != $customerId) {
                return response()->json([
                    'success' => false,
                    'status_code' => 403,
                    'message' => 'You are not authorized to reschedule this booking'
                ], 403);
            }

            // Check if booking can be rescheduled (only pending or accepted bookings)
            if (!in_array($booking->status, ['pending', 'accepted'])) {
                return response()->json([
                    'success' => false,
                    'status_code' => 409,
                    'message' => 'This booking cannot be rescheduled at this time'
                ], 409);
            }

            // Check if new date/time is not too close to current time (minimum 2 hours advance notice)
            $newDateTime = Carbon::createFromFormat('Y-m-d H:i', $newDate . ' ' . $newTime);
            $now = Carbon::now();
            
            //  return response()->json([
            //         'data' => abs($newDateTime->diffInHours($now)),
            //     ]);

            if (abs($newDateTime->diffInHours($now)) < 2) {
                return response()->json([
                    'success' => false,
                    'status_code' => 400,
                    'message' => 'New booking time must be at least 2 hours from now'
                ], 400);
            }

            // Check if service provider is available at the new date and time
            if ($booking->service_provider_id) {
                $availabilityCheck = ServiceProviderAvailability::where('service_provider_id', $booking->service_provider_id)
                    ->where('available_date', $newDate)
                    ->where('available_time', $newTime)
                    ->where('is_available', true)
                    ->exists();

                if (!$availabilityCheck) {
                    return response()->json([
                        'success' => false,
                        'status_code' => 409,
                        'message' => 'Service provider is not available at the requested date and time'
                    ], 409);
                }

                // Check for booking conflicts at new time
                $conflictCheck = Booking::where('service_provider_id', $booking->service_provider_id)
                    ->where('scheduled_date', $newDate)
                    ->where('preferred_time', $newTime)
                    ->where('status', '!=', 'cancelled')
                    ->where('id', '!=', $bookingId) // Exclude current booking
                    ->exists();

                if ($conflictCheck) {
                    return response()->json([
                        'success' => false,
                        'status_code' => 409,
                        'message' => 'Service provider has a conflicting booking at this time'
                    ], 409);
                }
            }

            // Store old date/time for notification
            $oldDate = $booking->scheduled_date;
            $oldTime = $booking->preferred_time;

            // Update the booking with new date and time
            $booking->update([
                'scheduled_date' => $newDate,
                'preferred_time' => $newTime,
                'updated_at' => now(),
            ]);

            // Send notifications
            if ($booking->customer) {
                  $user = User::find($booking->customer->id);
                $user->notify(new BookingNotification(
                    'Booking Rescheduled',
                    'Your booking has been successfully rescheduled to ' . $newDate . ' at ' . $newTime,
                    $booking->id,
                    'booking_rescheduled'
                ));
            }

            if ($booking->serviceProvider) {
                 $serviceProvider = User::find($booking->serviceProvider->id);
                $serviceProvider->notify(new BookingNotification(
                    'Booking Rescheduled',
                    'A booking has been rescheduled to ' . $newDate . ' at ' . $newTime,
                    $booking->id,
                    'booking_rescheduled'
                ));
            }

            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Booking rescheduled successfully',
                'data' => [
                    'booking_id' => $booking->id,
                    'booking_reference' => $booking->booking_reference,
                    'old_date' => $oldDate,
                    'old_time' => $oldTime,
                    'new_date' => $newDate,
                    'new_time' => $newTime,
                    'service_provider' => $booking->serviceProvider ? [
                        'id' => $booking->serviceProvider->id,
                        'name' => $booking->serviceProvider->name,
                    ] : null,
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'message' => 'Failed to reschedule booking',
                'error' => $e->getMessage()
            ], 500);
        }
    }

     /**
     * Calculate next billing date based on frequency type
     */
    private function calculateNextBillingDate($frequencyType)
    {
        $now = now();

        switch ($frequencyType) {
            case 'weekly':
                return $now->copy()->addWeek()->toDateString();
            case 'monthly':
                return $now->copy()->addMonth()->toDateString();
            case 'quarterly':
                return $now->copy()->addMonths(3)->toDateString();
            case 'yearly':
                return $now->copy()->addYear()->toDateString();
            default:
                return $now->copy()->addMonth()->toDateString(); // Default to monthly
        }
    }
}