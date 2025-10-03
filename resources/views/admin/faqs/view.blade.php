@extends('admin.layouts.masterlayout')

@section('content')
    <div class="content-area">

        <div class="dashboard-card">
            <div class="card-header">
                <h3>View FAQ</h3>
                <a href="{{ route('faq') }}" class="btn btn-secondary">Back</a>
            </div>
            <div class="card-body">
                <div class="row p-3">
                    <div class="col-md-12">
                        <h5>Question</h5>
                        <p>{{ $faq->question }}</p>
                        <hr>
                        <h5>Answer</h5>
                        <p>{{ $faq->answer }}</p>
                        <hr>
                        <h5>Status</h5>
                        <p>
                            @if ($faq->status == 1)
                                <span class="badge badge-success">Active</span>
                            @else
                                <span class="badge badge-danger">Inactive</span>
                            @endif
                        </p>
                        <hr>
                        <h5>Created At</h5>
                        <p>{{ $faq->created_at->format('d M Y, H:i') }}</p>
                        <hr>
                        <h5>Last Updated</h5>
                        <p>{{ $faq->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
