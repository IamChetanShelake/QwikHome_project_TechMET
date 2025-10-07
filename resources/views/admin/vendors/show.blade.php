@extends('admin.layouts.masterlayout')

@section('content')
    <div class="content-area">
        <div class="modern-view-container">
            <!-- Header Section -->
            <div class="view-header-section">
                <div class="view-header-content">
                    <div class="view-title-group">
                        <div class="view-icon-wrapper">
                            <i class="fas fa-user-tie view-main-icon"></i>
                        </div>
                        <div class="view-title-text">
                            <h2 class="view-title">Vendor Details</h2>
                            <p class="view-subtitle">Complete information about this vendor account</p>
                        </div>
                    </div>
                    <div class="view-actions">
                        <a href="{{ route('admin.vendors.edit', $vendor->id) }}" class="modern-btn modern-btn-primary">
                            <i class="fas fa-edit"></i>
                            <span>Edit Vendor</span>
                        </a>
                        <a href="{{ route('admin.vendors.index') }}" class="modern-btn modern-btn-secondary">
                            <i class="fas fa-arrow-left"></i>
                            <span>Back to List</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Content Section -->
            <div class="modern-view-card">
                <div class="view-content">
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

                    <!-- Payment Terms -->
                    <div class="additional-info">
                        <div class="info-section">
                            <h3 class="section-title">
                                <i class="fas fa-money-bill-wave"></i>
                                Payment Terms
                            </h3>
                            <div class="section-content">
                                <div class="info-row">
                                    <span class="info-key">Payment Type:</span>
                                    <span class="info-val">
                                        @if($vendor->payment_type)
                                            <span class="payment-type-badge {{ $vendor->payment_type }}">
                                                <i class="fas fa-cash-register"></i>
                                                {{ ucfirst(str_replace('_', ' ', $vendor->payment_type)) }}
                                            </span>
                                        @else
                                            <span class="text-muted">Not set</span>
                                        @endif
                                    </span>
                                </div>
                                @if($vendor->payment_type == 'fixed_rate')
                                <div class="info-row">
                                    <span class="info-key">Fixed Rate Amount:</span>
                                    <span class="info-val">
                                        @if($vendor->fixed_rate_amount)
                                            <span class="fixed-rate-value">
                                                AED &nbsp;
                                                {{ number_format($vendor->fixed_rate_amount, 2) }}
                                            </span>
                                        @else
                                            <span class="text-muted">Not set</span>
                                        @endif
                                    </span>
                                </div>
                                @endif
                                @if($vendor->payment_type == 'commission')
                                <div class="info-row">
                                    <span class="info-key">Commission Rate:</span>
                                    <span class="info-val">
                                        @if($vendor->commission_rate)
                                            <span class="commission-rate-value">

                                                {{ $vendor->commission_rate }}%
                                            </span>
                                        @else
                                            <span class="text-muted">Not set</span>
                                        @endif
                                    </span>
                                </div>
                                @endif
                                @if($vendor->payment_type == 'revenue_share')
                                <div class="info-row">
                                    <span class="info-key">Revenue Share Ratio:</span>
                                    <span class="info-val">
                                        @if($vendor->revenue_share_ratio)
                                            <span class="revenue-share-value">
                                                <i class="fas fa-chart-pie"></i>
                                                {{ $vendor->revenue_share_ratio }}
                                            </span>
                                        @else
                                            <span class="text-muted">Not set</span>
                                        @endif
                                    </span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Modern View Styles */
        .modern-view-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Header Styles */
        .view-header-section {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 20px 0 0;
            padding: 30px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-bottom: none;
        }

        .view-header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .view-title-group {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .view-icon-wrapper {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #00d4ff, #0099cc);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 25px rgba(0, 212, 255, 0.3);
        }

        .view-main-icon {
            font-size: 24px;
            color: white;
        }

        .view-title-text h2 {
            font-size: 28px;
            font-weight: 700;
            color: #ffffff;
            margin: 0;
            background: linear-gradient(135deg, #ffffff, #00d4ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .view-subtitle {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.7);
            margin: 5px 0 0 0;
        }

        .view-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        /* Content Styles */
        .modern-view-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(15px);
            border-radius: 0 0 20px 20px;
            padding: 40px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-top: none;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }

        .info-item {
            background: rgba(255, 255, 255, 0.03);
            border-radius: 12px;
            padding: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .info-item:hover {
            background: rgba(255, 255, 255, 0.05);
            transform: translateY(-2px);
        }

        .info-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 12px;
        }

        .info-label i {
            color: #00d4ff;
        }

        .info-value {
            font-size: 16px;
            font-weight: 500;
            color: #ffffff;
        }

        .text-primary {
            color: #00d4ff;
        }

        .text-muted {
            color: rgba(255, 255, 255, 0.5);
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
            background: rgba(255, 255, 255, 0.03);
            border-radius: 12px;
            padding: 24px;
            border: 1px solid rgba(255, 255, 255, 0.1);
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
            color: #ffffff;
            margin: 0;
        }

        .section-title i {
            color: #00d4ff;
        }

        .description-content p {
            color: rgba(255, 255, 255, 0.8);
            line-height: 1.6;
            margin: 0;
        }

        /* Additional Info Section */
        .additional-info {
            margin-top: 40px;
        }

        .info-section {
            background: rgba(255, 255, 255, 0.03);
            border-radius: 12px;
            padding: 24px;
            border: 1px solid rgba(255, 255, 255, 0.1);
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
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-key {
            font-weight: 500;
            color: rgba(255, 255, 255, 0.7);
        }

        .info-val {
            font-weight: 600;
            color: #ffffff;
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
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .modern-btn-secondary:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-1px);
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
        }
    </style>
@endsection
