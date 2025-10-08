@extends('admin.layouts.masterlayout')


@section('content')

    <style>
        /* Service View Styling */
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

        .service-badges {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .status-badge,
        .language-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .status-badge.status-active {
            background: rgba(34, 197, 94, 0.2);
            color: #22c55e;
            border: 1px solid rgba(34, 197, 94, 0.3);
        }

        .status-badge.status-inactive {
            background: rgba(239, 68, 68, 0.2);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .language-badge {
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

        .detail-card,
        .description-card {
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
        }

        .pricing-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 15px;
        }

        .price-item {
            text-align: center;
            padding: 15px;
            background: rgba(0, 212, 255, 0.1);
            border-radius: 10px;
            border: 1px solid rgba(0, 212, 255, 0.2);
        }

        .price-label {
            display: block;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 5px;
        }

        .price-value {
            display: block;
            font-size: 18px;
            font-weight: 700;
            color: #00d4ff;
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

        /* Descriptions */
        .descriptions-section {
            display: grid;
            gap: 20px;
            margin-bottom: 30px;
        }

        .description-text {
            color: rgba(255, 255, 255, 0.9);
            line-height: 1.6;
            margin: 0;
        }

        /* Sections */
        .included-section,
        .processes-section,
        .requirements-section {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 30px;
            margin-bottom: 30px;
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid rgba(0, 212, 255, 0.3);
        }

        .section-header i {
            font-size: 24px;
            color: #00d4ff;
        }

        .section-header h3 {
            margin: 0;
            font-size: 20px;
            font-weight: 700;
            color: #ffffff;
        }

        .included-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
        }

        .included-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 15px;
            background: rgba(34, 197, 94, 0.1);
            border-radius: 8px;
            border: 1px solid rgba(34, 197, 94, 0.2);
        }

        .included-item i {
            color: #22c55e;
            font-size: 14px;
        }

        .included-item span {
            color: #ffffff;
            font-size: 14px;
        }

        .processes-grid {
            display: grid;
            gap: 20px;
        }

        .process-card {
            display: flex;
            gap: 20px;
            padding: 20px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            align-items: flex-start;
        }

        .process-number {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #00d4ff, #0099cc);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: white;
            font-size: 16px;
            flex-shrink: 0;
        }

        .process-content {
            flex: 1;
            display: flex;
            gap: 15px;
            align-items: flex-start;
        }

        .process-image {
            width: 80px;
            height: 80px;
            flex-shrink: 0;
        }

        .process-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 8px;
        }

        .process-details {
            flex: 1;
        }

        .process-title {
            margin: 0 0 8px 0;
            font-size: 16px;
            font-weight: 600;
            color: #ffffff;
        }

        .process-description {
            margin: 0;
            color: rgba(255, 255, 255, 0.8);
            line-height: 1.5;
            font-size: 14px;
        }

        .requirements-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .requirement-card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            overflow: hidden;
            text-align: center;
        }

        .requirement-image {
            height: 120px;
            overflow: hidden;
        }

        .requirement-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .requirement-content {
            padding: 15px;
        }

        .requirement-title {
            margin: 0;
            font-size: 14px;
            font-weight: 600;
            color: #ffffff;
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

            .process-content {
                flex-direction: column;
            }

            .process-image {
                width: 100%;
                height: 150px;
            }
        }
    </style>
    <div class="service-view-container">
        <!-- Header Section -->
        <div class="service-header-section">
            <div class="service-header-content">
                <div class="service-icon-wrapper">
                    <i class="fas fa-eye"></i>
                </div>
                <div class="service-header-text">
                    <h1 class="service-title">{{ $service->name }}</h1>
                    <p class="service-subtitle">Service Details & Information</p>
                    <div class="service-badges">
                        <span class="status-badge status-{{ $service->status }}">
                            <i class="fas fa-circle"></i>
                            {{ ucfirst($service->status) }}
                        </span>
                        @if ($service->is_arabic)
                            <span class="language-badge">
                                <i class="fas fa-language"></i>
                                Arabic
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="service-header-actions">
                <a href="{{ route('services.services.edit', $service) }}" class="modern-btn modern-btn-primary">
                    <i class="fas fa-edit"></i>
                    Edit Service
                </a>
                <a href="{{ route('services.services.index') }}" class="modern-btn modern-btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Back to Services
                </a>
            </div>
        </div>

        <!-- Service Details Grid -->
        <div class="service-details-grid">

            <!-- Basic Information Card -->
            <div class="detail-card">
                <div class="card-header">
                    <i class="fas fa-info-circle"></i>
                    <h3>Basic Information</h3>
                </div>
                <div class="card-content">
                    <div class="detail-row">
                        <span class="detail-label">Category:</span>
                        <span class="detail-value">{{ $service->category->name ?? 'N/A' }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Subcategory:</span>
                        <span class="detail-value">{{ $service->subcategory->name ?? 'N/A' }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Duration:</span>
                        <span class="detail-value">{{ $service->duration ?? 'Not specified' }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Created:</span>
                        <span class="detail-value">{{ $service->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Pricing Information Card -->
            <div class="detail-card">
                <div class="card-header">
                    <!--<i class="fas fa-dollar-sign"></i>-->
                    <b>AED</b>
                    <h3>Pricing Information</h3>
                </div>
                <div class="card-content">
                    <div class="pricing-grid">
                        <div class="price-item">
                            <span class="price-label">One Time</span>
                            <span class="price-value">{{ number_format($service->price_onetime, 2) }}&nbsp;AED</span>
                        </div>
                        @if ($service->price_weekly)
                            <div class="price-item">
                                <span class="price-label">Weekly</span>
                                <span class="price-value">{{ number_format($service->price_weekly, 2) }}&nbsp;AED</span>
                            </div>
                        @endif
                        @if ($service->price_monthly)
                            <div class="price-item">
                                <span class="price-label">Monthly</span>
                                <span class="price-value">{{ number_format($service->price_monthly, 2) }}&nbsp;AED</span>
                            </div>
                        @endif
                        @if ($service->price_yearly)
                            <div class="price-item">
                                <span class="price-label">Yearly</span>
                                <span class="price-value">{{ number_format($service->price_yearly, 2) }}&nbsp;AED</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Service Image Card -->
            @if ($service->image)
                <div class="detail-card">
                    <div class="card-header">
                        <i class="fas fa-image"></i>
                        <h3>Service Image</h3>
                    </div>
                    <div class="card-content">
                        <div class="service-image-container">
                            <img src="{{ asset('Service_images/' . $service->image) }}" alt="{{ $service->name }}"
                                class="service-image">
                        </div>
                    </div>
                </div>
            @endif

        </div>

        <!-- Descriptions Section -->
        <div class="descriptions-section">
            @if ($service->short_description)
                <div class="description-card">
                    <div class="card-header">
                        <i class="fas fa-align-left"></i>
                        <h3>Short Description</h3>
                    </div>
                    <div class="card-content">
                        <p class="description-text">{{ $service->short_description }}</p>
                    </div>
                </div>
            @endif

            @if ($service->description)
                <div class="description-card">
                    <div class="card-header">
                        <i class="fas fa-file-alt"></i>
                        <h3>Detailed Description</h3>
                    </div>
                    <div class="card-content">
                        <div class="description-text">{!! nl2br(e($service->description)) !!}</div>
                    </div>
                </div>
            @endif
        </div>

        <!-- What's Included Section -->
        @if ($service->whats_include && count($service->whats_include) > 0)
            <div class="included-section">
                <div class="section-header">
                    <i class="fas fa-check-circle"></i>
                    <h3>What's Included</h3>
                </div>
                <div class="included-grid">
                    @foreach ($service->whats_include as $item)
                        @if ($item)
                            <div class="included-item">
                                <i class="fas fa-check"></i>
                                <span>{{ $item }}</span>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Our Processes Section -->
        @if ($service->processes && $service->processes->count() > 0)
            <div class="processes-section">
                <div class="section-header">
                    <i class="fas fa-cogs"></i>
                    <h3>Our Processes</h3>
                </div>
                <div class="processes-grid">
                    @foreach ($service->processes as $index => $process)
                        <div class="process-card">
                            <div class="process-number">{{ $index + 1 }}</div>
                            <div class="process-content">
                                @if ($process->image)
                                    <div class="process-image">
                                        <img src="{{ asset('Process_images/' . $process->image) }}"
                                            alt="{{ $process->title }}">
                                    </div>
                                @endif
                                <div class="process-details">
                                    <h4 class="process-title">{{ $process->title }}</h4>
                                    <p class="process-description">{{ $process->description }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Requirements Section -->
        @if ($service->requirements && $service->requirements->count() > 0)
            <div class="requirements-section">
                <div class="section-header">
                    <i class="fas fa-clipboard-list"></i>
                    <h3>What We Need From You</h3>
                </div>
                <div class="requirements-grid">
                    @foreach ($service->requirements as $requirement)
                        <div class="requirement-card">
                            @if ($requirement->image)
                                <div class="requirement-image">
                                    <img src="{{ asset('Service_requirement_images/' . $requirement->image) }}"
                                        alt="{{ $requirement->title }}">
                                </div>
                            @endif
                            <div class="requirement-content">
                                <h4 class="requirement-title">{{ $requirement->title }}</h4>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>

@endsection
