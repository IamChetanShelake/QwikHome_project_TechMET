@extends('admin.layouts.masterlayout')

@section('content')
    <div class="content-area">
        <div class="">
            <div class="dashboard-card p-3">
                <div class="card-header">
                    <h3>My Profile</h3>
                </div>
                <div class="card-body">

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Profile Image Section -->
                        <div class="row mb-4">
                            <div class="col-md-12 text-center">
                                <div class="profile-image-container position-relative d-inline-block mb-3">
                                    @if (auth()->user()->image)
                                        <img src="{{ asset('User_images/' . auth()->user()->image) }}"
                                            alt="{{ auth()->user()->name }}" class="rounded-circle profile-image"
                                            style="width: 150px; height: 150px; object-fit: cover; border: 4px solid #fff; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                                    @else
                                        <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center mx-auto profile-image-placeholder"
                                            style="width: 150px; height: 150px; border: 4px solid #fff; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                                            <i class="fas fa-user text-white" style="font-size: 60px;"></i>
                                        </div>
                                    @endif

                                    <!-- Camera Icon Overlay -->
                                    <div
                                        class="camera-overlay rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="fas fa-camera text-white" style="font-size: 24px;"></i>
                                    </div>
                                </div>

                                <!-- Upload Status Message -->
                                <div id="upload-status" class="mt-2" style="display: none;"></div>

                                <!-- Hidden File Input -->
                                <input type="file" id="profileImageInput" accept="image/*" style="display: none;">
                            </div>
                        </div>

                        <!-- Personal Information -->
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="name">Full Name *</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ old('name', auth()->user()->name) }}" required>
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="email">Email Address *</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ old('email', auth()->user()->email) }}" required>
                                    @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="phone">Phone Number</label>
                                    <input type="text" class="form-control" id="phone" name="phone"
                                        value="{{ old('phone', auth()->user()->phone) }}"
                                        placeholder="Enter your phone number">
                                    @error('phone')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6  col-12">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <textarea class="form-control" id="address" name="address" rows="3" placeholder="Enter your full address">{{ old('address', auth()->user()->address) }}</textarea>
                                    @error('address')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <!-- Account Timestamps -->
                        <hr class="my-4">
                        <h5 class="mb-3">Account Information</h5>

                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Member Since</label>
                                    <input type="text" class="form-control bg-light"
                                        value="{{ auth()->user()->created_at->format('M d, Y \a\t H:i') }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Last Updated</label>
                                    <input type="text" class="form-control bg-light"
                                        value="{{ auth()->user()->updated_at->format('M d, Y \a\t H:i') }}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary btn-lg px-5">
                                    <i class="fas fa-save"></i> Update Profile
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .profile-image-container {
            cursor: pointer;
        }

        .camera-overlay {
            position: absolute;
            bottom: 10px;
            right: 10px;
            width: 40px;
            height: 40px;
            background-color: rgba(0, 123, 255, 0.9);
            border: 2px solid #fff;
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 10;
        }

        .profile-image-container:hover .camera-overlay {
            opacity: 1;
        }

        .upload-status {
            font-size: 14px;
            font-weight: 500;
        }

        .upload-status.success {
            color: #28a745;
        }

        .upload-status.error {
            color: #dc3545;
        }
    </style>

    <script>
        $(document).ready(function() {
            // Camera overlay click - open file selector
            $('.profile-image-container').on('click', function() {
                $('#profileImageInput').click();
            });

            // Handle file selection for AJAX upload
            $('#profileImageInput').on('change', function() {
                const file = this.files[0];
                if (file) {
                    uploadImage(file);
                }
            });

            // AJAX image upload function
            function uploadImage(file) {
                const statusDiv = $('#upload-status');
                const formData = new FormData();

                // Validate file size (2MB limit)
                if (file.size > 2 * 1024 * 1024) {
                    showUploadStatus('File size too large. Maximum size is 2MB.', 'error');
                    return;
                }

                // Validate file type
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                if (!allowedTypes.includes(file.type)) {
                    showUploadStatus('Invalid file type. Only JPG, PNG, and GIF are allowed.', 'error');
                    return;
                }

                formData.append('image', file);
                formData.append('_token', '{{ csrf_token() }}');

                // Show uploading status
                showUploadStatus('Uploading...', 'info');

                // Hide any existing success message
                $('.alert-success').fadeOut('fast');

                $.ajax({
                    url: '{{ route('profile.upload.image') }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function(response) {
                        console.log('AJAX Success:', response); // Debug log

                        if (response.success) {
                            // Update the profile image immediately
                            updateProfileImage(response.image_url);

                            // Show success message
                            showUploadStatus('Profile image updated successfully!', 'success');

                            // Auto hide upload status after 3 seconds
                            setTimeout(function() {
                                statusDiv.fadeOut();
                            }, 3000);
                        } else {
                            showUploadStatus('Upload failed. Please try again.', 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('AJAX Error:', xhr, status, error); // Debug log

                        let errorMessage = 'Upload failed. Please try again.';

                        if (xhr.status === 419) {
                            errorMessage = 'CSRF token expired. Please refresh the page and try again.';
                        } else if (xhr.responseJSON && xhr.responseJSON.errors && xhr.responseJSON.errors.image) {
                            errorMessage = xhr.responseJSON.errors.image[0];
                        } else if (xhr.responseText) {
                            errorMessage = 'Server error: ' + xhr.status + ' ' + xhr.statusText;
                        }

                        showUploadStatus(errorMessage, 'error');
                    }
                });
            }

            // Function to update profile image display
            function updateProfileImage(imageUrl) {
                const container = $('.profile-image-container');

                // Replace the current image/placeholder with new image
                if (container.find('.profile-image').length) {
                    container.find('.profile-image').attr('src', imageUrl + '?t=' + Date.now()); // Cache busting
                } else {
                    // Replace placeholder with actual image
                    $('.profile-image-placeholder').replaceWith(
                        `<img src="${imageUrl}?t=${Date.now()}" alt="{{ auth()->user()->name }}" class="rounded-circle profile-image" style="width: 150px; height: 150px; object-fit: cover; border: 4px solid #fff; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">`
                    );
                }
            }

            // Function to show upload status
            function showUploadStatus(message, type) {
                const statusDiv = $('#upload-status');
                statusDiv.removeClass('success error info').addClass(type);
                statusDiv.html(
                    `<i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i> ${message}`
                    );
                statusDiv.show();

                if (type === 'error') {
                    setTimeout(function() {
                        statusDiv.fadeOut();
                    }, 5000);
                }
            }

            // Auto-hide success message
            setTimeout(function() {
                $('.alert-success').fadeOut('slow');
            }, 5000);
        });
    </script>
@endsection
