@extends('admin.layouts.masterlayout')

@section('content')
<div class="modern-form-container">
    <!-- Form Header Section -->
    <div class="form-header-section">
        <div class="form-header-content">
            <div class="form-icon-wrapper">
                <i class="fas fa-edit"></i>
            </div>
            <div class="form-header-text">
                <h1 class="form-title">Edit Service FAQs</h1>
                <p class="form-subtitle">Manage all FAQs for service: <strong>{{ $service->name }}</strong></p>
            </div>
        </div>
        <div class="form-header-actions">
            <a href="{{ route('faqs.service.view', $service->id) }}" class="modern-btn modern-btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Back to View
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="modern-form-card">
        <!-- Debug Information (remove this after fixing) -->
        <!-- @if(config('app.debug'))
            <div style="background: rgba(255,255,255,0.1); padding: 10px; margin-bottom: 20px; border-radius: 8px;">
                <strong>Debug Info:</strong><br>
                Service ID: {{ $service->id ?? 'null' }}<br>
                Service Name: {{ $service->name ?? 'null' }}<br>
                Category ID: {{ $service->category_id ?? 'null' }}<br>
                Subcategory ID: {{ $service->subcategory_id ?? 'null' }}<br>
                Category Loaded: {{ $service->relationLoaded('category') ? 'Yes' : 'No' }}<br>
                Subcategory Loaded: {{ $service->relationLoaded('subcategory') ? 'Yes' : 'No' }}<br>
                Category Name: {{ $service->category->name ?? 'null' }}<br>
                Subcategory Name: {{ $service->subcategory->name ?? 'null' }}<br>
                FAQs Count: {{ $faqs->count() }}
            </div>
        @endif -->
        
        <form method="POST" action="{{ route('faqs.service.update', $service->id) }}" id="faqsServiceForm">
            @csrf
            @method('PUT')

            <!-- Service Selection Grid -->
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
                                <option value="{{ $category->id }}"
                                    {{ isset($currentCategory) && $currentCategory->id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}</option>
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
                        Select the main category for these FAQs
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
                            @if (isset($currentCategory) && isset($currentSubcategory))
                                @foreach ($currentCategory->subcategories as $subcategory)
                                    <option value="{{ $subcategory->id }}"
                                        {{ $currentSubcategory->id == $subcategory->id ? 'selected' : '' }}>
                                        {{ $subcategory->name }}
                                    </option>
                                @endforeach
                            @endif
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
                            @if (isset($currentCategory) && isset($currentSubcategory) && isset($currentService))
                                @foreach ($currentSubcategory->services as $serviceOption)
                                    <option value="{{ $serviceOption->id }}"
                                        {{ $currentService->id == $serviceOption->id ? 'selected' : '' }}>
                                        {{ $serviceOption->name }}
                                    </option>
                                @endforeach
                            @endif
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
                        Select the target service for these FAQs
                    </div>
                </div>

                <!-- Current FAQ Count (Read-only) -->
                <div class="form-group-modern">
                    <label class="modern-label">
                        <i class="fas fa-list-ul text-cyan"></i>
                        Total FAQs
                    </label>
                    <div class="input-wrapper">
                        <div class="modern-input-display">{{ $faqs->count() }}</div>
                        <i class="fas fa-list-ul input-icon"></i>
                    </div>
                    <div class="field-hint">
                        <i class="fas fa-info-circle"></i>
                        Current number of FAQs being edited
                    </div>
                </div>
            </div>

            <!-- Q&A Repeater -->
            <div class="form-group-modern full-width">
                <label class="modern-label">
                    <i class="fas fa-list-ul text-cyan"></i>
                    Questions & Answers
                </label>
                <div id="qa-container">
                    @foreach ($faqs as $i => $faq)
                        <div class="qa-item" data-index="{{ $i + 1 }}">
                            <div class="qa-header">
                                <span class="qa-title"><i class="fas fa-hashtag"></i> Q&A #{{ $i + 1 }}</span>
                                <button type="button" class="modern-btn modern-btn-secondary remove-qa" data-faq-id="{{ $faq->id }}">
                                    <i class="fas fa-trash-alt"></i>
                                    Remove
                                </button>
                            </div>
                            <div class="qa-body">
                                <input type="hidden" name="faq_ids[]" value="{{ $faq->id }}">
                                <div class="form-group-modern">
                                    <label class="modern-label"><i class="fas fa-question text-cyan"></i> Question</label>
                                    <div class="input-wrapper">
                                        <input type="text" class="modern-input" name="questions[]" value="{{ $faq->question }}" required>
                                        <i class="fas fa-question input-icon"></i>
                                    </div>
                                </div>
                                <div class="form-group-modern">
                                    <label class="modern-label"><i class="fas fa-comment-dots text-cyan"></i> Answer</label>
                                    <div class="input-wrapper">
                                        <textarea class="modern-textarea summernote" name="answers[]" required>{{ $faq->answer }}</textarea>
                                        <i class="fas fa-comment-dots input-icon"></i>
                                    </div>
                                </div>
                                <div class="form-group-modern">
                                    <label class="modern-label"><i class="fas fa-toggle-on text-cyan"></i> Status</label>
                                    <div class="input-wrapper">
                                        <select class="modern-select" name="statuses[]">
                                            <option value="1" {{ $faq->status == 1 ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ $faq->status == 0 ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                        <i class="fas fa-toggle-on input-icon"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div id="remove-ids-container"></div>

            <!-- Actions -->
            <div class="form-actions">
                <button type="button" class="modern-btn modern-btn-secondary" id="addQaBtn">
                    <i class="fas fa-plus-circle"></i>
                    Add Q&A
                </button>
                <button type="submit" class="modern-btn modern-btn-primary" id="submitBtn">
                    <i class="fas fa-save"></i>
                    <span class="btn-text">Save FAQs</span>
                    <div class="btn-loader" style="display: none;">
                        <i class="fas fa-spinner fa-spin"></i>
                    </div>
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    /* Modern FAQ Edit Styling - Inherits from existing forms */
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

    .modern-input-display {
        width: 100%;
        padding: 16px 20px 16px 50px;
        background: rgba(255, 255, 255, 0.05);
        border: 2px solid rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        color: #ffffff;
        font-size: 14px;
        backdrop-filter: blur(10px);
        min-height: 20px;
    }

    .modern-select {
        appearance: none;
        cursor: pointer;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%23ffffff' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 12px center;
        background-repeat: no-repeat;
        background-size: 16px;
    }

    .modern-textarea {
        min-height: 120px;
        resize: vertical;
    }

    .input-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: rgba(255, 255, 255, 0.5);
        font-size: 14px;
        pointer-events: none;
    }

    /* Q&A Repeater */
    #qa-container {
        display: flex;
        flex-direction: column;
        gap: 18px;
    }

    .qa-item {
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        padding: 16px;
        background: rgba(255, 255, 255, 0.04);
    }

    .qa-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
    }

    .qa-title {
        color: #ffffff;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
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

    /* Error Messages and Field Hints */
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

    /* Focus states for form elements */
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

    .input-wrapper:focus-within .input-icon {
        color: #00d4ff;
        transform: translateY(-50%) scale(1.1);
    }

    /* Select dropdown styling */
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
</style>

<script>
    $(document).ready(function(){
        // Store initial selections for reset functionality
        var initialCategoryId = "{{ isset($currentCategory) ? $currentCategory->id : '' }}";
        var initialSubcategoryId = "{{ isset($currentSubcategory) ? $currentSubcategory->id : '' }}";
        var initialServiceId = "{{ isset($currentService) ? $currentService->id : '' }}";

        // Submit button loading
        $('#faqsServiceForm').on('submit', function(){
            const submitBtn = $('#submitBtn');
            submitBtn.prop('disabled', true);
            submitBtn.find('.btn-text').hide();
            submitBtn.find('.btn-loader').show();
        });

        // When category changes
        $('#category_id').change(function() {
            var categoryId = $(this).val();
            var subcategorySelect = $('#subcategory_id');
            var serviceSelect = $('#service_id');

            // Only reset if user actually changed the category
            if (categoryId !== initialCategoryId) {
                // Clear subcategory and service dropdowns
                subcategorySelect.html('<option value="">Select a Subcategory</option>');
                serviceSelect.html('<option value="">Select a Service</option>');
            }

            if (categoryId) {
                // Fetch subcategories for selected category
                $.get('{{ url('/') }}/faqs/get-subcategories/' + categoryId)
                    .done(function(data) {
                        if (data.length > 0) {
                            $.each(data, function(key, subcategory) {
                                subcategorySelect.append('<option value="' + subcategory
                                    .id + '">' + subcategory.name + '</option>');
                            });
                            // If this category has pre-selected subcategory, select it
                            if (categoryId === initialCategoryId && initialSubcategoryId) {
                                subcategorySelect.val(initialSubcategoryId).trigger('change');
                            }
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

            // Only reset if user actually changed the subcategory
            if (subcategoryId !== initialSubcategoryId) {
                serviceSelect.html('<option value="">Select a Service</option>');
            }

            if (categoryId && subcategoryId) {
                // Fetch services for selected category and subcategory
                $.get('{{ url('/') }}/faqs/get-services/' + categoryId + '/' + subcategoryId)
                    .done(function(data) {
                        if (data.length > 0) {
                            $.each(data, function(key, service) {
                                serviceSelect.append('<option value="' + service.id + '">' +
                                    service.name + '</option>');
                            });
                            // If this subcategory has pre-selected service, select it
                            if (subcategoryId === initialSubcategoryId && initialServiceId) {
                                serviceSelect.val(initialServiceId);
                            }
                        } else {
                            serviceSelect.html('<option value="">No services available</option>');
                        }
                    })
                    .fail(function() {
                        alert('Error loading services');
                    });
            }
        });

        // Initialize: if we have a pre-selected category, trigger the change event to load subcategories
        if (initialCategoryId) {
            $('#category_id').trigger('change');
        }

        // Summernote init helper
        function initSummernoteIfAvailable(el) {
            if ($.fn.summernote && !$(el).data('summernote')) {
                $(el).summernote({ height: 120 });
            }
        }
        $('#qa-container textarea.summernote').each(function(){ initSummernoteIfAvailable(this); });

        function refreshQaTitles() {
            $('#qa-container .qa-item').each(function(index){
                $(this).attr('data-index', index+1);
                $(this).find('.qa-title').html('<i class="fas fa-hashtag"></i> Q&A #' + (index+1));
            });
        }

        function addQaItem() {
            var $item = $('<div class="qa-item" data-index="0">\
                <div class="qa-header">\
+                   <span class="qa-title"><i class="fas fa-hashtag"></i> Q&A</span>\
                    <button type="button" class="modern-btn modern-btn-secondary remove-qa">\
                        <i class="fas fa-trash-alt"></i> Remove\
                    </button>\
                </div>\
                <div class="qa-body">\
                    <div class="form-group-modern">\
                        <label class="modern-label"><i class=\"fas fa-question text-cyan\"></i> Question</label>\
                        <div class=\"input-wrapper\">\
                            <input type=\"text\" class=\"modern-input\" name=\"questions[]\" placeholder=\"Enter the frequently asked question\" required>\
                            <i class=\"fas fa-question input-icon\"></i>\
                        </div>\
                    </div>\
                    <div class="form-group-modern">\
                        <label class="modern-label"><i class=\"fas fa-comment-dots text-cyan\"></i> Answer</label>\
                        <div class=\"input-wrapper\">\
                            <textarea class=\"modern-textarea summernote\" name=\"answers[]\" placeholder=\"Provide a detailed answer to the question\" required></textarea>\
                            <i class=\"fas fa-comment-dots input-icon\"></i>\
                        </div>\
                    </div>\
                    <div class="form-group-modern">\
                        <label class="modern-label"><i class=\"fas fa-toggle-on text-cyan\"></i> Status</label>\
                        <div class=\"input-wrapper\">\
                            <select class=\"modern-select\" name=\"statuses[]\">\
                                <option value=\"1\" selected>Active</option>\
                                <option value=\"0\">Inactive</option>\
                            </select>\
                            <i class=\"fas fa-toggle-on input-icon\"></i>\
                        </div>\
                    </div>\
                </div>\
            </div>');
            $('#qa-container').append($item);
            initSummernoteIfAvailable($item.find('textarea.summernote'));
            refreshQaTitles();
        }

        // Add new item
        $('#addQaBtn').on('click', function(){ addQaItem(); });

        // Remove item
        $('#qa-container').on('click', '.remove-qa', function(){
            var $item = $(this).closest('.qa-item');
            var existingId = $(this).data('faq-id');
            if (existingId) {
                // Track for deletion
                $('#remove-ids-container').append('<input type="hidden" name="remove_ids[]" value="'+ existingId +'">');
            }
            $item.remove();
            refreshQaTitles();
        });
    });
</script>
@endsection
