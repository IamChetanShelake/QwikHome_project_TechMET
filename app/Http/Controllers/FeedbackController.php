<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    /**
     * Display user feedback listing page
     */
    public function index()
    {
        $feedbacks = Feedback::where('user_id', auth()->id())
            ->with(['service', 'employee', 'booking'])
            ->orderBy('created_at', 'desc')
            ->get();


        $averageServiceRating = auth()->user()->feedbacks()->avg('rating_service') ?? 0;
      
        return view('user.feedback.index', compact('feedbacks', 'averageServiceRating'));
    }

    /**
     * Show the feedback form for a booking
     */
    public function show($bookingId)
    {
        $booking = Booking::with(['service', 'serviceProvider', 'feedback'])->findOrFail($bookingId);

        // Check if user can view this feedback form
        if ($booking->customer_id !== Auth::id()) {
            abort(403, 'Access denied. You can only view feedback for your own bookings.');
        }

        return view('user.feedback.create', compact('booking'));
    }

    /**
     * Store feedback for a completed booking
     */
    public function store(Request $request, $bookingId)
    {
        $request->validate([
            'rating_service' => 'required|integer|min:1|max:5',
            'rating_employee' => 'nullable|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $booking = Booking::findOrFail($bookingId);

        // Check if booking is completed
        if ($booking->status !== 'completed') {
            return response()->json(['error' => 'Feedback can only be submitted for completed bookings.'], 403);
        }

        // Check if user is the customer of this booking
        if ($booking->customer_id !== Auth::id()) {
            return response()->json(['error' => 'You can only submit feedback for your own bookings.'], 403);
        }

        // Check if feedback already exists
        if ($booking->feedback) {
            return response()->json(['error' => 'Feedback already exists for this booking.'], 403);
        }

        $feedback = Feedback::create([
            'user_id' => Auth::id(),
            'service_id' => $booking->service_id,
            'booking_id' => $booking->id,
            'employee_id' => $booking->service_provider_id, // Nullable in theory, but from booking it's set
            'rating_service' => $request->rating_service,
            'rating_employee' => $request->rating_employee,
            'comment' => $request->comment,
        ]);

        return response()->json(['message' => 'Feedback submitted successfully.', 'feedback' => $feedback], 201);
    }

    /**
     * Get feedback for a service (for service providers and admins)
     */
    public function serviceFeedbacks($serviceId)
    {
        $feedbacks = Feedback::where('service_id', $serviceId)
            ->with(['user', 'employee', 'booking'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($feedbacks);
    }

    /**
     * Get feedback for an employee (for vendors and admins)
     */
    public function employeeFeedbacks($employeeId)
    {
        $feedbacks = Feedback::where('employee_id', $employeeId)
            ->with(['user', 'service', 'booking'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($feedbacks);
    }

    /**
     * Get average ratings for a service
     */
    public function serviceRating($serviceId)
    {
        $avgRating = Feedback::where('service_id', $serviceId)->avg('rating_service');

        return response()->json([
            'service_id' => $serviceId,
            'average_rating' => round($avgRating, 1),
            'feedback_count' => Feedback::where('service_id', $serviceId)->count(),
        ]);
    }

    /**
     * Get average rating for an employee
     */
    public function employeeRating($employeeId)
    {
        $avgRating = Feedback::where('employee_id', $employeeId)->whereNotNull('rating_employee')->avg('rating_employee');

        return response()->json([
            'employee_id' => $employeeId,
            'average_rating' => round($avgRating, 1),
            'feedback_count' => Feedback::where('employee_id', $employeeId)->whereNotNull('rating_employee')->count(),
        ]);
    }
}
