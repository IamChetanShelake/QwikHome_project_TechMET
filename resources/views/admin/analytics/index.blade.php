@extends('admin.layouts.masterlayout')

@section('content')
    <div class="content-area">
        <div class="modern-list-container">
            <!-- Header Section -->
            <div class="analytics-header-section">
                <div class="list-header-content">
                    <div class="list-title-group">
                        <div class="list-icon-wrapper">
                            <i class="fas fa-chart-bar list-main-icon"></i>
                        </div>
                        <div class="list-title-text">
                            <h2 class="list-title">Reports & Analytics</h2>
                            <p class="list-subtitle">Comprehensive insights into your business performance</p>
                        </div>
                    </div>
                    <div class="filter-section">
                        <form method="GET" action="{{ route('admin.analytics.index') }}" class="filter-form">
                            <div class="filter-row">
                                <div class="filter-group">
                                    <label for="start_date">Start Date</label>
                                    <input type="date" id="start_date" name="start_date" value="{{ $startDate }}"
                                        class="filter-input">
                                </div>
                                <div class="filter-group">
                                    <label for="end_date">End Date</label>
                                    <input type="date" id="end_date" name="end_date" value="{{ $endDate }}"
                                        class="filter-input">
                                </div>
                                <div class="filter-group">
                                    <label for="service_id">Service</label>
                                    <select id="service_id" name="service_id" class="filter-select">
                                        <option value="">All Services</option>
                                        @foreach ($services as $service)
                                            <option value="{{ $service->id }}"
                                                {{ $serviceId == $service->id ? 'selected' : '' }}>
                                                {{ $service->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="filter-group">
                                    <label for="provider_id">Provider</label>
                                    <select id="provider_id" name="provider_id" class="filter-select">
                                        <option value="">All Providers</option>
                                        @foreach ($providers as $provider)
                                            <option value="{{ $provider->id }}"
                                                {{ $providerId == $provider->id ? 'selected' : '' }}>
                                                {{ $provider->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="filter-group">
                                    <button type="submit" class="modern-btn modern-btn-primary filter-btn">
                                        <i class="fas fa-filter"></i>
                                        <span>Apply Filters</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="summary-cards-grid">
            <div class="summary-card">
                <div class="card-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="card-content">
                    <h3>{{ number_format($analytics['total_bookings']) }}</h3>
                    <p>Total Bookings</p>
                    <div class="card-trend">
                        <i class="fas fa-arrow-up"></i>
                        <span>This Period</span>
                    </div>
                </div>
            </div>

            <div class="summary-card revenue-card">
                <div class="card-icon">
                    {{-- <i class="fas fa-dollar-sign"></i> --}}
                    <b>AED</b>
                </div>
                <div class="card-content">
                    <h3>{{ number_format($analytics['total_revenue'], 2) }}</h3>
                    <p>Total Revenue</p>
                    <div class="card-trend positive">
                        <i class="fas fa-arrow-up"></i>
                        <span>Growth</span>
                    </div>
                </div>
            </div>

            <div class="summary-card">
                <div class="card-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="card-content">
                    <h3>{{ number_format($analytics['completed_bookings']) }}</h3>
                    <p>Completed Bookings</p>
                    <div class="card-trend">
                        <span>{{ $analytics['total_bookings'] > 0 ? round(($analytics['completed_bookings'] / $analytics['total_bookings']) * 100) : 0 }}%
                            Rate</span>
                    </div>
                </div>
            </div>

            <div class="summary-card">
                <div class="card-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="card-content">
                    <h3>{{ number_format($analytics['pending_bookings']) }}</h3>
                    <p>Pending Bookings</p>
                    <div class="card-trend">
                        <span>Awaiting Action</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="charts-section">
            <div class="chart-row">
                <!-- Revenue Trend Chart -->
                <div class="chart-card">
                    <div class="chart-header">
                        <h4><i class="fas fa-chart-line"></i> Revenue Trend</h4>
                    </div>
                    <div class="chart-body">
                        <canvas id="revenueTrendChart" width="400" height="200"></canvas>
                    </div>
                </div>

                <!-- Daily Bookings Chart -->
                <div class="chart-card">
                    <div class="chart-header">
                        <h4><i class="fas fa-calendar-alt"></i> Daily Bookings</h4>
                    </div>
                    <div class="chart-body">
                        <canvas id="dailyBookingsChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>

            <!-- Status Distribution Chart -->
            <div class="chart-row single">
                <div class="chart-card">
                    <div class="chart-header">
                        <h4><i class="fas fa-pie-chart"></i> Booking Status Distribution</h4>
                    </div>
                    <div class="chart-body">
                        <canvas id="statusChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tables Section -->
        <div class="tables-section">
            <div class="table-row">
                <!-- Top Providers -->
                <div class="table-card">
                    <div class="table-header">
                        <h4><i class="fas fa-star"></i> Top Performing Providers</h4>
                    </div>
                    <div class="table-wrapper">
                        <table class="analytics-table">
                            <thead>
                                <tr>
                                    <th>Provider</th>
                                    <th>Total Bookings</th>
                                    <th>Revenue</th>
                                    <th>Completed</th>
                                    <th>Rating</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($analytics['top_providers'] as $provider)
                                    <tr>
                                        <td>
                                            <div class="provider-info">
                                                <strong>{{ $provider['name'] }}</strong>
                                                <small>{{ $provider['email'] }}</small>
                                            </div>
                                        </td>
                                        <td>{{ $provider['total_bookings'] }}</td>
                                        <td>₹{{ number_format($provider['total_revenue'], 2) }}</td>
                                        <td>{{ $provider['completed_bookings'] }}</td>
                                        <td>
                                            <div class="rating">
                                                <i class="fas fa-star"></i>
                                                {{ number_format($provider['rating'], 1) }}
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="empty-row">No provider data available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Popular Services -->
                <div class="table-card">
                    <div class="table-header">
                        <h4><i class="fas fa-fire"></i> Popular Services</h4>
                    </div>
                    <div class="table-wrapper">
                        <table class="analytics-table">
                            <thead>
                                <tr>
                                    <th>Service</th>
                                    <th>Category</th>
                                    <th>Bookings</th>
                                    <th>Revenue</th>
                                    <th>Avg Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($analytics['popular_services'] as $service)
                                    <tr>
                                        <td>
                                            <strong>{{ $service['name'] }}</strong>
                                        </td>
                                        <td>{{ $service['category'] }}</td>
                                        <td>{{ $service['total_bookings'] }}</td>
                                        <td>₹{{ number_format($service['total_revenue'], 2) }}</td>
                                        <td>₹{{ number_format($service['average_price'], 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="empty-row">No service data available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Bookings Table -->
        <div class="detailed-table-section">
            <div class="table-card">
                <div class="table-header">
                    <h4><i class="fas fa-list"></i> Detailed Bookings Report</h4>
                    <p class="table-subtitle">Showing {{ $bookings->count() }} bookings for the selected period</p>
                </div>
                <div class="table-wrapper">
                    <table class="detailed-table">
                        <thead>
                            <tr>
                                <th>Booking ID</th>
                                <th>Customer</th>
                                <th>Service</th>
                                <th>Provider</th>
                                <th>Date</th>
                                <th>Price</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bookings as $booking)
                                <tr>
                                    <td>
                                        <span class="booking-ref">{{ $booking->booking_reference }}</span>
                                    </td>
                                    <td>
                                        <div class="customer-info">
                                            <strong>{{ $booking->customer->name ?? 'N/A' }}</strong>
                                            <small>{{ $booking->customer->email ?? '' }}</small>
                                        </div>
                                    </td>
                                    <td>{{ $booking->service->name ?? 'N/A' }}</td>
                                    <td>{{ $booking->serviceProvider->name ?? 'N/A' }}</td>
                                    <td>{{ $booking->scheduled_date->format('d/m/Y') }}</td>
                                    <td>₹{{ number_format($booking->price, 2) }}</td>
                                    <td>
                                        <span class="status-badge status-{{ strtolower($booking->status) }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="empty-row">
                                        <div class="empty-state">
                                            <i class="fas fa-calendar-times"></i>
                                            <h5>No Bookings Found</h5>
                                            <p>No bookings match the selected filters for this period.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js Library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        /* Analytics Styles */
        .analytics-header-section {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 20px 20px 0 0;
            padding: 30px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-bottom: none;
        }

        .filter-section {
            margin-top: 20px;
        }

        .filter-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .filter-row {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            align-items: end;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .filter-group label {
            font-size: 14px;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.9);
        }

        .filter-input,
        .filter-select {
            padding: 10px 12px;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            font-size: 14px;
            min-width: 140px;
        }

        .filter-input:focus,
        .filter-select:focus {
            outline: none;
            border-color: #00d4ff;
            box-shadow: 0 0 0 2px rgba(0, 212, 255, 0.2);
        }

        .filter-btn {
            padding: 12px 24px;
            font-size: 14px;
            font-weight: 600;
        }

        /* Summary Cards */
        .summary-cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin: 20px 0;
        }

        .summary-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(15px);
            border-radius: 16px;
            padding: 24px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            gap: 20px;
            transition: transform 0.3s ease;
        }

        .summary-card:hover {
            transform: translateY(-4px);
        }

        .summary-card.revenue-card {
            background: linear-gradient(135deg, rgba(34, 197, 94, 0.1), rgba(34, 197, 94, 0.05));
            border-color: rgba(34, 197, 94, 0.3);
        }

        .card-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: #00d4ff;
            background: rgba(0, 212, 255, 0.1);
        }

        .summary-card.revenue-card .card-icon {
            color: #22c55e;
            background: rgba(34, 197, 94, 0.1);
        }

        .card-content h3 {
            font-size: 32px;
            font-weight: 700;
            color: #ffffff;
            margin: 0 0 4px 0;
        }

        .card-content p {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.7);
            margin: 0 0 8px 0;
        }

        .card-trend {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.6);
        }

        .card-trend.positive {
            color: #22c55e;
        }

        .card-trend i {
            font-size: 10px;
        }

        /* Charts Section */
        .charts-section {
            margin: 30px 0;
        }

        .chart-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .chart-row.single {
            grid-template-columns: 1fr;
            max-width: 800px;
            margin: 0 auto;
        }

        .chart-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(15px);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            overflow: hidden;
        }

        .chart-header {
            padding: 20px;
            background: rgba(255, 255, 255, 0.05);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .chart-header h4 {
            margin: 0;
            font-size: 18px;
            font-weight: 600;
            color: #ffffff;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .chart-header h4 i {
            color: #00d4ff;
        }

        .chart-body {
            padding: 20px;
            height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Tables Section */
        .tables-section {
            margin: 30px 0;
        }

        .table-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 20px;
        }

        .table-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(15px);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            overflow: hidden;
        }

        .table-header {
            padding: 20px;
            background: rgba(255, 255, 255, 0.05);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .table-header h4 {
            margin: 0 0 5px 0;
            font-size: 18px;
            font-weight: 600;
            color: #ffffff;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .table-header h4 i {
            color: #00d4ff;
        }

        .table-subtitle {
            margin: 0;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.6);
        }

        .table-wrapper {
            overflow-x: auto;
        }

        .analytics-table {
            width: 100%;
            border-collapse: collapse;
        }

        .analytics-table th {
            padding: 15px 12px;
            text-align: left;
            font-weight: 600;
            color: #ffffff;
            background: rgba(255, 255, 255, 0.05);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .analytics-table td {
            padding: 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .provider-info strong {
            color: #ffffff;
            display: block;
        }

        .provider-info small {
            color: rgba(255, 255, 255, 0.6);
        }

        .rating {
            display: flex;
            align-items: center;
            gap: 4px;
            color: #ffd700;
        }

        .empty-row {
            text-align: center;
            padding: 40px;
            color: rgba(255, 255, 255, 0.5);
        }

        /* Detailed Table */
        .detailed-table-section {
            margin: 30px 0;
        }

        .detailed-table {
            width: 100%;
            border-collapse: collapse;
        }

        .detailed-table th {
            padding: 15px 12px;
            text-align: left;
            font-weight: 600;
            color: #ffffff;
            background: rgba(255, 255, 255, 0.05);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .detailed-table td {
            padding: 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .booking-ref {
            font-family: 'Courier New', monospace;
            background: rgba(0, 212, 255, 0.1);
            padding: 4px 8px;
            border-radius: 4px;
            color: #00d4ff;
            font-weight: 600;
        }

        .customer-info strong {
            color: #ffffff;
            display: block;
        }

        .customer-info small {
            color: rgba(255, 255, 255, 0.6);
        }

        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 500;
            text-transform: uppercase;
        }

        .status-pending {
            background: rgba(245, 158, 11, 0.1);
            color: #f59e0b;
        }

        .status-confirmed {
            background: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
        }

        .status-in_progress {
            background: rgba(168, 85, 247, 0.1);
            color: #a855f7;
        }

        .status-completed {
            background: rgba(34, 197, 94, 0.1);
            color: #22c55e;
        }

        .status-cancelled {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
        }

        .empty-state {
            text-align: center;
            color: rgba(255, 255, 255, 0.5);
        }

        .empty-state i {
            font-size: 48px;
            display: block;
            margin-bottom: 15px;
        }

        .empty-state h5 {
            margin: 0 0 8px 0;
            font-size: 16px;
            color: rgba(255, 255, 255, 0.7);
        }

        .empty-state p {
            margin: 0;
            font-size: 14px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .filter-row {
                flex-direction: column;
                align-items: stretch;
            }

            .summary-cards-grid {
                grid-template-columns: 1fr;
            }

            .chart-row {
                grid-template-columns: 1fr;
            }

            .table-row {
                grid-template-columns: 1fr;
            }

            .analytics-table th,
            .analytics-table td,
            .detailed-table th,
            .detailed-table td {
                padding: 8px 6px;
                font-size: 12px;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Revenue Trend Chart
            const revenueCtx = document.getElementById('revenueTrendChart').getContext('2d');
            const revenueData = @json($analytics['revenue_trend']);

            new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: revenueData.map(item => item.month),
                    datasets: [{
                        label: 'Revenue (AED)',
                        data: revenueData.map(item => item.revenue),
                        borderColor: '#00d4ff',
                        backgroundColor: 'rgba(0, 212, 255, 0.1)',
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#00d4ff',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(255, 255, 255, 0.1)'
                            },
                            ticks: {
                                color: 'rgba(255, 255, 255, 0.7)',
                                callback: function(value) {
                                    return value.toLocaleString() + ' AED';
                                }
                            }
                        },
                        x: {
                            grid: {
                                color: 'rgba(255, 255, 255, 0.1)'
                            },
                            ticks: {
                                color: 'rgba(255, 255, 255, 0.7)'
                            }
                        }
                    }
                }
            });

            // Daily Bookings Chart
            const dailyCtx = document.getElementById('dailyBookingsChart').getContext('2d');
            const dailyData = @json($analytics['daily_bookings']);

            new Chart(dailyCtx, {
                type: 'bar',
                data: {
                    labels: dailyData.map(item => {
                        const date = new Date(item.date);
                        return date.toLocaleDateString('en-IN', {
                            day: '2-digit',
                            month: 'short'
                        });
                    }),
                    datasets: [{
                        label: 'Bookings',
                        data: dailyData.map(item => item.count),
                        backgroundColor: 'rgba(34, 197, 94, 0.6)',
                        borderColor: '#22c55e',
                        borderWidth: 1,
                        borderRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(255, 255, 255, 0.1)'
                            },
                            ticks: {
                                color: 'rgba(255, 255, 255, 0.7)',
                                stepSize: 1
                            }
                        },
                        x: {
                            grid: {
                                color: 'rgba(255, 255, 255, 0.1)'
                            },
                            ticks: {
                                color: 'rgba(255, 255, 255, 0.7)'
                            }
                        }
                    }
                }
            });

            // Status Distribution Chart
            const statusCtx = document.getElementById('statusChart').getContext('2d');
            const statusData = @json($analytics['status_chart_data']);

            const statusColors = {
                'Pending': '#f59e0b',
                'Confirmed': '#3b82f6',
                'In Progress': '#a855f7',
                'Completed': '#22c55e',
                'Cancelled': '#ef4444'
            };

            new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: statusData.map(item => item.status),
                    datasets: [{
                        data: statusData.map(item => item.count),
                        backgroundColor: statusData.map(item => statusColors[item.status] ||
                            '#6b7280'),
                        borderWidth: 0,
                        hoverBorderWidth: 2,
                        hoverBorderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: 'rgba(255, 255, 255, 0.7)',
                                padding: 20,
                                usePointStyle: true
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection
