@extends('admin.layouts.masterlayout')

@section('content')
<div class="modern-form-container">
    <!-- Form Header Section -->
    <div class="form-header-section">
        <div class="form-header-content">
            <div class="form-icon-wrapper">
                <i class="fas fa-eye"></i>
            </div>
            <div class="form-header-text">
                <h1 class="form-title">Service FAQs</h1>
                <p class="form-subtitle">Viewing all FAQs for service: <strong>{{ $service->name }}</strong></p>
            </div>
        </div>
        <div class="form-header-actions">
            <a href="{{ route('faq') }}" class="modern-btn modern-btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Back to FAQ Index
            </a>
            <a href="{{ route('faqs.service.edit', $service->id) }}" class="modern-btn modern-btn-primary">
                <i class="fas fa-edit"></i>
                Edit All FAQs
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="modern-form-card">
        <!-- Service Information Grid -->
        <div class="form-grid">
            <div class="form-group-modern">
                <label class="modern-label">
                    <i class="fas fa-concierge-bell text-cyan"></i>
                    Service
                </label>
                <div class="input-wrapper">
                    <div class="modern-input-display">{{ $service->name }}</div>
                    <i class="fas fa-concierge-bell input-icon"></i>
                </div>
            </div>
            <div class="form-group-modern">
                <label class="modern-label">
                    <i class="fas fa-folder text-cyan"></i>
                    Category
                </label>
                <div class="input-wrapper">
                    <div class="modern-input-display">{{ $service->category->name ?? 'N/A' }}</div>
                    <i class="fas fa-folder input-icon"></i>
                </div>
            </div>
            <div class="form-group-modern">
                <label class="modern-label">
                    <i class="fas fa-folder-open text-cyan"></i>
                    Subcategory
                </label>
                <div class="input-wrapper">
                    <div class="modern-input-display">{{ $service->subcategory->name ?? 'N/A' }}</div>
                    <i class="fas fa-folder-open input-icon"></i>
                </div>
            </div>
            <div class="form-group-modern">
                <label class="modern-label">
                    <i class="fas fa-list-ul text-cyan"></i>
                    Total FAQs
                </label>
                <div class="input-wrapper">
                    <div class="modern-input-display">{{ $faqs->count() }}</div>
                    <i class="fas fa-list-ul input-icon"></i>
                </div>
            </div>
        </div>

        <!-- FAQs List Section -->
        <div class="form-group-modern full-width">
            <label class="modern-label">
                <i class="fas fa-question-circle text-cyan"></i>
                Questions & Answers
            </label>
            <div class="faqs-list">
                @forelse ($faqs as $index => $faq)
                    <div class="faq-item">
                        <div class="faq-item-header">
                            <div class="faq-item-number">
                                <span class="faq-number">#{{ $index + 1 }}</span>
                            </div>
                            <div class="faq-item-status">
                                @if ($faq->status == 1)
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

                        <div class="faq-content">
                            <div class="faq-question">
                                <div class="question-label">
                                    <i class="fas fa-question text-cyan"></i>
                                    Question
                                </div>
                                <div class="question-text">{{ $faq->question }}</div>
                            </div>

                            <div class="faq-answer">
                                <div class="answer-label">
                                    <i class="fas fa-comment-dots text-cyan"></i>
                                    Answer
                                </div>
                                <div class="answer-text">{!! $faq->answer !!}</div>
                            </div>
                        </div>

                        <div class="faq-meta">
                            <div class="meta-item">
                                <i class="fas fa-calendar-plus"></i>
                                <span>Created: {{ $faq->created_at->format('d M Y, H:i') }}</span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-calendar-edit"></i>
                                <span>Updated: {{ $faq->updated_at->format('d M Y, H:i') }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-question-circle"></i>
                        </div>
                        <h3>No FAQs Found</h3>
                        <p>This service doesn't have any FAQs yet.</p>
                        <a href="{{ route('faqs.service.edit', $service->id) }}" class="modern-btn modern-btn-primary">
                            <i class="fas fa-plus"></i>
                            Add First FAQ
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<style>
    /* Modern FAQ View Styling - Same as Feedback Index */
    .modern-form-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .form-header-section {
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

    .form-header-content {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .form-icon-wrapper {
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

    .form-title {
        font-size: 28px;
        font-weight: 700;
        color: #334155;
        margin: 0;
    }

    .form-subtitle {
        font-size: 14px;
        color: rgba(51, 65, 85, 0.7);
        margin: 5px 0 0 0;
    }

    .modern-form-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(15px);
        border-radius: 0 0 20px 20px;
        padding: 40px;
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-top: none;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
        margin-bottom: 40px;
    }

    .form-group-modern.full-width {
        grid-column: 1 / -1;
    }

    .modern-label {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        font-weight: 600;
        color: #334155;
        margin-bottom: 8px;
    }

    .text-cyan {
        color: #00d4ff;
    }

    .input-wrapper {
        position: relative;
    }

    .modern-input-display {
        width: 100%;
        padding: 16px 20px 16px 50px;
        background: rgba(255, 255, 255, 0.9);
        border: 2px solid rgba(0, 0, 0, 0.1);
        border-radius: 12px;
        color: #334155;
        font-size: 14px;
        backdrop-filter: blur(10px);
        min-height: 20px;
    }

    .input-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: rgba(51, 65, 85, 0.5);
        font-size: 14px;
        pointer-events: none;
    }

    /* FAQ Items Styling - Same as Feedback Index */
    .faqs-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .faq-item {
        background: rgba(255, 255, 255, 0.9);
        border: 2px solid rgba(0, 0, 0, 0.1);
        border-radius: 16px;
        padding: 24px;
        backdrop-filter: blur(10px);
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .faq-item:hover {
        border-color: rgba(59, 130, 246, 0.3);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.1);
    }

    .faq-item-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .faq-number {
        background: linear-gradient(135deg, #00d4ff, #0099cc);
        color: white;
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 14px;
    }

    .status-badge {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-active {
        background: rgba(34, 197, 94, 0.2);
        color: #22c55e;
        border: 1px solid rgba(34, 197, 94, 0.3);
    }

    .status-inactive {
        background: rgba(239, 68, 68, 0.2);
        color: #ef4444;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }

    .faq-content {
        margin-bottom: 20px;
    }

    .faq-question {
        margin-bottom: 20px;
    }

    .question-label, .answer-label {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        font-weight: 600;
        color: #334155;
        margin-bottom: 8px;
    }

    .question-text {
        background: rgba(255, 255, 255, 0.9);
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        padding: 12px 16px;
        color: #334155;
        font-size: 16px;
        line-height: 1.5;
    }

    .answer-text {
        background: rgba(255, 255, 255, 0.9);
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        padding: 16px;
        color: rgba(51, 65, 85, 0.9);
        line-height: 1.6;
        min-height: 60px;
    }

    .faq-meta {
        display: flex;
        gap: 20px;
        padding-top: 15px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 6px;
        color: rgba(255, 255, 255, 0.6);
        font-size: 12px;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: rgba(255, 255, 255, 0.7);
    }

    .empty-icon {
        font-size: 48px;
        color: rgba(255, 255, 255, 0.3);
        margin-bottom: 20px;
    }

    .empty-state h3 {
        color: #ffffff;
        margin-bottom: 10px;
    }

    /* Button Styles - Same as Feedback Index */
    .modern-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 20px;
        border: none;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .modern-btn-primary {
        background: linear-gradient(135deg, #00d4ff, #0099cc);
        color: white;
        box-shadow: 0 4px 15px rgba(0, 212, 255, 0.3);
    }

    .modern-btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 212, 255, 0.4);
        color: white;
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
        .form-header-section,
        .modern-form-card {
            padding: 20px;
        }

        .form-header-content {
            flex-direction: column;
            text-align: center;
        }

        .form-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .faq-meta {
            flex-direction: column;
            gap: 10px;
        }
    }
</style>
@endsection
