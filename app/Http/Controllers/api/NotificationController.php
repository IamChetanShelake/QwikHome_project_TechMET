<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\CartItem;
use App\Models\PaymentTransaction;
use App\Services\FirebaseService;

class NotificationController extends Controller
{
    protected $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    /**
     * Send booking confirmation notification
     */
    public function sendBookingConfirmation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'cart_item_id' => 'required|exists:cart_items,id',
            'transaction_id' => 'required|exists:payment_transactions,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = User::findOrFail($request->user_id);
            $cartItem = CartItem::findOrFail($request->cart_item_id);
            $paymentTransaction = PaymentTransaction::findOrFail($request->transaction_id);

            // Verify the cart item belongs to the user
            if ($cartItem->user_id !== $user->id) {
                return response()->json([
                    'status' => false,
                    'message' => 'Cart item does not belong to the specified user'
                ], 403);
            }

            $service = $cartItem->getServiceAttribute();

            if (!$service) {
                return response()->json([
                    'status' => false,
                    'message' => 'Service not found for the cart item'
                ], 404);
            }

            // Check if user has FCM token
            if (!$user->fcm_token) {
                return response()->json([
                    'status' => false,
                    'message' => 'User does not have FCM token registered'
                ], 400);
            }

            $title = 'Booking Confirmed!';
            $body = "Your booking for {$service->name} has been confirmed. Amount: AED {$paymentTransaction->amount}";

            // Send push notification
            $this->firebaseService->sendPush($user->fcm_token, $title, $body);

