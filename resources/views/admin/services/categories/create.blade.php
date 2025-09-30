@extends('admin.layouts.masterlayout')

@section('title', 'Add Category')

@section('content')
<section class="content-section active">
    <div class="section-header">
        <h2>Add New Category</h2>
    </div>

    <div class="dashboard-card">
        <form method="POST" action="{{ route('services.categories.store') }}">
            @csrf

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

            <div class="form-actions">
                <button type="submit" class="btn-primary">Create Category</button>
                <a href="{{ route('services.categories.index') }}" class="btn-secondary">Cancel</a>
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
