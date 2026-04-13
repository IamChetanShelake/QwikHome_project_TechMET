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

    .faq-section {
        margin-bottom: 30px;
    }

    .faq-item {
        background: rgba(255, 255, 255, 0.8);
        border: 2px solid rgba(0, 0, 0, 0.08);
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 20px;
        transition: all 0.3s ease;
        position: relative;
    }

    .faq-item:hover {
        border-color: rgba(0, 212, 255, 0.2);
        background: rgba(0, 212, 255, 0.02);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 212, 255, 0.1);
    }

    .faq-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .faq-title {
        font-size: 18px;
        font-weight: 600;
        color: #334155;
        margin: 0;
    }

    .remove-faq-btn {
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
        border: 1px solid rgba(239, 68, 68, 0.2);
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .remove-faq-btn:hover {
        background: rgba(239, 68, 68, 0.2);
        transform: translateY(-1px);
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
        min-height: 100px;
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

    .add-faq-section {
        text-align: center;
        margin: 30px 0;
    }

    .add-faq-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(0, 212, 255, 0.1);
        color: #00d4ff;
        border: 2px solid rgba(0, 212, 255, 0.3);
        padding: 14px 28px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .add-faq-btn:hover {
        background: rgba(0, 212, 255, 0.2);
        border-color: #00d4ff;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 212, 255, 0.3);
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

        .faq-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
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
                        <i class="fas fa-plus form-main-icon"></i>
                    </div>
                    <div class="form-title-text">
                        <h2 class="form-title">Add New Service Provider FAQs</h2>
                        <p class="form-subtitle">Create multiple frequently asked questions at once</p>
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
            <form action="{{ route('service-provider-faqs.store') }}" method="POST" id="faqForm">
                @csrf

                <div id="faq-items" class="faq-section">
                    <div class="faq-item">
                        <div class="faq-header">
                            <h3 class="faq-title">FAQ #1</h3>
                            <button type="button" class="remove-faq-btn d-none">
                                <i class="fas fa-trash"></i>
                                Remove
                            </button>
                        </div>
                        <div class="mb-3">
                            <label class="modern-label">
                                <i class="fas fa-question-circle label-icon"></i>
                                Question
                            </label>
                            <input type="text" name="faqs[0][question]" class="modern-input" placeholder="Enter your FAQ question..." required>
                        </div>
                        <div class="mb-3">
                            <label class="modern-label">
                                <i class="fas fa-comment label-icon"></i>
                                Answer
                            </label>
                            <textarea name="faqs[0][answer]" class="modern-textarea" placeholder="Provide a comprehensive answer..." rows="4" required></textarea>
                        </div>
                        <div class="checkbox-wrapper">
                            <input type="checkbox" id="active_0" name="faqs[0][is_active]" class="modern-checkbox" value="1" checked>
                            <label for="active_0" class="checkbox-label">Mark this FAQ as active</label>
                        </div>
                    </div>
                </div>

                <div class="add-faq-section">
                    <button type="button" id="add-more" class="add-faq-btn">
                        <i class="fas fa-plus-circle"></i>
                        Add Another FAQ
                    </button>
                </div>

                <div class="form-actions">
                    <a href="{{ route('service-provider-faqs.index') }}" class="modern-btn modern-btn-secondary">
                        <i class="fas fa-times"></i>
                        <span>Cancel</span>
                    </a>
                    <button type="submit" class="modern-btn modern-btn-primary" id="submitBtn">
                        <i class="fas fa-save"></i>
                        <span>Create All FAQs</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function() {
    let faqCount = 1;
    const addMoreBtn = document.getElementById('add-more');
    const faqItemsContainer = document.getElementById('faq-items');
    const form = document.getElementById('faqForm');
    const submitBtn = document.getElementById('submitBtn');

    // Add more FAQ functionality
    addMoreBtn.addEventListener('click', function() {
        const newFaqItem = document.createElement('div');
        newFaqItem.className = 'faq-item';

        newFaqItem.innerHTML = `
            <div class="faq-header">
                <h3 class="faq-title">FAQ #${faqCount + 1}</h3>
                <button type="button" class="remove-faq-btn">
                    <i class="fas fa-trash"></i>
                    Remove
                </button>
            </div>
            <div class="mb-3">
                <label class="modern-label">
                    <i class="fas fa-question-circle label-icon"></i>
                    Question
                </label>
                <input type="text" name="faqs[${faqCount}][question]" class="modern-input" placeholder="Enter your FAQ question..." required>
            </div>
            <div class="mb-3">
                <label class="modern-label">
                    <i class="fas fa-comment label-icon"></i>
                    Answer
                </label>
                <textarea name="faqs[${faqCount}][answer]" class="modern-textarea" placeholder="Provide a comprehensive answer..." rows="4" required></textarea>
            </div>
            <div class="checkbox-wrapper">
                <input type="checkbox" id="active_${faqCount}" name="faqs[${faqCount}][is_active]" class="modern-checkbox" value="1" checked>
                <label for="active_${faqCount}" class="checkbox-label">Mark this FAQ as active</label>
            </div>
        `;

        faqItemsContainer.appendChild(newFaqItem);
        faqCount++;

        // Show remove buttons on all items when there are multiple items
        if (faqCount >= 2) {
            document.querySelectorAll('.remove-faq-btn').forEach(btn => {
                btn.classList.remove('d-none');
            });
        }
    });

    // Remove FAQ item using event delegation
    document.addEventListener('click', function(e) {
        if (e.target && (e.target.classList.contains('remove-faq-btn') || e.target.closest('.remove-faq-btn'))) {
            e.preventDefault();
            const faqItem = e.target.closest('.faq-item');
            if (faqItem) {
                faqItem.remove();
                faqCount--;

                // Hide remove buttons if only one item remains
                if (faqCount <= 1) {
                    document.querySelectorAll('.remove-faq-btn').forEach(btn => {
                        btn.classList.add('d-none');
                    });
                }

                // Re-number the remaining items and update form field names
                const allFaqItems = document.querySelectorAll('.faq-item');
                allFaqItems.forEach(function(item, index) {
                    const title = item.querySelector('.faq-title');
                    title.textContent = `FAQ #${index + 1}`;

                    // Update form field names and IDs
                    const questionInput = item.querySelector('input[name*="question"]');
                    const answerInput = item.querySelector('textarea[name*="answer"]');
                    const activeInput = item.querySelector('input[name*="is_active"]');
                    const activeLabel = item.querySelector('.checkbox-label');

                    questionInput.name = `faqs[${index}][question]`;
                    answerInput.name = `faqs[${index}][answer]`;
                    activeInput.name = `faqs[${index}][is_active]`;
                    activeInput.id = `active_${index}`;
                    activeLabel.setAttribute('for', `active_${index}`);
                });
                faqCount = allFaqItems.length;
            }
        }
    });

    // Form submission with loading state
    form.addEventListener('submit', function() {
        submitBtn.disabled = true;
        submitBtn.querySelector('span').textContent = 'Creating FAQs...';
        submitBtn.innerHTML = `
            <i class="fas fa-spinner fa-spin"></i>
            <span>Creating FAQs...</span>
        `;
    });
});
</script>
