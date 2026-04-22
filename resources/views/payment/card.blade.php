@extends('layouts.usermain')

@section('title', 'Payment - Credit Card')

@section('content')
<div class="container py-5" style="min-height: 70vh;">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="text-center mb-5">
                <i class="bi bi-credit-card-2-front text-forest" style="font-size: 3rem;"></i>
                <h2 class="serif mt-3 text-uppercase tracking-widest">Secure Checkout</h2>
                <p class="text-muted small">Order #{{ $order->user_order_number }} • Total: ${{ number_format($order->total_price, 2) }}</p>
            </div>

            <div class="card border-0 shadow-sm p-4">
                {{-- This is where the Stripe/Gateway Element will eventually go --}}
                <div class="alert alert-light border text-center py-4">
                    <i class="bi bi-shield-lock me-2"></i>
                    <span class="small text-uppercase tracking-tight">Encryption Active</span>
                    <hr>
                    <p class="mb-0 small text-muted">Card payments are currently being processed via our secure partner portal.</p>
                </div>

                <div class="d-grid gap-2 mt-4">
                    <button class="btn btn-dark rounded-0 py-3 fw-bold shadow-none">
                        PROCEED TO SECURE PORTAL
                    </button>
                    <a href="{{ route('index') }}" class="btn btn-link text-decoration-none text-muted small mt-2">
                        Cancel and return to gallery
                    </a>
                </div>
            </div>

            <div class="text-center mt-4">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5e/Visa_Inc._logo.svg/2560px-Visa_Inc._logo.svg.png" height="15" class="mx-2 opacity-50" alt="Visa">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2a/Mastercard-logo.svg/1280px-Mastercard-logo.svg.png" height="20" class="mx-2 opacity-50" alt="Mastercard">
            </div>
        </div>
    </div>
</div>
@endsection