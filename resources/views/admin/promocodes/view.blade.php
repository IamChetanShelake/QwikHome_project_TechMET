@extends('admin.layouts.masterlayout')

@section('content')
    <div class="content-area">
        <div class="">
            <div class="dashboard-card">
                <div class="card-header">
                    <h3>Promocode Details</h3>
                    <a href="{{ route('promocodes.index') }}" class="btn btn-secondary">Back</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5><strong>Promocode:</strong></h5>
                            <p>{{ $promocode->code }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5><strong>Discount Amount:</strong></h5>
                            <p>{{ number_format($promocode->discount, 2) }} {{ config('app.currency', 'AED') }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h5><strong>For Active Subscription Only:</strong></h5>
                            <p>
                                @if ($promocode->for_active_subscription)
                                    <span class="badge badge-success">Yes</span>
                                @else
                                    <span class="badge badge-secondary">No</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h5><strong>Used:</strong></h5>
                            <p>
                                @if ($promocode->is_used)
                                    <span class="badge badge-warning">Used</span>
                                @else
                                    <span class="badge badge-success">Not Used</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h5><strong>Expiry Date:</strong></h5>
                            <p>{{ $promocode->expiry_date ? $promocode->expiry_date->format('d/m/Y H:i') : 'No Expiry' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5><strong>Created At:</strong></h5>
                            <p>{{ $promocode->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h5><strong>Updated At:</strong></h5>
                            <p>{{ $promocode->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
