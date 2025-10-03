@extends('admin.layouts.masterlayout')

@section('content')
    <div class="content-area">
        <div class="">
            <div class="dashboard-card p-3">
                <div class="card-header">
                    <h3>Edit Coupon</h3>
                    <a href="{{ route('coupons.index') }}" class="btn btn-secondary">Back</a>
                </div>
                <div class="card-body p-3">
                    <form method="POST" action="{{ route('coupons.update', $coupon->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="code">Coupon Code</label>
                            <input type="text" class="form-control" id="code" name="code"
                                value="{{ $coupon->code }}" required>
                            @error('code')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3">{{ $coupon->description }}</textarea>
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="discount_type">Discount Type</label>
                            <select class="form-control" id="discount_type" name="discount_type" required>
                                <option value="">Select Type</option>
                                <option value="percentage" {{ $coupon->discount_type == 'percentage' ? 'selected' : '' }}>
                                    Percentage (%)</option>
                                <option value="fixed" {{ $coupon->discount_type == 'fixed' ? 'selected' : '' }}>Fixed
                                    Amount</option>
                            </select>
                            @error('discount_type')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="discount_value">Discount Value</label>
                            <input type="number" step="0.01" class="form-control" id="discount_value"
                                name="discount_value" value="{{ $coupon->discount_value }}" required>
                            @error('discount_value')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="expiry_date">Expiry Date</label>
                            <input type="datetime-local" class="form-control" id="expiry_date" name="expiry_date"
                                value="{{ $coupon->expiry_date->format('Y-m-d\TH:i') }}" required>
                            @error('expiry_date')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="usage_limit">Usage Limit (leave blank for unlimited)</label>
                            <input type="number" min="1" class="form-control" id="usage_limit" name="usage_limit"
                                value="{{ $coupon->usage_limit }}">
                            @error('usage_limit')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="1" {{ $coupon->status == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $coupon->status == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Update Coupon</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
