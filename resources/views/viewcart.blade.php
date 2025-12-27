@extends('layouts.usermain')

@section('content')

   <h3 class="fw-bold mb-5 d-flex justify-content-center">
    <i class="bi bi-cart-check-fill me-2 text-primary"></i>
    Your Shopping Cart
</h3>


    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fw-bold fade show">
            {{ session('success') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- If cart is empty --}}
    @if($cart->isEmpty())
        <div class="text-center py-5">
            <i class="bi bi-cart-x display-1 text-muted"></i>
            <h4 class="mt-3">Your cart is empty</h4>
            <a href="{{ route('index') }}" class="btn btn-primary mt-3">Start Shopping</a>
        </div>
    @else

   <div class="row justify-content-center g-4">

    {{-- COLUMN 1: CART ITEMS --}}
    <div class="col-md-4">
        <div class="card shadow-sm h-100">
            <div class="card-body">

                <h5 class="fw-bold mb-3">Cart Items</h5>

                @foreach($cart as $item)
                    <div class="d-flex align-items-center border-bottom py-3">

                        <img src="{{ asset('storage/products/' . $item->product->product_image) }}"
                             class="rounded"
                             style="width: 80px; height: 80px; object-fit: cover;">

                        <div class="ms-3 flex-grow-1">
                            <h6 class="fw-semibold mb-1">{{ $item->product->product_title }}</h6>
                            <p class="text-muted mb-1">${{ number_format($item->product->product_price, 2) }}</p>
                            <span class="badge bg-secondary">Qty: {{ $item->quantity ?? 1 }}</span>
                        </div>

                        <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-outline-danger btn-sm">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>

                    </div>
                @endforeach

            </div>
        </div>
    </div>

    {{-- FORM START --}}
    <form action="{{ route('order.confirm') }}" method="POST" class="col-md-8">
        @csrf

        <div class="row g-4">

            {{-- COLUMN 2: SUMMARY --}}
            <div class="col-md-6">
                <div class="card shadow-sm h-100">
                    <div class="card-body">

                        <h5 class="fw-bold">Summary</h5>
                        <hr>

                        <ul class="list-group mb-3">
                            @php $subtotal = 0; @endphp
                            @foreach($cart as $key => $item)
                                @php
                                    $price = $item->product->product_price * ($item->quantity ?? 1);
                                    $subtotal += $price;
                                @endphp
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>
                                        {{ $key + 1 }}. {{ $item->product->product_title }}
                                        <br>
                                        <small class="text-muted">Qty: {{ $item->quantity ?? 1 }}</small>
                                    </span>
                                    <strong>${{ number_format($price, 2) }}</strong>
                                </li>
                            @endforeach
                        </ul>

                        <p class="d-flex justify-content-between fw-bold">
                            <span>Subtotal</span>
                            <span>${{ number_format($subtotal, 2) }}</span>
                        </p>

                    </div>
                </div>
            </div>

            {{-- COLUMN 3: CUSTOMER INFO --}}
            <div class="col-md-6">
                <div class="card shadow-sm h-100">
                    <div class="card-body">

                        <h5 class="fw-bold mb-3">Customer Information</h5>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="receiver_phone" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <input type="text" name="receiver_address" class="form-control"required>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('product.details', $item->product->id) }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left"></i> Back
                            </a>

                            <button type="submit" class="btn btn-primary px-4">
                                Confirm Order
                            </button>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </form>
</div>


    @endif
</div>

@endsection
