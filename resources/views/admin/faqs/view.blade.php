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
                    <!-- Question and Answer (Full Width) -->
                    <div class="col-12">
                        <h5>Question</h5>
                        <p>{{ $faq->question }}</p>
                        <hr>
                        <h5>Answer</h5>
                        <p>{{ $faq->answer }}</p>
                        <hr>
                    </div>

                    <!-- Service Category Information -->
                    <div class="col-lg-6 col-12">
                        @if ($faq->service)
                            @if ($faq->service->category)
                                <h5>Category</h5>
                                <p>{{ $faq->service->category->name }}</p>
                            @else
                                <h5>Category</h5>
                                <p><em>No category assigned</em></p>
                            @endif
                        @else
                            <h5>Service Information</h5>
                            <p><em>No service information available</em></p>
                        @endif
                    </div>

                    <div class="col-lg-6 col-12">
                        @if ($faq->service)
                            @if ($faq->service->subcategory)
                                <h5>Subcategory</h5>
                                <p>{{ $faq->service->subcategory->name }}</p>
                            @else
                                <h5>Subcategory</h5>
                                <p><em>No subcategory assigned</em></p>
                            @endif
                        @endif
                    </div>

                    <div class="col-lg-6 col-12">
                        @if ($faq->service)
                            <h5>Service</h5>
                            <p>{{ $faq->service->name }}</p>
                        @endif
                    </div>

                    <!-- Status and Timestamps -->
                    <div class="col-lg-6 col-12">
                        <h5>Status</h5>
                        <p>
                            @if ($faq->status == 1)
                                <span class="status-badge completed"> Active </span>
                            @else
                                <span class="status-badge pending"> Inactive </span>
                            @endif
                        </p>
                    </div>

                    <div class="col-lg-6 col-12">
                        <h5>Created At</h5>
                        <p>{{ $faq->created_at->format('d M Y, H:i') }}</p>
                    </div>

                    <div class="col-lg-6 col-12">
                        <h5>Last Updated</h5>
                        <p>{{ $faq->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
