@extends('admin.layouts.masterlayout')

@section('title', 'Service Offerings')

@section('content')
<style>
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

    .header-actions {
        display: flex;
        gap: 15px;
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

    .offer-name {
        font-weight: 500;
        font-size: 14px;
    }

    .service-name {
        color: rgba(255, 255, 255, 0.8);
        font-size: 13px;
        margin-top: 2px;
    }

    .discount-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 8px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
        background: rgba(138, 43, 226, 0.2);
        color: #8a2be2;
        border: 1px solid rgba(138, 43, 226, 0.3);
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

    .date-range {
        display: block;
        font-size: 11px;
        color: rgba(255, 255, 255, 0.6);
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

    /* Debug section */
    .debug-section {
        background: rgba(0, 0, 0, 0.5);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
        font-family: 'Courier New', monospace;
        font-size: 12px;
        color: #ffffff;
    }

    .debug-title {
        font-weight: bold;
        color: #00d4ff;
        margin-bottom: 10px;
    }

    .debug-info {
        background: rgba(0, 0, 0, 0.3);
        padding: 10px;
        border-radius: 5px;
        border: 1px solid rgba(0, 212, 255, 0.2);
    }
</style>

<div class="modern-index-container">
    <!-- Alert System -->
    <div id="alertContainer" class="alert-container"></div>

    <!-- Debug Information -->
    <div class="debug-section">
        <div class="debug-title">🔍 Debug Information:</div>
        <div class="debug-info">
            <strong>Route:</strong> {{ Route::currentRouteName() }}<br>
            <strong>URL:</strong> {{ Request::fullUrl() }}<br>
            <strong>Method:</strong> {{ Request::method() }}<br>
            <strong>Controller:</strong> {{ get_class($this) }}<br>
            <strong>Offers Count:</strong> {{ $serviceOffers->total() }}<br>
            <strong>Services Count:</strong> {{ $services->count() }}<br>
            <strong>Query Params:</strong> {{ json_encode(Request::query()) }}
        </div>
    </div>

    <!-- Header Section -->
    <div class="index-header-section">
        <div class="header-content">
            <div class="header-icon-wrapper">
                <i class="fas fa-percent"></i>
            </div>
            <div class="header-text">
                <h1 class="header-title">Service Offerings</h1>
                <p class="header-subtitle">Manage promotional offerings for your services</p>
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ route('services.services.index') }}" class="modern-btn modern-btn-outline">
                <i class="fas fa-arrow-left"></i>
                Back to Services
            </a>
            <a href="{{ route('services.offers.create', 1) }}" class="modern-btn modern-btn-primary">
                <i class="fas fa-plus"></i>
                Create Offer
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
                <input type="text" name="search" id="search" value="{{ $search ?? '' }}"
                       placeholder="Search offers..." class="modern-filter-input">
            </div>

            <div class="filter-group">
                <label for="service_id" class="filter-label">
                    <i class="fas fa-concierge-bell"></i>
                    Service
                </label>
                <select name="service_id" id="service_id" class="modern-filter-select">
                    <option value="">All Services</option>
                    @foreach ($services as $service)
                        <option value="{{ $service->id }}" {{ ($service_id ?? '') == $service->id ? 'selected' : '' }}>
                            {{ $service->name }}
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
                    <option value="active" {{ ($status ?? '') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ ($status ?? '') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="filter-actions">
                <button type="submit" class="modern-btn modern-btn-primary">
                    <i class="fas fa-filter"></i>
                    Filter
                </button>
                <a href="{{ route('offers.index') }}" class="modern-btn modern-btn-outline">
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
                Offers List
            </h3>
            <div class="table-info">
                <span class="record-count">{{ $serviceOffers->total() }} offers found</span>
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
                        <th class="th-offer">
                            <i class="fas fa-tag"></i>
                            Offer Details
                        </th>
                        <th class="th-discount">
                            <i class="fas fa-percent"></i>
                            Discount
                        </th>
                        <th class="th-prices">
                            <i class="fas fa-dollar-sign"></i>
                            Discounted Prices
                        </th>
                        <th class="th-status">
                            <i class="fas fa-toggle-on"></i>
                            Status
                        </th>
                        <th class="th-validity">
                            <i class="fas fa-calendar"></i>
                            Validity
                        </th>
                        <th class="th-actions">
                            <i class="fas fa-cogs"></i>
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($serviceOffers as $offer)
                        <tr class="table-row">
                            <td class="td-id">{{ $offer->id }}</td>
                            <td class="td-offer">
                                <div>
                                    <span class="offer-name">{{ $offer->name }}</span>
                                    <div class="service-name">{{ $offer->service->name }}</div>
                                </div>
                            </td>
                            <td class="td-discount">
                                <span class="discount-badge">
                                    {{ $offer->discount_value }}{{ $offer->discount_type == 'percentage' ? '%' : ' AED' }}
                                </span>
                            </td>
                            <td class="td-prices">
                                <div style="font-size: 12px;">
                                    @if($offer->discounted_price_onetime)
                                        <div>Onetime: AED {{ number_format($offer->discounted_price_onetime, 2) }}</div>
                                    @endif
                                    @if($offer->discounted_price_weekly)
                                        <div>Weekly: AED {{ number_format($offer->discounted_price_weekly, 2) }}</div>
                                    @endif
                                    @if($offer->discounted_price_monthly)
                                        <div>Monthly: AED {{ number_format($offer->discounted_price_monthly, 2) }}</div>
                                    @endif
                                    @if($offer->discounted_price_yearly)
                                        <div>Yearly: AED {{ number_format($offer->discounted_price_yearly, 2) }}</div>
                                    @endif
                                    @if(!$offer->discounted_price_onetime && !$offer->discounted_price_weekly && !$offer->discounted_price_monthly && !$offer->discounted_price_yearly)
                                        <span class="no-data">-</span>
                                    @endif
                                </div>
                            </td>
                            <td class="td-status">
                                <span class="status-badge status-{{ $offer->status }}">
                                    <i class="fas fa-{{ $offer->status == 'active' ? 'check-circle' : 'times-circle' }}"></i>
                                    {{ ucfirst($offer->status) }}
                                </span>
                            </td>
                            <td class="td-validity">
                                <span class="date-text">
                                    @if($offer->start_date)
                                        {{ $offer->start_date->format('M d, Y') }}
                                    @else
                                        <span class="no-data">No start date</span>
                                    @endif
                                </span>
                                @if($offer->end_date)
                                    <span class="date-range">to {{ $offer->end_date->format('M d, Y') }}</span>
                                @else
                                    <span class="date-range">No end date</span>
                                @endif
                            </td>
                            <td class="td-actions">
                                <div class="action-buttons">
                                    <a href="{{ route('offers.show', $offer) }}"
                                       class="action-btn action-view" title="View Offer">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('offers.edit', $offer) }}"
                                       class="action-btn action-edit" title="Edit Offer">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="action-btn action-delete"
                                            onclick="confirmDelete({{ $offer->id }}, '{{ $offer->name }}')"
                                            title="Delete Offer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>

                                <!-- Hidden Delete Form -->
                                <form id="deleteForm{{ $offer->id }}" method="POST"
                                      action="{{ route('offers.destroy', $offer) }}"
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
                                    <i class="fas fa-percent"></i>
                                    <h3>No Service Offers Found</h3>
                                    <p>No offers match your current filters.</p>
                                    <a href="{{ route('services.offers.create', 1) }}"
                                       class="modern-btn modern-btn-primary">
                                        <i class="fas fa-plus"></i>
                                        Create First Offer
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($serviceOffers->hasPages())
            <div class="pagination-section">
                {{ $serviceOffers->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>

<script>
function confirmDelete(offerId, offerName) {
    if (confirm(`Are you sure you want to delete the offer "${offerName}"? This action cannot be undone.`)) {
        document.getElementById('deleteForm' + offerId).submit();
    }
}

// Auto-hide success alert
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search');
    const serviceSelect = document.getElementById('service_id');
    const statusSelect = document.getElementById('status');
    let searchTimeout;

    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            document.getElementById('filtersForm').submit();
        }, 500);
    });

    serviceSelect.addEventListener('change', function() {
        document.getElementById('filtersForm').submit();
    });

    statusSelect.addEventListener('change', function() {
        document.getElementById('filtersForm').submit();
    });
});

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
