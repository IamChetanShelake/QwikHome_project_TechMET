@extends('admin.layouts.masterlayout')

@section('content')
    <div class="content-area">
        <div class="">
            <div class="dashboard-card">
                <div class="card-header">
                    <h3>Coupon Details</h3>
                    <a href="{{ route('coupons.index') }}" class="btn btn-secondary">Back</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5><strong>Coupon Code:</strong></h5>
                            <p>{{ $coupon->code }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5><strong>Description:</strong></h5>
                            <p>{{ $coupon->description ?: 'No description' }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h5><strong>Discount Type:</strong></h5>
                            <p>{{ ucfirst($coupon->discount_type) }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5><strong>Discount Value:</strong></h5>
                            <p>
                                {{ $coupon->discount_value }}
                                @if($coupon->discount_type == 'percentage')
                                    %
                                @else
                                    {{ config('app.currency', '$') }}
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h5><strong>Expiry Date:</strong></h5>
                            <p>{{ $coupon->expiry_date->format('d/m/Y H:i') }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5><strong>Usage Limit:</strong></h5>
                            <p>{{ $coupon->usage_limit ?: 'Unlimited' }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h5><strong>Used Count:</strong></h5>
                            <p>{{ $coupon->used_count }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5><strong>Status:</strong></h5>
                            <p>
                                @if ($coupon->status == 1)
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-secondary">Inactive</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h5><strong>Created At:</strong></h5>
                            <p>{{ $coupon->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5><strong>Updated At:</strong></h5>
                            <p>{{ $coupon->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
