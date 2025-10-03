@extends('admin.layouts.masterlayout')

@section('title', 'Add Subcategory')

@section('content')
<section class="content-section active">
    <div class="section-header">
        <h2>Add New Subcategory</h2>
    </div>

    <div class="dashboard-card">
        <form method="POST" action="{{ route('services.subcategories.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="category_id">Category *</label>
                <select name="category_id" id="category_id" class="filter-select" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="name">Name *</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="filter-input" required>
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
                <label for="status">Status *</label>
                <select name="status" id="status" class="filter-select" required>
                    <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" name="image" id="image" accept="image/*">
                @error('image')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">Create Subcategory</button>
                <a href="{{ route('services.subcategories.index') }}" class="btn-secondary">Cancel</a>
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
