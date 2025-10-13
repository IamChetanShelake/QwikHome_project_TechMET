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

                    <!-- What's Included (Full Width) -->
                    <div class="form-group-modern full-width">
                        <label class="modern-label">
                            <i class="fas fa-check-circle text-cyan"></i>
                            What's Included
                            <span class="optional-badge">Optional</span>
                        </label>
                        <div class="dynamic-list-container">
                            <div id="whats_include_container">
                                @if (old('whats_include'))
                                    @foreach (old('whats_include') as $index => $include)
                                        <div class="dynamic-item">
                                            <div class="input-wrapper">
                                                <input type="text" name="whats_include[]" value="{{ $include }}"
                                                    class="modern-input" placeholder="Enter what's included">
                                                <i class="fas fa-check input-icon"></i>
                                            </div>
                                            @if ($index > 0)
                                                <button type="button" class="modern-btn-remove remove-include">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            @endif
                                        </div>
                                    @endforeach
                                @elseif ($service->whats_include && is_array($service->whats_include) && count($service->whats_include) > 0)
                                    @foreach ($service->whats_include as $index => $include)
                                        <div class="dynamic-item">
                                            <div class="input-wrapper">
                                                <input type="text" name="whats_include[]" value="{{ $include }}"
                                                    class="modern-input" placeholder="Enter what's included">
                                                <i class="fas fa-check input-icon"></i>
                                            </div>
                                            @if ($index > 0)
                                                <button type="button" class="modern-btn-remove remove-include">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            @endif
                                        </div>
                                    @endforeach
                                @else
                                    <div class="dynamic-item">
                                        <div class="input-wrapper">
                                            <input type="text" name="whats_include[]" class="modern-input"
                                                placeholder="Enter what's included">
                                            <i class="fas fa-check input-icon"></i>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <button type="button" id="add_include" class="modern-btn modern-btn-outline">
                                <i class="fas fa-plus"></i>
                                Add Item
                            </button>
                        </div>
                        @error('whats_include')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="field-hint">
                            <i class="fas fa-info-circle"></i>
                            List what customers will receive with this service
                        </div>
                    </div>

                    <!-- Duration -->
                    <div class="form-group-modern">
                        <label for="duration" class="modern-label">
                            <i class="fas fa-clock text-cyan"></i>
                            Duration
                            <span class="optional-badge">Optional</span>
                        </label>
                        <div class="input-wrapper">
                            <input type="text" class="modern-input" name="duration" id="duration"
                                value="{{ old('duration', $service->duration) }}" placeholder="e.g., 2-3 hours">
                            <i class="fas fa-clock input-icon"></i>
                        </div>
                        @error('duration')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Image Upload -->
                    <div class="form-group-modern">
                        <label for="image" class="modern-label">
                            <i class="fas fa-image text-cyan"></i>
                            Service Image
                            <span class="optional-badge">Optional</span>
                        </label>
                        <div class="input-wrapper">
                            <input type="file" class="modern-input file-input" name="image" id="image" accept="image/*">
                            <i class="fas fa-image input-icon"></i>
                        </div>
                        @if ($service->image)
                            <div class="current-image-preview">
                                <img src="{{ asset('Service_images/' . $service->image) }}"
                                    alt="Current Service Image" class="preview-image">
                                <span class="current-image-label">Current Image</span>
                            </div>
                        @endif
                        @error('image')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Pricing & Subscription Options -->
                <div class="full-width-section">
                    <h3 class="section-title">
                        <i class="fas fa-money-bill text-cyan"></i>
                        Pricing & Subscription Options
                    </h3>

                    <!-- One Time Service Price -->
                    <div class="pricing-section">
                        <div class="pricing-header">
                            <h4 class="pricing-title">One Time Service Price</h4>
                            <span class="required-badge">Required</span>
                        </div>
                        <div class="pricing-content">
                            <div class="pricing-row">
                                <div class="form-group-modern pricing-input">
                                    <label class="modern-label">
                                        <i class="fas fa-money-bill text-cyan"></i>
                                        Price Amount
                                        <span class="required-badge">Required</span>
                                    </label>
                                    <div class="input-wrapper">
                                        <input type="number" class="modern-input" name="price_onetime"
                                            value="{{ old('price_onetime', $service->price_onetime) }}"
                                            step="0.01" min="0" placeholder="0.00" required>
                                        <span class="input-suffix">AED</span>
                                    </div>
                                    @error('price_onetime')
                                        <div class="error-message">
                                            <i class="fas fa-exclamation-circle"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group-modern pricing-description">
                                    <label class="modern-label">
                                        <i class="fas fa-align-left text-cyan"></i>
                                        Price Description
                                        <span class="optional-badge">Optional</span>
                                    </label>
                                    <div class="input-wrapper">
                                        <textarea class="modern-textarea" name="price_onetime_desc"
                                            placeholder="Describe what's included in this price">{{ old('price_onetime_desc', $service->price_onetime_desc) }}</textarea>
                                        <i class="fas fa-align-left input-icon"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Weekly Subscription -->
                    <div class="pricing-section">
                        <div class="pricing-header">
                            <h4 class="pricing-title">Weekly Subscription</h4>
                            <div class="checkbox-wrapper">
                                <input type="checkbox" class="modern-checkbox" id="enable_weekly" name="enable_weekly"
                                    {{ old('enable_weekly') || $service->price_weekly ? 'checked' : '' }}>
                                <label class="checkbox-text" for="enable_weekly">Enable weekly pricing</label>
                            </div>
                        </div>
                        <div class="pricing-content" id="weekly_pricing_inputs" 
                            style="display: {{ old('enable_weekly') || $service->price_weekly ? 'block' : 'none' }};">
                            <div class="pricing-row">
                                <div class="form-group-modern pricing-input">
                                    <label class="modern-label">
                                        <i class="fas fa-money-bill text-cyan"></i>
                                        Price Amount
                                        <span class="required-badge">Required</span>
                                    </label>
                                    <div class="input-wrapper">
                                        <input type="number" class="modern-input" name="price_weekly"
                                            value="{{ old('price_weekly', $service->price_weekly) }}"
                                            step="0.01" min="0" placeholder="0.00">
                                        <span class="input-suffix">AED</span>
                                    </div>
                                    @error('price_weekly')
                                        <div class="error-message">
                                            <i class="fas fa-exclamation-circle"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group-modern pricing-description">
                                    <label class="modern-label">
                                        <i class="fas fa-align-left text-cyan"></i>
                                        Price Description
                                        <span class="optional-badge">Optional</span>
                                    </label>
                                    <div class="input-wrapper">
                                        <textarea class="modern-textarea" name="price_weekly_desc"
                                            placeholder="Describe what's included in weekly subscription">{{ old('price_weekly_desc', $service->price_weekly_desc) }}</textarea>
                                        <i class="fas fa-align-left input-icon"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Monthly Subscription -->
                    <div class="pricing-section">
                        <div class="pricing-header">
                            <h4 class="pricing-title">Monthly Subscription</h4>
                            <div class="checkbox-wrapper">
                                <input type="checkbox" class="modern-checkbox" id="enable_monthly" name="enable_monthly"
                                    {{ old('enable_monthly') || $service->price_monthly ? 'checked' : '' }}>
                                <label class="checkbox-text" for="enable_monthly">Enable monthly pricing</label>
                            </div>
                        </div>
                        <div class="pricing-content" id="monthly_pricing_inputs"
                            style="display: {{ old('enable_monthly') || $service->price_monthly ? 'block' : 'none' }};">
                            <div class="pricing-row">
                                <div class="form-group-modern pricing-input">
                                    <label class="modern-label">
                                        <i class="fas fa-money-bill text-cyan"></i>
                                        Price Amount
                                        <span class="required-badge">Required</span>
                                    </label>
                                    <div class="input-wrapper">
                                        <input type="number" class="modern-input" name="price_monthly"
                                            value="{{ old('price_monthly', $service->price_monthly) }}"
                                            step="0.01" min="0" placeholder="0.00">
                                        <span class="input-suffix">AED</span>
                                    </div>
                                    @error('price_monthly')
                                        <div class="error-message">
                                            <i class="fas fa-exclamation-circle"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group-modern pricing-description">
                                    <label class="modern-label">
                                        <i class="fas fa-align-left text-cyan"></i>
                                        Price Description
                                        <span class="optional-badge">Optional</span>
                                    </label>
                                    <div class="input-wrapper">
                                        <textarea class="modern-textarea" name="price_monthly_desc"
                                            placeholder="Describe what's included in monthly subscription">{{ old('price_monthly_desc', $service->price_monthly_desc) }}</textarea>
                                        <i class="fas fa-align-left input-icon"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Yearly Subscription -->
                    <div class="pricing-section">
                        <div class="pricing-header">
                            <h4 class="pricing-title">Yearly Subscription</h4>
                            <div class="checkbox-wrapper">
                                <input type="checkbox" class="modern-checkbox" id="enable_yearly" name="enable_yearly"
                                    {{ old('enable_yearly') || $service->price_yearly ? 'checked' : '' }}>
                                <label class="checkbox-text" for="enable_yearly">Enable yearly pricing</label>
                            </div>
                        </div>
                        <div class="pricing-content" id="yearly_pricing_inputs"
                            style="display: {{ old('enable_yearly') || $service->price_yearly ? 'block' : 'none' }};">
                            <div class="pricing-row">
                                <div class="form-group-modern pricing-input">
                                    <label class="modern-label">
                                        <i class="fas fa-money-bill text-cyan"></i>
                                        Price Amount
                                        <span class="required-badge">Required</span>
                                    </label>
                                    <div class="input-wrapper">
                                        <input type="number" class="modern-input" name="price_yearly"
                                            value="{{ old('price_yearly', $service->price_yearly) }}"
                                            step="0.01" min="0" placeholder="0.00">
                                        <span class="input-suffix">AED</span>
                                    </div>
                                    @error('price_yearly')
                                        <div class="error-message">
                                            <i class="fas fa-exclamation-circle"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group-modern pricing-description">
                                    <label class="modern-label">
                                        <i class="fas fa-align-left text-cyan"></i>
                                        Price Description
                                        <span class="optional-badge">Optional</span>
                                    </label>
                                    <div class="input-wrapper">
                                        <textarea class="modern-textarea" name="price_yearly_desc"
                                            placeholder="Describe what's included in yearly subscription">{{ old('price_yearly_desc', $service->price_yearly_desc) }}</textarea>
                                        <i class="fas fa-align-left input-icon"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Requirements Section -->
                <div class="full-width-section">
                    <div class="requirements-section">
                        <h3 class="section-title">
                            <i class="fas fa-clipboard-list text-cyan"></i>
                            What We Need From You
                        </h3>

                        <div class="requirements-container">
                            <div id="requirements_container">
                                @if ($service->requirements && $service->requirements->count() > 0)
                                    @foreach ($service->requirements as $index => $requirement)
                                        <div class="requirement-item">
                                            <div class="requirement-header">
                                                <span class="requirement-title">Requirement {{ $index + 1 }}</span>
                                                @if ($index > 0)
                                                    <button type="button" class="modern-btn-remove remove-requirement">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                @endif
                                            </div>
                                            <div class="requirement-content">
                                                <div class="requirement-row">
                                                    <div class="form-group-modern requirement-title-field">
                                                        <label class="modern-label">
                                                            <i class="fas fa-edit text-cyan"></i>
                                                            Requirement Title
                                                            <span class="required-badge">Required</span>
                                                        </label>
                                                        <div class="input-wrapper">
                                                            <input type="text" class="modern-input"
                                                                name="requirements[{{ $index }}][title]"
                                                                value="{{ old('requirements.'.$index.'.title', $requirement->title) }}"
                                                                placeholder="Enter requirement title" required>
                                                            <i class="fas fa-edit input-icon"></i>
                                                        </div>
                                                    </div>

                                                    <div class="form-group-modern requirement-image-field">
                                                        <label class="modern-label">
                                                            <i class="fas fa-image text-cyan"></i>
                                                            Requirement Image
                                                            <span class="optional-badge">Optional</span>
                                                        </label>
                                                        <div class="input-wrapper">
                                                            <input type="file" class="modern-input file-input"
                                                                name="requirements[{{ $index }}][image]" accept="image/*">
                                                            <i class="fas fa-image input-icon"></i>
                                                        </div>
                                                        @if ($requirement->image)
                                                            <div class="current-image-preview">
                                                                <img src="{{ asset('Service_requirement_images/' . $requirement->image) }}" alt="Current Requirement Image" class="preview-image">
                                                                <span class="current-image-label">Current Image</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="requirement-item">
                                        <div class="requirement-header">
                                            <span class="requirement-title">Requirement 1</span>
                                        </div>
                                        <div class="requirement-content">
                                            <div class="requirement-row">
                                                <div class="form-group-modern requirement-title-field">
                                                    <label class="modern-label">
                                                        <i class="fas fa-edit text-cyan"></i>
                                                        Requirement Title
                                                        <span class="required-badge">Required</span>
                                                    </label>
                                                    <div class="input-wrapper">
                                                        <input type="text" class="modern-input"
                                                            name="requirements[0][title]"
                                                            placeholder="Enter requirement title" required>
                                                        <i class="fas fa-edit input-icon"></i>
                                                    </div>
                                                </div>

                                                <div class="form-group-modern requirement-image-field">
                                                    <label class="modern-label">
                                                        <i class="fas fa-image text-cyan"></i>
                                                        Requirement Image
                                                        <span class="optional-badge">Optional</span>
                                                    </label>
                                                    <div class="input-wrapper">
                                                        <input type="file" class="modern-input file-input"
                                                            name="requirements[0][image]" accept="image/*">
                                                        <i class="fas fa-image input-icon"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <button type="button" id="add_requirement" class="modern-btn modern-btn-outline"
                                style="margin-top: 20px;">
                                <i class="fas fa-plus"></i>
                                Add Another Requirement
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Our Processes Section -->
                <div class="full-width-section">
                    <div class="processes-section">
                        <h3 class="section-title">
                            <i class="fas fa-cogs text-cyan"></i>
                            Our Processes
                        </h3>

                        <div class="processes-container">
                            <div id="processes_container">
                                @if ($service->processes && $service->processes->count() > 0)
                                    @foreach ($service->processes as $index => $process)
                                        <div class="process-item">
                                            <div class="process-header">
                                                <span class="process-title">Step {{ $index + 1 }}</span>
                                                @if ($index > 0)
                                                    <button type="button" class="modern-btn-remove remove-process">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                @endif
                                            </div>
                                            <div class="process-content">
                                                <div class="process-row">
                                                    <div class="form-group-modern process-title-field">
                                                        <label class="modern-label">
                                                            <i class="fas fa-heading text-cyan"></i>
                                                            Step Title
                                                            <span class="required-badge">Required</span>
                                                        </label>
                                                        <div class="input-wrapper">
                                                            <input type="text" class="modern-input"
                                                                name="processes[{{ $index }}][title]"
                                                                value="{{ old('processes.'.$index.'.title', $process->title) }}"
                                                                placeholder="Enter step title" required>
                                                            <i class="fas fa-heading input-icon"></i>
                                                        </div>
                                                    </div>

                                                    <div class="form-group-modern process-image-field">
                                                        <label class="modern-label">
                                                            <i class="fas fa-image text-cyan"></i>
                                                            Step Image
                                                            <span class="optional-badge">Optional</span>
                                                        </label>
                                                        <div class="input-wrapper">
                                                            <input type="file" class="modern-input file-input"
                                                                name="processes[{{ $index }}][image]" accept="image/*">
                                                            <i class="fas fa-image input-icon"></i>
                                                        </div>
                                                        @if ($process->image)
                                                            <div class="current-image-preview">
                                                                <img src="{{ asset('Process_images/' . $process->image) }}" alt="Current Process Image" class="preview-image">
                                                                <span class="current-image-label">Current Image</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="process-description-row">
                                                    <div class="form-group-modern process-description-field">
                                                        <label class="modern-label">
                                                            <i class="fas fa-align-left text-cyan"></i>
                                                            Step Description
                                                            <span class="required-badge">Required</span>
                                                        </label>
                                                        <div class="input-wrapper">
                                                            <textarea class="modern-textarea"
                                                                name="processes[{{ $index }}][description]"
                                                                placeholder="Describe this step in detail" required>{{ old('processes.'.$index.'.description', $process->description) }}</textarea>
                                                            <i class="fas fa-align-left input-icon"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="process-item">
                                        <div class="process-header">
                                            <span class="process-title">Step 1</span>
                                        </div>
                                        <div class="process-content">
                                            <div class="process-row">
                                                <div class="form-group-modern process-title-field">
                                                    <label class="modern-label">
                                                        <i class="fas fa-heading text-cyan"></i>
                                                        Step Title
                                                        <span class="required-badge">Required</span>
                                                    </label>
                                                    <div class="input-wrapper">
                                                        <input type="text" class="modern-input"
                                                            name="processes[0][title]"
                                                            placeholder="Enter step title" required>
                                                        <i class="fas fa-heading input-icon"></i>
                                                    </div>
                                                </div>

                                                <div class="form-group-modern process-image-field">
                                                    <label class="modern-label">
                                                        <i class="fas fa-image text-cyan"></i>
                                                        Step Image
                                                        <span class="optional-badge">Optional</span>
                                                    </label>
                                                    <div class="input-wrapper">
                                                        <input type="file" class="modern-input file-input"
                                                            name="processes[0][image]" accept="image/*">
                                                        <i class="fas fa-image input-icon"></i>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="process-description-row">
                                                <div class="form-group-modern process-description-field">
                                                    <label class="modern-label">
                                                        <i class="fas fa-align-left text-cyan"></i>
                                                        Step Description
                                                        <span class="required-badge">Required</span>
                                                    </label>
                                                    <div class="input-wrapper">
                                                        <textarea class="modern-textarea"
                                                            name="processes[0][description]"
                                                            placeholder="Describe this step in detail" required></textarea>
                                                        <i class="fas fa-align-left input-icon"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <button type="button" id="add_process" class="modern-btn modern-btn-outline"
                                style="margin-top: 20px;">
                                <i class="fas fa-plus"></i>
                                Add Another Step
                            </button>
                        </div>
                    </div>

                    <!-- Add With Material Section -->
                    <div class="form-group-modern">
                        <h3 class="section-title">
                            <i class="fas fa-tools text-cyan"></i>
                            With Material Section
                        </h3>
                        
                        <div class="materials-container">
                            <div id="materials_container">
                                @if ($service->materials && $service->materials->count() > 0)
                                    @foreach ($service->materials as $index => $material)
                                        <div class="material-item">
                                            <div class="material-header">
                                                <span class="material-title">Material {{ $index + 1 }}</span>
                                                @if ($index > 0)
                                                    <button type="button" class="modern-btn-remove remove-material">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                @endif
                                            </div>
                                            <div class="material-content">
                                                <div class="material-row">
                                                    <div class="form-group-modern material-name">
                                                        <label class="modern-label">
                                                            <i class="fas fa-box text-cyan"></i>
                                                            Material Name
                                                            <span class="required-badge">Required</span>
                                                        </label>
                                                        <div class="input-wrapper">
                                                            <input type="text" class="modern-input"
                                                                name="materials[{{ $index }}][material_name]"
                                                                value="{{ old('materials.'.$index.'.material_name', $material->material_name) }}"
                                                                placeholder="Enter material name" required>
                                                            <i class="fas fa-box input-icon"></i>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group-modern material-description">
                                                        <label class="modern-label">
                                                            <i class="fas fa-align-left text-cyan"></i>
                                                            Material Description
                                                            <span class="optional-badge">Optional</span>
                                                        </label>
                                                        <div class="input-wrapper">
                                                            <textarea class="modern-textarea"
                                                                name="materials[{{ $index }}][material_description]"
                                                                placeholder="Describe the material">{{ old('materials.'.$index.'.material_description', $material->material_description) }}</textarea>
                                                            <i class="fas fa-align-left input-icon"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="material-row">
                                                    <div class="form-group-modern material-applicable">
                                                        <label class="modern-label">
                                                            <i class="fas fa-link text-cyan"></i>
                                                            Set for Which Price
                                                            <span class="required-badge">Required</span>
                                                        </label>
                                                        <div class="input-wrapper">
                                                            <select class="modern-select"
                                                                name="materials[{{ $index }}][applicable_to]" required>
                                                                <option value="">Select Pricing Option</option>
                                                                <option value="onetime" {{ old('materials.'.$index.'.applicable_to', $material->applicable_to) == 'onetime' ? 'selected' : '' }}>One Time Service</option>
                                                                <option value="weekly" {{ old('materials.'.$index.'.applicable_to', $material->applicable_to) == 'weekly' ? 'selected' : '' }}>Weekly Subscription</option>
                                                                <option value="monthly" {{ old('materials.'.$index.'.applicable_to', $material->applicable_to) == 'monthly' ? 'selected' : '' }}>Monthly Subscription</option>
                                                                <option value="yearly" {{ old('materials.'.$index.'.applicable_to', $material->applicable_to) == 'yearly' ? 'selected' : '' }}>Yearly Subscription</option>
                                                                <option value="all" {{ old('materials.'.$index.'.applicable_to', $material->applicable_to) == 'all' ? 'selected' : '' }}>All Service Subscriptions</option>
                                                            </select>
                                                            <i class="fas fa-link input-icon"></i>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group-modern material-price">
                                                        <label class="modern-label">
                                                            <i class="fas fa-money-bill text-cyan"></i>
                                                            Material Price
                                                            <span class="required-badge">Required</span>
                                                        </label>
                                                        <div class="input-wrapper">
                                                            <input type="number" class="modern-input"
                                                                name="materials[{{ $index }}][material_price]"
                                                                value="{{ old('materials.'.$index.'.material_price', $material->material_price) }}"
                                                                step="0.01" min="0" placeholder="0.00" required>
                                                            <span class="input-suffix">AED</span>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group-modern material-image">
                                                        <label class="modern-label">
                                                            <i class="fas fa-image text-cyan"></i>
                                                            Material Image
                                                            <span class="optional-badge">Optional</span>
                                                        </label>
                                                        @if ($material->material_image)
                                                            <div class="current-image-preview" style="margin-bottom: 10px;">
                                                                <img src="{{ asset('Material_images/' . $material->material_image) }}" 
                                                                    alt="{{ $material->material_name }}" 
                                                                    class="preview-image"
                                                                    onerror="this.style.display='none'; this.nextElementSibling.textContent='Image not found';">
                                                                <span class="current-image-label">Current: {{ $material->material_image }}</span>
                                                            </div>
                                                        @endif
                                                        <div class="input-wrapper">
                                                            <input type="file" class="modern-input file-input"
                                                                name="materials[{{ $index }}][material_image]"
                                                                accept="image/*">
                                                            <i class="fas fa-image input-icon"></i>
                                                        </div>
                                                        <small class="field-hint">
                                                            <i class="fas fa-info-circle"></i>
                                                            {{ $material->material_image ? 'Upload new image to replace current one' : 'Choose an image file' }}
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="material-item">
                                        <div class="material-header">
                                            <span class="material-title">Material 1</span>
                                        </div>
                                        <div class="material-content">
                                            <div class="material-row">
                                                <div class="form-group-modern material-name">
                                                    <label class="modern-label">
                                                        <i class="fas fa-box text-cyan"></i>
                                                        Material Name
                                                        <span class="required-badge">Required</span>
                                                    </label>
                                                    <div class="input-wrapper">
                                                        <input type="text" class="modern-input"
                                                            name="materials[0][material_name]"
                                                            placeholder="Enter material name" required>
                                                        <i class="fas fa-box input-icon"></i>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group-modern material-description">
                                                    <label class="modern-label">
                                                        <i class="fas fa-align-left text-cyan"></i>
                                                        Material Description
                                                        <span class="optional-badge">Optional</span>
                                                    </label>
                                                    <div class="input-wrapper">
                                                        <textarea class="modern-textarea"
                                                            name="materials[0][material_description]"
                                                            placeholder="Describe the material"></textarea>
                                                        <i class="fas fa-align-left input-icon"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="material-row">
                                                <div class="form-group-modern material-applicable">
                                                    <label class="modern-label">
                                                        <i class="fas fa-link text-cyan"></i>
                                                        Set for Which Price
                                                        <span class="required-badge">Required</span>
                                                    </label>
                                                    <div class="input-wrapper">
                                                        <select class="modern-select"
                                                            name="materials[0][applicable_to]" required>
                                                            <option value="">Select Pricing Option</option>
                                                            <option value="onetime">One Time Service</option>
                                                            <option value="weekly">Weekly Subscription</option>
                                                            <option value="monthly">Monthly Subscription</option>
                                                            <option value="yearly">Yearly Subscription</option>
                                                            <option value="all">All Service Subscriptions</option>
                                                        </select>
                                                        <i class="fas fa-link input-icon"></i>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group-modern material-price">
                                                    <label class="modern-label">
                                                        <i class="fas fa-money-bill text-cyan"></i>
                                                        Material Price
                                                        <span class="required-badge">Required</span>
                                                    </label>
                                                    <div class="input-wrapper">
                                                        <input type="number" class="modern-input"
                                                            name="materials[0][material_price]"
                                                            step="0.01" min="0" placeholder="0.00" required>
                                                        <span class="input-suffix">AED</span>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group-modern material-image">
                                                    <label class="modern-label">
                                                        <i class="fas fa-image text-cyan"></i>
                                                        Material Image
                                                        <span class="optional-badge">Optional</span>
                                                    </label>
                                                    <div class="input-wrapper">
                                                        <input type="file" class="modern-input file-input"
                                                            name="materials[0][material_image]"
                                                            accept="image/*">
                                                        <i class="fas fa-image input-icon"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            
                            <button type="button" id="add_material" class="modern-btn modern-btn-outline" style="margin-top: 20px;">
                                <i class="fas fa-plus"></i>
                                Add More With Material
                            </button>
                        </div>
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

        /* Materials Section Styling */
        .materials-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-top: 20px;
        }

        .material-item {
            background: rgba(0, 212, 255, 0.02);
            border: 2px solid rgba(0, 212, 255, 0.1);
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
            position: relative;
        }

        .material-item:hover {
            border-color: rgba(0, 212, 255, 0.3);
            background: rgba(0, 212, 255, 0.05);
            transform: translateY(-2px);
        }

        .material-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 20px;
            background: rgba(0, 212, 255, 0.08);
            border-bottom: 1px solid rgba(0, 212, 255, 0.15);
        }

        .material-title {
            font-weight: 600;
            color: #00d4ff;
            font-size: 14px;
        }

        .material-content {
            padding: 20px;
        }

        .material-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .material-row:last-child {
            margin-bottom: 0;
        }

        .material-name,
        .material-description {
            grid-column: 1 / -1;
        }

        .material-applicable,
        .material-price,
        .material-image {
            display: flex;
            flex-direction: column;
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: #ffffff;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title i {
            color: #00d4ff;
        }

        .modern-btn-remove {
            background: rgba(255, 71, 87, 0.1);
            border: 1px solid rgba(255, 71, 87, 0.3);
            color: #ff4757;
            padding: 8px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .modern-btn-remove:hover {
            background: rgba(255, 71, 87, 0.2);
            border-color: rgba(255, 71, 87, 0.5);
        }

        .modern-btn-outline {
            background: transparent;
            border: 2px solid rgba(0, 212, 255, 0.3);
            color: #00d4ff;
            padding: 12px 24px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .modern-btn-outline:hover {
            background: rgba(0, 212, 255, 0.1);
            border-color: rgba(0, 212, 255, 0.5);
            transform: translateY(-2px);
        }

        .required-badge {
            background: #ff4757;
            color: white;
            font-size: 10px;
            padding: 2px 6px;
            border-radius: 4px;
            margin-left: 8px;
            font-weight: 500;
        }

        .optional-badge {
            background: #ffc107;
            color: #000;
            font-size: 10px;
            padding: 2px 6px;
            border-radius: 4px;
            margin-left: 8px;
            font-weight: 500;
        }

        .input-suffix {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.6);
            font-size: 14px;
            font-weight: 500;
            pointer-events: none;
        }

        /* Dynamic Lists */
        .dynamic-list-container,
        .requirements-container,
        .processes-container {
            background: rgba(255, 255, 255, 0.03);
            border-radius: 12px;
            padding: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .dynamic-item {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
        }

        .dynamic-item:last-child {
            margin-bottom: 0;
        }

        .dynamic-item .input-wrapper {
            flex: 1;
        }

        .dynamic-item .modern-btn-remove {
            flex-shrink: 0;
        }

        .field-hint {
            display: flex;
            align-items: center;
            gap: 6px;
            color: rgba(255, 255, 255, 0.6);
            font-size: 11px;
            margin-top: 4px;
        }

        /* Responsive Materials Styling */
        @media (max-width: 1024px) {
            .material-row {
                grid-template-columns: 1fr;
            }
            
            .material-name,
            .material-description,
            .material-applicable,
            .material-price,
            .material-image {
                grid-column: 1;
            }
        }

        @media (max-width: 768px) {
            .material-content {
                padding: 15px;
            }

            .material-header {
                padding: 12px 15px;
                flex-direction: column;
                gap: 10px;
                align-items: flex-start;
            }
        }

        /* Full Width Sections */
        .full-width-section {
            margin-bottom: 40px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 15px;
            padding: 25px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Pricing Section Styling */
        .pricing-section {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            margin-bottom: 20px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .pricing-section:hover {
            border-color: rgba(0, 212, 255, 0.2);
            background: rgba(255, 255, 255, 0.05);
        }

        .pricing-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 20px;
            background: rgba(0, 212, 255, 0.05);
            border-bottom: 1px solid rgba(0, 212, 255, 0.1);
        }

        .pricing-title {
            font-weight: 600;
            color: #ffffff;
            font-size: 16px;
            margin: 0;
        }

        .pricing-content {
            padding: 20px;
        }

        .pricing-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        /* Requirements & Processes */
        .requirements-section,
        .processes-section {
            background: rgba(255, 255, 255, 0.03);
            border-radius: 15px;
            padding: 25px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .requirements-container,
        .processes-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .requirement-item,
        .process-item {
            background: rgba(0, 212, 255, 0.02);
            border: 2px solid rgba(0, 212, 255, 0.1);
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .requirement-item:hover,
        .process-item:hover {
            border-color: rgba(0, 212, 255, 0.3);
            background: rgba(0, 212, 255, 0.05);
            transform: translateY(-2px);
        }

        .requirement-header,
        .process-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 20px;
            background: rgba(0, 212, 255, 0.08);
            border-bottom: 1px solid rgba(0, 212, 255, 0.15);
        }

        .requirement-title,
        .process-title {
            font-weight: 600;
            color: #00d4ff;
            font-size: 14px;
        }

        .requirement-content,
        .process-content {
            padding: 20px;
        }

        .requirement-row,
        .process-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .process-description-row {
            margin-bottom: 0;
        }

        .requirement-row:last-child,
        .process-row:last-child,
        .process-description-row:last-child {
            margin-bottom: 0;
        }

        /* Current Image Preview */
        .current-image-preview {
            margin-top: 10px;
            padding: 10px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .preview-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 6px;
        }

        .current-image-label {
            color: rgba(255, 255, 255, 0.8);
            font-size: 12px;
        }

        /* Checkbox Styling */
        .checkbox-wrapper {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .modern-checkbox {
            width: 18px;
            height: 18px;
            accent-color: #00d4ff;
        }

        .checkbox-text {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.9);
            cursor: pointer;
        }

        /* Fix nice-select plugin conflicts */
        .nice-select {
            display: none !important;
        }
        
        .nice-select + .modern-select {
            display: none !important;
        }
        
        .modern-select {
            display: block !important;
            appearance: auto !important;
        }
        
        /* Hide nice-select dropdown lists */
        .nice-select .list {
            display: none !important;
        }
        
        /* Ensure original selects are visible */
        select.modern-select {
            display: block !important;
        }
        
        /* Responsive Design */
        @media (max-width: 1024px) {
            .pricing-row,
            .requirement-row,
            .process-row {
                grid-template-columns: 1fr;
            }
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
        // Prevent nice-select from initializing on admin pages
        if (typeof $.fn.niceSelect !== 'undefined') {
            $.fn.niceSelect = function() { return this; };
        }
        
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

            // Materials functionality
            let materialIndex = {{ $service->materials ? $service->materials->count() : 1 }};
            
            document.getElementById('add_material')?.addEventListener('click', function(e) {
                e.preventDefault();
                const container = document.getElementById('materials_container');
                const currentIndex = materialIndex++;
                const newMaterial = document.createElement('div');
                newMaterial.className = 'material-item';
                newMaterial.innerHTML = `
                    <div class="material-header">
                        <span class="material-title">Material ${currentIndex + 1}</span>
                        <button type="button" class="modern-btn-remove remove-material">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="material-content">
                        <div class="material-row">
                            <div class="form-group-modern material-name">
                                <label class="modern-label">
                                    <i class="fas fa-box text-cyan"></i>
                                    Material Name
                                    <span class="required-badge">Required</span>
                                </label>
                                <div class="input-wrapper">
                                    <input type="text" class="modern-input"
                                        name="materials[${currentIndex}][material_name]"
                                        placeholder="Enter material name" required>
                                    <i class="fas fa-box input-icon"></i>
                                </div>
                            </div>
                            
                            <div class="form-group-modern material-description">
                                <label class="modern-label">
                                    <i class="fas fa-align-left text-cyan"></i>
                                    Material Description
                                    <span class="optional-badge">Optional</span>
                                </label>
                                <div class="input-wrapper">
                                    <textarea class="modern-textarea"
                                        name="materials[${currentIndex}][material_description]"
                                        placeholder="Describe the material"></textarea>
                                    <i class="fas fa-align-left input-icon"></i>
                                </div>
                            </div>
                        </div>
                        
                        <div class="material-row">
                            <div class="form-group-modern material-applicable">
                                <label class="modern-label">
                                    <i class="fas fa-link text-cyan"></i>
                                    Set for Which Price
                                    <span class="required-badge">Required</span>
                                </label>
                                <div class="input-wrapper">
                                    <select class="modern-select"
                                        name="materials[${currentIndex}][applicable_to]" required>
                                        <option value="">Select Pricing Option</option>
                                        <option value="onetime">One Time Service</option>
                                        <option value="weekly">Weekly Subscription</option>
                                        <option value="monthly">Monthly Subscription</option>
                                        <option value="yearly">Yearly Subscription</option>
                                        <option value="all">All Service Subscriptions</option>
                                    </select>
                                    <i class="fas fa-link input-icon"></i>
                                </div>
                            </div>
                            
                            <div class="form-group-modern material-price">
                                <label class="modern-label">
                                    <i class="fas fa-money-bill text-cyan"></i>
                                    Material Price
                                    <span class="required-badge">Required</span>
                                </label>
                                <div class="input-wrapper">
                                    <input type="number" class="modern-input"
                                        name="materials[${currentIndex}][material_price]"
                                        step="0.01" min="0" placeholder="0.00" required>
                                    <span class="input-suffix">AED</span>
                                </div>
                            </div>
                            
                            <div class="form-group-modern material-image">
                                <label class="modern-label">
                                    <i class="fas fa-image text-cyan"></i>
                                    Material Image
                                    <span class="optional-badge">Optional</span>
                                </label>
                                <div class="input-wrapper">
                                    <input type="file" class="modern-input file-input"
                                        name="materials[${currentIndex}][material_image]"
                                        accept="image/*">
                                    <i class="fas fa-image input-icon"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                container.appendChild(newMaterial);
            });

            // Remove material functionality
            document.addEventListener('click', function(e) {
                if (e.target.closest('.remove-material')) {
                    e.preventDefault();
                    e.target.closest('.material-item').remove();
                }
            });

            // Pricing options visibility toggle
            function togglePricingInput(checkboxId, inputContainerId) {
                document.getElementById(checkboxId)?.addEventListener('change', function() {
                    const isChecked = this.checked;
                    const inputContainer = document.getElementById(inputContainerId);

                    if (inputContainer) {
                        if (isChecked) {
                            inputContainer.style.display = 'block';
                        } else {
                            inputContainer.style.display = 'none';
                            // Clear input values when hiding
                            const inputs = inputContainer.querySelectorAll('input[type="number"], textarea');
                            inputs.forEach(input => input.value = '');
                        }
                    }
                });
            }

            // Initialize pricing toggles
            togglePricingInput('enable_weekly', 'weekly_pricing_inputs');
            togglePricingInput('enable_monthly', 'monthly_pricing_inputs');
            togglePricingInput('enable_yearly', 'yearly_pricing_inputs');

            // Requirements functionality
            let requirementIndex = {{ $service->requirements ? $service->requirements->count() : 1 }};
            
            document.getElementById('add_requirement')?.addEventListener('click', function(e) {
                e.preventDefault();
                const container = document.getElementById('requirements_container');
                const currentIndex = requirementIndex++;
                const newRequirement = document.createElement('div');
                newRequirement.className = 'requirement-item';
                newRequirement.innerHTML = `
                    <div class="requirement-header">
                        <span class="requirement-title">Requirement ${currentIndex + 1}</span>
                        <button type="button" class="modern-btn-remove remove-requirement">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="requirement-content">
                        <div class="requirement-row">
                            <div class="form-group-modern requirement-title-field">
                                <label class="modern-label">
                                    <i class="fas fa-edit text-cyan"></i>
                                    Requirement Title
                                    <span class="required-badge">Required</span>
                                </label>
                                <div class="input-wrapper">
                                    <input type="text" class="modern-input"
                                        name="requirements[${currentIndex}][title]"
                                        placeholder="Enter requirement title" required>
                                    <i class="fas fa-edit input-icon"></i>
                                </div>
                            </div>

                            <div class="form-group-modern requirement-image-field">
                                <label class="modern-label">
                                    <i class="fas fa-image text-cyan"></i>
                                    Requirement Image
                                    <span class="optional-badge">Optional</span>
                                </label>
                                <div class="input-wrapper">
                                    <input type="file" class="modern-input file-input"
                                        name="requirements[${currentIndex}][image]" accept="image/*">
                                    <i class="fas fa-image input-icon"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                container.appendChild(newRequirement);
            });

            // Remove requirement functionality
            document.addEventListener('click', function(e) {
                if (e.target.closest('.remove-requirement')) {
                    e.preventDefault();
                    e.target.closest('.requirement-item').remove();
                }
            });

            // Processes functionality
            let processIndex = {{ $service->processes ? $service->processes->count() : 1 }};
            
            document.getElementById('add_process')?.addEventListener('click', function(e) {
                e.preventDefault();
                const container = document.getElementById('processes_container');
                const currentIndex = processIndex++;
                const newProcess = document.createElement('div');
                newProcess.className = 'process-item';
                newProcess.innerHTML = `
                    <div class="process-header">
                        <span class="process-title">Step ${currentIndex + 1}</span>
                        <button type="button" class="modern-btn-remove remove-process">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="process-content">
                        <div class="process-row">
                            <div class="form-group-modern process-title-field">
                                <label class="modern-label">
                                    <i class="fas fa-heading text-cyan"></i>
                                    Step Title
                                    <span class="required-badge">Required</span>
                                </label>
                                <div class="input-wrapper">
                                    <input type="text" class="modern-input"
                                        name="processes[${currentIndex}][title]"
                                        placeholder="Enter step title" required>
                                    <i class="fas fa-heading input-icon"></i>
                                </div>
                            </div>

                            <div class="form-group-modern process-image-field">
                                <label class="modern-label">
                                    <i class="fas fa-image text-cyan"></i>
                                    Step Image
                                    <span class="optional-badge">Optional</span>
                                </label>
                                <div class="input-wrapper">
                                    <input type="file" class="modern-input file-input"
                                        name="processes[${currentIndex}][image]" accept="image/*">
                                    <i class="fas fa-image input-icon"></i>
                                </div>
                            </div>
                        </div>

                        <div class="process-description-row">
                            <div class="form-group-modern process-description-field">
                                <label class="modern-label">
                                    <i class="fas fa-align-left text-cyan"></i>
                                    Step Description
                                    <span class="required-badge">Required</span>
                                </label>
                                <div class="input-wrapper">
                                    <textarea class="modern-textarea"
                                        name="processes[${currentIndex}][description]"
                                        placeholder="Describe this step in detail" required></textarea>
                                    <i class="fas fa-align-left input-icon"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                container.appendChild(newProcess);
            });

            // Remove process functionality
            document.addEventListener('click', function(e) {
                if (e.target.closest('.remove-process')) {
                    e.preventDefault();
                    e.target.closest('.process-item').remove();
                }
            });

            // What's Included functionality
            document.getElementById('add_include')?.addEventListener('click', function(e) {
                e.preventDefault();
                const container = document.getElementById('whats_include_container');
                const newItem = document.createElement('div');
                newItem.className = 'dynamic-item';
                newItem.innerHTML = `
                    <div class="input-wrapper">
                        <input type="text" name="whats_include[]" class="modern-input" placeholder="Enter what's included">
                        <i class="fas fa-check input-icon"></i>
                    </div>
                    <button type="button" class="modern-btn-remove remove-include">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                container.appendChild(newItem);
            });

            // Remove include functionality
            document.addEventListener('click', function(e) {
                if (e.target.closest('.remove-include')) {
                    e.preventDefault();
                    const item = e.target.closest('.dynamic-item');
                    const container = document.getElementById('whats_include_container');
                    // Only remove if there's more than one item
                    if (container.querySelectorAll('.dynamic-item').length > 1) {
                        item.remove();
                    }
                }
            });
        });
    </script>
@endsection
