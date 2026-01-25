@extends('layouts.usermain')

@section('title', 'Register')

@section('content')
<style>
    /* Container for positioning */
    .input-group-container {
        position: relative;
        display: flex;
        align-items: center;
    }

    /* Error text style inside the input - Fixed to RIGHT */
    .input-error-inside {
        position: absolute;
        left: 12px;
        font-size: 0.7rem;
        color: #dc3545;
        font-weight: 700;
        pointer-events: none;
        white-space: nowrap;
        z-index: 5;
    }

    /* Red border and space for error text */
    .form-control.is-invalid {
        border-color: #dc3545 !important;
        padding-right: 110px !important; 
    }

    .register-card { border: none; border-top: 2px solid var(--gold); border-radius: 8px; }
    .btn-luxury { background-color: var(--forest); color: white; border: none; letter-spacing: 1px; font-weight: 600; }
    .btn-luxury:hover { background-color: #08291a; color: white; }
    
    .form-control:focus { 
        border-color: var(--forest) !important; 
        box-shadow: 0 0 0 0.25rem rgba(13, 59, 38, 0.2) !important; 
    }
    .login-link { color: var(--forest); text-decoration: none; font-weight: 600; }
</style>

<div class="d-flex justify-content-center align-items-center" style="min-height: 90vh; background-color: #f9f9f7;">
    <div class="card shadow-lg register-card" style="width: 450px;">
        <div class="card-body p-4">
            <div class="text-center mb-4">
                <h3 class="fw-bold" style="color: var(--forest);">Create Account</h3>
                <p class="text-muted small">Join our exclusive watch community</p>
            </div>

            <form id="registerForm" action="{{ route('register') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label for="name" class="form-label small fw-bold text-uppercase">Full Name</label>
                    <div class="input-group-container">
                        <input type="text" name="name" class="form-control" id="name" autofocus>
                        <div id="nameError" class="input-error-inside"></div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label small fw-bold text-uppercase">Email Address</label>
                    <div class="input-group-container">
                        <input type="email" name="email" class="form-control" id="email">
                        <div id="emailError" class="input-error-inside"></div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label small fw-bold text-uppercase">Password</label>
                    <div class="input-group-container">
                        <input type="password" name="password" class="form-control" id="password">
                        <div id="passwordError" class="input-error-inside"></div>
                    </div>
                </div>

                <div class="mb-5">
                    <label for="password_confirmation" class="form-label small fw-bold text-uppercase">Confirm Password</label>
                    <div class="input-group-container">
                        <input type="password" name="password_confirmation" class="form-control" id="password_confirmation">
                    </div>
                </div>

                <button type="submit" class="btn btn-luxury w-100 py-2">CREATE ACCOUNT</button>
            </form>

            <p class="mt-4 text-center small text-muted">
                Already have an account? <a href="{{ route('login') }}" class="login-link">Sign In</a>
            </p>
        </div>
    </div>
</div>

<script>
// 1. Clear error when typing
document.querySelectorAll('.form-control').forEach(input => {
    input.addEventListener('input', function() {
        this.classList.remove('is-invalid');
        const errorDiv = document.getElementById(this.id + 'Error');
        if (errorDiv) errorDiv.innerText = '';
    });
});

// 2. Simple AJAX Registration
document.getElementById('registerForm').addEventListener('submit', function(e) {
    e.preventDefault();

    fetch(this.action, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Accept": "application/json",
            "X-Requested-With": "XMLHttpRequest"
        },
        body: new FormData(this)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = data.redirect;
        } else if (data.errors) {
            Object.keys(data.errors).forEach(key => {
                const input = document.getElementById(key);
                const errorDiv = document.getElementById(key + 'Error');
                if (input) input.classList.add('is-invalid');
                if (errorDiv) errorDiv.innerText = data.errors[key][0];
            });
        }
    })
    .catch(error => console.error('Error:', error));
});
</script>
@endsection