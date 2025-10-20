@extends('admin.layouts.masterlayout')

@section('title', 'Disclaimers')

@section('content')
    <div class="modern-index-container">
        <!-- Alert System -->
        <div id="alertContainer" class="alert-container"></div>

        <!-- Header Section -->
        <div class="index-header-section">
            <div class="header-content">
                <div class="header-icon-wrapper">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="header-text">
                    <h1 class="header-title">Disclaimers</h1>
                    <p class="header-subtitle">Manage disclaimer content for your website</p>
                </div>
            </div>
            <div class="header-actions">
                <a href="{{ route('contentManagement.disclaimers.create') }}" class="modern-btn modern-btn-primary">
                    <i class="fas fa-plus"></i>
                    Add New Disclaimer
                </a>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif



        <!-- Table Section -->
        <div class="table-section">
            <div class="table-header">
                <h3 class="table-title">
                    <i class="fas fa-list"></i>
                    Disclaimers List
                </h3>
                <div class="table-info">
                    <span class="record-count">{{ $disclaimers->total() }} disclaimers found</span>
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
                            <th class="th-title">
                                <i class="fas fa-heading"></i>
                                Title
                            </th>
                            <th class="th-content">
                                <i class="fas fa-file-alt"></i>
                                Content
                            </th>
                            <th class="th-status">
                                <i class="fas fa-toggle-on"></i>
                                Status
                            </th>
                            <th class="th-date">
                                <i class="fas fa-calendar"></i>
                                Created
                            </th>
                            <th class="th-actions">
                                <i class="fas fa-cogs"></i>
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($disclaimers as $disclaimer)
                            <tr class="table-row">
                                <td class="td-id">{{ $disclaimer->id }}</td>
                                <td class="td-title">
                                    <span class="title-text">{{ $disclaimer->title ?: 'Untitled Disclaimer' }}</span>
                                </td>
                                <td class="td-content">
                                    <span class="content-text">{{ Str::limit($disclaimer->content, 80) }}</span>
                                </td>
                                <td class="td-status">
                                    <span class="status-badge status-{{ $disclaimer->status }}">
                                        <i
                                            class="fas fa-{{ $disclaimer->status == 'active' ? 'check-circle' : 'times-circle' }}"></i>
                                        {{ ucfirst($disclaimer->status) }}
                                    </span>
                                </td>
                                <td class="td-date">
                                    <span class="date-text">{{ $disclaimer->created_at->format('M d, Y') }}</span>
                                    <span class="time-text">{{ $disclaimer->created_at->format('H:i') }}</span>
                                </td>
                                <td class="td-actions">
                                    <div class="action-buttons">
                                        <a href="{{ route('contentManagement.disclaimers.edit', $disclaimer) }}"
                                            class="action-btn action-edit" title="Edit Disclaimer">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="action-btn action-delete"
                                            onclick="confirmDelete({{ $disclaimer->id }}, '{{ addslashes($disclaimer->title ?: 'Untitled Disclaimer') }}')"
                                            title="Delete Disclaimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>

                                    <!-- Hidden Delete Form -->
                                    <form id="deleteForm{{ $disclaimer->id }}" method="POST"
                                        action="{{ route('contentManagement.disclaimers.destroy', $disclaimer) }}"
                                        style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr class="empty-row">
                                <td colspan="6" class="empty-cell">
                                    <div class="empty-state">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        <h3>No Disclaimers Found</h3>
                                        <p>No disclaimers have been created yet.</p>
                                        <a href="{{ route('contentManagement.disclaimers.create') }}"
                                            class="modern-btn modern-btn-primary">
                                            <i class="fas fa-plus"></i>
                                            Create First Disclaimer
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($disclaimers->hasPages())
                <div class="pagination-section">
                    {{ $disclaimers->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>

    <style>
        /* Modern Disclaimers Index Styling */
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
            background: #ffffff;
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            border: 1px solid #e2e8f0;
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
            text-shadow: none;
        }

        .header-subtitle {
            font-size: 14px;
            color: #64748b;
            margin: 5px 0 0 0;
        }

        .table-section {
            background: #ffffff;
            backdrop-filter: blur(15px);
            border-radius: 15px;
            border: 1px solid #e2e8f0;
            overflow: hidden;
        }

        .table-header {
            padding: 25px;
            border-bottom: 1px solid #e2e8f0;
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
            color: #64748b;
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
            background: #f1f5f9;
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: #334155;
            border-bottom: 2px solid #e2e8f0;
            font-size: 14px;
        }

        .modern-table th i {
            margin-right: 8px;
        }

        .modern-table td {
            padding: 15px;
            border-bottom: 1px solid #f1f5f9;
            color: #334155;
            vertical-align: middle;
        }

        .table-row:hover {
            background: #f8fafc;
        }

        .title-text {
            font-weight: 500;
            font-size: 14px;
        }

        .content-text {
            color: #64748b;
            font-size: 13px;
            max-width: 200px;
            display: block;
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

        .status-active {
            background: rgba(34, 197, 94, 0.2);
            color: #22c55e;
            border: 1px solid rgba(34, 197, 94, 0.3);
        }

        .status-inactive {
            background: rgba(239, 68, 68, 0.2);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .date-text {
            display: block;
            font-size: 13px;
            font-weight: 500;
        }

        .time-text {
            display: block;
            font-size: 11px;
            color: #94a3b8;
            margin-top: 2px;
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

        .action-edit {
            background: rgba(59, 130, 246, 0.2);
            color: #3b82f6;
        }

        .action-edit:hover {
            background: rgba(59, 130, 246, 0.3);
            transform: translateY(-2px);
            color: #3b82f6;
        }

        .action-delete {
            background: rgba(239, 68, 68, 0.2);
            color: #ef4444;
        }

        .action-delete:hover {
            background: rgba(239, 68, 68, 0.3);
            transform: translateY(-2px);
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #64748b;
        }

        .empty-state i {
            font-size: 48px;
            color: #cbd5e1;
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
            padding: 12px 24px;
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

        .pagination-section {
            padding: 20px;
            border-top: 1px solid #e2e8f0;
        }

        .alert {
            position: relative;
            padding: 0.75rem 1rem;
            margin-bottom: 1rem;
            border: 1px solid transparent;
            border-radius: 0.375rem;
        }

        .alert-success {
            color: #22c55e;
            background-color: rgba(34, 197, 94, 0.1);
            border-color: rgba(34, 197, 94, 0.3);
        }

        .alert-danger {
            color: #ef4444;
            background-color: rgba(239, 68, 68, 0.1);
            border-color: rgba(239, 68, 68, 0.3);
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

            .modern-table th,
            .modern-table td {
                padding: 10px 8px;
                font-size: 12px;
            }

            .content-text {
                max-width: 120px;
            }
        }
    </style>

    <script>
        function confirmDelete(disclaimerId, disclaimerTitle) {
            if (confirm(
                    `Are you sure you want to delete the disclaimer "${disclaimerTitle}"? This action cannot be undone.`)) {
                document.getElementById('deleteForm' + disclaimerId).submit();
            }
        }

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                alert.classList.add('fade');
                setTimeout(function() {
                    alert.style.display = 'none';
                }, 150);
            });
        }, 5000);
    </script>
@endsection
