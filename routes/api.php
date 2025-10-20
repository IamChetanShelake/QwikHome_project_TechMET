<?php

use App\Http\Controllers\api\AddressApiController;
use App\Http\Controllers\api\AuthApiController;
use App\Http\Controllers\api\ProfileApiController;
use App\Http\Controllers\api\ReviewApiController;
use App\Http\Controllers\api\ServiceApiController;
use App\Http\Controllers\api\PolicyApiController;
use App\Http\Controllers\api\UserApiController;
use App\Http\Controllers\api\WishlistApiController;
use App\Http\Controllers\FeedbackController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\HomeApiController;



Route::get('/test', function (Request $request) {
    return response()->json([
        'status' => true,
        'status_code' => 200,
        'message' => 'API is working!'
    ], 200);
});

// Authentication routes--------------
Route::post('/signup', [AuthApiController::class, 'signup']);
Route::post('/login', [AuthApiController::class, 'login']);
Route::post('/logout', [AuthApiController::class, 'logout']);
Route::post('/delete-account', [AuthApiController::class, 'deleteAccount']);

// profile routes-------------------
Route::post('/update-profile', [ProfileApiController::class, 'updateProfile']);
Route::post('/get-profile', [ProfileApiController::class, 'getProfile']);

//home-----------------------
Route::get('/home', [HomeApiController::class, 'index']);
Route::get('/banners', [HomeApiController::class, 'banners']);

//categories-----------------------
Route::get('/categories', [ServiceApiController::class, 'categories']);

//services-----------------------
Route::post('/services', [ServiceApiController::class, 'services']);

//everythingWeOffer-----------------------
Route::get('/everything-we-offer', [ServiceApiController::class, 'everythingWeOffer']);

//subcategoryServices-----------------------
Route::post('/servicesOfSubcategory', [ServiceApiController::class, 'subcategoryServices']);

//service view apis-----------------------
Route::post('/view-service', [ServiceApiController::class, 'viewService']);
Route::post('/qwikpick-service', [ServiceApiController::class, 'qwikpickService']);
Route::post('/beauty-easy-service', [ServiceApiController::class, 'beautyAndEasyService']);
Route::post('/view-offer', [ServiceApiController::class, 'viewOffer']);

// Address API routes
Route::post('/addresses', [AddressApiController::class, 'index']); // Get all addresses
Route::post('/addresses-store', [AddressApiController::class, 'store']); // Add new address
Route::post('/addresses-edit', [AddressApiController::class, 'update']); // Edit address
Route::post('/addresses-delete', [AddressApiController::class, 'destroy']); // Remove address

// Reviews API routes (public for viewing reviews)
Route::get('/services/{serviceId}/reviews', [ReviewApiController::class, 'indexServiceReviews']);
Route::get('/service-providers/{serviceProviderId}/reviews', [ReviewApiController::class, 'indexServiceProviderReviews']);

// Reviews API routes (protected for submitting reviews)
Route::post('/services/{serviceId}/reviews', [ReviewApiController::class, 'storeServiceReview']);
Route::post('/service-providers/{serviceProviderId}/reviews', [ReviewApiController::class, 'storeServiceProviderReview']);








// Protected routes (require authentication)

Route::get('/user', function (Request $request) {
    return $request->user();
});
// Profile API route

// Feedback API routes
Route::post('/feedbacks/{bookingId}', [FeedbackController::class, 'store'])->name('api.feedback.store');
Route::get('/services/{serviceId}/feedbacks', [FeedbackController::class, 'serviceFeedbacks']);
Route::get('/employees/{employeeId}/feedbacks', [FeedbackController::class, 'employeeFeedbacks']);
Route::get('/services/{serviceId}/rating', [FeedbackController::class, 'serviceRating']);
Route::get('/employees/{employeeId}/rating', [FeedbackController::class, 'employeeRating']);

// Policy API routes
Route::get('/disclaimer', [PolicyApiController::class, 'getDisclaimer']);
Route::get('/privacy-policy', [PolicyApiController::class, 'getPrivacyPolicy']);
// FCM Token Update API route
Route::post('/update-fcm-token', [UserApiController::class, 'updateFcmToken']);
Route::get('/refund-policy', [PolicyApiController::class, 'getRefundPolicy']);
Route::get('/terms-conditions', [PolicyApiController::class, 'getTermsConditions']);

// Wishlist API routes
Route::post('/wishlist', [WishlistApiController::class, 'store']); // Add to wishlist
Route::get('/wishlist', [WishlistApiController::class, 'index']); // Get user's wishlist
Route::delete('/wishlist/{id}', [WishlistApiController::class, 'destroy']); // Remove specific wishlist item
Route::post('/wishlist/remove-item', [WishlistApiController::class, 'removeItem']); // Remove specific service/offer from wishlist
