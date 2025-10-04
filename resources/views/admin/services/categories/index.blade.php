@extends('admin.layouts.masterlayout')

@section('title', 'Categories')

@section('content')
<div class="modern-index-container">
    <!-- Alert System -->
    <div id="alertContainer" class="alert-container"></div>

    <!-- Header Section -->
    <div class="index-header-section">
        <div class="header-content">
            <div class="header-icon-wrapper">
                <i class="fas fa-folder"></i>
            </div>
            <div class="header-text">
                <h1 class="header-title">Service Categories</h1>
                <p class="header-subtitle">Manage and organize your service categories</p>
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ route('services.categories.create') }}" class="modern-btn modern-btn-primary">
                <i class="fas fa-plus"></i>
                Add New Category
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
                       placeholder="Search categories..." class="modern-filter-input">
            </div>
            
            <div class="filter-group">
                <label for="status" class="filter-label">
                    <i class="fas fa-filter"></i>
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
                <a href="{{ route('services.categories.index') }}" class="modern-btn modern-btn-outline">
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
                Categories List
            </h3>
            <div class="table-info">
                <span class="record-count">{{ $categories->total() }} categories found</span>
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
                            <i class="fas fa-tag"></i>
                            Name
                        </th>
                        <th class="th-description">
                            <i class="fas fa-align-left"></i>
                            Description
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
                    @forelse($categories as $category)
                        <tr class="table-row">
                            <td class="td-id">{{ $category->id }}</td>
                            <td class="td-name">
                                <div class="name-cell">
                                    @if($category->image)
                                        <img src="{{ asset('Category_images/' . $category->image) }}" 
                                             alt="{{ $category->name }}" class="category-image">
                                    @else
                                        <div class="category-placeholder">
                                            <i class="fas fa-folder"></i>
                                        </div>
                                    @endif
                                    <span class="category-name">{{ $category->name }}</span>
                                </div>
                            </td>
                            <td class="td-description">
                                <span class="description-text">{{ Str::limit($category->description ?: 'No description', 50) }}</span>
                            </td>
                            <td class="td-status">
                                <span class="status-badge status-{{ $category->status }}">
                                    <i class="fas fa-{{ $category->status == 'active' ? 'check-circle' : 'times-circle' }}"></i>
                                    {{ ucfirst($category->status) }}
                                </span>
                            </td>
                            <td class="td-date">
                                <span class="date-text">{{ $category->created_at->format('M d, Y') }}</span>
                                <span class="time-text">{{ $category->created_at->format('H:i') }}</span>
                            </td>
                            <td class="td-actions">
                                <div class="action-buttons">
                                    <a href="{{ route('services.categories.edit', $category) }}" 
                                       class="action-btn action-edit" title="Edit Category">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="action-btn action-delete" 
                                            onclick="confirmDelete({{ $category->id }}, '{{ $category->name }}')" 
                                            title="Delete Category">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                
                                <!-- Hidden Delete Form -->
                                <form id="deleteForm{{ $category->id }}" method="POST" 
                                      action="{{ route('services.categories.destroy', $category) }}" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr class="empty-row">
                            <td colspan="6" class="empty-cell">
                                <div class="empty-state">
                                    <i class="fas fa-folder-open"></i>
                                    <h3>No Categories Found</h3>
                                    <p>No categories match your current filters.</p>
                                    <a href="{{ route('services.categories.create') }}" class="modern-btn modern-btn-primary">
                                        <i class="fas fa-plus"></i>
                                        Create First Category
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($categories->hasPages())
            <div class="pagination-section">
                {{ $categories->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>

<style>
    /* Modern Categories Index Styling */
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

    .modern-filter-select option {
        background-color: #2d2d2d;
        color: #ffffff;
    }

    .modern-filter-input:focus, .modern-filter-select:focus {
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

    .category-image {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        object-fit: cover;
        border: 2px solid rgba(0, 212, 255, 0.3);
    }

    .category-placeholder {
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: rgba(255, 255, 255, 0.5);
    }

    .category-name {
        font-weight: 500;
        font-size: 14px;
    }

    .description-text {
        color: rgba(255, 255, 255, 0.8);
        font-size: 13px;
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
</script>
@endsection
