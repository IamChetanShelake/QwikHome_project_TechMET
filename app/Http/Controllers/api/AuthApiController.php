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
                'password' => ['required', 'confirmed'],
                'password_confirmation' => 'required',
                'role' => 'nullable|in:customer,vendor,admin'
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
                'password' => Hash::make($request->password),
                'role' => $request->role ?? 'customer',
                'active' => 1
            ]);



            return response()->json([
                'success' => true,
                'status_code' => 201,
                'message' => 'User registered successfully',
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
            // Validate input data - user can login with either email or phone
            $validator = Validator::make($request->all(), [
                'password' => 'required|string',
                'email' => 'nullable|email|exists:users,email',
                'phone' => 'nullable|string|exists:users,phone',
            ]);

            // Custom validation: at least one of email or phone must be provided
            $validator->after(function ($validator) use ($request) {
                if (empty($request->email) && empty($request->phone)) {
                    $validator->errors()->add('login', 'Either email or phone number is required for login.');
                }
                if (!empty($request->email) && !empty($request->phone)) {
                    $validator->errors()->add('login', 'Please provide either email OR phone number, not both.');
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

            // Check if user exists and password is correct
            // User can login with either email or phone
            $loginField = $request->has('email') ? 'email' : 'phone';
            $loginValue = $request->input($loginField);

            if (!Auth::attempt([$loginField => $loginValue, 'password' => $request->password])) {
                return response()->json([
                    'success' => false,
                    'status_code' => 401,
                    'message' => 'Invalid credentials'
                ], 401);
            }

            $user = Auth::user();

            // Check if user is active
            if ($user->active != 1) {
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
}
