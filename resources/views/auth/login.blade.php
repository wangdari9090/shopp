@extends('layouts.usermain')

@section('content')
<style>
    /* 1. Reset container to stack items vertically */
    .input-group-container { 
        display: flex; 
        flex-direction: column; 
    }
    
    /* 2. Style error text to sit clearly below the input */
    .input-error-under {
        font-size: 0.75rem;
        color: #dc3545;
        font-weight: 600;
        margin-top: 4px; /* Space between input and error */
        min-height: 18px; /* Prevents card jumping when error appears */
    }

    /* 3. Standard red border for invalid state */
    .form-control.is-invalid {
        border-color: #dc3545 !important;
        padding-right: 12px !important; /* Reset padding back to normal */
    }

    .login-card { border: none; border-top: 2px solid var(--gold); border-radius: 8px; }
    .btn-luxury { background-color: var(--forest); color: white; border: none; font-weight: 600; }
    .btn-luxury:hover { background-color: #08291a; color: white; }
</style>

<div class="d-flex justify-content-center align-items-center" style="min-height: 80vh; background-color: #f9f9f7;">
    <div class="card shadow-lg login-card" style="width: 400px;">
        <div class="card-body p-4">
            <div class="text-center mb-4">
                <h3 class="fw-bold" style="color: var(--forest);">Welcome Back</h3>
            </div>

            <form id="loginForm" action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label small fw-bold">EMAIL</label>
                    <div class="input-group-container">
                        <input type="email" name="email" class="form-control" id="email" autofocus>
                        <div id="emailError" class="input-error-under"></div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label small fw-bold">PASSWORD</label>
                    <div class="input-group-container">
                        <input type="password" name="password" class="form-control" id="password">
                        <div id="passwordError" class="input-error-under"></div>
                    </div>
                </div>

                <button type="submit" class="btn btn-luxury w-100 py-2">SIGN IN</button>
            </form>

            <p class="mt-4 text-center small">
                New? <a href="{{ route('register') }}" style="color: var(--forest);">Create Account</a>
            </p>
        </div>
    </div>
</div>

<script>
    // Clear error when user types
    document.querySelectorAll('.form-control').forEach(input => {
        input.addEventListener('input', function() {
            this.classList.remove('is-invalid');
            const err = document.getElementById(this.id + 'Error');
            if (err) err.innerText = '';
        });
    });

    document.getElementById('loginForm').addEventListener('submit', function(e) {
        e.preventDefault();

        fetch(this.action, {
            method: "POST",
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json"
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
                    const errorBox = document.getElementById(key + 'Error');
                    if (input) input.classList.add('is-invalid');
                    if (errorBox) errorBox.innerText = data.errors[key][0];
                });
            }
        })
        .catch(error => console.error('Error:', error));
    });
</script>
@endsection