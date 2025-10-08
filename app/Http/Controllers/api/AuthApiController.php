<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AuthApiController extends Controller
{
  public function signup(Request $request)
    {
        try {
            // Validate input data
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'phone' => 'required|string|max:15|unique:users',
                'role' => 'nullable'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'status_code' => 422,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Create user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                 'password' => null,
                'role' => 'user',
                'active' => 0
            ]);

            return response()->json([
                'success' => true,
                'status_code' => 201,
                'message' => 'User registered successfully',
                'otp' => '123456',
                'user' => $user,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'message' => 'Registration failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            // Validate input data - user can login with either email or phone and otp
            $validator = Validator::make($request->all(), [
                'otp' => 'nullable|string',
                'phone' => 'required|string|exists:users,phone',
            ]);

            // Custom validation: at least one of email or phone must be provided
            $validator->after(function ($validator) use ($request) {
                if (empty($request->phone)) {
                    $validator->errors()->add('login', 'phone number is required for login.');
                }
            });

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'status_code' => 422,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Check if user exists and OTP is correct
            // User can login with either email or phone
            $loginField = $request->has('phone') ?? 'phone';
            $loginValue = $request->input($loginField);

            $user = User::where($loginField, $loginValue)->first();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'status_code' => 401,
                    'message' => 'Invalid credentials'
                ], 401);
            }

            Auth::login($user);

            // Check if user is active
            if ($user->active == 1) {
                return response()->json([
                    'success' => false,
                    'status_code' => 403,
                    'message' => 'Account is deactivated'
                ], 403);
            }

            // Delete existing tokens (optional - depends on requirement)
            $user->tokens()->delete();

            // Generate new token
            $token = $user->createToken('API Token')->plainTextToken;

            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Login successful',
                'data' => [
                    'otp' => 654321,
                    'user' => $user,
                    'token' => $token
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'message' => 'Login failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $userID = $request->userid;
            $user = User::find($userID);
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'status_code' => 404,
                    'message' => 'User not found'
                ], 404);
            }
            // Delete the current access token
            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Logout successful'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'message' => 'Logout failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteAccount(Request $request)
    {
        try {
            // Validate userid
            $validator = Validator::make($request->all(), [
                'userid' => 'required|exists:users,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'status_code' => 422,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = User::find($request->userid);

            // Mark account as deleted
            $user->update([
                'is_deleted' => 1,
                'deleted_at' => now()
            ]);

            // Optional: Delete current access token so they can't use it anymore
            $user->currentAccessToken()->delete();

            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Account deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'message' => 'Account deletion failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
