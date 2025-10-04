@extends('admin.layouts.masterlayout')

@section('title', 'Edit Category')

@section('content')
<div class="modern-form-container">
    <!-- Form Header Section -->
    <div class="form-header-section">
        <div class="form-header-content">
            <div class="form-icon-wrapper">
                <i class="fas fa-edit"></i>
            </div>
            <div class="form-header-text">
                <h1 class="form-title">Edit Category</h1>
                <p class="form-subtitle">Update service category details</p>
            </div>
        </div>
        <div class="form-header-actions">
            <a href="{{ route('services.categories.index') }}" class="modern-btn modern-btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Back to Categories
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="modern-form-card">
        <form method="POST" action="{{ route('services.categories.update', $category) }}" id="categoryEditForm" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="form-grid">
                <!-- Name Input -->
                <div class="form-group-modern">
                    <label for="name" class="modern-label">
                        <i class="fas fa-tag text-cyan"></i>
                        Category Name
                        <span class="required-badge">Required</span>
                    </label>
                    <div class="input-wrapper">
                        <input type="text" class="modern-input" id="name" name="name" 
                               value="{{ old('name', $category->name) }}" placeholder="Enter category name" required>
                        <i class="fas fa-tag input-icon"></i>
                    </div>
                    @error('name')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                    <div class="field-hint">
                        <i class="fas fa-info-circle"></i>
                        Choose a clear and descriptive name for the category
                    </div>
                </div>

                <!-- Status Dropdown -->
                <div class="form-group-modern">
                    <label for="status" class="modern-label">
                        <i class="fas fa-toggle-on text-cyan"></i>
                        Status
                        <span class="required-badge">Required</span>
                    </label>
                    <div class="input-wrapper">
                        <select class="modern-select" id="status" name="status" required>
                            <option value="active" {{ old('status', $category->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $category->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        <i class="fas fa-toggle-on input-icon"></i>
                    </div>
                    @error('status')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                    <div class="field-hint">
                        <i class="fas fa-info-circle"></i>
                        Set category visibility status
                    </div>
                </div>

                <!-- Description Textarea (Full Width) -->
                <div class="form-group-modern full-width">
                    <label for="description" class="modern-label">
                        <i class="fas fa-align-left text-cyan"></i>
                        Description
                        <span class="optional-badge">Optional</span>
                    </label>
                    <div class="input-wrapper">
                        <textarea class="modern-textarea" id="description" name="description" 
                                  placeholder="Enter category description">{{ old('description', $category->description) }}</textarea>
                        <i class="fas fa-align-left input-icon"></i>
                    </div>
                    @error('description')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                    <div class="field-hint">
                        <i class="fas fa-info-circle"></i>
                        Provide a detailed description of what services this category includes
                    </div>
                </div>

                <!-- Current Image Display -->
                @if($category->image)
                <div class="form-group-modern full-width">
                    <label class="modern-label">
                        <i class="fas fa-image text-cyan"></i>
                        Current Image
                    </label>
                    <div class="current-image-wrapper">
                        <img src="{{ asset('Category_images/' . $category->image) }}" alt="Category Image" class="current-image">
                        <div class="image-info">
                            <p class="image-name">{{ $category->image }}</p>
                            <span class="image-badge">Current</span>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Image Upload (Full Width) -->
                <div class="form-group-modern full-width">
                    <label for="image" class="modern-label">
                        <i class="fas fa-camera text-cyan"></i>
                        {{ $category->image ? 'Update Image' : 'Category Image' }}
                        <span class="optional-badge">Optional</span>
                    </label>
                    <div class="input-wrapper">
                        <input type="file" class="modern-input file-input" id="image" name="image" accept="image/*">
                        <i class="fas fa-camera input-icon"></i>
                    </div>
                    @error('image')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                    <div class="field-hint">
                        <i class="fas fa-info-circle"></i>
                        {{ $category->image ? 'Upload a new image to replace the current one' : 'Upload an image to represent this category' }} (JPG, PNG, GIF - Max 2MB)
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <button type="submit" class="modern-btn modern-btn-primary" id="submitBtn">
                    <i class="fas fa-save"></i>
                    <span class="btn-text">Update Category</span>
                    <div class="btn-loader" style="display: none;">
                        <i class="fas fa-spinner fa-spin"></i>
                    </div>
                </button>
                <button type="reset" class="modern-btn modern-btn-secondary">
                    <i class="fas fa-undo"></i>
                    Reset Form
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    /* Modern Category Edit Form Styling */
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
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }

    .form-header-content {
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
        font-size: 24px;
        color: white;
        box-shadow: 0 8px 25px rgba(0, 212, 255, 0.3);
    }

    .form-title {
        font-size: 28px;
        font-weight: 700;
        color: #ffffff;
        margin: 0;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    .form-subtitle {
        font-size: 14px;
        color: rgba(255, 255, 255, 0.8);
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
        margin-bottom: 8px;
    }

    .text-cyan {
        color: #00d4ff;
    }

    .required-badge {
        background: linear-gradient(135deg, #ff4757, #ff3742);
        color: white;
        font-size: 10px;
        padding: 2px 6px;
        border-radius: 8px;
        font-weight: 500;
        margin-left: auto;
    }

    .optional-badge {
        background: linear-gradient(135deg, #ffc107, #ffb300);
        color: #333;
        font-size: 10px;
        padding: 2px 6px;
        border-radius: 8px;
        font-weight: 500;
        margin-left: auto;
    }

    .input-wrapper {
        position: relative;
    }

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

    .file-input {
        padding: 12px 20px 12px 50px;
    }

    .modern-select {
        appearance: none;
        cursor: pointer;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%23ffffff' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 12px center;
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

    .modern-textarea {
        min-height: 120px;
        resize: vertical;
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

    .input-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: rgba(255, 255, 255, 0.5);
        font-size: 14px;
        pointer-events: none;
        transition: all 0.3s ease;
    }

    .input-wrapper:focus-within .input-icon {
        color: #00d4ff;
        transform: translateY(-50%) scale(1.1);
    }

    .current-image-wrapper {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 15px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 12px;
        border: 2px solid rgba(255, 255, 255, 0.1);
    }

    .current-image {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid rgba(0, 212, 255, 0.3);
    }

    .image-info {
        flex: 1;
    }

    .image-name {
        color: #ffffff;
        font-size: 14px;
        margin: 0 0 5px 0;
        font-weight: 500;
    }

    .image-badge {
        background: linear-gradient(135deg, #00d4ff, #0099cc);
        color: white;
        font-size: 10px;
        padding: 2px 8px;
        border-radius: 8px;
        font-weight: 500;
    }

    .error-message {
        display: flex;
        align-items: center;
        gap: 6px;
        color: #ff4757;
        font-size: 12px;
        margin-top: 6px;
        animation: slideInUp 0.3s ease;
    }

    .field-hint {
        display: flex;
        align-items: center;
        gap: 6px;
        color: rgba(255, 255, 255, 0.6);
        font-size: 11px;
        margin-top: 4px;
    }

    .form-actions {
        display: flex;
        gap: 15px;
        justify-content: flex-start;
        flex-wrap: wrap;
    }

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
        color: white;
    }

    .modern-btn-secondary {
        background: rgba(255, 255, 255, 0.1);
        color: #ffffff;
        border: 2px solid rgba(255, 255, 255, 0.2);
    }

    .modern-btn-secondary:hover {
        background: rgba(255, 255, 255, 0.15);
        border-color: #00d4ff;
        color: #00d4ff;
        transform: translateY(-2px);
    }

    .btn-loader {
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
    }

    .modern-btn:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none !important;
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

    /* Responsive Design */
    @media (max-width: 768px) {
        .form-header-section,
        .modern-form-card {
            padding: 20px;
        }

        .form-header-content {
            flex-direction: column;
            text-align: center;
        }

        .form-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .form-actions {
            justify-content: center;
        }

        .modern-btn {
            flex: 1;
            justify-content: center;
            min-width: 140px;
        }

        .current-image-wrapper {
            flex-direction: column;
            text-align: center;
        }
    }
</style>

<script>
    $(document).ready(function() {
        // Form submission with loading state
        $('#categoryEditForm').on('submit', function() {
            const submitBtn = $('#submitBtn');
            const btnText = submitBtn.find('.btn-text');
            const btnLoader = submitBtn.find('.btn-loader');
            
            submitBtn.prop('disabled', true);
            btnText.hide();
            btnLoader.show();
        });

        // Input animations
        $('.modern-input, .modern-select, .modern-textarea').on('focus', function() {
            $(this).parent().addClass('focused');
        }).on('blur', function() {
            $(this).parent().removeClass('focused');
        });

        // Reset form functionality
        $('button[type="reset"]').on('click', function(e) {
            e.preventDefault();
            if (confirm('Are you sure you want to reset all fields?')) {
                $('#categoryEditForm')[0].reset();
            }
        });
    });
</script>
@endsection
