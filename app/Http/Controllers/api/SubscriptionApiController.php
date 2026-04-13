<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\UserSubscription;
use App\Models\ServiceSubscriptionPlan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionApiController extends Controller
{
    /**
     * Get user's subscriptions
     */
        public function getUserSubscriptions(Request $request)
    {
        try {
            $user = User::find($request->user);
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'status_code' => 401,
                    'message' => 'Unauthorized',
                ], 401);
            }

            $subscriptions = UserSubscription::with([
                'service',
                'subscriptionPlan' => function ($query) {
                    $query->select('id', 'service_id', 'frequency_type', 'price_per_time', 'no_of_times', 'duration', 'description');
                },
                'paymentMethod',
                'bookings' => function ($query) {
                    $query->select('id', 'subscription_id', 'scheduled_date', 'status', 'service_provider_id')
                          ->orderBy('scheduled_date', 'desc');
                },
                'bookings.serviceProvider' => function ($query) {
                    $query->select('id', 'name', 'phone');
                },
                'paymentTransactions' => function ($query) {
                    $query->select('id', 'subscription_id', 'amount', 'processed_at', 'status', 'payment_method_id')
                          ->orderBy('processed_at', 'desc');
                }
            ])
                ->forUser($user->id)
                ->orderBy('created_at', 'desc')
                ->get();

            // Get existing plan IDs to exclude from explore other plans
            $existingPlanIds = $subscriptions->pluck('subscription_plan_id')->filter()->unique();

            // Get random subscription plans from other services
            $explorePlans = ServiceSubscriptionPlan::with('service')
                ->whereNotIn('id', $existingPlanIds)
                ->inRandomOrder()
                ->take(4)
                ->get();

            $formattedExplorePlans = $explorePlans->map(function ($plan) {
                return [
                    'id' => $plan->id,
                    'frequency_type' => $plan->frequency_type,
                    'price_per_time' => number_format($plan->price_per_time, 2),
                    'no_of_times' => $plan->no_of_times,
                    'duration' => $plan->duration,
                    'description' => $plan->description,
                    'service' => [
                        'id' => $plan->service->id,
                        'name' => $plan->service->name,
                        'description' => $plan->service->description,
                        'category_id' => $plan->service->category_id,
                    ],
                ];
            });

            $formattedSubscriptions = $subscriptions->map(function ($subscription) {
                return [
                    'id' => $subscription->id,
                    'subscription_number' => $subscription->subscription_number,
                    'status' => $subscription->status,
                    'start_date' => $subscription->start_date,
                    'end_date' => $subscription->end_date,
                    'next_billing_date' => $subscription->next_billing_date,
                    'billing_cycle' => $subscription->billing_cycle,
                    'billing_day' => $subscription->billing_day,
                    'base_price' => number_format($subscription->base_price, 2),
                    'total_amount' => number_format($subscription->total_amount, 2),
                    'auto_renew' => $subscription->auto_renew,
                    'failed_payment_count' => $subscription->failed_payment_count,
                    'last_payment_date' => $subscription->last_payment_date,
                    'last_payment_amount' => number_format($subscription->last_payment_amount, 2),
                    'can_be_cancelled' => $subscription->canBeCancelled(),
                    'can_be_paused' => false,
                    'can_be_resumed' => false,
                    'days_until_next_billing' => $subscription->getDaysUntilNextBilling(),
                    'service' => [
                        'id' => $subscription->service->id,
                        'name' => $subscription->service->name,
                        'description' => $subscription->service->description,
                        'category_id' => $subscription->service->category_id,
                    ],
                    'subscription_plan' => $subscription->subscriptionPlan ? [
                        'id' => $subscription->subscriptionPlan->id,
                        'frequency_type' => $subscription->subscriptionPlan->frequency_type,
                        'price_per_time' => number_format($subscription->subscriptionPlan->price_per_time, 2),
                        'no_of_times' => $subscription->subscriptionPlan->no_of_times,
                        'duration' => $subscription->subscriptionPlan->duration,
                        'description' => $subscription->subscriptionPlan->description,
                    ] : null,
                    'payment_method' => $subscription->paymentMethod ? [
                        'id' => $subscription->paymentMethod->id,
                        'name' => $subscription->paymentMethod->name,
                        'type' => $subscription->paymentMethod->type,
                    ] : null,
                    'recent_bookings' => $subscription->bookings ? $subscription->bookings->take(5)->map(function ($booking) {
                        return [
                            'id' => $booking->id,
                            'booking_date' => $booking->scheduled_date,
                            'status' => $booking->status,
                            'service_provider' => $booking->serviceProvider ? [
                                'id' => $booking->serviceProvider->id,
                                'name' => $booking->serviceProvider->name,
                                'phone' => $booking->serviceProvider->phone,
                            ] : null,
                        ];
                    }) : [],
                    'payment_history' => $subscription->paymentTransactions ? $subscription->paymentTransactions->take(10)->map(function ($transaction) {
                        return [
                            'id' => $transaction->id,
                            'amount' => number_format($transaction->amount, 2),
                            'payment_date' => $transaction->processed_at,
                            'status' => $transaction->status,
                        ];
                    }) : [],
                    'billing_cycles' => $subscription->billingCycles ? $subscription->billingCycles->sortByDesc('cycle_number')->take(12)->map(function ($cycle) {
                        return [
                            'id' => $cycle->id,
                            'cycle_number' => $cycle->cycle_number,
                            'status' => $cycle->status,
                            'billing_date' => $cycle->start_date,
                            'amount' => number_format($cycle->amount, 2),
                        ];
                    }) : [],
                ];
            });

            return response()->json([
                'status' => true,
                'status_code' => 200,
                'message' => 'Subscriptions retrieved successfully',
                'data' => [
                    'subscriptions' => $formattedSubscriptions,
                    'total_count' => $subscriptions->count(),
                    'active_count' => $subscriptions->where('status', 'active')->count(),
                    'paused_count' => $subscriptions->where('status', 'paused')->count(),
                    'cancelled_count' => $subscriptions->where('status', 'cancelled')->count(),
                    'explore_other_plans' => $formattedExplorePlans,
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'status_code' => 500,
                'message' => 'Failed to retrieve subscriptions',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    // public function getUserSubscriptions(Request $request)
    // {
    //     try {
    //         $user = User::find($request->user);
    //         if (!$user) {
    //             return response()->json([
    //                 'status' => false,
    //                 'status_code' => 401,
    //                 'message' => 'Unauthorized',
    //             ], 401);
    //         }

    //         $subscriptions = UserSubscription::with([
    //             'service',
    //             'subscriptionPlan',
    //             'subscriptionPlan.billingFrequency',
    //             'paymentMethod',
    //             'bookings',
    //             'bookings.serviceProvider',
    //             'paymentTransactions',
    //             'billingCycles'
    //         ])
    //         ->forUser($user->id)
    //         ->orderBy('created_at', 'desc')
    //         ->get();

    //         $formattedSubscriptions = $subscriptions->map(function ($subscription) {
    //             return [
    //                 'id' => $subscription->id,
    //                 'subscription_number' => $subscription->subscription_number,
    //                 'status' => $subscription->status,
    //                 'start_date' => $subscription->start_date,
    //                 'end_date' => $subscription->end_date,
    //                 'next_billing_date' => $subscription->next_billing_date,
    //                 'billing_cycle' => $subscription->billing_cycle,
    //                 'billing_day' => $subscription->billing_day,
    //                 'base_price' => number_format($subscription->base_price, 2),
    //                 'total_amount' => number_format($subscription->total_amount, 2),
    //                 'auto_renew' => $subscription->auto_renew,
    //                 'failed_payment_count' => $subscription->failed_payment_count,
    //                 'last_payment_date' => $subscription->last_payment_date,
    //                 'last_payment_amount' => number_format($subscription->last_payment_amount, 2),
    //                 'can_be_cancelled' => $subscription->canBeCancelled(),
    //                 'can_be_paused' => $subscription->canBePaused(),
    //                 'can_be_resumed' => $subscription->canBeResumed(),
    //                 'days_until_next_billing' => $subscription->getDaysUntilNextBilling(),
    //                 'service' => [
    //                     'id' => $subscription->service->id,
    //                     'name' => $subscription->service->name,
    //                     'description' => $subscription->service->description,
    //                     'category_id' => $subscription->service->category_id,
    //                 ],
    //                 'subscription_plan' => [
    //                     'id' => $subscription->subscriptionPlan->id,
    //                     'name' => $subscription->subscriptionPlan->name,
    //                     'frequency_type' => $subscription->subscriptionPlan->frequency_type,
    //                     'duration' => $subscription->subscriptionPlan->duration,
    //                     'billing_frequency' => $subscription->subscriptionPlan->billingFrequency,
    //                     'pause_resume_allowed' => $subscription->subscriptionPlan->pause_resume_allowed,
    //                 ],
    //                 'payment_method' => $subscription->paymentMethod ? [
    //                     'id' => $subscription->paymentMethod->id,
    //                     'name' => $subscription->paymentMethod->name,
    //                     'type' => $subscription->paymentMethod->type,
    //                 ] : null,
    //                 'recent_bookings' => $subscription->bookings->take(5)->map(function ($booking) {
    //                     return [
    //                         'id' => $booking->id,
    //                         'booking_date' => $booking->booking_date,
    //                         'status' => $booking->status,
    //                         'service_provider' => $booking->serviceProvider ? [
    //                             'id' => $booking->serviceProvider->id,
    //                             'name' => $booking->serviceProvider->name,
    //                             'phone' => $booking->serviceProvider->phone,
    //                         ] : null,
    //                     ];
    //                 }),
    //                 'payment_history' => $subscription->paymentTransactions->take(10)->map(function ($transaction) {
    //                     return [
    //                         'id' => $transaction->id,
    //                         'amount' => number_format($transaction->amount, 2),
    //                         'payment_date' => $transaction->payment_date,
    //                         'status' => $transaction->status,
    //                     ];
    //                 }),
    //                 'billing_cycles' => $subscription->billingCycles->take(12)->map(function ($cycle) {
    //                     return [
    //                         'id' => $cycle->id,
    //                         'cycle_number' => $cycle->cycle_number,
    //                         'status' => $cycle->status,
    //                         'billing_date' => $cycle->billing_date,
    //                     ];
    //                 }),
    //             ];
    //         });

    //         return response()->json([
    //             'status' => true,
    //             'status_code' => 200,
    //             'message' => 'Subscriptions retrieved successfully',
    //             'data' => [
    //                 'subscriptions' => $formattedSubscriptions,
    //                 'total_count' => $subscriptions->count(),
    //                 'active_count' => $subscriptions->where('status', 'active')->count(),
    //                 'paused_count' => $subscriptions->where('status', 'paused')->count(),
    //                 'cancelled_count' => $subscriptions->where('status', 'cancelled')->count(),
    //             ]
    //         ], 200);

    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => false,
    //             'status_code' => 500,
    //             'message' => 'Failed to retrieve subscriptions',
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }
    // }
    
}
