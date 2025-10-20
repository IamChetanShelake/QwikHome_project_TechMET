@extends('admin.layouts.masterlayout')

@section('title', 'Create Service Offer')

@section('content')
    <style>
        .modern-form-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .form-header {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }

        .form-header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 28px;
            font-weight: 700;
        }

        .form-header p {
            color: rgba(255, 255, 255, 0.8);
            margin: 10px 0 0;
        }

        .form-section {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(15px);
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 30px;
            margin-bottom: 20px;
        }

        .form-section h3 {
            color: #00d4ff;
            margin: 0 0 20px 0;
            font-size: 20px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #ffffff;
            font-size: 14px;
        }

        .form-input,
        .form-textarea,
        .form-select {
            width: 100%;
            padding: 12px 16px;
            background: rgba(255, 255, 255, 0.05);
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            color: #ffffff;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-input:focus,
        .form-textarea:focus,
        .form-select:focus {
            outline: none;
            border-color: #00d4ff;
            background: rgba(255, 255, 255, 0.08);
            box-shadow: 0 0 15px rgba(0, 212, 255, 0.2);
        }

        .radio-group {
            display: flex;
            gap: 20px;
            margin: 10px 0;
        }

        .radio-option {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .radio-option input[type="radio"] {
            width: 18px;
            height: 18px;
            accent-color: #00d4ff;
        }

        .radio-option label {
            color: #ffffff;
            cursor: pointer;
            font-weight: 500;
        }

        .price-inputs {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 15px;
        }

        .form-actions {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 30px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, #00d4ff, #0099cc);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 212, 255, 0.4);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: #00d4ff;
        }

        .service-info {
            background: rgba(0, 212, 255, 0.1);
            border: 1px solid rgba(0, 212, 255, 0.3);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .service-info h4 {
            color: #00d4ff;
            margin: 0 0 10px 0;
            font-weight: 600;
        }

        .service-info p {
            color: #ffffff;
            margin: 5px 0;
            font-size: 14px;
        }
    </style>

    <div class="modern-form-container">
        <!-- Header -->
        <div class="form-header">
            <h1>Create Service Offer</h1>
            <p>Add a new offer for {{ $service->name }}</p>
        </div>

        <!-- Service Info -->
        <div class="service-info">
            <h4><i class="fas fa-info-circle"></i> Service Information</h4>
            <p><strong>Name:</strong> {{ $service->name ?? null }} </p>
            <p><strong>Category:</strong> {{ $service->category->name ?? null }}</p>
            <p><strong>Current Price:</strong> AED {{ number_format($service->price_onetime, 2) }}</p>
        </div>

        <!-- Frequency Options Info -->
        @if($frequencyOptions->count() > 0)
        <div class="service-info">
            <h4><i class="fas fa-clock"></i> Frequency Options</h4>
            @foreach($frequencyOptions as $option)
                <p><strong>{{ ucfirst($option->frequency_type) }}:</strong> AED {{ number_format($option->price_per_time, 2) }} per time</p>
            @endforeach
        </div>
        @endif

        <!-- Offer Form -->
        <form action="{{ route('offers.store') }}" method="POST">
            @csrf

            <!-- Basic Information -->
            <div class="form-section">
                <h3><i class="fas fa-tag"></i> Offer Details</h3>

                <input type="hidden" name="service_id" value="{{ $service->id }}">

                <div class="form-group">
                    <label for="name" class="form-label">Offer Name *</label>
                    <input type="text" id="name" name="name" class="form-input" placeholder="Enter offer name"
                        required>
                </div>

                <div class="form-group">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" name="description" class="form-textarea" placeholder="Enter offer description"></textarea>
                </div>
            </div>

            <!-- Discount Settings and Prices -->
            <div class="form-section">
                <h3><i class="fas fa-percent"></i> Discount Settings</h3>

                <div class="form-group">
                    <label class="form-label">Discount Type *</label>
                    <div class="radio-group">
                        <label class="radio-option">
                            <input type="radio" name="discount_type" value="percentage" checked>
                            <span>Percentage (%)</span>
                        </label>
                        <label class="radio-option">
                            <input type="radio" name="discount_type" value="flat">
                            <span>Flat Amount (AED)</span>
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="discount_value" class="form-label">Discount Value *</label>
                    <input type="number" id="discount_value" name="discount_value" class="form-input" step="0.01"
                        min="0" placeholder="0.00" required>
                </div>

                <div style="border-top: 1px solid rgba(255,255,255,0.1); padding-top: 20px; margin-top: 20px;">
                    <p style="color: #00d4ff; margin: 0 0 15px 0; font-weight: 600; font-size: 16px;">
                        <i class="fas fa-dollar-sign"></i> Set Discounted Prices Under All Frequencies:
                    </p>

                    <div class="price-inputs">
                        @php
                            $frequencyTypes = ['onetime', 'weekly', 'monthly', 'yearly'];
                        @endphp

                        @foreach($frequencyTypes as $type)
                            @foreach($frequencyOptions->where('frequency_type', $type) as $index => $option)
                                <div class="form-group">
                                    <label for="frequency_option_{{ $option->id }}" class="form-label">
                                        {{ ucfirst($type) }} Option {{ $index + 1 }} ({{ $option->no_of_times }} times, AED {{ number_format($option->price_per_time, 2) }} per time)
                                    </label>
                                    <input type="number"
                                           id="frequency_option_{{ $option->id }}"
                                           name="frequency_option_{{ $option->id }}"
                                           class="form-input calculate-discount"
                                           step="0.01"
                                           min="0"
                                           placeholder="{{ $option->price_per_time }}"
                                           data-original-price="{{ $option->price_per_time }}"
                                           data-frequency-type="{{ $type }}"
                                           data-frequency-id="{{ $option->id }}">
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Validity Period -->
            <div class="form-section">
                <h3><i class="fas fa-calendar"></i> Validity Period</h3>

                <div class="price-inputs">
                    <div class="form-group">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" id="start_date" name="start_date" class="form-input">
                    </div>

                    <div class="form-group">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" id="end_date" name="end_date" class="form-input">
                    </div>
                </div>
            </div>

            <!-- Status -->
            <div class="form-section">
                <h3><i class="fas fa-toggle-on"></i> Status</h3>

                <div class="form-group">
                    <label class="form-label">Offer Status *</label>
                    <select name="status" class="form-select" required>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Create Offer
                </button>
                <a href="{{ route('services.services.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i>
                    Cancel
                </a>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Set default dates
            const today = new Date();
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');
            const discountTypeInputs = document.querySelectorAll('input[name="discount_type"]');
            const discountValueInput = document.getElementById('discount_value');

            // Set start date today if empty
            if (!startDateInput.value) {
                startDateInput.valueAsDate = today;
            }

            // Set end date to 30 days from today if empty
            if (!endDateInput.value) {
                const endDate = new Date(today);
                endDate.setDate(today.getDate() + 30);
                endDateInput.valueAsDate = endDate;
            }

            // Validate end date is after start date
            startDateInput.addEventListener('change', function() {
                if (endDateInput.value && startDateInput.value > endDateInput.value) {
                    endDateInput.value = startDateInput.value;
                }
            });

            endDateInput.addEventListener('change', function() {
                if (startDateInput.value && endDateInput.value < startDateInput.value) {
                    endDateInput.value = startDateInput.value;
                }
            });

            // Discount calculation functionality
            function calculateDiscountedPrices() {
                const discountType = document.querySelector('input[name="discount_type"]:checked').value;
                const discountValue = parseFloat(discountValueInput.value) || 0;
                const priceInputs = document.querySelectorAll('.calculate-discount');

                priceInputs.forEach(input => {
                    const originalPrice = parseFloat(input.dataset.originalPrice);
                    if (!originalPrice) return;

                    let discountedPrice;
                    if (discountType === 'percentage') {
                        discountedPrice = originalPrice * (1 - (discountValue / 100));
                    } else { // flat discount
                        discountedPrice = Math.max(0, originalPrice - discountValue);
                    }

                    // Update the field value regardless of whether it was manually entered
                    // This ensures all fields update when discount type/value changes
                    input.value = discountedPrice.toFixed(2);
                });
            }

            // Add event listeners for discount type and value changes
            discountTypeInputs.forEach(input => {
                input.addEventListener('change', calculateDiscountedPrices);
            });

            discountValueInput.addEventListener('input', calculateDiscountedPrices);
        });
    </script>
@endsection
