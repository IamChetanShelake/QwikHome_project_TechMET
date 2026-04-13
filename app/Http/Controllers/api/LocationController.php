<?php
    
    namespace App\Http\Controllers\API;
    
    use App\Http\Controllers\Controller;
    use App\Models\User;
    use Illuminate\Http\Request;
    use Illuminate\Http\JsonResponse;
    
    class LocationController extends Controller
    {
        /**
         * Fetch current user's location (only for service providers).
         */
        public function show(Request $request): JsonResponse
        {
            $userId = $request->user;
            $serviceProviderId = $request->serviceProvider;
            
            $user = User::where('role','user')->find($userId);
            $serviceProvider = User::where('role','serviceprovider')->find($serviceProviderId);
    
            // if ($serviceProvider->role !== 'serviceprovider') {
            //     return response()->json(['error' => 'Access denied'], 403);
            // }
    
            return response()->json([
                'user' => [
                'latitude' => $user->latitude ?? null,
                'longitude' => $user->longitude ?? null,
                'last_updated' => $user->last_location_update ?? null,
                    ],
              'serviceprovider'=>[
                'latitude' => $serviceProvider->latitude ?? null ,
                'longitude' => $serviceProvider->longitude ?? null ,
                'last_updated' => $serviceProvider->last_location_update ?? null,
                  ],
            ]);
        }
    //     public function show(Request $request): JsonResponse
    // {
    //     // Accept both GET param & POST body
    //     $userId = $request->input('user');
    //     $serviceProviderId = $request->input('serviceProvider');
    
    //     if (!$userId || !$serviceProviderId) {
    //         return response()->json([
    //             'error' => 'user and serviceProvider fields are required'
    //         ], 400);
    //     }
    
    //     // Fetch correct user & provider
    //     $user = User::where('role', 'user')->find($userId);
    //     $serviceProvider = User::where('role', 'serviceprovider')->find($serviceProviderId);
    
    //     // Handle missing records safely
    //     if (!$user) {
    //         return response()->json([
    //             'error' => 'User not found',
    //         ], 404);
    //     }
    
    //     if (!$serviceProvider) {
    //         return response()->json([
    //             'error' => 'Service Provider not found',
    //         ], 404);
    //     }
    
    //     // Final safe output format
    //     return response()->json([
    //         'user' => [
    //             'latitude'      => $user->latitude ?? null,
    //             'longitude'     => $user->longitude ?? null,
    //             'last_updated'  => $user->last_location_update ?? null,
    //         ],
    
    //         'serviceprovider' => [
    //             'latitude'      => $serviceProvider->latitude ?? null,
    //             'longitude'     => $serviceProvider->longitude ?? null,
    //             'last_updated'  => $serviceProvider->last_location_update ?? null,
    //         ]
    //     ]);
    // }
    
        /**
         * Update current user's location (only for service providers).
         */
         public function update(Request $request): JsonResponse
{
    $request->validate([
        'userLatitude' => 'nullable|numeric',
        'userLongitude' => 'nullable|numeric',
        'serviceProviderLatitude' => 'nullable|numeric',
        'serviceProviderLongitude' => 'nullable|numeric',
    ]);

    $userId = $request->user ?? null;
    $serviceProviderId = $request->serviceProvider ?? null;

    $timestamp = now()->format('Y-m-d H:i:s'); // use 4-digit year

    $updatedUser = null;
    $updatedProvider = null;

    // --------- UPDATE USER ---------
    if (!empty($userId)) {
        $user = User::find($userId);

        if ($user && $request->filled('userLatitude') && $request->filled('userLongitude')) {

            $user->update([
                'latitude' => $request->userLatitude,
                'longitude' => $request->userLongitude,
                'last_location_update' => $timestamp,
            ]);

            $updatedUser = [
                'latitude' => $user->latitude,
                'longitude' => $user->longitude,
                'last_updated' => $user->last_location_update,
            ];
        }
    }

    // --------- UPDATE SERVICE PROVIDER ---------
    if (!empty($serviceProviderId)) {
        $serviceprovider = User::find($serviceProviderId);

        if ($serviceprovider && $request->filled('serviceProviderLatitude') && $request->filled('serviceProviderLongitude')) {

            $serviceprovider->update([
                'latitude' => $request->serviceProviderLatitude,
                'longitude' => $request->serviceProviderLongitude,
                'last_location_update' => $timestamp,
            ]);

            $updatedProvider = [
                'latitude' => $serviceprovider->latitude,
                'longitude' => $serviceprovider->longitude,
                'last_updated' => $serviceprovider->last_location_update,
            ];
        }
    }

    // ------------ RESPONSE LOGIC (UNCHANGED STRUCTURE) ------------

    // If only user updated
    if ($updatedUser && !$updatedProvider) {
        return response()->json([
            'message' => 'Location updated for  User  Successfully',
            'user' => $updatedUser
        ]);
    }

    // If only provider updated
    if ($updatedProvider && !$updatedUser) {
        return response()->json([
            'message' => 'Location updated for ServicePRovider Successfully',
            'serviceProvider' => $updatedProvider
        ]);
    }

    // If both updated
    if ($updatedUser && $updatedProvider) {
        return response()->json([
            'message' => 'Location updated for both User and ServicePRovider Successfully',
            'user' => $updatedUser,
            'serviceProvider' => $updatedProvider,
        ]);
    }

    // If neither updated
    return response()->json([
        'message' => 'No location updated. Missing or invalid data.',
    ], 400);
}

        // public function update(Request $request): JsonResponse
        // {
        //       $request->validate([
        //         'userLatitude' => 'nullable|numeric',
        //         'userLongitude' => 'nullable|numeric',
        //         'serviceProviderLatitude' => 'nullable|numeric',
        //         'serviceProviderLongitude' => 'nullable|numeric',
        //     ]);
    
    
        //     $userId = $request->user ?? null;
        //     $serviceProviderId = $request->serviceProvider ?? null;
            
            
        //     $userlat =  $request->userLatitude ?? null;
        //     $userlong =  $request->userLongitude ?? null;
        //     $providerlat =  $request->serviceProviderLatitude ?? null;
        //     $providerlong =  $request->serviceProviderLongitude ?? null;
            
        //     $user = $userId ? User::find($userId) : null;
        //     $serviceprovider = $serviceProviderId ? User::find($serviceProviderId) : null;
    
        //   if(!empty($user)){
        //     $user->update([
        //         'latitude' => $userlat,
        //         'longitude' => $userlong,
        //         'last_location_update' => now()->format('y-m-d H:i:s'),
        //     ]);
            
        //       return response()->json([
                
        //         'message' => 'Location updated for  User  Successfully',
                
        //         'user'=> [
        //         'latitude' => $user->latitude,
        //         'longitude' => $user->longitude,
        //         'last_updated' => $user->last_location_update,
        //             ],
                
        //     ]);
        //   }
            
        //     if(!empty($serviceprovider)){
        //     $serviceprovider->update([
        //         'latitude' => $providerlat,
        //         'longitude' => $providerlong,
        //         'last_location_update' => now()->format('y-m-d H:i:s'),
        //     ]);
            
        //       return response()->json([
                
        //         'message' => 'Location updated for ServicePRovider Successfully',
                
        //         'serviceProvider'=>[
        //              'latitude' => $serviceprovider->latitude,
        //         'longitude' => $serviceprovider->longitude,
        //         'last_updated' => $serviceprovider->last_location_update,
        //             ],
                
        //     ]);
        //     }
            
        //     // return response()->json([
                
        //     //     'message' => 'Location updated for both User and ServicePRovider Successfully',
                
        //     //     'user'=> [
        //     //     'latitude' => $user->latitude,
        //     //     'longitude' => $user->longitude,
        //     //     'last_updated' => $user->last_location_update,
        //     //         ],
        //     //     'serviceProvider'=>[
        //     //          'latitude' => $serviceprovider->latitude,
        //     //     'longitude' => $serviceprovider->longitude,
        //     //     'last_updated' => $serviceprovider->last_location_update,
        //     //         ],
                
        //     // ]);
        // }
    }
