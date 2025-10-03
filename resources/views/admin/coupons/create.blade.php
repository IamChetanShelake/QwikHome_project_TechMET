@extends('admin.layouts.masterlayout')

@section('content')
    <div class="content-area">

        <div class="">

            <div class="dashboard-card p-3">

                <div class="card-header">

                    <h3>Create Coupon</h3>
                    <a href="{{ route('coupons.index') }}" class="btn btn-secondary">Back</a>
                </div>
                <div class="card-body">

                    <form method="POST" action="{{ route('coupons.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="code">Coupon Code</label>
                            <input type="text" class="form-control" id="code" name="code" required>
                            @error('code')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="discount_type">Discount Type</label>
                            <select class="form-control" id="discount_type" name="discount_type" required>
                                <option value="">Select Type</option>
                                <option value="percentage">Percentage (%)</option>
                                <option value="fixed">Fixed Amount</option>
                            </select>
                            @error('discount_type')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="discount_value">Discount Value</label>
                            <input type="number" step="0.01" class="form-control" id="discount_value"
                                name="discount_value" required>
                            @error('discount_value')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="expiry_date">Expiry Date</label>
                            <input type="datetime-local" class="form-control" id="expiry_date" name="expiry_date" required>
                            @error('expiry_date')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="usage_limit">Usage Limit (leave blank for unlimited)</label>
                            <input type="number" min="1" class="form-control" id="usage_limit" name="usage_limit">
                            @error('usage_limit')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                            @error('status')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Create Coupon</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
