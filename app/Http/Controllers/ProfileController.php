<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Show the user's profile form.
     */
    public function show()
    {
        return view('admin.profile');
    }

    /**
     * Update the user's profile.
     */
    public function update(Request $request)
    {
        // Check if this is an AJAX request for image upload only
        if ($request->ajax() || $request->wantsJson()) {
            return $this->handleImageUpload($request);
        }

        // Regular form submission for full profile update
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore(auth()->id())],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed',
        ]);

        $user = auth()->user();

        // Check current password if changing password
        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect'])->withInput();
            }
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ];

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            $oldfile = public_path('user_images/' . $user->image);
            if ($user->image && file_exists()) {
                unlink($oldfile);
            }
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move('user_images', $imageName);
            $data['image'] = $imageName;
        }

        // Update password if provided
        if ($request->filled('new_password')) {
            $data['password'] = Hash::make($request->new_password);
        }

        $user->update($data);

        return back()->with('success', 'Profile updated successfully.');
    }

    /**
     * Handle AJAX image upload only.
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = auth()->user();

        try {
            // Delete old image if exists
            $oldfile = public_path('user_images/' . $user->image);
            if ($user->image && file_exists($oldfile)) {
                unlink($oldfile);
            }

            // Upload new image
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move('user_images', $imageName);

            // Update user with new image
            $user->update(['image' => $imageName]);

            return response()->json([
                'success' => true,
                'image_url' => asset('user_images/' . $imageName),
                'message' => 'Profile image updated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'errors' => ['image' => ['Upload failed. Please try again.']]
            ], 422);
        }
    }

    /**
     * Handle AJAX image upload (private method kept for backward compatibility).
     */
    private function handleImageUpload(Request $request)
    {
        return $this->uploadImage($request);
    }
    
    //profile change apis from serviceprovider and admin 
    

    public function getPendingProfileChangeRequests(Request $request)
    {
        try {
            // This would typically require admin authentication, but for now we'll assume it's handled
            $requests = ProfileChangeRequest::with('serviceProvider')
                ->where('status', 'pending')
                ->orderBy('created_at', 'desc')
                ->get();

            $formattedRequests = $requests->map(function ($request) {
                return [
                    'id' => $request->id,
                    'service_provider' => [
                        'id' => $request->serviceProvider->id,
                        'name' => $request->serviceProvider->name,
                        'email' => $request->serviceProvider->email,
                        'phone' => $request->serviceProvider->phone,
                        'current_image' => $request->serviceProvider->image_url
                    ],
                    'requested_data' => $request->requested_data,
                    'submitted_at' => $request->created_at->format('Y-m-d H:i:s')
                ];
            });

            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Pending profile change requests fetched successfully',
                'data' => $formattedRequests
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'message' => 'Failed to fetch pending requests',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function approveProfileChangeRequest(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'requestId' => 'required|exists:profile_change_requests,id',
                'adminId' => 'required|exists:users,id'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'status_code' => 422,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $changeRequest = ProfileChangeRequest::find($request->requestId);
            if (!$changeRequest || $changeRequest->status !== 'pending') {
                return response()->json([
                    'success' => false,
                    'status_code' => 404,
                    'message' => 'Profile change request not found or already processed'
                ], 404);
            }

            $user = $changeRequest->serviceProvider;
            $requestedData = $changeRequest->requested_data;

            // Update user data
            $updateData = [
                'name' => $requestedData['name'],
                'email' => $requestedData['email'],
                'phone' => $requestedData['phone'],
                'alternate_phone' => $requestedData['alternatePhone'],
                'biography' => $requestedData['biography'],
                'address' => $requestedData['address']
            ];

            // Handle profile image
            if ($requestedData['profileImage']) {
                // Delete old image if exists
                $oldfile = public_path('user_images/' . $user->image);
                if ($user->image && file_exists($oldfile)) {
                    unlink($oldfile);
                }

                // Move temp image to permanent location
                $tempPath = public_path('user_images/temp/' . $requestedData['profileImage']);
                $permanentPath = public_path('user_images/' . $requestedData['profileImage']);
                if (file_exists($tempPath)) {
                    rename($tempPath, $permanentPath);
                    $updateData['image'] = str_replace('_temp_', '_', $requestedData['profileImage']);
                }
            }

            $user->update($updateData);

            // Update request status
            $changeRequest->update([
                'status' => 'approved',
                'admin_id' => $request->adminId,
                'approved_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Profile change request approved successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'message' => 'Failed to approve profile change request',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function rejectProfileChangeRequest(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'requestId' => 'required|exists:profile_change_requests,id',
                'adminId' => 'required|exists:users,id'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'status_code' => 422,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $changeRequest = ProfileChangeRequest::find($request->requestId);
            if (!$changeRequest || $changeRequest->status !== 'pending') {
                return response()->json([
                    'success' => false,
                    'status_code' => 404,
                    'message' => 'Profile change request not found or already processed'
                ], 404);
            }

            // Delete temp image if exists
            if ($changeRequest->requested_data['profileImage']) {
                $tempPath = public_path('user_images/temp/' . $changeRequest->requested_data['profileImage']);
                if (file_exists($tempPath)) {
                    unlink($tempPath);
                }
            }

            // Update request status
            $changeRequest->update([
                'status' => 'rejected',
                'admin_id' => $request->adminId,
                'approved_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Profile change request rejected successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'message' => 'Failed to reject profile change request',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
