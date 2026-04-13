@extends('admin.layouts.masterlayout')

@section('content')
<style>
    /* Modern Form Styles */
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
        border-bottom: none;
    }

    .form-header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }

    .form-title-group {
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
        box-shadow: 0 8px 25px rgba(0, 212, 255, 0.3);
    }

    .form-main-icon {
        font-size: 24px;
        color: white;
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
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-top: none;
        padding: 40px;
        overflow: hidden;
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
        margin-bottom: 12px;
    }

    .label-icon {
        color: #00d4ff;
    }

    .modern-input,
    .modern-textarea {
        width: 100%;
        padding: 16px 20px;
        background: rgba(255, 255, 255, 0.9);
        border: 2px solid rgba(0, 0, 0, 0.1);
        border-radius: 12px;
        color: #334155;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .modern-textarea {
        resize: vertical;
        min-height: 120px;
        font-family: inherit;
    }

    .modern-input:focus,
    .modern-textarea:focus {
        outline: none;
        border-color: #00d4ff;
        background: rgba(0, 212, 255, 0.05);
        box-shadow: 0 0 20px rgba(0, 212, 255, 0.2);
        transform: translateY(-2px);
    }

    .modern-input::placeholder,
    .modern-textarea::placeholder {
        color: rgba(51, 65, 85, 0.5);
    }

    .checkbox-wrapper {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 15px;
        padding: 20px;
        background: rgba(0, 212, 255, 0.05);
        border-radius: 12px;
        border: 2px solid rgba(0, 212, 255, 0.1);
    }

    .modern-checkbox {
        width: 20px;
        height: 20px;
        accent-color: #00d4ff;
        cursor: pointer;
    }

    .checkbox-label {
        font-size: 14px;
        font-weight: 500;
        color: #334155;
        cursor: pointer;
    }

    .form-actions {
        display: flex;
        gap: 15px;
        justify-content: flex-end;
        flex-wrap: wrap;
        margin-top: 40px;
    }

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
        position: relative;
        overflow: hidden;
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
        transform: translateY(-1px);
    }

    .error-message {
        display: flex;
        align-items: center;
        gap: 6px;
        color: #ff4757;
        font-size: 12px;
        margin-top: 8px;
        animation: slideInUp 0.3s ease;
    }

    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 768px) {
        .modern-form-container {
            padding: 10px;
        }

        .form-header-section,
        .modern-form-card {
            padding: 20px;
        }

        .form-header-content {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .form-title-group {
            width: 100%;
        }

        .form-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .form-actions {
            flex-direction: column;
            gap: 10px;
        }

        .modern-btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="content-area">
    <div class="modern-form-container">
        <!-- Header Section -->
        <div class="form-header-section">
            <div class="form-header-content">
                <div class="form-title-group">
                    <div class="form-icon-wrapper">
                        <i class="fas fa-edit form-main-icon"></i>
                    </div>
                    <div class="form-title-text">
                        <h2 class="form-title">Edit Service Provider FAQ</h2>
                        <p class="form-subtitle">Update the FAQ details and manage its status</p>
                    </div>
                </div>
                <a href="{{ route('service-provider-faqs.index') }}" class="modern-btn modern-btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back to FAQs</span>
                </a>
            </div>
        </div>

        <!-- Form Section -->
        <div class="modern-form-card">
            <form method="POST" action="{{ route('service-provider-faqs.update', $service_provider_faq) }}" class="modern-form"
                  id="faqEditForm">
                @csrf
                @method('PUT')

                <!-- Form Grid -->
                <div class="form-grid">
                    <!-- Question Field -->
                    <div class="form-group-modern full-width">
                        <label for="question" class="modern-label">
                            <i class="fas fa-question-circle label-icon"></i>
                            Question
                        </label>
                        <input type="text" class="modern-input @error('question') is-invalid @enderror"
                               id="question" name="question" value="{{ old('question', $service_provider_faq->question) }}"
                               placeholder="Enter the FAQ question..." required>
                        @error('question')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                        <div style="color: rgba(51, 65, 85, 0.6); font-size: 11px; margin-top: 6px;">
                            <i class="fas fa-info-circle"></i>
                            Make your question clear and concise for better user understanding
                        </div>
                    </div>

                    <!-- Answer Field -->
                    <div class="form-group-modern full-width">
                        <label for="answer" class="modern-label">
                            <i class="fas fa-comment label-icon"></i>
                            Answer
                        </label>
                        <textarea class="modern-textarea @error('answer') is-invalid @enderror"
                                  id="answer" name="answer" rows="6" placeholder="Provide a comprehensive answer..."
                                  required>{{ old('answer', $service_provider_faq->answer) }}</textarea>
                        @error('answer')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                        <div style="color: rgba(51, 65, 85, 0.6); font-size: 11px; margin-top: 6px;">
                            <i class="fas fa-info-circle"></i>
                            Provide detailed and helpful answers to assist users effectively
                        </div>
                    </div>

                    <!-- Status Field -->
                    <div class="form-group-modern">
                        <div class="checkbox-wrapper">
                            <input type="checkbox" id="is_active" name="is_active"
                                   class="modern-checkbox" value="1"
                                   {{ old('is_active', $service_provider_faq->is_active) ? 'checked' : '' }}>
                            <label for="is_active" class="checkbox-label">
                                <strong>FAQ Status:</strong> Active
                            </label>
                        </div>
                        <div style="color: rgba(51, 65, 85, 0.6); font-size: 12px; margin-top: 10px; padding-left: 20px;">
                            <i class="fas fa-lightbulb"></i>
                            Active FAQs will be displayed to users in the support section
                        </div>
                        @error('is_active')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <a href="{{ route('service-provider-faqs.index') }}" class="modern-btn modern-btn-secondary">
                        <i class="fas fa-times"></i>
                        <span>Cancel</span>
                    </a>
                    <button type="submit" class="modern-btn modern-btn-primary" id="updateBtn">
                        <i class="fas fa-save"></i>
                        <span>Update FAQ</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('faqEditForm');
    const updateBtn = document.getElementById('updateBtn');
    const inputs = form.querySelectorAll('.modern-input, .modern-textarea');

    // Add focus effects to inputs
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.style.transform = 'translateY(-2px)';
            this.style.boxShadow = '0 0 20px rgba(0, 212, 255, 0.3)';
        });

        input.addEventListener('blur', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = 'none';
        });
    });

    // Form submission with loading state
    form.addEventListener('submit', function() {
        updateBtn.disabled = true;
        updateBtn.innerHTML = `
            <i class="fas fa-spinner fa-spin"></i>
            <span>Updating FAQ...</span>
        `;
    });

    // Auto-height adjustment for textarea
    const textarea = document.getElementById('answer');
    textarea.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = this.scrollHeight + 'px';
    });
    // Trigger on load
    textarea.dispatchEvent(new Event('input'));
});
</script>