            Log::info('NotificationController: Booking confirmation notification sent', [
                'user_id' => $user->id,
                'cart_item_id' => $cartItem->id,
                'transaction_id' => $paymentTransaction->id
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Booking confirmation notification sent successfully',
                'data' => [
                    'notification_title' => $title,
                    'notification_body' => $body,
                    'sent_to_user' => $user->id,
                    'fcm_token_used' => substr($user->fcm_token, 0, 20) . '...'
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('NotificationController: Failed to send booking confirmation notification', [
                'error' => $e->getMessage(),
                'user_id' => $request->user_id,
                'cart_item_id' => $request->cart_item_id,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => false,
                'message' => 'Failed to send notification: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Send booking cancellation notification
     */
    public function sendBookingCancellation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'cart_item_id' => 'required|exists:cart_items,id',
            'reason' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = User::findOrFail($request->user_id);
            $cartItem = CartItem::findOrFail($request->cart_item_id);

            // Verify the cart item belongs to the user
            if ($cartItem->user_id !== $user->id) {
                return response()->json([
                    'status' => false,
                    'message' => 'Cart item does not belong to the specified user'
                ], 403);
            }

            $service = $cartItem->getServiceAttribute();

            if (!$service) {
                return response()->json([
                    'status' => false,
                    'message' => 'Service not found for the cart item'
                ], 404);
            }

            // Check if user has FCM token
            if (!$user->fcm_token) {
                return response()->json([
                    'status' => false,
                    'message' => 'User does not have FCM token registered'
                ], 400);
            }

            $title = 'Booking Cancelled';
            $body = "Your booking for {$service->name} has been cancelled.";

            if ($request->reason) {
                $body .= " Reason: {$request->reason}";
            }

            // Send push notification
            $this->firebaseService->sendPush($user->fcm_token, $title, $body);

            Log::info('NotificationController: Booking cancellation notification sent', [
                'user_id' => $user->id,
                'cart_item_id' => $cartItem->id,
                'reason' => $request->reason
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Booking cancellation notification sent successfully',
                'data' => [
                    'notification_title' => $title,
                    'notification_body' => $body,
                    'sent_to_user' => $user->id,
                    'cancellation_reason' => $request->reason,
                    'fcm_token_used' => substr($user->fcm_token, 0, 20) . '...'
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('NotificationController: Failed to send booking cancellation notification', [
                'error' => $e->getMessage(),
                'user_id' => $request->user_id,
                'cart_item_id' => $request->cart_item_id,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => false,
                'message' => 'Failed to send notification: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Send booking status update notification
     */
    public function sendBookingStatusUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'cart_item_id' => 'required|exists:cart_items,id',
            'status' => 'required|in:confirmed,in_progress,completed,cancelled',
            'additional_info' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = User::findOrFail($request->user_id);
            $cartItem = CartItem::findOrFail($request->cart_item_id);

            // Verify the cart item belongs to the user
            if ($cartItem->user_id !== $user->id) {
                return response()->json([
                    'status' => false,
                    'message' => 'Cart item does not belong to the specified user'
                ], 403);
            }

            $service = $cartItem->getServiceAttribute();

            if (!$service) {
                return response()->json([
                    'status' => false,
                    'message' => 'Service not found for the cart item'
                ], 404);
            }

            // Check if user has FCM token
            if (!$user->fcm_token) {
                return response()->json([
                    'status' => false,
                    'message' => 'User does not have FCM token registered'
                ], 400);
            }

            $statusMessages = [
                'confirmed' => ['Booking Confirmed', "Your booking for {$service->name} has been confirmed and payment processed."],
                'in_progress' => ['Service Started', "Work has started on your {$service->name} booking."],
                'completed' => ['Service Completed', "Your {$service->name} service has been completed successfully."],
                'cancelled' => ['Booking Cancelled', "Your booking for {$service->name} has been cancelled."],
            ];

            [$title, $body] = $statusMessages[$request->status];

            if ($request->additional_info) {
                $body .= " {$request->additional_info}";
            }

            // Send push notification
            $this->firebaseService->sendPush($user->fcm_token, $title, $body);

            Log::info('NotificationController: Booking status update notification sent', [
                'user_id' => $user->id,
                'cart_item_id' => $cartItem->id,
                'status' => $request->status
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Booking status update notification sent successfully',
                'data' => [
                    'notification_title' => $title,
                    'notification_body' => $body,
                    'sent_to_user' => $user->id,
                    'booking_status' => $request->status,
                    'fcm_token_used' => substr($user->fcm_token, 0, 20) . '...'
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('NotificationController: Failed to send booking status update notification', [
                'error' => $e->getMessage(),
                'user_id' => $request->user_id,
                'cart_item_id' => $request->cart_item_id,
                'status' => $request->status,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => false,
                'message' => 'Failed to send notification: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Send notification to multiple users
     */
    public function sendBatchNotifications(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_ids' => 'required|array|min:1',
            'user_ids.*' => 'exists:users,id',
            'title' => 'required|string|max:255',
            'body' => 'required|string|max:1000',
            'type' => 'required|string|max:100',
            'data' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $users = User::whereIn('id', $request->user_ids)->get();
            $successCount = 0;
            $failureCount = 0;
            $results = [];

            foreach ($users as $user) {
                if ($user->fcm_token) {
                    try {
                        $this->firebaseService->sendPush($user->fcm_token, $request->title, $request->body);

                        $successCount++;
                        $results[] = [
                            'user_id' => $user->id,
                            'status' => 'success'
                        ];
                    } catch (\Exception $e) {
                        $failureCount++;
                        $results[] = [
                            'user_id' => $user->id,
                            'status' => 'failed',
                            'error' => $e->getMessage()
                        ];
                    }
                } else {
                    $failureCount++;
                    $results[] = [
                        'user_id' => $user->id,
                        'status' => 'failed',
                        'error' => 'No FCM token'
                    ];
                }
            }

            Log::info('NotificationController: Batch notification completed', [
                'total_users' => count($users),
                'success_count' => $successCount,
                'failure_count' => $failureCount
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Batch notification processing completed',
                'data' => [
                    'total_users' => count($users),
                    'success_count' => $successCount,
                    'failure_count' => $failureCount,
                    'results' => $results
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('NotificationController: Failed to send batch notifications', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => false,
                'message' => 'Failed to send batch notifications: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cancel booking with notification
     */
    public function cancelBooking(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'cart_item_id' => 'required|exists:cart_items,id',
            'cancellation_reason' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = User::findOrFail($request->user_id);
            $cartItem = CartItem::findOrFail($request->cart_item_id);

            // Verify the cart item belongs to the user
            if ($cartItem->user_id !== $user->id) {
                return response()->json([
                    'status' => false,
                    'message' => 'Cart item does not belong to the specified user'
                ], 403);
            }

            $service = $cartItem->getServiceAttribute();

            if (!$service) {
                return response()->json([
                    'status' => false,
                    'message' => 'Service not found for the cart item'
                ], 404);
            }

            // Here you would typically update the booking status in your database
            // For now, we'll just send the notification

            $title = 'Booking Cancelled';
            $body = "Your booking for {$service->name} has been cancelled.";

            if ($request->cancellation_reason) {
                $body .= " Reason: {$request->cancellation_reason}";
            }

            // Check if user has FCM token
            if (!$user->fcm_token) {
                return response()->json([
                    'status' => false,
                    'message' => 'User does not have FCM token registered for notifications'
                ], 400);
            }

            // Send push notification
            $this->firebaseService->sendPush($user->fcm_token, $title, $body);

            Log::info('NotificationController: Booking cancelled with notification', [
                'user_id' => $user->id,
                'cart_item_id' => $cartItem->id,
                'cancellation_reason' => $request->cancellation_reason
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Booking cancelled and notification sent successfully',
                'data' => [
                    'cancelled_booking' => [
                        'cart_item_id' => $cartItem->id,
                        'service_name' => $service->name,
                        'cancellation_reason' => $request->cancellation_reason
                    ],
                    'notification_sent' => [
                        'title' => $title,
                        'body' => $body,
                        'sent_to_user' => $user->id
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('NotificationController: Failed to cancel booking with notification', [
                'error' => $e->getMessage(),
                'user_id' => $request->user_id,
                'cart_item_id' => $request->cart_item_id,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => false,
                'message' => 'Failed to cancel booking: ' . $e->getMessage()
            ], 500);
        }
    }
}