@extends('admin.layouts.masterlayout')

@section('title', 'Vendor Details')

@section('content')
    <style>
        /* Modern View Styles */
        .modern-view-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Vendor Profile Section */
        .vendor-profile-section {
            display: flex;
            align-items: center;
            gap: 25px;
            background: rgba(0, 0, 0, 0.02);
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            border: 1px solid rgba(0, 0, 0, 0.1);
        }

        .vendor-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            overflow: hidden;
            border: 3px solid rgba(0, 212, 255, 0.3);
            box-shadow: 0 8px 25px rgba(0, 212, 255, 0.2);
        }

        .vendor-avatar-img {
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
            font-size: 40px;
        }

        .vendor-info {
            flex: 1;
        }

        .vendor-name {
            color: #334155;
            font-size: 32px;
            font-weight: 700;
            margin: 0 0 5px 0;
        }

        .vendor-role {
            color: rgba(51, 65, 85, 0.7);
            font-size: 16px;
            margin: 0;
        }

        /* Header Styles */
        .view-header-section {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 20px 20px 0 0;
            padding: 30px;
            border: 1px solid rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .view-header-content {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .header-icon-wrapper {
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

        .header-title {
            font-size: 28px;
            font-weight: 700;
            color: #334155;
            margin: 0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header-subtitle {
            font-size: 14px;
            color: rgba(51, 65, 85, 0.8);
            margin: 5px 0 0 0;
        }

        .header-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        /* Content Styles */
        .modern-view-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(15px);
            border-radius: 0 0 20px 20px;
            padding: 40px;
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-top: none;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }

        .info-item {
            background: rgba(0, 0, 0, 0.02);
            border-radius: 12px;
            padding: 20px;
            border: 1px solid rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .info-item:hover {
            background: rgba(0, 0, 0, 0.04);
            transform: translateY(-2px);
        }

        .info-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 600;
            color: rgba(51, 65, 85, 0.7);
            margin-bottom: 12px;
        }

        .info-label i {
            color: #00d4ff;
        }

        .info-value {
            font-size: 16px;
            font-weight: 500;
            color: #334155;
        }

        .text-primary {
            color: #00d4ff;
        }

        .text-muted {
            color: rgba(51, 65, 85, 0.5);
            font-style: italic;
        }

        /* Links */
        .email-link,
        .phone-link,
        .document-link {
            color: #00d4ff;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .email-link:hover,
        .phone-link:hover,
        .document-link:hover {
            color: #0099cc;
            transform: translateX(2px);
        }

        /* Status Badge */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
        }

        .status-active {
            background: rgba(34, 197, 94, 0.1);
            color: #22c55e;
            border: 1px solid rgba(34, 197, 94, 0.3);
        }

        /* Date Display */
        .date-display {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .date-display i {
            color: #00d4ff;
            font-size: 14px;
        }

        /* Description Section */
        .description-section {
            background: rgba(0, 0, 0, 0.02);
            border-radius: 12px;
            padding: 24px;
            border: 1px solid rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .section-header {
            margin-bottom: 16px;
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 18px;
            font-weight: 600;
            color: #334155;
            margin: 0;
        }

        .section-title i {
            color: #00d4ff;
        }

        .description-content p {
            color: rgba(51, 65, 85, 0.8);
            line-height: 1.6;
            margin: 0;
        }

        /* Additional Info Section */
        .additional-info {
            margin-top: 40px;
        }

        .info-section {
            background: rgba(0, 0, 0, 0.02);
            border-radius: 12px;
            padding: 24px;
            border: 1px solid rgba(0, 0, 0, 0.1);
        }

        .info-section:first-child {
            margin-top: 0;
        }

        .section-content {
            display: grid;
            gap: 12px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-key {
            font-weight: 500;
            color: rgba(51, 65, 85, 0.7);
        }

        .info-val {
            font-weight: 600;
            color: #334155;
            text-align: right;
            max-width: 60%;
        }

        /* Payment Type Badges */
        .payment-type-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .payment-type-badge.fixed_rate {
            background: rgba(0, 100, 255, 0.1);
            color: #0064ff;
            border: 1px solid rgba(0, 100, 255, 0.3);
        }

        .payment-type-badge.commission {
            background: rgba(255, 165, 0, 0.1);
            color: #ffa500;
            border: 1px solid rgba(255, 165, 0, 0.3);
        }

        .payment-type-badge.revenue_share {
            background: rgba(46, 204, 113, 0.1);
            color: #2ecc71;
            border: 1px solid rgba(46, 204, 113, 0.3);
        }

        .fixed-rate-value,
        .commission-rate-value,
        .revenue-share-value {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 8px;
            background: rgba(0, 212, 255, 0.1);
            border: 1px solid rgba(0, 212, 255, 0.3);
            border-radius: 6px;
            color: #00d4ff;
        }

        /* Services List Styles */
        .services-list {
            display: grid;
            gap: 20px;
            margin-top: 15px;
        }

        .service-payment-card {
            background: rgba(0, 0, 0, 0.02);
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            padding: 20px;
            transition: all 0.3s ease;
        }

        .service-payment-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .service-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }

        .service-name {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #334155;
            font-size: 16px;
            font-weight: 600;
            margin: 0;
        }

        .service-name i {
            color: #00d4ff;
        }

        .service-category-badge {
            padding: 4px 12px;
            background: rgba(0, 212, 255, 0.1);
            border: 1px solid rgba(0, 212, 255, 0.3);
            border-radius: 20px;
            font-size: 11px;
            font-weight: 500;
            color: #00d4ff;
        }

        .payment-details {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .payment-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .payment-label {
            font-size: 13px;
            color: rgba(51, 65, 85, 0.7);
            font-weight: 500;
        }

        .payment-value {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-weight: 600;
            font-size: 14px;
        }

        .no-services {
            text-align: center;
            padding: 40px 20px;
            color: rgba(51, 65, 85, 0.6);
        }

        .no-services i {
            font-size: 48px;
            margin-bottom: 15px;
            opacity: 0.5;
        }

        .no-services p {
            margin: 0;
            font-size: 14px;
        }

        /* Button Styles */
        .modern-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 14px 28px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .modern-btn-primary {
            background: linear-gradient(135deg, #00d4ff, #0099cc);
            color: white;
            box-shadow: 0 8px 25px rgba(0, 212, 255, 0.3);
        }

        .modern-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(0, 212, 255, 0.4);
        }

        .modern-btn-secondary {
            background: rgba(0, 0, 0, 0.1);
            color: #334155;
            border: 2px solid rgba(0, 0, 0, 0.2);
        }

        .modern-btn-secondary:hover {
            background: rgba(0, 0, 0, 0.15);
            border-color: #00d4ff;
            color: #00d4ff;
            transform: translateY(-2px);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .modern-view-container {
                padding: 10px;
            }

            .view-header-section,
            .modern-view-card {
                padding: 20px;
            }

            .view-header-content {
                flex-direction: column;
                align-items: flex-start;
            }

            .view-actions {
                width: 100%;
                justify-content: stretch;
            }

            .modern-btn {
                flex: 1;
                justify-content: center;
            }

            .info-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .info-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }

            .info-val {
                max-width: 100%;
                text-align: left;
            }

            /* Vendor Profile Responsive */
            .vendor-profile-section {
                flex-direction: column;
                text-align: center;
                padding: 20px;
            }

            .vendor-avatar {
                width: 80px;
                height: 80px;
            }

            .vendor-name {
                font-size: 24px;
            }
        }
    </style>
    <div class="modern-view-container">
        <!-- Header Section -->
        <div class="view-header-section">
            <div class="view-header-content">
                <div class="header-icon-wrapper">
                    <i class="fas fa-user-tie"></i>
                </div>
                <div class="header-text">
                    <h1 class="header-title">Vendor Details</h1>
                    <p class="header-subtitle">Complete information about this vendor account</p>
                </div>
            </div>
            <div class="header-actions">
                <a href="{{ route('admin.vendors.edit', $vendor->id) }}" class="modern-btn modern-btn-primary">
                    <i class="fas fa-edit"></i>
                    Edit Vendor
                </a>
                <a href="{{ route('admin.vendors.index') }}" class="modern-btn modern-btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Back to List
                </a>
            </div>
        </div>

            <!-- Content Section -->
            <div class="modern-view-card">
                <div class="view-content">
                    <!-- Vendor Profile Section -->
                    <div class="vendor-profile-section">
                        <div class="vendor-avatar">
                            @if ($vendor->image)
                                <img src="{{ asset('user_images/' . $vendor->image) }}" alt="{{ $vendor->name }}" class="vendor-avatar-img">
                            @else
                                <div class="avatar-placeholder">
                                    <i class="fas fa-user"></i>
                                </div>
                            @endif
                        </div>
                        <div class="vendor-info">
                            <h2 class="vendor-name">{{ $vendor->name }}</h2>
                            <p class="vendor-role">Vendor Account</p>
                        </div>
                    </div>

                    <!-- Main Info Grid -->
                    <div class="info-grid">
                        <!-- Vendor Name -->
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-user"></i>
                                <span>Vendor Name</span>
                            </div>
                            <div class="info-value">
                                <span class="text-primary">{{ $vendor->name }}</span>
                            </div>
                        </div>

                        <!-- Email Address -->
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-envelope"></i>
                                <span>Email Address</span>
                            </div>
                            <div class="info-value">
                                <a href="mailto:{{ $vendor->email }}" class="email-link">
                                    <i class="fas fa-external-link-alt"></i>
                                    {{ $vendor->email }}
                                </a>
                            </div>
                        </div>

                        <!-- Phone Number -->
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-phone"></i>
                                <span>Phone Number</span>
                            </div>
                            <div class="info-value">
                                @if($vendor->phone)
                                    <a href="tel:{{ $vendor->phone }}" class="phone-link">
                                        <i class="fas fa-external-link-alt"></i>
                                        {{ $vendor->phone }}
                                    </a>
                                @else
                                    <span class="text-muted">Not provided</span>
                                @endif
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-toggle-on"></i>
                                <span>Status</span>
                            </div>
                            <div class="info-value">
                                <span class="status-badge status-active">
                                    <i class="fas fa-check-circle"></i>
                                    Active
                                </span>
                            </div>
                        </div>

                        <!-- Member Since -->
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-calendar-plus"></i>
                                <span>Member Since</span>
                            </div>
                            <div class="info-value">
                                <div class="date-display">
                                    <i class="fas fa-calendar"></i>
                                    <span>{{ $vendor->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Last Updated -->
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-edit"></i>
                                <span>Last Updated</span>
                            </div>
                            <div class="info-value">
                                <div class="date-display">
                                    <i class="fas fa-calendar-edit"></i>
                                    <span>{{ $vendor->updated_at->format('d/m/Y H:i') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Address Section -->
                    @if($vendor->address)
                    <div class="description-section">
                        <div class="section-header">
                            <h3 class="section-title">
                                <i class="fas fa-map-marker-alt"></i>
                                Address
                            </h3>
                        </div>
                        <div class="description-content">
                            <p>{{ $vendor->address }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- Document Information -->
                    <div class="additional-info">
                        <div class="info-section">
                            <h3 class="section-title">
                                <i class="fas fa-file-alt"></i>
                                Required Documents
                            </h3>
                            <div class="section-content">
                                <div class="info-row">
                                    <span class="info-key">Signed Application:</span>
                                    <span class="info-val">
                                        @if($vendor->application_document)
                                            <a href="{{ asset('vendor_documents/' . $vendor->application_document) }}" target="_blank" class="document-link">
                                                <i class="fas fa-file-pdf"></i>
                                                {{ $vendor->application_document }}
                                            </a>
                                        @else
                                            <span class="text-muted">Not provided</span>
                                        @endif
                                    </span>
                                </div>
                                <div class="info-row">
                                    <span class="info-key">Trade License (Valid):</span>
                                    <span class="info-val">
                                        @if($vendor->trade_license_document)
                                            <a href="{{ asset('vendor_documents/' . $vendor->trade_license_document) }}" target="_blank" class="document-link">
                                                <i class="fas fa-file-pdf"></i>
                                                {{ $vendor->trade_license_document }}
                                            </a>
                                        @else
                                            <span class="text-muted">Not provided</span>
                                        @endif
                                    </span>
                                </div>
                                <div class="info-row">
                                    <span class="info-key">VAT Certificate/Tax Certificate:</span>
                                    <span class="info-val">
                                        @if($vendor->vat_certificate_document)
                                            <a href="{{ asset('vendor_documents/' . $vendor->vat_certificate_document) }}" target="_blank" class="document-link">
                                                <i class="fas fa-file-pdf"></i>
                                                {{ $vendor->vat_certificate_document }}
                                            </a>
                                        @else
                                            <span class="text-muted">Not provided</span>
                                        @endif
                                    </span>
                                </div>
                                <div class="info-row">
                                    <span class="info-key">Staff Documents (Police Clearance):</span>
                                    <span class="info-val">
                                        @if($vendor->staff_documents)
                                            <a href="{{ asset('vendor_documents/' . $vendor->staff_documents) }}" target="_blank" class="document-link">
                                                <i class="fas fa-file-pdf"></i>
                                                {{ $vendor->staff_documents }}
                                            </a>
                                        @else
                                            <span class="text-muted">Not provided</span>
                                        @endif
                                    </span>
                                </div>
                                <div class="info-row">
                                    <span class="info-key">Contract to be Signed:</span>
                                    <span class="info-val">
                                        @if($vendor->contract_document)
                                            <a href="{{ asset('vendor_documents/' . $vendor->contract_document) }}" target="_blank" class="document-link">
                                                <i class="fas fa-file-pdf"></i>
                                                {{ $vendor->contract_document }}
                                            </a>
                                        @else
                                            <span class="text-muted">Not provided</span>
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Services & Payment Terms -->
                    <div class="additional-info">
                        <div class="info-section">
                            <h3 class="section-title">
                                <i class="fas fa-concierge-bell"></i>
                                Services & Payment Terms
                            </h3>
                            <div class="section-content">
                                @if($vendor->services && $vendor->services->count() > 0)
                                    <div class="services-list">
                                        @foreach($vendor->services as $service)
                                            <div class="service-payment-card">
                                                <div class="service-header">
                                                    <h4 class="service-name">
                                                        <i class="fas fa-tools"></i>
                                                        {{ $service->name }}
                                                    </h4>
                                                    @if($service->category)
                                                        <span class="service-category-badge">{{ $service->category->name }}</span>
                                                    @endif
                                                </div>
                                                <div class="payment-details">
                                                    <div class="payment-row">
                                                        <span class="payment-label">Payment Type:</span>
                                                        <span class="payment-type-badge {{ $service->pivot->payment_type }}">
                                                            <i class="fas fa-cash-register"></i>
                                                            {{ ucfirst(str_replace('_', ' ', $service->pivot->payment_type ?? 'Not set')) }}
                                                        </span>
                                                    </div>
                                                    
                                                    @if($service->pivot->payment_type == 'fixed_rate' && $service->pivot->fixed_rate_amount)
                                                        <div class="payment-row">
                                                            <span class="payment-label">Fixed Rate:</span>
                                                            <span class="payment-value fixed-rate-value">
                                                                <i class="fas fa-dollar-sign"></i>
                                                                AED {{ number_format($service->pivot->fixed_rate_amount, 2) }}
                                                            </span>
                                                        </div>
                                                    @endif
                                                    
                                                    @if($service->pivot->payment_type == 'commission' && $service->pivot->commission_rate)
                                                        <div class="payment-row">
                                                            <span class="payment-label">Commission Rate:</span>
                                                            <span class="payment-value commission-rate-value">
                                                                <i class="fas fa-percent"></i>
                                                                {{ $service->pivot->commission_rate }}%
                                                            </span>
                                                        </div>
                                                    @endif
                                                    
                                                    @if($service->pivot->payment_type == 'revenue_share' && $service->pivot->revenue_share_ratio)
                                                        <div class="payment-row">
                                                            <span class="payment-label">Revenue Share:</span>
                                                            <span class="payment-value revenue-share-value">
                                                                <i class="fas fa-chart-pie"></i>
                                                                {{ $service->pivot->revenue_share_ratio }}
                                                            </span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="no-services">
                                        <i class="fas fa-info-circle"></i>
                                        <p>No services assigned to this vendor</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
