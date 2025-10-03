@extends('admin.layouts.masterlayout')

@section('content')
    <div class="content-area">
        <!-- Flash Messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="row">
            <!-- Back Button -->
            <div class="col-12 mb-3">
                <a href="{{ route('complaints.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Complaints
                </a>
            </div>
        </div>

        <div class="row">
            <!-- Complaint Details -->
            <div class="col-lg-8">
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3>Complaint Details #{{ $complaint->id }}</h3>
                        <span class="status-badge status-{{ $complaint->getStatusBadgeClass() }}">
                            {{ $complaint->getStatusLabel() }}
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5><strong>User Information</strong></h5>
                                <p><strong>Name:</strong> {{ $complaint->user->name ?? 'Unknown' }}</p>
                                <p><strong>Email:</strong> {{ $complaint->user->email ?? 'N/A' }}</p>
                                <p><strong>Complainant Type:</strong> {{ ucfirst(str_replace('_', ' ', $complaint->complainant_type)) }}</p>
                            </div>
                            <div class="col-md-6">
                                <h5><strong>Complaint Information</strong></h5>
                                <p><strong>Type:</strong> {{ ucfirst(str_replace('_', ' ', $complaint->complaint_type)) }}</p>
                                <p><strong>Order ID:</strong> {{ $complaint->order_id ?? 'N/A' }}</p>
                                <p><strong>Submitted:</strong> {{ $complaint->created_at->format('d/m/Y H:i') }}</p>
                                @if($complaint->resolved_at)
                                    <p><strong>Resolved:</strong> {{ $complaint->resolved_at->format('d/m/Y H:i') }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <h5><strong>Description</strong></h5>
                                <p>{{ $complaint->description }}</p>
                            </div>
                        </div>

                        @if($complaint->attachment_path)
                        <div class="row mt-4">
                            <div class="col-12">
                                <h5><strong>Attachment</strong></h5>
                                <p><a href="{{ asset('storage/' . $complaint->attachment_path) }}" target="_blank" class="btn btn-sm btn-info">
                                    <i class="fas fa-download"></i> {{ $complaint->original_filename }}
                                </a></p>
                            </div>
                        </div>
                        @endif

                        @if($complaint->resolution_details)
                        <div class="row mt-4">
                            <div class="col-12">
                                <h5><strong>Resolution Details</strong></h5>
                                <p><strong>Action Taken:</strong> {{ ucfirst(str_replace('_', ' ', $complaint->resolution_action ?? '')) }}</p>
                                <p>{{ $complaint->resolution_details }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Action Panel -->
            <div class="col-lg-4">
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3>Actions</h3>
                    </div>
                    <div class="card-body">
                        <!-- Status Update -->
                        @if($complaint->status !== 'resolved' && $complaint->status !== 'rejected')
                        <div class="mb-4">
                            <h5>Update Status</h5>
                            <form method="POST" action="{{ route('complaints.updateStatus', $complaint->id) }}">
                                @csrf
                                <div class="form-group">
                                    <select name="status" class="form-control" required>
                                        <option value="{{ $complaint->status }}" selected>{{ $complaint->getStatusLabel() }}</option>
                                        <option value="pending">Pending</option>
                                        <option value="in_review">In Review</option>
                                        <option value="resolved">Resolved</option>
                                        <option value="rejected">Rejected</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm">Update Status</button>
                            </form>
                        </div>
                        @endif

                        <!-- Assign Admin -->
                        @if(!$complaint->assigned_admin_id)
                        <div class="mb-4">
                            <h5>Assign Admin</h5>
                            <form method="POST" action="{{ route('complaints.assignAdmin', $complaint->id) }}">
                                @csrf
                                <div class="form-group">
                                    <select name="assigned_admin_id" class="form-control" required>
                                        <option value="">Select Admin</option>
                                        @foreach($admins as $admin)
                                            <option value="{{ $admin->id }}">{{ $admin->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-info btn-sm">Assign Admin</button>
                            </form>
                        </div>
                        @else
                        <div class="mb-4">
                            <h5>Assigned Admin</h5>
                            <p><strong>{{ $complaint->assignedAdmin->name ?? 'Unknown' }}</strong></p>
                        </div>
                        @endif

                        <!-- Admin Notes -->
                        <div class="mb-4">
                            <h5>Admin Notes</h5>
                            <form method="POST" action="{{ route('complaints.updateNotes', $complaint->id) }}">
                                @csrf
                                <div class="form-group">
                                    <textarea name="admin_notes" class="form-control" rows="4" placeholder="Internal notes...">{{ $complaint->admin_notes }}</textarea>
                                </div>
                                <button type="submit" class="btn btn-warning btn-sm">Update Notes</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Resolution Section -->
                @if($complaint->status !== 'resolved' && $complaint->status !== 'rejected')
                <div class="dashboard-card mt-3" id="resolution">
                    <div class="card-header">
                        <h3>Resolve Complaint</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('complaints.resolveComplaint', $complaint->id) }}">
                            @csrf
                            <div class="form-group">
                                <label>Resolution Action</label>
                                <select name="resolution_action" class="form-control" required>
                                    <option value="">Select Action</option>
                                    <option value="refund">Refund</option>
                                    <option value="replacement">Replacement</option>
                                    <option value="account_blocked">Account Blocked</option>
                                    <option value="warning">Warning issued</option>
                                    <option value="none">No action taken</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Resolution Details</label>
                                <textarea name="resolution_details" class="form-control" rows="4" required placeholder="Detail the resolution steps taken..."></textarea>
                            </div>
                            <div class="form-group">
                                <label>Internal Notes</label>
                                <textarea name="admin_notes" class="form-control" rows="3" placeholder="Internal notes for reference...">{{ $complaint->admin_notes }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-success">Mark as Resolved</button>
                        </form>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Auto-hide alerts
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 3000);
        });
    </script>
@endsection
