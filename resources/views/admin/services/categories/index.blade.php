@extends('admin.layouts.masterlayout')

@section('title', 'Categories')

@section('content')
<section class="content-section active">
    <div class="section-header">
        <h2>Categories</h2>
        <div class="section-actions">
            <a href="{{ route('services.categories.create') }}" class="btn-primary">Add New Category</a>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="filter-bar">
        <form method="GET" class="filter-group">
            <input type="text" name="search" value="{{ $search }}" placeholder="Search categories..." class="filter-input">
            <select name="status" class="filter-select">
                <option value="">All Status</option>
                <option value="active" {{ $status == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ $status == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
            <button type="submit" class="btn-secondary">Filter</button>
            <a href="{{ route('services.categories.index') }}" class="btn-secondary">Clear</a>
        </form>
    </div>

    <!-- Categories Table -->
    <div class="dashboard-card">
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->description ?: '-' }}</td>
                        <td>
                            <span class="status-badge {{ $category->status == 'active' ? 'completed' : 'pending' }}">
                                {{ ucfirst($category->status) }}
                            </span>
                        </td>
                        <td>{{ $category->created_at->format('Y-m-d') }}</td>
                        <td>
                            <a href="{{ route('services.categories.edit', $category) }}" class="action-btn edit">Edit</a>
                            @if($category->status == 'active')
                            <form method="POST" action="{{ route('services.categories.destroy', $category) }}" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn block" onclick="return confirm('Are you sure?')">Deactivate</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">No categories found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        {{ $categories->appends(request()->query())->links() }}
    </div>
</section>
@endsection
