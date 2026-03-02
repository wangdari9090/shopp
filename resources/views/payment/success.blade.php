@extends('layouts.usermain')

@section('content')
<div class="container py-5 mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 text-center">
            <div id="main-content">
                <h1 class="serif display-6 fw-bold mb-2">Order Received</h1>
                <p class="text-muted small text-uppercase tracking-widest mb-4">Voucher: #{{ $order->user_order_number }}</p>

                <div class="card border-0 shadow-sm p-4 mb-4 bg-white instruction-card">
                    <div class="card-body" id="payment-area">
                        @if($method === 'online_banking' || $method === 'card')
                            <div id="input-step">
                                <h6 class="serif text-uppercase tracking-widest mb-3" style="color: #b19470;">Instant Bank Transfer</h6>
                                <p class="text-muted small">Please transfer <strong>${{ number_format($order->total_price, 2) }}</strong> to our corporate account.</p>
                                
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
                                        <span class="fw-bold">#{{ $order->user_order_number }}</span>
                                    </div>
                                </div>

                                <form id="transfer-form">
                                    @csrf
                                    <div class="mb-3 text-start">
                                        <label class="small text-muted fw-bold text-uppercase mb-2 d-block">Transaction Reference Number</label>
                                        <input type="text" class="form-control rounded-0 fancy-input-box" placeholder="Enter Reference ID (e.g. TRN-123456)" required>
                                    </div>
                                    <button type="submit" class="btn btn-confirm w-100 py-3" id="confirm-btn">CONFIRM TRANSFER</button>
                                </form>
                            </div>
                        @else
                            <h6 class="serif text-uppercase tracking-widest mb-3" style="color: #b19470;">Cash on Delivery</h6>
                            <p class="text-muted small">Your order is confirmed. Please prepare <strong>${{ number_format($order->total_price, 2) }}</strong> for the courier.</p>
                            <a href="{{ url('/') }}" class="btn-return px-5 py-3 text-decoration-none d-inline-block mt-3">RETURN TO GALLERY</a>
                        @endif
                    </div>

                    {{-- Hidden Success Section --}}
                    <div id="success-step" class="d-none py-4">
                        <div class="mb-3">
                            <i class="bi bi-check-circle text-success" style="font-size: 3rem;"></i>
                        </div>
                        <h4 class="serif fw-bold">Payment Confirmed</h4>
                        <p class="text-muted small">Thank you for your purchase. We are now preparing your timepiece for delivery.</p>
                        <a href="{{ url('/') }}" class="btn-return px-5 py-3 text-decoration-none d-inline-block mt-4">CONTINUE SHOPPING</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .fancy-input-box { border: 1px solid #e0e0e0; padding: 12px; font-size: 0.9rem; }
    .fancy-input-box:focus { border-color: #b19470; box-shadow: none; }
    .instruction-card { border-radius: 0; border: 1px solid #f0f0f0 !important; position: relative; }
    .instruction-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; background: #b19470; }
    .btn-confirm { background: #1a1a1a; color: white; border-radius: 0; font-size: 0.8rem; letter-spacing: 1px; transition: 0.3s; }
    .btn-return { background: #1a1a1a; color: white; font-size: 0.75rem; letter-spacing: 2px; border: 1px solid #1a1a1a; }
    
    #success-step { animation: fadeInUp 0.5s ease-forwards; }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<script>
document.getElementById('transfer-form')?.addEventListener('submit', function(e) {
    e.preventDefault();
    const btn = document.getElementById('confirm-btn');
    const inputStep = document.getElementById('input-step');
    const successStep = document.getElementById('success-step');

    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> VERIFYING REFERENCE...';

    // Simulate bank verification delay
    setTimeout(() => {
        inputStep.classList.add('d-none');
        successStep.classList.remove('d-none');
        document.querySelector('h1').innerText = "Order Confirmed";
    }, 2000);
});
</script>
@endsection