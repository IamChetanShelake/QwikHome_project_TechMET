@extends('admin.layouts.masterlayout')

@section('title', 'Banners')

@section('content')
    <div class="modern-index-container">
        <!-- Alert System -->
        <div id="alertContainer" class="alert-container"></div>

        <!-- Header Section -->
        <div class="index-header-section">
            <div class="header-content">
                <div class="header-icon-wrapper">
                    <i class="fas fa-images"></i>
                </div>
                <div class="header-text">
                    <h1 class="header-title">Banners</h1>
                    <p class="header-subtitle">Manage banner images and content for your website</p>
                </div>
            </div>
            <div class="header-actions">
                <a href="{{ route('contentManagement.banners.create') }}" class="modern-btn modern-btn-primary">
                    <i class="fas fa-plus"></i>
                    Add New Banner
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

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Table Section -->
        <div class="table-section">
            <div class="table-header">
                <h3 class="table-title">
                    <i class="fas fa-list"></i>
                    Banners List
                </h3>
                <div class="table-info">
                    <span class="record-count">{{ $banners->total() }} banners found</span>
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
                            <th class="th-name">
                                <i class="fas fa-heading"></i>
                                Title
                            </th>
                            <th class="th-description">
                                <i class="fas fa-file-alt"></i>
                                Description
                            </th>
                            <th class="th-image">
                                <i class="fas fa-image"></i>
                                Image
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
                        @forelse($banners as $banner)
                            <tr class="table-row">
                                <td class="td-id">{{ $banner->id }}</td>
                                <td class="td-name">
                                    <span class="banner-title">{{ $banner->title }}</span>
                                </td>
                                <td class="td-description">
                                    <span class="description-text">{{ Str::limit($banner->description, 50) }}</span>
                                </td>
                                <td class="td-image">
                                    @if ($banner->image)
                                        <img src="{{ asset('banner_images/' . $banner->image) }}" alt="{{ $banner->title }}"
                                            class="banner-image">
                                    @else
                                        <div class="banner-placeholder">
                                            <i class="fas fa-image"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="td-status">
                                    <span class="status-badge status-{{ $banner->status }}">
                                        <i
                                            class="fas fa-{{ $banner->status == 'active' ? 'check-circle' : 'times-circle' }}"></i>
                                        {{ ucfirst($banner->status) }}
                                    </span>
                                </td>
                                <td class="td-date">
                                    <span class="date-text">{{ $banner->created_at->format('M d, Y') }}</span>
                                    <span class="time-text">{{ $banner->created_at->format('H:i') }}</span>
                                </td>
                                <td class="td-actions">
                                    <div class="action-buttons">
                                        <a href="{{ route('contentManagement.banners.show', $banner) }}"
                                            class="action-btn action-view" title="View Banner">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('contentManagement.banners.edit', $banner) }}"
                                            class="action-btn action-edit" title="Edit Banner">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="action-btn action-delete"
                                            onclick="confirmDelete({{ $banner->id }}, '{{ addslashes($banner->title) }}')"
                                            title="Delete Banner">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>

                                    <!-- Hidden Delete Form -->
                                    <form id="deleteForm{{ $banner->id }}" method="POST"
                                        action="{{ route('contentManagement.banners.destroy', $banner) }}"
                                        style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr class="empty-row">
                                <td colspan="7" class="empty-cell">
                                    <div class="empty-state">
                                        <i class="fas fa-images"></i>
                                        <h3>No Banners Found</h3>
                                        <p>No banners have been created yet.</p>
                                        <a href="{{ route('contentManagement.banners.create') }}"
                                            class="modern-btn modern-btn-primary">
                                            <i class="fas fa-plus"></i>
                                            Create First Banner
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($banners->hasPages())
                <div class="pagination-section">
                    {{ $banners->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>

    <style>
        /* Modern Banners Index Styling */
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

        .banner-title {
            font-weight: 500;
            font-size: 14px;
        }

        .description-text {
            color: rgba(255, 255, 255, 0.8);
            font-size: 13px;
        }

        .banner-image {
            width: 80px;
            height: 50px;
            border-radius: 8px;
            object-fit: cover;
            border: 2px solid rgba(0, 212, 255, 0.3);
        }

        .banner-placeholder {
            width: 80px;
            height: 50px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255, 255, 255, 0.5);
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
            color: rgba(255, 255, 255, 0.6);
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

        .action-view {
            background: rgba(0, 212, 255, 0.2);
            color: #00d4ff;
            text-decoration: none;
        }

        .action-view:hover {
            background: rgba(0, 212, 255, 0.3);
            transform: translateY(-2px);
            color: #00d4ff;
        }

        .action-edit {
            background: rgba(59, 130, 246, 0.2);
            color: #3b82f6;
            text-decoration: none;
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

        .pagination-section {
            padding: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
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

            .modern-table {
                font-size: 12px;
            }

            .modern-table th,
            .modern-table td {
                padding: 10px 8px;
            }

            .banner-title {
                max-width: 150px;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }
        }
    </style>

    <script>
        function confirmDelete(bannerId, bannerTitle) {
            if (confirm(`Are you sure you want to delete the banner "${bannerTitle}"? This action cannot be undone.`)) {
                document.getElementById('deleteForm' + bannerId).submit();
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
