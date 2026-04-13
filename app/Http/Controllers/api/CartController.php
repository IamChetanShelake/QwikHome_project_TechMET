<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Service;
use App\Models\ServiceFrequencyOption;
use App\Models\ServiceMaterial;
use App\Models\Cart;
use App\Models\Address;
use App\Models\CartItem;
use App\Models\Coupon;

class CartController extends Controller
{
    /**
     * Add service to cart
     */
      public function addToCart(Request $request)
    {

        // Validation rules
        $validator = Validator::make($request->all(), [
            'user' => 'required|exists:users,id',
            'service' => 'required|exists:services,id',
            'package' => 'nullable|exists:service_frequency_options,id',
            'material' => 'nullable|boolean',
            'providersCount' => 'nullable|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Fetch the selected service
        $service = Service::findOrFail($request->service);

        // Fetch selected frequency/package
        $frequencyOption = null;
        if ($request->package) {
            $frequencyOption = ServiceFrequencyOption::where('id', $request->package)
                ->where('service_id', $service->id)
                ->first();

            if (!$frequencyOption) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid service frequency option'
                ], 400);
            }
        }
        else{
            $frequencyOption = ServiceFrequencyOption::where('frequency_type', 'onetime')
                ->where('service_id', $service->id)
                ->first();
        }

        // Simulated available providers count
        $availableProviders = 10;
        $providersCount = $request->providersCount ?? 1;

        if ($providersCount > $availableProviders) {
            return response()->json([
                'status' => false,
                'message' =>  'Limited executives available , please select maximum 10 or below 10 executives'
            ], 400);
        }

        // Base price from the selected package or service default
        $basePrice = $frequencyOption ? $frequencyOption->price_per_time : 0;

        // Material handling — if true, include all materials of that service
        $materialsTotal = 0;
        $selectedMaterialIds = [];

        if ($request->material) {
            $materials = ServiceMaterial::where('service_id', $service->id)->get();
            $materialsTotal = $materials->sum('material_price');
            $selectedMaterialIds = $materials->pluck('id')->toArray();
        }
       
       
        // Total price calculation
        $totalPrice = ($basePrice * $providersCount ) + $materialsTotal;

        // Get or create cart
         $cart = Cart::firstOrCreate(['user_id' => $request->user]);
         
        //   return response()->json([
        //     'data' => [
        //       'providers count ' => $providersCount,
        //       'frequencyoption'=>$frequencyOption->price_per_time,
        //       'baseprice ' => $basePrice,
        //         'materialstotal' =>$materialsTotal,
        //       'totalPrice' => ($basePrice + $materialsTotal) * $providersCount
        //         ]
        // ]);
        

        // Create cart item
        $cartItem = CartItem::create([
             'user_id'=>$request->user,
            'cart_id' => $cart->id,
            'item_type' => 'service',
            'item_id' => $service->id,
            'item_name' => $service->name,
            'service_frequency_id' => $frequencyOption ? $frequencyOption->id : null,
            'quantity' => 1,
            'providers_count' => $providersCount,
            'include_material' => $request->material ?? 0,
            'selected_addons' => json_encode($selectedMaterialIds),
            'base_price' => $basePrice,
            // 'addons_price' => $materialsTotal,
            'unit_price' => $basePrice + $materialsTotal,
            'total_price' =>$totalPrice ,
        ]);

        // Update cart totals
        $cart->recalculateTotals();

