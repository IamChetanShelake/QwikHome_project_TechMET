@extends('admin.layouts.masterlayout')

@section('content')
    <div class="content-area">

        <div class="">

            <div class="dashboard-card p-3">

                <div class="card-header">

                    <h3>Create FAQ</h3>
                    <a href="{{ route('faq') }}" class="btn btn-secondary">Back</a>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('faq.store') }}">
                        @csrf
                        <div class="row">
                            <!-- Category Dropdown -->
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="category_id">Category</label>
                                    <select class="form-control" id="category_id" name="category_id" required>
                                        <option value="">Select a Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
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
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
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
                                    <input type="text" class="form-control" id="question" name="question" required>
                                    @error('question')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Answer Textarea (Full Width) -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="answer">Answer</label>
                                    <textarea class="form-control summernote" id="answer" name="answer" required></textarea>
                                    @error('answer')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Submit Button (Full Width) -->
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Create FAQ</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <script>
        $(document).ready(function() {
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
