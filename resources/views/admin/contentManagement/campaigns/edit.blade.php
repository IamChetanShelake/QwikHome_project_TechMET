@extends('admin.layouts.masterlayout')

@section('title', 'Edit Campaign: ' . $campaign->title)

@section('content')
<div class="modern-edit-container">
    <!-- Header Section -->
    <div class="edit-header-section">
        <div class="header-content">
            <div class="header-icon-wrapper">
                <i class="fas fa-bullhorn"></i>
            </div>
            <div class="header-text">
                <h1 class="header-title">Edit Campaign</h1>
                <p class="header-subtitle">Update campaign details and settings</p>
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ route('contentManagement.campaigns.index') }}" class="modern-btn modern-btn-outline">
                <i class="fas fa-arrow-left"></i>
                Back to List
            </a>
            <a href="{{ route('contentManagement.campaigns.show', $campaign) }}" class="modern-btn modern-btn-outline">
                <i class="fas fa-eye"></i>
                View Campaign
            </a>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Form Container -->
    <div class="form-container">
        <form method="POST" action="{{ route('contentManagement.campaigns.update', $campaign) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-heading"></i>
                        Title
                    </label>
                    <input type="text" class="form-input" name="title" value="{{ old('title', $campaign->title) }}" placeholder="Enter campaign title">
                    @error('title')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-toggle-on"></i>
                        Status
                    </label>
                    <div class="status-radio-group">
                        <div class="radio-option">
                            <input type="radio" id="status_active" name="status" value="active"
                                class="radio-input" {{ old('status', $campaign->status) == 'active' ? 'checked' : '' }}>
                            <label for="status_active" class="radio-label">Active</label>
                        </div>
                        <div class="radio-option">
                            <input type="radio" id="status_inactive" name="status" value="inactive"
                                class="radio-input" {{ old('status', $campaign->status) == 'inactive' ? 'checked' : '' }}>
                            <label for="status_inactive" class="radio-label">Inactive</label>
                        </div>
                    </div>
                    @error('status')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group-full">
                    <label class="form-label">
                        <i class="fas fa-file-alt"></i>
                        Description
                    </label>
                    <textarea class="form-textarea" name="description" placeholder="Enter campaign description">{{ old('description', $campaign->description) }}</textarea>
                    @error('description')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group-full">
                    <label class="form-label">
                        <i class="fas fa-image"></i>
                        Image
                    </label>
                    <div class="current-image-section">
                        @if($campaign->image)
                            <div class="current-image">
                                <img src="{{ asset('campaign_images/' . $campaign->image) }}" alt="{{ $campaign->title }}" class="current-image-preview">
                                <div class="current-image-info">
                                    <span>Current image: {{ $campaign->image }}</span>
                                    <a href="{{ asset('campaign_images/' . $campaign->image) }}" target="_blank" class="image-link">View Full Size</a>
                                </div>
                            </div>
                        @else
                            <div class="no-image">
                                <i class="fas fa-image"></i>
                                <span>No image uploaded</span>
                            </div>
                        @endif
                    </div>

                    <div class="file-input-wrapper">
                        <input type="file" id="image" class="file-input" name="image" accept="image/*" onchange="updateFileName(this)">
                        <label for="image" class="file-input-label">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <span class="file-name file-placeholder">Choose new image to replace current one...</span>
                        </label>
                    </div>
                    <small class="form-hint">Supported formats: JPG, PNG, GIF. Max size: 2MB. Leave empty to keep current image.</small>
                    @error('image')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="form-actions">
                <button type="submit" class="modern-btn modern-btn-primary">
                    <i class="fas fa-save"></i>
                    Update Campaign
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .modern-edit-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .edit-header-section {
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
        gap: 10px;
    }

    .form-container {
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(15px);
        border-radius: 15px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        overflow: hidden;
        padding: 30px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin-bottom: 20px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .form-group-full {
        grid-column: 1 / -1;
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .form-label {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 14px;
        font-weight: 500;
        color: #ffffff;
    }

    .form-input,
    .form-textarea {
        padding: 12px 15px;
        background: rgba(255, 255, 255, 0.1);
        border: 2px solid rgba(255, 255, 255, 0.2);
        border-radius: 10px;
        color: #ffffff;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .form-input::placeholder,
    .form-textarea::placeholder {
        color: rgba(255, 255, 255, 0.6);
    }

    .form-input:focus,
    .form-textarea:focus {
        outline: none;
        border-color: #00d4ff;
        background: rgba(255, 255, 255, 0.15);
        box-shadow: 0 0 0 3px rgba(0, 212, 255, 0.1);
    }

    .form-textarea {
        resize: vertical;
        min-height: 100px;
    }

    .status-radio-group {
        display: flex;
        gap: 20px;
        align-items: center;
    }

    .radio-option {
        display: flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
    }

    .radio-input {
        display: none;
    }

    .radio-label {
        position: relative;
        padding: 8px 12px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 8px;
        transition: all 0.3s ease;
        color: rgba(255, 255, 255, 0.7);
    }

    .radio-input:checked + .radio-label {
        background: rgba(34, 197, 94, 0.2);
        color: #22c55e;
        border: 1px solid rgba(34, 197, 94, 0.3);
    }

    .current-image-section {
        margin-bottom: 15px;
    }

    .current-image {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 15px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 10px;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .current-image-preview {
        width: 80px;
        height: 60px;
        border-radius: 8px;
        object-fit: cover;
        border: 2px solid rgba(0, 212, 255, 0.3);
    }

    .current-image-info {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .current-image-info span {
        font-size: 14px;
        color: rgba(255, 255, 255, 0.8);
    }

    .image-link {
        font-size: 12px;
        color: #00d4ff;
        text-decoration: none;
    }

    .image-link:hover {
        text-decoration: underline;
    }

    .no-image {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 15px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 10px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: rgba(255, 255, 255, 0.6);
    }

    .no-image i {
        font-size: 24px;
    }

    .file-input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .file-input {
        display: none;
    }

    .file-input-label {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 12px 15px;
        background: rgba(0, 212, 255, 0.1);
        border: 2px dashed rgba(0, 212, 255, 0.3);
        border-radius: 10px;
        cursor: pointer;
        color: #00d4ff;
        transition: all 0.3s ease;
        flex: 1;
    }

    .file-input-label:hover {
        background: rgba(0, 212, 255, 0.15);
        border-color: #00d4ff;
    }

    .file-name {
        font-size: 14px;
        color: rgba(255, 255, 255, 0.9);
    }

    .file-placeholder {
        font-size: 14px;
        color: rgba(255, 255, 255, 0.6);
    }

    .form-hint {
        font-size: 12px;
        color: rgba(255, 255, 255, 0.6);
        margin-top: 5px;
    }

    .form-actions {
        display: flex;
        justify-content: center;
        padding-top: 30px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        margin-top: 30px;
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
        color: rgba(255, 255, 255, 0.8);
        border: 2px solid rgba(255, 255, 255, 0.2);
    }

    .modern-btn-outline:hover {
        background: rgba(255, 255, 255, 0.05);
        border-color: rgba(255, 255, 255, 0.3);
        color: #ffffff;
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

    .error-message {
        color: #ef4444;
        font-size: 12px;
        margin-top: 4px;
    }

    @media (max-width: 768px) {
        .edit-header-section {
            flex-direction: column;
            text-align: center;
        }

        .header-actions {
            flex-direction: column;
            width: 100%;
        }

        .form-row {
            grid-template-columns: 1fr;
        }

        .current-image {
            flex-direction: column;
            text-align: center;
        }
    }
</style>

<script>
    function updateFileName(input) {
        const fileName = input.files[0]?.name || 'Choose new image to replace current one...';
        const label = document.querySelector('.file-input-label .file-name');
        if (fileName !== 'Choose new image to replace current one...') {
            label.classList.remove('file-placeholder');
            label.innerHTML = `<i class="fas fa-check-circle" style="color: #22c55e;"></i> ${fileName}`;
        } else {
            label.classList.add('file-placeholder');
            label.innerHTML = fileName;
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
