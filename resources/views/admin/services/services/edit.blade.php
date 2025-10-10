@extends('admin.layouts.masterlayout')

@section('title', 'Edit Service: ' . $service->name)

@section('content')
    <div class="modern-form-container">
        <!-- Form Header Section -->
        <div class="form-header-section">
            <div class="header-content">
                <div class="header-icon-wrapper">
                    <i class="fas fa-cogs"></i>
                </div>
                <div class="header-text">
                    <h1 class="header-title">Edit Service</h1>
                    <p class="header-subtitle">Update service information and settings</p>
                </div>
            </div>

            <!-- Actions Bar -->
            <div class="header-actions">
                <a href="{{ route('services.services.index') }}" class="modern-btn modern-btn-outline">
                    <i class="fas fa-arrow-left"></i>
                    Back to Services
                </a>
                <a href="{{ route('services.services.show', $service) }}" class="modern-btn modern-btn-outline">
                    <i class="fas fa-eye"></i>
                    View Service
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

        <!-- Form Card -->
        <div class="modern-form-card">
            <form method="POST" action="{{ route('services.services.update', $service) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-grid">
                    <!-- Left Column -->
                    <div class="form-column">
                        <!-- Category Selection -->
                        <div class="form-group-modern">
                            <label for="category_id" class="modern-label">
                                <i class="fas fa-folder"></i>
                                Category
                                <span class="required-asterisk">*</span>
                            </label>
                            <div class="input-wrapper">
                                <select name="category_id" id="category_id" class="modern-select" required>
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}"
                                            {{ $service->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <i class="fas fa-folder input-icon"></i>
                            </div>
                            @error('category_id')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Subcategory Selection -->
                        <div class="form-group-modern">
                            <label for="subcategory_id" class="modern-label">
                                <i class="fas fa-folder-open"></i>
                                Subcategory
                                <span class="optional-text">(Optional)</span>
                            </label>
                            <div class="input-wrapper">
                                <select name="subcategory_id" id="subcategory_id" class="modern-select">
                                    <option value="">Select Subcategory (Optional)</option>
                                    @foreach ($subcategories as $sub)
                                        <option value="{{ $sub->id }}"
                                            {{ $service->subcategory_id == $sub->id ? 'selected' : '' }}>
                                            {{ $sub->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <i class="fas fa-folder-open input-icon"></i>
                            </div>
                            @error('subcategory_id')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Service Name -->
                        <div class="form-group-modern">
                            <label for="name" class="modern-label">
                                <i class="fas fa-cogs"></i>
                                Service Name
                                <span class="required-asterisk">*</span>
                            </label>
                            <div class="input-wrapper">
                                <input type="text" name="name" id="name"
                                    value="{{ old('name', $service->name) }}" class="modern-input"
                                    placeholder="Enter service name" required>
                                <i class="fas fa-cogs input-icon"></i>
                            </div>
                            @error('name')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="form-group-modern">
                            <label for="status" class="modern-label">
                                <i class="fas fa-toggle-on"></i>
                                Status
                                <span class="required-asterisk">*</span>
                            </label>
                            <div class="radio-group">
                                <div class="radio-option">
                                    <input type="radio" id="status_active" name="status" value="active"
                                        class="radio-input"
                                        {{ old('status', $service->status) == 'active' ? 'checked' : '' }} required>
                                    <label for="status_active" class="radio-label">Active</label>
                                </div>
                                <div class="radio-option">
                                    <input type="radio" id="status_inactive" name="status" value="inactive"
                                        class="radio-input"
                                        {{ old('status', $service->status) == 'inactive' ? 'checked' : '' }}>
                                    <label for="status_inactive" class="radio-label">Inactive</label>
                                </div>
                            </div>
                            @error('status')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="form-column">
                        <!-- QwikPick Toggle -->
                        <div class="form-group-modern">
                            <label class="modern-label">
                                <i class="fas fa-star"></i>
                                QwikPick Service
                            </label>
                            <div class="toggle-wrapper">
                                <input type="checkbox" id="qwikpick" name="qwikpick" value="1"
                                    {{ old('qwikpick', $service->qwikpick) ? 'checked' : '' }}>
                                <label for="qwikpick" class="toggle-label">
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                            <small class="form-hint">Mark as featured QwikPick service</small>
                        </div>

                        <!-- Beauty & Easy Toggle -->
                        <div class="form-group-modern">
                            <label class="modern-label">
                                <i class="fas fa-magic"></i>
                                Beauty & Easy
                            </label>
                            <div class="toggle-wrapper">
                                <input type="checkbox" id="beauty_and_easy" name="beauty_and_easy" value="1"
                                    {{ old('beauty_and_easy', $service->beauty_and_easy) ? 'checked' : '' }}>
                                <label for="beauty_and_easy" class="toggle-label">
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                            <small class="form-hint">Mark as beauty and easy service</small>
                        </div>

                        <!-- Arabic Service Toggle -->
                        <div class="form-group-modern">
                            <label class="modern-label">
                                <i class="fas fa-language"></i>
                                Arabic Service
                            </label>
                            <div class="toggle-wrapper">
                                <input type="checkbox" id="is_arabic" name="is_arabic" value="1"
                                    {{ old('is_arabic', $service->is_arabic) ? 'checked' : '' }}>
                                <label for="is_arabic" class="toggle-label">
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                            <small class="form-hint">Mark for Arabic language support</small>
                        </div>
                    </div>
                </div>

                <!-- Full Width Fields -->
                <div class="form-row-full">
                    <!-- Short Description -->
                    <div class="form-group-modern">
                        <label for="short_description" class="modern-label">
                            <i class="fas fa-file-alt"></i>
                            Short Description
                            <span class="optional-text">(Optional)</span>
                        </label>
                        <div class="input-wrapper">
                            <input type="text" name="short_description" id="short_description"
                                value="{{ old('short_description', $service->short_description) }}" class="modern-input"
                                placeholder="Brief description of the service">
                            <i class="fas fa-file-alt input-icon"></i>
                        </div>
                        @error('short_description')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Full Description -->
                    <div class="form-group-modern">
                        <label for="description" class="modern-label">
                            <i class="fas fa-align-left"></i>
                            Full Description
                            <span class="optional-text">(Optional)</span>
                        </label>
                        <div class="input-wrapper">
                            <textarea name="description" id="description" class="modern-textarea"
                                placeholder="Detailed description of the service">{{ old('description', $service->description) }}</textarea>
                            <i class="fas fa-align-left input-icon"></i>
                        </div>
                        @error('description')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- What's Included -->
                    <div class="form-group-modern">
                        <label for="whats_include" class="modern-label">
                            <i class="fas fa-list"></i>
                            What's Included
                            <span class="optional-text">(Optional)</span>
                        </label>
                        <div class="input-wrapper">
                            <textarea name="whats_include" id="whats_include" class="modern-textarea"
                                placeholder="List the included features or items">{{ is_array(old('whats_include', $service->whats_include)) ? implode("\n", old('whats_include', $service->whats_include)) : $service->whats_include }}</textarea>
                            <i class="fas fa-list input-icon"></i>
                        </div>
                        <small class="form-hint">Enter each item on a new line</small>
                        @error('whats_include')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Image Upload -->
                    <div class="form-group-modern">
                        <label for="image" class="modern-label">
                            <i class="fas fa-image"></i>
                            Service Image
                            <span class="optional-text">(Optional)</span>
                        </label>
                        <div class="file-upload-wrapper">
                            <input type="file" name="image" id="image" class="modern-file-input"
                                accept="image/*">
                            <label for="image" class="file-upload-label">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <span class="file-upload-text">Choose Image File</span>
                            </label>
                            @if ($service->image)
                                <div class="current-image-preview">
                                    <img src="{{ asset('Service_images/' . $service->image) }}"
                                        alt="Current Service Image" class="preview-image">
                                    <span class="current-image-label">Current Image</span>
                                </div>
                            @endif
                        </div>
                        @error('image')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <button type="submit" class="modern-btn modern-btn-primary">
                        <i class="fas fa-save"></i>
                        Update Service
                    </button>
                    <a href="{{ route('services.services.index') }}" class="modern-btn modern-btn-secondary">
                        <i class="fas fa-times"></i>
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <style>
        /* Modern Service Edit Form Styling */
        .modern-form-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Form Header Section */
        .form-header-section {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 20px 20px 0 0;
            padding: 30px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-bottom: none;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
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

        .modern-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease;
            color: rgba(255, 255, 255, 0.8);
        }

        .modern-btn:hover {
            background: rgba(255, 255, 255, 0.05);
            border-color: rgba(255, 255, 255, 0.3);
            color: #ffffff;
            transform: translateY(-2px);
        }

        /* Form Card */
        .modern-form-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(15px);
            border-radius: 0 0 20px 20px;
            padding: 40px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-top: none;
        }

        /* Form Grid - Two Column Layout */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }

        .form-column {
            display: flex;
            flex-direction: column;
            gap: 30px;
        }

        .form-row-full {
            margin-top: 40px;
            display: flex;
            flex-direction: column;
            gap: 30px;
        }

        .form-group-modern {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        /* Labels */
        .modern-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 600;
            color: #ffffff;
            margin-bottom: 8px;
        }

        .modern-label i {
            color: #00d4ff;
            width: 16px;
        }

        .required-asterisk {
            color: #ff4757;
            font-weight: 700;
        }

        .optional-text {
            color: rgba(255, 255, 255, 0.6);
            font-weight: 400;
            font-size: 12px;
        }

        /* Input Wrapper */
        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        /* Input Fields */
        .modern-input,
        .modern-select,
        .modern-textarea {
            width: 100%;
            padding: 16px 20px 16px 50px;
            background: rgba(255, 255, 255, 0.05);
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: #ffffff;
            font-size: 14px;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .modern-input:focus,
        .modern-select:focus,
        .modern-textarea:focus {
            outline: none;
            border-color: #00d4ff;
            background: rgba(255, 255, 255, 0.08);
            box-shadow: 0 0 20px rgba(0, 212, 255, 0.2);
            transform: translateY(-2px);
        }

        .modern-input::placeholder,
        .modern-textarea::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        /* Select Dropdown */
        .modern-select {
            appearance: none;
            cursor: pointer;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%23ffffff' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 20px center;
            background-repeat: no-repeat;
            background-size: 16px;
        }

        .modern-select option {
            background-color: #2d2d2d;
            color: #ffffff;
            padding: 10px 15px;
            border: none;
        }

        .modern-select option:hover,
        .modern-select option:focus,
        .modern-select option:checked {
            background-color: #404040;
            color: #00d4ff;
        }

        /* Textarea */
        .modern-textarea {
            resize: vertical;
            min-height: 120px;
            font-family: inherit;
            line-height: 1.5;
        }

        /* Input Icons */
        .input-icon {
            position: absolute;
            left: 16px;
            color: #00d4ff;
            font-size: 16px;
            pointer-events: none;
            z-index: 1;
        }

        /* Radio Group */
        .radio-group {
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
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .radio-input:checked+.radio-label {
            background: rgba(34, 197, 94, 0.2);
            color: #22c55e;
            border-color: rgba(34, 197, 94, 0.3);
        }

        /* Toggle Switches */
        .toggle-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .toggle-wrapper input[type="checkbox"] {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }

        .toggle-label {
            position: relative;
            display: block;
            width: 50px;
            height: 26px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 13px;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .toggle-slider {
            position: absolute;
            height: 18px;
            width: 18px;
            left: 3px;
            top: 3px;
            border-radius: 50%;
            background: #ffffff;
            transition: all 0.3s ease;
        }

        .toggle-wrapper input[type="checkbox"]:checked+.toggle-label {
            background: rgba(34, 197, 94, 0.3);
            border-color: rgba(34, 197, 94, 0.4);
        }

        .toggle-wrapper input[type="checkbox"]:checked+.toggle-label .toggle-slider {
            transform: translateX(24px);
            background: #22c55e;
        }

        /* Form Hints */
        .form-hint {
            color: rgba(255, 255, 255, 0.6);
            font-size: 12px;
            margin-top: 5px;
        }

        /* File Upload */
        .file-upload-wrapper {
            position: relative;
        }

        .modern-file-input {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .file-upload-label {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 20px;
            background: rgba(255, 255, 255, 0.05);
            border: 2px dashed rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            color: rgba(255, 255, 255, 0.7);
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            justify-content: center;
        }

        .file-upload-label:hover {
            border-color: #00d4ff;
            background: rgba(255, 255, 255, 0.08);
            color: #00d4ff;
        }

        .file-upload-label i {
            font-size: 24px;
            color: #00d4ff;
        }

        .current-image-preview {
            margin-top: 15px;
            text-align: center;
        }

        .preview-image {
            max-width: 150px;
            max-height: 150px;
            border-radius: 12px;
            border: 2px solid rgba(0, 212, 255, 0.3);
            object-fit: cover;
        }

        .current-image-label {
            display: block;
            margin-top: 8px;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.6);
        }

        /* Error Messages */
        .error-message {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #ff4757;
            font-size: 13px;
            margin-top: 8px;
            padding: 8px 12px;
            background: rgba(255, 71, 87, 0.1);
            border-radius: 8px;
            border-left: 3px solid #ff4757;
        }

        .error-message i {
            font-size: 14px;
        }

        /* Form Actions */
        .form-actions {
            display: flex;
            gap: 15px;
            justify-content: center;
            padding-top: 40px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: 50px;
        }

        /* Modern Buttons */
        .modern-btn-primary {
            background: linear-gradient(135deg, #00d4ff, #0099cc);
            color: white;
            box-shadow: 0 8px 25px rgba(0, 212, 255, 0.3);
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 14px 28px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease;
            min-width: 160px;
            justify-content: center;
        }

        .modern-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(0, 212, 255, 0.4);
            color: white;
        }

        .modern-btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            border: 2px solid rgba(255, 255, 255, 0.2);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 14px 28px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease;
            min-width: 120px;
            justify-content: center;
        }

        .modern-btn-secondary:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
            color: #ffffff;
        }

        /* Alerts */
        .alert {
            position: relative;
            padding: 15px 20px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 12px;
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

        .alert i {
            margin-right: 8px;
        }

        .btn-close {
            background: none;
            border: none;
            color: currentColor;
            opacity: 0.8;
            cursor: pointer;
            font-size: 18px;
            padding: 0;
            margin-left: auto;
        }

        .btn-close:hover {
            opacity: 1;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .modern-form-container {
                padding: 15px;
            }

            .form-header-section {
                flex-direction: column;
                text-align: center;
                padding: 20px;
            }

            .header-actions {
                flex-direction: column;
                width: 100%;
            }

            .modern-btn {
                width: 100%;
                margin-bottom: 10px;
            }

            .modern-form-card {
                padding: 20px;
            }

            .form-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .form-column {
                gap: 20px;
            }

            .form-row-full {
                margin-top: 20px;
                gap: 20px;
            }

            .form-actions {
                flex-direction: column;
                padding-top: 20px;
                margin-top: 20px;
            }

            .modern-btn-primary,
            .modern-btn-secondary {
                width: 100%;
                min-width: unset;
            }

            .radio-group {
                flex-direction: column;
                gap: 10px;
                align-items: flex-start;
            }

            .toggle-wrapper {
                justify-content: flex-start;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // File upload preview
            const fileInput = document.getElementById('image');
            const fileLabel = document.querySelector('.file-upload-text');

            if (fileInput) {
                fileInput.addEventListener('change', function(e) {
                    if (e.target.files.length > 0) {
                        fileLabel.textContent = e.target.files[0].name;
                    } else {
                        fileLabel.textContent = 'Choose Image File';
                    }
                });
            }

            // Dynamic subcategory loading based on category selection
            const categorySelect = document.getElementById('category_id');
            const subcategorySelect = document.getElementById('subcategory_id');

            if (categorySelect && subcategorySelect) {
                categorySelect.addEventListener('change', function() {
                    const categoryId = this.value;
                    if (categoryId) {
                        // Here you would typically make an AJAX request to get subcategories
                        // For now, we'll just show a loading state
                        subcategorySelect.innerHTML = '<option value="">Loading...</option>';
                    } else {
                        subcategorySelect.innerHTML =
                            '<option value="">Select Subcategory (Optional)</option>';
                    }
                });
            }

            // Form validation enhancement
            const form = document.querySelector('form');
            const inputs = form.querySelectorAll('.modern-input, .modern-select, .modern-textarea');

            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    if (this.hasAttribute('required') && !this.value.trim()) {
                        this.style.borderColor = '#ff4757';
                    } else {
                        this.style.borderColor = '';
                    }
                });

                input.addEventListener('input', function() {
                    if (this.style.borderColor === 'rgb(255, 71, 87)') {
                        this.style.borderColor = '';
                    }
                });
            });

            // Checkbox handling for toggle switches
            const checkboxes = form.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    // Ensure proper form submission
                    this.value = this.checked ? '1' : '0';
                });
            });
        });
    </script>
@endsection
