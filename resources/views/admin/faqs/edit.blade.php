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
                <h1 class="form-title">Edit FAQ</h1>
                <p class="form-subtitle">Update frequently asked question details</p>
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
        <form method="POST" action="{{ route('faq.update', $faq->id) }}" id="faqEditForm">
            @csrf
            @method('PUT')
            
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
                                @foreach ($currentSubcategory->services as $service)
                                    <option value="{{ $service->id }}"
                                        {{ $currentService->id == $service->id ? 'selected' : '' }}>
                                        {{ $service->name }}
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
                            <option value="1" {{ $faq->status == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ $faq->status == 0 ? 'selected' : '' }}>Inactive</option>
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
                               value="{{ $faq->question }}" placeholder="Enter the frequently asked question" required>
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
                                  placeholder="Provide a detailed answer to the question" required>{{ $faq->answer }}</textarea>
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
                    <i class="fas fa-save"></i>
                    <span class="btn-text">Update FAQ</span>
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

    <script>
        $(document).ready(function() {
            // Store initial selections for reset functionality
            var initialCategoryId = "{{ isset($currentCategory) ? $currentCategory->id : '' }}";
            var initialSubcategoryId = "{{ isset($currentSubcategory) ? $currentSubcategory->id : '' }}";
            var initialServiceId = "{{ isset($currentService) ? $currentService->id : '' }}";

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
        });
    </script>
@endsection
