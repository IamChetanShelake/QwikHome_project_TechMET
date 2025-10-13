@extends('admin.layouts.masterlayout')

@section('title', 'View Campaign: ' . $campaign->title)

@section('content')
<div class="modern-show-container">
    <!-- Header Section -->
    <div class="show-header-section">
        <div class="header-content">
            <div class="header-icon-wrapper">
                <i class="fas fa-bullhorn"></i>
            </div>
            <div class="header-text">
                <h1 class="header-title">Campaign Details</h1>
                <p class="header-subtitle">View complete campaign information</p>
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ route('contentManagement.campaigns.index') }}" class="modern-btn modern-btn-outline">
                <i class="fas fa-arrow-left"></i>
                Back to List
            </a>
            <a href="{{ route('contentManagement.campaigns.edit', $campaign) }}" class="modern-btn modern-btn-secondary">
                <i class="fas fa-edit"></i>
                Edit Campaign
            </a>
        </div>
    </div>

    <!-- Content Section -->
    <div class="content-grid">
        <!-- Main Details Card -->
        <div class="details-card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fas fa-info-circle"></i>
                    Campaign Information
                </h2>
            </div>
            <div class="card-content">
                <div class="info-grid">
                    <div class="info-row">
                        <span class="info-label">Campaign ID:</span>
                        <span class="info-value">#{{ $campaign->id }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Title:</span>
                        <span class="info-value">{{ $campaign->title ?: 'No title' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Status:</span>
                        <span class="info-value">
                            <span class="status-badge status-{{ $campaign->status }}">
                                <i class="fas fa-{{ $campaign->status == 'active' ? 'check-circle' : 'times-circle' }}"></i>
                                {{ ucfirst($campaign->status) }}
                            </span>
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Created:</span>
                        <span class="info-value">{{ $campaign->created_at->format('M d, Y \a\t H:i') }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Last Updated:</span>
                        <span class="info-value">{{ $campaign->updated_at->format('M d, Y \a\t H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Description Card -->
        <div class="details-card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fas fa-file-alt"></i>
                    Description
                </h2>
            </div>
            <div class="card-content">
                @if($campaign->description)
                    <p class="description-text">{{ $campaign->description }}</p>
                @else
                    <p class="no-data"><i class="fas fa-info-circle"></i> No description provided</p>
                @endif
            </div>
        </div>

        <!-- Image Card -->
        <div class="details-card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fas fa-image"></i>
                    Campaign Image
                </h2>
            </div>
            <div class="card-content">
                @if($campaign->image)
                    <div class="image-section">
                        <img src="{{ asset('campaign_images/' . $campaign->image) }}" alt="{{ $campaign->title }}" class="campaign-image">
                        <div class="image-actions">
                            <a href="{{ asset('campaign_images/' . $campaign->image) }}" target="_blank" class="image-btn">
                                <i class="fas fa-external-link-alt"></i>
                                View Full Size
                            </a>
                            <span class="image-info">{{ $campaign->image }}</span>
                        </div>
                    </div>
                @else
                    <div class="no-image-section">
                        <i class="fas fa-image"></i>
                        <span>No image uploaded for this campaign</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Actions Card -->
        <div class="details-card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fas fa-cogs"></i>
                    Actions
                </h2>
            </div>
            <div class="card-content">
                <div class="action-buttons">
                    <a href="{{ route('contentManagement.campaigns.edit', $campaign) }}" class="action-btn action-edit">
                        <i class="fas fa-edit"></i>
                        Edit Campaign
                    </a>
                    <button type="button" class="action-btn action-delete"
                            onclick="confirmDelete({{ $campaign->id }}, '{{ addslashes($campaign->title ?: 'Untitled Campaign') }}')">
                        <i class="fas fa-trash"></i>
                        Delete Campaign
                    </button>
                </div>

                <!-- Hidden Delete Form -->
                <form id="deleteForm{{ $campaign->id }}" method="POST"
                      action="{{ route('contentManagement.campaigns.destroy', $campaign) }}" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .modern-show-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .show-header-section {
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
        margin-bottom: 30px;
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
        gap: 10px;
    }

    .content-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
        gap: 20px;
    }

    .details-card {
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(15px);
        border-radius: 15px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        overflow: hidden;
    }

    .card-header {
        padding: 20px 25px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        background: rgba(255, 255, 255, 0.03);
    }

    .card-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 18px;
        font-weight: 600;
        color: #ffffff;
        margin: 0;
    }

    .card-title i {
        color: #00d4ff;
    }

    .card-content {
        padding: 25px;
    }

    .info-grid {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .info-label {
        font-weight: 500;
        color: rgba(255, 255, 255, 0.7);
        font-size: 14px;
    }

    .info-value {
        font-weight: 600;
        color: #ffffff;
        font-size: 14px;
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

    .description-text {
        color: #ffffff;
        line-height: 1.6;
        font-size: 14px;
        margin: 0;
        white-space: pre-wrap;
    }

    .no-data {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        color: rgba(255, 255, 255, 0.5);
        font-style: italic;
        padding: 20px;
    }

    .image-section {
        text-align: center;
    }

    .campaign-image {
        max-width: 100%;
        height: auto;
        border-radius: 10px;
        border: 2px solid rgba(0, 212, 255, 0.3);
        margin-bottom: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .image-actions {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
    }

    .image-btn {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 8px 15px;
        background: rgba(0, 212, 255, 0.1);
        color: #00d4ff;
        text-decoration: none;
        border-radius: 8px;
        font-size: 12px;
        border: 1px solid rgba(0, 212, 255, 0.3);
        transition: all 0.3s ease;
    }

    .image-btn:hover {
        background: rgba(0, 212, 255, 0.2);
        transform: translateY(-1px);
    }

    .image-info {
        font-size: 12px;
        color: rgba(255, 255, 255, 0.6);
        font-family: monospace;
    }

    .no-image-section {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 15px;
        padding: 40px 20px;
        color: rgba(255, 255, 255, 0.6);
    }

    .no-image-section i {
        font-size: 48px;
        opacity: 0.5;
    }

    .action-buttons {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
    }

    .action-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 20px;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        flex: 1;
        justify-content: center;
    }

    .action-edit {
        background: rgba(59, 130, 246, 0.2);
        color: #3b82f6;
        border: 2px solid rgba(59, 130, 246, 0.3);
    }

    .action-edit:hover {
        background: rgba(59, 130, 246, 0.3);
        transform: translateY(-2px);
    }

    .action-delete {
        background: rgba(239, 68, 68, 0.2);
        color: #ef4444;
        border: 2px solid rgba(239, 68, 68, 0.3);
    }

    .action-delete:hover {
        background: rgba(239, 68, 68, 0.3);
        transform: translateY(-2px);
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
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .modern-btn-outline {
        background: transparent;
        color: rgba(255, 255, 255, 0.8);
        border: 2px solid rgba(255, 255, 255, 0.2);
    }

    .modern-btn-outline:hover {
        background: rgba(255, 255, 255, 0.05);
        border-color: rgba(255, 255, 255, 0.3);
        color: #ffffff;
    }

    .modern-btn-secondary {
        background: rgba(0, 212, 255, 0.1);
        color: #00d4ff;
        border: 2px solid rgba(0, 212, 255, 0.3);
    }

    .modern-btn-secondary:hover {
        background: rgba(0, 212, 255, 0.2);
        border-color: #00d4ff;
    }

    @media (max-width: 768px) {
        .show-header-section {
            flex-direction: column;
            text-align: center;
        }

        .header-actions {
            flex-direction: column;
            width: 100%;
        }

        .content-grid {
            grid-template-columns: 1fr;
        }

        .info-row {
            flex-direction: column;
            align-items: flex-start;
            gap: 5px;
        }

        .image-actions {
            flex-direction: column;
            gap: 10px;
        }

        .action-buttons {
            flex-direction: column;
        }

        .action-btn {
            flex: none;
        }
    }
</style>

<script>
    function confirmDelete(campaignId, campaignTitle) {
        if (confirm(`Are you sure you want to delete the campaign "${campaignTitle}"? This action cannot be undone.`)) {
            document.getElementById('deleteForm' + campaignId).submit();
        }
    }
</script>
@endsection
