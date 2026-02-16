@extends('layouts.usermain')

@section('content')
<div class="container py-5 text-center" style="min-height: 70vh;">
    <div class="mb-4">
        <i class="bi bi-check2-circle text-success" style="font-size: 4rem;"></i>
    </div>
    
    <h2 class="serif text-uppercase tracking-widest mb-3">Order Received</h2>
    <p class="text-muted mb-5">Voucher Number: #{{ $order->user_order_number }}</p>

    <div class="row justify-content-center mb-5">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm p-4 bg-light">
                @if($method === 'online_banking')
                    <h6 class="serif text-uppercase mb-3">Transfer Instructions</h6>
                    <p class="small">Please transfer <strong>${{ number_format($order->total_price, 2) }}</strong> to:</p>
                    <p class="mb-1"><strong>Bank:</strong> Global Watch Bank</p>
                    <p class="mb-0"><strong>Account:</strong> 099-2345-123</p>
                @elseif($method === 'card')
                    <h6 class="serif text-uppercase mb-3">Payment Processing</h6>
                    <p class="small">Your card payment for <strong>${{ number_format($order->total_price, 2) }}</strong> is being verified. You will receive an email once confirmed.</p>
                @else
                    <h6 class="serif text-uppercase mb-3">Cash on Delivery</h6>
                    <p class="small">Please have <strong>${{ number_format($order->total_price, 2) }}</strong> ready upon delivery.</p>
                @endif
            </div>
        </div>
    </div>

    <a href="{{ url('/') }}" wire:navigate class="btn btn-outline-dark rounded-0 px-5 py-3 fw-bold small">
        RETURN TO GALLERY
    </a>
</div>
@endsection