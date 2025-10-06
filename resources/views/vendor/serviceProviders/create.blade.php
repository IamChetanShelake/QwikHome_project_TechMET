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
                        <h2 class="form-title">Add New Employee</h2>
                        <p class="form-subtitle">Create a new service provider account with access to the platform</p>
                    </div>
                </div>
                <a href="{{ route('serviceProviders.index') }}" class="back-btn">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back to Employees</span>
                </a>
            </div>

            <!-- Form Section -->
            <div class="form-card">
                <form action="{{ route('serviceProviders.store') }}" method="POST" enctype="multipart/form-data">
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
                                                           {{ in_array($service->id, old('services', [])) ? 'checked' : '' }}>
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

                        <!-- Hidden role field -->
                        <input type="hidden" name="role" value="serviceprovider">
                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <a href="{{ route('serviceProviders.index') }}" class="cancel-btn">
                            <i class="fas fa-times"></i>
                            <span>Cancel</span>
                        </a>
                        <button type="submit" class="submit-btn">
                            <i class="fas fa-save"></i>
                            <span>Create Employee</span>
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
@endsection
