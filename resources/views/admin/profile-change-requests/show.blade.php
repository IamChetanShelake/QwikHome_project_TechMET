@extends('admin.layouts.masterlayout')

@section('title', 'Profile Change Request Details')

@section('content')
    <style>
        /* Modern Profile Change Request Show Styling */
        .show-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .alert-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }

        .header-section {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            border: 1px solid rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .header-content {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 20px;
        }

        .header-icon-wrapper {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #8b5cf6, #7c3aed);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
            box-shadow: 0 8px 25px rgba(139, 92, 246, 0.3);
        }

        .header-title {
            font-size: 28px;
            font-weight: 700;
            color: #334155;
            margin: 0;
        }

        .header-subtitle {
            font-size: 14px;
            color: rgba(51, 65, 85, 0.8);
            margin: 5px 0 0 0;
        }

        .request-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .info-card {
            background: rgba(255, 255, 255, 0.8);
            border-radius: 15px;
            padding: 20px;
            border: 1px solid rgba(0, 0, 0, 0.1);
        }

        .info-label {
            font-size: 12px;
            font-weight: 600;
            color: #8b5cf6;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }

        .info-value {
            font-size: 16px;
            color: #334155;
            font-weight: 500;
        }

        .provider-section {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(15px);
            border-radius: 15px;
            border: 1px solid rgba(0, 0, 0, 0.1);
            padding: 25px;
            margin-bottom: 20px;
        }

        .provider-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .provider-image {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            object-fit: cover;
            border: 3px solid rgba(139, 92, 246, 0.3);
        }

        .provider-placeholder {
            width: 60px;
            height: 60px;
            background: rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(0, 0, 0, 0.5);
            font-size: 24px;
        }

        .provider-details h3 {
            font-size: 20px;
            font-weight: 600;
            color: #334155;
            margin: 0 0 5px 0;
        }

        .provider-meta {
            color: rgba(51, 65, 85, 0.8);
            font-size: 14px;
        }

        .changes-section {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(15px);
            border-radius: 15px;
            border: 1px solid rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-bottom: 20px;
        }

        .changes-header {
            padding: 25px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .changes-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 18px;
            font-weight: 600;
            color: #334155;
            margin: 0;
        }

        .bulk-actions {
            display: flex;
            gap: 10px;
        }

        .bulk-btn {
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .approve-all-btn {
            background: rgba(34, 197, 94, 0.2);
            color: #22c55e;
        }

        .approve-all-btn:hover {
            background: rgba(34, 197, 94, 0.3);
            transform: translateY(-2px);
        }

        .reject-all-btn {
            background: rgba(239, 68, 68, 0.2);
            color: #ef4444;
        }

        .reject-all-btn:hover {
            background: rgba(239, 68, 68, 0.3);
            transform: translateY(-2px);
        }

        .change-item {
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .change-item:last-child {
            border-bottom: none;
        }

        .change-content {
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .change-details {
            flex: 1;
        }

        .change-field {
            font-size: 16px;
            font-weight: 600;
            color: #8b5cf6;
            margin-bottom: 8px;
        }

        .change-comparison {
            display: flex;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .change-value {
            flex: 1;
            min-width: 200px;
        }

        .change-label {
            font-size: 12px;
            font-weight: 600;
            color: rgba(51, 65, 85, 0.7);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .change-text {
            font-size: 14px;
            color: #334155;
            padding: 8px 12px;
            background: rgba(0, 0, 0, 0.05);
            border-radius: 6px;
            word-break: break-word;
        }

        .change-arrow {
            color: #8b5cf6;
            font-size: 18px;
        }

        .change-actions {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .field-action-btn {
            padding: 8px 16px;
            border-radius: 6px;
            border: none;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .approve-field-btn {
            background: rgba(34, 197, 94, 0.2);
            color: #22c55e;
        }

        .approve-field-btn:hover {
            background: rgba(34, 197, 94, 0.3);
            transform: translateY(-2px);
        }

        .reject-field-btn {
            background: rgba(239, 68, 68, 0.2);
            color: #ef4444;
        }

        .reject-field-btn:hover {
            background: rgba(239, 68, 68, 0.3);
            transform: translateY(-2px);
        }

        .status-indicator {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-approved {
            background: rgba(34, 197, 94, 0.2);
            color: #22c55e;
        }

        .status-rejected {
            background: rgba(239, 68, 68, 0.2);
            color: #ef4444;
        }

        .status-pending {
            background: rgba(251, 191, 36, 0.2);
            color: #d97706;
        }

        .actions-section {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(15px);
            border-radius: 15px;
            border: 1px solid rgba(0, 0, 0, 0.1);
            padding: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .back-btn {
            padding: 12px 24px;
            background: rgba(139, 92, 246, 0.1);
            color: #8b5cf6;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .back-btn:hover {
            background: rgba(139, 92, 246, 0.2);
            transform: translateY(-2px);
        }

        .final-actions {
            display: flex;
            gap: 10px;
        }

        .final-approve-btn {
            padding: 12px 24px;
            background: rgba(34, 197, 94, 0.2);
            color: #22c55e;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .final-approve-btn:hover {
            background: rgba(34, 197, 94, 0.3);
            transform: translateY(-2px);
        }

        .final-reject-btn {
            padding: 12px 24px;
            background: rgba(239, 68, 68, 0.2);
            color: #ef4444;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .final-reject-btn:hover {
            background: rgba(239, 68, 68, 0.3);
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .change-content {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .change-actions {
                width: 100%;
                justify-content: flex-end;
            }

            .bulk-actions {
                flex-direction: column;
                width: 100%;
            }

            .bulk-btn {
                width: 100%;
                justify-content: center;
            }

            .final-actions {
                flex-direction: column;
                width: 100%;
            }

            .final-approve-btn,
            .final-reject-btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>

    <div class="show-container">
        <!-- Alert System -->
        <div id="alertContainer" class="alert-container">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
        </div>

        <!-- Header Section -->
        <div class="header-section">
            <div class="header-content">
                <div class="header-icon-wrapper">
                    <i class="fas fa-user-edit"></i>
                </div>
                <div class="header-text">
                    <h1 class="header-title">Profile Change Request #{{ $request->id }}</h1>
                    <p class="header-subtitle">Review individual field changes for approval</p>
                </div>
            </div>

            <div class="request-info">
                <div class="info-card">
                    <div class="info-label">Submitted</div>
                    <div class="info-value">{{ $request->created_at->format('M d, Y \a\t H:i') }}</div>
                </div>
                <div class="info-card">
                    <div class="info-label">Reason</div>
                    <div class="info-value">{{ $request->reason ?: 'No reason provided' }}</div>
                </div>
                <div class="info-card">
                    <div class="info-label">Status</div>
                    <div class="info-value">
                        <span class="status-indicator status-{{ $request->status }}">
                            {{ ucfirst($request->status) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Provider Section -->
        <div class="provider-section">
            <div class="provider-header">
                @if ($request->serviceProvider->image)
               
                    <img src="{{ $request->serviceProvider->image_url }}"
                        alt="{{ $request->serviceProvider->name }}" class="provider-image">
                @else
              
                    <div class="provider-placeholder">
                        <i class="fas fa-user"></i>
                    </div>
                @endif
                <div class="provider-details">
                    <h3>{{ $request->serviceProvider->name }}</h3>
                    <div class="provider-meta">
                        <div>{{ $request->serviceProvider->email }}</div>
                        <div>{{ $request->serviceProvider->phone ?: 'No phone' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Changes Section -->
        <div class="changes-section">
            <div class="changes-header">
                <h3 class="changes-title">
                    <i class="fas fa-exchange-alt"></i>
                    Requested Changes
                </h3>
                <div class="bulk-actions">
                    <form method="POST" action="{{ route('admin.profile-change-requests.approve-all', $request->id) }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="bulk-btn approve-all-btn"
                            onclick="return confirm('Are you sure you want to approve all changes?')">
                            <i class="fas fa-check-double"></i>
                            Approve All
                        </button>
                    </form>
                    <form method="POST" action="{{ route('admin.profile-change-requests.reject-all', $request->id) }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="bulk-btn reject-all-btn"
                            onclick="return confirm('Are you sure you want to reject all changes?')">
                            <i class="fas fa-times-circle"></i>
                            Reject All
                        </button>
                    </form>
                </div>
            </div>

            @php
                $changes = $request->requested_data;
                $changeFields = [
                    'name' => 'Name',
                    'email' => 'Email',
                    'phone' => 'Phone',
                    'alternatePhone' => 'Alternate Phone',
                    'biography' => 'Biography',
                    'address' => 'Address',
                    'profileImage' => 'Profile Image'
                ];
               
            @endphp

            @foreach($changeFields as $field => $label)
                    
                @if(isset($changes[$field]))
                    <div class="change-item">
                        <div class="change-content">
                            <div class="change-details">
                                <div class="change-field">{{ $label }}</div>
                                <div class="change-comparison">
                                    <div class="change-value">
                                        <div class="change-label">Current</div>
                                        <div class="change-text">
                                            @if($field == 'profileImage')
                                                @if($request->serviceProvider->image)
                                                    <img src="{{ $request->serviceProvider->image_url }}"
                                                        alt="Current image" style="max-width: 100px; max-height: 100px; border-radius: 4px;">
                                                @else
                                                    No image
                                                @endif
                                            @else
                                                {{ $request->serviceProvider->{$field} ?: 'Not set' }}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="change-arrow">
                                        <i class="fas fa-arrow-right"></i>
                                    </div>
                                    <div class="change-value">
                                        <div class="change-label">Requested</div>
                                        <div class="change-text">
                                            @if($field === 'profileImage')
                                                @if(isset($changes[$field]) && $changes[$field])
                                                    <img src="{{ asset('user_images/' . $changes[$field]) }}"
                                                        alt="New image" style="max-width: 100px; max-height: 100px; border-radius: 4px;">
                                                @else
                                                    No image
                                                @endif
                                            @else
                                                {{ $changes[$field] ?: 'Not set' }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="change-actions">
                                <form method="POST" action="{{ route('admin.profile-change-requests.approve-field', [$request->id, $field]) }}" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="field-action-btn approve-field-btn">
                                        <i class="fas fa-check"></i>
                                        Approve
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.profile-change-requests.reject-field', [$request->id, $field]) }}" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="field-action-btn reject-field-btn">
                                        <i class="fas fa-times"></i>
                                        Reject
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <!-- Actions Section -->
        <div class="actions-section">
            <a href="{{ route('admin.profile-change-requests.index') }}" class="back-btn">
                <i class="fas fa-arrow-left"></i>
                Back to Requests
            </a>

            <div class="final-actions">
                <form method="POST" action="{{ route('admin.profile-change-requests.approve', $request->id) }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="final-approve-btn"
                        onclick="return confirm('Are you sure you want to approve all remaining changes?')">
                        <i class="fas fa-check-circle"></i>
                        Final Approve
                    </button>
                </form>

                <form method="POST" action="{{ route('admin.profile-change-requests.reject', $request->id) }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="final-reject-btn"
                        onclick="return confirm('Are you sure you want to reject this request?')">
                        <i class="fas fa-times-circle"></i>
                        Reject Request
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
@endsection
