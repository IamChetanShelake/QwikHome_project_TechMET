@extends('admin.layouts.masterlayout')

@section('content')
<div class="modern-form-container">
    <!-- Form Header Section -->
    <div class="form-header-section">
        <div class="form-header-content">
            <div class="form-icon-wrapper">
                <i class="fas fa-question-circle"></i>
            </div>
            <div class="form-header-text">
                <h1 class="form-title">Create FAQ</h1>
                <p class="form-subtitle">Add a new frequently asked question to help your customers</p>
            </div>
        </div>
        <div class="form-header-actions">
            <a href="{{ route('faq') }}" class="modern-btn modern-btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Back to FAQs
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="modern-form-card">
        <form method="POST" action="{{ route('faq.store') }}" id="faqForm">
            @csrf
            
            <div class="form-grid">
                <!-- Category Dropdown -->
                <div class="form-group-modern">
                    <label for="category_id" class="modern-label">
                        <i class="fas fa-folder text-cyan"></i>
                        Category
                    </label>
                    <div class="input-wrapper">
                        <select class="modern-select" id="category_id" name="category_id" required>
                            <option value="">Select a Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
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
                    <div class="field-hint">
                        <i class="fas fa-info-circle"></i>
                        Select the main category for this FAQ
                    </div>
                </div>

                <!-- Subcategory Dropdown -->
                <div class="form-group-modern">
                    <label for="subcategory_id" class="modern-label">
                        <i class="fas fa-folder-open text-cyan"></i>
                        Subcategory
                    </label>
                    <div class="input-wrapper">
                        <select class="modern-select" id="subcategory_id" name="subcategory_id" required>
                            <option value="">Select a Subcategory</option>
                        </select>
                        <i class="fas fa-folder-open input-icon"></i>
                    </div>
                    @error('subcategory_id')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                    <div class="field-hint">
                        <i class="fas fa-info-circle"></i>
                        Choose the specific subcategory
                    </div>
                </div>

                <!-- Service Dropdown -->
                <div class="form-group-modern">
                    <label for="service_id" class="modern-label">
                        <i class="fas fa-concierge-bell text-cyan"></i>
                        Service
                    </label>
                    <div class="input-wrapper">
                        <select class="modern-select" id="service_id" name="service_id" required>
                            <option value="">Select a Service</option>
                        </select>
                        <i class="fas fa-concierge-bell input-icon"></i>
                    </div>
                    @error('service_id')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                    <div class="field-hint">
                        <i class="fas fa-info-circle"></i>
                        Select the specific service for this FAQ
                    </div>
                </div>

                <!-- Status Dropdown -->
                <div class="form-group-modern">
                    <label for="status" class="modern-label">
                        <i class="fas fa-toggle-on text-cyan"></i>
                        Status
                    </label>
                    <div class="input-wrapper">
                        <select class="modern-select" id="status" name="status" required>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
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
                        Set FAQ visibility status
                    </div>
                </div>

                <!-- Question Input (Full Width) -->
                <div class="form-group-modern full-width">
                    <label for="question" class="modern-label">
                        <i class="fas fa-question text-cyan"></i>
                        Question
                    </label>
                    <div class="input-wrapper">
                        <input type="text" class="modern-input" id="question" name="question" 
                               placeholder="Enter the frequently asked question" required>
                        <i class="fas fa-question input-icon"></i>
                    </div>
                    @error('question')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                    <div class="field-hint">
                        <i class="fas fa-info-circle"></i>
                        Write a clear and concise question that customers frequently ask
                    </div>
                </div>

                <!-- Answer Textarea (Full Width) -->
                <div class="form-group-modern full-width">
                    <label for="answer" class="modern-label">
                        <i class="fas fa-comment-dots text-cyan"></i>
                        Answer
                    </label>
                    <div class="input-wrapper">
                        <textarea class="modern-textarea summernote" id="answer" name="answer" 
                                  placeholder="Provide a detailed answer to the question" required></textarea>
                        <i class="fas fa-comment-dots input-icon"></i>
                    </div>
                    @error('answer')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                    <div class="field-hint">
                        <i class="fas fa-info-circle"></i>
                        Provide a comprehensive answer that addresses the question completely
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <button type="submit" class="modern-btn modern-btn-primary" id="submitBtn">
                    <i class="fas fa-plus"></i>
                    <span class="btn-text">Create FAQ</span>
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
    /* Modern FAQ Form Styling */
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
    }
</style>

<script>
    $(document).ready(function() {
        // Form submission with loading state
        $('#faqForm').on('submit', function() {
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
                $('#faqForm')[0].reset();
                $('#subcategory_id').html('<option value="">Select a Subcategory</option>');
                $('#service_id').html('<option value="">Select a Service</option>');
            }
        });

        // When category changes
        $('#category_id').change(function() {
            var categoryId = $(this).val();
            var subcategorySelect = $('#subcategory_id');
            var serviceSelect = $('#service_id');

            // Clear subcategory and service dropdowns
            subcategorySelect.html('<option value="">Select a Subcategory</option>');
            serviceSelect.html('<option value="">Select a Service</option>');

            if (categoryId) {
                // Fetch subcategories for selected category
                $.get('{{ url('/') }}/faqs/get-subcategories/' + categoryId)
                    .done(function(data) {
                        if (data.length > 0) {
                            $.each(data, function(key, subcategory) {
                                subcategorySelect.append('<option value="' + subcategory
                                    .id + '">' + subcategory.name + '</option>');
                            });
                        }
                    })
                    .fail(function() {
                        alert('Error loading subcategories');
                    });
            }
        });

        // When subcategory changes
        $('#subcategory_id').change(function() {
            var categoryId = $('#category_id').val();
            var subcategoryId = $(this).val();
            var serviceSelect = $('#service_id');

            // Clear service dropdown
            serviceSelect.html('<option value="">Select a Service</option>');

            if (categoryId && subcategoryId) {
                // Fetch services for selected category and subcategory
                $.get('{{ url('/') }}/faqs/get-services/' + categoryId + '/' + subcategoryId)
                    .done(function(data) {
                        if (data.length > 0) {
                            $.each(data, function(key, service) {
                                serviceSelect.append('<option value="' + service.id + '">' +
                                    service.name + '</option>');
                            });
                        } else {
                            serviceSelect.html('<option value="">No services available</option>');
                        }
                    })
                    .fail(function() {
                        alert('Error loading services');
                    });
            }
        });
    });
</script>
@endsection
