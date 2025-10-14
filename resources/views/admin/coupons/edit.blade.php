@extends('admin.layouts.masterlayout')

@section('content')
    <div class="content-area">
        <div class="modern-form-container">
            <!-- Header Section -->
            <div class="form-header-section">
                <div class="form-header-content">
                    <div class="form-title-group">
                        <div class="form-icon-wrapper">
                            <i class="fas fa-edit form-main-icon"></i>
                        </div>
                        <div class="form-title-text">
                            <h2 class="form-title">Edit Coupon</h2>
                            <p class="form-subtitle">Update coupon details and discount settings</p>
                        </div>
                    </div>
                    <a href="{{ route('coupons.index') }}" class="modern-btn modern-btn-secondary">
                        <i class="fas fa-arrow-left"></i>
                        <span>Back to List</span>
                    </a>
                </div>
            </div>

            <!-- Form Section -->
            <div class="modern-form-card">
                <form method="POST" action="{{ route('coupons.update', $coupon->id) }}" class="modern-form"
                    id="couponEditForm">
                    @csrf
                    @method('PUT')

                    <!-- Form Grid -->
                    <div class="form-grid">
                        <!-- Coupon Code Field -->
                        <div class="form-group-modern">
                            <label for="code" class="modern-label">
                                <i class="fas fa-barcode label-icon"></i>
                                Coupon Code
                            </label>
                            <div class="input-wrapper">
                                <div class="input-icon">
                                    {{-- <i class="fas fa-hashtag"></i> --}}
                                </div>
                                <input type="text" class="modern-input @error('code') error @enderror" id="code"
                                    name="code" value="{{ old('code', $coupon->code) }}"
                                    placeholder="Enter unique coupon code (e.g. SUMMER2024)" required>
                                <div class="input-border"></div>
                            </div>
                            @error('code')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                            <div class="field-hint">
                                <i class="fas fa-info-circle"></i>
                                Create a memorable and unique coupon code
                            </div>
                        </div>



                        <!-- Discount Value Field -->
                        <div class="form-group-modern">
                            <label for="discount_value" class="modern-label">
                                <i class="fas fa-coins label-icon"></i>
                                Discount Value
                            </label>
                            <div class="input-wrapper">
                                <div class="input-icon">
                                    <i class="fas fa-calculator"></i>
                                </div>
                                <input type="number" step="0.01" min="0"
                                    class="modern-input @error('discount_value') error @enderror" id="discount_value"
                                    name="discount_value" value="{{ old('discount_value', $coupon->discount_value) }}"
                                    placeholder="0.00" required>
                                <div class="input-suffix" id="valueSuffix">%</div>
                                <div class="input-border"></div>
                            </div>
                            @error('discount_value')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                            <div class="field-hint">
                                <i class="fas fa-info-circle"></i>
                                <span id="valueHint">Enter percentage value (e.g., 10 for 10%)</span>
                            </div>
                        </div>

                        <!-- Expiry Date Field -->
                        <div class="form-group-modern">
                            <label for="expiry_date" class="modern-label">
                                <i class="fas fa-calendar-times label-icon"></i>
                                Expiry Date
                            </label>
                            <div class="input-wrapper">
                                <div class="input-icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <input type="datetime-local" class="modern-input @error('expiry_date') error @enderror"
                                    id="expiry_date" name="expiry_date"
                                    value="{{ old('expiry_date', $coupon->expiry_date->format('Y-m-d\TH:i')) }}" required>
                                <div class="input-border"></div>
                            </div>
                            @error('expiry_date')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                            <div class="field-hint">
                                <i class="fas fa-info-circle"></i>
                                Set when this coupon will expire
                            </div>
                        </div>

                        <!-- Usage Limit Field -->
                        <div class="form-group-modern">
                            <label for="usage_limit" class="modern-label">
                                <i class="fas fa-users label-icon"></i>
                                Usage Limit
                                <span class="optional-badge">Optional</span>
                            </label>
                            <div class="input-wrapper">
                                <div class="input-icon">
                                    <i class="fas fa-hashtag"></i>
                                </div>
                                <input type="number" min="1"
                                    class="modern-input @error('usage_limit') error @enderror" id="usage_limit"
                                    name="usage_limit" value="{{ old('usage_limit', $coupon->usage_limit) }}"
                                    placeholder="Leave empty for unlimited">
                                <div class="input-border"></div>
                            </div>
                            @error('usage_limit')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                            <div class="field-hint">
                                <i class="fas fa-info-circle"></i>
                                Maximum number of times this coupon can be used
                            </div>
                        </div>

                        <!-- Status Field -->
                        <div class="form-group-modern">
                            <label for="status" class="modern-label">
                                <i class="fas fa-toggle-on label-icon"></i>
                                Status
                            </label>
                            <div class="input-wrapper">
                                <div class="input-icon">
                                    <i class="fas fa-power-off"></i>
                                </div>
                                <select class="modern-select @error('status') error @enderror" id="status"
                                    name="status" required>
                                    <option value="1" {{ old('status', $coupon->status) == 1 ? 'selected' : '' }}>
                                        Active</option>
                                    <option value="0" {{ old('status', $coupon->status) == 0 ? 'selected' : '' }}>
                                        Inactive</option>
                                </select>
                                <div class="select-arrow">
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                                <div class="input-border"></div>
                            </div>
                            @error('status')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                            <div class="field-hint">
                                <i class="fas fa-info-circle"></i>
                                Set coupon availability status
                            </div>
                        </div>

                        <!-- Service Applicability Section -->
                        <div class="form-group-modern full-width">
                            <label class="modern-label">
                                <i class="fas fa-cogs label-icon"></i>
                                Service Applicability
                            </label>
                            <div class="service-selection-container">
                                <!-- Applicability Type -->
                                <div class="applicability-options">
                                    <div class="radio-group">
                                        <div class="radio-option">
                                            <input type="radio" id="all_services" name="applicable_to" value="all_services" 
                                                {{ old('applicable_to', $coupon->applicable_to ?? 'all_services') == 'all_services' ? 'checked' : '' }}>
                                            <label for="all_services" class="radio-label">
                                                <div class="radio-icon">
                                                    <i class="fas fa-globe"></i>
                                                </div>
                                                <div class="radio-content">
                                                    <div class="radio-title">All Services</div>
                                                    <div class="radio-desc">Apply to all available services</div>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="radio-option">
                                            <input type="radio" id="specific_services" name="applicable_to" value="specific_services"
                                                {{ old('applicable_to', $coupon->applicable_to ?? 'all_services') == 'specific_services' ? 'checked' : '' }}>
                                            <label for="specific_services" class="radio-label">
                                                <div class="radio-icon">
                                                    <i class="fas fa-list-check"></i>
                                                </div>
                                                <div class="radio-content">
                                                    <div class="radio-title">Specific Services</div>
                                                    <div class="radio-desc">Choose specific services</div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Service Selection (Hidden by default) -->
                                <div id="service-selection-panel" class="service-selection-panel" 
                                    style="display: {{ old('applicable_to', $coupon->applicable_to ?? 'all_services') == 'specific_services' ? 'block' : 'none' }};">
                                    <div class="selection-grid">
                                        <!-- Category Filter -->
                                        <div class="form-group-modern">
                                            <label for="category_filter" class="modern-label">
                                                <i class="fas fa-folder label-icon"></i>
                                                Filter by Category
                                            </label>
                                            <div class="input-wrapper">
                                                <div class="input-icon">
                                                    <i class="fas fa-filter"></i>
                                                </div>
                                                <select class="modern-select" id="category_filter" name="category_filter">
                                                    <option value="">All Categories</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}" 
                                                            {{ isset($defaultCategoryId) && $defaultCategoryId == $category->id ? 'selected' : '' }}>
                                                            {{ $category->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="select-arrow">
                                                    <i class="fas fa-chevron-down"></i>
                                                </div>
                                                <div class="input-border"></div>
                                            </div>
                                        </div>

                                        <!-- Subcategory Filter -->
                                        <div class="form-group-modern">
                                            <label for="subcategory_filter" class="modern-label">
                                                <i class="fas fa-folder-open label-icon"></i>
                                                Filter by Subcategory
                                            </label>
                                            <div class="input-wrapper">
                                                <div class="input-icon">
                                                    <i class="fas fa-filter"></i>
                                                </div>
                                                <select class="modern-select" id="subcategory_filter" name="subcategory_filter" 
                                                    {{ isset($defaultCategoryId) && $defaultCategoryId ? '' : 'disabled' }}>
                                                    <option value="">All Subcategories</option>
                                                    @if(isset($subcategories) && $subcategories->count() > 0)
                                                        @foreach ($subcategories as $subcategory)
                                                            <option value="{{ $subcategory->id }}"
                                                                {{ isset($defaultSubcategoryId) && $defaultSubcategoryId == $subcategory->id ? 'selected' : '' }}>
                                                                {{ $subcategory->name }}
                                                            </option>
                                                        @endforeach
                                                    @else
                                                        <option value="">No subcategories available</option>
                                                    @endif
                                                </select>
                                                <div class="select-arrow">
                                                    <i class="fas fa-chevron-down"></i>
                                                </div>
                                                <div class="input-border"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Services List -->
                                    <div class="services-container">
                                        <div class="services-header">
                                            <h4>Select Services</h4>
                                            <div class="bulk-actions">
                                                <button type="button" class="btn-link" id="select-all-services">Select All</button>
                                                <button type="button" class="btn-link" id="deselect-all-services">Deselect All</button>
                                            </div>
                                        </div>
                                        <div class="services-grid" id="services-grid">
                                            @foreach ($services as $service)
                                                <div class="service-item" data-category="{{ $service->category_id }}" data-subcategory="{{ $service->subcategory_id }}">
                                                    <input type="checkbox" id="service_{{ $service->id }}" name="service_ids[]" value="{{ $service->id }}" class="service-checkbox"
                                                        {{ in_array($service->id, old('service_ids', $selectedServiceIds ?? [])) ? 'checked' : '' }}>
                                                    <label for="service_{{ $service->id }}" class="service-label">
                                                        <div class="service-info">
                                                            <div class="service-name">{{ $service->name }}</div>
                                                            <div class="service-meta">{{ $service->category->name ?? 'No Category' }} > {{ $service->subcategory->name ?? 'No Subcategory' }}</div>
                                                        </div>
                                                        <div class="service-check">
                                                            <i class="fas fa-check"></i>
                                                        </div>
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @error('applicable_to')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                            @error('service_ids')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                            <div class="field-hint">
                                <i class="fas fa-info-circle"></i>
                                Choose whether this coupon applies to all services or specific ones
                            </div>
                        </div>

                        <!-- Description Field -->
                        <div class="form-group-modern full-width">
                            <label for="description" class="modern-label">
                                <i class="fas fa-align-left label-icon"></i>
                                Description
                                <span class="optional-badge">Optional</span>
                            </label>
                            <div class="input-wrapper">
                                <div class="input-icon textarea-icon">
                                    <i class="fas fa-edit"></i>
                                </div>
                                <textarea class="modern-textarea @error('description') error @enderror" id="description" name="description"
                                    rows="4"
                                    placeholder="Enter a brief description of this coupon (e.g., Summer sale discount for all products)">{{ old('description', $coupon->description) }}</textarea>
                                <div class="input-border"></div>
                            </div>
                            @error('description')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                            <div class="field-hint">
                                <i class="fas fa-info-circle"></i>
                                Provide additional details about this coupon
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <button type="button" class="modern-btn modern-btn-outline" onclick="resetForm()">
                            <i class="fas fa-undo"></i>
                            <span>Reset Changes</span>
                        </button>
                        <button type="submit" class="modern-btn modern-btn-primary" id="submitBtn">
                            <i class="fas fa-save"></i>
                            <span>Update Coupon</span>
                            <div class="btn-loader">
                                <div class="spinner"></div>
                            </div>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        /* Modern Form Styles */
        .modern-form-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .form-header-section {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 20px 20px 0 0;
            padding: 30px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-bottom: none;
        }

        .form-header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .form-title-group {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .form-icon-wrapper {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #00d4ff, #0099cc);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 25px rgba(0, 212, 255, 0.3);
        }

        .form-main-icon {
            font-size: 24px;
            color: white;
        }

        .form-title {
            font-size: 28px;
            font-weight: 700;
            color: #ffffff;
            margin: 0;
            background: linear-gradient(135deg, #ffffff, #00d4ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .form-subtitle {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.7);
            margin: 5px 0 0 0;
        }

        .modern-form-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(15px);
            border-radius: 0 0 20px 20px;
            padding: 40px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-top: none;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }

        .form-group-modern.full-width {
            grid-column: 1 / -1;
        }

        .modern-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 600;
            color: #ffffff;
            margin-bottom: 12px;
        }

        .label-icon {
            color: #00d4ff;
        }

        .optional-badge {
            background: rgba(255, 193, 7, 0.2);
            color: #ffc107;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 10px;
            font-weight: 500;
            margin-left: 8px;
        }

        .input-wrapper {
            position: relative;
        }

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

        .modern-textarea {
            resize: vertical;
            min-height: 100px;
            font-family: inherit;
        }

        .modern-select {
            appearance: none;
            cursor: pointer;
        }

        /* Dropdown option styling */
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

        .modern-input:focus,
        .modern-select:focus,
        .modern-textarea:focus {
            outline: none;
            border-color: #00d4ff;
            background: rgba(255, 255, 255, 0.08);
            box-shadow: 0 0 20px rgba(0, 212, 255, 0.2);
            transform: translateY(-2px);
        }

        .modern-input.error,
        .modern-select.error,
        .modern-textarea.error {
            border-color: #ff4757;
            box-shadow: 0 0 20px rgba(255, 71, 87, 0.2);
        }

        .modern-input::placeholder,
        .modern-textarea::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.6);
            font-size: 14px;
            z-index: 2;
        }

        .textarea-icon {
            top: 20px;
            transform: none;
        }

        .input-suffix {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #00d4ff;
            font-weight: 600;
            font-size: 12px;
        }

        .select-arrow {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.6);
            pointer-events: none;
            font-size: 12px;
        }

        .input-border {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #00d4ff, #0099cc);
            transition: width 0.3s ease;
        }

        .modern-input:focus+.input-border,
        .modern-select:focus+.select-arrow+.input-border,
        .modern-textarea:focus+.input-border {
            width: 100%;
        }

        .error-message {
            display: flex;
            align-items: center;
            gap: 6px;
            color: #ff4757;
            font-size: 12px;
            margin-top: 8px;
            animation: slideInUp 0.3s ease;
        }

        .field-hint {
            display: flex;
            align-items: center;
            gap: 6px;
            color: rgba(255, 255, 255, 0.5);
            font-size: 11px;
            margin-top: 6px;
        }

        .form-actions {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            flex-wrap: wrap;
        }

        .modern-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 14px 28px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .modern-btn-primary {
            background: linear-gradient(135deg, #00d4ff, #0099cc);
            color: white;
            box-shadow: 0 8px 25px rgba(0, 212, 255, 0.3);
        }

        .modern-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(0, 212, 255, 0.4);
        }

        .modern-btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .modern-btn-secondary:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-1px);
        }

        .modern-btn-outline {
            background: transparent;
            color: rgba(255, 255, 255, 0.8);
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        .modern-btn-outline:hover {
            background: rgba(255, 255, 255, 0.05);
            border-color: rgba(255, 255, 255, 0.3);
        }

        .btn-loader {
            display: none;
            margin-left: 8px;
        }

        .spinner {
            width: 16px;
            height: 16px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top: 2px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Service Selection Styles */
        .service-selection-container {
            background: rgba(255, 255, 255, 0.03);
            border-radius: 12px;
            padding: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .applicability-options {
            margin-bottom: 20px;
        }

        .radio-group {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
        }

        .radio-option {
            position: relative;
        }

        .radio-option input[type="radio"] {
            display: none;
        }

        .radio-label {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 16px;
            background: rgba(255, 255, 255, 0.05);
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .radio-label:hover {
            border-color: rgba(0, 212, 255, 0.3);
            background: rgba(255, 255, 255, 0.08);
        }

        .radio-option input[type="radio"]:checked + .radio-label {
            border-color: #00d4ff;
            background: rgba(0, 212, 255, 0.1);
        }

        .radio-icon {
            width: 40px;
            height: 40px;
            background: rgba(0, 212, 255, 0.2);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #00d4ff;
            font-size: 18px;
        }

        .radio-content {
            flex: 1;
        }

        .radio-title {
            color: #ffffff;
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 4px;
        }

        .radio-desc {
            color: rgba(255, 255, 255, 0.6);
            font-size: 12px;
        }

        .service-selection-panel {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .selection-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .services-container {
            background: rgba(255, 255, 255, 0.02);
            border-radius: 8px;
            padding: 16px;
        }

        .services-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .services-header h4 {
            color: #ffffff;
            margin: 0;
            font-size: 16px;
            font-weight: 600;
        }

        .bulk-actions {
            display: flex;
            gap: 12px;
        }

        .btn-link {
            background: none;
            border: none;
            color: #00d4ff;
            font-size: 12px;
            cursor: pointer;
            text-decoration: underline;
            transition: color 0.3s ease;
        }

        .btn-link:hover {
            color: #ffffff;
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 12px;
            max-height: 300px;
            overflow-y: auto;
            padding-right: 8px;
        }

        .services-grid::-webkit-scrollbar {
            width: 6px;
        }

        .services-grid::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 3px;
        }

        .services-grid::-webkit-scrollbar-thumb {
            background: rgba(0, 212, 255, 0.5);
            border-radius: 3px;
        }

        .service-item {
            position: relative;
        }

        .service-item input[type="checkbox"] {
            display: none;
        }

        .service-label {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .service-label:hover {
            border-color: rgba(0, 212, 255, 0.3);
            background: rgba(255, 255, 255, 0.08);
        }

        .service-item input[type="checkbox"]:checked + .service-label {
            border-color: #00d4ff;
            background: rgba(0, 212, 255, 0.1);
        }

        .service-info {
            flex: 1;
        }

        .service-name {
            color: #ffffff;
            font-weight: 500;
            font-size: 13px;
            margin-bottom: 4px;
        }

        .service-meta {
            color: rgba(255, 255, 255, 0.5);
            font-size: 11px;
        }

        .service-check {
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .service-item input[type="checkbox"]:checked + .service-label .service-check {
            background: #00d4ff;
            border-color: #00d4ff;
            color: #ffffff;
        }

        .service-check i {
            font-size: 12px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .service-item input[type="checkbox"]:checked + .service-label .service-check i {
            opacity: 1;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .modern-form-container {
                padding: 10px;
            }

            .form-header-section,
            .modern-form-card {
                padding: 20px;
            }

            .form-header-content {
                flex-direction: column;
                align-items: flex-start;
            }

            .form-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .form-actions {
                justify-content: stretch;
            }

            .modern-btn {
                flex: 1;
                justify-content: center;
            }

            .radio-group {
                grid-template-columns: 1fr;
            }

            .selection-grid {
                grid-template-columns: 1fr;
            }

            .services-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <script>
        // Form Enhancement Scripts
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('couponEditForm');
            const submitBtn = document.getElementById('submitBtn');
            const inputs = form.querySelectorAll('.modern-input, .modern-select, .modern-textarea');
            // Add input animations
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('focused');
                });

                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('focused');
                });

                // Auto-uppercase for code field
                if (input.name === 'code') {
                    input.addEventListener('input', function() {
                        this.value = this.value.toUpperCase();
                    });
                }
            });

            // Form submission with loading state
            form.addEventListener('submit', function() {
                submitBtn.disabled = true;
                submitBtn.querySelector('span').style.display = 'none';
                submitBtn.querySelector('.btn-loader').style.display = 'block';
            });

            // Service Selection Functionality
            const allServicesRadio = document.getElementById('all_services');
            const specificServicesRadio = document.getElementById('specific_services');
            const serviceSelectionPanel = document.getElementById('service-selection-panel');
            const categoryFilter = document.getElementById('category_filter');
            const subcategoryFilter = document.getElementById('subcategory_filter');
            const servicesGrid = document.getElementById('services-grid');
            const selectAllBtn = document.getElementById('select-all-services');
            const deselectAllBtn = document.getElementById('deselect-all-services');

            // Store initial values for edit form
            const initialCategoryId = "{{ $defaultCategoryId ?? '' }}";
            const initialSubcategoryId = "{{ $defaultSubcategoryId ?? '' }}";

            // Toggle service selection panel
            function toggleServiceSelection() {
                if (specificServicesRadio.checked) {
                    serviceSelectionPanel.style.display = 'block';
                } else {
                    serviceSelectionPanel.style.display = 'none';
                    // Uncheck all services when switching to "All Services"
                    document.querySelectorAll('.service-checkbox').forEach(checkbox => {
                        checkbox.checked = false;
                    });
                }
            }

            allServicesRadio.addEventListener('change', toggleServiceSelection);
            specificServicesRadio.addEventListener('change', toggleServiceSelection);

            // Category filter functionality
            categoryFilter.addEventListener('change', function() {
                const categoryId = this.value;
                
                // Only reset if user actually changed the category (not initial load)
                if (categoryId !== initialCategoryId) {
                    // Reset subcategory filter
                    subcategoryFilter.innerHTML = '<option value="">All Subcategories</option>';
                    subcategoryFilter.disabled = !categoryId;
                } else {
                    subcategoryFilter.disabled = !categoryId;
                }

                if (categoryId) {
                    // Show loading state only if not initial load
                    if (categoryId !== initialCategoryId) {
                        subcategoryFilter.innerHTML = '<option value="">Loading subcategories...</option>';
                    }
                    
                    // Fetch subcategories
                    fetch(`{{ url('/coupons/get-subcategories') }}/${categoryId}`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(`HTTP error! status: ${response.status}`);
                            }
                            return response.json();
                        })
                        .then(data => {
                            // Only rebuild dropdown if not initial load or if no subcategories exist
                            if (categoryId !== initialCategoryId || subcategoryFilter.children.length <= 1) {
                                subcategoryFilter.innerHTML = '<option value="">All Subcategories</option>';
                                if (data && data.length > 0) {
                                    data.forEach(subcategory => {
                                        const option = document.createElement('option');
                                        option.value = subcategory.id;
                                        option.textContent = subcategory.name;
                                        // Pre-select if this is the initial subcategory
                                        if (subcategory.id == initialSubcategoryId && categoryId === initialCategoryId) {
                                            option.selected = true;
                                        }
                                        subcategoryFilter.appendChild(option);
                                    });
                                } else {
                                    subcategoryFilter.innerHTML = '<option value="">No subcategories found</option>';
                                }
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching subcategories:', error);
                            subcategoryFilter.innerHTML = '<option value="">Error loading subcategories</option>';
                            alert('Failed to load subcategories. Please try again.');
                        });
                }

                filterServices();
            });

            // Subcategory filter functionality
            subcategoryFilter.addEventListener('change', filterServices);

            // Filter services based on category and subcategory
            function filterServices() {
                const categoryId = categoryFilter.value;
                const subcategoryId = subcategoryFilter.value;
                const serviceItems = document.querySelectorAll('.service-item');

                serviceItems.forEach(item => {
                    const itemCategory = item.dataset.category;
                    const itemSubcategory = item.dataset.subcategory;
                    
                    let show = true;
                    
                    if (categoryId && itemCategory !== categoryId) {
                        show = false;
                    }
                    
                    if (subcategoryId && itemSubcategory !== subcategoryId) {
                        show = false;
                    }
                    
                    item.style.display = show ? 'block' : 'none';
                });
            }

            // Select/Deselect all visible services
            selectAllBtn.addEventListener('click', function() {
                document.querySelectorAll('.service-item:not([style*="display: none"]) .service-checkbox').forEach(checkbox => {
                    checkbox.checked = true;
                });
            });

            deselectAllBtn.addEventListener('click', function() {
                document.querySelectorAll('.service-checkbox').forEach(checkbox => {
                    checkbox.checked = false;
                });
            });

            // Form validation for service selection
            form.addEventListener('submit', function(e) {
                if (specificServicesRadio.checked) {
                    const selectedServices = document.querySelectorAll('.service-checkbox:checked');
                    if (selectedServices.length === 0) {
                        e.preventDefault();
                        alert('Please select at least one service or choose "All Services" option.');
                        return false;
                    }
                }
            });

            // Initialize filters on page load if we have pre-selected values
            if (initialCategoryId) {
                // Trigger filtering to show only relevant services
                filterServices();
            }
        });

        function resetForm() {
            if (confirm('Are you sure you want to reset all changes? This will restore the original values.')) {
                location.reload();
            }
        }
    </script>
@endsection
