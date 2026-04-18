@extends('layouts.usermain')

@section('content')
    <div class="container py-5 mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <div id="main-content">
                    <h1 class="serif display-6 fw-bold mb-2" id="page-title">Order Review</h1>
                    <p class="text-muted small text-uppercase tracking-widest mb-4">Reference: #{{ $nextNumber }}</p>

                    <div class="card border-0 shadow-sm p-4 mb-4 bg-white instruction-card">
                        <div class="card-body" id="payment-area">

                            @if($method === 'online_banking' || $method === 'card')
                                <div id="input-step">
                                    <h6 class="serif text-uppercase tracking-widest mb-3" style="color: #b19470;">
                                        {{ $method === 'card' ? 'Card Payment' : 'Bank Transfer' }}
                                    </h6>
                                    <p class="text-muted small">Please transfer
                                        <strong>${{ number_format($total, 2) }}</strong> to our corporate account.
                                    </p>

                                    <div class="bg-light p-3 mb-4 text-start border">
                                        <div class="d-flex justify-content-between mb-1 small">
                                            <span class="text-muted">Bank:</span>
                                            <span class="fw-bold">Global Watch Bank</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-1 small">
                                            <span class="text-muted">Account:</span>
                                            <span class="fw-bold">099-2345-123</span>
                                        </div>
                                        <div class="d-flex justify-content-between small">
                                            <span class="text-muted">Reference:</span>
                                            <span class="fw-bold">#{{ $nextNumber }}</span>
                                        </div>
                                    </div>

                                    <form id="transfer-form">
                                        @csrf
                                        <div class="mb-3 text-start">
                                            <label class="small text-muted fw-bold text-uppercase mb-2 d-block">
                                                Transaction Reference Number
                                            </label>
                                            <input type="text" name="transaction_reference"
                                                class="form-control rounded-0 fancy-input-box"
                                                placeholder="Enter Reference ID (e.g. TRN-123456)" required>
                                        </div>
                                        <div id="transfer-error" class="alert alert-danger small d-none mb-3"></div>
                                        <button type="submit" class="btn btn-confirm w-100 py-3" id="confirm-btn">
                                            CONFIRM TRANSFER
                                        </button>
                                    </form>
                                </div>

                            @else
                                {{-- Cash on Delivery --}}
                                <div id="input-step">
                                    <h6 class="serif text-uppercase tracking-widest mb-3" style="color: #b19470;">
                                        Cash on Delivery
                                    </h6>
                                    <p class="text-muted small">Please prepare
                                        <strong>${{ number_format($total, 2) }}</strong> for the courier upon delivery.
                                    </p>
                                    <div class="bg-light p-3 mb-4 text-start border small text-muted">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Your order will be processed once you confirm below.
                                    </div>
                                    <div id="cod-error" class="alert alert-danger small d-none mb-3"></div>
                                    <form id="cod-form">
                                        @csrf
                                        <button type="submit" class="btn btn-confirm w-100 py-3" id="cod-btn">
                                            CONFIRM ORDER
                                        </button>
                                    </form>
                                </div>
                            @endif

                        </div>

                        {{-- Success Section (shown after finalize) --}}
                        <div id="success-step" class="d-none py-4">
                            <div class="mb-3">
                                <i class="bi bi-check-circle text-success" style="font-size: 3rem;"></i>
                            </div>
                            <h4 class="serif fw-bold">Order Confirmed!</h4>
                            <p class="text-muted small">Thank you for your purchase. We are now preparing your
                                timepiece for delivery.</p>
                            <a href="{{ url('/') }}"
                                class="btn-return px-5 py-3 text-decoration-none d-inline-block mt-4">
                                CONTINUE SHOPPING
                            </a>
                        </div>
                    </div>

                    <a href="{{ route('cart.index') }}" class="text-muted small text-decoration-none">
                        <i class="bi bi-arrow-left me-1"></i> Back to cart
                    </a>
                </div>
            </div>
        </div>
    </div>

    <style>
        .fancy-input-box {
            border: 1px solid #e0e0e0;
            padding: 12px;
            font-size: 0.9rem;
        }

        .fancy-input-box:focus {
            border-color: #b19470;
            box-shadow: none;
        }

        .instruction-card {
            border-radius: 0;
            border: 1px solid #f0f0f0 !important;
            position: relative;
        }

        .instruction-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: #b19470;
        }

        .btn-confirm {
            background: #1a1a1a;
            color: white;
            border-radius: 0;
            font-size: 0.8rem;
            letter-spacing: 1px;
            transition: 0.3s;
        }

        .btn-confirm:hover {
            background: #333;
            color: white;
        }

        .btn-return {
            background: #1a1a1a;
            color: white;
            font-size: 0.75rem;
            letter-spacing: 2px;
            border: 1px solid #1a1a1a;
        }

        #success-step {
            animation: fadeInUp 0.5s ease forwards;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>

    <script>
        function finalizeOrder(formEl, btnId, errorId) {
            const btn       = document.getElementById(btnId);
            const errorBox  = document.getElementById(errorId);
            const inputStep = document.getElementById('input-step');
            const successStep = document.getElementById('success-step');
            const origText  = btn.innerHTML;

            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> PROCESSING...';
            if (errorBox) errorBox.classList.add('d-none');

            const formData = new FormData(formEl);

            fetch("{{ route('order.finalize') }}", {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json',
                }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    inputStep.classList.add('d-none');
                    successStep.classList.remove('d-none');
                    document.getElementById('page-title').innerText = 'Order Confirmed';

                    // Clear cart badge
                    const badge = document.getElementById('cart-count');
                    if (badge) { badge.innerText = '0'; badge.style.display = 'none'; }
                } else {
                    btn.disabled = false;
                    btn.innerHTML = origText;
                    if (errorBox) {
                        errorBox.innerText = data.message || 'Something went wrong. Please try again.';
                        errorBox.classList.remove('d-none');
                    }
                }
            })
            .catch(() => {
                btn.disabled = false;
                btn.innerHTML = origText;
                if (errorBox) {
                    errorBox.innerText = 'Network error. Please check your connection and try again.';
                    errorBox.classList.remove('d-none');
                }
            });
        }

        document.getElementById('transfer-form')?.addEventListener('submit', function(e) {
            e.preventDefault();
            finalizeOrder(this, 'confirm-btn', 'transfer-error');
        });

        document.getElementById('cod-form')?.addEventListener('submit', function(e) {
            e.preventDefault();
            finalizeOrder(this, 'cod-btn', 'cod-error');
        });
    </script>
@endsection