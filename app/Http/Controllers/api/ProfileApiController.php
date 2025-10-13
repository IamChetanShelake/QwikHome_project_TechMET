<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProfileApiController extends Controller
{
    public function updateProfile(Request $request)
    {
        try {

            // Validate input data
            $validator = Validator::make($request->all(), [
                'user' => 'required|exists:users,id',
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:15',
                'email' => 'required|string|email|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'status_code' => 422,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = User::find($request->user);
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'status_code' => 404,
                    'message' => 'User dont exists'
                ], 404);
            }

            $data = [
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
            ];

            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image if exists
                $oldfile = public_path('user_images/' . $user->image);
                if ($user->image && file_exists($oldfile)) {
                    unlink($oldfile);
                }

                $imageName = time() . '.' . $request->image->extension();
                $request->image->move('user_images', $imageName);
                $data['image'] = $imageName;
            }

            // Update user profile
            $user->update($data);



            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Profile updated successfully',
                'user' => $user,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'message' => 'Profile update failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getProfile(Request $request)
    {
        try {
            // Validate input data
            $validator = Validator::make($request->all(), [
                'user' => 'required|exists:users,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'status_code' => 422,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = User::find($request->user);
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'status_code' => 404,
                    'message' => 'User dont exists'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Profile fetched successfully',
                'user' => $user,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'message' => 'Profile fetch failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
