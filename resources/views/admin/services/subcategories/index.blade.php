@extends('admin.layouts.masterlayout')

@section('title', 'Subcategories')

@section('content')
<section class="content-section active">
    <div class="section-header">
        <h2>Subcategories</h2>
        <div class="section-actions">
            <a href="{{ route('services.subcategories.create') }}" class="btn-primary">Add New Subcategory</a>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="filter-bar">
        <form method="GET" class="filter-group">
            <input type="text" name="search" value="{{ $search }}" placeholder="Search subcategories..." class="filter-input">
            <select name="category_id" class="filter-select">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ $category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
            <select name="status" class="filter-select">
                <option value="">All Status</option>
                <option value="active" {{ $status == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ $status == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
            <button type="submit" class="btn-secondary">Filter</button>
            <a href="{{ route('services.subcategories.index') }}" class="btn-secondary">Clear</a>
        </form>
    </div>

    <!-- Subcategories Table -->
    <div class="dashboard-card">
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subcategories as $subcategory)
                    <tr>
                        <td>{{ $subcategory->id }}</td>
                        <td>{{ $subcategory->name }}</td>
                        <td>{{ $subcategory->category->name }}</td>
                        <td>{{ $subcategory->description ?: '-' }}</td>
                        <td>
                            <span class="status-badge {{ $subcategory->status == 'active' ? 'completed' : 'pending' }}">
                                {{ ucfirst($subcategory->status) }}
                            </span>
                        </td>
                        <td>{{ $subcategory->created_at->format('Y-m-d') }}</td>
                        <td>
                            <a href="{{ route('services.subcategories.edit', $subcategory) }}" class="action-btn edit">Edit</a>
                            @if($subcategory->status == 'active')
                            <form method="POST" action="{{ route('services.subcategories.destroy', $subcategory) }}" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn block" onclick="return confirm('Are you sure?')">Deactivate</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">No subcategories found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        {{ $subcategories->appends(request()->query())->links() }}
    </div>
</section>
@endsection
