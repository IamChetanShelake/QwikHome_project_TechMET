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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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
            if ($user->image && file_exists(public_path('User_images/' . $user->image))) {
                unlink(public_path('User_images/' . $user->image));
            }
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move('User_images', $imageName);
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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = auth()->user();

        try {
            // Delete old image if exists
            if ($user->image && file_exists(public_path('User_images/' . $user->image))) {
                unlink(public_path('User_images/' . $user->image));
            }

            // Upload new image
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move('User_images', $imageName);

            // Update user with new image
            $user->update(['image' => $imageName]);

            return response()->json([
                'success' => true,
                'image_url' => asset('User_images/' . $imageName),
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
}
