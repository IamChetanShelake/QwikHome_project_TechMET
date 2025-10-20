@extends('admin.layouts.masterlayout')

@section('content')
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
                            <h2 class="form-title">Edit Promocode</h2>
                            <p class="form-subtitle">Update promotional code details and settings</p>
                        </div>
                    </div>
                    <a href="{{ route('promocodes.index') }}" class="modern-btn modern-btn-secondary">
                        <i class="fas fa-arrow-left"></i>
                        <span>Back to List</span>
                    </a>
                </div>
            </div>

            <!-- Form Section -->
            <div class="modern-form-card">
                <form method="POST" action="{{ route('promocodes.update', $promocode->id) }}" class="modern-form"
                    id="promocodeEditForm">
                    @csrf
                    @method('PUT')

                    <!-- Form Grid -->
                    <div class="form-grid">
                        <!-- Promocode Field -->
                        <div class="form-group-modern">
                            <label for="code" class="modern-label">
                                <i class="fas fa-code label-icon"></i>
                                Promocode
                            </label>
                            <div class="input-wrapper">
                                <div class="input-icon">
                                    <i class="fas fa-hashtag"></i>
                                </div>
                                <input type="text" class="modern-input @error('code') error @enderror" id="code"
                                    name="code" value="{{ old('code', $promocode->code) }}"
                                    placeholder="Enter promocode (e.g. SAVE20, WELCOME50)" pattern="[A-Za-z0-9]+"
                                    title="Only letters and numbers allowed" required>
                                <div class="input-border"></div>
                            </div>
                            @error('code')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                            <div class="field-hint">
                                <i class="fas fa-info-circle"></i>
                                Use alphanumeric characters only (A-Z, 0-9)
                            </div>
                        </div>

                        <!-- Discount Amount Field -->
                        <div class="form-group-modern">
                            <label for="discount" class="modern-label">
                                <i class="fas fa-money-bill-wave label-icon"></i>
                                Discount Amount
                            </label>
                            <div class="input-wrapper">
                                <div class="input-icon">
                                    <i class="fas fa-money-bill-wave"></i>
                                </div>
                                <input type="number" step="0.01" min="0"
                                    class="modern-input @error('discount') error @enderror" id="discount" name="discount"
                                    value="{{ old('discount', $promocode->discount) }}" placeholder="0.00" required>
                                <div class="input-suffix">{{ config('app.currency', 'AED') }}</div>
                                <div class="input-border"></div>
                            </div>
                            @error('discount')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                            <div class="field-hint">
                                <i class="fas fa-info-circle"></i>
                                Enter the fixed discount amount in {{ config('app.currency', 'AED') }}
                            </div>
                        </div>

                        <!-- Expiry Date Field -->
                        <div class="form-group-modern full-width">
                            <label for="expiry_date" class="modern-label">
                                <i class="fas fa-calendar-alt label-icon"></i>
                                Expiry Date
                                <span class="optional-badge">Optional</span>
                            </label>
                            <div class="input-wrapper">
                                <div class="input-icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <input type="datetime-local" class="modern-input @error('expiry_date') error @enderror"
                                    id="expiry_date" name="expiry_date"
                                    value="{{ old('expiry_date', $promocode->expiry_date ? $promocode->expiry_date->format('Y-m-d\TH:i') : '') }}">
                                <div class="input-border"></div>
                            </div>
                            @error('expiry_date')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                            <div class="field-hint">
                                <i class="fas fa-info-circle"></i>
                                Leave empty for no expiration date
                            </div>
                        </div>

                        <!-- For Active Subscription Toggle -->
                        <div class="form-group-modern full-width">
                            <label for="for_active_subscription" class="modern-label">
                                <i class="fas fa-user-check label-icon"></i>
                                For Active Subscription
                            </label>
                            <div class="toggle-wrapper">
                                <input type="hidden" name="for_active_subscription" id="for_active_subscription_hidden" value="{{ old('for_active_subscription', $promocode->for_active_subscription ?? 1) }}">
                                <div class="toggle-switch" id="toggleSwitch">
                                    <div class="toggle-option" data-value="0">
                                        <i class="fas fa-times"></i>
                                        <span>No</span>
                                    </div>
                                    <div class="toggle-option" data-value="1">
                                        <i class="fas fa-check"></i>
                                        <span>Yes</span>
                                    </div>
                                    <div class="toggle-slider"></div>
                                </div>
                            </div>
                            @error('for_active_subscription')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                            <div class="field-hint">
                                <i class="fas fa-info-circle"></i>
                                Enable this if the promocode is only for users with active subscriptions
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <button type="button" class="modern-btn modern-btn-outline" onclick="resetForm()">
                            <i class="fas fa-undo"></i>
                            <span>Reset Changes</span>
                        </button>
                        <button type="submit" class="modern-btn modern-btn-primary" id="submitBtn">
                            <i class="fas fa-save"></i>
                            <span>Update Promocode</span>
                            <div class="btn-loader">
                                <div class="spinner"></div>
                            </div>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        /* Modern Form Styles */
        .modern-form-container {
            max-width: 1000px;
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
            margin-bottom: 12px;
        }

        .label-icon {
            color: #00d4ff;
        }

        .optional-badge {
            background: rgba(255, 193, 7, 0.2);
            color: #ffc107;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 10px;
            font-weight: 500;
            margin-left: 8px;
        }

        .input-wrapper {
            position: relative;
        }

        .modern-input {
            width: 100%;
            padding: 16px 20px 16px 50px;
            background: rgba(255, 255, 255, 0.9);
            border: 2px solid rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            color: #334155;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .modern-input:focus {
            outline: none;
            border-color: #3b82f6;
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.2);
            transform: translateY(-2px);
        }

        .modern-input.error {
            border-color: #ff4757;
            box-shadow: 0 0 20px rgba(255, 71, 87, 0.2);
        }

        .modern-input::placeholder {
            color: rgba(51, 65, 85, 0.5);
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(51, 65, 85, 0.6);
            font-size: 14px;
            pointer-events: none;
            z-index: 2;
        }

        .input-suffix {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #00d4ff;
            font-weight: 600;
            font-size: 12px;
        }

        .input-border {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #00d4ff, #0099cc);
            transition: width 0.3s ease;
        }

        .modern-input:focus+.input-border {
            width: 100%;
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

        .field-hint {
            display: flex;
            align-items: center;
            gap: 6px;
            color: rgba(51, 65, 85, 0.6);
            font-size: 11px;
            margin-top: 6px;
        }

        /* Toggle Switch Styles */
        .toggle-wrapper {
            margin-top: 8px;
        }

        .toggle-switch {
            position: relative;
            display: inline-flex;
            background: rgba(255, 255, 255, 0.9);
            border: 2px solid rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            padding: 4px;
            gap: 4px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .toggle-option {
            position: relative;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            border-radius: 10px;
            color: rgba(51, 65, 85, 0.6);
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
            z-index: 2;
            cursor: pointer;
            min-width: 100px;
            justify-content: center;
        }

        .toggle-option i {
            font-size: 14px;
        }

        .toggle-option.active {
            color: #ffffff;
        }

        .toggle-slider {
            position: absolute;
            top: 4px;
            left: 4px;
            width: calc(50% - 4px);
            height: calc(100% - 8px);
            background: linear-gradient(135deg, #00d4ff, #0099cc);
            border-radius: 10px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 15px rgba(0, 212, 255, 0.4);
            z-index: 1;
        }

        .toggle-switch.no-selected .toggle-slider {
            left: 4px;
        }

        .toggle-switch.yes-selected .toggle-slider {
            left: calc(50% + 0px);
        }

        .toggle-option:hover {
            color: rgba(51, 65, 85, 0.8);
        }

        .toggle-option.active:hover {
            color: #ffffff;
        }

        .form-actions {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            flex-wrap: wrap;
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

        .modern-btn-outline {
            background: transparent;
            color: #334155;
            border: 2px solid rgba(0, 0, 0, 0.2);
        }

        .modern-btn-outline:hover {
            background: rgba(0, 0, 0, 0.05);
            border-color: rgba(0, 0, 0, 0.3);
        }

        .btn-loader {
            display: none;
            margin-left: 8px;
        }

        .spinner {
            width: 16px;
            height: 16px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top: 2px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
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

        /* Additional Responsive Enhancements */
        @media (max-width: 1024px) {
            .form-grid {
                grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
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

            .toggle-option {
                min-width: 80px;
                padding: 10px 16px;
            }
        }

        @media (max-width: 480px) {
            .toggle-option {
                min-width: 70px;
                padding: 8px 12px;
                font-size: 13px;
            }
        }
    </style>

    <script>
        // Form Enhancement Scripts
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('promocodeEditForm');
            const submitBtn = document.getElementById('submitBtn');
            const inputs = form.querySelectorAll('.modern-input');

            // Add input animations
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('focused');
                });

                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('focused');
                });

                // Auto-uppercase for code field
                if (input.name === 'code') {
                    input.addEventListener('input', function() {
                        this.value = this.value.toUpperCase();
                    });
                }
            });

            // Toggle Switch Functionality
            const toggleSwitch = document.getElementById('toggleSwitch');
            const hiddenInput = document.getElementById('for_active_subscription_hidden');
            const toggleOptions = toggleSwitch.querySelectorAll('.toggle-option');

            // Set initial state based on existing value
            // Convert to string and normalize (handle both 0/1 and true/false)
            let currentValue = String(hiddenInput.value);
            if (currentValue === 'true' || currentValue === '1') {
                currentValue = '1';
                hiddenInput.value = '1';
            } else if (currentValue === 'false' || currentValue === '0') {
                currentValue = '0';
                hiddenInput.value = '0';
            }

            toggleOptions.forEach(option => {
                if (option.getAttribute('data-value') === currentValue) {
                    option.classList.add('active');
                }
            });

            if (currentValue === '0') {
                toggleSwitch.classList.add('no-selected');
            } else {
                toggleSwitch.classList.add('yes-selected');
            }

            toggleOptions.forEach(option => {
                option.addEventListener('click', function() {
                    const value = this.getAttribute('data-value');

                    // Update hidden input
                    hiddenInput.value = value;

                    // Update active states
                    toggleOptions.forEach(opt => opt.classList.remove('active'));
                    this.classList.add('active');

                    // Update slider position
                    if (value === '0') {
                        toggleSwitch.classList.remove('yes-selected');
                        toggleSwitch.classList.add('no-selected');
                    } else {
                        toggleSwitch.classList.remove('no-selected');
                        toggleSwitch.classList.add('yes-selected');
                    }
                });
            });

            // Form submission with loading state
            form.addEventListener('submit', function() {
                submitBtn.disabled = true;
                submitBtn.querySelector('span').style.display = 'none';
                submitBtn.querySelector('.btn-loader').style.display = 'block';
            });
        });

        function resetForm() {
            if (confirm('Are you sure you want to reset all changes? This will restore the original values.')) {
                location.reload();
            }
        }
    </script>
@endsection
