<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserApiController extends Controller
{
    public function updateFcmToken(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'fcm_token' => 'required|string',
            ]);

            $user = User::find($request->user_id);

            // Store old token for logging
            $oldToken = $user->fcm_token;

            $user->fcm_token = $request->fcm_token;
            $user->save();

            Log::info('FCM Token Updated', [
                'user_id' => $request->user_id,
                'old_token_prefix' => $oldToken ? substr($oldToken, 0, 20) . '...' : null,
                'new_token_prefix' => substr($request->fcm_token, 0, 20) . '...',
                'updated_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'FCM token updated successfully',
                'data' => [
                    'user_id' => $user->id,
                    'updated_at' => $user->updated_at
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            Log::error('FCM Token Update Failed', [
                'error' => $e->getMessage(),
                'user_id' => $request->input('user_id'),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to update FCM token: ' . $e->getMessage()
            ], 500);
        }
    }
}