@extends('admin.layouts.masterlayout')

@section('content')
    <div class="content-area">
        <div class="">
            <div class="dashboard-card">
                <div class="card-header">
                    <h3>Edit FAQ</h3>
                    <a href="{{ route('faq') }}" class="btn btn-secondary">Back</a>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('faq.update', $faq->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="question">Question</label>
                            <input type="text" class="form-control" id="question" name="question"
                                value="{{ $faq->question }}" required>
                            @error('question')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="answer">Answer</label>
                            <textarea class="form-control" id="answer" name="answer" rows="5" required>{{ $faq->answer }}</textarea>
                            @error('answer')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="1" {{ $faq->status == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $faq->status == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Update FAQ</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
