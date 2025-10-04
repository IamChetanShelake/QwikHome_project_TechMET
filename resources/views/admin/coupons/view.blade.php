@extends('admin.layouts.masterlayout')

@section('content')
    <div class="content-area">
        <div class="modern-view-container">
            <!-- Header Section -->
            <div class="view-header-section">
                <div class="view-header-content">
                    <div class="view-title-group">
                        <div class="view-icon-wrapper">
                            <i class="fas fa-eye view-main-icon"></i>
                        </div>
                        <div class="view-title-text">
                            <h2 class="view-title">Coupon Details</h2>
                            <p class="view-subtitle">Complete information about this discount coupon</p>
                        </div>
                    </div>
                    <div class="view-actions">
                        <a href="{{ route('coupons.edit', $coupon->id) }}" class="modern-btn modern-btn-primary">
                            <i class="fas fa-edit"></i>
                            <span>Edit Coupon</span>
                        </a>
                        <a href="{{ route('coupons.index') }}" class="modern-btn modern-btn-secondary">
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
                        <!-- Coupon Code -->
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-barcode"></i>
                                <span>Coupon Code</span>
                            </div>
                            <div class="info-value">
                                <div class="code-display">
                                    <span class="code-text">{{ $coupon->code }}</span>
                                    <button class="copy-btn" onclick="copyToClipboard('{{ $coupon->code }}')">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                            </div>
                        </div>



                        <!-- Discount Value -->
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-coins"></i>
                                <span>Discount Value</span>
                            </div>
                            <div class="info-value">
                                <div class="discount-display">
                                    <span class="discount-amount">{{ $coupon->discount_value }}</span>
                                    <span class="discount-unit">
                                        @if($coupon->discount_type == 'percentage')
                                            %
                                        @else
                                            {{ config('app.currency', 'AED') }}
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-toggle-on"></i>
                                <span>Status</span>
                            </div>
                            <div class="info-value">
                                @if ($coupon->status == 1)
                                    <span class="status-badge status-active">
                                        <i class="fas fa-check-circle"></i>
                                        Active
                                    </span>
                                @else
                                    <span class="status-badge status-inactive">
                                        <i class="fas fa-times-circle"></i>
                                        Inactive
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Expiry Date -->
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-calendar-times"></i>
                                <span>Expiry Date</span>
                            </div>
                            <div class="info-value">
                                <div class="date-display">
                                    <i class="fas fa-calendar-check"></i>
                                    <span>{{ $coupon->expiry_date->format('d/m/Y H:i') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Usage Statistics -->
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-chart-bar"></i>
                                <span>Usage Statistics</span>
                            </div>
                            <div class="info-value">
                                <div class="usage-stats">
                                    <div class="usage-count">
                                        <span class="count">{{ $coupon->used_count }}</span>
                                        <span class="label">Used</span>
                                    </div>
                                    <div class="usage-separator">/</div>
                                    <div class="usage-limit">
                                        <span class="limit">{{ $coupon->usage_limit ?: '∞' }}</span>
                                        <span class="label">Limit</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Created At -->
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-plus-circle"></i>
                                <span>Created At</span>
                            </div>
                            <div class="info-value">
                                <div class="date-display">
                                    <i class="fas fa-calendar-plus"></i>
                                    <span>{{ $coupon->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Updated At -->
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-edit"></i>
                                <span>Last Updated</span>
                            </div>
                            <div class="info-value">
                                <div class="date-display">
                                    <i class="fas fa-calendar-edit"></i>
                                    <span>{{ $coupon->updated_at->format('d/m/Y H:i') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Description Section -->
                    @if($coupon->description)
                    <div class="description-section">
                        <div class="section-header">
                            <h3 class="section-title">
                                <i class="fas fa-align-left"></i>
                                Description
                            </h3>
                        </div>
                        <div class="description-content">
                            <p>{{ $coupon->description }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- Additional Info Section -->
                    <div class="additional-info">
                        <div class="info-section">
                            <h3 class="section-title">
                                <i class="fas fa-info-circle"></i>
                                Coupon Information
                            </h3>
                            <div class="section-content">
                                <div class="info-row">
                                    <span class="info-key">ID:</span>
                                    <span class="info-val">#{{ $coupon->id }}</span>
                                </div>
                                <div class="info-row">
                                    <span class="info-key">Type:</span>
                                    <span class="info-val">
                                        @if($coupon->discount_type == 'percentage')
                                            Percentage Discount
                                        @else
                                            Fixed Amount Discount
                                        @endif
                                    </span>
                                </div>
                                <div class="info-row">
                                    <span class="info-key">Usage Remaining:</span>
                                    <span class="info-val">
                                        @if($coupon->usage_limit)
                                            {{ $coupon->usage_limit - $coupon->used_count }} uses left
                                        @else
                                            Unlimited
                                        @endif
                                    </span>
                                </div>
                                <div class="info-row">
                                    <span class="info-key">Current Status:</span>
                                    <span class="info-val">
                                        @if ($coupon->expiry_date && $coupon->expiry_date->isPast())
                                            <span class="text-danger">Expired</span>
                                        @elseif ($coupon->status == 0)
                                            <span class="text-warning">Inactive</span>
                                        @elseif ($coupon->usage_limit && $coupon->used_count >= $coupon->usage_limit)
                                            <span class="text-info">Usage Limit Reached</span>
                                        @else
                                            <span class="text-success">Active & Available</span>
                                        @endif
                                    </span>
                                </div>
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
            border-radius: 20px 20px 0 0;
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

        .view-title {
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

        /* Specific Content Styles */
        .code-display {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .code-text {
            font-family: 'Courier New', monospace;
            background: rgba(0, 212, 255, 0.1);
            padding: 8px 12px;
            border-radius: 8px;
            color: #00d4ff;
            font-weight: 600;
        }

        .copy-btn {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 6px;
            padding: 6px 8px;
            color: rgba(255, 255, 255, 0.7);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .copy-btn:hover {
            background: rgba(255, 255, 255, 0.15);
            color: #00d4ff;
        }

        .type-badge {
            display: flex;
            align-items: center;
            gap: 8px;
            background: rgba(0, 212, 255, 0.1);
            padding: 8px 12px;
            border-radius: 8px;
            color: #00d4ff;
            font-weight: 600;
        }

        .discount-display {
            display: flex;
            align-items: baseline;
            gap: 4px;
        }

        .discount-amount {
            font-size: 24px;
            font-weight: 700;
            color: #ffffff;
        }

        .discount-unit {
            font-size: 16px;
            color: #00d4ff;
            font-weight: 600;
        }

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

        .status-inactive {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .date-display {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .date-display i {
            color: #00d4ff;
            font-size: 14px;
        }

        .usage-stats {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .usage-count, .usage-limit {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .usage-count .count, .usage-limit .limit {
            font-size: 20px;
            font-weight: 700;
            color: #ffffff;
        }

        .usage-count .label, .usage-limit .label {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.6);
        }

        .usage-separator {
            font-size: 18px;
            color: rgba(255, 255, 255, 0.5);
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
        }

        .text-success {
            color: #22c55e;
        }

        .text-warning {
            color: #f59e0b;
        }

        .text-danger {
            color: #ef4444;
        }

        .text-info {
            color: #3b82f6;
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

            .usage-stats {
                flex-direction: column;
                gap: 8px;
            }
        }
    </style>

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                // Show success feedback
                const btn = event.target.closest('.copy-btn');
                const originalIcon = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-check"></i>';
                btn.style.color = '#22c55e';
                
                setTimeout(function() {
                    btn.innerHTML = originalIcon;
                    btn.style.color = '';
                }, 2000);
            }).catch(function(err) {
                console.error('Could not copy text: ', err);
            });
        }
    </script>
@endsection
