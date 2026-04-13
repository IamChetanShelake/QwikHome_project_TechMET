@extends('admin.layouts.masterlayout')

@section('content')
    <style>
        /* Modern Show Styles */
        .modern-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .modern-header {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 20px 20px 0 0;
            padding: 30px;
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-bottom: none;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .header-title-group {
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
            box-shadow: 0 8px 25px rgba(0, 212, 255, 0.3);
        }

        .header-icon {
            font-size: 24px;
            color: white;
        }

        .header-title {
            font-size: 28px;
            font-weight: 700;
            color: #334155;
            margin: 0;
        }

        .header-subtitle {
            font-size: 14px;
            color: rgba(51, 65, 85, 0.7);
            margin: 5px 0 0 0;
        }

        .action-buttons {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .modern-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(15px);
            border-radius: 0 0 20px 20px;
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-top: none;
            padding: 40px;
            overflow: hidden;
        }

        .info-section {
            margin-bottom: 40px;
        }

        .info-title {
            font-size: 18px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .info-icon {
            color: #00d4ff;
        }

        .faq-content {
            background: rgba(0, 212, 255, 0.03);
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            border: 2px solid rgba(0, 212, 255, 0.1);
            position: relative;
            overflow: hidden;
        }

        .faq-content::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(135deg, #00d4ff, #0099cc);
        }

        .question-section {
            margin-bottom: 25px;
        }

        .question-label {
            font-size: 16px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .question-text {
            font-size: 18px;
            font-weight: 500;
            color: #334155;
            line-height: 1.6;
            background: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            border: 2px solid rgba(0, 212, 255, 0.1);
        }

        .answer-section {
            margin-bottom: 20px;
        }

        .answer-label {
            font-size: 16px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .answer-text {
            font-size: 16px;
            color: rgba(51, 65, 85, 0.9);
            line-height: 1.7;
            background: rgba(255, 255, 255, 0.8);
            padding: 25px;
            border-radius: 10px;
            border: 2px solid rgba(0, 212, 255, 0.1);
            white-space: pre-line;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .detail-card {
            background: rgba(255, 255, 255, 0.8);
            border-radius: 12px;
            padding: 20px;
            border: 2px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .detail-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 212, 255, 0.1);
            border-color: rgba(0, 212, 255, 0.2);
        }

        .detail-label {
            font-size: 12px;
            font-weight: 600;
            color: rgba(51, 65, 85, 0.7);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .detail-value {
            font-size: 14px;
            font-weight: 500;
            color: #334155;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-active {
            background: rgba(34, 197, 94, 0.1);
            color: #16a34a;
        }

        .status-inactive {
            background: rgba(239, 68, 68, 0.1);
            color: #dc2626;
        }

        .id-highlight {
            font-family: 'JetBrains Mono', monospace;
            background: linear-gradient(135deg, #00d4ff, #0099cc);
            color: white;
            padding: 4px 8px;
            border-radius: 6px;
            font-weight: 700;
        }

        .timestamp {
            font-size: 13px;
            color: rgba(51, 65, 85, 0.8);
        }

        .action-section {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 12px;
            padding: 25px;
            border: 2px solid rgba(0, 0, 0, 0.05);
        }

        .action-title {
            font-size: 16px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 15px;
        }

        .modern-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .modern-btn-primary {
            background: linear-gradient(135deg, #00d4ff, #0099cc);
            color: white;
            box-shadow: 0 4px 15px rgba(0, 212, 255, 0.3);
        }

        .modern-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 212, 255, 0.4);
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
            transform: translateY(-1px);
        }

        @media (max-width: 768px) {
            .modern-container {
                padding: 10px;
            }

            .modern-header,
            .modern-card {
                padding: 20px;
            }

            .header-content {
                flex-direction: column;
                align-items: flex-start;
            }

            .action-buttons {
                width: 100%;
                justify-content: stretch;
            }

            .modern-btn {
                flex: 1;
                justify-content: center;
            }

            .detail-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .question-text,
            .answer-text {
                padding: 15px;
            }

            .faq-content {
                padding: 20px;
            }
        }
    </style>

    <div class="content-area">
        <div class="modern-container">
            <!-- Header Section -->
            <div class="modern-header">
                <div class="header-content">
                    <div class="header-title-group">
                        <div class="header-icon-wrapper">
                            <i class="fas fa-eye header-icon"></i>
                        </div>
                        <div class="header-title-text">
                            <h2 class="header-title">Service Provider FAQ Details</h2>
                            <p class="header-subtitle">View complete FAQ information and details</p>
                        </div>
                    </div>
                    <div class="action-buttons">
                        <a href="{{ route('service-provider-faqs.edit', $faq) }}" class="modern-btn modern-btn-primary">
                            <i class="fas fa-edit"></i>
                            <span>Edit FAQ</span>
                        </a>
                        <a href="{{ route('service-provider-faqs.index') }}" class="modern-btn modern-btn-secondary">
                            <i class="fas fa-arrow-left"></i>
                            <span>Back to FAQs</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="modern-card">
                <!-- FAQ Content Section -->
                <div class="info-section">
                    <h3 class="info-title">
                        <i class="fas fa-question-circle info-icon"></i>
                        FAQ Content
                    </h3>

                    <div class="faq-content">
                        <div class="question-section">
                            <div class="question-label">
                                <i class="fas fa-question"></i>
                                Question
                            </div>
                            <div class="question-text">
                                {{ $faq->question }}
                            </div>
                        </div>

                        <div class="answer-section">
                            <div class="answer-label">
                                <i class="fas fa-reply"></i>
                                Answer
                            </div>
                            <div class="answer-text">
                                {{ $faq->answer }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Details Grid -->
                <div class="info-section">
                    <h3 class="info-title">
                        <i class="fas fa-info-circle info-icon"></i>
                        FAQ Details
                    </h3>

                    <div class="detail-grid">
                        <div class="detail-card">
                            <div class="detail-label">ID</div>
                            <div class="detail-value">
                                <span class="id-highlight">#{{ $faq->id }}</span>
                            </div>
                        </div>

                        <div class="detail-card">
                            <div class="detail-label">Status</div>
                            <div class="detail-value">
                                <span class="status-badge {{ $faq->is_active ? 'status-active' : 'status-inactive' }}">
                                    <i class="fas fa-{{ $faq->is_active ? 'check-circle' : 'times-circle' }}"></i>
                                    {{ $faq->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </div>

                        <div class="detail-card">
                            <div class="detail-label">Created At</div>
                            <div class="detail-value">
                                <i class="fas fa-calendar-plus" style="color: #10b981;"></i>
                                <span class="timestamp">{{ $faq->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                        </div>

                        <div class="detail-card">
                            <div class="detail-label">Updated At</div>
                            <div class="detail-value">
                                <i class="fas fa-clock" style="color: #f59e0b;"></i>
                                <span class="timestamp">{{ $faq->updated_at->format('d/m/Y H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions Section -->
                <div class="action-section">
                    <div class="action-title">Quick Actions</div>
                    <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                        <a href="{{ route('service-provider-faqs.edit', $faq) }}" class="modern-btn modern-btn-primary">
                            <i class="fas fa-edit"></i>
                            <span>Edit This FAQ</span>
                        </a>
                        <a href="{{ route('service-provider-faqs.create') }}" class="modern-btn modern-btn-secondary">
                            <i class="fas fa-plus"></i>
                            <span>Create New FAQ</span>
                        </a>
                        <a href="{{ route('service-provider-faqs.index') }}" class="modern-btn modern-btn-secondary">
                            <i class="fas fa-list"></i>
                            <span>View All FAQs</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
