@extends('admin.layouts.masterlayout')

@section('content')
   <style>
            /* Modern Bookings Index Styling */
            .modern-index-container {
                max-width: 1400px;
                margin: 0 auto;
                padding: 20px;
            }

            .alert-container {
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 1000;
            }

            .index-header-section {
                background: rgba(255, 255, 255, 0.9);
                backdrop-filter: blur(10px);
                border-radius: 20px;
                padding: 30px;
                border: 1px solid rgba(0, 0, 0, 0.1);
                display: flex;
                justify-content: space-between;
                align-items: center;
                flex-wrap: wrap;
                gap: 20px;
                margin-bottom: 20px;
            }

            .header-content {
                display: flex;
                align-items: center;
                gap: 20px;
            }

            .header-icon-wrapper {
                width: 60px;
                height: 60px;
                background: linear-gradient(135deg, #00d4ff, #0099cc);
                border-radius: 15px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 24px;
                color: white;
                box-shadow: 0 8px 25px rgba(0, 212, 255, 0.3);
            }

            .header-title {
                font-size: 28px;
                font-weight: 700;
                color: #334155;
                margin: 0;
                text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }

            .header-subtitle {
                font-size: 14px;
                color: rgba(51, 65, 85, 0.8);
                margin: 5px 0 0 0;
            }

            .filters-section {
                background: rgba(255, 255, 255, 0.9);
                backdrop-filter: blur(15px);
                border-radius: 15px;
                padding: 25px;
                border: 1px solid rgba(0, 0, 0, 0.1);
                margin-bottom: 20px;
            }

            .filters-form {
                display: flex;
                gap: 20px;
                align-items: end;
                flex-wrap: wrap;
            }

            .filter-group {
                display: flex;
                flex-direction: column;
                gap: 8px;
                min-width: 200px;
            }

            .filter-label {
                display: flex;
                align-items: center;
                gap: 8px;
                font-size: 14px;
                font-weight: 600;
                color: #334155;
            }

            .modern-filter-input,
            .modern-filter-select {
                padding: 12px 16px;
                background: rgba(255, 255, 255, 0.9);
                border: 2px solid rgba(0, 0, 0, 0.1);
                border-radius: 10px;
                color: #334155;
                font-size: 14px;
                transition: all 0.3s ease;
            }

            .modern-filter-select {
                appearance: none;
                cursor: pointer;
                background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%23334155' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
                background-position: right 12px center;
                background-repeat: no-repeat;
                background-size: 16px;
            }

            .modern-filter-select option {
                background-color: #ffffff;
                color: #334155;
            }

            .modern-filter-input:focus,
            .modern-filter-select:focus {
                outline: none;
                border-color: #3b82f6;
                background: rgba(255, 255, 255, 0.9);
                box-shadow: 0 0 15px rgba(59, 130, 246, 0.2);
            }

            .filter-actions {
                display: flex;
                gap: 10px;
                align-items: end;
            }

            .table-section {
                background: rgba(255, 255, 255, 0.9);
                backdrop-filter: blur(15px);
                border-radius: 15px;
                border: 1px solid rgba(0, 0, 0, 0.1);
                overflow: hidden;
            }

            .table-header {
                padding: 25px;
                border-bottom: 1px solid rgba(0, 0, 0, 0.1);
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .table-title {
                display: flex;
                align-items: center;
                gap: 10px;
                font-size: 18px;
                font-weight: 600;
                color: #334155;
                margin: 0;
            }

            .record-count {
                color: rgba(51, 65, 85, 0.7);
                font-size: 14px;
            }

            .modern-table-container {
                overflow-x: auto;
            }

            .modern-table {
                width: 100%;
                border-collapse: collapse;
            }

            .modern-table th {
                background: rgba(59, 130, 246, 0.1);
                padding: 15px;
                text-align: left;
                font-weight: 600;
                color: #3b82f6;
                border-bottom: 2px solid rgba(59, 130, 246, 0.2);
                font-size: 14px;
            }

            .modern-table th i {
                margin-right: 8px;
            }

            .modern-table td {
                padding: 15px;
                border-bottom: 1px solid rgba(0, 0, 0, 0.05);
                color: #334155;
                vertical-align: middle;
            }

            .table-row:hover {
                background: rgba(0, 0, 0, 0.03);
            }

            .booking-id {
                display: flex;
                align-items: center;
                gap: 8px;
                color: #f59e0b;
                font-weight: 600;
            }

            .service-info {
                display: flex;
                flex-direction: column;
                gap: 4px;
            }

            .service-name {
                color: #334155;
                font-weight: 600;
            }

            .service-category {
                color: rgba(51, 65, 85, 0.6);
                font-size: 12px;
            }

            .customer-info {
                display: flex;
                flex-direction: column;
                gap: 4px;
            }

            .customer-name {
                color: #334155;
                font-weight: 600;
            }

            .customer-email {
                color: rgba(51, 65, 85, 0.6);
                font-size: 12px;
            }

            .provider-name {
                color: #334155;
                font-weight: 500;
            }

            .datetime-info {
                display: flex;
                flex-direction: column;
                gap: 4px;
            }

            .date-text {
                color: #334155;
                font-weight: 500;
            }

            .time-text {
                color: rgba(51, 65, 85, 0.6);
                font-size: 12px;
            }

            .status-badge {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 6px 12px;
                border-radius: 20px;
                font-size: 12px;
                font-weight: 500;
            }

            .status-pending {
                background: rgba(59, 130, 246, 0.2);
                color: #3b82f6;
                border: 1px solid rgba(59, 130, 246, 0.3);
            }

            .status-ongoing {
                background: rgba(59, 130, 246, 0.2);
                color: #3b82f6;
                border: 1px solid rgba(59, 130, 246, 0.3);
            }

            .status-completed {
                background: rgba(34, 197, 94, 0.2);
                color: #22c55e;
                border: 1px solid rgba(34, 197, 94, 0.3);
            }

            .price-text {
                color: #10b981;
                font-weight: 600;
            }

            .action-buttons {
                display: flex;
                gap: 8px;
            }

            .action-btn {
                width: 35px;
                height: 35px;
                border-radius: 8px;
                border: none;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                transition: all 0.3s ease;
                font-size: 14px;
            }

            .action-view {
                background: rgba(59, 130, 246, 0.2);
                color: #3b82f6;
                text-decoration: none;
            }

            .action-view:hover {
                background: rgba(59, 130, 246, 0.3);
                transform: translateY(-2px);
                color: #3b82f6;
            }

            .action-edit {
                background: rgba(59, 130, 246, 0.2);
                color: #3b82f6;
            }

            .action-edit:hover {
                background: rgba(59, 130, 246, 0.3);
                transform: translateY(-2px);
            }

            .empty-state {
                text-align: center;
                padding: 60px 20px;
                color: rgba(51, 65, 85, 0.7);
            }

            .empty-state i {
                font-size: 48px;
                color: rgba(51, 65, 85, 0.3);
                margin-bottom: 20px;
            }

            .empty-state h3 {
                font-size: 24px;
                margin-bottom: 10px;
                color: #334155;
            }

            .empty-state p {
                font-size: 16px;
                margin-bottom: 30px;
            }

            .modern-btn {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                padding: 12px 20px;
                border: none;
                border-radius: 10px;
                font-size: 14px;
                font-weight: 600;
                text-decoration: none;
                cursor: pointer;
                transition: all 0.3s ease;
            }

            .modern-btn-primary {
                background: linear-gradient(135deg, #00d4ff, #0099cc);
                color: white;
                box-shadow: 0 4px 15px rgba(0, 212, 255, 0.3);
            }

            .modern-btn-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 25px rgba(0, 212, 255, 0.4);
                color: white;
            }

            .modern-btn-secondary {
                background: rgba(0, 0, 0, 0.1);
                color: #334155;
                border: 2px solid rgba(0, 0, 0, 0.2);
            }

            .modern-btn-secondary:hover {
                background: rgba(0, 0, 0, 0.15);
                border-color: #00d4ff;
                color: #00d4ff;
                transform: translateY(-2px);
            }

            .modern-btn-outline {
                background: transparent;
                color: rgba(51, 65, 85, 0.7);
                border: 2px solid rgba(0, 0, 0, 0.2);
            }

            .modern-btn-outline:hover {
                background: rgba(0, 0, 0, 0.05);
                color: #334155;
                border-color: rgba(0, 0, 0, 0.3);
            }

            /* Modal Styles */
            .modern-modal .modal-content {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(20px);
                border: 1px solid rgba(0, 0, 0, 0.1);
                border-radius: 16px;
                color: #334155;
            }

            .modern-modal-header {
                background: linear-gradient(135deg, #00d4ff, #0099cc);
                border-radius: 16px 16px 0 0;
                padding: 20px 25px;
                border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            }

            .modal-title {
                display: flex;
                align-items: center;
                gap: 10px;
                color: white;
                font-weight: 600;
            }

            .modern-modal-footer {
                border-top: 1px solid rgba(0, 0, 0, 0.1);
                padding: 20px 25px;
            }

            .form-group-modern {
                margin-bottom: 20px;
            }

            .form-label-modern {
                display: flex;
                align-items: center;
                gap: 8px;
                color: #334155;
                font-weight: 500;
                margin-bottom: 8px;
            }

            .form-label-modern i {
                color: #00d4ff;
            }

            .form-select-modern,
            .form-textarea-modern {
                width: 100%;
                padding: 12px 16px;
                background: rgba(255, 255, 255, 0.9);
                border: 1px solid rgba(0, 0, 0, 0.2);
                border-radius: 8px;
                color: #334155;
                font-size: 14px;
                transition: all 0.3s ease;
            }

            .form-select-modern:focus,
            .form-textarea-modern:focus {
                outline: none;
                border-color: #00d4ff;
                box-shadow: 0 0 0 3px rgba(0, 212, 255, 0.1);
            }

            .form-textarea-modern {
                resize: vertical;
                min-height: 80px;
            }

            .pagination-section {
                padding: 20px;
                border-top: 1px solid rgba(0, 0, 0, 0.1);
            }

            /* Responsive Design */
            @media (max-width: 768px) {
                .index-header-section {
                    flex-direction: column;
                    text-align: center;
                }

                .filters-form {
                    flex-direction: column;
                    align-items: stretch;
                }

                .filter-group {
                    min-width: auto;
                }

                .filter-actions {
                    justify-content: center;
                }

                .table-header {
                    flex-direction: column;
                    gap: 15px;
                    text-align: center;
                }

                .modern-table {
                    font-size: 12px;
                }

                .modern-table th,
                .modern-table td {
                    padding: 10px 8px;
                }
            }
        </style>
    <div class="modern-index-container">
        <!-- Alert System -->
        <div id="alertContainer" class="alert-container"></div>

        <!-- Header Section -->
        <div class="index-header-section">
            <div class="header-content">
                <div class="header-icon-wrapper">
                    <i class="fas fa-tasks"></i>
                </div>
                <div class="header-text">
                    <h1 class="header-title">Bookings Monitoring</h1>
                    <p class="header-subtitle">Monitor and manage all service bookings and their statuses</p>
                </div>
            </div>
            {{-- <div class="header-actions">
                <a href="{{ route('vendor.bookings.create') }}" class="modern-btn modern-btn-primary">
                    <i class="fas fa-plus"></i>
                    Create New Booking
                </a>
            </div> --}}
        </div>
        
          <!-- Auto Cancel Settings Section -->
        <div class="auto-cancel-section"
            style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border-radius: 20px; padding: 30px; border: 1px solid rgba(0, 0, 0, 0.1); margin-bottom: 20px;">
            <h3 style="font-size: 24px; font-weight: 700; color: #334155; margin-bottom: 20px;">Auto Cancel Settings</h3>
            <form id="autoCancelForm" style="display: flex; gap: 20px; align-items: end;">
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <label for="timeLimit" style="font-size: 14px; font-weight: 600; color: #334155;">Time Limit
                        (hours)</label>
                    <input type="number" id="timeLimit" value="{{ \App\Models\Setting::get('auto_cancel_time_limit', 1) }}"
                        min="1"
                        style="padding: 12px 16px; background: rgba(255, 255, 255, 0.9); border: 2px solid rgba(0, 0, 0, 0.1); border-radius: 10px; color: #334155; font-size: 14px;"
                        required>
                </div>
                <button type="submit" class="modern-btn modern-btn-primary" style="height: fit-content;">
                    <i class="fas fa-save"></i>
                    Save Setting
                </button>
                <button type="button" id="cancelOldBookings" class="modern-btn modern-btn-secondary"
                    style="height: fit-content;">
                    <i class="fas fa-times-circle"></i>
                    Cancel Old Pending Bookings
                </button>
            </form>
        </div>


        <!-- Filters Section -->
        <div class="filters-section">
            <form method="GET" action="{{ route('vendor.bookings.index') }}" class="filters-form">
                <div class="filter-group">
                    <label for="status" class="filter-label">
                        <i class="fas fa-filter"></i>
                        Status
                    </label>
                    <select name="status" id="status" class="modern-filter-select">
                        <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="ongoing" {{ request('status') == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed
                        </option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="provider_id" class="filter-label">
                        <i class="fas fa-user"></i>
                        Service Provider
                    </label>
                    <select name="provider_id" id="provider_id" class="modern-filter-select">
                        <option value="">All Providers</option>
                        @foreach ($serviceProviders as $provider)
                            <option value="{{ $provider->id }}"
                                {{ request('provider_id') == $provider->id ? 'selected' : '' }}>
                                {{ $provider->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-group">
                    <label for="start_date" class="filter-label">
                        <i class="fas fa-calendar"></i>
                        Start Date
                    </label>
                    <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}"
                        class="modern-filter-input" placeholder="Select start date">
                </div>

                <div class="filter-group">
                    <label for="end_date" class="filter-label">
                        <i class="fas fa-calendar"></i>
                        End Date
                    </label>
                    <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}"
                        class="modern-filter-input" placeholder="Select end date">
                </div>

                <div class="filter-actions">
                    <button type="submit" class="modern-btn modern-btn-secondary">
                        <i class="fas fa-search"></i>
                        Filter
                    </button>
                    <a href="{{ route('vendor.bookings.index') }}" class="modern-btn modern-btn-outline">
                        <i class="fas fa-times"></i>
                        Clear
                    </a>
                </div>
            </form>
        </div>

        <!-- Table Section -->
        <div class="table-section">
            <div class="table-header">
                <h3 class="table-title">
                    <i class="fas fa-list"></i>
                    Bookings List
                </h3>
                <div class="table-info">
                    <span class="record-count">{{ $bookings->count() }} bookings found</span>
                </div>
            </div>

            <div class="modern-table-container">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th class="th-id">
                                <i class="fas fa-hashtag"></i>
                                Sr.
                            </th>
                            <th class="th-booking">
                                <i class="fas fa-tag"></i>
                                Booking ID
                            </th>
                            <th class="th-service">
                                <i class="fas fa-concierge-bell"></i>
                                Service
                            </th>
                            <th class="th-customer">
                                <i class="fas fa-user"></i>
                                Customer
                            </th>
                            <th class="th-provider">
                                <i class="fas fa-user-tie"></i>
                                Provider
                            </th>
                            <th class="th-datetime">
                                <i class="fas fa-calendar"></i>
                                Date & Time
                            </th>
                            <th class="th-status">
                                <i class="fas fa-info-circle"></i>
                                Status
                            </th>
                            <th class="th-price">
                                <i class="fas fa-dollar-sign"></i>
                                Price
                            </th>
                            <th class="th-actions">
                                <i class="fas fa-cogs"></i>
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $booking)
                            <tr class="table-row">
                                <td class="td-id">{{ $loop->iteration }}</td>
                                <td class="td-booking">
                                    <div class="booking-id">
                                        <i class="fas fa-tag"></i>
                                        <span>{{ $booking->booking_reference ?? 'null' }}</span>
                                    </div>
                                </td>
                                <td class="td-service">
                                    <div class="service-info">
                                        <strong class="service-name">{{ $booking->service->name ?? 'Unassigned' }}</strong>
                                        <small
                                            class="service-category">{{ $booking->service->category->name ?? 'Unassigned'  }}</small>
                                    </div>
                                </td>
                                <td class="td-customer">
                                    <div class="customer-info">
                                        <strong class="customer-name">{{ $booking->customer->name ?? 'n/a'  }}</strong>
                                        <small class="customer-email">{{ $booking->customer->email ?? 'n/a' }}</small>
                                    </div>
                                </td>
                                <td class="td-provider">
                                    <span class="provider-name">{{ $booking->serviceProvider->name ?? 'N' }}</span>
                                </td>
                                <td class="td-datetime">
                                    <div class="datetime-info">
                                        <span class="date-text">{{ $booking->scheduled_date->format('M d, Y') ?? 'n/a' }}</span>
                                        <small class="time-text">{{ $booking->start_time }} -
                                            {{ $booking->end_time }}</small>
                                    </div>
                                </td>
                                <td class="td-status">
                                    <span class="status-badge status-{{ $booking->status }}">
                                        <i
                                            class="fas fa-{{ $booking->status == 'completed' ? 'check' : ($booking->status == 'ongoing' ? 'play' : 'clock') }}"></i>
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                                <td class="td-price">
                                    <span class="price-text">
                                        @if ($booking->price)
                                            AED {{ number_format($booking->price, 2) }}
                                        @else
                                            N/A
                                        @endif
                                    </span>
                                </td>
                                <td class="td-actions">
                                    <div class="action-buttons">
                                        <a href="{{ route('vendor.bookings.show', $booking->id) }}"
                                            class="action-btn action-view" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if ($booking->status != 'completed')
                                            <button class="action-btn action-edit update-status-btn"
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
                            <tr class="empty-row">
                                <td colspan="9" class="empty-cell">
                                    <div class="empty-state">
                                        <i class="fas fa-tasks"></i>
                                        <h3>No Bookings Found</h3>
                                        <p>No bookings match your current filters.</p>

                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($bookings->hasPages())
                <div class="pagination-section">
                    {{ $bookings->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
    </div>

    <!-- Status Update Modal -->
    <div class="modal fade" id="statusModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modern-modal">
                <div class="modal-header modern-modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-edit"></i>
                        Update Booking Status
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="statusForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group-modern">
                            <label for="status" class="form-label-modern">
                                <i class="fas fa-info-circle"></i>
                                Status
                            </label>
                            <select name="status" id="status" class="form-select-modern" required>
                                <option value="pending">Pending</option>
                                <option value="ongoing">Ongoing</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                        <div class="form-group-modern">
                            <label for="vendor_notes" class="form-label-modern">
                                <i class="fas fa-sticky-note"></i>
                                Vendor Notes
                            </label>
                            <textarea name="vendor_notes" id="vendor_notes" class="form-textarea-modern" rows="3"
                                placeholder="Optional notes about this booking"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer modern-modal-footer">
                        <button type="button" class="modern-btn modern-btn-outline" data-bs-dismiss="modal">
                            <i class="fas fa-times"></i>
                            Cancel
                        </button>
                        <button type="submit" class="modern-btn modern-btn-primary">
                            <i class="fas fa-save"></i>
                            Update Status
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            function confirmDelete(categoryId, categoryName) {
                if (confirm(`Are you sure you want to delete the category "${categoryName}"? This action cannot be undone.`)) {
                    document.getElementById('deleteForm' + categoryId).submit();
                }
            }

            // Auto-submit filters on change
            document.addEventListener('DOMContentLoaded', function() {
                const searchInput = document.getElementById('search');
                const statusSelect = document.getElementById('status');

                let searchTimeout;

                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => {
                        document.getElementById('filtersForm').submit();
                    }, 500);
                });

                statusSelect.addEventListener('change', function() {
                    document.getElementById('filtersForm').submit();
                });
            });

            // Handle status update modal
            $(document).ready(function() {
                $('.update-status-btn').on('click', function() {
                    var bookingId = $(this).data('booking-id');
                    var currentStatus = $(this).data('current-status');

                    $('#status').val(currentStatus);
                    $('#statusForm').attr('action', '{{ url('vendor/bookings') }}/' + bookingId +
                        '/update-status');
                    $('#vendor_notes').val('');
                });
            });
            
 // Handle auto cancel settings
            $(document).ready(function() {
                $('#autoCancelForm').on('submit', function(e) {
                    e.preventDefault();
                    var timeLimit = $('#timeLimit').val();
                    $.ajax({
                        url: '{{ route('vendor.bookings.saveAutoCancelSetting') }}',
                        method: 'POST',
                        data: {
                            time_limit: timeLimit,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            showAlert(response.message, 'success');
                        },
                        error: function() {
                            showAlert('Failed to save setting', 'error');
                        }
                    });
                });

                $('#cancelOldBookings').on('click', function() {
                    $.ajax({
                        url: '{{ route('vendor.bookings.cancelOldBookings') }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            showAlert(response.message, 'success');
                            location.reload(); // Reload to see updated bookings
                        },
                        error: function() {
                            showAlert('Failed to cancel bookings', 'error');
                        }
                    });
                });
            });

            function showAlert(message, type) {
                var alertClass = type === 'success' ? 'alert-success' : type === 'error' ? 'alert-danger' : 'alert-info';
                var alertHtml = '<div class="alert ' + alertClass + ' alert-dismissible fade show" role="alert">' +
                    message +
                    '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                    '</div>';
                $('#alertContainer').html(alertHtml);
                setTimeout(function() {
                    $('.alert').alert('close');
                }, 5000);
            }
        </script>
    @endsection
