@extends('admin.layouts.masterlayout')

@section('content')
    <style>
        /* Modern Services Form Styling */
        .modern-form-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }

        .form-header-section {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 20px 20px 0 0;
            padding: 30px;
            border: 1px solid rgba(255, 255, 255, 0.1);
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
            color: #ffffff;
            margin: 0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .form-subtitle {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.8);
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
            margin-bottom: 8px;
        }

        .text-cyan {
            color: #00d4ff;
        }

        .required-badge {
            background: linear-gradient(135deg, #ff4757, #ff3742);
            color: white;
            font-size: 10px;
            padding: 2px 6px;
            border-radius: 8px;
            font-weight: 500;
            margin-left: auto;
        }

        .optional-badge {
            background: linear-gradient(135deg, #ffc107, #ffb300);
            color: #333;
            font-size: 10px;
            padding: 2px 6px;
            border-radius: 8px;
            font-weight: 500;
            margin-left: auto;
        }

        .input-wrapper {
            position: relative;
        }

        .modern-input,
        .modern-select,
        .modern-textarea {
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

        .file-input {
            padding: 12px 20px 12px 50px;
        }

        .modern-select {
            appearance: none;
            cursor: pointer;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%23ffffff' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 12px center;
            background-repeat: no-repeat;
            background-size: 16px;
        }

        .modern-select option {
            background-color: #2d2d2d;
            color: #ffffff;
            padding: 10px 15px;
            border: none;
        }

        .modern-select option:hover,
        .modern-select option:focus,
        .modern-select option:checked {
            background-color: #404040;
            color: #00d4ff;
        }

        .modern-textarea {
            min-height: 120px;
            resize: vertical;
        }

        .modern-input:focus,
        .modern-select:focus,
        .modern-textarea:focus {
            outline: none;
            border-color: #00d4ff;
            background: rgba(255, 255, 255, 0.08);
            box-shadow: 0 0 20px rgba(0, 212, 255, 0.2);
            transform: translateY(-2px);
        }

        .modern-input::placeholder,
        .modern-textarea::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.5);
            font-size: 14px;
            pointer-events: none;
            transition: all 0.3s ease;
        }

        .input-wrapper:focus-within .input-icon {
            color: #00d4ff;
            transform: translateY(-50%) scale(1.1);
        }

        .input-suffix {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.7);
            font-size: 12px;
            font-weight: 500;
            pointer-events: none;
        }

        /* Dynamic Lists */
        .dynamic-list-container,
        .requirements-container,
        .processes-container {
            background: rgba(255, 255, 255, 0.03);
            border-radius: 12px;
            padding: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .dynamic-item {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
        }

        .dynamic-item:last-child {
            margin-bottom: 0;
        }

        .dynamic-item .input-wrapper {
            flex: 1;
        }

        .requirement-item {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
        }

        .requirement-fields {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 15px;
        }

        .process-item {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
        }

        .process-fields {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 15px;
            margin-bottom: 15px;
        }

        @media (max-width: 768px) {
            .process-fields {
                grid-template-columns: 1fr;
            }
        }

        .modern-btn-remove {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            border: none;
            background: rgba(239, 68, 68, 0.2);
            color: #ef4444;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            top: 15px;
            right: 15px;
        }

        .modern-btn-remove:hover {
            background: rgba(239, 68, 68, 0.3);
            transform: scale(1.1);
        }

        /* Pricing Section */
        .pricing-section {
            background: rgba(0, 212, 255, 0.05);
            border-radius: 15px;
            padding: 25px;
            border: 1px solid rgba(0, 212, 255, 0.1);
            margin-bottom: 30px;
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 18px;
            font-weight: 600;
            color: #00d4ff;
            margin: 0 0 20px 0;
        }

        .pricing-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .pricing-option-container {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .pricing-option-header {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 0;
        }

        .pricing-option-container .checkbox-text {
            font-size: 13px;
            font-weight: 600;
            color: #00d4ff;
            margin: 0;
            cursor: pointer;
        }

        .pricing-input {
            transition: all 0.3s ease;
        }

        .pricing-description {
            margin-top: 15px;
        }

        .pricing-horizontal-layout {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-top: 15px;
        }

        @media (max-width: 768px) {
            .pricing-horizontal-layout {
                grid-template-columns: 1fr;
            }
        }

        /* Checkbox Styling */
        .checkbox-wrapper {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 15px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            border: 2px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .checkbox-wrapper:hover {
            border-color: rgba(0, 212, 255, 0.3);
            background: rgba(255, 255, 255, 0.08);
        }

        .modern-checkbox {
            width: 20px;
            height: 20px;
            border-radius: 4px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            background: transparent;
            cursor: pointer;
            position: relative;
            appearance: none;
            transition: all 0.3s ease;
        }

        .modern-checkbox:checked {
            background: linear-gradient(135deg, #00d4ff, #0099cc);
            border-color: #00d4ff;
        }

        .modern-checkbox:checked::after {
            content: '✓';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 12px;
            font-weight: bold;
        }

        .checkbox-text {
            color: #ffffff;
            font-size: 14px;
            cursor: pointer;
            margin: 0;
        }

        .error-message {
            display: flex;
            align-items: center;
            gap: 6px;
            color: #ff4757;
            font-size: 12px;
            margin-top: 6px;
            animation: slideInUp 0.3s ease;
        }

        .field-hint {
            display: flex;
            align-items: center;
            gap: 6px;
            color: rgba(255, 255, 255, 0.6);
            font-size: 11px;
            margin-top: 4px;
        }

        .form-actions {
            display: flex;
            gap: 15px;
            justify-content: flex-start;
            flex-wrap: wrap;
        }

        .modern-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 14px 28px;
            border: none;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
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

        .modern-btn-outline {
            background: transparent;
            color: rgba(255, 255, 255, 0.8);
            border: 2px solid rgba(255, 255, 255, 0.2);
            padding: 10px 20px;
            font-size: 13px;
        }

        .modern-btn-outline:hover {
            background: rgba(255, 255, 255, 0.05);
            border-color: #00d4ff;
            color: #00d4ff;
        }

        .btn-loader {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
        }

        .modern-btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none !important;
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

        /* Frequency Management Styles */
        .frequency-section {
            margin-bottom: 30px;
            background: rgba(255, 255, 255, 0.02);
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            overflow: hidden;
        }

        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px;
            background: rgba(0, 212, 255, 0.08);
            border-bottom: 1px solid rgba(0, 212, 255, 0.2);
        }

        .section-header .checkbox-text {
            color: #00d4ff !important;
            font-weight: 600;
            font-size: 16px;
        }

        .frequency-options {
            padding: 20px;
        }

        .frequency-container {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .frequency-item {
            background: rgba(0, 212, 255, 0.02);
            border: 2px solid rgba(0, 212, 255, 0.1);
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .frequency-item:hover {
            border-color: rgba(0, 212, 255, 0.3);
            background: rgba(0, 212, 255, 0.05);
            transform: translateY(-2px);
        }

        .frequency-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 20px;
            background: rgba(0, 212, 255, 0.08);
            border-bottom: 1px solid rgba(0, 212, 255, 0.15);
        }

        .frequency-title {
            font-weight: 600;
            color: #00d4ff;
            font-size: 14px;
        }

        .frequency-content {
            padding: 20px;
        }

        .frequency-row {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr;
            gap: 20px;
        }

        .frequency-no {
            order: -4;
        }

        .frequency-duration {
            order: -3;
        }

        .frequency-price {
            order: -2;
        }

        .frequency-material {
            order: -1;
            margin-top: 10px;
        }

        .frequency-material .checkbox-wrapper {
            padding: 12px 15px;
            min-height: auto;
        }

        .frequency-material .checkbox-text {
            font-size: 12px;
        }

        /* Responsive Frequency Styling */
        @media (max-width: 1024px) {
            .frequency-row {
                grid-template-columns: 1fr 1fr;
            }

            .frequency-no {
                order: 0;
            }

            .frequency-price {
                order: 0;
            }

            .frequency-material {
                order: 0;
                grid-column: 1 / -1;
                margin-top: 0;
            }
        }

        @media (max-width: 768px) {
            .frequency-row {
                grid-template-columns: 1fr;
            }

            .frequency-material {
                order: 0;
            }

            .section-header {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }

            .frequency-options {
                padding: 15px;
            }

            .frequency-container {
                gap: 10px;
            }

            .frequency-header {
                padding: 12px 15px;
                flex-direction: column;
                gap: 10px;
                align-items: flex-start;
            }

            .frequency-content {
                padding: 15px;
            }
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

            .pricing-grid {
                grid-template-columns: 1fr;
            }

            .requirement-fields {
                grid-template-columns: 1fr;
            }

            .form-actions {
                justify-content: center;
            }

            .modern-btn {
                flex: 1;
                justify-content: center;
                min-width: 140px;
            }
        }
    </style>
    <div class="modern-form-container">
        <!-- Form Header Section -->
        <div class="form-header-section">
            <div class="form-header-content">
                <div class="form-icon-wrapper">
                    <i class="fas fa-concierge-bell"></i>
                </div>
                <div class="form-header-text">
                    <h1 class="form-title">Create Service</h1>
                    <p class="form-subtitle">Add a new service to your platform</p>
                </div>
            </div>
            <div class="form-header-actions">
                <a href="{{ route('services.services.index') }}" class="modern-btn modern-btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Back to Services
                </a>
            </div>
        </div>

        <!-- Form Card -->
        <div class="modern-form-card">
            <form method="POST" action="{{ route('services.services.store') }}" id="serviceForm"
                enctype="multipart/form-data">
                @csrf

                <div class="form-grid">
                    <!-- Category Dropdown -->
                    <div class="form-group-modern">
                        <label for="category_id" class="modern-label">
                            <i class="fas fa-folder text-cyan"></i>
                            Category
                            <span class="required-badge">Required</span>
                        </label>
                        <div class="input-wrapper">
                            <select class="modern-select" id="category_id" name="category_id" required>
                                <option value="">Select Category</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}"
                                        {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                            <i class="fas fa-folder input-icon"></i>
                        </div>
                        @error('category_id')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="field-hint">
                            <i class="fas fa-info-circle"></i>
                            Select the main category for this service
                        </div>
                    </div>

                    <!-- Subcategory Dropdown -->
                    <div class="form-group-modern">
                        <label for="subcategory_id" class="modern-label">
                            <i class="fas fa-folder-open text-cyan"></i>
                            Subcategory
                            <span class="optional-badge">Optional</span>
                        </label>
                        <div class="input-wrapper">
                            <select class="modern-select" id="subcategory_id" name="subcategory_id">
                                <option value="">None</option>
                                @foreach ($subcategories as $sub)
                                    <option value="{{ $sub->id }}"
                                        {{ old('subcategory_id') == $sub->id ? 'selected' : '' }}>
                                        {{ $sub->name }}
                                    </option>
                                @endforeach
                            </select>
                            <i class="fas fa-folder-open input-icon"></i>
                        </div>
                        @error('subcategory_id')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="field-hint">
                            <i class="fas fa-info-circle"></i>
                            Choose a subcategory if applicable
                        </div>
                    </div>

                    <!-- Service Name (Full Width) -->
                    <div class="form-group-modern full-width">
                        <label for="name" class="modern-label">
                            <i class="fas fa-tag text-cyan"></i>
                            Service Name
                            <span class="required-badge">Required</span>
                        </label>
                        <div class="input-wrapper">
                            <input type="text" class="modern-input" id="name" name="name"
                                value="{{ old('name') }}" placeholder="Enter service name" required>
                            <i class="fas fa-tag input-icon"></i>
                        </div>
                        @error('name')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="field-hint">
                            <i class="fas fa-info-circle"></i>
                            Choose a clear and descriptive name for the service
                        </div>
                    </div>

                    <!-- Short Description (Full Width) -->
                    <div class="form-group-modern full-width">
                        <label for="short_description" class="modern-label">
                            <i class="fas fa-align-left text-cyan"></i>
                            Short Description
                            <span class="optional-badge">Optional</span>
                        </label>
                        <div class="input-wrapper">
                            <textarea class="modern-textarea" id="short_description" name="short_description"
                                placeholder="Enter a brief description">{{ old('short_description') }}</textarea>
                            <i class="fas fa-align-left input-icon"></i>
                        </div>
                        @error('short_description')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="field-hint">
                            <i class="fas fa-info-circle"></i>
                            A brief summary of the service (used in listings)
                        </div>
                    </div>

                    <!-- Add Our Processes (Full Width) -->
                    <div class="form-group-modern full-width">
                        <label class="modern-label">
                            <i class="fas fa-cogs text-cyan"></i>
                            Add Our Processes
                            <span class="optional-badge">Optional</span>
                        </label>
                        <div class="processes-container">
                            <div id="processes_container">
                                @if (old('processes'))
                                    @foreach (old('processes') as $index => $process)
                                        <div class="process-item">
                                            <div class="process-fields">
                                                <div class="input-wrapper">
                                                    <input type="text" name="processes[{{ $index }}][title]"
                                                        value="{{ $process['title'] ?? '' }}" class="modern-input"
                                                        placeholder="Process title">
                                                    <i class="fas fa-text-width input-icon"></i>
                                                </div>
                                                <div class="input-wrapper">
                                                    <textarea name="processes[{{ $index }}][description]" class="modern-textarea"
                                                        placeholder="Process description">{{ $process['description'] ?? '' }}</textarea>
                                                    <i class="fas fa-align-left input-icon"></i>
                                                </div>
                                                <div class="input-wrapper">
                                                    <input type="file" name="processes[{{ $index }}][image]"
                                                        class="modern-input file-input" accept="image/*">
                                                    <i class="fas fa-image input-icon"></i>
                                                </div>
                                            </div>
                                            @if ($index > 0)
                                                <button type="button" class="modern-btn-remove remove-process">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            @endif
                                        </div>
                                    @endforeach
                                @else
                                    <div class="process-item">
                                        <div class="process-fields">
                                            <div class="input-wrapper">
                                                <input type="text" name="processes[0][title]" class="modern-input"
                                                    placeholder="Process title">
                                                <i class="fas fa-text-width input-icon"></i>
                                            </div>
                                            <div class="input-wrapper">
                                                <textarea name="processes[0][description]" class="modern-textarea" placeholder="Process description"></textarea>
                                                <i class="fas fa-align-left input-icon"></i>
                                            </div>
                                            <div class="input-wrapper">
                                                <input type="file" name="processes[0][image]"
                                                    class="modern-input file-input" accept="image/*">
                                                <i class="fas fa-image input-icon"></i>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <button type="button" id="add_process" class="modern-btn modern-btn-outline">
                                <i class="fas fa-plus"></i>
                                Add Process
                            </button>
                        </div>
                        @error('processes')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="field-hint">
                            <i class="fas fa-info-circle"></i>
                            Define the step-by-step processes involved in delivering this service
                        </div>
                    </div>

                    <!-- Description (Full Width) -->
                    <div class="form-group-modern full-width">
                        <label for="description" class="modern-label">
                            <i class="fas fa-file-alt text-cyan"></i>
                            Detailed Description
                            <span class="optional-badge">Optional</span>
                        </label>
                        <div class="input-wrapper">
                            <textarea class="modern-textarea" id="description" name="description" placeholder="Enter detailed description">{{ old('description') }}</textarea>
                            <i class="fas fa-file-alt input-icon"></i>
                        </div>
                        @error('description')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="field-hint">
                            <i class="fas fa-info-circle"></i>
                            Comprehensive description of the service and what it includes
                        </div>
                    </div>

                    <!-- What's Included (Full Width) -->
                    <div class="form-group-modern full-width">
                        <label class="modern-label">
                            <i class="fas fa-check-circle text-cyan"></i>
                            What's Included
                            <span class="optional-badge">Optional</span>
                        </label>
                        <div class="dynamic-list-container">
                            <div id="whats_include_container">
                                @if (old('whats_include'))
                                    @foreach (old('whats_include') as $index => $include)
                                        <div class="dynamic-item">
                                            <div class="input-wrapper">
                                                <input type="text" name="whats_include[]" value="{{ $include }}"
                                                    class="modern-input" placeholder="Enter what's included">
                                                <i class="fas fa-check input-icon"></i>
                                            </div>
                                            @if ($index > 0)
                                                <button type="button" class="modern-btn-remove remove-include">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            @endif
                                        </div>
                                    @endforeach
                                @else
                                    <div class="dynamic-item">
                                        <div class="input-wrapper">
                                            <input type="text" name="whats_include[]" class="modern-input"
                                                placeholder="Enter what's included">
                                            <i class="fas fa-check input-icon"></i>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <button type="button" id="add_include" class="modern-btn modern-btn-outline">
                                <i class="fas fa-plus"></i>
                                Add Item
                            </button>
                        </div>
                        @error('whats_include')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="field-hint">
                            <i class="fas fa-info-circle"></i>
                            List what customers will receive with this service
                        </div>
                    </div>

                    <!-- Requirements (Full Width) -->
                    <div class="form-group-modern full-width">
                        <label class="modern-label">
                            <i class="fas fa-clipboard-list text-cyan"></i>
                            What We Need From You
                            <span class="optional-badge">Optional</span>
                        </label>
                        <div class="requirements-container">
                            <div id="requirements_container">
                                @if (old('requirements'))
                                    @foreach (old('requirements') as $index => $req)
                                        <div class="requirement-item">
                                            <div class="requirement-fields">
                                                <div class="input-wrapper">
                                                    <input type="text" name="requirements[{{ $index }}][title]"
                                                        class="modern-input" placeholder="Requirement title">
                                                    <i class="fas fa-text-width input-icon"></i>
                                                </div>
                                                <div class="input-wrapper">
                                                    <input type="file" name="requirements[{{ $index }}][image]"
                                                        class="modern-input file-input" accept="image/*">
                                                    <i class="fas fa-image input-icon"></i>
                                                </div>
                                            </div>
                                            @if ($index > 0)
                                                <button type="button" class="modern-btn-remove remove-requirement">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            @endif
                                        </div>
                                    @endforeach
                                @else
                                    <div class="requirement-item">
                                        <div class="requirement-fields">
                                            <div class="input-wrapper">
                                                <input type="text" name="requirements[0][title]" class="modern-input"
                                                    placeholder="Requirement title">
                                                <i class="fas fa-text-width input-icon"></i>
                                            </div>
                                            <div class="input-wrapper">
                                                <input type="file" name="requirements[0][image]"
                                                    class="modern-input file-input" accept="image/*">
                                                <i class="fas fa-image input-icon"></i>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <button type="button" id="add_requirement" class="modern-btn modern-btn-outline">
                                <i class="fas fa-plus"></i>
                                Add Requirement
                            </button>
                        </div>
                        @error('requirements')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="field-hint">
                            <i class="fas fa-info-circle"></i>
                            Specify what customers need to provide for this service
                        </div>
                    </div>
                </div> <!-- Closing form-grid -->
                
                <!-- Pricing Section -->
                <div class="full-width-section">
                    <div class="pricing-section">
                        <h3 class="section-title">
                            Pricing & Subscription Options
                        </h3>

                            <!-- One Time Service -->
                            <div class="frequency-section">
                                <div class="section-header">
                                    <input type="checkbox" class="modern-checkbox" id="enable_onetime" checked>
                                    <label for="enable_onetime" class="checkbox-text">
                                        <i class="fas fa-hand-point-right text-cyan"></i> One Time Service
                                    </label>
                                </div>

                                <div class="frequency-options" id="onetime_options" style="display: block;">
                                <div class="pricing-horizontal-layout">
                                    <div class="form-group-modern pricing-input">
                                        <label for="price_onetime" class="modern-label">
                                            <i class="fas fa-money-bill text-cyan"></i>
                                            Price
                                            <span class="optional-badge">Optional</span>
                                        </label>
                                        <div class="input-wrapper">
                                            <input type="number" class="modern-input" id="price_onetime"
                                                name="price_onetime" value="{{ old('price_onetime') }}"
                                                step="0.01" min="0" placeholder="0.00">
                                            <span class="input-suffix">AED</span>
                                        </div>
                                    </div>
                                    <div class="form-group-modern pricing-description">
                                        <label for="price_onetime_description" class="modern-label">
                                            <i class="fas fa-align-left text-cyan"></i>
                                            Description
                                            <span class="optional-badge">Optional</span>
                                        </label>
                                        <div class="input-wrapper">
                                            <textarea class="modern-textarea" id="price_onetime_description" name="price_onetime_description"
                                                placeholder="Descibe the one time service">{{ old('price_onetime_description') }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                </div>
                            </div>

                            <!-- Weekly Subscription -->
                            <div class="frequency-section">
                                <div class="section-header">
                                    <input type="checkbox" class="modern-checkbox" id="enable_weekly">
                                    <label for="enable_weekly" class="checkbox-text">
                                        <i class="fas fa-calendar-week text-cyan"></i> Weekly Subscription
                                    </label>
                                </div>

                                <div class="frequency-options" id="weekly_options" style="display: none;">
                                    <div class="frequency-container" id="weekly_frequencies">
                                        @if (old('weekly_frequencies'))
                                            @foreach (old('weekly_frequencies') as $index => $frequency)
                                                <div class="frequency-item">
                                                    <div class="frequency-header">
                                                        <span class="frequency-title">Weekly Option
                                                            {{ $index + 1 }}</span>
                                                        @if ($index > 0)
                                                            <button type="button"
                                                                class="modern-btn-remove remove-frequency">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        @endif
                                                    </div>
                                                    <div class="frequency-content">
                                                        <div class="frequency-row">
                                                            <div class="form-group-modern frequency-no">
                                                                <label class="modern-label">
                                                                    <i class="fas fa-hashtag text-cyan"></i>
                                                                    Times per Week
                                                                </label>
                                                                <div class="input-wrapper">
                                                                    <select class="modern-select frequency-no-select"
                                                                        name="weekly_frequencies[{{ $index }}][no_of_times]">
                                                                        @for ($i = 1; $i <= 7; $i++)
                                                                            <option value="{{ $i }}"
                                                                                {{ ($frequency['no_of_times'] ?? $i) == $i ? 'selected' : '' }}>
                                                                                {{ $i }}
                                                                                time{{ $i > 1 ? 's' : '' }}
                                                                            </option>
                                                                        @endfor
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group-modern frequency-duration">
                                                                <label class="modern-label">
                                                                    <i class="fas fa-clock text-cyan"></i>
                                                                    Duration
                                                                </label>
                                                                <div class="input-wrapper">
                                                                    <select class="modern-select"
                                                                        name="weekly_frequencies[{{ $index }}][duration]">
                                                                        @for ($i = 1; $i <= 10; $i++)
                                                                            <option value="{{ $i }}"
                                                                                {{ ($frequency['duration'] ?? 1) == $i ? 'selected' : '' }}>
                                                                                {{ $i }} hour{{ $i > 1 ? 's' : '' }}
                                                                            </option>
                                                                        @endfor
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group-modern frequency-price">
                                                                <label class="modern-label">
                                                                    <i class="fas fa-money-bill text-cyan"></i>
                                                                    Price per Service
                                                                </label>
                                                                <div class="input-wrapper">
                                                                    <input type="number" class="modern-input"
                                                                        name="weekly_frequencies[{{ $index }}][price_per_time]"
                                                                        value="{{ $frequency['price_per_time'] ?? '' }}"
                                                                        step="0.01" min="0" placeholder="0.00">
                                                                    <span class="input-suffix">AED</span>
                                                                </div>
                                                            </div>
                                                            <div class="form-group-modern frequency-material">
                                                                <label class="modern-label">
                                                                    <i class="fas fa-tools text-cyan"></i>
                                                                    With Material
                                                                </label>
                                                                <div class="checkbox-wrapper">
                                                                    <input type="checkbox" class="modern-checkbox"
                                                                        name="weekly_frequencies[{{ $index }}][with_material]"
                                                                        value="1"
                                                                        {{ $frequency['with_material'] ?? 0 ? 'checked' : '' }}>
                                                                    <label class="checkbox-text">Material included (+100 Rs)</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="frequency-item">
                                                <div class="frequency-header">
                                                    <span class="frequency-title">Weekly Option 1</span>
                                                </div>
                                                <div class="frequency-content">
                                                    <div class="frequency-row">
                                                        <div class="form-group-modern frequency-no">
                                                            <label class="modern-label">
                                                                <i class="fas fa-hashtag text-cyan"></i>
                                                                Times per Week
                                                            </label>
                                                            <div class="input-wrapper">
                                                                <select class="modern-select frequency-no-select"
                                                                    name="weekly_frequencies[0][no_of_times]">
                                                                    @for ($i = 1; $i <= 7; $i++)
                                                                        <option value="{{ $i }}"
                                                                            {{ $i == 1 ? 'selected' : '' }}>
                                                                            {{ $i }}
                                                                            time{{ $i > 1 ? 's' : '' }}
                                                                        </option>
                                                                    @endfor
                                                                </select>
                                                            </div>
                                                        </div>
                                                            <div class="form-group-modern frequency-duration">
                                                                <label class="modern-label">
                                                                    <i class="fas fa-clock text-cyan"></i>
                                                                    Duration
                                                                </label>
                                                                <div class="input-wrapper">
                                                                    <select class="modern-select"
                                                                        name="weekly_frequencies[0][duration]">
                                                                        @for ($i = 1; $i <= 10; $i++)
                                                                            <option value="{{ $i }}"
                                                                                {{ $i == 1 ? 'selected' : '' }}>
                                                                                {{ $i }} hour{{ $i > 1 ? 's' : '' }}
                                                                            </option>
                                                                        @endfor
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group-modern frequency-price">
                                                                <label class="modern-label">
                                                                    <i class="fas fa-money-bill text-cyan"></i>
                                                                    Price per Service
                                                                </label>
                                                                <div class="input-wrapper">
                                                                    <input type="number" class="modern-input"
                                                                        name="weekly_frequencies[0][price_per_time]"
                                                                        step="0.01" min="0" placeholder="0.00">
                                                                    <span class="input-suffix">AED</span>
                                                                </div>
                                                            </div>
                                                            <div class="form-group-modern frequency-material">
                                                                <label class="modern-label">
                                                                    <i class="fas fa-tools text-cyan"></i>
                                                                    With Material
                                                                </label>
                                                                <div class="checkbox-wrapper">
                                                                    <input type="checkbox" class="modern-checkbox"
                                                                        name="weekly_frequencies[0][with_material]"
                                                                        value="1">
                                                                    <label class="checkbox-text">Material included (+100 Rs)</label>
                                                                </div>
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <button type="button" id="add_weekly_frequency"
                                        class="modern-btn modern-btn-outline">
                                        <i class="fas fa-plus"></i> Add Weekly Option
                                    </button>
                                </div>
                            </div>

                            <!-- Monthly Subscription -->
                            <div class="frequency-section">
                                <div class="section-header">
                                    <input type="checkbox" class="modern-checkbox" id="enable_monthly">
                                    <label for="enable_monthly" class="checkbox-text">
                                        <i class="fas fa-calendar-alt text-cyan"></i> Monthly Subscription
                                    </label>
                                </div>

                                <div class="frequency-options" id="monthly_options" style="display: none;">
                                    <div class="frequency-container" id="monthly_frequencies">
                                        @if (old('monthly_frequencies'))
                                            @foreach (old('monthly_frequencies') as $index => $frequency)
                                                <div class="frequency-item">
                                                    <div class="frequency-header">
                                                        <span class="frequency-title">Monthly Option
                                                            {{ $index + 1 }}</span>
                                                        @if ($index > 0)
                                                            <button type="button"
                                                                class="modern-btn-remove remove-frequency">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        @endif
                                                    </div>
                                                    <div class="frequency-content">
                                                        <div class="frequency-row">
                                                            <div class="form-group-modern frequency-no">
                                                                <label class="modern-label">
                                                                    <i class="fas fa-hashtag text-cyan"></i>
                                                                    Times per Month
                                                                </label>
                                                                <div class="input-wrapper">
                                                                    <select class="modern-select frequency-no-select"
                                                                        name="monthly_frequencies[{{ $index }}][no_of_times]">
                                                                        @for ($i = 1; $i <= 30; $i++)
                                                                            <option value="{{ $i }}"
                                                                                {{ ($frequency['no_of_times'] ?? $i) == $i ? 'selected' : '' }}>
                                                                                {{ $i }}
                                                                                time{{ $i > 1 ? 's' : '' }}
                                                                            </option>
                                                                        @endfor
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group-modern frequency-price">
                                                                <label class="modern-label">
                                                                    <i class="fas fa-money-bill text-cyan"></i>
                                                                    Price per Time
                                                                </label>
                                                                <div class="input-wrapper">
                                                                    <input type="number" class="modern-input"
                                                                        name="monthly_frequencies[{{ $index }}][price_per_time]"
                                                                        value="{{ $frequency['price_per_time'] ?? '' }}"
                                                                        step="0.01" min="0" placeholder="0.00">
                                                                    <span class="input-suffix">AED</span>
                                                                </div>
                                                            </div>
                                                            <div class="form-group-modern frequency-material">
                                                                <label class="modern-label">
                                                                    <i class="fas fa-tools text-cyan"></i>
                                                                    With Material
                                                                </label>
                                                                <div class="checkbox-wrapper">
                                                                    <input type="checkbox" class="modern-checkbox"
                                                                        name="monthly_frequencies[{{ $index }}][with_material]"
                                                                        value="1"
                                                                        {{ $frequency['with_material'] ?? 0 ? 'checked' : '' }}>
                                                                    <label class="checkbox-text">Material included</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="frequency-item">
                                                <div class="frequency-header">
                                                    <span class="frequency-title">Monthly Option 1</span>
                                                </div>
                                                <div class="frequency-content">
                                                    <div class="frequency-row">
                                                        <div class="form-group-modern frequency-no">
                                                            <label class="modern-label">
                                                                <i class="fas fa-hashtag text-cyan"></i>
                                                                Times per Month
                                                            </label>
                                                            <div class="input-wrapper">
                                                                <select class="modern-select frequency-no-select"
                                                                    name="monthly_frequencies[0][no_of_times]">
                                                                    @for ($i = 1; $i <= 30; $i++)
                                                                        <option value="{{ $i }}"
                                                                            {{ $i == 1 ? 'selected' : '' }}>
                                                                            {{ $i }}
                                                                            time{{ $i > 1 ? 's' : '' }}
                                                                        </option>
                                                                    @endfor
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group-modern frequency-price">
                                                            <label class="modern-label">
                                                                <i class="fas fa-money-bill text-cyan"></i>
                                                                Price per Time
                                                            </label>
                                                            <div class="input-wrapper">
                                                                <input type="number" class="modern-input"
                                                                    name="monthly_frequencies[0][price_per_time]"
                                                                    step="0.01" min="0" placeholder="0.00">
                                                                <span class="input-suffix">AED</span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group-modern frequency-material">
                                                            <label class="modern-label">
                                                                <i class="fas fa-tools text-cyan"></i>
                                                                With Material
                                                            </label>
                                                            <div class="checkbox-wrapper">
                                                                <input type="checkbox" class="modern-checkbox"
                                                                    name="monthly_frequencies[0][with_material]"
                                                                    value="1">
                                                                <label class="checkbox-text">Material included</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <button type="button" id="add_monthly_frequency"
                                        class="modern-btn modern-btn-outline">
                                        <i class="fas fa-plus"></i> Add Monthly Option
                                    </button>
                                </div>
                            </div>

                            <!-- Yearly Subscription -->
                            <div class="frequency-section">
                                <div class="section-header">
                                    <input type="checkbox" class="modern-checkbox" id="enable_yearly">
                                    <label for="enable_yearly" class="checkbox-text">
                                        <i class="fas fa-calendar text-cyan"></i> Yearly Subscription
                                    </label>
                                </div>

                                <div class="frequency-options" id="yearly_options" style="display: none;">
                                    <div class="frequency-container" id="yearly_frequencies">
                                        @if (old('yearly_frequencies'))
                                            @foreach (old('yearly_frequencies') as $index => $frequency)
                                                <div class="frequency-item">
                                                    <div class="frequency-header">
                                                        <span class="frequency-title">Yearly Option
                                                            {{ $index + 1 }}</span>
                                                        @if ($index > 0)
                                                            <button type="button"
                                                                class="modern-btn-remove remove-frequency">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        @endif
                                                    </div>
                                                    <div class="frequency-content">
                                                        <div class="frequency-row">
                                                            <div class="form-group-modern frequency-no">
                                                                <label class="modern-label">
                                                                    <i class="fas fa-hashtag text-cyan"></i>
                                                                    Times per Year
                                                                </label>
                                                                <div class="input-wrapper">
                                                                    <select class="modern-select frequency-no-select"
                                                                        name="yearly_frequencies[{{ $index }}][no_of_times]">
                                                                        @for ($i = 1; $i <= 12; $i++)
                                                                            <option value="{{ $i }}"
                                                                                {{ ($frequency['no_of_times'] ?? $i) == $i ? 'selected' : '' }}>
                                                                                {{ $i }}
                                                                                time{{ $i > 1 ? 's' : '' }}
                                                                            </option>
                                                                        @endfor
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group-modern frequency-price">
                                                                <label class="modern-label">
                                                                    <i class="fas fa-money-bill text-cyan"></i>
                                                                    Price per Time
                                                                </label>
                                                                <div class="input-wrapper">
                                                                    <input type="number" class="modern-input"
                                                                        name="yearly_frequencies[{{ $index }}][price_per_time]"
                                                                        value="{{ $frequency['price_per_time'] ?? '' }}"
                                                                        step="0.01" min="0" placeholder="0.00">
                                                                    <span class="input-suffix">AED</span>
                                                                </div>
                                                            </div>
                                                            <div class="form-group-modern frequency-material">
                                                                <label class="modern-label">
                                                                    <i class="fas fa-tools text-cyan"></i>
                                                                    With Material
                                                                </label>
                                                                <div class="checkbox-wrapper">
                                                                    <input type="checkbox" class="modern-checkbox"
                                                                        name="yearly_frequencies[{{ $index }}][with_material]"
                                                                        value="1"
                                                                        {{ $frequency['with_material'] ?? 0 ? 'checked' : '' }}>
                                                                    <label class="checkbox-text">Material included</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="frequency-item">
                                                <div class="frequency-header">
                                                    <span class="frequency-title">Yearly Option 1</span>
                                                </div>
                                                <div class="frequency-content">
                                                    <div class="frequency-row">
                                                        <div class="form-group-modern frequency-no">
                                                            <label class="modern-label">
                                                                <i class="fas fa-hashtag text-cyan"></i>
                                                                Times per Year
                                                            </label>
                                                            <div class="input-wrapper">
                                                                <select class="modern-select frequency-no-select"
                                                                    name="yearly_frequencies[0][no_of_times]">
                                                                    @for ($i = 1; $i <= 12; $i++)
                                                                        <option value="{{ $i }}"
                                                                            {{ $i == 1 ? 'selected' : '' }}>
                                                                            {{ $i }}
                                                                            time{{ $i > 1 ? 's' : '' }}
                                                                        </option>
                                                                    @endfor
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group-modern frequency-price">
                                                            <label class="modern-label">
                                                                <i class="fas fa-money-bill text-cyan"></i>
                                                                Price per Time
                                                            </label>
                                                            <div class="input-wrapper">
                                                                <input type="number" class="modern-input"
                                                                    name="yearly_frequencies[0][price_per_time]"
                                                                    step="0.01" min="0" placeholder="0.00">
                                                                <span class="input-suffix">AED</span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group-modern frequency-material">
                                                            <label class="modern-label">
                                                                <i class="fas fa-tools text-cyan"></i>
                                                                With Material
                                                            </label>
                                                            <div class="checkbox-wrapper">
                                                                <input type="checkbox" class="modern-checkbox"
                                                                    name="yearly_frequencies[0][with_material]"
                                                                    value="1">
                                                                <label class="checkbox-text">Material included</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <button type="button" id="add_yearly_frequency"
                                        class="modern-btn modern-btn-outline">
                                        <i class="fas fa-plus"></i> Add Yearly Option
                                    </button>
                                </div>
                                </div>
                            </div>

                            <!-- Additional Options within Pricing Section -->
                            <div class="pricing-additional-options" style="margin-top: 20px; border-top: 1px solid rgba(0, 212, 255, 0.1); padding-top: 20px;">
                                <div class="row">
                                    <!-- Status -->
                                    <div class="col-md-6">
                                        <div class="form-group-modern action-field">
                                            <label for="status" class="modern-label">
                                                <i class="fas fa-toggle-on text-cyan"></i>
                                                Status
                                                <span class="required-badge">Required</span>
                                            </label>
                                            <div class="input-wrapper">
                                                <select class="modern-select" id="status" name="status" required>
                                                    <option value="active"
                                                        {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active
                                                    </option>
                                                    <option value="inactive"
                                                        {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive
                                                    </option>
                                                </select>
                                                <i class="fas fa-toggle-on input-icon"></i>
                                            </div>
                                            @error('status')
                                                <div class="error-message">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Arabic Support -->
                                    <div class="col-md-6">
                                        <div class="form-group-modern action-field">
                                            <label class="modern-label checkbox-label">
                                                <i class="fas fa-language text-cyan"></i>
                                                Arabic Support
                                                <span class="optional-badge">Optional</span>
                                            </label>
                                            <div class="checkbox-wrapper">
                                                <input type="checkbox" class="modern-checkbox" id="is_arabic"
                                                    name="is_arabic" value="1" {{ old('is_arabic') ? 'checked' : '' }}>
                                                <label for="is_arabic" class="checkbox-text">This service supports Arabic
                                                    language</label>
                                            </div>
                                            @error('is_arabic')
                                                <div class="error-message">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                        {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Form Fields (Service Image and Actions) -->
                    <div class="form-grid">
                        <!-- Service Image (Full Width) -->
                    <div class="form-group-modern full-width">
                        <label for="image" class="modern-label">
                            <i class="fas fa-image text-cyan"></i>
                            Service Image
                            <span class="optional-badge">Optional</span>
                        </label>
                        <div class="input-wrapper">
                            <input type="file" class="modern-input file-input" id="image" name="image"
                                accept="image/*">
                            <i class="fas fa-image input-icon"></i>
                        </div>
                        @error('image')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="field-hint">
                            <i class="fas fa-info-circle"></i>
                            Upload an image to represent this service (JPG, PNG, GIF - Max 2MB)
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <button type="submit" class="modern-btn modern-btn-primary" id="submitBtn">
                            <i class="fas fa-plus"></i>
                            <span class="btn-text">Create Service</span>
                            <div class="btn-loader" style="display: none;">
                                <i class="fas fa-spinner fa-spin"></i>
                            </div>
                        </button>
                        <button type="reset" class="modern-btn modern-btn-secondary">
                            <i class="fas fa-undo"></i>
                            Reset Form
                        </button>
                    </div>
                    </div> <!-- Closing form-grid for additional fields -->
            </form>
        </div>
    </div>



    <script>
        $(document).ready(function() {
            // Form submission with loading state
            $('#serviceForm').on('submit', function() {
                const submitBtn = $('#submitBtn');
                const btnText = submitBtn.find('.btn-text');
                const btnLoader = submitBtn.find('.btn-loader');

                submitBtn.prop('disabled', true);
                btnText.hide();
                btnLoader.show();
            });

            // Input animations
            $('.modern-input, .modern-select, .modern-textarea').on('focus', function() {
                $(this).parent().addClass('focused');
            }).on('blur', function() {
                $(this).parent().removeClass('focused');
            });

            // Reset form functionality
            $('button[type="reset"]').on('click', function(e) {
                e.preventDefault();
                if (confirm('Are you sure you want to reset all fields?')) {
                    $('#serviceForm')[0].reset();
                    // Reset dynamic lists
                    $('#whats_include_container').html(`
                    <div class="dynamic-item">
                        <div class="input-wrapper">
                            <input type="text" name="whats_include[]" class="modern-input" placeholder="Enter what's included">
                            <i class="fas fa-check input-icon"></i>
                        </div>
                    </div>
                `);
                    $('#requirements_container').html(`
                    <div class="requirement-item">
                        <div class="requirement-fields">
                            <div class="input-wrapper">
                                <input type="text" name="requirements[0][title]" class="modern-input" placeholder="Requirement title">
                                <i class="fas fa-text-width input-icon"></i>
                            </div>
                            <div class="input-wrapper">
                                <input type="file" name="requirements[0][image]" class="modern-input file-input" accept="image/*">
                                <i class="fas fa-image input-icon"></i>
                            </div>
                        </div>
                    </div>
                `);
                    $('#processes_container').html(`
                    <div class="process-item">
                        <div class="process-fields">
                            <div class="input-wrapper">
                                <input type="text" name="processes[0][title]" class="modern-input" placeholder="Process title">
                                <i class="fas fa-text-width input-icon"></i>
                            </div>
                            <div class="input-wrapper">
                                <textarea name="processes[0][description]" class="modern-textarea" placeholder="Process description"></textarea>
                                <i class="fas fa-align-left input-icon"></i>
                            </div>
                            <div class="input-wrapper">
                                <input type="file" name="processes[0][image]" class="modern-input file-input" accept="image/*">
                                <i class="fas fa-image input-icon"></i>
                            </div>
                        </div>
                    </div>
                `);
                }
            });

            // What's Included functionality
            $('#add_include').on('click', function(e) {
                e.preventDefault();
                const container = $('#whats_include_container');
                const newItem = $(`
                <div class="dynamic-item">
                    <div class="input-wrapper">
                        <input type="text" name="whats_include[]" class="modern-input" placeholder="Enter what's included">
                        <i class="fas fa-check input-icon"></i>
                    </div>
                    <button type="button" class="modern-btn-remove remove-include">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `);
                container.append(newItem);
            });

            $(document).on('click', '.remove-include', function() {
                $(this).closest('.dynamic-item').remove();
            });

            // Requirements functionality
            let reqIndex = {{ count(old('requirements', [1])) }};
            $('#add_requirement').on('click', function(e) {
                e.preventDefault();
                const container = $('#requirements_container');
                const currentIndex = reqIndex++;
                const newItem = $(`
                <div class="requirement-item">
                    <div class="requirement-fields">
                        <div class="input-wrapper">
                            <input type="text" name="requirements[${currentIndex}][title]" class="modern-input" placeholder="Requirement title">
                            <i class="fas fa-text-width input-icon"></i>
                        </div>
                        <div class="input-wrapper">
                            <input type="file" name="requirements[${currentIndex}][image]" class="modern-input file-input" accept="image/*">
                            <i class="fas fa-image input-icon"></i>
                        </div>
                    </div>
                    <button type="button" class="modern-btn-remove remove-requirement">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `);
                container.append(newItem);
            });

            $(document).on('click', '.remove-requirement', function() {
                $(this).closest('.requirement-item').remove();
            });

            // Processes functionality
            let processIndex = {{ count(old('processes', [1])) }};
            $('#add_process').on('click', function(e) {
                e.preventDefault();
                const container = $('#processes_container');
                const currentIndex = processIndex++;
                const newItem = $(`
                <div class="process-item">
                    <div class="process-fields">
                        <div class="input-wrapper">
                            <input type="text" name="processes[${currentIndex}][title]" class="modern-input" placeholder="Process title">
                            <i class="fas fa-text-width input-icon"></i>
                        </div>
                        <div class="input-wrapper">
                            <textarea name="processes[${currentIndex}][description]" class="modern-textarea" placeholder="Process description"></textarea>
                            <i class="fas fa-align-left input-icon"></i>
                        </div>
                        <div class="input-wrapper">
                            <input type="file" name="processes[${currentIndex}][image]" class="modern-input file-input" accept="image/*">
                            <i class="fas fa-image input-icon"></i>
                        </div>
                    </div>
                    <button type="button" class="modern-btn-remove remove-process">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `);
                container.append(newItem);
            });

            $(document).on('click', '.remove-process', function() {
                $(this).closest('.process-item').remove();
            });

            // Pricing options visibility toggle
            function togglePricingInput(checkboxId, inputContainerId) {
                $('#' + checkboxId).on('change', function() {
                    const isChecked = $(this).is(':checked');
                    const inputContainer = $('#' + inputContainerId);

                    if (isChecked) {
                        inputContainer.slideDown(300);
                    } else {
                        inputContainer.slideUp(300, function() {
                            // Clear input values when hiding
                            inputContainer.find('input[type="number"]').val('');
                            inputContainer.find('input[type="checkbox"]').prop('checked', false);
                            inputContainer.find('select').each(function() {
                                $(this).find('option:first').prop('selected', true);
                            });
                        });
                    }
                });
            }

            // Dynamic frequency management
            function addFrequencyOption(type) {
                const container = $('#' + type + '_frequencies');
                const currentCount = container.find('.frequency-item').length;
                const optionNumber = currentCount + 1;

                // Build options based on type
                let optionsHtml = '<option value="">Select times</option>';
                let maxLimit;

                switch (type) {
                    case 'weekly':
                        maxLimit = 7;
                        break;
                    case 'monthly':
                        maxLimit = 30;
                        break;
                    case 'yearly':
                        maxLimit = 12;
                        break;
                    default:
                        maxLimit = 1;
                }

                for (let i = 1; i <= maxLimit; i++) {
                    const selected = i === 1 ? 'selected' : '';
                    const timesText = i === 1 ? 'time' : 'times';
                    optionsHtml += `<option value="${i}" ${selected}>${i} ${timesText}</option>`;
                }

                const periodText = type === 'yearly' ? 'Year' : type.charAt(0).toUpperCase() + type.slice(1, -2);

                const frequencyItem = $(`
                <div class="frequency-item">
                    <div class="frequency-header">
                        <span class="frequency-title">${type.charAt(0).toUpperCase() + type.slice(1)} Option ${optionNumber}</span>
                        <button type="button" class="modern-btn-remove remove-frequency">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="frequency-content">
                        <div class="frequency-row">
                            <div class="form-group-modern frequency-no">
                                <label class="modern-label">
                                    <i class="fas fa-hashtag text-cyan"></i>
                                    Times per ${periodText}
                                </label>
                                <div class="input-wrapper">
                                    <select class="modern-select frequency-no-select"
                                        name="${type}_frequencies[${currentCount}][no_of_times]">
                                        ${optionsHtml}
                                    </select>
                                </div>
                            </div>
                            <div class="form-group-modern frequency-price">
                                <label class="modern-label">
                                    <i class="fas fa-money-bill text-cyan"></i>
                                    Price per Time
                                </label>
                                <div class="input-wrapper">
                                    <input type="number" class="modern-input"
                                        name="${type}_frequencies[${currentCount}][price_per_time]"
                                        step="0.01" min="0" placeholder="0.00">
                                    <span class="input-suffix">AED</span>
                                </div>
                            </div>
                            <div class="form-group-modern frequency-material">
                                <label class="modern-label">
                                    <i class="fas fa-tools text-cyan"></i>
                                    With Material
                                </label>
                                <div class="checkbox-wrapper">
                                    <input type="checkbox" class="modern-checkbox"
                                        name="${type}_frequencies[${currentCount}][with_material]" value="1">
                                    <label class="checkbox-text">Material included</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `);

                container.append(frequencyItem);
            }

            // Initialize pricing toggles
            togglePricingInput('enable_onetime', 'onetime_options');
            togglePricingInput('enable_weekly', 'weekly_options');
            togglePricingInput('enable_monthly', 'monthly_options');
            togglePricingInput('enable_yearly', 'yearly_options');

            // Frequency management buttons
            $('#add_weekly_frequency').on('click', function(e) {
                e.preventDefault();
                addFrequencyOption('weekly');
            });

            $('#add_monthly_frequency').on('click', function(e) {
                e.preventDefault();
                addFrequencyOption('monthly');
            });

            $('#add_yearly_frequency').on('click', function(e) {
                e.preventDefault();
                addFrequencyOption('yearly');
            });

            // Remove frequency option
            $(document).on('click', '.remove-frequency', function() {
                $(this).closest('.frequency-item').remove();
            });

            // Check and show inputs if old data exists
            @if (old('price_weekly') || old('price_weekly_description'))
                $('#enable_weekly').prop('checked', true).trigger('change');
            @endif
            @if (old('price_monthly') || old('price_monthly_description'))
                $('#enable_monthly').prop('checked', true).trigger('change');
            @endif
            @if (old('price_yearly') || old('price_yearly_description'))
                $('#enable_yearly').prop('checked', true).trigger('change');
            @endif
            // One time price is always visible by default (checkbox checked)
        });
    </script>
@endsection
