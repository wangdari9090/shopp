@extends('layouts.usermain')
@section('content')

<div class="container py-5">
    {{-- Success message --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i><strong>{{ session('success') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-1">
        
        <div class="col-lg-4 col-md-6">
            <div class="product-detail-img-container shadow-sm bg-white rounded-3 overflow-hidden">
                <div class="img-wrap p-4">
                    <img id="mainProductImage" 
                         src="{{ asset('storage/products/' . ($product->product_image[0] ?? 'default.jpg')) }}" 
                         class="uniform-img-carousel img-fluid" 
                         alt="{{ $product->product_title }}"
                         style="transition: opacity 0.3s ease;">
                </div>
            </div>
            @if(count($product->product_image) > 1)
            <div class="d-flex gap-2 mt-3 justify-content-center">
                @foreach($product->product_image as $index => $img)
                <div class="thumb-box border rounded p-1 {{ $index === 0 ? 'border-success' : '' }}" 
                     style="width: 75px; height: 75px; cursor: pointer; transition: all 0.2s ease;"
                     onclick="changeMainImage('{{ asset('storage/products/'.$img) }}', this)">
                     <img src="{{ asset('storage/products/'.$img) }}" class="w-100 h-100 object-fit-contain">
                </div>
                @endforeach
            </div>
            @endif
        </div>

        <div class="col-lg-6 col-md-12 d-flex align-items-center">
            <div class="ps-lg-4 w-100">
                {{-- <span class="text-success fw-bold text-uppercase small tracking-widest">{{ $product->category->name ?? 'Premium Series' }}</span> --}}
                <h1 class="fw-bold display-5 mt-2 mb-3 fs-1 text-dark">{{ $product->product_title }}</h1>

                <h2 class="text-success fw-bold mb-4">
                    ${{ number_format($product->product_price, 2) }}
                </h2>

                <div class="description-box mb-4">
                    <label class="fw-bold small text-uppercase text-muted mb-2 d-block">Description</label>
                    <p class="text-secondary leading-relaxed">
                        {{ $product->product_description }}
                    </p>
                </div>

                <div class="mb-4">
                    @if ($product->product_quantity > 0)
                        <span class="badge rounded-pill bg-success-subtle text-success border border-success px-3 py-2">
                            <i class="bi bi-check2-circle me-1"></i> In Stock
                        </span>
                    @else
                        <span class="badge rounded-pill bg-danger-subtle text-danger border border-danger px-3 py-2">
                            Out of Stock
                        </span>
                    @endif
                </div>
                <div class="d-flex align-items-center gap-2 pt-2">
    {{-- Main Form with Quantity and Add to Cart --}}
    <form action="{{ route('add_to_cart', $product->id) }}" method="POST" class="d-flex align-items-center gap-2">
        @csrf
        
        {{-- Quantity Selector --}}
        <div class="input-group input-group-sm border rounded" style="width: 110px;">
    {{-- Added id="minus-btn" --}}
    <button class="btn btn-link text-dark text-decoration-none px-2" type="button" id="minus-btn">
        <i class="bi bi-dash"></i>
    </button>
    
    <input type="number" name="quantity" id="product-qty" 
           class="form-control border-0 text-center bg-transparent p-0" 
           value="1" min="1" max="{{ $product->product_quantity }}" 
           style="box-shadow: none; font-weight: bold;">
    
    {{-- Added id="plus-btn" --}}
    <button class="btn btn-link text-dark text-decoration-none px-2" type="button" id="plus-btn">
        <i class="bi bi-plus"></i>
    </button>
</div>

        {{-- Small Add to Cart Button --}}
        <button class="btn btn-success btn-sm fw-bold shadow-sm text-uppercase tracking-wider px-3 py-2">
            <i class="bi bi-cart-plus me-1"></i> Add
        </button>
    </form>

    {{-- Back Button (Matching small size) --}}
    <a href="{{ route('index') }}" class="btn btn-outline-dark btn-sm px-3 py-2 d-flex align-items-center" title="Back to Shop">
        <i class="bi bi-arrow-left"></i>
    </a>
</div>
            </div>
        </div>
    </div>

    {{-- Bottom Section: Related --}}
    <hr class="my-5 opacity-25">
    <h4 class="fw-bold mb-5 text-center text-uppercase tracking-widest">Related Timepieces</h4>
    
    <div class="row g-4">
        @foreach($related as $item)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="product-arrival-card-carousel overflow-hidden h-100 border rounded-3 transition-all">
                    <a href="{{ route('product.details', $item->id) }}" class="text-decoration-none">
                        <div class="img-wrap p-3" style="aspect-ratio: 1/1; background: #fcfcfc;">
                            <img src="{{ asset('storage/products/' . ($item->product_image[0] ?? 'default.jpg')) }}" 
                                 class="w-100 h-100 object-fit-contain" 
                                 alt="{{ $item->product_title }}">
                        </div>
                        <div class="p-3 text-center border-top bg-white">
                            <h6 class="product-name text-dark mb-1 fw-bold">{{ Str::limit($item->product_title, 20) }}</h6>
                            <p class="text-success fw-bold mb-0">${{ number_format($item->product_price, 2) }}</p>
                        </div>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>


{{-- Scripts --}}
<script>
function changeMainImage(imagePath, element) {
    const mainImage = document.getElementById('mainProductImage');
    mainImage.style.opacity = '0';
    
    setTimeout(() => {
        mainImage.src = imagePath;
        mainImage.style.opacity = '1';
    }, 150);

    document.querySelectorAll('.thumb-box').forEach(box => {
        box.classList.remove('border-success');
    });

    element.classList.add('border-success');
}

document.addEventListener('DOMContentLoaded', function () {
    const plusBtn = document.getElementById('plus-btn');
    const minusBtn = document.getElementById('minus-btn');
    const qtyInput = document.getElementById('product-qty');

    if (plusBtn && minusBtn && qtyInput) {
        plusBtn.addEventListener('click', function (e) {
            e.preventDefault();
            let currentVal = parseInt(qtyInput.value) || 1;
            let maxVal = parseInt(qtyInput.getAttribute('max')) || 999;
            
            if (currentVal < maxVal) {
                qtyInput.value = currentVal + 1;
            }
        });

        minusBtn.addEventListener('click', function (e) {
            e.preventDefault(); // Prevents any accidental form submission
            let currentVal = parseInt(qtyInput.value) || 1;
            
            if (currentVal > 1) {
                qtyInput.value = currentVal - 1;
            }
        });
    }
});
</script>

@endsection