@extends('layouts.usermain')

@section('title', 'Payment - Mobile Banking')

@section('content')
<div class="container py-5" style="min-height: 70vh;">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <i class="bi bi-bank text-forest mb-4" style="font-size: 3rem;"></i>
            <h2 class="serif mb-4 text-uppercase tracking-widest">Mobile Banking</h2>
            <p class="text-muted mb-5">Please complete your transfer to secure your timepiece.</p>
            
            <div class="card border-0 shadow-sm p-4 bg-light mb-5 text-start">
                <h6 class="serif text-forest border-bottom pb-2 mb-3">Transfer Details</h6>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Account Name:</span>
                    <span class="fw-bold">TIMEPIECE LUXURY LTD</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Bank Name:</span>
                    <span class="fw-bold">GLOBAL WATCH BANK</span>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <span class="text-muted">Account Number:</span>
                    <span class="fw-bold fs-5">099-2345-123</span>
                </div>
                <div class="bg-white p-3 border text-center">
                    <small class="text-muted d-block mb-1">Total Amount Due</small>
                    <span class="h4 serif">${{ number_format($order->total_price, 2) }}</span>
                </div>
            </div>

            <div class="d-grid gap-3">
                <a href="{{ route('index') }}" wire:navigate class="btn btn-dark rounded-0 py-3 fw-bold tracking-widest">
                    I HAVE COMPLETED THE TRANSFER
                </a>
                <a href="{{ route('contact') }}" wire:navigate class="btn btn-link text-muted text-decoration-none small">
                    Need help with your payment?
                </a>
            </div>
        </div>
    </div>
</div>
@endsection