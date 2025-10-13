@extends('admin.layouts.masterlayout')

@section('content')
    <div class="content-area">
        <div class="form-container">
            <!-- Header Section -->
            <div class="form-header">
                <div class="form-title-group">
                    <div class="form-icon-wrapper">
                        <i class="fas fa-user-plus form-main-icon"></i>
                    </div>
                    <div class="form-title-text">
                        <h2 class="form-title">Add New Vendor</h2>
                        <p class="form-subtitle">Create a new vendor account with access to the platform</p>
                    </div>
                </div>
                <a href="{{ route('admin.vendors.index') }}" class="back-btn">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back to Vendors</span>
                </a>
            </div>

            <!-- Form Section -->
            <div class="form-card">
                <form action="{{ route('admin.vendors.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-grid">
                        <!-- Basic Information Section -->
                        <div class="form-section">
                            <div class="section-header">
                                <i class="fas fa-user"></i>
                                <h3>Basic Information</h3>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="name" class="form-label">
                                        <i class="fas fa-user"></i>
                                        Full Name <span class="required">*</span>
                                    </label>
                                    <input type="text" id="name" name="name" class="form-input"
                                           value="{{ old('name') }}" placeholder="Enter full name" required>
                                    @error('name')
                                        <div class="error-message">
                                            <i class="fas fa-exclamation-circle"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="email" class="form-label">
                                        <i class="fas fa-envelope"></i>
                                        Email Address <span class="required">*</span>
                                    </label>
                                    <input type="email" id="email" name="email" class="form-input"
                                           value="{{ old('email') }}" placeholder="Enter email address" required>
                                    @error('email')
                                        <div class="error-message">
                                            <i class="fas fa-exclamation-circle"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="password" class="form-label">
                                        <i class="fas fa-lock"></i>
                                        Password <span class="required">*</span>
                                    </label>
                                    <div class="password-input-wrapper">
                                        <input type="password" id="password" name="password" class="form-input"
                                               placeholder="Enter password" required>
                                        <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <div class="error-message">
                                            <i class="fas fa-exclamation-circle"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="password_confirmation" class="form-label">
                                        <i class="fas fa-lock"></i>
                                        Confirm Password <span class="required">*</span>
                                    </label>
                                    <div class="password-input-wrapper">
                                        <input type="password" id="password_confirmation" name="password_confirmation"
                                               class="form-input" placeholder="Confirm password" required>
                                        <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information Section -->
                        <div class="form-section">
                            <div class="section-header">
                                <i class="fas fa-address-book"></i>
                                <h3>Contact Information</h3>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="phone" class="form-label">
                                        <i class="fas fa-phone"></i>
                                        Phone Number
                                    </label>
                                    <input type="tel" id="phone" name="phone" class="form-input"
                                           value="{{ old('phone') }}" placeholder="Enter phone number">
                                    @error('phone')
                                        <div class="error-message">
                                            <i class="fas fa-exclamation-circle"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="image" class="form-label">
                                        <i class="fas fa-camera"></i>
                                        Profile Image
                                    </label>
                                    <div class="file-input-wrapper">
                                        <input type="file" id="image" name="image" class="file-input" accept="image/*" onchange="previewImage(event)">
                                        <div class="file-input-display">
                                            <i class="fas fa-upload"></i>
                                            <span>Choose image...</span>
                                        </div>
                                    </div>
                                    <div class="file-info">
                                        <small>Supported formats: JPEG, PNG, JPG. Max size: 3MB</small>
                                    </div>
                                    @error('image')
                                        <div class="error-message">
                                            <i class="fas fa-exclamation-circle"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group full-width">
                                    <label for="address" class="form-label">
                                        <i class="fas fa-map-marker-alt"></i>
                                        Address
                                    </label>
                                    <textarea id="address" name="address" class="form-textarea"
                                              placeholder="Enter complete address">{{ old('address') }}</textarea>
                                    @error('address')
                                        <div class="error-message">
                                            <i class="fas fa-exclamation-circle"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                            <!-- Image Preview -->
                        <div class="image-preview-section" id="imagePreview" style="display: none;">
                            <div class="preview-header">
                                <h4>Image Preview</h4>
                                <button type="button" class="remove-image-btn" onclick="removeImage()">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <div class="image-preview-container">
                                <img id="previewImg" src="" alt="Preview" class="preview-image">
                            </div>
                        </div>

                        <!-- Services Section -->
                        <div class="form-section">
                            <div class="section-header">
                                <i class="fas fa-tools"></i>
                                <h3>Services Offered</h3>
                            </div>

                            <div class="form-row">
                                <div class="form-group full-width">
                                    <label class="form-label">
                                        <i class="fas fa-check-square"></i>
                                        Select Services
                                    </label>
                                    <div class="services-grid">
                                        @if($services->count() > 0)
                                            @foreach($services as $service)
                                                <div class="service-item">
                                                    <input type="checkbox" name="services[]" value="{{ $service->id }}" id="service_{{ $service->id }}" class="service-checkbox"
                                                           {{ in_array($service->id, old('services', [])) ? 'checked' : '' }} onchange="toggleServicePayment({{ $service->id }})">
                                                    <label for="service_{{ $service->id }}" class="service-label">
                                                        <span class="service-icon"><i class="fas fa-wrench"></i></span>
                                                        <span class="service-name">{{ $service->name }}</span>
                                                    </label>
                                                </div>
                                            @endforeach
                                        @else
                                            <p class="no-services">No services available</p>
                                        @endif
                                    </div>
                                    @error('services')
                                        <div class="error-message">
                                            <i class="fas fa-exclamation-circle"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    @error('services.*')
                                        <div class="error-message">
                                            <i class="fas fa-exclamation-circle"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Service Payment Terms Section -->
                        <div class="form-section">
                            <div class="section-header">
                                <i class="fas fa-money-bill-wave"></i>
                                <h3>Service Payment Terms</h3>
                            </div>

                            <!-- Apply Same Payment Terms Option -->
                            <div class="form-row">
                                <div class="form-group full-width">
                                    <div class="checkbox-container">
                                        <input type="checkbox" id="apply_same_terms" name="apply_same_terms" value="1" onchange="togglePaymentModes(this)">
                                        <label for="apply_same_terms" class="checkbox-label">
                                            <span class="checkmark"></span>
                                            Apply same payment terms to all selected services
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Global Payment Terms (when applying same terms to all services) -->
                            <div id="global-payment-section" style="display: none;">
                                <div class="global-payment-header">
                                    <h4>All Selected Services</h4>
                                </div>
                                <div class="global-payment-fields">
                                    <div class="form-row">
                                        <div class="form-group">
                                            <label class="form-label">
                                                <i class="fas fa-cash-register"></i>
                                                Payment Type <span class="required">*</span>
                                            </label>
                                            <select id="global_payment_type" name="global_payment_type" class="modern-filter-select" onchange="toggleGlobalPaymentFields(this)">
                                                <option value="">Select Payment Type</option>
                                                <option value="fixed_rate">Fixed Rate</option>
                                                <option value="commission">Commission</option>
                                                <option value="revenue_share">Revenue Share</option>
                                            </select>
                                            @error('global_payment_type')
                                                <div class="error-message">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group" id="global_fixed_rate_container" style="display: none;">
                                            <label class="form-label">
                                                <i class="fas fa-dollar-sign"></i>
                                                Fixed Rate Amount
                                            </label>
                                            <input type="number" id="global_fixed_rate_amount" name="global_fixed_rate_amount" class="form-input" step="0.01" placeholder="Enter fixed rate amount" value="{{ old('global_fixed_rate_amount') }}">
                                            @error('global_fixed_rate_amount')
                                                <div class="error-message">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group" id="global_commission_container" style="display: none;">
                                            <label class="form-label">
                                                <i class="fas fa-percent"></i>
                                                Commission Rate (%)
                                            </label>
                                            <input type="number" id="global_commission_rate" name="global_commission_rate" class="form-input" step="0.01" min="0" max="100" placeholder="Enter commission rate" value="{{ old('global_commission_rate') }}">
                                            @error('global_commission_rate')
                                                <div class="error-message">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group" id="global_revenue_share_container" style="display: none;">
                                            <label class="form-label">
                                                <i class="fas fa-chart-pie"></i>
                                                Revenue Share Ratio
                                            </label>
                                            <input type="text" id="global_revenue_share_ratio" name="global_revenue_share_ratio" class="form-input" placeholder="e.g., 40:60" value="{{ old('global_revenue_share_ratio') }}">
                                            <div class="field-info">
                                                <small>Format: X:Y (e.g., 40:60 means 40% to vendor, 60% to platform)</small>
                                            </div>
                                            @error('global_revenue_share_ratio')
                                                <div class="error-message">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Individual Service Payment Terms -->
                            <div id="individual-payment-section">
                                @if($services->count() > 0)
                                    @foreach($services as $service)
                                        <div class="service-payment-item" id="payment-service-{{ $service->id }}" style="display: {{ in_array($service->id, old('services', [])) ? 'block' : 'none' }};">
                                            <div class="service-payment-header">
                                                <h4>{{ $service->name }}</h4>
                                            </div>
                                            <div class="service-payment-fields">
                                                <div class="form-row">
                                                    <div class="form-group">
                                                        <label class="form-label">
                                                            <i class="fas fa-cash-register"></i>
                                                            Payment Type <span class="required">*</span>
                                                        </label>
                                                        <select name="service_payment_type[]" class="modern-filter-select" onchange="togglePaymentFields(this)">
                                                            <option value="">Select Payment Type</option>
                                                            <option value="fixed_rate">Fixed Rate</option>
                                                            <option value="commission">Commission</option>
                                                            <option value="revenue_share">Revenue Share</option>
                                                        </select>
                                                        @error('service_payment_type.*')
                                                            <div class="error-message">
                                                                <i class="fas fa-exclamation-circle"></i>
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>

                                                    <div class="form-group fixed-rate-field" style="display: none;">
                                                        <label class="form-label">
                                                            <i class="fas fa-dollar-sign"></i>
                                                            Fixed Rate Amount
                                                        </label>
                                                        <input type="number" name="fixed_rate_amount[]" class="form-input" step="0.01" placeholder="Enter fixed rate amount">
                                                        @error('fixed_rate_amount.*')
                                                            <div class="error-message">
                                                                <i class="fas fa-exclamation-circle"></i>
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <div class="form-group commission-field" style="display: none;">
                                                        <label class="form-label">
                                                            <i class="fas fa-percent"></i>
                                                            Commission Rate (%)
                                                        </label>
                                                        <input type="number" name="commission_rate[]" class="form-input" step="0.01" min="0" max="100" placeholder="Enter commission rate">
                                                        @error('commission_rate.*')
                                                            <div class="error-message">
                                                                <i class="fas fa-exclamation-circle"></i>
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>

                                                    <div class="form-group revenue-share-field" style="display: none;">
                                                        <label class="form-label">
                                                            <i class="fas fa-chart-pie"></i>
                                                            Revenue Share Ratio
                                                        </label>
                                                        <input type="text" name="revenue_share_ratio[]" class="form-input" placeholder="e.g., 40:60">
                                                        <div class="field-info">
                                                            <small>Format: X:Y (e.g., 40:60 means 40% to vendor, 60% to platform)</small>
                                                        </div>
                                                        @error('revenue_share_ratio.*')
                                                            <div class="error-message">
                                                                <i class="fas fa-exclamation-circle"></i>
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>

                        <!-- Document Upload Section -->
                        <div class="form-section">
                            <div class="section-header">
                                <i class="fas fa-file-alt"></i>
                                <h3>Required Documents</h3>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="application_document" class="form-label">
                                        <i class="fas fa-file-signature"></i>
                                        Signed Application <span class="required">*</span>
                                    </label>
                                    <div class="file-input-wrapper">
                                        <input type="file" id="application_document" name="application_document" class="file-input" accept="application/pdf,image/*" required>
                                        <div class="file-input-display">
                                            <i class="fas fa-upload"></i>
                                            <span>Choose signed application...</span>
                                        </div>
                                    </div>
                                    <div class="file-info">
                                        <small>Supported formats: PDF, JPEG, PNG. Max size: 5MB</small>
                                    </div>
                                    @error('application_document')
                                        <div class="error-message">
                                            <i class="fas fa-exclamation-circle"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="trade_license_document" class="form-label">
                                        <i class="fas fa-file-contract"></i>
                                        Trade License (Valid) <span class="required">*</span>
                                    </label>
                                    <div class="file-input-wrapper">
                                        <input type="file" id="trade_license_document" name="trade_license_document" class="file-input" accept="application/pdf,image/*" required>
                                        <div class="file-input-display">
                                            <i class="fas fa-upload"></i>
                                            <span>Choose trade license...</span>
                                        </div>
                                    </div>
                                    <div class="file-info">
                                        <small>Supported formats: PDF, JPEG, PNG. Max size: 5MB</small>
                                    </div>
                                    @error('trade_license_document')
                                        <div class="error-message">
                                            <i class="fas fa-exclamation-circle"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="vat_certificate_document" class="form-label">
                                        <i class="fas fa-file-invoice-dollar"></i>
                                        VAT Certificate/Tax Certificate <span class="required">*</span>
                                    </label>
                                    <div class="file-input-wrapper">
                                        <input type="file" id="vat_certificate_document" name="vat_certificate_document" class="file-input" accept="application/pdf,image/*" required>
                                        <div class="file-input-display">
                                            <i class="fas fa-upload"></i>
                                            <span>Choose VAT certificate...</span>
                                        </div>
                                    </div>
                                    <div class="file-info">
                                        <small>Supported formats: PDF, JPEG, PNG. Max size: 5MB</small>
                                    </div>
                                    @error('vat_certificate_document')
                                        <div class="error-message">
                                            <i class="fas fa-exclamation-circle"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="staff_documents" class="form-label">
                                        <i class="fas fa-users"></i>
                                        Staff Documents (Police Clearance) <span class="required">*</span>
                                    </label>
                                    <div class="file-input-wrapper">
                                        <input type="file" id="staff_documents" name="staff_documents" class="file-input" accept="application/pdf,image/*" required>
                                        <div class="file-input-display">
                                            <i class="fas fa-upload"></i>
                                            <span>Choose staff documents...</span>
                                        </div>
                                    </div>
                                    <div class="file-info">
                                        <small>Supported formats: PDF, JPEG, PNG. Max size: 5MB</small>
                                    </div>
                                    @error('staff_documents')
                                        <div class="error-message">
                                            <i class="fas fa-exclamation-circle"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group full-width">
                                    <label for="contract_document" class="form-label">
                                        <i class="fas fa-file-contract"></i>
                                        Contract to be Signed <span class="required">*</span>
                                    </label>
                                    <div class="file-input-wrapper">
                                        <input type="file" id="contract_document" name="contract_document" class="file-input" accept="application/pdf,image/*" required>
                                        <div class="file-input-display">
                                            <i class="fas fa-upload"></i>
                                            <span>Choose contract document...</span>
                                        </div>
                                    <div class="file-info">
                                        <small>Supported formats: PDF, JPEG, PNG. Max size: 5MB</small>
                                    </div>
                                    @error('contract_document')
                                        <div class="error-message">
                                            <i class="fas fa-exclamation-circle"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        </div>

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <a href="{{ route('admin.vendors.index') }}" class="cancel-btn">
                            <i class="fas fa-times"></i>
                            <span>Cancel</span>
                        </a>
                        <button type="submit" class="submit-btn">
                            <i class="fas fa-save"></i>
                            <span>Create Vendor</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .modern-filter-input, .modern-filter-select {
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

    .modern-filter-input:focus, .modern-filter-select:focus {
        outline: none;
        border-color: #00d4ff;
        background: rgba(255, 255, 255, 0.08);
        box-shadow: 0 0 15px rgba(0, 212, 255, 0.2);
    }
        .form-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Header Styles */
        .form-header {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(15px);
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

        .back-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            text-decoration: none;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .back-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateX(-2px);
        }

        /* Form Card */
        .form-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(15px);
            border-radius: 0 0 20px 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-top: none;
            padding: 40px;
            overflow: hidden;
        }

        .form-grid {
            display: grid;
            gap: 40px;
        }

        .form-section {
            background: rgba(255, 255, 255, 0.03);
            border-radius: 15px;
            padding: 30px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .section-header i {
            color: #00d4ff;
            font-size: 20px;
        }

        .section-header h3 {
            color: #ffffff;
            font-size: 18px;
            font-weight: 600;
            margin: 0;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 25px;
        }

        .form-row:last-child {
            margin-bottom: 0;
        }

        .full-width {
            grid-column: 1 / -1;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-label {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #ffffff;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 8px;
        }

        .form-label i {
            color: #00d4ff;
            font-size: 12px;
        }

        .required {
            color: #ef4444;
        }

        .form-input, .form-textarea {
            padding: 14px 16px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            color: #ffffff;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-input:focus, .form-textarea:focus {
            outline: none;
            border-color: #00d4ff;
            box-shadow: 0 0 0 3px rgba(0, 212, 255, 0.1);
        }

        .form-input::placeholder, .form-textarea::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .form-textarea {
            resize: vertical;
            min-height: 100px;
        }

        .password-input-wrapper {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: rgba(255, 255, 255, 0.6);
            cursor: pointer;
            padding: 4px;
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        .password-toggle:hover {
            color: #00d4ff;
            background: rgba(255, 255, 255, 0.1);
        }

        .file-input-wrapper {
            position: relative;
        }

        .file-input {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .file-input-display {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 14px 16px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            color: rgba(255, 255, 255, 0.7);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .file-input-display:hover {
            border-color: #00d4ff;
            background: rgba(255, 255, 255, 0.05);
        }

        .file-info {
            margin-top: 6px;
        }

        .file-info small {
            color: rgba(255, 255, 255, 0.5);
            font-size: 12px;
        }

        .error-message {
            display: flex;
            align-items: center;
            gap: 6px;
            color: #ef4444;
            font-size: 12px;
            margin-top: 6px;
        }

        .error-message i {
            font-size: 10px;
        }

        /* Image Preview */
        .image-preview-section {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 20px;
        }

        .preview-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .preview-header h4 {
            color: #ffffff;
            font-size: 16px;
            margin: 0;
        }

        .remove-image-btn {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #ef4444;
            border-radius: 8px;
            padding: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .remove-image-btn:hover {
            background: rgba(239, 68, 68, 0.2);
        }

        .image-preview-container {
            display: flex;
            justify-content: center;
        }

        .preview-image {
            max-width: 200px;
            max-height: 200px;
            border-radius: 10px;
            border: 2px solid rgba(0, 212, 255, 0.3);
        }

        /* Form Actions */
        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 40px;
            padding-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .cancel-btn, .submit-btn {
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
        }

        .cancel-btn {
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .cancel-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        .submit-btn {
            background: linear-gradient(135deg, #00d4ff, #0099cc);
            color: white;
            box-shadow: 0 8px 25px rgba(0, 212, 255, 0.3);
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(0, 212, 255, 0.4);
        }

        /* Services Grid Styles */
        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 15px;
        }

        .service-item {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .service-checkbox {
            display: none;
        }

        .service-label {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 15px;
            background: rgba(255, 255, 255, 0.05);
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
        }

        .service-label:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(0, 212, 255, 0.3);
        }

        .service-checkbox:checked + .service-label {
            background: rgba(0, 212, 255, 0.1);
            border-color: #00d4ff;
        }

        .service-icon {
            color: #00d4ff;
            font-size: 16px;
        }

        .service-name {
            color: #ffffff;
            font-weight: 500;
        }

        .no-services {
            text-align: center;
            color: rgba(255, 255, 255, 0.6);
            font-style: italic;
            padding: 20px;
            margin: 0;
        }

        /* Service Payment Terms Styles */
        .service-payment-item {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .service-payment-item:last-child {
            margin-bottom: 0;
        }

        .service-payment-header h4 {
            color: #ffffff;
            font-size: 16px;
            font-weight: 600;
            margin: 0 0 15px 0;
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .service-payment-fields {
            display: grid;
            gap: 15px;
        }

        .fixed-rate-field, .commission-field, .revenue-share-field {
            opacity: 0;
            transform: scale(0.95);
            transition: all 0.3s ease;
        }

        .fixed-rate-field[style*="display: flex"],
        .commission-field[style*="display: flex"],
        .revenue-share-field[style*="display: flex"] {
            opacity: 1;
            transform: scale(1);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .form-container {
                padding: 10px;
            }

            .form-header {
                padding: 20px;
                flex-direction: column;
                align-items: flex-start;
            }

            .form-card {
                padding: 20px;
            }

            .form-row {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .form-section {
                padding: 20px;
            }

            .form-actions {
                flex-direction: column;
            }

            .cancel-btn, .submit-btn {
                width: 100%;
                justify-content: center;
            }

            .services-grid {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .service-label {
                padding: 10px 12px;
            }
        }
    </style>

    <script>
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const button = input.parentElement.querySelector('.password-toggle i');

            if (input.type === 'password') {
                input.type = 'text';
                button.classList.remove('fa-eye');
                button.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                button.classList.remove('fa-eye-slash');
                button.classList.add('fa-eye');
            }
        }

        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('previewImg').src = e.target.result;
                    document.getElementById('imagePreview').style.display = 'block';
                }
                reader.readAsDataURL(file);

                // Update file display
                const fileDisplay = event.target.parentElement.querySelector('.file-input-display span');
                fileDisplay.textContent = file.name;
            }
        }

        function removeImage() {
            document.getElementById('image').value = '';
            document.getElementById('imagePreview').style.display = 'none';
            document.querySelector('.file-input-display span').textContent = 'Choose image...';
        }

        // Password confirmation validation
        document.getElementById('password_confirmation').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmPassword = this.value;

            if (password !== confirmPassword) {
                this.setCustomValidity('Passwords do not match');
            } else {
                this.setCustomValidity('');
            }
        });
    </script>

    <script>
        // Toggle payment modes (global vs individual)
        function togglePaymentModes(checkbox) {
            const globalSection = document.getElementById('global-payment-section');
            const individualSection = document.getElementById('individual-payment-section');

            if (checkbox.checked) {
                globalSection.style.display = 'block';
                individualSection.style.display = 'none';
            } else {
                globalSection.style.display = 'none';
                individualSection.style.display = 'block';
            }
        }

        // Toggle global payment fields based on payment type
        function toggleGlobalPaymentFields(selectElement) {
            const paymentSection = document.getElementById('global-payment-section');
            const selectedValue = selectElement.value;

            // Hide all field containers
            paymentSection.querySelectorAll('.fixed-rate-field, .commission-field, .revenue-share-field').forEach(field => {
                field.style.display = 'none';
            });

            // Show the appropriate container based on selection
            if (selectedValue === 'fixed_rate') {
                paymentSection.querySelector('#global_fixed_rate_container').style.display = 'flex';
            } else if (selectedValue === 'commission') {
                paymentSection.querySelector('#global_commission_container').style.display = 'flex';
            } else if (selectedValue === 'revenue_share') {
                paymentSection.querySelector('#global_revenue_share_container').style.display = 'flex';
            }
        }

        // Toggle service payment sections
        function toggleServicePayment(serviceId) {
            const checkbox = document.getElementById('service_' + serviceId);
            const paymentSection = document.getElementById('payment-service-' + serviceId);

            if (checkbox.checked) {
                paymentSection.style.display = 'block';
            } else {
                paymentSection.style.display = 'none';
                // Reset payment fields when unchecked
                const selects = paymentSection.querySelectorAll('select');
                const inputs = paymentSection.querySelectorAll('input');
                selects.forEach(select => select.selectedIndex = 0);
                inputs.forEach(input => input.value = '');
                // Hide all payment field containers
                paymentSection.querySelectorAll('.fixed-rate-field, .commission-field, .revenue-share-field').forEach(field => {
                    field.style.display = 'none';
                });
            }
        }

        // Toggle payment fields based on payment type
        function togglePaymentFields(selectElement) {
            const paymentSection = selectElement.closest('.service-payment-item');
            const selectedValue = selectElement.value;

            // Hide all field containers
            paymentSection.querySelectorAll('.fixed-rate-field, .commission-field, .revenue-share-field').forEach(field => {
                field.style.display = 'none';
            });

            // Show the appropriate container based on selection
            if (selectedValue === 'fixed_rate') {
                paymentSection.querySelector('.fixed-rate-field').style.display = 'flex';
            } else if (selectedValue === 'commission') {
                paymentSection.querySelector('.commission-field').style.display = 'flex';
            } else if (selectedValue === 'revenue_share') {
                paymentSection.querySelector('.revenue-share-field').style.display = 'flex';
            }
        }
    </script>
@endsection
