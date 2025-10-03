@extends('admin.layouts.masterlayout')

@section('content')
    <div class="content-area">
        <div class="">
            <div class="dashboard-card">
                <div class="card-header">
                    <h3>Service Provider Details</h3>
                    <a href="{{ route('serviceProviders.index') }}" class="btn btn-secondary">Back</a>
                </div>
                <div class="card-body p-4">
                    <!-- Service Provider Image -->
                    <div class="row mb-4">
                        <div class="col-12 text-center">
                            @if($serviceProvider->image)
                                <img src="{{ asset('User_images/' . $serviceProvider->image) }}" alt="{{ $serviceProvider->name }}" class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
                            @else
                                <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center mx-auto" style="width: 100px; height: 100px;">
                                    <i class="fas fa-user text-white" style="font-size: 40px;"></i>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <h5><strong>Name:</strong></h5>
                            <p>{{ $serviceProvider->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5><strong>Email:</strong></h5>
                            <p>{{ $serviceProvider->email ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h5><strong>Phone:</strong></h5>
                            <p>{{ $serviceProvider->phone ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5><strong>Role:</strong></h5>
                            <p>{{ $serviceProvider->role ?? 'serviceprovider' }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <h5><strong>Address:</strong></h5>
                            <p>{{ $serviceProvider->address ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h5><strong>Created At:</strong></h5>
                            <p>{{ $serviceProvider->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5><strong>Updated At:</strong></h5>
                            <p>{{ $serviceProvider->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
