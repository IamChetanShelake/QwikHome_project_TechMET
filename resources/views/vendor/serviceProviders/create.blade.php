@extends('admin.layouts.masterlayout')

@section('content')
    <div class="content-area">

        <div class="">

            <div class="dashboard-card p-3">

                <div class="card-header">

                    <h3>Create Service Provider</h3>
                    <a href="{{ route('serviceProviders.index') }}" class="btn btn-secondary">Back</a>
                </div>
                <div class="card-body">

                    <form method="POST" action="{{ route('serviceProviders.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="phone">Phone (optional)</label>
                                    <input type="number" class="form-control" id="phone" name="phone">
                                    @error('phone')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                    @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="password" name="password">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" id="togglePassword"
                                                style="border-left: none;">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @error('password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>
                        <div class="row">

                            <div class="form-group">
                                <input type="hidden" name="role" value="serviceprovider">
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="address">Address (optional)</label>
                                    <textarea class="form-control" id="address" name="address" rows="3"></textarea>
                                    @error('address')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="image">Image (optional)</label>
                                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                    @error('image')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Create Service Provider</button>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <script>
        $(document).ready(function() {
            $('#togglePassword').on('click', function(e) {
                e.preventDefault();

                const passwordInput = $('#password');
                const toggleButton = $(this);
                const icon = toggleButton.find('i');

                if (passwordInput.attr('type') === 'password') {
                    passwordInput.attr('type', 'text');
                    icon.removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    passwordInput.attr('type', 'password');
                    icon.removeClass('fa-eye-slash').addClass('fa-eye');
                }
                console.log('Password toggle clicked');
            });
        });
    </script>
@endsection
