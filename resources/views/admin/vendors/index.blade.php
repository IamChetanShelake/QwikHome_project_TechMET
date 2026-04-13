@extends('admin.layouts.masterlayout')

@section('title', 'Vendors')

@section('content')
 <style>
        /* Modern Vendors Index Styling */
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

        .name-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .vendor-image {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            object-fit: cover;
            border: 2px solid rgba(0, 212, 255, 0.3);
        }

        .vendor-placeholder {
            width: 40px;
            height: 40px;
            background: rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(0, 0, 0, 0.5);
        }

        .vendor-name {
            font-weight: 500;
            font-size: 14px;
        }

        .email-text, .phone-text, .address-text {
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
            text-decoration: none;
        }

        .action-view {
            background: rgba(59, 130, 246, 0.2);
            color: #3b82f6;
        }

        .action-view:hover {
            background: rgba(59, 130, 246, 0.3);
            transform: translateY(-2px);
            color: #3b82f6;
        }

        .action-edit {
            background: rgba(245, 158, 11, 0.2);
            color: #f59e0b;
        }

        .action-edit:hover {
            background: rgba(245, 158, 11, 0.3);
            transform: translateY(-2px);
            color: #f59e0b;
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
        }
    </style>
    <div class="modern-index-container">
        <!-- Alert System -->
        <div id="alertContainer" class="alert-container"></div>

        <!-- Header Section -->
        <div class="index-header-section">
            <div class="header-content">
                <div class="header-icon-wrapper">
                    <i class="fas fa-user-tie"></i>
                </div>
                <div class="header-text">
                    <h1 class="header-title">Vendor Management</h1>
                    <p class="header-subtitle">Manage vendor accounts and their access to the platform</p>
                </div>
            </div>
            <div class="header-actions">
                <a href="{{ route('admin.vendors.create') }}" class="modern-btn modern-btn-primary">
                    <i class="fas fa-plus"></i>
                    Add New Vendor
                </a>
            </div>
        </div>

        <!-- Table Section -->
        <div class="table-section">
            <div class="table-header">
                <h3 class="table-title">
                    <i class="fas fa-list"></i>
                    Vendors List
                </h3>
                <div class="table-info">
                    <span class="record-count">{{ $vendors->count() }} vendors found</span>
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
                            <th class="th-image">
                                <i class="fas fa-image"></i>
                                Photo
                            </th>
                            <th class="th-name">
                                <i class="fas fa-user"></i>
                                Name
                            </th>
                            <th class="th-email">
                                <i class="fas fa-envelope"></i>
                                Email
                            </th>
                            <th class="th-phone">
                                <i class="fas fa-phone"></i>
                                Phone
                            </th>
                            <th class="th-address">
                                <i class="fas fa-map-marker-alt"></i>
                                Address
                            </th>
                            <th class="th-date">
                                <i class="fas fa-calendar"></i>
                                Joined
                            </th>
                            <th class="th-actions">
                                <i class="fas fa-cogs"></i>
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($vendors as $vendor)
                            <tr class="table-row">
                                <td class="td-id">{{ $vendor->id }}</td>
                                <td class="td-image">
                                    <div class="name-cell">
                                        @if ($vendor->image)
                                            <img src="{{ asset('user_images/' . $vendor->image) }}"
                                                alt="{{ $vendor->name }}" class="vendor-image">
                                        @else
                                            <div class="vendor-placeholder">
                                                <i class="fas fa-user"></i>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="td-name">
                                    <span class="vendor-name">{{ $vendor->name }}</span>
                                </td>
                                <td class="td-email">
                                    <span class="email-text">{{ $vendor->email }}</span>
                                </td>
                                <td class="td-phone">
                                    <span class="phone-text">{{ $vendor->phone ?: 'Not provided' }}</span>
                                </td>
                                <td class="td-address">
                                    <span class="address-text" title="{{ $vendor->address }}">
                                        {{ Str::limit($vendor->address, 30) ?: 'Not provided' }}
                                    </span>
                                </td>
                                <td class="td-date">
                                    <span class="date-text">{{ $vendor->created_at->format('M d, Y') }}</span>
                                    <span class="time-text">{{ $vendor->created_at->format('H:i') }}</span>
                                </td>
                                <td class="td-actions">
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.vendors.show', $vendor->id) }}"
                                            class="action-btn action-view" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.vendors.edit', $vendor->id) }}"
                                            class="action-btn action-edit" title="Edit Vendor">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="action-btn action-delete"
                                            onclick="confirmDelete({{ $vendor->id }}, '{{ $vendor->name }}')"
                                            title="Delete Vendor">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>

                                    <!-- Hidden Delete Form -->
                                    <form id="deleteForm{{ $vendor->id }}" method="POST"
                                        action="{{ route('admin.vendors.destroy', $vendor->id) }}"
                                        style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr class="empty-row">
                                <td colspan="8" class="empty-cell">
                                    <div class="empty-state">
                                        <i class="fas fa-user-tie"></i>
                                        <h3>No Vendors Found</h3>
                                        <p>Start by creating your first vendor account</p>
                                        <a href="{{ route('admin.vendors.create') }}"
                                            class="modern-btn modern-btn-primary">
                                            <i class="fas fa-plus"></i>
                                            Create First Vendor
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($vendors instanceof \Illuminate\Pagination\LengthAwarePaginator && $vendors->hasPages())
                <div class="pagination-section">
                    {{ $vendors->links() }}
                </div>
            @endif
        </div>
    </div>

   

    <script>
        function confirmDelete(vendorId, vendorName) {
            if (confirm(`Are you sure you want to delete the vendor "${vendorName}"? This action cannot be undone.`)) {
                document.getElementById('deleteForm' + vendorId).submit();
            }
        }
    </script>
@endsection
