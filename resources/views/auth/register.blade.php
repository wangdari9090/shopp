@extends('layouts.usermain')

@section('title', 'Register')

@section('content')
<style>
    /* Container must be relative for absolute error positioning */
    .input-group-container {
        position: relative;
        display: flex;
        align-items: center;
    }

    /* 1. The Masking Error Style */
    .input-error-inside {
        position: absolute;
        left: 10px; /* Aligned to the right */
        font-size: 0.75rem;
        color: #dc3545;
        font-weight: 700;
        pointer-events: none;
        white-space: nowrap;
        z-index: 5;
        
        /* This covers the typed text */
        background-color: white; 
        padding: 0 8px;
        border-radius: 4px;
        display: none; /* Hidden by default */
    }

    /* Show error only when input is invalid */
    .form-control.is-invalid + .input-error-inside {
        display: block;
    }

    /* 2. Red border for invalid state */
    .form-control.is-invalid {
        border-color: #dc3545 !important;
        position: relative;
    }

    /* Card & Button Aesthetics */
    .register-card { border: none; border-top: 2px solid var(--gold); border-radius: 8px; }
    .btn-luxury { background-color: var(--forest); color: white; border: none; letter-spacing: 1px; font-weight: 600; }
    .btn-luxury:hover { background-color: #08291a; color: white; }
    .login-link { color: var(--forest); text-decoration: none; font-weight: 600; }
</style>

<div class="d-flex justify-content-center align-items-center" style="min-height: 90vh; background-color: #f9f9f7;">
    <div class="card shadow-lg register-card" style="width: 450px;">
        <div class="card-body p-4">
            <div class="text-center mb-4">
                <h3 class="fw-bold" style="color: var(--forest);">Create Account</h3>
                <p class="text-muted small">Join our exclusive watch community</p>
            </div>

            <form id="registerForm" action="{{ route('register') }}" method="POST" autocomplete="off">
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
                    <label for="password" class="form-label small fw-bold text-uppercase" autocomplete="new-password">Password</label>
                    <div class="input-group-container">
                        <input type="password" name="password" class="form-control" id="password" autocomplete="new-password">
                        <div id="passwordError" class="input-error-inside"></div>
                    </div>
                </div>

                <div class="mb-5">
                    <label for="password_confirmation" class="form-label small fw-bold text-uppercase">Confirm Password</label>
                    <div class="input-group-container">
                        <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" autocomplete="new-password">
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
(function () {
    const registerForm = document.getElementById('registerForm');
    if (!registerForm) return;

    // Function to clear error styling and hide the overlay
    const clearError = (input) => {
        input.classList.remove('is-invalid');
        const errorDiv = document.getElementById(input.id + 'Error');
        if (errorDiv) {
            errorDiv.innerText = '';
            errorDiv.style.display = 'none';
        }
    };

    document.querySelectorAll('.form-control').forEach(input => {
        input.addEventListener('focus', function() { clearError(this); });
        input.addEventListener('input', function() { clearError(this); });
    });

    // AJAX Registration Logic
    registerForm.addEventListener('submit', function(e) {
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
        .then(async response => {
            const data = await response.json();
            if (response.ok && data.success) {
                window.location.href = data.redirect;
            } else if (data.errors) {
                Object.keys(data.errors).forEach(key => {
                    const input = document.getElementById(key);
                    const errorDiv = document.getElementById(key + 'Error');
                    if (input) {
                        input.classList.add('is-invalid');
                        if (errorDiv) {
                            errorDiv.innerText = data.errors[key][0];
                            errorDiv.style.display = 'block';
                        }
                    }
                });
            }
        })
        .catch(error => console.error('Error:', error));
    });
})();
</script>
@endsection