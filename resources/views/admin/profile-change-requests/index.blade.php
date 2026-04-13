@extends('admin.layouts.masterlayout')

@section('title', 'Profile Change Requests')

@section('content')
    <style>
        /* Modern Profile Change Requests Index Styling */
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
            background: linear-gradient(135deg, #8b5cf6, #7c3aed);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
            box-shadow: 0 8px 25px rgba(139, 92, 246, 0.3);
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
            background: rgba(139, 92, 246, 0.1);
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: #8b5cf6;
            border-bottom: 2px solid rgba(139, 92, 246, 0.2);
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

        .name-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .provider-image {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            object-fit: cover;
            border: 2px solid rgba(139, 92, 246, 0.3);
        }

        .provider-placeholder {
            width: 40px;
            height: 40px;
            background: rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(0, 0, 0, 0.5);
        }

        .provider-name {
            font-weight: 500;
            font-size: 14px;
        }

        .email-text,
        .phone-text {
            color: rgba(51, 65, 85, 0.8);
            font-size: 13px;
        }

        .date-text {
            display: block;
            font-size: 13px;
            font-weight: 500;
        }

        .time-text {
            display: block;
            font-size: 11px;
            color: rgba(51, 65, 85, 0.6);
            margin-top: 2px;
        }

        .changes-preview {
            max-width: 300px;
            font-size: 12px;
            line-height: 1.4;
        }

        .change-item {
            margin-bottom: 4px;
            padding: 4px 8px;
            background: rgba(139, 92, 246, 0.1);
            border-radius: 4px;
            border-left: 3px solid #8b5cf6;
        }

        .change-label {
            font-weight: 600;
            color: #8b5cf6;
        }

        .change-value {
            color: #334155;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .action-btn {
            padding: 8px 16px;
            border-radius: 8px;
            border: none;
            display: flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
        }

        .action-approve {
            background: rgba(34, 197, 94, 0.2);
            color: #22c55e;
        }

        .action-approve:hover {
            background: rgba(34, 197, 94, 0.3);
            transform: translateY(-2px);
            color: #22c55e;
        }

        .action-reject {
            background: rgba(239, 68, 68, 0.2);
            color: #ef4444;
        }

        .action-reject:hover {
            background: rgba(239, 68, 68, 0.3);
            transform: translateY(-2px);
            color: #ef4444;
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

            .name-cell {
                flex-direction: column;
                gap: 8px;
                text-align: center;
            }

            .changes-preview {
                max-width: 200px;
            }

            .action-buttons {
                flex-direction: column;
                gap: 4px;
            }

            .action-btn {
                padding: 6px 12px;
                font-size: 11px;
            }
        }
    </style>

    <div class="modern-index-container">
        <!-- Alert System -->
        <div id="alertContainer" class="alert-container">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
        </div>

        <!-- Header Section -->
        <div class="index-header-section">
            <div class="header-content">
                <div class="header-icon-wrapper">
                    <i class="fas fa-user-edit"></i>
                </div>
                <div class="header-text">
                    <h1 class="header-title">Profile Change Requests</h1>
                    <p class="header-subtitle">Review and manage service provider profile update requests</p>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="table-section">
            <div class="table-header">
                <h3 class="table-title">
                    <i class="fas fa-list"></i>
                    Pending Requests
                </h3>
                <div class="table-info">
                    <span class="record-count">{{ $requests->count() }} pending requests</span>
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
                            <th class="th-provider">
                                <i class="fas fa-user"></i>
                                Service Provider
                            </th>
                            <th class="th-reason">
                                <i class="fas fa-comment"></i>
                                Reason
                            </th>
                            <th class="th-date">
                                <i class="fas fa-calendar"></i>
                                Submitted
                            </th>
                            <th class="th-actions">
                                <i class="fas fa-cogs"></i>
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($requests as $request)
                            <tr class="table-row">
                                <td class="td-id">{{ $request->id }}</td>
                                <td class="td-provider">
                                    <div class="name-cell">
                                        @if ($request->serviceProvider->image)
                                            <img src="{{ asset('user_images/' . $request->serviceProvider->image) }}"
                                                alt="{{ $request->serviceProvider->name }}" class="provider-image">
                                        @else
                                            <div class="provider-placeholder">
                                                <i class="fas fa-user"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <span class="provider-name">{{ $request->serviceProvider->name }}</span>
                                            <div class="email-text">{{ $request->serviceProvider->email }}</div>
                                            <div class="phone-text">{{ $request->serviceProvider->phone ?: 'No phone' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="td-reason">
                                    <div class="reason-text">
                                        {{ Str::limit($request->reason ?: 'No reason provided', 50) }}
                                    </div>
                                </td>
                                <td class="td-date">
                                    <span class="date-text">{{ $request->created_at->format('M d, Y') }}</span>
                                    <span class="time-text">{{ $request->created_at->format('H:i') }}</span>
                                </td>
                                <td class="td-actions">
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.profile-change-requests.show', $request->id) }}"
                                            class="action-btn action-approve">
                                            <i class="fas fa-eye"></i>
                                            View
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="empty-row">
                                <td colspan="5" class="empty-cell">
                                    <div class="empty-state">
                                        <i class="fas fa-user-edit"></i>
                                        <h3>No Pending Requests</h3>
                                        <p>All profile change requests have been processed</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
@endsection
