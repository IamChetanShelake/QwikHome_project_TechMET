@extends('admin.layouts.masterlayout')

@section('title', 'Feedback Management')

@section('content')
    <div class="modern-index-container">
        <!-- Alert System -->
        <div id="alertContainer" class="alert-container"></div>

        <!-- Header Section -->
        <div class="index-header-section">
            <div class="header-content">
                <div class="header-icon-wrapper">
                    <i class="fas fa-comments"></i>
                </div>
                <div class="header-text">
                    <h1 class="header-title">Feedback Management</h1>
                    <p class="header-subtitle">Monitor and analyze customer feedback for your services</p>
                </div>
            </div>
            {{-- <div class="header-actions">
            <a href="#" class="modern-btn modern-btn-primary">
                <i class="fas fa-chart-bar"></i>
                View Analytics
            </a>
        </div> --}}
        </div>

        <!-- Filters Section -->
        <div class="filters-section">
            <form method="GET" class="filters-form" id="filtersForm">
            <div class="filter-group">
                <label for="search" class="filter-label">
                    <i class="fas fa-search"></i>
                    Search
                </label>
                <input type="text" name="query" id="query" value="{{ request('query') }}"
                       placeholder="Search by customer or service..." class="modern-filter-input">
            </div>

            <div class="filter-actions">
                <button type="submit" class="modern-btn modern-btn-secondary">
                    <i class="fas fa-filter"></i>
                    Filter
                </button>
                <a href="{{ route('feedback.index') }}" class="modern-btn modern-btn-outline">
                    <i class="fas fa-times"></i>
                    Clear
                </a>
            </div>
            </form>
        </div>

        <!-- Stats Cards Section -->
        <div class="stats-section">
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-comments"></i>
                    </div>
                    <div class="stat-content">
                        <h3>{{ $feedbacks->count() }}</h3>
                        <p>Total Feedback</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="stat-content">
                        <h3>{{ $feedbacks->avg('rating_service') ? number_format($feedbacks->avg('rating_service'), 1) : '0.0' }}
                        </h3>
                        <p>Avg Service Rating</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="stat-content">
                        <h3>{{ $feedbacks->whereNotNull('rating_employee')->avg('rating_employee') ? number_format($feedbacks->whereNotNull('rating_employee')->avg('rating_employee'), 1) : '0.0' }}
                        </h3>
                        <p>Avg Employee Rating</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <div class="stat-content">
                        <h3>{{ $feedbacks->whereNotNull('comment')->count() }}</h3>
                        <p>With Comments</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="table-section">
            <div class="table-header">
                <h3 class="table-title">
                    <i class="fas fa-list"></i>
                    Feedback Records
                </h3>
                <div class="table-info">
                    <span class="record-count">{{ $feedbacks->count() }} feedback records found</span>
                </div>
            </div>

            <div class="modern-table-container">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th class="th-id">
                                <i class="fas fa-hashtag"></i>
                                ID
                            </th>
                            <th class="th-customer">
                                <i class="fas fa-user"></i>
                                Customer
                            </th>
                            <th class="th-service">
                                <i class="fas fa-concierge-bell"></i>
                                Service
                            </th>
                            <th class="th-employee">
                                <i class="fas fa-user-tie"></i>
                                Employee
                            </th>
                            <th class="th-service-rating">
                                <i class="fas fa-star"></i>
                                Service Rating
                            </th>
                            <th class="th-employee-rating">
                                <i class="fas fa-star-half-alt"></i>
                                Employee Rating
                            </th>
                            <th class="th-comment">
                                <i class="fas fa-comment"></i>
                                Comment
                            </th>
                            <th class="th-date">
                                <i class="fas fa-calendar"></i>
                                Submitted
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($feedbacks as $feedback)
                            <tr class="table-row">
                                <td class="td-id">{{ $feedback->id }}</td>
                                <td class="td-customer">
                                    <div class="customer-cell">
                                        <div class="customer-name">{{ $feedback->user->name }}</div>
                                        <div class="customer-email">{{ $feedback->user->email }}</div>
                                    </div>
                                </td>
                                <td class="td-service">
                                    <span class="service-name">{{ $feedback->service->name }}</span>
                                </td>
                                <td class="td-employee">
                                    @if ($feedback->employee)
                                        <span class="employee-name">{{ $feedback->employee->name }}</span>
                                    @else
                                        <span class="no-data">-</span>
                                    @endif
                                </td>
                                <td class="td-service-rating">
                                    <div class="rating-display">
                                        {!! App\Models\Feedback::renderStars($feedback->rating_service) !!}
                                    </div>
                                </td>
                                <td class="td-employee-rating">
                                    @if ($feedback->rating_employee)
                                        <div class="rating-display">
                                            {!! App\Models\Feedback::renderStars($feedback->rating_employee) !!}
                                        </div>
                                    @else
                                        <span class="no-data">-</span>
                                    @endif
                                </td>
                                <td class="td-comment">
                                    @if ($feedback->comment)
                                        @if (strlen($feedback->comment) > 60)
                                            <span class="comment-text" title="{{ $feedback->comment }}">
                                                {{ substr($feedback->comment, 0, 60) }}...
                                            </span>
                                        @else
                                            <span class="comment-text">{{ $feedback->comment }}</span>
                                        @endif
                                    @else
                                        <span class="no-data">-</span>
                                    @endif
                                </td>
                                <td class="td-date">
                                    <span class="date-text">{{ $feedback->created_at->format('M d, Y') }}</span>
                                    <span class="time-text">{{ $feedback->created_at->format('H:i') }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr class="empty-row">
                                <td colspan="8" class="empty-cell">
                                    <div class="empty-state">
                                        <i class="fas fa-comments"></i>
                                        <h3>No Feedback Found</h3>
                                        <p>No feedback records match your current filters.</p>
                                        {{-- <a href="#" class="modern-btn modern-btn-primary">
                                        <i class="fas fa-chart-bar"></i>
                                        View Analytics
                                    </a> --}}
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        /* Modern Feedback Index Styling - Same as Services */
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
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            border: 1px solid rgba(255, 255, 255, 0.1);
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
            color: #ffffff;
            margin: 0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .header-subtitle {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.8);
            margin: 5px 0 0 0;
        }

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
            min-width: 250px;
        }

        .filter-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 600;
            color: #ffffff;
        }

        .modern-filter-input {
            padding: 12px 16px;
            background: rgba(255, 255, 255, 0.05);
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            color: #ffffff;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .modern-filter-input:focus {
            outline: none;
            border-color: #00d4ff;
            background: rgba(255, 255, 255, 0.08);
            box-shadow: 0 0 15px rgba(0, 212, 255, 0.2);
        }

        .filter-actions {
            display: flex;
            gap: 10px;
            align-items: end;
        }

        .stats-section {
            margin-bottom: 20px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(15px);
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #00d4ff, #0099cc);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: white;
        }

        .stat-content h3 {
            font-size: 24px;
            font-weight: 700;
            color: #ffffff;
            margin: 0;
        }

        .stat-content p {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.7);
            margin: 5px 0 0 0;
            font-weight: 500;
        }

        .table-section {
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

        .modern-table-container {
            overflow-x: auto;
        }

        .modern-table {
            width: 100%;
            border-collapse: collapse;
        }

        .modern-table th {
            background: rgba(0, 212, 255, 0.1);
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: #00d4ff;
            border-bottom: 2px solid rgba(0, 212, 255, 0.2);
            font-size: 14px;
        }

        .modern-table th i {
            margin-right: 8px;
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

        .customer-cell {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .customer-name {
            font-weight: 600;
            font-size: 14px;
            color: #ffffff;
        }

        .customer-email {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.6);
        }

        .service-name,
        .employee-name {
            font-weight: 500;
            font-size: 14px;
            color: rgba(255, 255, 255, 0.9);
        }

        .rating-display {
            font-size: 14px;
            font-weight: 500;
        }

        .rating-display .rating-stars {
            color: #ffd700;
            margin-right: 5px;
        }

        .comment-text {
            color: rgba(255, 255, 255, 0.8);
            font-size: 13px;
            line-height: 1.4;
            max-width: 250px;
            display: block;
        }

        .date-text {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: #ffffff;
        }

        .time-text {
            display: block;
            font-size: 11px;
            color: rgba(255, 255, 255, 0.6);
            margin-top: 2px;
        }

        .no-data {
            color: rgba(255, 255, 255, 0.4);
            font-style: italic;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: rgba(255, 255, 255, 0.7);
        }

        .empty-state i {
            font-size: 48px;
            color: rgba(255, 255, 255, 0.3);
            margin-bottom: 20px;
        }

        .empty-state h3 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #ffffff;
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
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        .modern-btn-secondary:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: #00d4ff;
            color: #00d4ff;
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

        .rating-stars {
            color: #ffd700;
            font-weight: bold;
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

            .stats-grid {
                grid-template-columns: 1fr;
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

            .customer-cell {
                flex-direction: column;
                gap: 2px;
            }
        }
    </style>

    <script>
        // Auto-submit filters on change with debounce
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('query');
            let searchTimeout;

            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    document.getElementById('filtersForm').submit();
                }, 500);
            });
        });
    </script>
@endsection
