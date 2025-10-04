@extends('admin.layouts.masterlayout')

@section('content')
    <style>
        th,
        td {
            text-align: center;
            vertical-align: middle;
        }

        .status-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
            text-transform: uppercase;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-ongoing {
            background: #d1ecf1;
            color: #0c5460;
        }

        .status-completed {
            background: #d4edda;
            color: #155724;
        }

        .stats-card {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            text-align: center;
        }

        .stats-number {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
        }

        .filter-form {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
    </style>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stats-card">
                <h5>Total Bookings</h5>
                <div class="stats-number">{{ $stats['total'] }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <h5>Pending</h5>
                <div class="stats-number" style="color: #856404;">{{ $stats['pending'] }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <h5>Ongoing</h5>
                <div class="stats-number" style="color: #0c5460;">{{ $stats['ongoing'] }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <h5>Completed</h5>
                <div class="stats-number" style="color: #155724;">{{ $stats['completed'] }}</div>
            </div>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="filter-form">
        <form method="GET" action="{{ route('vendor.bookings.index') }}" class="row g-3">
            <div class="col-md-2">
                <select name="status" class="form-select">
                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="ongoing" {{ request('status') == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="provider_id" class="form-select">
                    <option value="">All Providers</option>
                    @foreach ($serviceProviders as $provider)
                        <option value="{{ $provider->id }}"
                            {{ request('provider_id') == $provider->id ? 'selected' : '' }}>
                            {{ $provider->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}"
                    placeholder="Start Date">
            </div>
            <div class="col-md-2">
                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}"
                    placeholder="End Date">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('vendor.bookings.index') }}" class="btn btn-secondary w-100">Clear</a>
            </div>
        </form>
    </div>

    {{-- <div class="header-right mt-3 mx-3 mb-3">
        <div class="search-box">
            <a href="{{ route('vendor.bookings.create') }}" class="btn btn-primary">Create New Booking</a>
        </div>
    </div> --}}

    <div class="content-area">
        <section id="dashboard-section" class="content-section active">
            <div class="dashboard-card">
                <div class="card-header">
                    <h3>Service Monitoring Panel</h3>
                </div>
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Sr.</th>
                                <th>Booking ID</th>
                                <th>Service</th>
                                <th>Customer</th>
                                <th>Provider</th>
                                <th>Date & Time</th>
                                <th>Status</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($bookings as $booking)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $booking->booking_reference }}</td>
                                    <td>
                                        <strong>{{ $booking->service->name ?? 'N/A' }}</strong><br>
                                        <small>{{ $booking->service->category->name ?? '' }}</small>
                                    </td>
                                    <td>
                                        {{ $booking->customer->name }}<br>
                                        <small>{{ $booking->customer->email }}</small>
                                    </td>
                                    <td>{{ $booking->serviceProvider->name }}</td>
                                    <td>
                                        {{ $booking->scheduled_date->format('M d, Y') }}<br>
                                        <small>{{ $booking->start_time }} - {{ $booking->end_time }}</small>
                                    </td>
                                    <td>
                                        <span class="status-badge status-{{ $booking->status }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if ($booking->price)
                                            ${{ number_format($booking->price, 2) }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1 justify-content-center">
                                            <a href="{{ route('vendor.bookings.show', $booking->id) }}"
                                                class="btn btn-sm btn-info" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if ($booking->status != 'completed')
                                                <button class="btn btn-sm btn-success update-status-btn"
                                                    data-bs-toggle="modal" data-bs-target="#statusModal"
                                                    data-booking-id="{{ $booking->id }}"
                                                    data-current-status="{{ $booking->status }}" title="Update Status">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">No bookings found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-3">
                        {{ $bookings->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Status Update Modal -->
    <div class="modal fade" id="statusModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Booking Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="statusForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select" required>
                                <option value="pending">Pending</option>
                                <option value="ongoing">Ongoing</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="vendor_notes" class="form-label">Vendor Notes</label>
                            <textarea name="vendor_notes" id="vendor_notes" class="form-control" rows="3" placeholder="Optional notes"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Status</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Auto hide success alert
            setTimeout(function() {
                $('.alert-success').fadeOut('slow');
            }, 3000);

            // Handle status update modal
            $('.update-status-btn').on('click', function() {
                var bookingId = $(this).data('booking-id');
                var currentStatus = $(this).data('current-status');

                $('#status').val(currentStatus);
                $('#statusForm').attr('action', '{{ url('vendor/bookings') }}/' + bookingId +
                    '/update-status');
                $('#vendor_notes').val('');
            });
        });
    </script>
@endsection
