@extends('layouts.usermain')

@section('content')
<div class="container py-5 mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 text-center">
            {{-- Header --}}
            <h1 class="serif display-6 fw-bold mb-2">Order Received</h1>
            <p class="text-muted small text-uppercase tracking-widest mb-4">Voucher: #{{ $order->user_order_number }}</p>

            <div class="card border-0 shadow-sm p-4 mb-4 bg-white instruction-card">
                <div class="card-body">
                    @if($method === 'online_banking' || $method === 'card')
                        <h6 class="serif text-uppercase tracking-widest mb-3" style="color: #b19470;">Finalize Your Payment</h6>
                        <p class="text-muted small">Please transfer <strong>${{ number_format($order->total_price, 2) }}</strong> to our account and upload the receipt below.</p>
                        
                        <div class="bg-light p-3 mb-4 text-start small border">
                            <strong>Bank:</strong> Global Watch Bank<br>
                            <strong>Account:</strong> 099-2345-123<br>
                            <strong>Name:</strong> Global Watch Co., Ltd.
                        </div>

                        {{-- Screenshot Upload Form --}}
                        <form action="{{ route('payment.upload', $order->id) }}" method="POST" enctype="multipart/form-data" class="mt-4">
                            @csrf
                            <div class="mb-3">
                                <label class="small text-muted d-block mb-2 text-start fw-bold">UPLOAD RECEIPT / SCREENSHOT</label>
                                <input type="file" name="payment_proof" class="form-control form-control-sm rounded-0" required>
                            </div>
                            <button type="submit" class="btn btn-confirm w-100 py-2">SUBMIT PROOF</button>
                        </form>

                    @else
                        {{-- COD Case --}}
                        <h6 class="serif text-uppercase tracking-widest mb-3" style="color: #b19470;">Cash on Delivery</h6>
                        <p class="text-muted small">Your order is confirmed. Please prepare <strong>${{ number_format($order->total_price, 2) }}</strong> for the courier.</p>
                        <a href="{{ url('/') }}" class="btn-return px-5 py-3 text-decoration-none d-inline-block mt-3">RETURN TO GALLERY</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .instruction-card { border-radius: 0; border: 1px solid #f0f0f0 !important; position: relative; }
    .instruction-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; background: #b19470; }
    .btn-confirm { background: #1a1a1a; color: white; border-radius: 0; font-size: 0.8rem; letter-spacing: 1px; }
    .btn-return { background: #1a1a1a; color: white; font-size: 0.75rem; letter-spacing: 2px; border: 1px solid #1a1a1a; }
</style>
@endsection