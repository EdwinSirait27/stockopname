@extends('layouts.app')
@section('title', 'Edit Users')
@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-social/assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .password-wrapper {
            position: relative;
        }

        .password-wrapper input {
            padding-right: 42px;
            /* beri ruang untuk ikon */
        }

        .toggle-password {
            position: absolute;
            top: 50%;
            right: 12px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
            font-size: 1rem;
        }

        .toggle-password:hover {
            color: #343a40;
        }

        .pwindicator {
            margin-top: 5px;
        }
        select.form-control, select.form-select {
    font-size: 2rem;
    color: #212529;
}

    </style>
@endpush
@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>User : {{ $user->name }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Users</a></div>
                    <div class="breadcrumb-item">Users</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row mt-sm-4">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <form action="{{ route('users.update', $hashedId) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <h4>Edit Profile {{ $user->name }}</h4>
                                    @if (session('status'))
                                        <div class="alert alert-success">
                                            {{ session('status') }}
                                        </div>
                                    @endif
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    {{-- <div class="row">
                                        <div class="form-group col-md-6 col-12">
                                            <label>Name</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                               value="{{ old('name', $user->name) }}">
                                            <div class="invalid-feedback">
                                                Please fill in the Name
                                            </div>
                                        </div>
                                        
                                            <div class="form-group col-md-6 col-12">
                                                    <label>Roles</label>
                                                    <div class="@error('role') border border-danger rounded-3 @enderror">
                                                        <select class="form-control @error('role') is-invalid @enderror" name="role" id="role"
                                                            required>

                                                            <option value="">Select Role</option>
                                                            @foreach ($roles as $name => $displayName)
                                                                <option value="{{ $name }}"
                                                                    {{ $selectedRole == $name ? 'selected' : '' }}>
                                                                    {{ $displayName }}
                                                                </option>
                                                            @endforeach
                                                        </select>


                                                        @error('role')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                </div>
                                            </div>

                                        <div class="form-group col-md-6 col-12">
                                            <label for="newPassword">New Password</label>
                                            <div class="password-wrapper position-relative">
                                                <input type="password" class="form-control pwstrength" id="newPassword"
                                                    data-indicator="pwindicator" name="new_password">
                                                <span class="toggle-password" onclick="togglePassword()">
                                                    <i id="eyeIcon" class="fa fa-eye"></i>
                                                </span>
                                                <div class="invalid-feedback">
                                                    Please fill in the New Password
                                                </div>
                                                <div id="pwindicator" class="pwindicator">
                                                    <div class="bar"></div>
                                                    <div class="label"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <script>
                                            function togglePassword() {
                                                const passwordInput = document.getElementById("newPassword");
                                                const eyeIcon = document.getElementById("eyeIcon");

                                                if (passwordInput.type === "password") {
                                                    passwordInput.type = "text";
                                                    eyeIcon.classList.remove("fa-eye");
                                                    eyeIcon.classList.add("fa-eye-slash");
                                                } else {
                                                    passwordInput.type = "password";
                                                    eyeIcon.classList.remove("fa-eye-slash");
                                                    eyeIcon.classList.add("fa-eye");
                                                }
                                            }
                                        </script>
                                    </div> --}}
                                    <div class="row">
                                        <!-- Name Field -->
                                        <div class="form-group col-md-6 col-12">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                value="{{ old('name', $user->name) }}">
                                            <div class="invalid-feedback">
                                                Please fill in the Name
                                            </div>
                                        </div>

                                       <!-- Roles Field -->
<div class="form-group col-md-6 col-12">
    <label for="role">Roles</label>
    <div class="@error('role') border border-danger rounded-3 @enderror">
        <select class="form-select @error('role') is-invalid @enderror" name="role" id="role" required>
            <option value="">Select Role</option>
            @foreach ($roles as $name => $displayName)
                <option value="{{ $name }}" {{ $selectedRole == $name ? 'selected' : '' }}>
                    {{ $displayName ?? ucfirst($name) }}
                </option>
            @endforeach
        </select>
        @error('role')
            <span class="invalid-feedback d-block" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>




                                        <!-- New Password Field -->
                                        <div class="form-group col-md-6 col-12">
                                            <label for="newPassword">New Password</label>
                                            <div class="password-wrapper position-relative">
                                                <input type="password" class="form-control pwstrength" id="newPassword"
                                                    data-indicator="pwindicator" name="new_password">
                                                <span
                                                    class="toggle-password position-absolute top-50 end-0 translate-middle-y pe-3"
                                                    onclick="togglePassword()">
                                                    <i id="eyeIcon" class="fa fa-eye"></i>
                                                </span>
                                                <div class="invalid-feedback">
                                                    Please fill in the New Password
                                                </div>
                                                <div id="pwindicator" class="pwindicator mt-2">
                                                    <div class="bar"></div>
                                                    <div class="label"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <script>
                                        function togglePassword() {
                                            const passwordInput = document.getElementById("newPassword");
                                            const eyeIcon = document.getElementById("eyeIcon");

                                            if (passwordInput.type === "password") {
                                                passwordInput.type = "text";
                                                eyeIcon.classList.remove("fa-eye");
                                                eyeIcon.classList.add("fa-eye-slash");
                                            } else {
                                                passwordInput.type = "password";
                                                eyeIcon.classList.remove("fa-eye-slash");
                                                eyeIcon.classList.add("fa-eye");
                                            }
                                        }
                                    </script>

                                </div>
                                <div class="card-footer d-flex justify-content-between">
                                    <a href="{{ url('/users') }}" class="btn btn-secondary">Back</a>
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/summernote/dist/summernote-bs4.js') }}"></script>
    <script src="{{ asset('library/jquery.pwstrength/jquery.pwstrength.min.js') }}"></script>
    <script src="{{ asset('js/page/features-profile.js') }}"></script>
    <!-- Page Specific JS File -->
@endpush
