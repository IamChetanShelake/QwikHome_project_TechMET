@extends('admin.layouts.masterlayout')

@section('title', 'Create Banners')

@section('content')
    <style>
        .modern-create-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .create-header-section {
            background: #ffffff;
            border-radius: 20px;
            padding: 30px;
            border: 1px solid #e2e8f0;
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
            color: #1e293b;
            margin: 0;
        }

        .header-subtitle {
            font-size: 14px;
            color: #64748b;
            margin: 5px 0 0 0;
        }

        .form-container {
            background: #ffffff;
            border-radius: 15px;
            border: 1px solid #e2e8f0;
            overflow: hidden;
            padding: 30px;
        }

        .banner-entry {
            background: #f8fafc;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid #e2e8f0;
            position: relative;
        }

        .banner-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .banner-number {
            font-size: 18px;
            font-weight: 600;
            color: #00d4ff;
        }

        .remove-banner-btn {
            background: rgba(239, 68, 68, 0.2);
            color: #ef4444;
            border: none;
            border-radius: 8px;
            padding: 8px 12px;
            cursor: pointer;
            font-size: 12px;
            transition: all 0.3s ease;
        }

        .remove-banner-btn:hover {
            background: rgba(239, 68, 68, 0.3);
            transform: scale(1.05);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 15px;
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
            color: #334155;
        }

        .form-input,
        .form-textarea,
        .form-select {
            padding: 12px 15px;
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            color: #334155;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-input::placeholder,
        .form-textarea::placeholder {
            color: #94a3b8;
        }

        .form-input:focus,
        .form-textarea:focus,
        .form-select:focus {
            outline: none;
            border-color: #00d4ff;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(0, 212, 255, 0.1);
        }

        .form-textarea {
            resize: vertical;
            min-height: 80px;
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
            background: #dbeafe;
            border: 2px dashed #93c5fd;
            border-radius: 10px;
            cursor: pointer;
            color: #0284c7;
            transition: all 0.3s ease;
            flex: 1;
        }

        .file-input-label:hover {
            background: #bfdbfe;
            border-color: #3b82f6;
        }

        .file-name {
            font-size: 14px;
            color: #334155;
        }

        .file-placeholder {
            font-size: 14px;
            color: #94a3b8;
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
            background: #f1f5f9;
            border-radius: 8px;
            transition: all 0.3s ease;
            color: #64748b;
        }

        .radio-input:checked+.radio-label {
            background: rgba(34, 197, 94, 0.2);
            color: #22c55e;
            border: 1px solid rgba(34, 197, 94, 0.3);
        }

        .form-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
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

        .modern-btn-secondary {
            background: #dbeafe;
            color: #0284c7;
            border: 2px solid #93c5fd;
        }

        .modern-btn-secondary:hover {
            background: #bfdbfe;
            border-color: #3b82f6;
            color: #0284c7;
        }

        .modern-btn-outline {
            background: transparent;
            color: #475569;
            border: 2px solid #cbd5e1;
        }

        .modern-btn-outline:hover {
            background: #f1f5f9;
            border-color: #94a3b8;
            color: #1e293b;
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

        @media (max-width: 768px) {
            .create-header-section {
                flex-direction: column;
                text-align: center;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .form-actions {
                flex-direction: column;
                gap: 15px;
            }

            .banner-header {
                flex-direction: column;
                gap: 10px;
                align-items: flex-start;
            }
        }
    </style>

    <div class="modern-create-container">
        <!-- Header Section -->
        <div class="create-header-section">
            <div class="header-content">
                <div class="header-icon-wrapper">
                    <i class="fas fa-images"></i>
                </div>
                <div class="header-text">
                    <h1 class="header-title">Create Banners</h1>
                    <p class="header-subtitle">Add banner images and content for your website</p>
                </div>
            </div>
            <div class="header-actions">
                <a href="{{ route('contentManagement.banners.index') }}" class="modern-btn modern-btn-outline">
                    <i class="fas fa-arrow-left"></i>
                    Back to List
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

        <!-- Form Container -->
        <div class="form-container">
            <form id="bulkBannerForm" method="POST" action="{{ route('contentManagement.banners.store') }}"
                enctype="multipart/form-data">
                @csrf
                <div id="bannersContainer">
                    <!-- Dynamic banner entries will be added here -->
                </div>

                <!-- Action Buttons -->
                <div class="form-actions">
                    <button type="button" id="addBannerBtn" class="modern-btn modern-btn-secondary">
                        <i class="fas fa-plus"></i>
                        Add Another Banner
                    </button>
                    <button type="submit" class="modern-btn modern-btn-primary">
                        <i class="fas fa-save"></i>
                        Create Banners
                    </button>
                </div>
            </form>
        </div>
    </div>


    <script>
        let bannerCount = 0;

        function createBannerEntry(index) {
            const bannerHtml = `
            <div class="banner-entry" data-index="${index}">
                <div class="banner-header">
                    <div class="banner-number">Banner ${index + 1}</div>
                    ${index > 0 ? '<button type="button" class="remove-banner-btn" onclick="removeBanner(this)">Remove</button>' : ''}
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-heading"></i>
                            Title
                        </label>
                        <input type="text" class="form-input" name="titles[${index}]" placeholder="Enter banner title">
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-toggle-on"></i>
                            Status
                        </label>
                        <div class="status-radio-group">
                            <div class="radio-option">
                                <input type="radio" id="status_active_${index}" name="statuses[${index}]" value="active" class="radio-input" checked>
                                <label for="status_active_${index}" class="radio-label">Active</label>
                            </div>
                            <div class="radio-option">
                                <input type="radio" id="status_inactive_${index}" name="statuses[${index}]" value="inactive" class="radio-input">
                                <label for="status_inactive_${index}" class="radio-label">Inactive</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group-full">
                        <label class="form-label">
                            <i class="fas fa-file-alt"></i>
                            Description
                        </label>
                        <textarea class="form-textarea" name="descriptions[${index}]" placeholder="Enter banner description"></textarea>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group-full">
                        <label class="form-label">
                            <i class="fas fa-image"></i>
                            Image
                        </label>
                        <div class="file-input-wrapper">
                            <input type="file" id="image_${index}" class="file-input" name="images[]" accept="image/*" onchange="updateFileName(this, ${index})">
                            <label for="image_${index}" class="file-input-label">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <span class="file-name file-placeholder">Choose banner image...</span>
                            </label>
                        </div>
                        <small class="form-hint" style="color: #94a3b8; font-size: 12px; margin-top: 5px;">Supported formats: JPG, PNG, GIF. Max size: 2MB</small>
                    </div>
                </div>
            </div>
        `;
            return bannerHtml;
        }

        function updateFileName(input, index) {
            const fileName = input.files[0]?.name || 'Choose banner image...';
            const label = document.querySelector(`#image_${index}`).nextElementSibling.querySelector('.file-name');
            if (fileName !== 'Choose banner image...') {
                label.classList.remove('file-placeholder');
                label.innerHTML = `<i class="fas fa-check-circle" style="color: #22c55e;"></i> ${fileName}`;
            } else {
                label.classList.add('file-placeholder');
                label.innerHTML = fileName;
            }
        }

        function addBanner() {
            const container = document.getElementById('bannersContainer');
            const bannerHtml = createBannerEntry(bannerCount);
            container.insertAdjacentHTML('beforeend', bannerHtml);
            bannerCount++;
        }

        function removeBanner(button) {
            const bannerEntry = button.closest('.banner-entry');
            bannerEntry.remove();

            // Renumber remaining banners
            const banners = document.querySelectorAll('.banner-entry');
            banners.forEach((banner, index) => {
                const numberElement = banner.querySelector('.banner-number');
                numberElement.textContent = `Banner ${index + 1}`;

                // Update input names
                const inputs = banner.querySelectorAll('input, textarea, select');
                inputs.forEach(input => {
                    if (input.name.includes('[')) {
                        input.name = input.name.replace(/\[\d+\]/, `[${index}]`);
                    }
                    if (input.id.includes('_')) {
                        const parts = input.id.split('_');
                        const lastPart = parts[parts.length - 1];
                        input.id = input.id.replace(lastPart, index);
                    }
                });

                // Update labels
                const labels = banner.querySelectorAll('label[for]');
                labels.forEach(label => {
                    if (label.htmlFor.includes('_')) {
                        const parts = label.htmlFor.split('_');
                        const lastPart = parts[parts.length - 1];
                        label.htmlFor = label.htmlFor.replace(lastPart, index);
                    }
                });
            });

            bannerCount--;
        }

        function validateForm() {
            // No validation required since all fields are optional now
            return true;
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Add first banner by default
            addBanner();

            // Add banner button click
            document.getElementById('addBannerBtn').addEventListener('click', addBanner);

            // Form submission validation (removed since all fields are optional)
            document.getElementById('bulkBannerForm').addEventListener('submit', function(e) {
                // No validation required since all fields are optional
            });

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
        });
    </script>
@endsection
