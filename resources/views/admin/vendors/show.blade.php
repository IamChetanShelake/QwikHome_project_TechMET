@extends('admin.layouts.masterlayout')

@section('content')
    <div class="content-area">
        <div class="profile-container">
            <!-- Header Section -->
            <div class="profile-header">
                <div class="profile-info">
                    <div class="profile-avatar">
                        @if($vendor->image)
                            <img src="{{ asset('user_images/' . $vendor->image) }}" alt="{{ $vendor->name }}">
                        @else
                            <div class="avatar-placeholder">
                                <i class="fas fa-user"></i>
                            </div>
                        @endif
                    </div>
                    <div class="profile-details">
                        <h1 class="profile-name">{{ $vendor->name }}</h1>
                        <p class="profile-role">Vendor Account</p>
                        <div class="profile-meta">
                            <span class="meta-item">
                                <i class="fas fa-calendar"></i>
                                Joined {{ $vendor->created_at->format('M j, Y') }}
                            </span>
                            <span class="meta-item">
                                <i class="fas fa-clock"></i>
                                Last updated {{ $vendor->updated_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="profile-actions">
                    <a href="{{ route('admin.vendors.edit', $vendor->id) }}" class="action-btn primary">
                        <i class="fas fa-edit"></i>
                        <span>Edit Vendor</span>
                    </a>
                    <a href="{{ route('admin.vendors.index') }}" class="action-btn secondary">
                        <i class="fas fa-arrow-left"></i>
                        <span>Back to List</span>
                    </a>
                </div>
            </div>

            <!-- Content Grid -->
            <div class="profile-content">
                <!-- Basic Information -->
                <div class="info-card">
                    <div class="card-header">
                        <i class="fas fa-user"></i>
                        <h3>Basic Information</h3>
                    </div>
                    <div class="card-content">
                        <div class="info-row">
                            <div class="info-label">Full Name</div>
                            <div class="info-value">{{ $vendor->name }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Email Address</div>
                            <div class="info-value">
                                <a href="mailto:{{ $vendor->email }}" class="email-link">
                                    <i class="fas fa-envelope"></i>
                                    {{ $vendor->email }}
                                </a>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Account Status</div>
                            <div class="info-value">
                                <span class="status-badge active">
                                    <i class="fas fa-check-circle"></i>
                                    Active
                                </span>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Member Since</div>
                            <div class="info-value">{{ $vendor->created_at->format('F j, Y') }}</div>
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="info-card">
                    <div class="card-header">
                        <i class="fas fa-address-book"></i>
                        <h3>Contact Information</h3>
                    </div>
                    <div class="card-content">
                        <div class="info-row">
                            <div class="info-label">Phone Number</div>
                            <div class="info-value">
                                @if($vendor->phone)
                                    <a href="tel:{{ $vendor->phone }}" class="phone-link">
                                        <i class="fas fa-phone"></i>
                                        {{ $vendor->phone }}
                                    </a>
                                @else
                                    <span class="no-data">Not provided</span>
                                @endif
                            </div>
                        </div>
                        <div class="info-row full-width">
                            <div class="info-label">Address</div>
                            <div class="info-value">
                                @if($vendor->address)
                                    <div class="address-display">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <span>{{ $vendor->address }}</span>
                                    </div>
                                @else
                                    <span class="no-data">Not provided</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Account Statistics -->
                <div class="info-card">
                    <div class="card-header">
                        <i class="fas fa-chart-bar"></i>
                        <h3>Account Overview</h3>
                    </div>
                    <div class="card-content">
                        <div class="stats-grid">
                            <div class="stat-item">
                                <div class="stat-icon">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                                <div class="stat-info">
                                    <div class="stat-value">{{ $vendor->created_at->diffInDays(now()) }}</div>
                                    <div class="stat-label">Days Active</div>
                                </div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-icon">
                                    <i class="fas fa-user-shield"></i>
                                </div>
                                <div class="stat-info">
                                    <div class="stat-value">{{ $vendor->role }}</div>
                                    <div class="stat-label">User Role</div>
                                </div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-icon">
                                    <i class="fas fa-id-badge"></i>
                                </div>
                                <div class="stat-info">
                                    <div class="stat-value">#{{ $vendor->id }}</div>
                                    <div class="stat-label">User ID</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity (Placeholder) -->
                <div class="info-card full-width">
                    <div class="card-header">
                        <i class="fas fa-history"></i>
                        <h3>Recent Activity</h3>
                    </div>
                    <div class="card-content">
                        <div class="activity-list">
                            <div class="activity-item">
                                <div class="activity-icon">
                                    <i class="fas fa-user-plus"></i>
                                </div>
                                <div class="activity-content">
                                    <div class="activity-title">Account Created</div>
                                    <div class="activity-time">{{ $vendor->created_at->format('M j, Y \a\t g:i A') }}</div>
                                </div>
                            </div>
                            <div class="activity-item">
                                <div class="activity-icon">
                                    <i class="fas fa-edit"></i>
                                </div>
                                <div class="activity-content">
                                    <div class="activity-title">Profile Last Updated</div>
                                    <div class="activity-time">{{ $vendor->updated_at->format('M j, Y \a\t g:i A') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .profile-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Profile Header */
        .profile-header {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            padding: 30px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 30px;
            margin-bottom: 30px;
        }

        .profile-info {
            display: flex;
            align-items: center;
            gap: 25px;
        }

        .profile-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            overflow: hidden;
            border: 3px solid rgba(0, 212, 255, 0.3);
            box-shadow: 0 8px 25px rgba(0, 212, 255, 0.2);
        }

        .profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .avatar-placeholder {
            width: 100%;
            height: 100%;
            background: rgba(0, 212, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #00d4ff;
            font-size: 32px;
        }

        .profile-details h1 {
            color: #ffffff;
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 5px 0;
        }

        .profile-role {
            color: rgba(255, 255, 255, 0.7);
            font-size: 16px;
            margin: 0 0 15px 0;
        }

        .profile-meta {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 6px;
            color: rgba(255, 255, 255, 0.6);
            font-size: 14px;
        }

        .meta-item i {
            color: #00d4ff;
            font-size: 12px;
        }

        .profile-actions {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .action-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .action-btn.primary {
            background: linear-gradient(135deg, #00d4ff, #0099cc);
            color: white;
            box-shadow: 0 8px 25px rgba(0, 212, 255, 0.3);
        }

        .action-btn.primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(0, 212, 255, 0.4);
        }

        .action-btn.secondary {
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .action-btn.secondary:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        /* Profile Content */
        .profile-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
        }

        .info-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(15px);
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            overflow: hidden;
        }

        .card-header {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 20px 25px;
            background: rgba(255, 255, 255, 0.05);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .card-header i {
            color: #00d4ff;
            font-size: 18px;
        }

        .card-header h3 {
            color: #ffffff;
            font-size: 18px;
            font-weight: 600;
            margin: 0;
        }

        .card-content {
            padding: 25px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-row.full-width {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }

        .info-label {
            color: rgba(255, 255, 255, 0.7);
            font-size: 14px;
            font-weight: 500;
        }

        .info-value {
            color: #ffffff;
            font-size: 14px;
            font-weight: 500;
        }

        .email-link, .phone-link {
            color: #00d4ff;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.3s ease;
        }

        .email-link:hover, .phone-link:hover {
            color: #0099cc;
            transform: translateX(2px);
        }

        .no-data {
            color: rgba(255, 255, 255, 0.5);
            font-style: italic;
        }

        .address-display {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            max-width: 300px;
        }

        .address-display i {
            color: #00d4ff;
            margin-top: 2px;
            flex-shrink: 0;
        }

        /* Status Badge */
        .status-badge {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .status-badge.active {
            background: rgba(34, 197, 94, 0.1);
            color: #22c55e;
            border: 1px solid rgba(34, 197, 94, 0.3);
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 20px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #00d4ff, #0099cc);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
        }

        .stat-info {
            flex: 1;
        }

        .stat-value {
            color: #ffffff;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 2px;
        }

        .stat-label {
            color: rgba(255, 255, 255, 0.6);
            font-size: 12px;
            text-transform: uppercase;
            font-weight: 500;
            letter-spacing: 0.5px;
        }

        /* Activity List */
        .activity-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .activity-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            background: rgba(0, 212, 255, 0.1);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #00d4ff;
            font-size: 16px;
        }

        .activity-content {
            flex: 1;
        }

        .activity-title {
            color: #ffffff;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 2px;
        }

        .activity-time {
            color: rgba(255, 255, 255, 0.6);
            font-size: 12px;
        }

        /* Full Width */
        .full-width {
            grid-column: 1 / -1;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .profile-content {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .profile-container {
                padding: 10px;
            }

            .profile-header {
                padding: 20px;
                flex-direction: column;
                text-align: center;
            }

            .profile-info {
                flex-direction: column;
                gap: 20px;
            }

            .profile-actions {
                width: 100%;
            }

            .action-btn {
                flex: 1;
                justify-content: center;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .info-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 5px;
            }

            .address-display {
                max-width: 100%;
            }
        }
    </style>
@endsection
