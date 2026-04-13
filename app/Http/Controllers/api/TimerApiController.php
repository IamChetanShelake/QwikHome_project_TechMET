<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\ServiceProviderAttendance;
use App\Models\ServiceFrequencyOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class TimerApiController extends Controller
{
    /**
     * POST API: Get timer for a booking
     */
    public function timer(Request $request)
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

            // Find the booking with attendance and selected frequency option
            $booking = Booking::with(['selectedFrequencyOption'])->find($bookingId);
            //   return response()->json([
                   
            //         'message' => $booking,
            //     ], 200);

            if (!$booking) {
                return response()->json([
                    'success' => false,
                    'status_code' => 404,
                    'message' => 'Booking not found'
                ], 404);
            }

             // Find attendance record using correct column name
            $attendance = ServiceProviderAttendance::where('bookingId', $bookingId)->first();

            // Check if the booking has attendance (punched in)
            if (!$attendance) {
                return response()->json([
                    'success' => false,
                    'status_code' => 400,
                    'message' => 'Service provider has not punched in for this booking'
                ], 400);
            }

            $punchInTime = Carbon::parse($attendance->punchIn_time);
            
            // $subscription = ServiceFrequencyOption::where('service_id',$booking->service_id)->first();
            
                //   return response()->json([
                //     'message' => $booking->selectedFrequencyOption,
                // ], 200);
            

            // Check if the selected frequency option exists and duration is 1
            
            if (!$booking->selectedFrequencyOption) {
                return response()->json([
                    'success' => false,
                    'status_code' => 400,
                    'message' => 'Timer is only available for services with greater or equal than 1 hour duration'
                ], 400);
            }

            $duration = $booking->selectedFrequencyOption->duration; // Should be 1

            $limitMinutes = $duration * 60; // 60 minutes

            $now = Carbon::now();
            $elapsedMinutes = $punchInTime->diffInMinutes($now);
            $remainingMinutes = $limitMinutes - $elapsedMinutes;

            // Calculate hours and minutes for display
            $elapsedHours = intdiv($elapsedMinutes, 60);
            $elapsedMins = $elapsedMinutes % 60;
            $elapsedTime = sprintf('%02d:%02d', $elapsedHours, $elapsedMins);

            $remainingHours = intdiv(max(0, $remainingMinutes), 60);
            $remainingMins = max(0, $remainingMinutes) % 60;
            $remainingTime = sprintf('%02d:%02d', $remainingHours, $remainingMins);

            if ($elapsedMinutes >= $limitMinutes) {
                // Time has elapsed
                return response()->json([
                    'success' => true,
                    'status_code' => 200,
                    'message' => 'Timer retrieved successfully',
                    'data' => [
                        'status' => 'elapsed',
                        'elapsed_time' => $elapsedTime,
                        'remaining_time' => '00:00',
                        'limit_time' => '01:00'
                    ]
                ], 200);
            } else {
                // Still running
                return response()->json([
                    'success' => true,
                    'status_code' => 200,
                    'message' => 'Timer retrieved successfully',
                    'data' => [
                        'status' => 'running',
                        'elapsed_time' => $elapsedTime,
                        'remaining_time' => $remainingTime,
                        'limit_time' => '01:00'
                    ]
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'message' => 'Failed to retrieve timer',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
