@extends('admin.layout')
@section('content')
<main class="login-form">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <h3 class="card-header text-center">Login</h3>
                    <div class="card-body">
                        <form id="loginForm" method="POST" action="{{ route('login.post') }}">
                            @csrf
                            @if($message = Session::get('success'))
                                <div class="alert alert-success">
                                    {{ $message }}
                                </div>
                            @endif
                            <div class="form-group mb-3">
                                <input type="text" placeholder="Email" id="email" class="form-control" name="email"
                                    value="{{ old('email') }}"  autofocus>
                                <span class="text-danger" id="emailError"></span>
                                @if($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                            <div class="form-group mb-3">
                                <input type="password" placeholder="Password" id="password" class="form-control"
                                    name="password" value="{{ old('password') }}" >
                                <span class="text-danger" id="passwordError"></span>
                                @if($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                            <div class="form-group mb-3">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember"> Remember Me
                                    </label>
                                </div>
                            </div>
                            <div class="d-grid mx-auto">
                                <button type="submit" class="btn btn-dark btn-block">Signin</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    $(document).ready(function() {
        $('#loginForm').on('submit', function(event) {
            // Clear previous errors
            $('#emailError').text('');
            $('#passwordError').text('');

            let email = $('#email').val().trim();
            let password = $('#password').val().trim();
            let valid = true;

            // Validate email
            if (email === '') {
                $('#emailError').text('Email is required.');
                valid = false;
            } else if (!validateEmail(email)) {
                $('#emailError').text('Invalid email format.');
                valid = false;
            }

            // Validate password
            if (password === '') {
                $('#passwordError').text('Password is required.');
                valid = false;
            }

            if (!valid) {
                event.preventDefault();
            }
        });

        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }
    });
</script>
@endsection
