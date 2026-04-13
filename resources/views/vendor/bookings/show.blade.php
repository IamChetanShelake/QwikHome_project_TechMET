@extends('admin.layouts.masterlayout')

@section('content')
<style>
        /* Modern Show Page Styling */
        .modern-show-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .alert-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }

        .show-header-section {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            border: 1px solid rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 20px;
        }

        .header-content {
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
            font-size: 24px;
            color: white;
            box-shadow: 0 8px 25px rgba(0, 212, 255, 0.3);
        }

        .header-title {
            font-size: 28px;
            font-weight: 700;
            color: #334155;
            margin: 0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header-subtitle {
            font-size: 14px;
            color: rgba(51, 65, 85, 0.8);
            margin: 5px 0 0 0;
        }

        .header-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .status-section {
            text-align: center;
            margin-bottom: 30px;
        }

        .content-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .info-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(15px);
            border-radius: 15px;
            border: 1px solid rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .card-header {
            background: rgba(59, 130, 246, 0.1);
            padding: 20px;
            border-bottom: 1px solid rgba(59, 130, 246, 0.2);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-header i {
            color: #3b82f6;
            font-size: 18px;
        }

        .card-header h3 {
            margin: 0;
            color: #3b82f6;
            font-size: 18px;
            font-weight: 600;
        }

        .card-content {
            padding: 20px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 10px 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-row strong {
            color: #334155;
            font-weight: 600;
            min-width: 140px;
        }

        .info-row span {
            color: #64748b;
            text-align: right;
            flex: 1;
        }

        .total-row {
            background: rgba(34, 197, 94, 0.1);
            padding: 15px;
            border-radius: 8px;
            margin: 10px 0;
            border: 1px solid rgba(34, 197, 94, 0.2);
        }

        .total-amount {
            color: #22c55e !important;
            font-weight: 700;
            font-size: 16px;
        }

        .text-success {
            color: #22c55e !important;
        }

        .text-danger {
            color: #ef4444 !important;
        }

        .text-warning {
            color: #f59e0b !important;
        }

        .notes-section {
            margin-bottom: 30px;
        }

        .notes-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 20px;
        }

        .notes-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(15px);
            border-radius: 15px;
            border: 1px solid rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .notes-header {
            background: rgba(139, 92, 246, 0.1);
            padding: 20px;
            border-bottom: 1px solid rgba(139, 92, 246, 0.2);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .notes-header i {
            color: #8b5cf6;
        }

        .notes-header h4 {
            margin: 0;
            color: #8b5cf6;
            font-size: 16px;
            font-weight: 600;
        }

        .notes-content {
            padding: 20px;
            color: #64748b;
            line-height: 1.6;
        }

        .feedback-section,
        .cancellation-section {
            margin-bottom: 30px;
        }

        .feedback-ratings {
            margin-bottom: 20px;
        }

        .rating-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .rating-row:last-child {
            border-bottom: none;
        }

        .stars {
            color: #f59e0b;
            font-weight: 600;
        }

        .feedback-comment {
            margin: 20px 0;
        }

        .feedback-comment p {
            color: #64748b;
            line-height: 1.6;
            margin: 10px 0 0 0;
            padding: 15px;
            background: rgba(0, 0, 0, 0.02);
            border-radius: 8px;
            border-left: 4px solid #3b82f6;
        }

        .feedback-date {
            text-align: right;
            color: rgba(51, 65, 85, 0.6);
        }

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

        .modern-btn-outline {
            background: transparent;
            color: rgba(51, 65, 85, 0.7);
            border: 2px solid rgba(0, 0, 0, 0.2);
        }

        .modern-btn-outline:hover {
            background: rgba(0, 0, 0, 0.05);
            color: #334155;
            border-color: rgba(0, 0, 0, 0.3);
        }

        /* Modal Styles */
        .modern-modal .modal-content {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 16px;
            color: #334155;
        }

        .modern-modal-header {
            background: linear-gradient(135deg, #00d4ff, #0099cc);
            border-radius: 16px 16px 0 0;
            padding: 20px 25px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }

        .modal-title {
            display: flex;
            align-items: center;
            gap: 10px;
            color: white;
            font-weight: 600;
        }

        .modern-modal-footer {
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            padding: 20px 25px;
        }

        .form-group-modern {
            margin-bottom: 20px;
        }

        .form-label-modern {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #334155;
            font-weight: 500;
            margin-bottom: 8px;
        }

        .form-label-modern i {
            color: #00d4ff;
        }

        .form-select-modern,
        .form-textarea-modern {
            width: 100%;
            padding: 12px 16px;
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            color: #334155;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-select-modern:focus,
        .form-textarea-modern:focus {
            outline: none;
            border-color: #00d4ff;
            box-shadow: 0 0 0 3px rgba(0, 212, 255, 0.1);
        }

        .form-textarea-modern {
            resize: vertical;
            min-height: 80px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .show-header-section {
                flex-direction: column;
                text-align: center;
            }

            .content-grid,
            .notes-grid {
                grid-template-columns: 1fr;
            }

            .info-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 5px;
            }

            .info-row strong {
                min-width: auto;
            }

            .info-row span {
                text-align: left;
            }

            .header-actions {
                justify-content: center;
            }
        }
    </style>
    <div class="modern-show-container">
        <!-- Alert System -->
        <div id="alertContainer" class="alert-container"></div>

        <!-- Header Section -->
        <div class="show-header-section">
            <div class="header-content">
                <div class="header-icon-wrapper">
                    <i class="fas fa-eye"></i>
                </div>
                <div class="header-text">
                    <h1 class="header-title">Booking Details</h1>
                    <p class="header-subtitle">Complete information for booking {{ $booking->booking_reference }}</p>
                </div>
            </div>
            <div class="header-actions">
                <a href="{{ route('vendor.bookings.index') }}" class="modern-btn modern-btn-outline">
                    <i class="fas fa-arrow-left"></i>
                    Back to Bookings
                </a>
              
            </div>
        </div>

        <!-- Status Badge -->
        <div class="status-section">
            <span class="status-badge status-{{ $booking->status }}">
                <i
                    class="fas fa-{{ $booking->status == 'completed' ? 'check' : ($booking->status == 'ongoing' ? 'play' : 'clock') }}"></i>
                {{ ucfirst($booking->status) }}
            </span>
        </div>

        <!-- Main Content Grid -->
        <div class="content-grid">
            <!-- Service Information -->
            <div class="info-card">
                <div class="card-header">
                    <i class="fas fa-concierge-bell"></i>
                    <h3>Service Information</h3>
                </div>
                <div class="card-content">
                    <div class="info-row">
                        <strong>Service Name:</strong>
                        <span>{{ $booking->service->name ?? 'N/A' }}</span>
                    </div>
                    <div class="info-row">
                        <strong>Category:</strong>
                        <span>{{ $booking->service->category->name ?? 'N/A' }}</span>
                    </div>
                    @if ($booking->service->description)
                        <div class="info-row">
                            <strong>Description:</strong>
                            <span>{{ $booking->service->description }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Customer Information -->
            <div class="info-card">
                <div class="card-header">
                    <i class="fas fa-user"></i>
                    <h3>Customer Information</h3>
                </div>
                <div class="card-content">
                    <div class="info-row">
                        <strong>Name:</strong>
                        <span>{{ $booking->customer->name }}</span>
                    </div>
                    <div class="info-row">
                        <strong>Email:</strong>
                        <span>{{ $booking->customer->email }}</span>
                    </div>
                    @if ($booking->customer->phone)
                        <div class="info-row">
                            <strong>Phone:</strong>
                            <span>{{ $booking->customer->phone }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Service Provider Information -->
            <div class="info-card">
                <div class="card-header">
                    <i class="fas fa-user-tie"></i>
                    <h3>Service Provider</h3>
                </div>
                <div class="card-content">
                    <div class="info-row">
                        <strong>Name:</strong>
                        <span>{{ $booking->serviceProvider->name ?? 'Not Assigned' }}</span>
                    </div>
                    @if ($booking->serviceProvider)
                        <div class="info-row">
                            <strong>Email:</strong>
                            <span>{{ $booking->serviceProvider->email }}</span>
                        </div>
                        @if ($booking->serviceProvider->phone)
                            <div class="info-row">
                                <strong>Phone:</strong>
                                <span>{{ $booking->serviceProvider->phone }}</span>
                            </div>
                        @endif
                    @endif
                </div>
            </div>

            <!-- Scheduling Details -->
            <div class="info-card">
                <div class="card-header">
                    <i class="fas fa-calendar"></i>
                    <h3>Scheduling Details</h3>
                </div>
                <div class="card-content">
                    <div class="info-row">
                        <strong>Scheduled Date:</strong>
                        <span>{{ $booking->scheduled_date->format('M d, Y') }}</span>
                    </div>
                    <div class="info-row">
                        <strong>Time Slot:</strong>
                        <span>{{ $booking->start_time }} - {{ $booking->end_time }}</span>
                    </div>
                    @if ($booking->preferred_time)
                        <div class="info-row">
                            <strong>Preferred Time:</strong>
                            <span>{{ $booking->preferred_time }}</span>
                        </div>
                    @endif
                    @if ($booking->next_booking_date)
                        <div class="info-row">
                            <strong>Next Booking Date:</strong>
                            <span>{{ $booking->next_booking_date->format('M d, Y') }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Pricing & Payment Details -->
            <div class="info-card">
                <div class="card-header">
                    <i class="fas fa-dollar-sign"></i>
                    <h3>Pricing & Payment</h3>
                </div>
                <div class="card-content">
                    <div class="info-row">
                        <strong>Base Price:</strong>
                        <span>AED {{ number_format($booking->price ?? 0, 2) }}</span>
                    </div>
                    @if ($booking->discount_amount > 0)
                        <div class="info-row">
                            <strong>Discount:</strong>
                            <span class="text-success">-AED {{ number_format($booking->discount_amount, 2) }}</span>
                        </div>
                    @endif
                    @if ($booking->tax_amount > 0)
                        <div class="info-row">
                            <strong>Tax:</strong>
                            <span>AED {{ number_format($booking->tax_amount, 2) }}</span>
                        </div>
                    @endif
                    <div class="info-row total-row">
                        <strong>Total Amount:</strong>
                        <span class="total-amount">AED
                            {{ number_format($booking->total_amount ?? ($booking->price ?? 0), 2) }}</span>
                    </div>
                    @if ($booking->paid_amount > 0)
                        <div class="info-row">
                            <strong>Paid Amount:</strong>
                            <span class="text-success">AED {{ number_format($booking->paid_amount, 2) }}</span>
                        </div>
                    @endif
                    @if ($booking->refund_amount > 0)
                        <div class="info-row">
                            <strong>Refund Amount:</strong>
                            <span class="text-warning">AED {{ number_format($booking->refund_amount, 2) }}</span>
                        </div>
                    @endif
                    @if ($booking->payment_due_date)
                        <div class="info-row">
                            <strong>Payment Due Date:</strong>
                            <span>{{ $booking->payment_due_date->format('M d, Y') }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Booking Timeline -->
            <div class="info-card">
                <div class="card-header">
                    <i class="fas fa-history"></i>
                    <h3>Booking Timeline</h3>
                </div>
                <div class="card-content">
                    <div class="info-row">
                        <strong>Created:</strong>
                        <span>{{ $booking->created_at->format('M d, Y H:i') }}</span>
                    </div>
                    @if ($booking->completed_at)
                        <div class="info-row">
                            <strong>Completed:</strong>
                            <span class="text-success">{{ $booking->completed_at->format('M d, Y H:i') }}</span>
                        </div>
                    @endif
                    @if ($booking->cancelled_at)
                        <div class="info-row">
                            <strong>Cancelled:</strong>
                            <span class="text-danger">{{ $booking->cancelled_at->format('M d, Y H:i') }}</span>
                        </div>
                    @endif
                    <div class="info-row">
                        <strong>Last Updated:</strong>
                        <span>{{ $booking->updated_at->format('M d, Y H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notes Section -->
        <div class="notes-section">
            <div class="notes-grid">
                @if ($booking->customer_notes)
                    <div class="notes-card">
                        <div class="notes-header">
                            <i class="fas fa-sticky-note"></i>
                            <h4>Customer Notes</h4>
                        </div>
                        <div class="notes-content">
                            {{ $booking->customer_notes }}
                        </div>
                    </div>
                @endif

                @if ($booking->vendor_notes)
                    <div class="notes-card">
                        <div class="notes-header">
                            <i class="fas fa-sticky-note"></i>
                            <h4>Vendor Notes</h4>
                        </div>
                        <div class="notes-content">
                            {{ $booking->vendor_notes }}
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Feedback Section -->
        @if ($booking->feedback)
            <div class="feedback-section">
                <div class="info-card">
                    <div class="card-header">
                        <i class="fas fa-star"></i>
                        <h3>Customer Feedback</h3>
                    </div>
                    <div class="card-content">
                        <div class="feedback-ratings">
                            @if ($booking->feedback->rating_service)
                                <div class="rating-row">
                                    <strong>Service Rating:</strong>
                                    <span
                                        class="stars">{{ \App\Models\Feedback::renderStars($booking->feedback->rating_service) }}</span>
                                </div>
                            @endif
                            @if ($booking->feedback->rating_employee)
                                <div class="rating-row">
                                    <strong>Employee Rating:</strong>
                                    <span
                                        class="stars">{{ \App\Models\Feedback::renderStars($booking->feedback->rating_employee) }}</span>
                                </div>
                            @endif
                        </div>
                        @if ($booking->feedback->comment)
                            <div class="feedback-comment">
                                <strong>Comment:</strong>
                                <p>{{ $booking->feedback->comment }}</p>
                            </div>
                        @endif
                        <div class="feedback-date">
                            <small>Submitted on {{ $booking->feedback->created_at->format('M d, Y H:i') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Cancellation Details -->
        @if ($booking->cancelled_at)
            <div class="cancellation-section">
                <div class="info-card">
                    <div class="card-header">
                        <i class="fas fa-ban"></i>
                        <h3>Cancellation Details</h3>
                    </div>
                    <div class="card-content">
                        <div class="info-row">
                            <strong>Cancellation Reason:</strong>
                            <span>{{ $booking->cancellation_reason ?? 'Not specified' }}</span>
                        </div>
                        @if ($booking->cancellation_fee > 0)
                            <div class="info-row">
                                <strong>Cancellation Fee:</strong>
                                <span class="text-danger">AED {{ number_format($booking->cancellation_fee, 2) }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>

    

    <script>
        // Handle status update success
        @if (session('success'))
            document.addEventListener('DOMContentLoaded', function() {
                showAlert('{{ session('success') }}', 'success');
            });
        @endif

        function showAlert(message, type) {
            const alertContainer = document.getElementById('alertContainer');
            const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
            const alertHtml = `
                <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
            alertContainer.innerHTML = alertHtml;

            // Auto remove after 5 seconds
            setTimeout(() => {
                const alert = alertContainer.querySelector('.alert');
                if (alert) {
                    alert.remove();
                }
            }, 5000);
        }
    </script>
@endsection
