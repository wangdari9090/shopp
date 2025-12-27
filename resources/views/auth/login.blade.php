@extends('layouts.usermain')

@push('styles')
    @vite(['resources/auth/login.css']) 
@endpush

@section('content')

<div class="d-flex justify-content-center align-items-center" style="min-height: 80vh; background-color: #f9f9f7;">
    <div class="card shadow-lg login-card" style="width: 400px;">
        <div class="card-body p-4">
            <div class="text-center mb-4">
                <h3 class="fw-bold" style="color: var(--forest);">Welcome Back</h3>
                <p class="text-muted small">Enter your credentials to access your collection</p>
            </div>

            <div style="min-height: 50px;">
                @if(session('error'))
                    <div class="alert alert-danger py-2 small">
                        {{ session('error') }}
                    </div>
                @endif
            </div>

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label small fw-bold text-uppercase">Email Address</label>
                    <input type="email" name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           id="email" value="{{ old('email') }}" placeholder="name@example.com">
                    <div class="invalid-feedback d-block" style="min-height: 20px;">
                        @error('email') {{ $message }} @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label small fw-bold text-uppercase">Password</label>
                    <input type="password" name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           id="password">
                    <div class="invalid-feedback d-block" style="min-height: 20px;">
                        @error('password') {{ $message }} @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-luxury w-100 py-2">SIGN IN</button>
            </form>

            <p class="mt-4 text-center small text-muted">
                New to the gallery? <a href="{{ route('register') }}" class="login-link">Create Account</a>
            </p>
        </div>
    </div>
</div>
<style>
    .login-card {
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
        border-color: var(--forest);
        box-shadow: 0 0 0 0.2rem rgba(13, 59, 38, 0.2);
        outline: 0;
    }

     .login-link { color: var(--forest); text-decoration: none; font-weight: 600; }
    .login-link:hover { color: var(--gold); }
</style>
@endsection