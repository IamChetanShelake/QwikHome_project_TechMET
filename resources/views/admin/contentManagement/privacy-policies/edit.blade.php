@extends('admin.layouts.masterlayout')

@section('title', 'Edit Privacy Policy')

@section('content')
    <style>
        .edit-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }

        .edit-header-section {
            background: #ffffff;
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            border: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .header-title {
            font-size: 28px;
            font-weight: 700;
            color: #334155;
            margin: 0;
            text-shadow: none;
        }

        .header-subtitle {
            font-size: 14px;
            color: #64748b;
            margin: 5px 0 0 0;
        }

        .form-container {
            background: #ffffff;
            backdrop-filter: blur(15px);
            border-radius: 15px;
            border: 1px solid #e2e8f0;
            padding: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 500;
            color: #334155;
        }

        .form-input {
            width: 100%;
            padding: 12px 15px;
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            color: #334155;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: #00d4ff;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(0, 212, 255, 0.1);
        }

        .form-input::placeholder {
            color: #94a3b8;
        }

        .radio-label {
            position: relative;
            padding: 10px 16px;
            background: #f1f5f9;
            border-radius: 8px;
            transition: all 0.3s ease;
            color: #64748b;
            border: 2px solid transparent;
        }

        .form-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
        }

        .form-textarea {
            min-height: 150px;
            resize: vertical;
        }

        .status-radio-group {
            display: flex;
            gap: 20px;
            align-items: center;
            padding: 15px 0;
        }

        .radio-option {
            display: flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
        }

        .radio-input {
            display: none;
        }

        .radio-label {
            position: relative;
            padding: 10px 16px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 8px;
            transition: all 0.3s ease;
            color: rgba(255, 255, 255, 0.7);
            border: 2px solid transparent;
        }

        .radio-input:checked+.radio-label {
            background: rgba(34, 197, 94, 0.2);
            color: #22c55e;
            border-color: rgba(34, 197, 94, 0.3);
        }

        .form-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .modern-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .modern-btn-primary {
            background: linear-gradient(135deg, #ff9500, #e8871b);
            color: white;
            box-shadow: 0 4px 15px rgba(255, 149, 0, 0.3);
        }

        .modern-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 149, 0, 0.4);
            color: white;
        }

        .modern-btn-secondary {
            background: rgba(0, 212, 255, 0.1);
            color: #00d4ff;
            border: 2px solid rgba(0, 212, 255, 0.3);
        }

        .modern-btn-secondary:hover {
            background: rgba(0, 212, 255, 0.2);
            border-color: #00d4ff;
            color: #00d4ff;
        }

        .alert {
            position: relative;
            padding: 0.75rem 1rem;
            margin-bottom: 1rem;
            border: 1px solid transparent;
            border-radius: 0.375rem;
        }

        .alert-success {
            color: #22c55e;
            background-color: rgba(34, 197, 94, 0.1);
            border-color: rgba(34, 197, 94, 0.3);
        }

        .alert-danger {
            color: #ef4444;
            background-color: rgba(239, 68, 68, 0.1);
            border-color: rgba(239, 68, 68, 0.3);
        }

        @media (max-width: 768px) {
            .edit-header-section {
                flex-direction: column;
                text-align: center;
            }

            .form-actions {
                flex-direction: column;
                gap: 15px;
            }
        }
    </style>

    <div class="edit-container">
        <!-- Header Section -->
        <div class="edit-header-section">
            <div class="header-content">
                <div class="header-icon-wrapper">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <div class="header-text">
                    <h1 class="header-title">Edit Privacy Policy</h1>
                    <p class="header-subtitle">Update privacy policy content</p>
                </div>
            </div>
            <div class="header-actions">
                <a href="{{ route('contentManagement.privacy-policies.index') }}" class="modern-btn modern-btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Back to List
                </a>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Form Container -->
        <div class="form-container">
            <form method="POST" action="{{ route('contentManagement.privacy-policies.update', $privacyPolicy) }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-heading" style="margin-right: 8px;"></i>
                        Title
                    </label>
                    <input type="text" class="form-input" name="title" placeholder="Enter privacy policy title (optional)" value="{{ old('title', $privacyPolicy->title) }}">
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-file-alt" style="margin-right: 8px;"></i>
                        Content
                    </label>
                    <textarea class="form-input form-textarea" name="content" placeholder="Enter privacy policy content">{{ old('content', $privacyPolicy->content) }}</textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-toggle-on" style="margin-right: 8px;"></i>
                        Status
                    </label>
                    <div class="status-radio-group">
                        <div class="radio-option">
                            <input type="radio" id="status_active" name="status" value="active" class="radio-input" {{ old('status', $privacyPolicy->status) == 'active' ? 'checked' : '' }}>
                            <label for="status_active" class="radio-label">Active</label>
                        </div>
                        <div class="radio-option">
                            <input type="radio" id="status_inactive" name="status" value="inactive" class="radio-input" {{ old('status', $privacyPolicy->status) == 'inactive' ? 'checked' : '' }}>
                            <label for="status_inactive" class="radio-label">Inactive</label>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <a href="{{ route('contentManagement.privacy-policies.index') }}" class="modern-btn modern-btn-secondary">
                        <i class="fas fa-times"></i>
                        Cancel
                    </a>
                    <button type="submit" class="modern-btn modern-btn-primary">
                        <i class="fas fa-save"></i>
                        Update Privacy Policy
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                alert.classList.add('fade');
                setTimeout(function() {
                    alert.style.display = 'none';
                }, 150);
            });
        }, 5000);
    </script>
@endsection
