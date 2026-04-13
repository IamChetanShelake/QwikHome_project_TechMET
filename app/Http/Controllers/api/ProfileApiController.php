<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\ProfileChangeRequest;
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
                'is_guest' => 0,    //this will disable guest mode also
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
    
    //get service provider personal information 
     public function getServiceProviderPersonalInfo(Request $request)
    {
        try {
            // Validate input data
            $validator = Validator::make($request->all(), [
                'serviceProviderId' => 'required|exists:users,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'status_code' => 422,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = User::find($request->serviceProviderId);
            if (!$user || !$user->isServiceProvider()) {
                return response()->json([
                    'success' => false,
                    'status_code' => 404,
                    'message' => 'Service provider not found'
                ], 404);
            }

            $data = [
                [
                    'title' => 'information protected',
                    'data' => 'For security reasons, personal information cannot be edited directly. To update your information, please request changes through our admin team.'
                ],
                [
                    'title' => 'Profile Photo',
                    'data'=> $user->image_url,
                ],
                [
                    'title' => 'basic information',
                    'data'=>[
                    'name' => $user->name,
                    'email' => $user->email,
                    'biography' => $user->biography,
                    ]
                ],
                [
                    'title' => 'Concact Information',
                    'data' => [
                         'phone' => $user->phone,
                         'alternatePhone' => $user->alternatePhone,
                        ],
                ],
                [
                    'title' => 'Address',
                    'data' => $user->address,
                ],
            ];

            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Service provider personal information fetched successfully',
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'message' => 'Failed to fetch service provider personal information',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
     public function requestProfileChange(Request $request)
    {
        try {
            // Validate input data - only serviceProviderId is required
            $validator = Validator::make($request->all(), [
                'serviceProviderId' => 'required|exists:users,id',
                'reason' => 'nullable|string',
                'name' => 'nullable|string|max:255',
                'email' => 'nullable|string|email|max:255',
                'phone' => 'nullable|string|max:15',
                'alternatePhone' => 'nullable|string|max:15',
                'biography' => 'nullable|string',
                'address' => 'nullable|string',
                'profileImage' => 'nullable|image'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'status_code' => 422,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = User::find($request->serviceProviderId);
            if (!$user || !$user->isServiceProvider()) {
                return response()->json([
                    'success' => false,
                    'status_code' => 404,
                    'message' => 'Service provider not found'
                ], 404);
            }

            // Check if there's already a pending request
            $existingRequest = ProfileChangeRequest::where('service_provider_id', $request->serviceProviderId)
                ->where('status', 'pending')
                ->first();

            if ($existingRequest) {
                return response()->json([
                    'success' => false,
                    'status_code' => 400,
                    'message' => 'You already have a pending profile change request'
                ], 400);
            }

            // Build requested data only with provided fields
            $requestedData = [];

            if ($request->has('name') && $request->name !== null) {
                $requestedData['name'] = $request->name;
            }
            if ($request->has('email') && $request->email !== null) {
                $requestedData['email'] = $request->email;
            }
            if ($request->has('phone') && $request->phone !== null) {
                $requestedData['phone'] = $request->phone;
            }
            if ($request->has('alternatePhone') && $request->alternatePhone !== null) {
                $requestedData['alternatePhone'] = $request->alternatePhone;
            }
            if ($request->has('biography') && $request->biography !== null) {
                $requestedData['biography'] = $request->biography;
            }
            if ($request->has('address') && $request->address !== null) {
                $requestedData['address'] = $request->address;
            }

            // Handle profile image upload
            if ($request->hasFile('profileImage')) {
                $imageName = time() . '.' . $request->profileImage->extension();
                $request->profileImage->move('user_images', $imageName);
                $requestedData['profileImage'] = $imageName;
            }

            // Check if at least one field is being changed
            if (empty($requestedData)) {
                return response()->json([
                    'success' => false,
                    'status_code' => 400,
                    'message' => 'At least one field must be provided for the profile change request'
                ], 400);
            }

            // Create the profile change request
            ProfileChangeRequest::create([
                'service_provider_id' => $request->serviceProviderId,
                'reason' => $request->reason,
                'requested_data' => $requestedData,
                'status' => 'pending'
            ]);

            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Profile change request submitted successfully. It will be reviewed by admin.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'message' => 'Failed to submit profile change request',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    //settings page api in servicePRovider app 
    public function settings(Request $request)
    {
        try {
            // Validate input data
            $validator = Validator::make($request->all(), [
                'serviceProviderId' => 'required|exists:users,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'status_code' => 422,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = User::find($request->serviceProviderId);
            if (!$user || !$user->isServiceProvider()) {
                return response()->json([
                    'success' => false,
                    'status_code' => 404,
                    'message' => 'Service provider not found'
                ], 404);
            }

            // Get completed bookings count for this service provider
            $completedBookings = $user->bookingsAsServiceProvider()->where('status', 'completed')->count();

            // Build the response data structure
            $data = [
                // Welcome section with name, message, image
                [
                    'welcome_message' => 'Hello, Welcome Back ' . $user->name,
                    'name' => $user->name,
                    'image_url' => $user->image_url,
                ],
                // Statistics section
                [
                    'bookings_completed' => $completedBookings,
                    'member_since' => $user->created_at->format('Y-m-d'),
                ],
                // Settings menu items
                [
                    [
                        'title' => 'Personal Info',
                        'description' => 'Name, contact, location'
                    ],
                    [
                        'title' => 'Service details',
                        'description' => 'Service offered, area'
                    ],
                    [
                        'title' => 'Service Areas',
                        'description' => 'Manage service locations'
                    ],
                    [
                        'title' => 'Payment & Banking',
                        'description' => 'Payment details, payment methods'
                    ],
                    [
                        'title' => 'Account & Security',
                        'description' => 'Password, Privacy, Security'
                    ],
                    [
                        'title' => 'Support',
                        'description' => 'Help center, contact support'
                    ],
                    [
                        'title' => 'About us',
                        'description' => 'App info, terms & conditions'
                    ],
                    [
                        'title' => 'Log out',
                        'description' => 'Sign out of your account'
                    ]
                ]
            ];

            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Settings data retrieved successfully',
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'message' => 'Failed to retrieve settings data',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
