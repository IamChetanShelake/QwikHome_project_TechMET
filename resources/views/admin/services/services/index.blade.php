@extends('admin.layouts.masterlayout')

@section('title', 'Services')

@section('content')
    <style>
        /* Modern Services Index Styling */
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

        .modern-filter-input,
        .modern-filter-select {
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

        .modern-filter-select option {
            background-color: #2d2d2d;
            color: #ffffff;
        }

        .modern-filter-input:focus,
        .modern-filter-select:focus {
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

        .name-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .service-image {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            object-fit: cover;
            border: 2px solid rgba(0, 212, 255, 0.3);
        }

        .service-placeholder {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255, 255, 255, 0.5);
        }

        .service-name {
            font-weight: 500;
            font-size: 14px;
        }

        .category-text,
        .subcategory-text {
            color: rgba(255, 255, 255, 0.8);
            font-size: 13px;
        }

        .price-text {
            font-weight: 500;
            color: #00d4ff;
        }

        .rating-text {
            display: flex;
            align-items: center;
            gap: 5px;
            color: #ffd700;
            font-weight: 500;
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

        .pagination-section {
            padding: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Toggle Switch Styles */
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(239, 68, 68, 0.3);
            transition: 0.4s;
            border-radius: 24px;
            border: 2px solid rgba(239, 68, 68, 0.4);
        }

        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 3px;
            bottom: 2px;
            background-color: #ef4444;
            transition: 0.4s;
            border-radius: 50%;
        }

        input:checked+.toggle-slider {
            background-color: rgba(34, 197, 94, 0.3);
            border-color: rgba(34, 197, 94, 0.4);
        }

        input:focus+.toggle-slider {
            box-shadow: 0 0 15px rgba(0, 212, 255, 0.2);
            border-color: #00d4ff;
        }

        input:checked+.toggle-slider:before {
            transform: translateX(26px);
            background-color: #22c55e;
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
                    <i class="fas fa-concierge-bell"></i>
                </div>
                <div class="header-text">
                    <h1 class="header-title">Services</h1>
                    <p class="header-subtitle">Manage and organizeing your service offerings</p>
                </div>
            </div>
            <div class="header-actions">
                <a href="{{ route('services.services.create') }}" class="modern-btn modern-btn-primary">
                    <i class="fas fa-plus"></i>
                    Add New Service
                </a>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="filters-section">
            <form method="GET" class="filters-form" id="filtersForm">
                <div class="filter-group">
                    <label for="search" class="filter-label">
                        <i class="fas fa-search"></i>
                        Search
                    </label>
                    <input type="text" name="search" id="search" value="{{ $search }}"
                        placeholder="Search services..." class="modern-filter-input">
                </div>

                <div class="filter-group">
                    <label for="category_id" class="filter-label">
                        <i class="fas fa-folder"></i>
                        Category
                    </label>
                    <select name="category_id" id="category_id" class="modern-filter-select">
                        <option value="">All Categories</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $category_id == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-group">
                    <label for="subcategory_id" class="filter-label">
                        <i class="fas fa-folder-open"></i>
                        Subcategory
                    </label>
                    <select name="subcategory_id" id="subcategory_id" class="modern-filter-select">
                        <option value="">All Subcategories</option>
                        @foreach ($subcategories as $sub)
                            <option value="{{ $sub->id }}" {{ $subcategory_id == $sub->id ? 'selected' : '' }}>
                                {{ $sub->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-group">
                    <label for="status" class="filter-label">
                        <i class="fas fa-toggle-on"></i>
                        Status
                    </label>
                    <select name="status" id="status" class="modern-filter-select">
                        <option value="">All Status</option>
                        <option value="active" {{ $status == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div class="filter-actions">
                    <button type="submit" class="modern-btn modern-btn-secondary">
                        <i class="fas fa-filter"></i>
                        Filter
                    </button>
                    <a href="{{ route('services.services.index') }}" class="modern-btn modern-btn-outline">
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
                    Services List
                </h3>
                <div class="table-info">
                    <span class="record-count">{{ $services->total() }} services found</span>
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
                                <i class="fas fa-concierge-bell"></i>
                                Service Name
                            </th>
                            <th class="th-category">
                                <i class="fas fa-folder"></i>
                                Category
                            </th>
                            <th class="th-subcategory">
                                <i class="fas fa-folder-open"></i>
                                Subcategory
                            </th>
                            <th class="th-price">
                                <i class="fas fa-dollar-sign"></i>
                                Price
                            </th>
                            <th class="th-status">
                                <i class="fas fa-toggle-on"></i>
                                Status
                            </th>
                            <th class="th-qwikpick">
                                <i class="fas fa-star"></i>
                                Qwikpick
                            </th>
                            <th class="th-beauty-easy">
                                <i class="fas fa-magic"></i>
                                Beauty & Easy
                            </th>
                            <th class="th-rating">
                                <i class="fas fa-star"></i>
                                Rating
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
                        @forelse($services as $service)
                            <tr class="table-row">
                                <td class="td-id">{{ $service->id }}</td>
                                <td class="td-name">
                                    <div class="name-cell">
                                        @if ($service->image)
                                            <img src="{{ asset('Service_images/' . $service->image) }}"
                                                alt="{{ $service->name }}" class="service-image">
                                        @else
                                            <div class="service-placeholder">
                                                <i class="fas fa-concierge-bell"></i>
                                            </div>
                                        @endif
                                        <span class="service-name">{{ $service->name }}</span>
                                    </div>
                                </td>
                                <td class="td-category">
                                    <span class="category-text">{{ $service->category->name }}</span>
                                </td>
                                <td class="td-subcategory">
                                    @if ($service->subcategory)
                                        <span class="subcategory-text">{{ $service->subcategory->name }}</span>
                                    @else
                                        <span class="no-data">-</span>
                                    @endif
                                </td>
                                <td class="td-price">
                                    <span class="price-text">AED
                                        &nbsp;{{ number_format($service->price_onetime ?? 0, 2) }}</span>
                                </td>
                                <td class="td-status">
                                    <span class="status-badge status-{{ $service->status }}">
                                        <i
                                            class="fas fa-{{ $service->status == 'active' ? 'check-circle' : 'times-circle' }}"></i>
                                        {{ ucfirst($service->status) }}
                                    </span>
                                </td>
                                <td class="td-qwikpick">
                                    <label class="toggle-switch">
                                        <input type="checkbox" data-service-id="{{ $service->id }}"
                                            data-field="qwikpick" {{ $service->qwikpick ? 'checked' : '' }}
                                            onchange="toggleField({{ $service->id }}, 'qwikpick', this)">
                                        <span class="toggle-slider"></span>
                                    </label>
                                </td>
                                <td class="td-beauty-easy">
                                    <label class="toggle-switch">
                                        <input type="checkbox" data-service-id="{{ $service->id }}"
                                            data-field="beauty_and_easy" {{ $service->beauty_and_easy ? 'checked' : '' }}
                                            onchange="toggleField({{ $service->id }}, 'beauty_and_easy', this)">
                                        <span class="toggle-slider"></span>
                                    </label>
                                </td>
                                <td class="td-rating">
                                    <span class="rating-text">{{ number_format($service->average_rating ?? 0, 1) }}/5</span>
                                </td>
                                <td class="td-date">
                                    <span class="date-text">{{ $service->created_at->format('M d, Y') }}</span>
                                    <span class="time-text">{{ $service->created_at->format('H:i') }}</span>
                                </td>
                                <td class="td-actions">
                                    <div class="action-buttons">
                                        <a href="{{ route('services.services.show', $service) }}"
                                            class="action-btn action-view" title="View Service">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('services.services.edit', $service) }}"
                                            class="action-btn action-edit" title="Edit Service">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="action-btn action-delete"
                                            onclick="confirmDelete({{ $service->id }}, '{{ $service->name }}')"
                                            title="Delete Service">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>

                                    <!-- Hidden Delete Form -->
                                    <form id="deleteForm{{ $service->id }}" method="POST"
                                        action="{{ route('services.services.destroy', $service) }}"
                                        style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr class="empty-row">
                                <td colspan="11" class="empty-cell">
                                    <div class="empty-state">
                                        <i class="fas fa-concierge-bell"></i>
                                        <h3>No Services Found</h3>
                                        <p>No services match your current filters.</p>
                                        <a href="{{ route('services.services.create') }}"
                                            class="modern-btn modern-btn-primary">
                                            <i class="fas fa-plus"></i>
                                            Create First Service
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($services->hasPages())
                <div class="pagination-section">
                    {{ $services->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>



    <script>
        function confirmDelete(serviceId, serviceName) {
            if (confirm(`Are you sure you want to delete the service "${serviceName}"? This action cannot be undone.`)) {
                document.getElementById('deleteForm' + serviceId).submit();
            }
        }

        // Auto-submit filters on change
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search');
            const categorySelect = document.getElementById('category_id');
            const subcategorySelect = document.getElementById('subcategory_id');
            const statusSelect = document.getElementById('status');

            let searchTimeout;

            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    document.getElementById('filtersForm').submit();
                }, 500);
            });

            categorySelect.addEventListener('change', function() {
                document.getElementById('filtersForm').submit();
            });

            subcategorySelect.addEventListener('change', function() {
                document.getElementById('filtersForm').submit();
            });

            statusSelect.addEventListener('change', function() {
                document.getElementById('filtersForm').submit();
            });
        });

        // Toggle field function
        window.toggleField = function(serviceId, field, checkbox) {
            fetch(`/services/${serviceId}/toggle/${field}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({})
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showAlert(data.message, 'success');
                    } else {
                        showAlert('Error: ' + data.message, 'error');
                        // Revert the checkbox state if error
                        checkbox.checked = !checkbox.checked;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('An error occurred while updating the field.', 'error');
                    // Revert the checkbox state if error
                    checkbox.checked = !checkbox.checked;
                });
        };

        // Alert system
        function showAlert(message, type = 'success') {
            const alertContainer = document.getElementById('alertContainer');
            const alert = document.createElement('div');
            alert.className = `alert alert-${type}`;
            alert.style.cssText = `
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 10px;
            color: #ffffff;
            font-weight: 500;
            animation: slideIn 0.3s ease;
            backdrop-filter: blur(10px);
        `;

            if (type === 'success') {
                alert.style.background = 'rgba(34, 197, 94, 0.2)';
                alert.style.border = '1px solid rgba(34, 197, 94, 0.3)';
            } else {
                alert.style.background = 'rgba(239, 68, 68, 0.2)';
                alert.style.border = '1px solid rgba(239, 68, 68, 0.3)';
            }

            const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
            alert.innerHTML = `
            <i class="fas ${icon}"></i>
            &nbsp;&nbsp;${message}
        `;

            alertContainer.appendChild(alert);

            setTimeout(() => {
                alert.style.animation = 'slideOut 0.3s ease';
                setTimeout(() => {
                    alert.remove();
                }, 300);
            }, 3000);
        }
    </script>
@endsection
