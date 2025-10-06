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
        if ($request->has('query') && !empty($request->query)) {
            $query->where(function ($q) use ($request) {
                $q->whereHas('user', function ($userQuery) use ($request) {
                    $userQuery->where('name', 'like', '%' . $request->query . '%')
                        ->orWhere('email', 'like', '%' . $request->query . '%');
                })
                    ->orWhereHas('service', function ($serviceQuery) use ($request) {
                        $serviceQuery->where('name', 'like', '%' . $request->query . '%');
                    });
            });
        }

        $feedbacks = $query->orderBy('created_at', 'desc')->get();

        return view('admin.feedback.index', compact('feedbacks'));
    }

    public function search(Request $request)
    {
        if (!$request->has('query') || empty($request->query)) {
            return response()->json([]);
        }

        $feedbacks = Feedback::with(['user', 'service', 'employee', 'booking'])
            ->where(function($q) use ($request) {
                $q->whereHas('user', function($userQuery) use ($request) {
                    $userQuery->where('name', 'like', '%' . $request->query . '%')
                             ->orWhere('email', 'like', '%' . $request->query . '%');
                })
                ->orWhereHas('service', function($serviceQuery) use ($request) {
                    $serviceQuery->where('name', 'like', '%' . $request->query . '%');
                });
            })
            ->orderBy('created_at', 'desc')
            ->take(50)
            ->get();

        return response()->json($feedbacks);
    }
}
