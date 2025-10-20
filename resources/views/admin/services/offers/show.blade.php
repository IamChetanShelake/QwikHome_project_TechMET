@extends('admin.layouts.masterlayout')

@section('title', 'View Service Offer')

@section('content')
<style>
    .modern-show-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 20px;
    }

    .show-header {
        background: #ffffff;
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 30px;
        margin-bottom: 20px;
        border: 1px solid #e2e8f0;
        text-align: center;
    }

    .header-breadcrumb {
        color: #64748b;
        margin-bottom: 15px;
        font-size: 14px;
    }

    .header-breadcrumb a {
        color: #00d4ff;
        text-decoration: none;
    }

    .header-breadcrumb a:hover {
        text-decoration: underline;
    }

    .header-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #8a2be2, #4b0082);
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        color: white;
        box-shadow: 0 8px 25px rgba(138, 43, 226, 0.3);
        margin: 20px 0;
    }

    .header-title {
        font-size: 32px;
        font-weight: 700;
        color: #334155;
        margin: 10px 0 5px;
        text-shadow: none;
    }

    .header-subtitle {
        color: #64748b;
        font-size: 16px;
    }

    .show-section {
        background: #ffffff;
        backdrop-filter: blur(15px);
        border-radius: 15px;
        border: 1px solid #e2e8f0;
        padding: 30px;
        margin-bottom: 20px;
    }

    .section-title {
        color: #334155;
        margin: 0 0 25px 0;
        font-size: 22px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 12px;
        padding-bottom: 10px;
        border-bottom: 2px solid #e2e8f0;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
        margin-bottom: 25px;
    }

    .info-card {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 12px;
        padding: 20px;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .info-label {
        color: rgba(255, 255, 255, 0.7);
        font-size: 12px;
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 0.5px;
        margin-bottom: 5px;
    }

    .info-value {
        color: #ffffff;
        font-size: 16px;
        font-weight: 500;
        margin-bottom: 8px;
    }

    .info-description {
        color: #334155;
        font-size: 14px;
        line-height: 1.5;
    }

    .service-info-card {
        background: #f0f9ff;
        border: 1px solid #0ea5e9;
        border-radius: 12px;
        padding: 25px;
    }

    .service-title {
        color: #0ea5e9;
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .service-details {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-bottom: 20px;
    }

    .service-detail {
        background: #ffffff;
        border-radius: 8px;
        padding: 12px 15px;
        border: 1px solid #e2e8f0;
    }

    .service-label {
        color: #64748b;
        font-size: 11px;
        text-transform: uppercase;
        font-weight: 600;
        margin-bottom: 3px;
    }

    .service-value {
        color: #334155;
        font-size: 14px;
        font-weight: 500;
    }

    .discount-summary {
        background: #faf5ff;
        border: 1px solid #c084fc;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 20px;
    }

    .discount-title {
        color: #7c3aed;
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .discount-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 15px;
    }

    .discount-item {
        background: #ffffff;
        border-radius: 8px;
        padding: 15px;
        text-align: center;
        border: 1px solid #e2e8f0;
    }

    .discount-label {
        color: #64748b;
        font-size: 12px;
        text-transform: uppercase;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .discount-value {
        color: #334155;
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 3px;
    }

    .discount-percent {
        color: #7c3aed;
        font-weight: 600;
        font-size: 14px;
    }

    .prices-section {
        margin-bottom: 25px;
    }

    .prices-title {
        color: #334155;
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .price-comparison {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
    }

    .price-card {
        background: #ffffff;
        border-radius: 10px;
        padding: 20px;
        border: 1px solid #e2e8f0;
        text-align: center;
    }

    .price-frequency {
        color: #334155;
        font-size: 14px;
        font-weight: 600;
        text-transform: uppercase;
        margin-bottom: 10px;
    }

    .price-discounted {
        color: #334155;
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .price-original {
        color: #94a3b8;
        font-size: 16px;
        text-decoration: line-through;
        margin-bottom: 10px;
    }

    .price-save {
        color: #22c55e;
        font-size: 14px;
        font-weight: 600;
    }

    .status-section {
        text-align: center;
        margin-bottom: 25px;
    }

    .status-badge-large {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        padding: 15px 30px;
        border-radius: 25px;
        font-size: 16px;
        font-weight: 600;
        background: rgba(34, 197, 94, 0.2);
        color: #22c55e;
        border: 2px solid rgba(34, 197, 94, 0.3);
    }

    .status-badge-large.inactive {
        background: rgba(239, 68, 68, 0.2);
        color: #ef4444;
        border-color: rgba(239, 68, 68, 0.3);
    }

    .validity-section {
        text-align: center;
    }

    .validity-icon {
        font-size: 48px;
        color: #cbd5e1;
        margin-bottom: 15px;
    }

    .validity-text {
        color: #64748b;
        font-size: 16px;
        margin-bottom: 10px;
    }

    .validity-dates {
        color: #334155;
        font-size: 18px;
        font-weight: 600;
    }

    .action-buttons {
        display: flex;
        gap: 15px;
        justify-content: center;
        margin-top: 40px;
        flex-wrap: wrap;
    }

    .btn {
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

    .btn-primary {
        background: linear-gradient(135deg, #00d4ff, #0099cc);
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 212, 255, 0.4);
    }

    .btn-secondary {
        background: #f8fafc;
        color: #64748b;
        border: 2px solid #e2e8f0;
    }

    .btn-secondary:hover {
        background: #e2e8f0;
        border-color: #00d4ff;
        color: #334155;
        transform: translateY(-2px);
    }

    .btn-outline {
        background: #f8fafc;
        color: #64748b;
        border: 2px solid #e2e8f0;
    }

    .btn-outline:hover {
        background: #e2e8f0;
        color: #334155;
        border-color: #00d4ff;
        transform: translateY(-2px);
    }

    .btn-danger {
        background: #fef2f2;
        color: #dc2626;
        border: 2px solid #fecaca;
    }

    .btn-danger:hover {
        background: #fecaca;
        border-color: #dc2626;
        transform: translateY(-2px);
    }

    .no-price {
        color: #94a3b8;
        font-style: italic;
        font-size: 14px;
    }
</style>

<div class="modern-show-container">
    <!-- Header -->
    <div class="show-header">
        <div class="header-breadcrumb">
            <a href="{{ route('services.services.index') }}">Services</a> →
            <a href="{{ route('offers.index') }}">Offers</a> →
            <span>View Offer</span>
        </div>

        <div class="header-icon">
            <i class="fas fa-percent"></i>
        </div>

        <h1 class="header-title">{{ $serviceOffer->name }}</h1>
        <p class="header-subtitle">Service offer details and pricing</p>
    </div>

    <!-- Service Information -->
    <div class="show-section">
        <h2 class="section-title">
            <i class="fas fa-concierge-bell"></i>
            Service Information
        </h2>

        <div class="service-info-card">
            <h3 class="service-title">
                <i class="fas fa-tag"></i>
                {{ $serviceOffer->service->name }}
            </h3>

            <div class="service-details">
                <div class="service-detail">
                    <div class="service-label">Category</div>
                    <div class="service-value">{{ $serviceOffer->service->category->name }}</div>
                </div>

                @if($serviceOffer->service->subcategory)
                <div class="service-detail">
                    <div class="service-label">Subcategory</div>
                    <div class="service-value">{{ $serviceOffer->service->subcategory->name }}</div>
                </div>
                @endif

                <div class="service-detail">
                    <div class="service-label">Original Price</div>
                    <div class="service-value">AED {{ number_format($serviceOffer->service->price_onetime, 2) }}</div>
                </div>

                <div class="service-detail">
                    <div class="service-label">Service Status</div>
                    <div class="service-value">
                        <span class="status-badge status-{{ $serviceOffer->service->status }}">
                            {{ ucfirst($serviceOffer->service->status) }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="info-description">
                @if($serviceOffer->service->description)
                    {{ $serviceOffer->service->description }}
                @else
                    Service description not available.
                @endif
            </div>
        </div>
    </div>

    <!-- Discount Summary -->
    <div class="show-section">
        <h2 class="section-title">
            <i class="fas fa-percentage"></i>
            Discount Configuration
        </h2>

        <div class="discount-summary">
            <h3 class="discount-title">
                <i class="fas fa-tags"></i>
                Current Discount Settings
            </h3>

            <div class="discount-grid">
                <div class="discount-item">
                    <div class="discount-label">Discount Type</div>
                    <div class="discount-value">{{ ucfirst($serviceOffer->discount_type) }}</div>
                </div>

                <div class="discount-item">
                    <div class="discount-label">Discount Value</div>
                    <div class="discount-value">
                        {{ $serviceOffer->discount_value }}
                        <span class="discount-percent">{{ $serviceOffer->discount_type == 'percentage' ? '%' : 'AED' }}</span>
                    </div>
                </div>

                <div class="discount-item">
                    <div class="discount-label">Offer Status</div>
                    <div class="discount-value">
                        <span class="status-badge status-{{ $serviceOffer->status }}">
                            {{ ucfirst($serviceOffer->status) }}
                        </span>
                    </div>
                </div>
            </div>

            @if($serviceOffer->description)
            <div style="margin-top: 20px; color: #64748b;">
                <strong>Description:</strong> {{ $serviceOffer->description }}
            </div>
            @endif
        </div>
    </div>

    <!-- Pricing Section -->
    <div class="show-section">
        <h2 class="section-title">
            <i class="fas fa-dollar-sign"></i>
            Pricing Details
        </h2>

        <div class="prices-section">
            <h3 class="prices-title">
                <i class="fas fa-chart-line"></i>
                Discounted Prices by Frequency Options
            </h3>

            @if($frequencyOptions->count() > 0)
                <div class="price-comparison">
                    @foreach($frequencyOptions as $frequencyOption)
                        @php
                            $discountRecord = $serviceOffer->frequencyOptionDiscounts->firstWhere('frequency_option_id', $frequencyOption->id);
                        @endphp
                        <div class="price-card">
                            <div class="price-frequency">{{ ucfirst($frequencyOption->frequency_type) }} ({{ $frequencyOption->no_of_times }} times)</div>
                            @if($discountRecord)
                                <div class="price-discounted">AED {{ number_format($discountRecord->discounted_price, 2) }}</div>
                                <div class="price-original">AED {{ number_format($frequencyOption->price_per_time, 2) }}</div>
                                <div class="price-save">
                                    Save AED {{ number_format($frequencyOption->price_per_time - $discountRecord->discounted_price, 2) }}
                                </div>
                            @else
                                <div class="no-price">Not discounted</div>
                                <div class="price-original">AED {{ number_format($frequencyOption->price_per_time, 2) }}</div>
                            @endif
                            <div class="info-description" style="margin-top: 10px;">
                                Duration: {{ $frequencyOption->duration }} days
                                @if($frequencyOption->description)
                                    <br>{{ $frequencyOption->description }}
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="info-description">
                    No frequency options available for this service.
                </div>
            @endif
        </div>
    </div>

    <!-- Status & Validity -->
    <div class="show-section">
        <div class="status-section">
            <div class="status-badge-large {{ $serviceOffer->status == 'inactive' ? 'inactive' : '' }}">
                <i class="fas fa-{{ $serviceOffer->status == 'active' ? 'check-circle' : 'times-circle' }}"></i>
                {{ ucfirst($serviceOffer->status) }} Offer
            </div>
        </div>

        <div class="validity-section">
            <div class="validity-icon">
                <i class="fas fa-calendar-alt"></i>
            </div>

            <div class="validity-text">Offer Validity Period</div>

            @if($serviceOffer->start_date || $serviceOffer->end_date)
                <div class="validity-dates">
                    @if($serviceOffer->start_date)
                        <span>From: {{ $serviceOffer->start_date->format('M d, Y') }}</span>
                    @else
                        <span>No start date</span>
                    @endif

                    @if($serviceOffer->end_date)
                        <span style="margin-left: 20px;">To: {{ $serviceOffer->end_date->format('M d, Y') }}</span>
                    @else
                        <span style="margin-left: 20px;">No end date</span>
                    @endif
                </div>
            @else
                <div class="validity-dates">No validity period set (Permanent offer)</div>
            @endif
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="action-buttons">
        <a href="{{ route('offers.edit', $serviceOffer) }}" class="btn btn-secondary">
            <i class="fas fa-edit"></i>
            Edit Offer
        </a>

        <button type="button" class="btn btn-danger" onclick="confirmDelete()">
            <i class="fas fa-trash"></i>
            Delete Offer
        </button>

        <a href="{{ route('offers.index') }}" class="btn btn-outline">
            <i class="fas fa-arrow-left"></i>
            Back to Offers
        </a>
    </div>

    <!-- Hidden Delete Form -->
    <form id="deleteForm" method="POST" action="{{ route('offers.destroy', $serviceOffer) }}" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
</div>

<script>
function confirmDelete() {
    if (confirm('Are you sure you want to delete this offer? This action cannot be undone.')) {
        document.getElementById('deleteForm').submit();
    }
}
</script>
@endsection
