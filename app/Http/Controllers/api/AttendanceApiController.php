<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\ServiceProviderAttendance;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class AttendanceApiController extends Controller
{
    /**
     * POST API: Punch in for a booking
     */
    public function punchIn(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'serviceProvider' => 'required|exists:users,id',
                'bookingId' => 'required|exists:bookings,id',
                'startImage' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'startNotes' => 'nullable|string|max:1000',
                'startLatitude' => 'nullable|numeric|between:-90,90',
                'startLongitude' => 'nullable|numeric|between:-180,180',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'status_code' => 400,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 400);
            }

            $serviceProviderId = $request->serviceProvider;
            $bookingId = $request->bookingId;

            // Check if booking exists and belongs to this service provider
            $booking = Booking::where('id', $bookingId)
                ->where('service_provider_id', $serviceProviderId)
                ->whereIn('status', ['accepted', 'assigned'])
                ->first();

            if (!$booking) {
                return response()->json([
                    'success' => false,
                    'status_code' => 404,
                    'message' => 'Booking not found or not assigned to this service provider'
                ], 404);
            }

            // Check if attendance already exists for this booking
            $attendance = ServiceProviderAttendance::where('serviceProviderId', $serviceProviderId)
                ->where('bookingId', $bookingId)
                ->first();

            if ($attendance && in_array($attendance->status, ['punchedIn','punchedOut', 'completed'])) {
                return response()->json([
                    'success' => false,
                    'status_code' => 409,
                    'message' => 'Attendance already punchedIn or completed for this booking'
                ], 409);
            }
                        

            // Handle image upload
            $startImagePath = null;
            if ($request->hasFile('startImage')) {
                $imageName = time()."_".$request->startImage->getClientOriginalName();
                $request->startImage->move('attendance_images',$imageName);
                // ->store('attendance_images', 'public');
            }

            //      return response()->json([
            //     'success' => true,
            //     'status_code' => 200,
            //     'data' => $imageName,
            //     'punchIn_time' => now()->format('Y-m-d H:i:s'),
            // ], 200);
            // Create or update attendance
            
                $attendance = ServiceProviderAttendance::create([
                    'serviceProviderId' => $serviceProviderId,
                    'bookingId' => $bookingId,
                    'status' => 'punchedIn',
                    'punchIn_time' => now(),
                    'startImage' => $imageName,
                    'startNotes' => $request->startNotes,
                    'startLatitude' => $request->startLatitude,
                    'startLongitude' => $request->startLongitude,
                ]);

                // Update booking status
                $booking->update(['status' => 'ongoing']);
        

            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Punched in successfully',
                'data' => [
                    'attendance' => $attendance->load(['serviceProvider', 'booking']),
                    // 'attendance' => [
                    //         'serviceProviderId'=>$attendance->serviceProviderId,
                    //         'bookingId'=>$attendance->bookingId,
                    //         'status'=>$attendance->status,
                    //         'punchIn_time'=>$attendance->punchIn_time->format('Y-m-d H:i:s'),
                    //         'startImage'=>$attendance->startImage,
                    //         'startNotes'=>$attendance->startNotes,
                    //         'startLatitude'=>$attendance->startLatitude,
                    //         'startLongitude'=>$attendance->startLongitude,
                    //     ],
                        'service_provider'=>$attendance->serviceProvider,
                        'booking'=>$attendance->booking,
                    'start_image_url' => $attendance->start_image_url,
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'message' => 'Failed to punch in',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * POST API: Punch out for a booking
     */
    public function punchOut(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'serviceProvider' => 'required|exists:users,id',
                'bookingId' => 'required|exists:bookings,id',
                'completionImage' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'completionNotes' => 'nullable|string|max:1000',
                'completionLatitude' => 'nullable|numeric|between:-90,90',
                'completionLongitude' => 'nullable|numeric|between:-180,180',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'status_code' => 400,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 400);
            }

            $serviceProviderId = $request->serviceProvider;
            $bookingId = $request->bookingId;

            // Check if attendance exists and is in progress
            $attendance = ServiceProviderAttendance::where('serviceProviderId', $serviceProviderId)
                ->where('bookingId', $bookingId)
                ->whereIn('status', ['punchedIn', 'inProgress'])
                ->first();

            if (!$attendance) {
                return response()->json([
                    'success' => false,
                    'status_code' => 404,
                    'message' => 'No active attendance found for this booking'
                ], 404);
            }

            // Handle image upload
            $completionImagePath = null;
            if ($request->hasFile('completionImage')) {
                 $imageName = time()."_".$request->completionImage->getClientOriginalName();
                $request->completionImage->move('attendance_images',$imageName);
                // $completionImagePath = $request->file('completionImage')->store('attendance_images', 'public');
                
            }

            // Punch out
            $dubai = 'Asia/Dubai';
            
            $punchOutTime = now();
             
            $totalTime = abs($punchOutTime->diffInMinutes($attendance->punchIn_time))/ 60; // Convert to hours
            
            $attendance->punchOut_time =  $punchOutTime;
            // $attendance->punchOut_time =  now()->format('Y-m-d H:i:s');
            $attendance->status =  'punchedOut';
            $attendance->completionImage =  $imageName;
            $attendance->completionNotes =  $request->completionNotes;
            $attendance->completionLatitude =  $request->completionLatitude;
            $attendance->completionLongitude =  $request->completionLongitude;
            $attendance->totalTime =  round($totalTime, 2);
            //  return response()->json([
            //         'punchin' => $punchedinTime,
            //         'punchout' =>  Carbon::parse($punchOutTime,$dubai)->setTimezone($dubai)->format('Y-m-d H:i:s'),
                    
            //     ]);
            $attendance->save();
            
        // $attendance->update([
        //     'status' => 'punchedOut',
        //     'punchOut_time' => $punchOutTime,
        //     'completionImage' => $imageName,
        //     'completionNotes' => $request->completionNotes,
        //     'completionLatitude' => $request->completionLatitude,
        //     'completionLongitude' =>  $request->completionLongitude,
        //     'totalTime' => round($totalTime, 2),
        // ]);

        // Update booking status to completed
        $attendance->booking->update(['status' => 'completed']);
            
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Punched out successfully',
                'data' => [
                    'attendance' => $attendance->load(['serviceProvider', 'booking']),
                    'start_image_url' => $attendance->start_image_url,
                    'completion_image_url' => $attendance->completion_image_url,
                    'formatted_total_time' => $attendance->formatted_total_time,
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'message' => 'Failed to punch out',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * POST API: Get attendance details for a booking
     */
    public function getAttendance(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'serviceProvider' => 'required|exists:users,id',
                'bookingId' => 'required|exists:bookings,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'status_code' => 400,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 400);
            }

            $serviceProviderId = $request->serviceProvider;
            $bookingId = $request->bookingId;

            $attendance = ServiceProviderAttendance::where('service_provider_id', $serviceProviderId)
                ->where('booking_id', $bookingId)
                ->with(['serviceProvider', 'booking'])
                ->first();

            if (!$attendance) {
                return response()->json([
                    'success' => false,
                    'status_code' => 404,
                    'message' => 'Attendance record not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Attendance details retrieved successfully',
                'data' => [
                    'attendance' => $attendance,
                    'start_image_url' => $attendance->start_image_url,
                    'mid_image_url' => $attendance->mid_image_url,
                    'completion_image_url' => $attendance->completion_image_url,
                    'formatted_total_time' => $attendance->formatted_total_time,
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'message' => 'Failed to retrieve attendance details',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    /**
     * POST API: Get punch in detail page data for a booking
     */
    public function punchInDetailPage(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'bookingId' => 'required|exists:bookings,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'status_code' => 400,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 400);
            }

            $bookingId = $request->bookingId;

            // Get booking with customer, service, and default address
            $booking = Booking::with([
                'customer' => function ($query) {
                    $query->select('id', 'name', 'email', 'phone', 'image')
                        ->with(['addresses' => function ($q) {
                            $q->default(); // Get default address
                        }]);
                },
                'service' => function ($query) {
                    $query->select('id', 'name', 'description', 'media', 'price_onetime', 'price_weekly', 'price_monthly', 'price_yearly');
                }
            ])->find($bookingId);

            if (!$booking) {
                return response()->json([
                    'success' => false,
                    'status_code' => 404,
                    'message' => 'Booking not found'
                ], 404);
            }

            // Get default address
            $defaultAddress = $booking->customer->addresses->first();

            // Format the response data
            $formattedData = [
                'booking_id' => $booking->id,
                'booking_reference' => $booking->booking_reference,
                'scheduled_date' => $booking->scheduled_date->format('y-m-d'),
                'preferred_time' => $booking->preferred_time,
                'status' => $booking->status,
                'total_amount' => $booking->total_amount,
                'currency' => $booking->currency,
                'booking_type' => $booking->booking_type,
                'customer_notes' => $booking->customer_notes,
                'user_details' => [
                    'id' => $booking->customer->id,
                    'name' => $booking->customer->name,
                    'email' => $booking->customer->email,
                    'phone' => $booking->customer->phone,
                    'image' => $booking->customer->image_url,
                ],
                'service_details' => [
                    'id' => $booking->service->id,
                    'name' => $booking->service->name,
                    'description' => $booking->service->description,
                    'image' => $booking->service->image_url,
                    // 'price_onetime' => $booking->service->price_onetime,
                    // 'price_weekly' => $booking->service->price_weekly,
                    // 'price_monthly' => $booking->service->price_monthly,
                    // 'price_yearly' => $booking->service->price_yearly,
                ],
                'default_address' => $defaultAddress ?? null,
            ];

            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Punch in detail page data retrieved successfully',
                'data' => $formattedData
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'message' => 'Failed to retrieve punch in detail page data',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * POST API: Update mid progress for a booking
     */
    public function updateMidProgress(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'serviceProvider' => 'required|exists:users,id',
                'bookingId' => 'required|exists:bookings,id',
                'midImage' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'midNotes' => 'nullable|string|max:1000',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'status_code' => 400,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 400);
            }

            $bookingId = $request->bookingId;

            // Find the attendance record for this booking
            $attendance = ServiceProviderAttendance::where('serviceProviderId',$request->serviceProvider)->where('bookingId', $bookingId)->first();

            if (!$attendance) {
                return response()->json([
                    'success' => false,
                    'status_code' => 404,
                    'message' => 'Attendance record not found for this booking'
                ], 404);
            }

            // Check if attendance is in a valid state for mid progress update
            if (!in_array($attendance->status, ['punchedIn', 'inProgress'])) {
                return response()->json([
                    'success' => false,
                    'status_code' => 409,
                    'message' => 'Cannot update mid progress for completed attendance'
                ], 409);
            }

            // Handle image upload
            $imageName = null;
            if ($request->hasFile('midImage')) {
                 $imageName = time()."_".$request->midImage->getClientOriginalName();
                $request->midImage->move('attendance_images',$imageName);
            }

            // Update mid progress
            $attendance->updateMidProgress($imageName, $request->midNotes);
            // $attendance->update([
            //     'midImage'=>$imageName,
            //     'midNotes'=> $request->midNotes,
            //     ]);
            

            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Mid progress updated successfully',
                'data' => [
                    'attendance' => $attendance->load(['serviceProvider', 'booking']),
                    'mid_image_url' => $attendance->mid_image_url,
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'message' => 'Failed to update mid progress',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    //test punchout time calculator
      public function TestpunchOut(Request $request)
    {
        $punchOutTime = Carbon::parse($request->punchOut_time);
        $punchInTime  = Carbon::parse($request->punchIn_time);
        
        $totalTime = abs($punchOutTime->diffInMinutes($punchInTime)) / 60; // Convert to hours
        
          return response()->json([
             'status' => 'punchedOut',
            'punchIn_time' => $punchInTime->format('H:i:s'),
            'punchOut_time' => $punchOutTime->format('H:i:s'),
            'totalTime' => round($totalTime, 2),
            ], 200);
    }
}
