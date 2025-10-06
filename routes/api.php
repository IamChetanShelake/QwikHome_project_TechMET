<?php

use App\Http\Controllers\api\AuthApiController;
use App\Http\Controllers\FeedbackController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/test', function (Request $request) {
    return response()->json([
        'status' => true,
        'status_code' => 200,
        'message' => 'API is working!'
    ], 200);
});

// Authentication routes
Route::post('/signup', [AuthApiController::class, 'signup']);
Route::post('/login', [AuthApiController::class, 'login']);

// Protected routes (require authentication)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [AuthApiController::class, 'logout']);

    // Feedback API routes
    Route::post('/feedbacks/{bookingId}', [FeedbackController::class, 'store'])->name('api.feedback.store');
    Route::get('/services/{serviceId}/feedbacks', [FeedbackController::class, 'serviceFeedbacks']);
    Route::get('/employees/{employeeId}/feedbacks', [FeedbackController::class, 'employeeFeedbacks']);
    Route::get('/services/{serviceId}/rating', [FeedbackController::class, 'serviceRating']);
    Route::get('/employees/{employeeId}/rating', [FeedbackController::class, 'employeeRating']);
});
