@extends('masterdesign')

@section('view_cart')

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

    <div class="row d-flex justify-content-center">
        <div class="col-lg-4 col-md-6 mb-4">

            <div class="card shadow-sm mb-4">
                <div class="card-body">

                    @foreach($cart as $item)
                    <div class="d-flex align-items-center border-bottom py-3">

                        {{-- Product Image --}}
                        <img src="{{ asset('storage/products/' . $item->product->product_image) }}"
                             class="rounded"
                             style="width: 90px; height: 90px; object-fit: cover;">

                        {{-- Product Info --}}
                        <div class="ms-3 flex-grow-1">

                            <h5 class="fw-semibold mb-1">{{ $item->product->product_title }}</h5>
                            <p class="text-muted mb-1">${{ number_format($item->product->product_price, 2) }}</p>

                            {{-- Quantity --}}
                            <p class="badge bg-secondary">Qty: {{ $item->quantity ?? 1 }}</p>
                        </div>

                        {{-- Remove Button --}}
                        <form action="{{ route('removecartproduct', $item->id) }}" method="POST">
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

        {{-- Summary Sidebar --}}
        <div class="col-lg-4 col-md-6">
    <div class="card shadow-sm">
        <div class="card-body">

            <h4 class="fw-bold">Summary</h4>
            <hr>

            {{-- List of Items --}}
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
            @php
                $subtotal = 0;
                foreach($cart as $item){
                    $subtotal += $item->product->product_price * ($item->quantity ?? 1);
                }
            @endphp
            {{-- Total --}}
            <p class="d-flex justify-content-between">
                <span>Sub Total:</span>
                <strong>${{ number_format($subtotal, 2) }}</strong>
            </p>
             <div class="mt-4 d-flex d-flex justify-content-between">

                 <a href="{{ route('index') }}" class="btn btn-outline-secondary btn-lg">
                     <i class="bi bi-arrow-left"></i> Back
                 </a>
                <a href="{{ route('confirm_order') }}" class="btn btn-primary btn-lg px-4">
                    Confirm Order
                </a>

            </div>
    </div>
</div>

    </div>

    @endif
</div>

@endsection
