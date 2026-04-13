<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Service;
use App\Models\Offer;
use Illuminate\Support\Facades\Log;

class WishlistApiController extends Controller
{
    /**
     * Get user's wishlist
     */
    public function index(Request $request)
    {
        try {
            $request->validate([
                'user' => 'required|exists:users,id',
            ]);

            $wishlists = Wishlist::with(['service', 'offers'])
                ->where('user_id', $request->user)
                ->get();

            $wishlistData = $wishlists->map(function ($wishlist) {
                
                // Add onetime_price array before subscription_plans
                  $onetimeOption = $wishlist->service->subscriptionPlans->where('frequency_type', 'onetime')->first();
                return [
                    'wishlist' => $wishlist,
                    'onetime_price'=>$onetimeOption ? $onetimeOption->price_per_time : null,
                    'service' => $wishlist->service,
                    'offer' => $wishlist->offers,
                   
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Wishlist retrieved successfully',
                'data' => $wishlistData
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            Log::error('Get Wishlist Failed', [
                'error' => $e->getMessage(),
                'user_id' => $request->input('user'),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve wishlist: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Add service or offer to wishlist
     */
     public function store(Request $request)
{
    try {
        $request->validate([
            'user' => 'required|exists:users,id',
            'service' => 'nullable|exists:services,id',
            'offer' => 'nullable|exists:offers,id',
            'wishlisted' => 'required|boolean', // true or false
        ]);

        if (!$request->service && !$request->offer) {
            return response()->json([
                'success' => false,
                'message' => 'Either service_id or offer_id must be provided'
            ], 422);
        }

        // Find existing wishlist entry (either by service or offer)
        // $existingWishlist = Wishlist::where('user_id', $request->user)
        //     ->when($request->service, function ($q)
        //     { 
        //         return  $q->where('service_id', $request->service) ;
        //     }) 
            
        //     ->when($request->offer, function ($q) { return $q->where('offer_id', $request->offer); })
        //     ->first();
        
          $existingWishlist = Wishlist::where('user_id',  $request->user)
        ->where('service_id',  $request->service)
        ->first();

        // CASE 1: wishlisted = true → Add item
        if ($request->wishlisted == true) {
            if ($existingWishlist) {
                return response()->json([
                    'success' => false,
                    'message' => 'Item already exists in wishlist'
                ], 409);
            }

            $wishlist = Wishlist::create([
                'user_id' => $request->user,
                'service_id' => $request->service,
                'offer_id' => $request->offer,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Item added to wishlist successfully',
                'data' => [
                    'wishlist' => $wishlist,
                    'is_wishlisted' => true,
                    'added_at' => $wishlist->created_at
                ]
            ], 201);
        }

        // CASE 2: wishlisted = false → Remove item
        if ($request->wishlisted == false) {
            if (!$existingWishlist) {
                return response()->json([
                    'success' => false,
                    'message' => 'Item not found in wishlist',
                    'is_wishlisted' => false
                ], 404);
            }

            $existingWishlist->delete();

            return response()->json([
                'success' => true,
                'message' => 'Item removed from wishlist successfully',
                'is_wishlisted' => false
            ], 200);
        }

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Validation failed',
            'errors' => $e->errors()
        ], 422);

    } catch (\Exception $e) {
        \Log::error('Add/Remove Wishlist Failed', [
            'error' => $e->getMessage(),
            'user_id' => $request->input('user'),
            'service_id' => $request->input('service'),
            'offer_id' => $request->input('offer'),
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Wishlist operation failed: ' . $e->getMessage()
        ], 500);
    }
}

    /**
     * Remove item from wishlist
     */
    public function destroy(Request $request)
    {
        try {
            $request->validate([
                'user' => 'required|exists:users,id',
                'wishlist_id' => 'required|exists:wishlists,id',
            ]);

            $userid = $request->user;
            $id = $request->wishlist_id;
            $wishlist = Wishlist::where('user_id', $userid)
                ->where('id', $id)
                ->first();


            if (!$wishlist) {
                return response()->json([
                    'success' => false,
                    'message' => 'Wishlist item not found'
                ], 404);
            }

            $userId = $wishlist->user;
            $serviceId = $wishlist->service;
            $offerId = $wishlist->offer;

            $wishlist->delete();

            Log::info('Item removed from wishlist', [
                'user_id' => $userId,
                'service_id' => $serviceId,
                'offer_id' => $offerId,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Item removed from wishlist successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Remove from Wishlist Failed', [
                'error' => $e->getMessage(),
                'wishlist_id' => $id,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to remove item from wishlist: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove specific service or offer from user's wishlist
     */
    public function removeItem(Request $request)
    {
        try {
            $request->validate([
                'user' => 'required|exists:users,id',
                'service' => 'nullable|exists:services,id',
                'offer' => 'nullable|exists:offers,id',
            ]);

            if (!$request->service && !$request->offer) {
                return response()->json([
                    'success' => false,
                    'message' => 'Either service_id or offer_id must be provided'
                ], 422);
            }

            $wishlist = Wishlist::where('user_id', $request->user)
                ->where(function ($query) use ($request) {
                    if ($request->service) {
                        $query->where('service_id', $request->service);
                    }
                    if ($request->offer) {
                        $query->where('offer_id', $request->offer);
                    }
                })
                ->first();

            if (!$wishlist) {
                return response()->json([
                    'success' => false,
                    'message' => 'Item not found in wishlist'
                ], 404);
            }

            $wishlist->delete();

            Log::info('Item removed from wishlist', [
                'user_id' => $request->user,
                'service_id' => $request->service,
                'offer_id' => $request->offer,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Item removed from wishlist successfully'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Remove Item from Wishlist Failed', [
                'error' => $e->getMessage(),
                'user_id' => $request->input('user'),
                'service_id' => $request->input('service'),
                'offer_id' => $request->input('offer'),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to remove item from wishlist: ' . $e->getMessage()
            ], 500);
        }
    }
}
