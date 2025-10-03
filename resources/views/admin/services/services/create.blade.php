@extends('admin.layouts.masterlayout')

@section('title', 'Add Service')

@section('content')
    <section class="content-section active p-3">
        <div class="section-header">
            <h2>Add New Service</h2>
        </div>

        <div class="dashboard-card p-3">
            <form method="POST" action="{{ route('services.services.store') }}">
                @csrf

                <div class="form-group">
                    <label for="category_id">Category *</label>
                    <select name="category_id" id="category_id" class="filter-select" required>
                        <option value="">Select Category</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
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
                            <option value="{{ $sub->id }}" {{ old('subcategory_id') == $sub->id ? 'selected' : '' }}>
                                {{ $sub->name }}</option>
                        @endforeach
                    </select>
                    @error('subcategory_id')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="name">Name *</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="filter-input"
                        required>
                    @error('name')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" class="message-textarea">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="price">Price *</label>
                    <input type="number" name="price" id="price" value="{{ old('price') }}" step="0.01"
                        min="0" class="filter-input" required>
                    @error('price')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="duration">Duration</label>
                    <input type="text" name="duration" id="duration" value="{{ old('duration') }}" class="filter-input"
                        placeholder="e.g., 2 hours">
                    @error('duration')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="status">Status *</label>
                    <select name="status" id="status" class="filter-select" required>
                        <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-primary">Create Service</button>
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
</style>
