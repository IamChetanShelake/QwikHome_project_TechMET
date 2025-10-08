@extends('admin.layouts.masterlayout')

@section('content')
    <!-- Content Area -->
    <div class="content-area">
        <!-- Dashboard Section -->
        <section id="dashboard-section" class="content-section active">
            <div class="stats-grid">
                <a href="{{ route('vendor.bookings.index') }}" class="stat-card-link">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="stat-content">
                            <h3>{{ number_format($stats['total_bookings']) }}</h3>
                            <p>Total Bookings</p>
                            <span class="stat-change positive">View Details</span>
                        </div>
                    </div>
                </a>
                <div class="stat-card">
                    <div class="stat-icon">
                        <b>AED</b>
                    </div>
                    <div class="stat-content">
                        <h3>{{ number_format($stats['total_revenue'], 2) }}</h3>
                        <p>Total Revenue</p>
                        <span class="stat-info">From all bookings</span>
                    </div>
                </div>
                @if (auth()->user()->isAdmin())
                    <a href="{{ route('customers') }}" class="stat-card-link">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="stat-content">
                                <h3>{{ number_format($stats['total_customers']) }}</h3>
                                <p>Total Customers</p>
                                <span class="stat-change positive">View All</span>
                            </div>
                        </div>
                    </a>
                    <a href="{{ route('serviceProviders.index') }}" class="stat-card-link">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <div class="stat-content">
                                <h3>{{ number_format($stats['total_providers']) }}</h3>
                                <p>Service Providers</p>
                                <span class="stat-change positive">Manage</span>
                            </div>
                        </div>
                    </a>
                @endif
            </div>

            <div class="dashboard-stats-secondary">
                <div class="stats-row">
                    <a href="{{ route('services.services.index') }}" class="stats-item">
                        <div class="stats-item-content">
                            <div class="stats-icon">
                                <i class="fas fa-concierge-bell"></i>
                            </div>
                            <div class="stats-info">
                                <h4>{{ number_format($stats['total_services']) }}</h4>
                                <p>Services</p>
                            </div>
                        </div>
                    </a>
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('coupons.index') }}" class="stats-item">
                            <div class="stats-item-content">
                                <div class="stats-icon">
                                    <i class="fas fa-tags"></i>
                                </div>
                                <div class="stats-info">
                                    <h4>{{ number_format($stats['total_coupons']) }}</h4>
                                    <p>Coupons</p>
                                </div>
                            </div>
                        </a>
                        <a href="{{ route('admin.vendors.index') }}" class="stats-item">
                            <div class="stats-item-content">
                                <div class="stats-icon">
                                    <i class="fas fa-user-tie"></i>
                                </div>
                                <div class="stats-info">
                                    <h4>{{ number_format($stats['total_vendors']) }}</h4>
                                    <p>Vendors</p>
                                </div>
                            </div>
                        </a>
                        <a href="{{ route('complaints.index') }}" class="stats-item">
                            <div class="stats-item-content">
                                <div class="stats-icon">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                                <div class="stats-info">
                                    <h4>{{ number_format($stats['total_complaints']) }}</h4>
                                    <p>Complaints</p>
                                </div>
                            </div>
                        </a>
                    @endif
                </div>
            </div>

            <div class="dashboard-grid">
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3>Recent Bookings</h3>
                        <a href="{{ route('vendor.bookings.index') }}" class="btn-secondary">View All</a>
                    </div>
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Booking ID</th>
                                    <th>Customer</th>
                                    <th>Service</th>
                                    <th>Status</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($stats['recent_bookings'] as $booking)
                                    <tr>
                                        <td>{{ $booking->booking_reference }}</td>
                                        <td>{{ $booking->customer->name ?? 'N/A' }}</td>
                                        <td>{{ $booking->service->name ?? 'N/A' }}</td>
                                        <td>
                                            <span
                                                class="status-badge {{ strtolower(str_replace(' ', '-', $booking->status)) }}">
                                                {{ $booking->status }}
                                            </span>
                                        </td>
                                        <td>{{ number_format($booking->price, 2) }}&nbsp;AED</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" style="text-align: center; padding: 20px;">
                                            No recent bookings found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="dashboard-card">
                    <div class="card-header">
                        <h3>Revenue Chart</h3>
                    </div>
                    <div class="chart-container">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>
        </section>

        <!-- Other sections will be loaded dynamically -->
        <div id="dynamic-content"></div>
    </div>

    <style>
        .stat-card-link {
            text-decoration: none;
            color: inherit;
            transition: transform 0.3s ease;
        }

        .stat-card-link:hover {
            transform: translateY(-2px);
        }

        .stat-info {
            color: rgba(255, 255, 255, 0.6);
            font-size: 11px;
        }

        .dashboard-stats-secondary {
            margin: 30px 0;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 25px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .stats-item {
            display: block;
            text-decoration: none;
            color: inherit;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            padding: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .stats-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .stats-item-content {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .stats-item .stats-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: #00d4ff;
            background: rgba(0, 212, 255, 0.1);
        }

        .stats-info h4 {
            font-size: 24px;
            font-weight: 700;
            color: #ffffff;
            margin: 0 0 2px 0;
        }

        .stats-info p {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.7);
            margin: 0;
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 8px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 12px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: #00d4ff;
        }

        /* Enhanced status badge styles */
        .status-completed {
            background: rgba(34, 197, 94, 0.1);
            color: #22c55e;
        }

        .status-in-progress,
        .status-in_progress {
            background: rgba(168, 85, 247, 0.1);
            color: #a855f7;
        }

        .status-pending {
            background: rgba(245, 158, 11, 0.1);
            color: #f59e0b;
        }

        .status-confirmed {
            background: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
        }

        .status-cancelled {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .stats-row {
                grid-template-columns: repeat(2, 1fr);
            }

            .stats-item-content {
                flex-direction: column;
                text-align: center;
                gap: 10px;
            }
        }
    </style>
@endsection
