@extends('admin.layouts.masterlayout')

@section('content')
    <style>
        th,
        td {
            text-align: center;
            vertical-align: middle;
        }

        .filters-section {
            background: #333333;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .status-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
        }

        .status-warning {
            background: #ffc107;
            color: #000;
        }

        .status-info {
            background: #17a2b8;
            color: white;
        }

        .status-success {
            background: #28a745;
            color: white;
        }

        .status-danger {
            background: #dc3545;
            color: white;
        }

        .status-secondary {
            background: #6c757d;
            color: white;
        }
    </style>

    <!-- Content Area -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <span aria-hidden="true">&times;</span>
        </div>
    @endif

    <div class="content-area">
        <!-- Filters Section -->
        <div class="filters-section">
            <form method="GET" action="{{ route('complaints.index') }}">
                <div class="row">
                    <div class="col-md-2">
                        <select name="status" class="form-control">
                            <option value="">All Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="in_review" {{ request('status') == 'in_review' ? 'selected' : '' }}>In Review
                            </option>
                            <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved
                            </option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected
                            </option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="complaint_type" class="form-control">
                            <option value="">All Types</option>
                            <option value="late_delivery"
                                {{ request('complaint_type') == 'late_delivery' ? 'selected' : '' }}>Late Delivery</option>
                            <option value="poor_service"
                                {{ request('complaint_type') == 'poor_service' ? 'selected' : '' }}>Poor Service</option>
                            <option value="payment_issue"
                                {{ request('complaint_type') == 'payment_issue' ? 'selected' : '' }}>Payment Issue</option>
                            <option value="fraud" {{ request('complaint_type') == 'fraud' ? 'selected' : '' }}>Fraud
                            </option>
                            <option value="product_quality"
                                {{ request('complaint_type') == 'product_quality' ? 'selected' : '' }}>Product Quality
                            </option>
                            <option value="communication"
                                {{ request('complaint_type') == 'communication' ? 'selected' : '' }}>Communication</option>
                            <option value="other" {{ request('complaint_type') == 'other' ? 'selected' : '' }}>Other
                            </option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="user_name" class="form-control" placeholder="User Name"
                            value="{{ request('user_name') }}">
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="date_from" class="form-control" placeholder="From Date"
                            value="{{ request('date_from') }}">
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="date_to" class="form-control" placeholder="To Date"
                            value="{{ request('date_to') }}">
                    </div>
                    <div class="col-md-2">
                        <div class="d-flex gap-1">

                            <button type="submit" class="btn btn-primary">Filter</button>
                            <a href="{{ route('complaints.index') }}" class="btn btn-secondary">Clear</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Dashboard Section -->
        <section id="dashboard-section" class="content-section active">
            <div class="dashboard-card">
                <div class="card-header">
                    <h3>Complaints Management</h3>
                </div>
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th>Type</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($complaints as $complaint)
                                <tr>
                                    <td>{{ $complaint->id }}</td>
                                    <td>{{ $complaint->user->name ?? 'Unknown' }}</td>
                                    <td>{{ ucfirst(str_replace('_', ' ', $complaint->complaint_type)) }}</td>
                                    <td>{{ Str::limit($complaint->description, 50) }}</td>
                                    <td>
                                        <span class="status-badge status-{{ $complaint->getStatusBadgeClass() }}">
                                            {{ $complaint->getStatusLabel() }}
                                        </span>
                                    </td>
                                    <td>{{ $complaint->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="d-flex gap-1 justify-content-center">
                                            <a href="{{ route('complaints.view', $complaint->id) }}">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if ($complaint->status !== 'resolved' && $complaint->status !== 'rejected')
                                                <a href="{{ route('complaints.view', $complaint->id) }}#resolution">
                                                    <i class="fas fa-check"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    @if ($complaints->hasPages())
                        <div class="pagination-container mt-3">
                            {{ $complaints->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>

    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('.alert-success').fadeOut('slow');
            }, 3000);
        });
    </script>
@endsection
