@extends('layouts.usermain')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;1,600&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">


<div class="container py-5 mt-4">
    <div class="row mb-5 align-items-end">
        <div class="col-md-8">
            <h1 class="serif display-5 fw-bold mb-0">Your Selection</h1>
            <p class="text-muted small text-uppercase tracking-widest mt-2">Personal Curated Timepieces</p>
        </div>
        <div class="col-md-4 text-md-end">
            <span class="small text-muted">{{ $count }} Items in Bag</span>
        </div>
    </div>

    @if($cart->isEmpty())
        <div class="text-center py-5 border-top border-bottom">
            <h2 class="serif py-5 italic">Your collection is empty.</h2>
            <a href="{{ route('index') }}" class="btn-confirm px-5 d-inline-block text-decoration-none">BROWSE THE COLLECTION</a>
        </div>
    @else

<div class="row g-4">
        <div class="col-lg-4">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th colspan="2">Description</th>
                        <th class="text-end">Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart as $item)
                    <tr>
                        <td style="width: 80px;">
                            <div class="watch-img-container border">
                                <img src="{{ asset('storage/products/' . (is_array($item->product->product_image) ? $item->product->product_image[0] : $item->product->product_image)) }}" 
                                    class="img-fluid" alt="Product">
                            </div>
                        </td>
                        <td class="ps-3">
                            <h6 class="serif mb-1" style="font-size: 0.9rem;">{{ $item->product->product_title }}</h6>
                            <div class="d-flex align-items-center mt-2">
                                <div class="d-flex align-items-center border px-1 py-0" style="background: #fdfdfd; scale: 0.8; transform-origin: left;">
                                    <form action="{{ route('cart.reduce', $item->id) }}" method="POST" class="m-0">
                                        @csrf
                                        <button type="submit" class="btn btn-sm p-1 text-dark border-0 shadow-none"><i class="bi bi-dash"></i></button>
                                    </form>
                                    <span class="mx-2 fw-bold small">{{ $item->quantity }}</span>
                                    <form action="{{ route('cart.increase', $item->id) }}" method="POST" class="m-0">
                                        @csrf
                                        <button type="submit" class="btn btn-sm p-1 text-dark border-0 shadow-none"><i class="bi bi-plus"></i></button>
                                    </form>
                                </div>
                                <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="ms-2">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn p-0 text-danger opacity-50"><i class="bi bi-trash3" style="font-size: 0.8rem;"></i></button>
                                </form>
                            </div>
                        </td>
                        <td class="text-end fw-light serif small">
                            ${{ number_format($item->product->product_price * ($item->quantity ?? 1), 2) }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-lg-4">
    <h6 class="serif mb-4 text-uppercase tracking-widest">Your Order Summary</h6>
    
    <div class="summary-container p-4">
        <div class="mb-4 order-items-summary px-1" style="max-height: 200px; overflow-y: auto;">
            @foreach($cart as $item)
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="pe-2">
                        <p class="mb-0 small fw-bold serif" style="font-size: 12px;">
                            {{ $item->product->product_title }}
                        </p>
                        <span class="text-muted" style="font-size: 10px; letter-spacing: 1px;">QTY: {{ $item->quantity }}</span>
                    </div>
                    <span class="small fw-bold" style="color: var(--luxury-dark);">
                        ${{ number_format($item->product->product_price * $item->quantity, 2) }}
                    </span>
                </div>
            @endforeach
        </div>

        <div class="border-top pt-3" style="border-top: 1px solid #ddd !important;">
            <div class="d-flex justify-content-between mb-2">
                <span class="small text-muted text-uppercase" style="font-size: 10px; letter-spacing: 1px;">Subtotal</span>
                <span class="small fw-bold">${{ number_format($subtotal, 2) }}</span>
            </div>
            <div class="d-flex justify-content-between mb-3">
                <span class="small text-muted text-uppercase" style="font-size: 10px; letter-spacing: 1px;">Shipping</span>
                <span class="small text-success fw-bold" style="font-size: 10px; letter-spacing: 1px;">COMPLIMENTARY</span>
            </div>
            
            <div class="d-flex justify-content-between align-items-end pt-3 border-top mb-4" style="border-top: 2px solid var(--luxury-dark) !important;">
                <h5 class="serif mb-0 text-uppercase" style="font-size: 0.9rem; letter-spacing: 1px;">Total Due</h5>
                <h4 class="serif mb-0" style="color: var(--luxury-gold); font-weight: bold;">${{ number_format($subtotal, 2) }}</h4>
            </div>

        </div>
    </div>
</div>
        <div class="col-lg-4 border-start border-end px-lg-4">
            <form action="{{ route('order.confirm') }}" id="order-form" method="POST">
    @csrf
    <h6 class="serif mb-4 text-uppercase tracking-widest">Delivery Details</h6>
    
    {{-- Contact Number --}}
    <div class="mb-4 position-relative pb-3">
        <label class="small text-muted text-uppercase fw-bold" style="font-size: 9px;">Contact Number</label>
        <input type="text" name="receiver_phone" class="form-control fancy-input shadow-none @error('receiver_phone') is-invalid @enderror" value="{{ old('receiver_phone') }}">
        @error('receiver_phone')
            <div class="invalid-feedback position-absolute start-0" style="font-size: 9px; bottom: 0;">{{ $message }}</div>
        @enderror
    </div>

    {{-- Shipping Address --}}
    <div class="mb-5 position-relative pb-3">
        <label class="small text-muted text-uppercase fw-bold" style="font-size: 9px;">Shipping Address</label>
        <textarea name="receiver_address" class="form-control fancy-input shadow-none @error('receiver_address') is-invalid @enderror" rows="3" placeholder="Full Street Address">{{ old('receiver_address') }}</textarea>
        @error('receiver_address')
            <div class="invalid-feedback position-absolute start-0" style="font-size: 9px; bottom: 0;">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="d-flex gap-2 mt-3">
    {{-- <a href="{{ route('product.details', $item->id) }}" class="btn btn-outline-dark px-3 d-flex align-items-center justify-content-center" style="width: 50px;" title="Back to Shop">
        <i class="bi bi-arrow-left"></i>
    </a> --}}

    <button type="submit" form="order-form" class="btn btn-confirm flex-grow-1 text-uppercase fw-bold">
        Confirm Order
    </button>
</div>
    </div>
</form>
        </div>

        
</div>
    @endif
</div>

<style>  
.invalid-feedback {
    display: block !important;
    height: 35px;
    line-height: 1;
    overflow: hidden;
}
    .fancy-input {
        border: none;
        border-bottom: 1px solid #e0e0e0;
        border-radius: 0;
        padding: 12px 0;
        background: transparent !important;
        transition: border-color 0.4s;
    }
    .fancy-input:focus {
        box-shadow: none;
        border-bottom-color: var(--luxury-dark);
    }
    
    .table th { font-weight: 600; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 1.5px; border: none; color: #888; }
    .table td { border-bottom: 1px solid #f0f0f0; padding: 25px 0; }
    
    .btn-confirm {
        background: var(--forest);
        color:white;
        border-radius: 5px;
        padding: 10px;
        letter-spacing: 2px;
        font-size: 0.8rem;
        transition: all 0.3s;
        border: 1px solid var(--forest);
    }
    .btn-confirm:hover {
        background: var(--forest);
        color:white;
    transform: translateY(-4px); 
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }

  .watch-img-container {
        position: relative;
        overflow: hidden;
        background: #fff;
        border-color: #f0f0f0 !important;
    }
    
</style>

@endsection