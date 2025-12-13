@extends('masterdesign')

@section('checkout')

<h3 class="fw-bold mb-5 d-flex justify-content-center">
    <i class="bi bi-credit-card-2-front-fill me-2 text-primary"></i>
    Checkout
</h3>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show fw-bold">
        {{ session('success') }}
        <button class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if($cart->isEmpty())
    <div class="text-center py-5">
        <i class="bi bi-cart-x display-1 text-muted"></i>
        <h4 class="mt-3">Your cart is empty</h4>
        <a href="{{ route('index') }}" class="btn btn-primary mt-3">Start Shopping</a>
    </div>
@else

<div class="row d-flex justify-content-evenly">

    {{-- LEFT SIDE – CUSTOMER FORM --}}
    <div class="col-lg-6 col-md-6 ">

        <div class="card shadow-sm">
            <div class="card-body">

                <h5 class="fw-bold mb-3">Customer Information</h5>

                <form action="{{ route('confirm_order') }}" method="POST">
                    @csrf

                    {{-- Email and Phone --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="tel" name="phone" class="form-control">
                        </div>
                    </div>

                    <hr>

                    {{-- Shipping Address --}}
                    <h5 class="fw-bold mb-3">Shipping Address</h5>

                    <div class="mb-3">
                        <label class="form-label">Street Address</label>
                        <input type="text" name="street" class="form-control">
                    </div>

                    <hr>

                    {{-- Payment Method --}}
                    <h5 class="fw-bold mb-3">Payment Method</h5>

                    <select name="payment_method" class="form-select mb-3">
                        <option value="" disabled selected>Select Method</option>
                        <option value="credit_card">Credit / Debit Card</option>
                        <option value="paypal">PayPal</option>
                        <option value="cod">Cash on Delivery</option>
                    </select>

                    {{-- Order Notes --}}
                    <div class="mb-3">
                        <label class="form-label">Order Notes (Optional)</label>
                        <textarea name="notes" class="form-control" rows="3"
                                placeholder="Notes about your order"></textarea>
                    </div>

                   
                    <div class="mt-4 d-flex d-flex justify-content-between">

                 <a href="{{ route('index') }}" class="btn btn-outline-secondary btn-lg">
                     <i class="bi bi-arrow-left"></i> Back
                 </a>
                  <button type="submit" class="btn btn-primary">
                        Confirm Order
                    </button>
            </div>
                </form>

            </div>
        </div>

    </div>

    {{-- RIGHT SIDE – ORDER SUMMARY --}}
    <div class="col-lg-6 col-md-6">
        <div class="card shadow-sm">
            <div class="card-body">

                <h5 class="fw-bold mb-3">Order Summary</h5>

                 <ul class="list-group mb-3">
                @php
                    $totalPrice = 0;
                @endphp

                @foreach($cart as $key => $item)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>
                            {{ $key + 1 }} . {{ $item->product->product_title }}
                            <br>
                            <small class="text-muted ms-3">Qty: {{ $item->quantity ?? 1 }}</small>
                        </span>


                        <strong class="p-2 ms-3">
                            ${{ number_format($item->product->product_price * ($item->quantity ?? 1), 2) }}
                        </strong>
                    </li>
                @endforeach
            </ul>
                <hr>

                <p class="d-flex justify-content-between fs-5 m-3">
                    <span>Total</span>
                    <strong>${{ number_format($subtotal + 5, 2) }}</strong>
                </p>

            </div>
        </div>
    </div>

</div>

@endif

@endsection
