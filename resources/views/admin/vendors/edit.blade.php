@extends('admin.layouts.masterlayout')

@section('content')
    <div class="content-area">
        <div class="form-container">
            <!-- Header Section -->
            <div class="form-header">
                <div class="form-title-group">
                    <div class="form-icon-wrapper">
                        <i class="fas fa-user-edit form-main-icon"></i>
                    </div>
                    <div class="form-title-text">
                        <h2 class="form-title">Edit Vendor</h2>
                        <p class="form-subtitle">Update vendor account information and settings</p>
                    </div>
                </div>
                <a href="{{ route('admin.vendors.index') }}" class="back-btn">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back to Vendors</span>
                </a>
            </div>

            <!-- Form Section -->
            <div class="form-card">
                <form action="{{ route('admin.vendors.update', $vendor->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

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
                                           value="{{ old('name', $vendor->name) }}" placeholder="Enter full name" required>
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
                                           value="{{ old('email', $vendor->email) }}" placeholder="Enter email address" required>
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
                                        New Password
                                    </label>
                                    <div class="password-input-wrapper">
                                        <input type="password" id="password" name="password" class="form-input"
                                               placeholder="Leave blank to keep current password">
                                        <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <div class="field-info">
                                        <small>Leave blank if you don't want to change the password</small>
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
                                        Confirm New Password
                                    </label>
                                    <div class="password-input-wrapper">
                                        <input type="password" id="password_confirmation" name="password_confirmation"
                                               class="form-input" placeholder="Confirm new password">
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
                                           value="{{ old('phone', $vendor->phone) }}" placeholder="Enter phone number">
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
                                            <span>{{ $vendor->image ? 'Change image...' : 'Choose image...' }}</span>
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
                                              placeholder="Enter complete address">{{ old('address', $vendor->address) }}</textarea>
                                    @error('address')
                                        <div class="error-message">
                                            <i class="fas fa-exclamation-circle"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Current Image Preview -->
                        @if($vendor->image)
                            <div class="image-preview-section" id="currentImagePreview">
                                <div class="preview-header">
                                    <h4>Current Image</h4>
                                    <div class="preview-actions">
                                        <button type="button" class="change-image-btn" onclick="document.getElementById('image').click()">
                                            <i class="fas fa-edit"></i>
                                            Change
                                        </button>
                                        <button type="button" class="remove-image-btn" onclick="removeCurrentImage()">
                                            <i class="fas fa-times"></i>
                                            Remove
                                        </button>
                                    </div>
                                </div>
                                <div class="image-preview-container">
                                    <img id="currentImg" src="{{ asset('user_images/' . $vendor->image) }}" alt="Current Image" class="preview-image">
                                </div>
                            </div>
                        @endif

                        <!-- New Image Preview -->
                        <div class="image-preview-section" id="imagePreview" style="display: none;">
                            <div class="preview-header">
                                <h4>New Image Preview</h4>
                                <button type="button" class="remove-image-btn" onclick="removeImage()">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <div class="image-preview-container">
                                <img id="previewImg" src="" alt="Preview" class="preview-image">
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
                                    Signed Application
                                </label>
                                <div class="file-input-wrapper">
                                    <input type="file" id="application_document" name="application_document" class="file-input" accept="application/pdf,image/*">
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

                                @if($vendor->application_document)
                                    <div class="file-preview">
                                        <p>Current file: <a href="{{ asset('vendor_documents/' . $vendor->application_document) }}" target="_blank">{{ $vendor->application_document }}</a></p>
                                    </div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="trade_license_document" class="form-label">
                                    <i class="fas fa-file-contract"></i>
                                    Trade License (Valid)
                                </label>
                                <div class="file-input-wrapper">
                                    <input type="file" id="trade_license_document" name="trade_license_document" class="file-input" accept="application/pdf,image/*">
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

                                @if($vendor->trade_license_document)
                                    <div class="file-preview">
                                        <p>Current file: <a href="{{ asset('vendor_documents/' . $vendor->trade_license_document) }}" target="_blank">{{ $vendor->trade_license_document }}</a></p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="vat_certificate_document" class="form-label">
                                    <i class="fas fa-file-invoice-dollar"></i>
                                    VAT Certificate/Tax Certificate
                                </label>
                                <div class="file-input-wrapper">
                                    <input type="file" id="vat_certificate_document" name="vat_certificate_document" class="file-input" accept="application/pdf,image/*">
                                    <div class="file-input-display">
                                        <i class="fas fa-upload"></i>
                                        <span>Choose VAT certificate...</span>
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

                                @if($vendor->vat_certificate_document)
                                    <div class="file-preview">
                                        <p>Current file: <a href="{{ asset('vendor_documents/' . $vendor->vat_certificate_document) }}" target="_blank">{{ $vendor->vat_certificate_document }}</a></p>
                                    </div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="staff_documents" class="form-label">
                                    <i class="fas fa-users"></i>
                                    Staff Documents (Police Clearance)
                                </label>
                                <div class="file-input-wrapper">
                                    <input type="file" id="staff_documents" name="staff_documents" class="file-input" accept="application/pdf,image/*">
                                    <div class="file-input-display">
                                        <i class="fas fa-upload"></i>
                                        <span>Choose staff documents...</span>
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

                                @if($vendor->staff_documents)
                                    <div class="file-preview">
                                        <p>Current file: <a href="{{ asset('vendor_documents/' . $vendor->staff_documents) }}" target="_blank">{{ $vendor->staff_documents }}</a></p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group full-width">
                                <label for="contract_document" class="form-label">
                                    <i class="fas fa-file-contract"></i>
                                    Contract to be Signed
                                </label>
                                <div class="file-input-wrapper">
                                    <input type="file" id="contract_document" name="contract_document" class="file-input" accept="application/pdf,image/*">
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

                                @if($vendor->contract_document)
                                    <div class="file-preview">
                                        <p>Current file: <a href="{{ asset('vendor_documents/' . $vendor->contract_document) }}" target="_blank">{{ $vendor->contract_document }}</a></p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Payment Terms Section -->
                    <div class="form-section">
                        <div class="section-header">
                            <i class="fas fa-money-bill-wave"></i>
                            <h3>Payment Terms</h3>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="payment_type" class="form-label">
                                    <i class="fas fa-cash-register"></i>
                                    Payment Type
                                </label>
                                <select id="payment_type" name="payment_type" class="form-input">
                                    <option value="">Select Payment Type</option>
                                    <option value="fixed_rate" {{ old('payment_type', $vendor->payment_type) == 'fixed_rate' ? 'selected' : '' }}>Fixed Rate</option>
                                    <option value="commission" {{ old('payment_type', $vendor->payment_type) == 'commission' ? 'selected' : '' }}>Commission</option>
                                    <option value="revenue_share" {{ old('payment_type', $vendor->payment_type) == 'revenue_share' ? 'selected' : '' }}>Revenue Share</option>
                                </select>
                                @error('payment_type')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group" id="fixed_rate_container" style="{{ in_array(old('payment_type', $vendor->payment_type), ['fixed_rate']) ? 'display: flex;' : 'display: none;' }}">
                                <label for="fixed_rate_amount" class="form-label">
                                    <i class="fas fa-dollar-sign"></i>
                                    Fixed Rate Amount
                                </label>
                                <input type="number" id="fixed_rate_amount" name="fixed_rate_amount" class="form-input" step="0.01" placeholder="Enter fixed rate amount" value="{{ old('fixed_rate_amount', $vendor->fixed_rate_amount) }}">
                                @error('fixed_rate_amount')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group" id="commission_container" style="{{ in_array(old('payment_type', $vendor->payment_type), ['commission']) ? 'display: flex;' : 'display: none;' }}">
                                <label for="commission_rate" class="form-label">
                                    <i class="fas fa-percent"></i>
                                    Commission Rate (%)
                                </label>
                                <input type="number" id="commission_rate" name="commission_rate" class="form-input" step="0.01" min="0" max="100" placeholder="Enter commission rate" value="{{ old('commission_rate', $vendor->commission_rate) }}">
                                @error('commission_rate')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group" id="revenue_share_container" style="{{ in_array(old('payment_type', $vendor->payment_type), ['revenue_share']) ? 'display: flex;' : 'display: none;' }}">
                                <label for="revenue_share_ratio" class="form-label">
                                    <i class="fas fa-chart-pie"></i>
                                    Revenue Share Ratio
                                </label>
                                <input type="text" id="revenue_share_ratio" name="revenue_share_ratio" class="form-input" placeholder="e.g., 40:60" value="{{ old('revenue_share_ratio', $vendor->revenue_share_ratio) }}">
                                <div class="field-info">
                                    <small>Format: X:Y (e.g., 40:60 means 40% to vendor, 60% to platform)</small>
                                </div>
                                @error('revenue_share_ratio')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <a href="{{ route('admin.vendors.index') }}" class="cancel-btn">
                            <i class="fas fa-times"></i>
                            <span>Cancel</span>
                        </a>
                        <a href="{{ route('admin.vendors.show', $vendor->id) }}" class="view-btn">
                            <i class="fas fa-eye"></i>
                            <span>View Details</span>
                        </a>
                        <button type="submit" class="submit-btn">
                            <i class="fas fa-save"></i>
                            <span>Update Vendor</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
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

        .field-info small {
            color: rgba(255, 255, 255, 0.6);
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

        .preview-actions {
            display: flex;
            gap: 8px;
        }

        .change-image-btn, .remove-image-btn {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .change-image-btn {
            background: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
            border: 1px solid rgba(59, 130, 246, 0.3);
        }

        .change-image-btn:hover {
            background: rgba(59, 130, 246, 0.2);
        }

        .remove-image-btn {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.3);
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
            justify-content: space-between;
            gap: 15px;
            align-items: center;
            margin-top: 40px;
            padding-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .cancel-btn, .view-btn, .submit-btn {
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

        .view-btn {
            background: rgba(245, 158, 11, 0.1);
            color: #f59e0b;
            border: 1px solid rgba(245, 158, 11, 0.3);
        }

        .view-btn:hover {
            background: rgba(245, 158, 11, 0.2);
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

            .cancel-btn, .view-btn, .submit-btn {
                width: 100%;
                justify-content: center;
            }

            .preview-actions {
                flex-direction: column;
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

                    // Hide current image preview if it exists
                    const currentPreview = document.getElementById('currentImagePreview');
                    if (currentPreview) {
                        currentPreview.style.display = 'none';
                    }
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

            // Show current image preview again if it exists
            const currentPreview = document.getElementById('currentImagePreview');
            if (currentPreview) {
                currentPreview.style.display = 'block';
            }
        }

        function removeCurrentImage() {
            if (confirm('Are you sure you want to remove the current image? This action will delete the image permanently.')) {
                // Add a hidden input to mark image for deletion
                const form = document.querySelector('form');
                const deleteInput = document.createElement('input');
                deleteInput.type = 'hidden';
                deleteInput.name = 'delete_image';
                deleteInput.value = '1';
                form.appendChild(deleteInput);

                // Hide current image preview
                document.getElementById('currentImagePreview').style.display = 'none';

                // Update file display
                document.querySelector('.file-input-display span').textContent = 'Choose new image...';
            }
        }

        // Password confirmation validation
        document.getElementById('password_confirmation').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmPassword = this.value;

            if (password && password !== confirmPassword) {
                this.setCustomValidity('Passwords do not match');
            } else {
                this.setCustomValidity('');
            }
        });
    </script>

    <script>
        // Handle payment type selection
        document.getElementById('payment_type').addEventListener('change', function() {
            const selectedValue = this.value;

            // Hide all containers
            document.getElementById('fixed_rate_container').style.display = 'none';
            document.getElementById('commission_container').style.display = 'none';
            document.getElementById('revenue_share_container').style.display = 'none';

            // Show the appropriate container based on selection
            if (selectedValue === 'fixed_rate') {
                document.getElementById('fixed_rate_container').style.display = 'flex';
            } else if (selectedValue === 'commission') {
                document.getElementById('commission_container').style.display = 'flex';
            } else if (selectedValue === 'revenue_share') {
                document.getElementById('revenue_share_container').style.display = 'flex';
            }
        });
    </script>
@endsection
