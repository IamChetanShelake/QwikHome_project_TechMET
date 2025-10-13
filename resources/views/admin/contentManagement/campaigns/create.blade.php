@extends('admin.layouts.masterlayout')


@section('content')
    <style>
        .modern-create-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .create-header-section {
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

        .form-container {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(15px);
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            overflow: hidden;
            padding: 30px;
        }

        .campaign-entry {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
        }

        .campaign-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .campaign-number {
            font-size: 18px;
            font-weight: 600;
            color: #00d4ff;
        }

        .remove-campaign-btn {
            background: rgba(239, 68, 68, 0.2);
            color: #ef4444;
            border: none;
            border-radius: 8px;
            padding: 8px 12px;
            cursor: pointer;
            font-size: 12px;
            transition: all 0.3s ease;
        }

        .remove-campaign-btn:hover {
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
            color: #ffffff;
        }

        .form-input,
        .form-textarea,
        .form-select {
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
        .form-textarea:focus,
        .form-select:focus {
            outline: none;
            border-color: #00d4ff;
            background: rgba(255, 255, 255, 0.15);
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
            border-top: 1px solid rgba(255, 255, 255, 0.1);
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
            background: rgba(0, 212, 255, 0.1);
            color: #00d4ff;
            border: 2px solid rgba(0, 212, 255, 0.3);
        }

        .modern-btn-secondary:hover {
            background: rgba(0, 212, 255, 0.2);
            border-color: #00d4ff;
            color: #00d4ff;
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

            .campaign-header {
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
                    <i class="fas fa-bullhorn"></i>
                </div>
                <div class="header-text">
                    <h1 class="header-title">Create Campaigns</h1>
                    <p class="header-subtitle">Add marketing campaigns and promotional activities</p>
                </div>
            </div>
            <div class="header-actions">
                <a href="{{ route('contentManagement.campaigns.index') }}" class="modern-btn modern-btn-outline">
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
            <form id="bulkCampaignForm" method="POST" action="{{ route('contentManagement.campaigns.store') }}"
                enctype="multipart/form-data">
                @csrf
                <div id="campaignsContainer">
                </div>

                <!-- Action Buttons -->
                <div class="form-actions">
                    <button type="button" id="addCampaignBtn" class="modern-btn modern-btn-secondary">
                        <i class="fas fa-plus"></i>
                        Add Another Campaign
                    </button>
                    <button type="submit" class="modern-btn modern-btn-primary">
                        <i class="fas fa-save"></i>
                        Create Campaigns
                    </button>
                </div>
            </form>
        </div>
    </div>


    <script>
        let campaignCount = 0;

        function createCampaignEntry(index) {
            const campaignHtml = `
            <div class="campaign-entry" data-index="${index}">
                <div class="campaign-header">
                    <div class="campaign-number">Campaign ${index + 1}</div>
                    ${index > 0 ? '<button type="button" class="remove-campaign-btn" onclick="removeCampaign(this)">Remove</button>' : ''}
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-heading"></i>
                            Title
                        </label>
                        <input type="text" class="form-input" name="titles[${index}]" placeholder="Enter campaign title">
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
                        <textarea class="form-textarea" name="descriptions[${index}]" placeholder="Enter campaign description"></textarea>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group-full">
                        <label class="form-label">
                            <i class="fas fa-image"></i>
                            Image
                        </label>
                        <div class="file-input-wrapper">
                            <input type="file" id="image_${index}" class="file-input" name="images[${index}]" accept="image/*" onchange="updateFileName(this, ${index})">
                            <label for="image_${index}" class="file-input-label">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <span class="file-name file-placeholder">Choose campaign image...</span>
                            </label>
                        </div>
                        <small class="form-hint" style="color: rgba(255,255,255,0.6); font-size: 12px; margin-top: 5px;">Supported formats: JPG, PNG, GIF. Max size: 2MB</small>
                    </div>
                </div>
            </div>
        `;
            return campaignHtml;
        }

        function updateFileName(input, index) {
            const fileName = input.files[0]?.name || 'Choose campaign image...';
            const label = document.querySelector(`#image_${index}`).nextElementSibling.querySelector('.file-name');
            if (fileName !== 'Choose campaign image...') {
                label.classList.remove('file-placeholder');
                label.innerHTML = `<i class="fas fa-check-circle" style="color: #22c55e;"></i> ${fileName}`;
            } else {
                label.classList.add('file-placeholder');
                label.innerHTML = fileName;
            }
        }

        function addCampaign() {
            const container = document.getElementById('campaignsContainer');
            const campaignHtml = createCampaignEntry(campaignCount);
            container.insertAdjacentHTML('beforeend', campaignHtml);
            campaignCount++;
        }

        function removeCampaign(button) {
            const campaignEntry = button.closest('.campaign-entry');
            campaignEntry.remove();

            // Renumber remaining campaigns
            const campaigns = document.querySelectorAll('.campaign-entry');
            campaigns.forEach((campaign, index) => {
                const numberElement = campaign.querySelector('.campaign-number');
                numberElement.textContent = `Campaign ${index + 1}`;

                // Update input names
                const inputs = campaign.querySelectorAll('input, textarea, select');
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
                const labels = campaign.querySelectorAll('label[for]');
                labels.forEach(label => {
                    if (label.htmlFor.includes('_')) {
                        const parts = label.htmlFor.split('_');
                        const lastPart = parts[parts.length - 1];
                        label.htmlFor = label.htmlFor.replace(lastPart, index);
                    }
                });
            });

            campaignCount--;
        }

        function validateForm() {
            // No validation required since all fields are optional now
            return true;
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Add first campaign by default
            addCampaign();

            // Add campaign button click
            document.getElementById('addCampaignBtn').addEventListener('click', addCampaign);

            // Form submission validation (removed since all fields are optional)
            document.getElementById('bulkCampaignForm').addEventListener('submit', function(e) {
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
