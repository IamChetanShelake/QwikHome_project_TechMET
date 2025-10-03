@extends('admin.layouts.masterlayout')

@section('content')
    <div class="content-area">

        <div class="">

            <div class="dashboard-card p-3">

                <div class="card-header">

                    <h3>Create Promocode</h3>
                    <a href="{{ route('promocodes.index') }}" class="btn btn-secondary">Back</a>
                </div>
                <div class="card-body">

                    <form method="POST" action="{{ route('promocodes.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="code">Promocode (alphanumeric only, e.g. ABC123)</label>
                                    <input type="text" class="form-control" id="code" name="code" required
                                           pattern="[A-Za-z0-9]+" title="Only letters and numbers allowed">
                                    @error('code')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="discount">Discount Amount ({{ config('app.currency', 'AED') }})</label>
                                    <input type="number" step="0.01" min="0" class="form-control" id="discount"
                                        name="discount" required>
                                    @error('discount')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="expiry_date">Expiry Date (optional)</label>
                                    <input type="datetime-local" class="form-control" id="expiry_date" name="expiry_date">
                                    @error('expiry_date')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Create Promocode</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
