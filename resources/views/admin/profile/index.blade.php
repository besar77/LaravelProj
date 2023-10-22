@extends('admin.layouts.master')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Profile</h1>
        </div>

        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>Update User Settings</h4>

                </div>
                <div class="card-body">

                    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group row mb-4">
                            <div class="col-sm-12 col-md-7">
                                <div id="image-preview" class="image-preview">
                                    <label for="image-upload" id="image-label">Choose File</label>
                                    <input type="file" name="avatar" id="image-upload" />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" value="{{ auth()->user()->name }}">
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control" name="email" value="{{ auth()->user()->email }}">
                        </div>
                        <button class="btn btn-primary" type="submit">Save</button>
                    </form>

                </div>
            </div>

            <div class="card card-primary">
                <div class="card-header">
                    <h4>Update Password</h4>

                </div>
                <div class="card-body">
                    <form action="{{ route('admin.profile.password.update') }}" method="POST">
                        @csrf
                        @method('PUT')


                        <div class="form-group">
                            <label>Current Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="current_password" id="password_current">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary"
                                        onclick="togglePasswordVisibility('password_current')">
                                        <i class="far fa-eye" id="password_currentIcon"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="password" id="passwordField">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary"
                                        onclick="togglePasswordVisibility('passwordField')">
                                        <i id="passwordFieldIcon" class="far fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Confirm Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="password_confirmation"
                                    id="passwordConfirmationField">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary"
                                        onclick="togglePasswordVisibility('passwordConfirmationField')">
                                        <i id="passwordConfirmationFieldIcon" class="far fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>




                        <button class="btn btn-primary" type="submit">Save</button>
                    </form>

                </div>
            </div>

        </div>
    </section>

    <script>
        function togglePasswordVisibility(fieldname) {
            var passwordField = document.getElementById(fieldname);
            var passwordIcon = document.getElementById(fieldname + "Icon");

            if (passwordField.type === "password") {
                passwordField.type = "text";
                passwordIcon.classList.remove("far", "fa-eye");
                passwordIcon.classList.add("far", "fa-eye-slash");
            } else {
                passwordField.type = "password";
                passwordIcon.classList.remove("far", "fa-eye-slash");
                passwordIcon.classList.add("far", "fa-eye");
            }
        }
    </script>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {

            $('.image-preview').css({
                'background-image': 'url({{ asset(auth()->user()->avatar) }})',
                'background-size': 'cover',
                'background-position': 'center center'
            });

        });
    </script>
@endpush
