@extends('admin.layouts.masterlayout')



@section('content')
    <section class="content-section active p-3">
        <style>
            .tabs {
                margin-bottom: 20px;
            }



            .tab-link {
                display: inline-block;
                padding: 10px 20px;
                margin-right: 5px;
                background: #f8f9fa;
                border: 1px solid #dee2e6;
                border-radius: 4px 4px 0 0;
                color: #007bff;
                text-decoration: none;
            }

            .tab-link.active {
                background: #007bff;
                color: white;
                border-bottom-color: white;
            }

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
        <div class="section-header">
            <h2>Service Management</h2>
            <div class="section-actions m-3">
                <a href="{{ route('services.services.create') }}" class="btn-primary">Add New Service</a>
            </div>
        </div>



        <!-- Search and Filter -->
        <div class="filter-bar">
            <form method="GET" class="filter-group">
                <input type="text" name="search" value="{{ $search }}" placeholder="Search services..."
                    class="filter-input">
                <select name="category_id" class="filter-select">
                    <option value="">All Categories</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $category_id == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}</option>
                    @endforeach
                </select>
                <select name="subcategory_id" class="filter-select">
                    <option value="">All Subcategories</option>
                    @foreach ($subcategories as $sub)
                        <option value="{{ $sub->id }}" {{ $subcategory_id == $sub->id ? 'selected' : '' }}>
                            {{ $sub->name }}</option>
                    @endforeach
                </select>
                <select name="status" class="filter-select">
                    <option value="">All Status</option>
                    <option value="active" {{ $status == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ $status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                <button type="submit" class="btn-secondary">Filter</button>
                <a href="{{ route('services.services.index') }}" class="btn-secondary">Clear</a>
            </form>
        </div>

        <!-- Services Table -->
        <div class="dashboard-card">
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Subcategory</th>
                            <th>Price</th>
                            <th>Duration</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($services as $service)
                            <tr>
                                <td>{{ $service->id }}</td>
                                <td>{{ $service->name }}</td>
                                <td>{{ $service->category->name }}</td>
                                <td>{{ $service->subcategory ? $service->subcategory->name : '-' }}</td>
                                <td>₹{{ number_format($service->price, 2) }}</td>
                                <td>{{ $service->duration ?: '-' }}</td>
                                <td>
                                    <span
                                        class="status-badge {{ $service->status == 'active' ? 'completed' : 'pending' }}">
                                        {{ ucfirst($service->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('services.services.edit', $service) }}"
                                            class="action-btn edit">Edit</a>
                                        <form method="POST" action="{{ route('services.services.destroy', $service) }}"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn block"
                                                onclick="return confirm('Are you sure you want to delete this service?')">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">No services found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            {{ $services->appends(request()->query())->links() }}
        </div>
    </section>
@endsection
