@extends('masterdesign')

@section('title', 'Register')

@section('register')
<div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow-sm" style="width: 400px;">
        <div class="card-body">
            <h3 class="card-title text-center mb-4">Register Your Account</h3>

            <!-- Display Session Error -->
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <!-- Login Form -->
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <!-- Name -->
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name') }}" autofocus>
                    @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ old('email') }}" autofocus>
                    @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-3">
                <label for="passwor" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password">
                    @error('password')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Confirm Password -->
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation">
                    @error('password_confirmation')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Remember Me</label>
                </div>

                <!-- Submit -->
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>

            <!-- login? Link -->
            <p class="mt-3 text-center">
                Already have an account? <a href="{{ route('login.show') }}">Login</a>
            </p>
        </div>
    </div>
</div>
@endsection