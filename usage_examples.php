<?php
/**
 * Example Usage for Feedback System - Average Rating Calculations
 *
 * This file demonstrates how to use the feedback system and calculate average ratings
 * implemented in the QwikHom platform.
 */

// Assuming Laravel autoloading is available
use App\Models\User;
use App\Models\Service;
use App\Models\Feedback;

// Example 1: Get average rating for a specific service
function getServiceRatingExample($serviceId)
{
    $service = Service::find($serviceId);

    if ($service) {
        // Method 1: Using accessor (calculates on-the-fly)
        $avgRating = $service->average_rating;

        // Method 2: Direct query (more efficient for bulk operations)
        $avgRating = Feedback::where('service_id', $serviceId)->avg('rating_service');

        return [
            'service_name' => $service->name,
            'average_rating' => round($avgRating, 1),
            'total_feedbacks' => $service->feedbacks()->count()
        ];
    }

    return null;
}

// Example 2: Get average rating for a specific employee (service provider)
function getEmployeeRatingExample($employeeId)
{
    $employee = User::find($employeeId);

    if ($employee) {
        // Method 1: Using accessor
        $avgRating = $employee->average_employee_rating;

        // Method 2: Direct query
        $avgRating = Feedback::where('employee_id', $employeeId)
            ->whereNotNull('rating_employee')
            ->avg('rating_employee');

        return [
            'employee_name' => $employee->name,
            'average_rating' => round($avgRating, 1),
            'total_feedbacks' => $employee->employeeFeedbacks()->count()
        ];
    }

    return null;
}

// Example 3: Get top-rated services
function getTopRatedServices($limit = 10)
{
    return Service::with(['feedbacks' => function($query) {
        $query->selectRaw('service_id, AVG(rating_service) as avg_rating, COUNT(*) as feedback_count')
              ->groupBy('service_id')
              ->havingRaw('COUNT(*) >= 5'); // Minimum 5 feedbacks
    }])
    ->join('feedbacks', 'services.id', '=', 'feedbacks.service_id')
    ->select('services.*')
    ->selectRaw('AVG(feedbacks.rating_service) as avg_rating, COUNT(feedbacks.id) as feedback_count')
    ->groupBy('services.id')
    ->havingRaw('COUNT(feedbacks.id) >= 5') // Minimum 5 feedbacks
    ->orderBy('avg_rating', 'desc')
    ->limit($limit)
    ->get();
}

// Example 4: Get top-rated employees
function getTopRatedEmployees($limit = 10)
{
    return User::with(['employeeFeedbacks' => function($query) {
        $query->whereNotNull('rating_employee');
    }])
    ->join('feedbacks', 'users.id', '=', 'feedbacks.employee_id')
    ->select('users.*')
    ->selectRaw('AVG(feedbacks.rating_employee) as avg_rating, COUNT(feedbacks.id) as feedback_count')
    ->groupBy('users.id')
    ->havingRaw('COUNT(feedbacks.id) >= 3') // Minimum 3 feedbacks
    ->havingRaw('AVG(feedbacks.rating_employee) >= 4.0') // Minimum rating
    ->orderBy('avg_rating', 'desc')
    ->limit($limit)
    ->get();
}

// Example 5: Service rating over time (monthly aggregation)
function getServiceRatingTrend($serviceId, $months = 12)
{
    return Feedback::where('service_id', $serviceId)
        ->selectRaw('
            YEAR(created_at) as year,
            MONTH(created_at) as month,
            AVG(rating_service) as avg_rating,
            COUNT(*) as feedback_count
        ')
        ->whereRaw("created_at >= DATE_SUB(NOW(), INTERVAL ? MONTH)", [$months])
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->orderBy('month', 'desc')
        ->get();
}

// Example 6: Overall platform statistics
function getPlatformFeedbackStats()
{
    $totalFeedbacks = Feedback::count();
    $avgServiceRating = Feedback::avg('rating_service') ?? 0;
    $avgEmployeeRating = Feedback::whereNotNull('rating_employee')->avg('rating_employee') ?? 0;
    $feedbacksWithComments = Feedback::whereNotNull('comment')->count();
    $completionRate = 0; // Would need additional logic to calculate booking completion vs feedback rate

    return [
        'total_feedbacks' => $totalFeedbacks,
        'average_service_rating' => round($avgServiceRating, 2),
        'average_employee_rating' => round($avgEmployeeRating, 2),
        'feedbacks_with_comments' => $feedbacksWithComments,
        'comment_percentage' => $totalFeedbacks > 0 ? round(($feedbacksWithComments / $totalFeedbacks) * 100, 1) : 0,
    ];
}

// Example 7: Recent feedback summary
function getRecentFeedbackSummary($days = 30)
{
    return Feedback::with(['user', 'service', 'employee', 'booking'])
        ->whereRaw("created_at >= DATE_SUB(NOW(), INTERVAL ? DAY)", [$days])
        ->orderBy('created_at', 'desc')
        ->select(['id', 'user_id', 'service_id', 'employee_id', 'rating_service', 'rating_employee', 'comment', 'created_at'])
        ->get();
}

/*
API Endpoints Available:

POST /api/feedbacks/{bookingId} - Store feedback for a booking
GET /api/services/{serviceId}/feedbacks - Get all feedback for a service
GET /api/employees/{employeeId}/feedbacks - Get all feedback for an employee
GET /api/services/{serviceId}/rating - Get average rating for a service
GET /api/employees/{employeeId}/rating - Get average rating for an employee

Admin Routes:
/admin/feedback - Feedback management dashboard
/admin/feedback/data - AJAX endpoint for feedback data
/admin/feedback/{id} - View feedback detail
/admin/feedback/export/csv - Export feedback to CSV

Web Routes:
/feedback/{booking} - View feedback form for a booking (authenticated users only)
*/

?>
