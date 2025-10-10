<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\ServiceReview;
use App\Models\ServiceProviderReview;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewApiController extends Controller
{
    // Service Reviews
    public function indexServiceReviews(Request $request, $serviceId)
    {
        try {
            $reviews = ServiceReview::where('service_id', $serviceId)
                ->with('user:id,name,image')
                ->get();

            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Service reviews retrieved successfully',
                'data' => [
                    'reviews' => $reviews,
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'message' => 'Service reviews retrieval failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function storeServiceReview(Request $request, $serviceId)
    {
        try {
            $request->validate([
                
                'rating' => 'required|numeric|min:1|max:5',
                'review' => 'nullable|string',
            ]);

            $userId = Auth::id();

            // Check if service exists
            $service = Service::find($serviceId);
            if (!$service) {
                return response()->json([
                    'success' => false,
                    'status_code' => 404,
                    'message' => 'Service not found'
                ], 404);
            }

            // Check if user already reviewed this service
            $existingReview = ServiceReview::where('service_id', $serviceId)
                ->where('user_id', $userId)
                ->first();

            if ($existingReview) {
                // Update existing review
                $existingReview->update([
                    'rating' => $request->rating,
                    'review' => $request->review,
                ]);
                $review = $existingReview;
                $message = 'Service review updated successfully';
            } else {
                // Create new review
                $review = ServiceReview::create([
                    'service_id' => $serviceId,
                    'user_id' => $userId,
                    'rating' => $request->rating,
                    'review' => $request->review,
                ]);
                $message = 'Service review added successfully';
            }

            // Update average rating for service
            $averageRating = $service->serviceReviews()->avg('rating');
            $service->update(['average_rating' => $averageRating ?? 0]);

            return response()->json([
                'success' => true,
                'status_code' => 201,
                'message' => $message,
                'data' => [
                    'review' => $review->load('user:id,name,image'),
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'message' => 'Service review submission failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Service Provider Reviews
    public function indexServiceProviderReviews(Request $request, $serviceProviderId)
    {
        try {
            $reviews = ServiceProviderReview::where('service_provider_id', $serviceProviderId)
                ->with('reviewer:id,name,image')
                ->get();

            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Service provider reviews retrieved successfully',
                'data' => [
                    'reviews' => $reviews,
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'message' => 'Service provider reviews retrieval failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function storeServiceProviderReview(Request $request, $serviceProviderId)
    {
        try {
            $request->validate([
                'rating' => 'required|numeric|min:1|max:5',
                'review' => 'nullable|string',
            ]);

            $reviewerId = Auth::id();

            // Check if service provider exists and is a service provider
            $serviceProvider = User::where('id', $serviceProviderId)->where('role', 'serviceprovider')->first();
            if (!$serviceProvider) {
                return response()->json([
                    'success' => false,
                    'status_code' => 404,
                    'message' => 'Service provider not found'
                ], 404);
            }

            // Check if reviewer is not reviewing themselves
            if ($reviewerId == $serviceProviderId) {
                return response()->json([
                    'success' => false,
                    'status_code' => 400,
                    'message' => 'You cannot review yourself'
                ], 400);
            }

            // Check if reviewer already reviewed this service provider
            $existingReview = ServiceProviderReview::where('service_provider_id', $serviceProviderId)
                ->where('reviewer_id', $reviewerId)
                ->first();

            if ($existingReview) {
                // Update existing review
                $existingReview->update([
                    'rating' => $request->rating,
                    'review' => $request->review,
                ]);
                $review = $existingReview;
                $message = 'Service provider review updated successfully';
            } else {
                // Create new review
                $review = ServiceProviderReview::create([
                    'service_provider_id' => $serviceProviderId,
                    'reviewer_id' => $reviewerId,
                    'rating' => $request->rating,
                    'review' => $request->review,
                ]);
                $message = 'Service provider review added successfully';
            }

            // Update average rating for service provider
            $averageRating = $serviceProvider->serviceProviderReviewsReceived()->avg('rating');
            $serviceProvider->update(['average_rating' => $averageRating ?? 0]);

            return response()->json([
                'success' => true,
                'status_code' => 201,
                'message' => $message,
                'data' => [
                    'review' => $review->load('reviewer:id,name,image'),
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'message' => 'Service provider review submission failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