        return response()->json([
            'status' => true,
            'message' => 'Service added to cart successfully',
            'cart_item' => $cartItem
        ]);
    }


 /**
      * POST API: Store preferred time and date in cart item
      */
    public function storePreferredTimeDate(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user' => 'required|exists:users,id', // Customer
                'cartid' => 'required|exists:cart_items,id',
                'scheduledDate' => 'required|date|after_or_equal:today',
                'preferredTime' => 'required|date_format:H:i',
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
            $cartItem = \App\Models\CartItem::with(['cart'])
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

            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Preferred time and date stored in cart item successfully',
                'data' => [
                    'cart_item' => $cartItem
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'message' => 'Failed to store preferred time and date',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
     public function getCart(Request $request)
        {
            // Validation
            $validator = Validator::make($request->all(), [
                'user' => 'required|exists:users,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Get user's cart with items
            $cart = Cart::with(['items' => function($query) {
                $query->with(['serviceFrequency', ])->where('item_type', 'service');
            }])->where('user_id', $request->user)->first();

            if (!$cart) {
                return response()->json([
                    'status' => false,
                    'message' => 'Cart not found',
                    'data' => [
                        'cart_items' => [],
                        'total_amount' => 0,
                        'total_items' => 0
                    ]
                ], 404);
            }

            // Format cart items for response
     
        // Format cart items for response
        $cartItems = $cart->items->map(function ($item) {
            return [
                'id' => $item->id,
                'item_type' => $item->item_type,
                'item_id' => $item->item_id,
                'item_name' => $item->item_name,
                'service' => $item->getServiceAttribute() ? [
                    'id' => $item->getServiceAttribute()->id,
                    'name' => $item->getServiceAttribute()->name,
                    'description' => $item->getServiceAttribute()->description,
                    'image' => $item->getServiceAttribute()->image,
                ] : null,
                'service_frequency_id' => $item->service_frequency_id,
                'service_frequency_name' => $item->serviceFrequency ? $item->serviceFrequency->frequency_type : null,
                'allow_increment' => $item->getServiceAttribute()->allow_quantity_increment,
                'quantity' => $item->quantity,
                'providers_count' => $item->providers_count,
                'include_material' => $item->include_material,
                'selected_addons' => json_decode($item->selected_addons),
                'base_price' => $item->base_price,
                'addons_price' => $item->addons_price,
                'unit_price' => $item->unit_price,
                'total_price' => $item->total_price,

            ];
        });

            // Calculate total amount
            $totalAmount = $cart->items->sum('total_price');
            $totalItems = $cart->items->count();

            return response()->json([
                'status' => true,
                'message' => 'Cart retrieved successfully',
                'data' => [
                    'cart_items' => $cartItems,
                    'total_amount' => $totalAmount,
                    'total_items' => $totalItems,
                    'cart_id' => $cart->id,
                ]
            ]);
        }
        
         /**
     * Update cart item quantity
     */
    public function updateCartItemQuantity(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'user' => 'required|exists:users,id',
            'cartid' => 'nullable|exists:cart_items,id',
            'service' => 'nullable|exists:services,id',
            'material' => 'required|boolean',
            'quantity' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Find the cart/service item and ensure it belongs to the user
        if($request->cartid)
        {
        $cartItem = CartItem::where('id', $request->cartid)
            ->whereHas('cart', function ($query) use ($request) {
                $query->where('user_id', $request->user);
            })
            ->first();
        }
        else if($request->service){
            
             $cartItem = CartItem::
            where('item_id', $request->service)
            ->first();
            
            if(!$cartItem)
            {
            
             $service = Service::findOrFail($request->service);
            $frequencyOption = ServiceFrequencyOption::where('service_id', $service->id)
            ->where('frequency_type', 'onetime')
                    ->first();
            // Simulated available providers count
            $providersCount = 1;
            // Base price from the selected package or service default
            $basePrice = $frequencyOption ? $frequencyOption->price_per_time : 0;
    
            // Material handling — if true, include all materials of that service
            $materialsTotal = 0;
            $selectedMaterialIds = [];
            
            if($request->material == true){
            $materials = ServiceMaterial::where('service_id', $service->id)->get();
            $materialsTotal = $materials->sum('material_price');
            $selectedMaterialIds = $materials->pluck('id')->toArray();
            }
            //  return response()->json([
               
            //     'materialtotal' => $materialsTotal,
            //     'selectedMaterialIds' => $selectedMaterialIds,
             
            // ]);
    
            // Total price calculation
            $totalPrice = ($basePrice + $materialsTotal) * $providersCount;
    
            // Get or create cart
            $cart = Cart::firstOrCreate(['user_id' => $request->user]);
    
            // Create cart item
            $cartItem = CartItem::create([
                'user_id'=>$request->user,
                'cart_id' => $cart->id,
                'item_type' => 'service',
                'item_id' => $service->id,
                'item_name' => $service->name,
                'service_frequency_id' => $frequencyOption ? $frequencyOption->id : null,
                'quantity' => 1,
                'providers_count' => $providersCount,
                'include_material' => 1,
                'selected_addons' => json_encode($selectedMaterialIds),
                'base_price' => $basePrice,
                'addons_price' => $materialsTotal,
                'unit_price' => $basePrice + $materialsTotal,
                'total_price' => $basePrice + $materialsTotal,
            ]);
            
            }
            
        }

        if (!$cartItem) {
            return response()->json([
                'status' => false,
                'message' => 'Cart item not found or does not belong to user'
            ], 404);
        }

        $oldQuantity = $cartItem->quantity;
        $newQuantity = $request->quantity;
        
        if($newQuantity == 0){
            $cartItem->delete();
            
            return response()->json([
            'status' => true,
            'message' => 'Service deleted from cart successfully',
            ],200);
        }

        // Update cart item quantity and recalculate pricing
        $cartItem->update([
            'quantity' => $newQuantity,
            'total_price' => ($cartItem->unit_price * $newQuantity) + $cartItem->addons_price - $cartItem->discount_amount + $cartItem->tax_amount,
        ]);

        // Recalculate cart totals
        $cart = $cartItem->cart;
        $cart->recalculateTotals();

        return response()->json([
            'status' => true,
            'message' => 'Cart item quantity updated successfully',
            'data' => [
                'cart_item' => [
                    'id' => $cartItem->id,
                    'item_name' => $cartItem->item_name,
                    'old_quantity' => $oldQuantity,
                    'new_quantity' => $newQuantity,
                    'unit_price' => $cartItem->unit_price,
                    'total_price' => $cartItem->total_price,
                ],
                'cart_totals' => [
                    'total_amount' => $cart->total,
                    'total_items' => $cart->total_items,
                ]
            ]
        ]);
    }
        
         /**
     * Remove service from cart
     */
     public function removeFromCart(Request $request)
    {
        // Validation rules
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

        // Find the cart item and ensure it belongs to the user
        $cartItem = CartItem::where('id', $request->cartid)
            ->whereHas('cart', function ($query) use ($request) {
                $query->where('user_id', $request->user);
            })
            ->first();

        if (!$cartItem) {
            return response()->json([
                'status' => false,
                'message' => 'Cart item not found or does not belong to user'
            ], 404);
        }

        // Store cart reference before deletion for totals recalculation
        $cart = $cartItem->cart;
        $removedItemData = [
            'id' => $cartItem->id,
            'item_name' => $cartItem->item_name,
            'total_price' => $cartItem->total_price,
        ];

        // Delete the cart item from database
        $cartItem->delete();

        // Check if cart is now empty and delete it if so
        $remainingItems = $cart->items()->count();
        if ($remainingItems === 0) {
            $cart->delete();
            $cartDeleted = true;
        } else {
            // Recalculate cart totals if cart still exists
            $cart->recalculateTotals();
            $cartDeleted = false;
        }

        return response()->json([
            'status' => true,
            'message' => 'Service deleted from cart successfully',
            'data' => [
                'deleted_item' => $removedItemData,
                'cart_deleted' => $cartDeleted,
                'cart_totals' => $cartDeleted ? [
                    'total_amount' => 0,
                    'total_items' => 0,
                ] : [
                    'total_amount' => $cart->total,
                    'total_items' => $cart->total_items,
                ]
            ]
        ]);
    }
    
    //payment page 
      public function PaymentPage(Request $request)
    {
        // Validation - only cartid required
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

        // Get cart item and fetch user_id from cart_items only
        $cartItem = CartItem::where('user_id', $request->user)->find($request->cartid);

        if (!$cartItem) {
            return response()->json([
                'status' => false,
                'message' => 'Cart item not found'
            ], 404);
        }

        // Fetch user_id from cart_items table only
        $userId = $cartItem->user_id;

        if (!$userId) {
            return response()->json([
                'status' => false,
                'message' => 'User ID not found in cart item'
            ], 400);
        }

        // Get user's default address only
        $defaultAddress = Address::where('user_id', $userId)
            ->where('is_default', true)
            ->first();
        
        $preferredTime = $cartItem->preferred_time;
        $scheduledDate = $cartItem->scheduled_date;


        // Get the cart that contains this cart item
        $cart = $cartItem->cart;

        // Get all cart items for this cart
        $cartWithItems = CartItem::with(['cart'])
            ->where('cart_id', $cart->id)
            ->get();

        // Format cart items for response


        // Calculate totals from cart items (keeping existing calculation)
        $totalAmount = $cartWithItems->sum('total_price');
        $totalItems = $cartWithItems->count();

        // Get refund policy
        $refundPolicy = \App\Models\RefundPolicy::first();
        
         // Fetch applicable coupons
        $serviceId = $cartItem->item_id;
        $coupons = Coupon::where('status', 1)
            ->where('expiry_date', '>', now())
            ->where(function ($query) use ($serviceId) {
                $query->where('applicable_to', 'all_services')
                      ->orWhere(function ($q) use ($serviceId) {
                          $q->where('applicable_to', 'specific_services')
                            ->whereJsonContains('service_ids', $serviceId);
                      });
            })
            ->get();

        // Format coupons for response
        $formattedCoupons = $coupons->map(function ($coupon) {
            return [
                'coupon_code' => $coupon,
            ];
        });

        return response()->json([
            'status' => true,
            'message' => 'Payment page data retrieved successfully',
            'data' => [
                'user_id' => $userId, // From cart_items only
                'cart_id' => $cartItem->cart_id, // From cart_items only
                'default_address' => $defaultAddress,
                'date_time'=> [
                    $preferredTime ?? null,
                    $scheduledDate ?? null,
                    ],
                'service_id' => $cartItem->item_id, // Service ID from item_id column for all item types
                'service' => $cartItem->getServiceAttribute() ? [
                    'id' => $cartItem->getServiceAttribute()->id,
                    'name' => $cartItem->getServiceAttribute()->name,
                    'description' => $cartItem->getServiceAttribute()->description,
                    'image' => $cartItem->getServiceAttribute()->image,
                ] : null,
                 'coupons' => $formattedCoupons,
                'cart_details' => [
                    'id' => $cart->id,
                    'total' => $totalAmount,
                    'total_items' => $totalItems,
                ],

                'pricing_summary' => [
                    'subtotal' => $cartWithItems->sum(function ($item) {
                        return $item->base_price * $item->quantity;
                    }),
                    'materials_total' => $cartWithItems->sum('addons_price'),
                    'discount_amount' => $cartWithItems->sum('discount_amount'),
                    'tax_amount' => $cartWithItems->sum('tax_amount'),
                    'total_amount' => $totalAmount,
                    'total_items_count' => $totalItems,
                    'currency' => 'AED'
                ],
                'refund_policy' => $refundPolicy ? [
                    'id' => $refundPolicy->id,
                    'title' => $refundPolicy->title,
                    'content' => $refundPolicy->content,
                    'created_at' => $refundPolicy->created_at,
                ] : null
            ]
        ]);
    }
    
    
    /**
     * Process payment using user_id from cart_items only
     */
    private function processPayment($cartItem, $userId, $amount)
    {
        try {
            // Create payment transaction directly using cart_items data
            $transaction = \App\Models\PaymentTransaction::create([
                'user_id' => $userId,
                'amount' => $amount,
                'currency' => 'AED',
                'status' => 'processing',
                'type' => 'payment',
                'provider' => 'cart_payment', // Direct cart payment
                'provider_response' => json_encode([
                    'cart_item_id' => $cartItem->id,
                    'cart_id' => $cartItem->cart_id,
                    'processed_at' => now(),
                    'source' => 'cart_items_payment'
                ])
            ]);

            // Simulate payment processing
            $paymentStatus = $this->simulatePaymentProcessing($amount);

            // Update transaction status
            $transaction->update([
                'status' => $paymentStatus['status'],
                'provider_response' => json_encode(array_merge(
                    json_decode($transaction->provider_response, true),
                    $paymentStatus['response']
                ))
            ]);

            // Create payment status history
            \App\Models\PaymentStatusHistory::create([
                'payment_transaction_id' => $transaction->id,
                'old_status' => 'processing',
                'new_status' => $paymentStatus['status'],
                'changed_by' => $userId,
                'notes' => 'Payment processed from cart_items'
            ]);

            // If payment is successful, create booking payment record
            if ($paymentStatus['status'] === 'completed') {
                \App\Models\BookingPayment::create([
                    'booking_id' => $cartItem->id, // Using cart_item as booking reference
                    'payment_transaction_id' => $transaction->id,
                    'amount' => $amount
                ]);
            }

            return [
                'status' => true,
                'transaction' => $transaction,
                'message' => 'Payment processed successfully'
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => 'Payment processing failed: ' . $e->getMessage()
            ];
        }
    }


    /**
     * Simulate payment processing (replace with actual payment gateway integration)
     */
    private function simulatePaymentProcessing($amount)
    {
        // Simple 95% success rate for cart payments
        $isSuccessful = (mt_rand() / mt_getrandmax()) < 0.95;

        if ($isSuccessful) {
            return [
                'status' => 'completed',
                'response' => [
                    'transaction_id' => 'txn_' . uniqid(),
                    'amount_paid' => $amount,
                    'payment_date' => now()->toISOString(),
                    'status_message' => 'Payment successful via cart_items'
                ]
            ];
        } else {
            return [
                'status' => 'failed',
                'response' => [
                    'error_code' => 'PAYMENT_FAILED',
                    'error_message' => 'Payment could not be processed',
                    'failure_reason' => 'Simulated payment failure'
                ]
            ];
        }
    }

    /**
     * Get payment history for a user based on their cart_items
     */
    public function getPaymentHistory(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'cartid' => 'nullable|exists:cart_items,id',
            'limit' => 'nullable|integer|min:1|max:100',
            'offset' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        if ($request->cartid) {
            // Get payment history for a specific cart item
            $cartItem = CartItem::find($request->cartid);

            if (!$cartItem) {
                return response()->json([
                    'status' => false,
                    'message' => 'Cart item not found'
                ], 404);
            }

            $userId = $cartItem->user_id;

            if (!$userId) {
                return response()->json([
                    'status' => false,
                    'message' => 'User ID not found in cart item'
                ], 400);
            }

            // Get payment transactions for this specific cart item
            $paymentTransactions = \App\Models\PaymentTransaction::with(['paymentMethod'])
                ->where('user_id', $userId)
                ->where('provider_response->cart_item_id', $cartItem->id)
                ->orderBy('created_at', 'desc')
                ->limit($request->limit ?? 10)
                ->offset($request->offset ?? 0)
                ->get();
        } else {
            // Get payment history for all user's cart items
            return response()->json([
                'status' => false,
                'message' => 'Please provide a cartid to get payment history'
            ], 400);
        }

        // Format payment history for response
        $paymentHistory = $paymentTransactions->map(function ($transaction) {
            return [
                'id' => $transaction->id,
                'transaction_id' => $transaction->transaction_id,
                'amount' => $transaction->amount,
                'currency' => $transaction->currency,
                'status' => $transaction->status,
                'type' => $transaction->type,
                'provider' => $transaction->provider,
                'payment_method' => $transaction->paymentMethod ? [
                    'id' => $transaction->paymentMethod->id,
                    'type' => $transaction->paymentMethod->type,
                    'provider' => $transaction->paymentMethod->provider,
                ] : null,
                'processed_at' => $transaction->processed_at,
                'completed_at' => $transaction->completed_at,
                'failed_at' => $transaction->failed_at,
                'failure_reason' => $transaction->failure_reason,
                'created_at' => $transaction->created_at,
            ];
        });

        return response()->json([
            'status' => true,
            'message' => 'Payment history retrieved successfully',
            'data' => [
                'payment_history' => $paymentHistory,
                'total_count' => $paymentTransactions->count(),
                'summary' => [
                    'total_amount' => $paymentTransactions->where('status', 'completed')->sum('amount'),
                    'completed_payments' => $paymentTransactions->where('status', 'completed')->count(),
                    'failed_payments' => $paymentTransactions->where('status', 'failed')->count(),
                    'pending_payments' => $paymentTransactions->where('status', 'pending')->count(),
                ]
            ]
        ]);
    }

    /**
     * Get user's payment summary based on cart_items
     */
    public function getPaymentSummary(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'cartid' => 'required|exists:cart_items,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Get cart item and fetch user_id from cart_items only
        $cartItem = CartItem::find($request->cartid);

        if (!$cartItem) {
            return response()->json([
                'status' => false,
                'message' => 'Cart item not found'
            ], 404);
        }

        $userId = $cartItem->user_id;

        if (!$userId) {
            return response()->json([
                'status' => false,
                'message' => 'User ID not found in cart item'
            ], 400);
        }

        // Get payment summary for this user from cart_items
        $paymentTransactions = \App\Models\PaymentTransaction::where('user_id', $userId)->get();

        $summary = [
            'total_transactions' => $paymentTransactions->count(),
            'total_amount_paid' => $paymentTransactions->where('status', 'completed')->sum('amount'),
            'total_pending_amount' => $paymentTransactions->where('status', 'pending')->sum('amount'),
            'total_failed_amount' => $paymentTransactions->where('status', 'failed')->sum('amount'),
            'payment_methods_used' => $paymentTransactions->pluck('paymentMethod.type')->unique()->values(),
            'last_payment_date' => $paymentTransactions->where('status', 'completed')->max('completed_at'),
            'currency' => 'AED'
        ];

        return response()->json([
            'status' => true,
            'message' => 'Payment summary retrieved successfully',
            'data' => [
                'user_id' => $userId, // From cart_items only
                'summary' => $summary
            ]
        ]);
    }

    /**
     * Process payment for all items in cart using cart_items data only
     */
    public function processCartPayment(Request $request)
    {
        // Validation - only cartid required
        $validator = Validator::make($request->all(), [
            'cartid' => 'required|exists:cart_items,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Get cart item and fetch cart_id from cart_items only
        $cartItem = CartItem::find($request->cartid);

        if (!$cartItem) {
            return response()->json([
                'status' => false,
                'message' => 'Cart item not found'
            ], 404);
        }

        $cartId = $cartItem->cart_id;
        $userId = $cartItem->user_id;

        if (!$userId) {
            return response()->json([
                'status' => false,
                'message' => 'User ID not found in cart item'
            ], 400);
        }

        // Get all items in this cart
        $allCartItems = CartItem::where('cart_id', $cartId)->get();

        if ($allCartItems->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'No items found in cart'
            ], 404);
        }

        // Calculate total amount for all items
        $totalAmount = $allCartItems->sum('total_price');

        // Process payment for entire cart
        $paymentResult = $this->processCartPaymentTransaction($allCartItems, $userId, $totalAmount);

        if (!$paymentResult['status']) {
            return response()->json([
                'status' => false,
                'message' => 'Cart payment processing failed',
                'error' => $paymentResult['message']
            ], 400);
        }

        return response()->json([
            'status' => true,
            'message' => 'Cart payment processed successfully',
            'data' => [
                'user_id' => $userId, // From cart_items only
                'cart_id' => $cartId, // From cart_items only
                'payment_transaction' => $paymentResult['transaction'],
                'cart_summary' => [
                    'total_items' => $allCartItems->count(),
                    'total_amount' => $totalAmount,
                    'currency' => 'AED'
                ],
                'processed_items' => $allCartItems->pluck('id')
            ]
        ]);
    }

    /**
     * Process payment transaction for entire cart
     */
    private function processCartPaymentTransaction($cartItems, $userId, $totalAmount)
    {
        try {
            // Create single payment transaction for entire cart
            $transaction = \App\Models\PaymentTransaction::create([
                'user_id' => $userId,
                'amount' => $totalAmount,
                'currency' => 'AED',
                'status' => 'processing',
                'type' => 'cart_payment',
                'provider' => 'cart_payment_system',
                'provider_response' => json_encode([
                    'cart_items' => $cartItems->pluck('id')->toArray(),
                    'total_items' => $cartItems->count(),
                    'processed_at' => now(),
                    'source' => 'cart_items_bulk_payment'
                ])
            ]);

            // Simulate payment processing for cart
            $paymentStatus = $this->simulatePaymentProcessing($totalAmount);

            // Update transaction status
            $transaction->update([
                'status' => $paymentStatus['status'],
                'provider_response' => json_encode(array_merge(
                    json_decode($transaction->provider_response, true),
                    $paymentStatus['response']
                ))
            ]);

            // Create payment status history
            \App\Models\PaymentStatusHistory::create([
                'payment_transaction_id' => $transaction->id,
                'old_status' => 'processing',
                'new_status' => $paymentStatus['status'],
                'changed_by' => $userId,
                'notes' => 'Bulk cart payment processed from cart_items'
            ]);

            // If payment is successful, create booking payment records for all items
            if ($paymentStatus['status'] === 'completed') {
                foreach ($cartItems as $item) {
                    \App\Models\BookingPayment::create([
                        'booking_id' => $item->id,
                        'payment_transaction_id' => $transaction->id,
                        'amount' => $item->total_price
                    ]);
                }
            }

            return [
                'status' => true,
                'transaction' => $transaction,
                'message' => 'Cart payment processed successfully'
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => 'Cart payment processing failed: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Get cart payment status using cart_items data only
     */
    public function getCartPaymentStatus(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'cartid' => 'required|exists:cart_items,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Get cart item and fetch user_id from cart_items only
        $cartItem = CartItem::find($request->cartid);

        if (!$cartItem) {
            return response()->json([
                'status' => false,
                'message' => 'Cart item not found'
            ], 404);
        }

        $userId = $cartItem->user_id;

        if (!$userId) {
            return response()->json([
                'status' => false,
                'message' => 'User ID not found in cart item'
            ], 400);
        }

        // Get all payment transactions for this user from cart_items
        $paymentTransactions = \App\Models\PaymentTransaction::with(['statusHistory'])
            ->where('user_id', $userId)
            ->where('provider_response->cart_item_id', $cartItem->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Get cart payment status summary
        $cartPayments = $paymentTransactions->where('type', 'cart_payment');

        return response()->json([
            'status' => true,
            'message' => 'Cart payment status retrieved successfully',
            'data' => [
                'user_id' => $userId, // From cart_items only
                'cart_id' => $cartItem->cart_id, // From cart_items only
                'payment_summary' => [
                    'total_transactions' => $paymentTransactions->count(),
                    'cart_payments' => $cartPayments->count(),
                    'latest_payment' => $paymentTransactions->first(),
                    'payment_status' => $cartPayments->isNotEmpty() ?
                        $cartPayments->first()->status : 'no_payments'
                ],
                'recent_transactions' => $paymentTransactions->take(5)->map(function ($transaction) {
                    return [
                        'id' => $transaction->id,
                        'amount' => $transaction->amount,
                        'status' => $transaction->status,
                        'type' => $transaction->type,
                        'created_at' => $transaction->created_at,
                        'completed_at' => $transaction->completed_at
                    ];
                })
            ]
        ]);
    }
    
    //  public function PaymentPage(Request $request)
    // {
    //     // Validation - only cartid required
    //     $validator = Validator::make($request->all(), [
    //         'user' => 'required|exists:users,id',
    //         'cartid' => 'required|exists:cart_items,id',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Validation failed',
    //             'errors' => $validator->errors()
    //         ], 422);
    //     }

    //     // Get cart item and fetch user_id from cart_items only
    //     $cartItem = CartItem::where('user_id',$request->user)->find($request->cartid);

    //     if (!$cartItem) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Cart item not found'
    //         ], 404);
    //     }

    //     // Fetch user_id from cart_items table only
    //     $userId = $cartItem->user_id;

    //     if (!$userId) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'User ID not found in cart item'
    //         ], 400);
    //     }

    //     // Get user's default address only
    //     $defaultAddress = Address::where('user_id', $userId)
    //         ->where('is_default', true)
    //         ->first();

    //     // Get the cart that contains this cart item
    //     $cart = $cartItem->cart;

    //     // Get all cart items for this cart
    //     $cartWithItems = CartItem::with(['cart'])
    //         ->where('cart_id', $cart->id)
    //         ->get();

    //     // Format cart items for response
      

    //     // Calculate totals from cart items (keeping existing calculation)
    //     $totalAmount = $cartWithItems->sum('total_price');
    //     $totalItems = $cartWithItems->count();

    //     // Get refund policy
    //     $refundPolicy = \App\Models\RefundPolicy::first();

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Payment page data retrieved successfully',
    //         'data' => [
    //             'user_id' => $userId, // From cart_items only
    //             'cart_id' => $cartItem->cart_id, // From cart_items only
    //             'default_address' => $defaultAddress,
    //             'service_id' => $cartItem->item_type === 'service' ? $cartItem->item_id : null, // Service ID from cart_items
    //             'cart_details' => [
    //                 'id' => $cart->id,
    //                 'total' => $totalAmount,
    //                 'total_items' => $totalItems,
    //             ],
               
    //             'pricing_summary' => [
    //                 'subtotal' => $cartWithItems->sum(function($item) {
    //                     return $item->base_price * $item->quantity;
    //                 }),
    //                 'materials_total' => $cartWithItems->sum('addons_price'),
    //                 'discount_amount' => $cartWithItems->sum('discount_amount'),
    //                 'tax_amount' => $cartWithItems->sum('tax_amount'),
    //                 'total_amount' => $totalAmount,
    //                 'total_items_count' => $totalItems,
    //                 'currency' => 'AED'
    //             ],
    //             'refund_policy' => $refundPolicy ? [
    //                 'id' => $refundPolicy->id,
    //                 'title' => $refundPolicy->title,
    //                 'content' => $refundPolicy->content,
    //                 'created_at' => $refundPolicy->created_at,
    //             ] : null
    //         ]
    //     ]);
    // }
 

}
