<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use App\Models\Service;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        // Default date range (last 30 days)
        $startDate = $request->get('start_date', Carbon::now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));
        $serviceId = $request->get('service_id');
        $providerId = $request->get('provider_id');

        // Base query for filtering
        $bookingsQuery = Booking::with(['service', 'serviceProvider', 'customer', 'vendor'])
            ->whereBetween('scheduled_date', [$startDate, $endDate]);

        if ($serviceId) {
            $bookingsQuery->where('service_id', $serviceId);
        }

        if ($providerId) {
            $bookingsQuery->where('service_provider_id', $providerId);
        }

        $bookings = $bookingsQuery->get();

        // Analytics Data
        $analytics = [
            // Summary metrics
            'total_bookings' => $bookings->count(),
            'total_revenue' => $bookings->sum('price'),
            'completed_bookings' => $bookings->where('status', 'completed')->count(),
            'pending_bookings' => $bookings->where('status', 'pending')->count(),

            // Monthly revenue trend (last 12 months)
            'revenue_trend' => $this->getRevenueTrend($startDate, $endDate),

            // Booking status distribution
            'status_distribution' => $this->getStatusDistribution($bookings),

            // Status distribution for charts
            'status_chart_data' => $this->getStatusChartData($bookings),

            // Top performing providers
            'top_providers' => $this->getTopProviders($bookings),

            // Popular services
            'popular_services' => $this->getPopularServices($bookings),

            // Daily bookings (for chart)
            'daily_bookings' => $this->getDailyBookings($startDate, $endDate, $serviceId, $providerId),
        ];

        // Get filter options
        $services = Service::select('id', 'name')->orderBy('name')->get();
        $providers = User::where('role', 'serviceprovider')
            ->select('id', 'name', 'email')
            ->orderBy('name')
            ->get();

        return view('admin.analytics.index', compact(
            'analytics',
            'bookings',
            'services',
            'providers',
            'startDate',
            'endDate',
            'serviceId',
            'providerId'
        ));
    }

    private function getRevenueTrend($startDate, $endDate)
    {
        return Booking::select(
                DB::raw('DATE_FORMAT(scheduled_date, "%Y-%m") as month'),
                DB::raw('SUM(price) as revenue'),
                DB::raw('COUNT(*) as bookings')
            )
            ->whereBetween('scheduled_date', [$startDate, $endDate])
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->map(function($item) {
                return [
                    'month' => Carbon::createFromFormat('Y-m', $item->month)->format('M Y'),
                    'revenue' => (float) $item->revenue,
                    'bookings' => $item->bookings
                ];
            });
    }

    private function getStatusDistribution($bookings)
    {
        $statuses = ['pending', 'confirmed', 'in_progress', 'completed', 'cancelled'];
        $distribution = [];

        foreach ($statuses as $status) {
            $distribution[$status] = $bookings->where('status', $status)->count();
        }

        return $distribution;
    }

    private function getStatusChartData($bookings)
    {
        $statuses = ['pending', 'confirmed', 'in_progress', 'completed', 'cancelled'];
        $chartData = [];

        foreach ($statuses as $status) {
            $count = $bookings->where('status', $status)->count();
            if ($count > 0) { // Only include statuses that have bookings
                $chartData[] = [
                    'status' => ucfirst(str_replace('_', ' ', $status)),
                    'count' => $count
                ];
            }
        }

        return $chartData;
    }

    private function getTopProviders($bookings)
    {
        return $bookings->groupBy('service_provider_id')
            ->map(function($providerBookings) {
                $provider = $providerBookings->first()->serviceProvider;
                if (!$provider) return null;

                return [
                    'name' => $provider->name,
                    'email' => $provider->email,
                    'total_bookings' => $providerBookings->count(),
                    'total_revenue' => $providerBookings->sum('price'),
                    'completed_bookings' => $providerBookings->where('status', 'completed')->count(),
                    'rating' => 4.5 // This would come from a ratings system
                ];
            })
            ->filter()
            ->sortByDesc('total_revenue')
            ->take(10)
            ->values();
    }

    private function getPopularServices($bookings)
    {
        return $bookings->groupBy('service_id')
            ->map(function($serviceBookings) {
                $service = $serviceBookings->first()->service;
                if (!$service) return null;

                return [
                    'name' => $service->name,
                    'category' => $service->subcategory->category->name ?? 'N/A',
                    'total_bookings' => $serviceBookings->count(),
                    'total_revenue' => $serviceBookings->sum('price'),
                    'average_price' => $serviceBookings->avg('price')
                ];
            })
            ->filter()
            ->sortByDesc('total_bookings')
            ->take(10)
            ->values();
    }

    private function getDailyBookings($startDate, $endDate, $serviceId = null, $providerId = null)
    {
        $query = Booking::select(
                DB::raw('DATE(scheduled_date) as date'),
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(price) as revenue')
            )
            ->whereBetween('scheduled_date', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date');

        if ($serviceId) {
            $query->where('service_id', $serviceId);
        }

        if ($providerId) {
            $query->where('service_provider_id', $providerId);
        }

        return $query->get()->map(function($item) {
            return [
                'date' => Carbon::parse($item->date)->format('Y-m-d'),
                'count' => $item->count,
                'revenue' => (float) $item->revenue
            ];
        });
    }
}
