@extends('admin.layouts.masterlayout')

@section('content')
    <div class="content-area">
        <div class="">
            <div class="dashboard-card p-3">
                <div class="card-header">
                    <h3>Edit FAQ</h3>
                    <a href="{{ route('faq') }}" class="btn btn-secondary">Back</a>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('faq.update', $faq->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <!-- Category Dropdown -->
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label for="category_id">Category</label>
                                    <select class="form-control" id="category_id" name="category_id" required>
                                        <option value="">Select a Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ isset($currentCategory) && $currentCategory->id == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Subcategory Dropdown -->
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="subcategory_id">Subcategory</label>
                                    <select class="form-control" id="subcategory_id" name="subcategory_id" required>
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
                                    @error('subcategory_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Service Dropdown -->
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="service_id">Service</label>
                                    <select class="form-control" id="service_id" name="service_id" required>
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
                                    @error('service_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Status Dropdown -->
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="1" {{ $faq->status == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ $faq->status == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('status')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Question Input (Full Width) -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="question">Question</label>
                                    <input type="text" class="form-control" id="question" name="question"
                                        value="{{ $faq->question }}" required>
                                    @error('question')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Answer Textarea (Full Width) -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="answer">Answer</label>
                                    <textarea class="form-control summernote" id="answer" name="answer" required>{{ $faq->answer }}</textarea>
                                    @error('answer')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Submit Button (Full Width) -->
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Update FAQ</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
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
