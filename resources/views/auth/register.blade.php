@extends('layouts.usermain')

@section('title', 'Register')

@section('content')

<div class="d-flex justify-content-center align-items-center" style="min-height: 90vh; background-color: #f9f9f7;">
    <div class="card shadow-lg register-card" style="width: 450px;">
        <div class="card-body p-4">
            <div class="text-center mb-4">
                <h3 class="fw-bold" style="color: var(--forest);">Create Account</h3>
                <p class="text-muted small">Join our exclusive watch community</p>
            </div>

            @if(session('error'))
                <div class="alert alert-danger py-2 small">{{ session('error') }}</div>
            @endif

            <form action="{{ route('register') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label for="name" class="form-label small fw-bold text-uppercase">Full Name</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                           id="name" value="{{ old('name') }}" placeholder="John Doe" autofocus>
                     <div class="invalid-feedback d-block" style="min-height: 20px;">
                        @error('name') {{ $message }} @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label small fw-bold text-uppercase">Email Address</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                           id="email" value="{{ old('email') }}" placeholder="name@example.com">
                    <div class="invalid-feedback d-block" style="min-height: 20px;">
                        @error('email') {{ $message }} @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label small fw-bold text-uppercase">Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password">
                    <div class="invalid-feedback d-block" style="min-height: 20px;">
                        @error('email') {{ $message }} @enderror
                    </div>
                </div>

                <div class="mb-5">
                    <label for="password_confirmation" class="form-label small fw-bold text-uppercase">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" 
                           id="password_confirmation">
                </div>

                <button type="submit" class="btn btn-luxury w-100 py-2">CREATE ACCOUNT</button>
            </form>

            <p class="mt-4 text-center small text-muted">
                Already have an account? <a href="{{ route('login') }}" class="login-link">Sign In</a>
            </p>
        </div>
    </div>
</div>

<style>
    .register-card {
        border: none;
        border-top: 2px solid var(--gold);
        border-radius: 8px;
    }
     .btn-luxury {
        background-color: var(--forest);
        color: white;
        border: none;
        letter-spacing: 1px;
        font-weight: 600;
        transition: 0.3s;
    }
    .btn-luxury:hover {
        background-color: #08291a;
        color: white;
    }
    .form-control:focus {
        border-color: var(--forest) !important;
        box-shadow: 0 0 0 0.25rem rgba(13, 59, 38, 0.2) !important;
        outline: 0;
    }
    .login-link { color: var(--forest); text-decoration: none; font-weight: 600; }
    .login-link:hover { color: var(--gold); }
</style>
@endsection