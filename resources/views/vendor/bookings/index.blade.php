@extends('admin.layouts.masterlayout')

@section('content')
    <div class="content-area">
        <div class="modern-list-container">
            <!-- Success Message -->
            @if (session('success'))
                <div class="modern-alert modern-alert-success" id="successAlert">
                    <div class="alert-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="alert-content">
                        <strong>Success!</strong>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button class="alert-close" onclick="closeAlert()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            <!-- Header Section -->
            <div class="list-header-section">
                <div class="list-header-content">
                    <div class="list-title-group">
                        <div class="list-icon-wrapper">
                            <i class="fas fa-tasks list-main-icon"></i>
                        </div>
                        <div class="list-title-text">
                            <h2 class="list-title">Bookings Monitoring</h2>
                            <p class="list-subtitle">Monitor and manage all service bookings and their statuses</p>
                        </div>
                    </div>
                    <a href="{{ route('vendor.bookings.create') }}" class="modern-btn modern-btn-primary">
                        <i class="fas fa-plus"></i>
                        <span>Create New Booking</span>
                    </a>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="stats-grid-section">
                <div class="stats-grid">
                    <div class="stats-card pending-card">
                        <div class="stats-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stats-content">
                            <h3 class="stats-number">{{ $stats['pending'] }}</h3>
                            <p class="stats-label">Pending</p>
                        </div>
                    </div>
                    <div class="stats-card ongoing-card">
                        <div class="stats-icon">
                            <i class="fas fa-play-circle"></i>
                        </div>
                        <div class="stats-content">
                            <h3 class="stats-number">{{ $stats['ongoing'] }}</h3>
                            <p class="stats-label">Ongoing</p>
                        </div>
                    </div>
                    <div class="stats-card completed-card">
                        <div class="stats-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stats-content">
                            <h3 class="stats-number">{{ $stats['completed'] }}</h3>
                            <p class="stats-label">Completed</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters Section -->
            <div class="filters-section">
                <form method="GET" action="{{ route('vendor.bookings.index') }}" class="filters-form">
                    <div class="filter-group">
                        <label for="status" class="filter-label">
                            <i class="fas fa-filter"></i>
                            Status
                        </label>
                        <div class="select-wrapper">
                            <select name="status" id="status" class="modern-filter-select">
                                <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="ongoing" {{ request('status') == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                            <div class="select-arrow">
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>
                    </div>

                    <div class="filter-group">
                        <label for="provider_id" class="filter-label">
                            <i class="fas fa-user"></i>
                            Service Provider
                        </label>
                        <div class="select-wrapper">
                            <select name="provider_id" id="provider_id" class="modern-filter-select">
                                <option value="">All Providers</option>
                                @foreach ($serviceProviders as $provider)
                                    <option value="{{ $provider->id }}"
                                        {{ request('provider_id') == $provider->id ? 'selected' : '' }}>
                                        {{ $provider->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="select-arrow">
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>
                    </div>

                    <div class="filter-group">
                        <label for="start_date" class="filter-label">
                            <i class="fas fa-calendar"></i>
                            Start Date
                        </label>
                        <div class="input-wrapper">
                            <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}"
                                   class="modern-filter-input" placeholder="Select start date">
                            <div class="input-icon">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                        </div>
                    </div>

                    <div class="filter-group">
                        <label for="end_date" class="filter-label">
                            <i class="fas fa-calendar"></i>
                            End Date
                        </label>
                        <div class="input-wrapper">
                            <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}"
                                   class="modern-filter-input" placeholder="Select end date">
                            <div class="input-icon">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                        </div>
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
            <div class="modern-table-card">
                <div class="table-header">
                    <h3 class="table-title">
                        <i class="fas fa-list"></i>
                        Bookings List
                    </h3>
                    <div class="table-info">
                        <span class="record-count">{{ $bookings->total() }} bookings found</span>
                    </div>
                </div>

                <div class="table-wrapper">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>
                                    <div class="th-content">
                                        <i class="fas fa-hashtag"></i>
                                        <span>Sr.</span>
                                    </div>
                                </th>
                                <th>
                                    <div class="th-content">
                                        <i class="fas fa-tag"></i>
                                        <span>Booking ID</span>
                                    </div>
                                </th>
                                <th>
                                    <div class="th-content">
                                        <i class="fas fa-concierge-bell"></i>
                                        <span>Service</span>
                                    </div>
                                </th>
                                <th>
                                    <div class="th-content">
                                        <i class="fas fa-user"></i>
                                        <span>Customer</span>
                                    </div>
                                </th>
                                <th>
                                    <div class="th-content">
                                        <i class="fas fa-user-tie"></i>
                                        <span>Provider</span>
                                    </div>
                                </th>
                                <th>
                                    <div class="th-content">
                                        <i class="fas fa-calendar"></i>
                                        <span>Date & Time</span>
                                    </div>
                                </th>
                                <th>
                                    <div class="th-content">
                                        <i class="fas fa-info-circle"></i>
                                        <span>Status</span>
                                    </div>
                                </th>
                                <th>
                                    <div class="th-content">
                                        <i class="fas fa-dollar-sign"></i>
                                        <span>Price</span>
                                    </div>
                                </th>
                                <th>
                                    <div class="th-content">
                                        <i class="fas fa-cogs"></i>
                                        <span>Actions</span>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($bookings as $booking)
                                <tr class="table-row">
                                    <td>
                                        <div class="td-content">
                                            <span class="serial-number">{{ $loop->iteration }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="td-content">
                                            <div class="booking-id">
                                                <i class="fas fa-tag"></i>
                                                <span>{{ $booking->booking_reference }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="td-content">
                                            <div class="service-info">
                                                <strong class="service-name">{{ $booking->service->name ?? 'N/A' }}</strong>
                                                <small class="service-category">{{ $booking->service->category->name ?? '' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="td-content">
                                            <div class="customer-info">
                                                <strong class="customer-name">{{ $booking->customer->name }}</strong>
                                                <small class="customer-email">{{ $booking->customer->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="td-content">
                                            <span class="provider-name">{{ $booking->serviceProvider->name }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="td-content">
                                            <div class="datetime-info">
                                                <span class="date-text">{{ $booking->scheduled_date->format('M d, Y') }}</span>
                                                <small class="time-text">{{ $booking->start_time }} - {{ $booking->end_time }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="td-content">
                                            <span class="status-badge status-{{ $booking->status }}">
                                                <i class="fas fa-{{ $booking->status == 'completed' ? 'check' : ($booking->status == 'ongoing' ? 'play' : 'clock') }}"></i>
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="td-content">
                                            <span class="price-text">
                                                @if ($booking->price)
                                                    AED {{ number_format($booking->price, 2) }}
                                                @else
                                                    N/A
                                                @endif
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="td-content">
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
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9">
                                        <div class="empty-state">
                                            <div class="empty-icon">
                                                <i class="fas fa-tasks"></i>
                                            </div>
                                            <h3>No Bookings Found</h3>
                                            <p>No bookings match your current filters.</p>
                                            <a href="{{ route('vendor.bookings.create') }}" class="modern-btn modern-btn-primary">
                                                <i class="fas fa-plus"></i>
                                                Create First Booking
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($bookings->hasPages())
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
                            <textarea name="vendor_notes" id="vendor_notes" class="form-textarea-modern"
                                      rows="3" placeholder="Optional notes about this booking"></textarea>
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
    </div>

    <style>
        /* Modern Bookings Monitoring Styles */
        .modern-list-container {
            max-width: 1800px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Alert Styles */
        .modern-alert {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 16px 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            animation: slideInDown 0.3s ease;
        }

        .modern-alert-success {
            background: rgba(34, 197, 94, 0.1);
            border-color: rgba(34, 197, 94, 0.3);
            color: #22c55e;
        }

        .alert-icon {
            font-size: 20px;
        }

        .alert-content {
            flex: 1;
        }

        .alert-content strong {
            display: block;
            font-weight: 600;
            margin-bottom: 2px;
        }

        .alert-close {
            background: none;
            border: none;
            color: inherit;
            cursor: pointer;
            padding: 4px;
            border-radius: 4px;
            transition: background-color 0.2s;
        }

        .alert-close:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        /* Header Styles */
        .list-header-section {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 20px 20px 0 0;
            padding: 30px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-bottom: none;
        }

        .list-header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .list-title-group {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .list-icon-wrapper {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
        }

        .list-main-icon {
            font-size: 24px;
            color: white;
        }

        .list-title {
            font-size: 28px;
            font-weight: 700;
            color: #ffffff;
            margin: 0;
            background: linear-gradient(135deg, #ffffff, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .list-subtitle {
            color: rgba(255, 255, 255, 0.7);
            margin: 5px 0 0 0;
        }

        /* Stats Grid */
        .stats-grid-section {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(10px);
            padding: 25px 30px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-top: none;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .stats-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 25px;
            display: flex;
            align-items: center;
            gap: 15px;
            transition: all 0.3s ease;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.12);
        }

        .stats-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: white;
        }

        .pending-card .stats-icon {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
        }

        .ongoing-card .stats-icon {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
        }

        .completed-card .stats-icon {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
        }

        .stats-content {
            flex: 1;
        }

        .stats-number {
            font-size: 28px;
            font-weight: 700;
            color: #ffffff;
            margin: 0 0 5px 0;
        }

        .stats-label {
            color: rgba(255, 255, 255, 0.7);
            font-size: 14px;
            margin: 0;
        }

        /* Filters Section */
        .filters-section {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(15px);
            border-radius: 15px;
            padding: 25px;
            border: 1px solid rgba(255, 255, 255, 0.1);
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
            color: #ffffff;
        }

        .modern-filter-input, .modern-filter-select {
            padding: 12px 16px;
            background: rgba(255, 255, 255, 0.05);
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            color: #ffffff;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .modern-filter-select {
            appearance: none;
            cursor: pointer;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%23ffffff' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 12px center;
            background-repeat: no-repeat;
            background-size: 16px;
        }

        .modern-filter-input:focus, .modern-filter-select:focus {
            outline: none;
            border-color: #3b82f6;
            background: rgba(255, 255, 255, 0.08);
            box-shadow: 0 0 15px rgba(59, 130, 246, 0.2);
        }

        .filter-actions {
            display: flex;
            gap: 10px;
            align-items: end;
        }

        /* Enhanced Input and Select Wrappers */
        .select-wrapper {
            position: relative;
        }

        .modern-filter-select {
            appearance: none;
            background-image: none;
            cursor: pointer;
            padding-right: 45px !important;
        }

        .select-arrow {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.6);
            font-size: 12px;
            pointer-events: none;
            transition: all 0.3s ease;
        }

        .modern-filter-select:focus + .select-arrow {
            color: #3b82f6;
            transform: translateY(-50%) rotate(180deg);
        }

        .input-wrapper {
            position: relative;
        }

        .modern-filter-input {
            padding-right: 45px !important;
            padding-left: 45px !important;
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.6);
            font-size: 14px;
            pointer-events: none;
            transition: all 0.3s ease;
        }

        .modern-filter-input:focus + .input-icon {
            color: #3b82f6;
        }

        /* Modern Calendar/Date Picker Styling */
        .modern-filter-input[type="date"] {
            position: relative;
            color-scheme: dark;
        }

        .modern-filter-input[type="date"]::-webkit-calendar-picker-indicator {
            background: transparent;
            bottom: 0;
            color: transparent;
            cursor: pointer;
            height: auto;
            left: 0;
            position: absolute;
            right: 0;
            top: 0;
            width: auto;
            opacity: 0;
        }

        .modern-filter-input[type="date"]::-webkit-inner-spin-button,
        .modern-filter-input[type="date"]::-webkit-outer-spin-button {
            height: auto;
            display: none;
        }

        /* Custom calendar icon that works with date inputs */
        .input-wrapper:has(.modern-filter-input[type="date"]) .input-icon {
            pointer-events: none;
            z-index: 1;
        }

        /* Enhanced select options styling */
        .modern-filter-select option {
            background: #2d2d2d;
            color: #ffffff;
            padding: 8px;
        }

        /* Enhanced hover effects for filter elements */
        .filter-group:hover .modern-filter-select,
        .filter-group:hover .modern-filter-input {
            border-color: rgba(59, 130, 246, 0.4);
            box-shadow: 0 0 10px rgba(59, 130, 246, 0.1);
        }

        /* Modern calendar dropdown styling (when supported) */
        .modern-filter-input[type="date"]::-webkit-datetime-edit-fields-wrapper {
            padding: 0;
        }

        .modern-filter-input[type="date"]::-webkit-datetime-edit-text {
            color: #ffffff;
            padding: 0 0.3em;
        }

        .modern-filter-input[type="date"]::-webkit-datetime-edit-month-field,
        .modern-filter-input[type="date"]::-webkit-datetime-edit-day-field,
        .modern-filter-input[type="date"]::-webkit-datetime-edit-year-field {
            padding: 0 0.2em;
        }

        /* Fallback for browsers that don't support color-scheme */
        .modern-filter-input[type="date"] {
            color: #ffffff;
        }

        /* Enhanced date input focus state */
        .modern-filter-input[type="date"]:focus {
            color: #ffffff;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }

        /* Table Styles */
        .modern-table-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(15px);
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            overflow: hidden;
        }

        .table-header {
            padding: 25px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
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
            color: #ffffff;
            margin: 0;
        }

        .record-count {
            color: rgba(255, 255, 255, 0.7);
            font-size: 14px;
        }

        .table-wrapper {
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

        .th-content {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .modern-table td {
            padding: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            color: #ffffff;
            vertical-align: middle;
        }

        .table-row:hover {
            background: rgba(255, 255, 255, 0.03);
        }

        /* Content Styles */
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
            color: #ffffff;
            font-weight: 600;
        }

        .service-category {
            color: rgba(255, 255, 255, 0.6);
            font-size: 12px;
        }

        .customer-info {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .customer-name {
            color: #ffffff;
            font-weight: 600;
        }

        .customer-email {
            color: rgba(255, 255, 255, 0.6);
            font-size: 12px;
        }

        .provider-name {
            color: #ffffff;
            font-weight: 500;
        }

        .datetime-info {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .date-text {
            color: #ffffff;
            font-weight: 500;
        }

        .time-text {
            color: rgba(255, 255, 255, 0.6);
            font-size: 12px;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
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
            background: rgba(16, 185, 129, 0.2);
            color: #10b981;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .price-text {
            color: #10b981;
            font-weight: 600;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .action-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .action-view {
            background: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
            border: 1px solid rgba(59, 130, 246, 0.3);
        }

        .action-view:hover {
            background: rgba(59, 130, 246, 0.2);
            transform: translateY(-2px);
        }

        .action-edit {
            background: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
            border: 1px solid rgba(59, 130, 246, 0.3);
        }

        .action-edit:hover {
            background: rgba(59, 130, 246, 0.2);
            transform: translateY(-2px);
        }

        /* Button Styles */
        .modern-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 14px 28px;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .modern-btn-primary {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
        }

        .modern-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(59, 130, 246, 0.4);
        }

        .modern-btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        .modern-btn-secondary:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: #3b82f6;
            color: #3b82f6;
            transform: translateY(-2px);
        }

        .modern-btn-outline {
            background: transparent;
            color: rgba(255, 255, 255, 0.7);
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        .modern-btn-outline:hover {
            background: rgba(255, 255, 255, 0.05);
            color: #ffffff;
            border-color: rgba(255, 255, 255, 0.3);
        }

        /* Modal Styles */
        .modern-modal .modal-content {
            background: rgba(45, 45, 45, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            color: #ffffff;
        }

        .modern-modal-header {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            border-radius: 16px 16px 0 0;
            padding: 20px 25px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .modal-title {
            display: flex;
            align-items: center;
            gap: 10px;
            color: white;
            font-weight: 600;
        }

        .modern-modal-footer {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding: 20px 25px;
        }

        .form-group-modern {
            margin-bottom: 20px;
        }

        .form-label-modern {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #ffffff;
            font-weight: 500;
            margin-bottom: 8px;
        }

        .form-label-modern i {
            color: #3b82f6;
        }

        .form-select-modern, .form-textarea-modern {
            width: 100%;
            padding: 12px 16px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            color: #ffffff;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-select-modern:focus, .form-textarea-modern:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .form-textarea-modern {
            resize: vertical;
            min-height: 80px;
        }

        /* Pagination */
        .pagination-section {
            padding: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: rgba(255, 255, 255, 0.7);
        }

        .empty-icon {
            font-size: 48px;
            color: rgba(255, 255, 255, 0.3);
            margin-bottom: 20px;
        }

        .empty-state h3 {
            font-size: 20px;
            color: #ffffff;
            margin-bottom: 8px;
        }

        .empty-state p {
            margin-bottom: 24px;
        }

        /* Animations */
        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .modern-list-container {
                padding: 10px;
            }

            .list-header-section {
                padding: 20px;
            }

            .list-header-content {
                flex-direction: column;
                align-items: flex-start;
            }

            .stats-grid {
                grid-template-columns: 1fr;
                gap: 15px;
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

            .modern-table {
                font-size: 12px;
            }

            .modern-table th,
            .modern-table td {
                padding: 10px 8px;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-hide success alert
            const successAlert = document.getElementById('successAlert');
            if (successAlert) {
                setTimeout(function() {
                    successAlert.style.opacity = '0';
                    setTimeout(function() {
                        successAlert.remove();
                    }, 300);
                }, 3000);
            }
        });

        function closeAlert() {
            const alerts = document.querySelectorAll('.modern-alert');
            alerts.forEach(alert => {
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.remove();
                }, 300);
            });
        }

        // Handle status update modal
        $(document).ready(function() {
            $('.update-status-btn').on('click', function() {
                var bookingId = $(this).data('booking-id');
                var currentStatus = $(this).data('current-status');

                $('#status').val(currentStatus);
                $('#statusForm').attr('action', '{{ url('vendor/bookings') }}/' + bookingId + '/update-status');
                $('#vendor_notes').val('');
            });
        });
    </script>
@endsection
