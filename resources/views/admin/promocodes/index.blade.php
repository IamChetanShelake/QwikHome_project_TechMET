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
                            <i class="fas fa-tags list-main-icon"></i>
                        </div>
                        <div class="list-title-text">
                            <h2 class="list-title">Promocodes Management</h2>
                            <p class="list-subtitle">Manage and monitor all promotional codes</p>
                        </div>
                    </div>
                    <a href="{{ route('promocodes.create') }}" class="modern-btn modern-btn-primary">
                        <i class="fas fa-plus"></i>
                        <span>Create Promocode</span>
                    </a>
                </div>
            </div>

            <!-- Table Section -->
            <div class="modern-table-card">
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
                                        <i class="fas fa-code"></i>
                                        <span>Code</span>
                                    </div>
                                </th>
                                <th>
                                    <div class="th-content">
                                        <i class="fas fa-dollar-sign"></i>
                                        <span>Discount</span>
                                    </div>
                                </th>
                                <th>
                                    <div class="th-content">
                                        <i class="fas fa-chart-line"></i>
                                        <span>Status</span>
                                    </div>
                                </th>
                                <th>
                                    <div class="th-content">
                                        <i class="fas fa-calendar-alt"></i>
                                        <span>Expiry Date</span>
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
                            @forelse ($promocodes as $promocode)
                                <tr class="table-row" data-id="{{ $promocode->id }}">
                                    <td>
                                        <div class="td-content">
                                            <span class="serial-number">{{ $loop->iteration }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="td-content">
                                            <div class="code-badge">
                                                <i class="fas fa-hashtag"></i>
                                                <span>{{ $promocode->code }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="td-content">
                                            <div class="discount-amount">
                                                <span class="amount">{{ number_format($promocode->discount, 2) }}</span>
                                                <span class="currency">{{ config('app.currency', 'AED') }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="td-content">
                                            @if ($promocode->is_used)
                                                <span class="modern-status-badge status-used">
                                                    <i class="fas fa-check-circle"></i>
                                                    Used
                                                </span>
                                            @else
                                                <span class="modern-status-badge status-available">
                                                    <i class="fas fa-clock"></i>
                                                    Available
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="td-content">
                                            <div class="expiry-date">
                                                @if ($promocode->expiry_date)
                                                    <i class="fas fa-calendar-check"></i>
                                                    <span>{{ $promocode->expiry_date->format('d/m/Y') }}</span>
                                                @else
                                                    <i class="fas fa-infinity"></i>
                                                    <span>No Expiry</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="td-content">
                                            <div class="action-buttons">
                                                <a href="{{ route('promocodes.view', $promocode->id) }}" 
                                                   class="action-btn action-view" 
                                                   title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('promocodes.edit', $promocode->id) }}" 
                                                   class="action-btn action-edit" 
                                                   title="Edit Promocode">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" 
                                                        class="action-btn action-delete" 
                                                        title="Delete Promocode"
                                                        onclick="deletePromocode({{ $promocode->id }}, '{{ $promocode->code }}')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">
                                        <div class="empty-state">
                                            <div class="empty-icon">
                                                <i class="fas fa-tags"></i>
                                            </div>
                                            <h3>No Promocodes Found</h3>
                                            <p>Start by creating your first promotional code</p>
                                            <a href="{{ route('promocodes.create') }}" class="modern-btn modern-btn-primary">
                                                <i class="fas fa-plus"></i>
                                                <span>Create First Promocode</span>
                                            </a>
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

    <!-- Delete Form (Hidden) -->
    <form id="deleteForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <style>
        /* Modern List Styles */
        .modern-list-container {
            max-width: 1400px;
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
            background: linear-gradient(135deg, #00d4ff, #0099cc);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 25px rgba(0, 212, 255, 0.3);
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
            background: linear-gradient(135deg, #ffffff, #00d4ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .list-subtitle {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.7);
            margin: 5px 0 0 0;
        }

        /* Table Styles */
        .modern-table-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(15px);
            border-radius: 0 0 20px 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-top: none;
            overflow: hidden;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        .modern-table {
            width: 100%;
            border-collapse: collapse;
        }

        .modern-table th {
            background: rgba(255, 255, 255, 0.05);
            padding: 20px 16px;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .th-content {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 600;
            color: #ffffff;
        }

        .th-content i {
            color: #00d4ff;
            font-size: 12px;
        }

        .modern-table td {
            padding: 20px 16px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .table-row {
            transition: all 0.3s ease;
        }

        .table-row:hover {
            background: rgba(255, 255, 255, 0.03);
        }

        .td-content {
            display: flex;
            align-items: center;
        }

        /* Content Styles */
        .serial-number {
            color: rgba(255, 255, 255, 0.7);
            font-weight: 500;
        }

        .code-badge {
            display: flex;
            align-items: center;
            gap: 6px;
            background: rgba(0, 212, 255, 0.1);
            padding: 6px 12px;
            border-radius: 8px;
            color: #00d4ff;
            font-weight: 600;
            font-family: 'Courier New', monospace;
        }

        .discount-amount {
            display: flex;
            align-items: baseline;
            gap: 4px;
        }

        .discount-amount .amount {
            font-size: 16px;
            font-weight: 600;
            color: #ffffff;
        }

        .discount-amount .currency {
            font-size: 12px;
            color: #00d4ff;
            font-weight: 500;
        }

        .modern-status-badge {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .status-used {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .status-available {
            background: rgba(34, 197, 94, 0.1);
            color: #22c55e;
            border: 1px solid rgba(34, 197, 94, 0.3);
        }

        .expiry-date {
            display: flex;
            align-items: center;
            gap: 6px;
            color: rgba(255, 255, 255, 0.8);
        }

        .expiry-date i {
            color: #00d4ff;
            font-size: 12px;
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
            background: rgba(245, 158, 11, 0.1);
            color: #f59e0b;
            border: 1px solid rgba(245, 158, 11, 0.3);
        }

        .action-edit:hover {
            background: rgba(245, 158, 11, 0.2);
            transform: translateY(-2px);
        }

        .action-delete {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .action-delete:hover {
            background: rgba(239, 68, 68, 0.2);
            transform: translateY(-2px);
        }

        /* Button Styles */
        .modern-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 14px 28px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .modern-btn-primary {
            background: linear-gradient(135deg, #00d4ff, #0099cc);
            color: white;
            box-shadow: 0 8px 25px rgba(0, 212, 255, 0.3);
        }

        .modern-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(0, 212, 255, 0.4);
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

            .modern-table th,
            .modern-table td {
                padding: 12px 8px;
            }

            .th-content,
            .td-content {
                font-size: 12px;
            }

            .action-buttons {
                flex-direction: column;
                gap: 4px;
            }
        }
    </style>

    <script>
        // Auto-hide success alert
        document.addEventListener('DOMContentLoaded', function() {
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
            const alert = document.getElementById('successAlert');
            if (alert) {
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.remove();
                }, 300);
            }
        }

        function deletePromocode(id, code) {
            if (confirm(`Are you sure you want to delete the promocode "${code}"? This action cannot be undone.`)) {
                const form = document.getElementById('deleteForm');
                form.action = `/promocodes/${id}`;
                form.submit();
            }
        }
    </script>
@endsection
