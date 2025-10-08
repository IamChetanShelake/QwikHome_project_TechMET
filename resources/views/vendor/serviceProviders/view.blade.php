@extends('admin.layouts.masterlayout')

@section('content')
    <style>
        /* Service Provider View Styling */
        .service-view-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }

        .service-header-section {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 30px;
        }

        .service-header-content {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .service-header-with-avatar {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .service-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 3px solid rgba(0, 212, 255, 0.5);
            box-shadow: 0 8px 25px rgba(0, 212, 255, 0.2);
            overflow: hidden;
            flex-shrink: 0;
        }

        .service-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .service-avatar.no-image {
            background: linear-gradient(135deg, #00d4ff, #0099cc);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 32px;
        }

        .service-icon-wrapper {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #00d4ff, #0099cc);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
            box-shadow: 0 8px 25px rgba(0, 212, 255, 0.3);
        }

        .service-title {
            font-size: 28px;
            font-weight: 700;
            color: #ffffff;
            margin: 0 0 5px 0;
        }

        .service-subtitle {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.7);
            margin: 0 0 10px 0;
        }

        .service-badges,
        .status-badge,
        .language-badge,
        .role-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .service-badges {
            gap: 10px;
            flex-wrap: wrap;
        }

        .status-badge.status-active {
            background: rgba(34, 197, 94, 0.2);
            color: #22c55e;
            border: 1px solid rgba(34, 197, 94, 0.3);
        }

        .role-badge {
            background: rgba(168, 85, 247, 0.2);
            color: #a855f7;
            border: 1px solid rgba(168, 85, 247, 0.3);
        }

        .service-header-actions {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .modern-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .modern-btn-primary {
            background: linear-gradient(135deg, #00d4ff, #0099cc);
            color: white;
            box-shadow: 0 8px 25px rgba(0, 212, 255, 0.3);
        }

        .modern-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(0, 212, 255, 0.4);
            color: white;
        }

        .modern-btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        .modern-btn-secondary:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: #00d4ff;
            color: #00d4ff;
            transform: translateY(-2px);
        }

        /* Detail Cards */
        .service-details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .detail-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            overflow: hidden;
        }

        .card-header {
            background: rgba(0, 212, 255, 0.1);
            padding: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-header i {
            color: #00d4ff;
            font-size: 18px;
        }

        .card-header h3 {
            margin: 0;
            font-size: 16px;
            font-weight: 600;
            color: #ffffff;
        }

        .card-content {
            padding: 20px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-weight: 600;
            color: rgba(255, 255, 255, 0.8);
        }

        .detail-value {
            color: #ffffff;
            text-align: right;
            word-break: break-word;
        }

        .address-value {
            text-align: left !important;
            max-width: 70%;
            line-height: 1.4;
        }

        .service-image-container {
            text-align: center;
        }

        .service-image {
            max-width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
        }

        .no-image-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 40px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            border: 2px dashed rgba(255, 255, 255, 0.2);
            color: rgba(255, 255, 255, 0.6);
            font-size: 14px;
        }

        .no-image-container i {
            font-size: 24px;
            color: #00d4ff;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .service-view-container {
                padding: 15px;
            }

            .service-header-section {
                padding: 20px;
                flex-direction: column;
                text-align: center;
            }

            .service-header-content {
                flex-direction: column;
                text-align: center;
            }

            .service-details-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
    <div class="service-view-container">
        <!-- Header Section -->
        <div class="service-header-section">
            <div class="service-header-content">
                <div class="service-header-with-avatar">
                    <div class="service-avatar">
                        @if ($serviceProvider->image)
                            <img src="{{ asset('user_images/' . $serviceProvider->image) }}"
                                alt="{{ $serviceProvider->name }}">
                        @else
                            <div class="no-image">
                                <i class="fas fa-user"></i>
                            </div>
                        @endif
                    </div>
                    <div class="service-header-text">
                        <h1 class="service-title">{{ $serviceProvider->name }}</h1>
                        <p class="service-subtitle">Service Provider & Employee Information</p>
                        <div class="service-badges">
                            @if ($serviceProvider->role)
                                <span class="role-badge role-{{ strtolower($serviceProvider->role) }}">
                                    <i class="fas fa-briefcase"></i>
                                    {{ ucfirst($serviceProvider->role) }}
                                </span>
                            @endif
                            @if ($serviceProvider->email)
                                <span class="status-badge status-active">
                                    <i class="fas fa-circle"></i>
                                    Active Provider
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="service-header-actions">
                <a href="{{ route('serviceProviders.edit', $serviceProvider->id) }}" class="modern-btn modern-btn-primary">
                    <i class="fas fa-edit"></i>
                    Edit Provider
                </a>
                <a href="{{ route('serviceProviders.index') }}" class="modern-btn modern-btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Back to Providers
                </a>
            </div>
        </div>

        <!-- Service Details Grid -->
        <div class="service-details-grid">

            <!-- Basic Information Card -->
            <div class="detail-card">
                <div class="card-header">
                    <i class="fas fa-user"></i>
                    <h3>Basic Information</h3>
                </div>
                <div class="card-content">
                    <div class="detail-row">
                        <span class="detail-label">Full Name:</span>
                        <span class="detail-value">{{ $serviceProvider->name }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Email:</span>
                        <span class="detail-value">{{ $serviceProvider->email ?? 'Not provided' }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Phone:</span>
                        <span class="detail-value">{{ $serviceProvider->phone ?? 'Not provided' }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Role:</span>
                        <span class="detail-value">{{ ucfirst($serviceProvider->role ?? 'serviceprovider') }}</span>
                    </div>
                </div>
            </div>

            <!-- Contact Information Card -->
            <div class="detail-card">
                <div class="card-header">
                    <i class="fas fa-address-book"></i>
                    <h3>Contact Information</h3>
                </div>
                <div class="card-content">
                    <div class="detail-row">
                        <span class="detail-label">Address:</span>
                        <div class="detail-value address-value">
                            {{ $serviceProvider->address ?? 'Not provided' }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Account Information Card -->
            <div class="detail-card">
                <div class="card-header">
                    <i class="fas fa-calendar"></i>
                    <h3>Account Information</h3>
                </div>
                <div class="card-content">
                    <div class="detail-row">
                        <span class="detail-label">Account Created:</span>
                        <span class="detail-value">{{ $serviceProvider->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Last Updated:</span>
                        <span class="detail-value">{{ $serviceProvider->updated_at->format('M d, Y') }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Member Since:</span>
                        <span class="detail-value">{{ $serviceProvider->created_at->format('F Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Profile Image Card -->
            {{-- <div class="detail-card">
                <div class="card-header">
                    <i class="fas fa-image"></i>
                    <h3>Profile Image</h3>
                </div>
                <div class="card-content">
                    <div class="service-image-container">
                        @if ($serviceProvider->image)
                            <img src="{{ asset('user_images/' . $serviceProvider->image) }}"
                                alt="{{ $serviceProvider->name }}" class="service-image">
                        @else
                            <div class="no-image-container">
                                <i class="fas fa-user"></i>
                                <span>No image available</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div> --}}

        </div>
    </div>
@endsection
