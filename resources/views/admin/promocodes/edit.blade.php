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
                <form method="POST" action="{{ route('promocodes.update', $promocode->id) }}" class="modern-form" id="promocodeEditForm">
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
                                <input type="text" 
                                       class="modern-input @error('code') error @enderror" 
                                       id="code" 
                                       name="code" 
                                       value="{{ old('code', $promocode->code) }}"
                                       placeholder="Enter promocode (e.g. SAVE20, WELCOME50)"
                                       pattern="[A-Za-z0-9]+" 
                                       title="Only letters and numbers allowed"
                                       required>
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
                                <i class="fas fa-dollar-sign label-icon"></i>
                                Discount Amount
                            </label>
                            <div class="input-wrapper">
                                <div class="input-icon">
                                    <i class="fas fa-money-bill-wave"></i>
                                </div>
                                <input type="number" 
                                       step="0.01" 
                                       min="0" 
                                       class="modern-input @error('discount') error @enderror" 
                                       id="discount"
                                       name="discount" 
                                       value="{{ old('discount', $promocode->discount) }}"
                                       placeholder="0.00"
                                       required>
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
                                <input type="datetime-local" 
                                       class="modern-input @error('expiry_date') error @enderror" 
                                       id="expiry_date" 
                                       name="expiry_date"
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
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 20px 20px 0 0;
            padding: 30px;
            border: 1px solid rgba(255, 255, 255, 0.1);
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
            color: #ffffff;
            margin: 0;
            background: linear-gradient(135deg, #ffffff, #00d4ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .form-subtitle {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.7);
            margin: 5px 0 0 0;
        }

        .modern-form-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(15px);
            border-radius: 0 0 20px 20px;
            padding: 40px;
            border: 1px solid rgba(255, 255, 255, 0.1);
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
            color: #ffffff;
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
            background: rgba(255, 255, 255, 0.05);
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: #ffffff;
            font-size: 14px;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .modern-input:focus {
            outline: none;
            border-color: #00d4ff;
            background: rgba(255, 255, 255, 0.08);
            box-shadow: 0 0 20px rgba(0, 212, 255, 0.2);
            transform: translateY(-2px);
        }

        .modern-input.error {
            border-color: #ff4757;
            box-shadow: 0 0 20px rgba(255, 71, 87, 0.2);
        }

        .modern-input::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.6);
            font-size: 14px;
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

        .modern-input:focus + .input-border {
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
            color: rgba(255, 255, 255, 0.5);
            font-size: 11px;
            margin-top: 6px;
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
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .modern-btn-secondary:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-1px);
        }

        .modern-btn-outline {
            background: transparent;
            color: rgba(255, 255, 255, 0.8);
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        .modern-btn-outline:hover {
            background: rgba(255, 255, 255, 0.05);
            border-color: rgba(255, 255, 255, 0.3);
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
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
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

        /* Responsive Design */
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
            }

            .form-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .form-actions {
                justify-content: stretch;
            }

            .modern-btn {
                flex: 1;
                justify-content: center;
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
