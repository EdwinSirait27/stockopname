@extends('layouts.auth')

@section('title', 'Register')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush
@section('main')
    <div class="card card-primary">
        <div class="card-header">
            <h4>Register</h4>
        </div>
     
        <div class="card-body">
            <form action="{{ route('auth-register.register') }}" method="POST">
                @csrf
                @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

                <div class="row">
                    <div class="form-group col-6">
                        <label for="Name">Name</label>
                        <input id="name" type="text" placeholder="Fill your name"
                            class="form-control text-capitalize" name="name" value="{{ old('name') }}" autofocus>

                    </div>
                    <div class="form-group col-6">
                        <label for="username">Username</label>
                        <input id="username" placeholder="create your username" type="number"
                            class="form-control"value="{{ old('username') }}" name="username" autofocus>
                        <small class="form-text text-muted">*min 8 character exp:08234729</small>
                    </div>

                    <script>
                        document.getElementById('name').addEventListener('blur', function() {
                            this.value = this.value.replace(/\b\w/g, c => c.toUpperCase());
                        });
                    </script>
                    <div class="form-group col-12">
                        <label for="password">Password</label>
                        <div class="input-group">
                            <input id="password" placeholder="create your password" type="password"
                                class="form-control pwstrength" data-indicator="pwindicator" name="password">
                                
                                <div class="input-group-append">
                                    <span class="input-group-text" onclick="togglePassword()" style="cursor: pointer;">
                                        <i class="fa fa-eye" id="eyeIcon"></i>
                                    </span>
                                </div>
                            </div>
                            <small class="form-text text-muted">*min 8 character exp:08234729</small>
                        <div id="pwindicator" class="pwindicator">
                            <div class="bar"></div>
                            <div class="label"></div>
                        </div>
                    </div>
                    <script>
                        function togglePassword() {
                            const passwordInput = document.getElementById('password');
                            const eyeIcon = document.getElementById('eyeIcon');
                            const isPassword = passwordInput.type === 'password';

                            passwordInput.type = isPassword ? 'text' : 'password';
                            eyeIcon.classList.toggle('fa-eye');
                            eyeIcon.classList.toggle('fa-eye-slash');
                        }
                    </script>

                </div>
                {{-- <div class="form-group">
                    <label for="password2" class="d-block">Password Confirmation</label>
                    <input id="password2" type="password" class="form-control" name="password_confirmation">
                    
                </div> --}}
                {{-- <div class="form-group">
                    <button type="submit" class="btn btn-success btn-lg btn-block">
                        Register
                    </button>
                </div> --}}
                <div class="form-group d-flex justify-content-between">
                    <a href="{{ route('login') }}" class="btn btn-secondary btn-lg">
                        Back
                    </a>
                    <button type="submit" class="btn btn-success btn-lg">
                        Register
                    </button>
                </div>

            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
    <script src="{{ asset('library/jquery.pwstrength/jquery.pwstrength.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/auth-register.js') }}"></script>
@endpush
