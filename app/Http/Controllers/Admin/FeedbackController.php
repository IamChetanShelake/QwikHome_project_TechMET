<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index(Request $request)
    {
        $query = Feedback::with(['user', 'service', 'employee', 'booking']);

        // Apply search
        $queryValue = $request->input('query');
        if ($queryValue && !empty($queryValue)) {
            $query->where(function ($q) use ($queryValue) {
                $q->whereHas('user', function ($userQuery) use ($queryValue) {
                    $userQuery->where('name', 'like', '%' . $queryValue . '%')
                        ->orWhere('email', 'like', '%' . $queryValue . '%');
                })
                    ->orWhereHas('service', function ($serviceQuery) use ($queryValue) {
                        $serviceQuery->where('name', 'like', '%' . $queryValue . '%');
                    });
            });
        }

        $feedbacks = $query->orderBy('created_at', 'desc')->get();

        return view('admin.feedback.index', compact('feedbacks'));
    }

    public function search(Request $request)
    {
        $queryValue = $request->input('query');
        if (!$queryValue || empty($queryValue)) {
            return response()->json([]);
        }

        $feedbacks = Feedback::with(['user', 'service', 'employee', 'booking'])
            ->where(function($q) use ($queryValue) {
                $q->whereHas('user', function($userQuery) use ($queryValue) {
                    $userQuery->where('name', 'like', '%' . $queryValue . '%')
                              ->orWhere('email', 'like', '%' . $queryValue . '%');
                })
                ->orWhereHas('service', function($serviceQuery) use ($queryValue) {
                    $serviceQuery->where('name', 'like', '%' . $queryValue . '%');
                });
            })
            ->orderBy('created_at', 'desc')
            ->take(50)
            ->get();

        return response()->json($feedbacks);
    }
}
