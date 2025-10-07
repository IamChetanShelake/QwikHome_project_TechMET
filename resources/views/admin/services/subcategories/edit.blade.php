@extends('admin.layouts.masterlayout')

@section('title', 'Edit Subcategory')

@section('content')
<div class="modern-form-container">
    <!-- Form Header Section -->
    <div class="form-header-section">
        <div class="header-content">
            <div class="header-icon-wrapper">
                <i class="fas fa-folder-open"></i>
            </div>
            <div class="header-text">
                <h1 class="header-title">Edit Subcategory</h1>
                <p class="header-subtitle">Update subcategory information and settings</p>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="modern-form-card">
        <form method="POST" action="{{ route('services.subcategories.update', $subcategory) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Form Grid -->
            <div class="form-grid">
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
                                    {{ $subcategory->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
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

                <!-- Subcategory Name -->
                <div class="form-group-modern">
                    <label for="name" class="modern-label">
                        <i class="fas fa-folder-open"></i>
                        Subcategory Name
                        <span class="required-asterisk">*</span>
                    </label>
                    <div class="input-wrapper">
                        <input type="text" name="name" id="name" value="{{ old('name', $subcategory->name) }}"
                            class="modern-input" placeholder="Enter subcategory name" required>
                        <i class="fas fa-folder-open input-icon"></i>
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
                    <div class="input-wrapper">
                        <select name="status" id="status" class="modern-select" required>
                            <option value="active" {{ old('status', $subcategory->status) == 'active' ? 'selected' : '' }}>
                                Active
                            </option>
                            <option value="inactive" {{ old('status', $subcategory->status) == 'inactive' ? 'selected' : '' }}>
                                Inactive
                            </option>
                        </select>
                        <i class="fas fa-toggle-on input-icon"></i>
                    </div>
                    @error('status')
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
                        Subcategory Image
                        <span class="optional-badge">Optional</span>
                    </label>
                    <div class="file-upload-wrapper">
                        <input type="file" name="image" id="image" class="modern-file-input" accept="image/*">
                        <label for="image" class="file-upload-label">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <span class="file-upload-text">Choose Image File</span>
                        </label>
                        @if($subcategory->image)
                            <div class="current-image-preview">
                                <img src="{{ asset('Subcategory_images/' . $subcategory->image) }}" 
                                     alt="Current Subcategory Image" class="preview-image">
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

            <!-- Description - Full Width -->
            <div class="form-group-modern full-width">
                <label for="description" class="modern-label">
                    <i class="fas fa-align-left"></i>
                    Description
                    <span class="optional-badge">Optional</span>
                </label>
                <div class="input-wrapper">
                    <textarea name="description" id="description" class="modern-textarea" 
                              placeholder="Enter subcategory description (optional)" rows="4">{{ old('description', $subcategory->description) }}</textarea>
                    <i class="fas fa-align-left input-icon"></i>
                </div>
                @error('description')
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <button type="submit" class="modern-btn modern-btn-primary">
                    <i class="fas fa-save"></i>
                    Update Subcategory
                </button>
                <a href="{{ route('services.subcategories.index') }}" class="modern-btn modern-btn-secondary">
                    <i class="fas fa-times"></i>
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<style>
    /* Modern Subcategory Edit Form Styling */
    .modern-form-container {
        max-width: 1000px;
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

    /* Form Card */
    .modern-form-card {
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(15px);
        border-radius: 0 0 20px 20px;
        padding: 40px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-top: none;
    }

    /* Form Grid */
    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
        margin-bottom: 40px;
    }

    .form-group-modern {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .form-group-modern.full-width {
        grid-column: 1 / -1;
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

    .optional-badge {
        background: rgba(255, 193, 7, 0.2);
        color: #ffc107;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 500;
        margin-left: auto;
    }

    /* Input Wrapper */
    .input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    /* Input Fields */
    .modern-input, .modern-select, .modern-textarea {
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

    .modern-input:focus, .modern-select:focus, .modern-textarea:focus {
        outline: none;
        border-color: #00d4ff;
        background: rgba(255, 255, 255, 0.08);
        box-shadow: 0 0 20px rgba(0, 212, 255, 0.2);
        transform: translateY(-2px);
    }

    .modern-input::placeholder, .modern-textarea::placeholder {
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
        padding: 16px 20px;
        background: rgba(255, 255, 255, 0.05);
        border: 2px dashed rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        color: rgba(255, 255, 255, 0.8);
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
        font-size: 20px;
        color: #00d4ff;
    }

    .current-image-preview {
        margin-top: 15px;
        text-align: center;
    }

    .preview-image {
        max-width: 120px;
        max-height: 120px;
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
        padding-top: 20px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        margin-top: 30px;
    }

    /* Modern Buttons */
    .modern-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 14px 28px;
        border: none;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.3s ease;
        min-width: 140px;
        justify-content: center;
    }

    .modern-btn-primary {
        background: linear-gradient(135deg, #00d4ff, #0099cc);
        color: white;
        box-shadow: 0 8px 25px rgba(0, 212, 255, 0.3);
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
    }

    .modern-btn-secondary:hover {
        background: rgba(255, 255, 255, 0.15);
        border-color: rgba(255, 255, 255, 0.3);
        transform: translateY(-2px);
        color: #ffffff;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .modern-form-container {
            padding: 15px;
        }

        .form-header-section,
        .modern-form-card {
            padding: 20px;
        }

        .header-content {
            flex-direction: column;
            text-align: center;
            gap: 15px;
        }

        .form-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .form-actions {
            flex-direction: column;
        }

        .modern-btn {
            width: 100%;
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
    });
</script>
@endsection