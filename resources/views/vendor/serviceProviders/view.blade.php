@extends('admin.layouts.masterlayout')

@section('content')
    <div class="content-area">
        <div class="profile-container">
            <!-- Header Section -->
            <div class="profile-header">
                <div class="profile-title-group">
                    <div class="profile-icon-wrapper">
                        <i class="fas fa-user-circle profile-main-icon"></i>
                    </div>
                    <div class="profile-title-text">
                        <h2 class="profile-title">Employee Details</h2>
                        <p class="profile-subtitle">View complete employee information and account details</p>
                    </div>
                </div>
                <a href="{{ route('serviceProviders.index') }}" class="back-btn">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back to Employees</span>
                </a>
            </div>

            <!-- Profile Card -->
            <div class="profile-card">
                <div class="profile-grid">
                    <!-- Profile Image Section -->
                    <div class="profile-image-section">
                        <div class="image-container">
                            @if ($serviceProvider->image)
                                <img src="{{ asset('user_images/' . $serviceProvider->image) }}"
                                    alt="{{ $serviceProvider->name }}" class="profile-image">
                            @else
                                <div class="profile-image no-image">
                                    <i class="fas fa-user"></i>
                                </div>
                            @endif
                        </div>
                        <div class="employee-status">
                            <span class="status-badge active">
                                <i class="fas fa-circle"></i>
                                Service Provider
                            </span>
                        </div>
                    </div>

                    <!-- Profile Information Section -->
                    <div class="profile-info-section">
                        <!-- Basic Information -->
                        <div class="info-section">
                            <div class="section-header">
                                <i class="fas fa-user"></i>
                                <h3>Basic Information</h3>
                            </div>

                            <div class="info-grid">
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-user"></i>
                                        <span>Full Name</span>
                                    </div>
                                    <div class="info-value">{{ $serviceProvider->name }}</div>
                                </div>

                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-envelope"></i>
                                        <span>Email Address</span>
                                    </div>
                                    <div class="info-value">{{ $serviceProvider->email ?? 'Not provided' }}</div>
                                </div>

                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-phone"></i>
                                        <span>Phone Number</span>
                                    </div>
                                    <div class="info-value">{{ $serviceProvider->phone ?? 'Not provided' }}</div>
                                </div>

                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-user-tag"></i>
                                        <span>Role</span>
                                    </div>
                                    <div class="info-value">
                                        <span class="role-badge">{{ ucfirst($serviceProvider->role ?? 'serviceprovider') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="info-section">
                            <div class="section-header">
                                <i class="fas fa-address-book"></i>
                                <h3>Contact Information</h3>
                            </div>

                            <div class="info-grid">
                                <div class="info-item full-width">
                                    <div class="info-label">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <span>Address</span>
                                    </div>
                                    <div class="info-value address-value">
                                        {{ $serviceProvider->address ?? 'Not provided' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Account Information -->
                        <div class="info-section">
                            <div class="section-header">
                                <i class="fas fa-calendar"></i>
                                <h3>Account Information</h3>
                            </div>

                            <div class="info-grid">
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-calendar-plus"></i>
                                        <span>Account Created</span>
                                    </div>
                                    <div class="info-value">{{ $serviceProvider->created_at->format('M d, Y \a\t H:i') }}</div>
                                </div>

                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-calendar-check"></i>
                                        <span>Last Updated</span>
                                    </div>
                                    <div class="info-value">{{ $serviceProvider->updated_at->format('M d, Y \a\t H:i') }}</div>
                                </div>

                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-clock"></i>
                                        <span>Member Since</span>
                                    </div>
                                    <div class="info-value">{{ $serviceProvider->created_at->format('F Y') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="profile-actions">
                    <a href="{{ route('serviceProviders.edit', $serviceProvider->id) }}" class="action-btn edit-btn">
                        <i class="fas fa-edit"></i>
                        <span>Edit Employee</span>
                    </a>
                    <a href="{{ route('serviceProviders.index') }}" class="action-btn back-btn">
                        <i class="fas fa-list"></i>
                        <span>View All Employees</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
