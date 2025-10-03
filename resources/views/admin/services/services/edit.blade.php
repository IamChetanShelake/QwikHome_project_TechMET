@extends('admin.layouts.masterlayout')

@section('title', 'Edit Service')

@section('content')
    <section class="content-section active p-3">
        <div class="section-header">
            <h2>Edit Service</h2>
        </div>

        <div class="dashboard-card p-3">
            <form method="POST" action="{{ route('services.services.update', $service) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="category_id">Category *</label>
                    <select name="category_id" id="category_id" class="filter-select" required>
                        <option value="">Select Category</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $service->category_id == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="subcategory_id">Subcategory (Optional)</label>
                    <select name="subcategory_id" id="subcategory_id" class="filter-select">
                        <option value="">None</option>
                        @foreach ($subcategories as $sub)
                            <option value="{{ $sub->id }}"
                                {{ $service->subcategory_id == $sub->id ? 'selected' : '' }}>{{ $sub->name }}</option>
                        @endforeach
                    </select>
                    @error('subcategory_id')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="name">Name *</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $service->name) }}"
                        class="filter-input" required>
                    @error('name')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="short_description">Short Description</label>
                    <textarea name="short_description" id="short_description" class="message-textarea">{{ old('short_description', $service->short_description) }}</textarea>
                    @error('short_description')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" class="message-textarea">{{ old('description', $service->description) }}</textarea>
                    @error('description')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>What's Included</label>
                    <div id="whats_include_container">
                        @if(old('whats_include'))
                            @foreach(old('whats_include') as $index => $include)
                                <div class="include-item" style="display: flex; align-items: center; margin-bottom: 10px;">
                                    <input type="text" name="whats_include[]" value="{{ $include }}" class="filter-input" placeholder="Enter item" style="flex: 1; margin-right: 10px;">
                                    @if($index > 0)
                                        <button type="button" class="btn btn-danger remove-include">Remove</button>
                                    @endif
                                </div>
                            @endforeach
                        @elseif($service->whats_include)
                            @foreach($service->whats_include as $index => $include)
                                <div class="include-item" style="display: flex; align-items: center; margin-bottom: 10px;">
                                    <input type="text" name="whats_include[]" value="{{ $include }}" class="filter-input" placeholder="Enter item" style="flex: 1; margin-right: 10px;">
                                    @if($index > 0)
                                        <button type="button" class="btn btn-danger remove-include">Remove</button>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <div class="include-item" style="display: flex; align-items: center; margin-bottom: 10px;">
                                <input type="text" name="whats_include[]" class="filter-input" placeholder="Enter item" style="flex: 1;">
                            </div>
                        @endif
                    </div>
                    <button type="button" id="add_include" class="btn-secondary">Add New</button>
                    @error('whats_include')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>What We Need From You</label>
                    <div id="requirements_container">
                        @if(old('requirements'))
                            @foreach(old('requirements') as $index => $req)
                                <div class="requirement-item" style="border-bottom: 1px solid #ddd; padding: 10px 0; margin-bottom: 10px;">
                                    <input type="text" name="requirements[{{ $index }}][title]" value="{{ $req['title'] ?? '' }}" class="filter-input" placeholder="Title" style="margin-bottom: 10px; width: 100%;">
                                    <input type="file" name="requirements[{{ $index }}][image]" accept="image/*" style="margin-bottom: 10px;">
                                    @if($index > 0)
                                        <button type="button" class="btn btn-danger remove-requirement">Remove</button>
                                    @endif
                                </div>
                            @endforeach
                        @elseif($service->requirements->count() > 0)
                            @foreach($service->requirements as $index => $req)
                                <div class="requirement-item" style="border-bottom: 1px solid #ddd; padding: 10px 0; margin-bottom: 10px;">
                                    <input type="text" name="requirements[{{ $index }}][title]" value="{{ old('requirements.' . $index . '.title', $req->title) }}" class="filter-input" placeholder="Title" style="margin-bottom: 10px; width: 100%;">
                                    <input type="file" name="requirements[{{ $index }}][image]" accept="image/*" style="margin-bottom: 10px;">
                                    <input type="hidden" name="requirements[{{ $index }}][existing_image]" value="{{ $req->image }}">
                                    @if($req->image)
                                        <p>Current Image: <img src="{{ asset('Service_requirement_images/' . $req->image) }}" width="100" alt="Requirement Image"></p>
                                    @endif
                                    @if($index > 0)
                                        <button type="button" class="btn btn-danger remove-requirement">Remove</button>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <div class="requirement-item" style="border-bottom: 1px solid #ddd; padding: 10px 0; margin-bottom: 10px;">
                                <input type="text" name="requirements[0][title]" class="filter-input" placeholder="Title" style="margin-bottom: 10px; width: 100%;">
                                <input type="file" name="requirements[0][image]" accept="image/*" style="margin-bottom: 10px;">
                            </div>
                        @endif
                    </div>
                    <button type="button" id="add_requirement" class="btn-secondary">Add New</button>
                    @error('requirements')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="price_onetime">One Time Price *</label>
                    <input type="number" name="price_onetime" id="price_onetime" value="{{ old('price_onetime', $service->price_onetime) }}" step="0.01"
                        min="0" class="filter-input" required>
                    @error('price_onetime')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="price_weekly">Weekly Price</label>
                    <input type="number" name="price_weekly" id="price_weekly" value="{{ old('price_weekly', $service->price_weekly) }}" step="0.01"
                        min="0" class="filter-input">
                    @error('price_weekly')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="price_monthly">Monthly Price</label>
                    <input type="number" name="price_monthly" id="price_monthly" value="{{ old('price_monthly', $service->price_monthly) }}" step="0.01"
                        min="0" class="filter-input">
                    @error('price_monthly')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="price_yearly">Yearly Price</label>
                    <input type="number" name="price_yearly" id="price_yearly" value="{{ old('price_yearly', $service->price_yearly) }}" step="0.01"
                        min="0" class="filter-input">
                    @error('price_yearly')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="duration">Duration</label>
                    <input type="text" name="duration" id="duration" value="{{ old('duration', $service->duration) }}"
                        class="filter-input" placeholder="e.g., 2 hours">
                    @error('duration')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="status">Status *</label>
                    <select name="status" id="status" class="filter-select" required>
                        <option value="active" {{ old('status', $service->status) == 'active' ? 'selected' : '' }}>Active
                        </option>
                        <option value="inactive" {{ old('status', $service->status) == 'inactive' ? 'selected' : '' }}>
                            Inactive</option>
                    </select>
                    @error('status')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="is_arabic">Arabic</label>
                    <input type="checkbox" name="is_arabic" id="is_arabic" value="1" {{ old('is_arabic', $service->is_arabic) ? 'checked' : '' }}>
                    @error('is_arabic')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" name="image" id="image" accept="image/*">
                    @if($service->image)
                        <p>Current Image: <img src="{{ asset('Service_images/' . $service->image) }}" width="100" alt="Service Image"></p>
                    @endif
                    @error('image')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-primary">Update Service</button>
                    <a href="{{ route('services.services.index') }}" class="btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </section>
@endsection

<style>
    .error {
        color: #e74c3c;
        font-size: 14px;
        margin-top: 5px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-actions {
        margin-top: 30px;
    }

    .btn-danger {
        background-color: #dc3545;
        color: white;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
    }

    .btn-secondary {
        background-color: #6c757d;
        color: white;
        border: none;
        padding: 10px 15px;
        cursor: pointer;
        margin-top: 10px;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // What's Included
        document.getElementById('add_include').addEventListener('click', function(e) {
            e.preventDefault();
            var container = document.getElementById('whats_include_container');
            var newItem = container.lastElementChild.cloneNode(true);
            var input = newItem.querySelector('input');
            input.value = '';
            if (!newItem.querySelector('.remove-include')) {
                var removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className = 'btn btn-danger remove-include';
                removeBtn.textContent = 'Remove';
                removeBtn.style.marginLeft = '10px';
                newItem.appendChild(removeBtn);
            }
            container.appendChild(newItem);
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-include')) {
                e.target.closest('.include-item').remove();
            }
        });

        // Requirements
        let reqIndex = {{ count(old('requirements', $service->requirements ?? [])) }};
        document.getElementById('add_requirement').addEventListener('click', function(e) {
            e.preventDefault();
            var container = document.getElementById('requirements_container');
            var newItem = container.lastElementChild.cloneNode(true);
            var currentIndex = reqIndex++;
            var titleInput = newItem.querySelector('input[placeholder="Title"]');
            var imageInput = newItem.querySelector('input[type="file"]');
            titleInput.name = 'requirements[' + currentIndex + '][title]';
            titleInput.value = '';
            imageInput.name = 'requirements[' + currentIndex + '][image]';
            // Remove current image display
            var img = newItem.querySelector('p');
            if (img) img.remove();
            // Add remove if not present
            if (!newItem.querySelector('.remove-requirement')) {
                var removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className = 'btn btn-danger remove-requirement';
                removeBtn.textContent = 'Remove';
                removeBtn.style.marginTop = '10px';
                newItem.appendChild(removeBtn);
            }
            container.appendChild(newItem);
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-requirement')) {
                e.target.closest('.requirement-item').remove();
            }
        });
    });
</script>
