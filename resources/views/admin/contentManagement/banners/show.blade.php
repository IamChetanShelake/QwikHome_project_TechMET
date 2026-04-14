@extends('admin.layouts.masterlayout')

@section('title', 'Banner Details')

@section('content')
<style>
    /* Modern Show Page Styling */
    .modern-show-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .show-header-section {
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
    }

    .header-subtitle {
        font-size: 14px;
        color: rgba(51, 65, 85, 0.8);
        margin: 5px 0 0 0;
    }

    .details-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(15px);
        border-radius: 15px;
        border: 1px solid rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .banner-image-section {
        width: 100%;
        max-height: 400px;
        overflow: hidden;
        background: rgba(0, 0, 0, 0.05);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .banner-image {
        width: 100%;
        height: auto;
        object-fit: cover;
    }

    .details-body {
        padding: 30px;
    }

    .detail-row {
        display: flex;
        margin-bottom: 20px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        padding-bottom: 15px;
    }

    .detail-row:last-child {
        border-bottom: none;
        margin-bottom: 0;
    }

    .detail-label {
        width: 150px;
        font-weight: 600;
        color: #64748b;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .detail-value {
        flex: 1;
        color: #334155;
        font-size: 15px;
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
        background: rgba(0, 0, 0, 0.1);
        color: #334155;
        border: 2px solid rgba(0, 0, 0, 0.2);
    }

    .modern-btn-secondary:hover {
        background: rgba(0, 0, 0, 0.15);
        color: #334155;
    }
</style>

<div class="modern-show-container">
    <!-- Header Section -->
    <div class="show-header-section">
        <div class="header-content">
            <div class="header-icon-wrapper">
                <i class="fas fa-image"></i>
            </div>
            <div class="header-text">
                <h1 class="header-title">Banner Details</h1>
                <p class="header-subtitle">Viewing details for "{{ $banner->title }}"</p>
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ route('contentManagement.banners.edit', $banner) }}" class="modern-btn modern-btn-primary">
                <i class="fas fa-edit"></i>
                Edit Banner
            </a>
            <a href="{{ route('contentManagement.banners.index') }}" class="modern-btn modern-btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Back to List
            </a>
        </div>
    </div>

    <!-- Details Card -->
    <div class="details-card">
        <!-- Image Section -->
        <div class="banner-image-section">
            @if($banner->image)
                <img src="{{ asset('banner_images/' . $banner->image) }}" alt="{{ $banner->title }}" class="banner-image">
            @else
                <div style="padding: 50px; color: #94a3b8;">
                    <i class="fas fa-image" style="font-size: 48px; margin-bottom: 10px;"></i>
                    <p>No Image Available</p>
                </div>
            @endif
        </div>

        <!-- Details Body -->
        <div class="details-body">
            <div class="detail-row">
                <div class="detail-label">
                    <i class="fas fa-heading"></i> Title
                </div>
                <div class="detail-value">
                    {{ $banner->title }}
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">
                    <i class="fas fa-align-left"></i> Description
                </div>
                <div class="detail-value">
                    {{ $banner->description ?? 'No description provided.' }}
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">
                    <i class="fas fa-toggle-on"></i> Status
                </div>
                <div class="detail-value">
                    <span class="status-badge status-{{ $banner->status }}">
                        <i class="fas fa-{{ $banner->status == 'active' ? 'check-circle' : 'times-circle' }}"></i>
                        {{ ucfirst($banner->status) }}
                    </span>
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">
                    <i class="fas fa-calendar"></i> Created At
                </div>
                <div class="detail-value">
                    {{ $banner->created_at->format('F d, Y - h:i A') }}
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">
                    <i class="fas fa-clock"></i> Updated At
                </div>
                <div class="detail-value">
                    {{ $banner->updated_at->format('F d, Y - h:i A') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection