@extends('layouts.usermain')

@section('hero')
<section class="hero-fancy position-relative py-3 overflow-hidden" style="background: #ffffff;">
    <div class="container position-relative py-4" style="z-index: 1;">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span style="width: 40px; height: 2px; background: #198754;"></span>
                    <span class="text-success fw-bold text-uppercase small tracking-widest">Premium Collection</span>
                </div>
                <h1 class="hero-title mb-4">
                    The Art of <br>
                    <span class="text-italic-green">Timekeeping.</span>
                </h1>

                <p class="hero-paragraph mb-5 pe-lg-5">
                    Elevate your presence with timepieces that blend heritage 
                    craftsmanship with modern forest-green aesthetics.
                </p>

                <div class="d-flex gap-3">
                    <a href="#best-seller-section" class="btn shop-now-btn px-5 shadow-lg">
                        Shop Now
                    </a>
                </div>
            </div>

           <div class="col-lg-6">
            <div class="hero-grid" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px;">
            @foreach($popularProducts->take(4) as $product)
            <div class="hero-item-luxury">
                {{-- Product Image Container --}}
                <div class="product-img-box">
                    @php
                        $images = json_decode($product->product_image, true);
                        $firstImage = $images[0] ?? 'default.jpg';
                    @endphp
                    
                    {{-- Floating Badge --}}
                    <span class="product-badge">Popular</span>

                    <img src="{{ asset('storage/products/' . $firstImage) }}" 
                        class="product-img-zoom" 
                        alt="{{ $product->product_title }}">
                    
                    {{-- Hover Action --}}
                    <div class="product-action-overlay">
                        <a href="{{ route('product.details', $product->id) }}" class="btn-discover">
                            View Piece
                        </a>
                    </div>
                </div>

        {{-- Product Info --}}
        <div class="product-details-minimal">
            <p class="text-muted small mb-1 text-uppercase tracking-wider" style="font-size: 0.65rem;">Timeless Series</p>
            <h6 class="product-title-luxury">{{ $product->product_title }}</h6>
            <div class="d-flex justify-content-between align-items-center mt-2">
                <span class="product-price-luxury">${{ number_format($product->product_price, 2) }}</span>
                <i class="bi bi-arrow-right text-success small"></i>
            </div>
        </div>
    </div>
    @endforeach
</div>
</div>
        </div>
    </div>
</section>
@endsection

@section('content')

{{-- CATEGORY SECTION --}}
<section id="categories" class="py-5 category-mist-theme">
    <div class="container">
        <div class="text-center mb-4">
            <span class="section-subtitle">Browse by Category</span>
        </div>
        
        <div class="row g-3">
            @php
                $categories = [
                    1 => ['icon' => 'bi-smartwatch', 'name' => 'Smart'],
                    2 => ['icon' => 'bi-watch', 'name' => 'Luxury'],
                    3 => ['icon' => 'bi-clock-history', 'name' => 'Auto'],
                    4 => ['icon' => 'bi-stopwatch', 'name' => 'Chrono'],
                    5 => ['icon' => 'bi-droplet', 'name' => 'Diver'],
                    6 => ['icon' => 'bi-compass', 'name' => 'Field']
                ];
            @endphp
            @foreach($categories as $id => $cat)
            <div class="col-4 col-md-2">
                <a href="{{ route('category.products', $id) }}" class="text-decoration-none">
                    <div class="minimal-cat-box">
                        <div class="cat-icon-inner">
                            <i class="bi {{ $cat['icon'] }}"></i>
                        </div>
                        <span class="cat-label">{{ $cat['name'] }}</span>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container" id="best-seller-section"> 
        <div class="mb-5 text-center">
            <h2 class="section-title-luxury mb-0">Best Sellers</h2>
            <p class="text-success fw-bold small text-uppercase tracking-widest">Most Wanted Timepieces</p>
        </div>

        <div id="product-data-container">
        <div class="row g-4">
           @foreach($products as $product)
<div class="col-6 col-md-4 col-lg-3">
    <div class="product-arrival-card-carousel overflow-hidden">
        
        {{-- Wrap the image/carousel area in the route link --}}
        <a href="{{ route('product.details', $product->id) }}" class="text-decoration-none">
            <div id="bestSellerCarousel{{ $product->id }}" 
                 class="carousel slide carousel-fade" 
                 data-bs-ride="carousel" 
                 data-bs-interval="3000">

                <div class="carousel-inner">
                    @foreach($product->product_image as $imgIndex => $image)
                        <div class="carousel-item {{ $imgIndex === 0 ? 'active' : '' }}">
                            <div class="img-wrap justify-content-center">
                                <img src="{{ asset('storage/products/'.$image) }}" 
                                     class="uniform-img-carousel" 
                                     alt="{{ $product->product_title }}">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </a>

        <div class="p-3 text-center border-top bg-white">
            {{-- Also wrap the title so users can click that too --}}
            <a href="{{ route('product.details', $product->id) }}" class="text-decoration-none text-dark">
                <h6 class="product-name mb-1 fw-bold">
                    {{ Str::limit($product->product_title, 20) }}
                </h6>
            </a>
            
            <div class="product-price text-success fw-bold">
                ${{ number_format($product->product_price, 2) }}
            </div>
            
            <div class="mt-2">
                <span class="badge bg-light text-success border border-success-subtle rounded-pill px-3 py-1 fw-bold" style="font-size: 0.65rem;">
                    TOP RATED
                </span>
            </div>
        </div>
    </div>
</div>
@endforeach
        </div>
        <div class="d-flex justify-content-between align-items-center p-4 border-top mt-4">
                <div class="small text-muted">
                    Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} products
                </div>
                <div class="luxury-pagination mt-4">
                    {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</section>

{{-- New Arrivals --}}
<section id="new-arrivals" class="py-5 bg-white">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-5">
            <div>
                <h2 class="section-title-luxury mb-0">The Latest Movements</h2>
                <p class="text-gold fw-bold small text-uppercase tracking-widest mb-0">New Arrivals</p>
            </div>
            <a href="/shop" class="btn-link-gold text-decoration-none fw-bold small">VIEW ALL <i class="bi bi-arrow-right"></i></a>
        </div>

        <div class="row g-4">
            @foreach($newArrivals ?? [] as $product)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="product-arrival-card">
                    <span class="badge-new">New</span>

                    <div class="img-wrap">
                        {{-- Fix: Added [0] --}}
                        <img src="{{ asset('storage/products/'.($product->product_image[0] ?? 'default.jpg')) }}" 
                             class="uniform-img img-front" alt="Front">
                        
                        {{-- Fix: Check if 2nd image exists in array --}}
                        @if(isset($product->product_image[1]))
                        <img src="{{ asset('storage/products/'.$product->product_image[1]) }}" 
                             class="uniform-img img-back" alt="Back">
                        @endif

                        <div class="arrival-overlay">
                            <form action="" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $product->id }}">
                                <button type="submit" class="btn-quick-add">
                                    <i class="bi bi-bag-plus"></i>
                                </button>
                            </form>
                            <a href="{{ route('product.details', $product->id) }}" class="btn-view-circle">
                                <i class="bi bi-eye"></i>
                            </a>
                        </div>
                    </div>

                    <div class="pt-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="product-name mb-1">{{ Str::limit($product->product_title, 22) }}</h6>
                                <p class="text-muted small mb-0">{{ $product->category->name ?? 'Collection' }}</p>
                            </div>
                            <div class="product-price">${{ number_format($product->product_price, 2) }}</div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    
</section>

<script>
$(document).ready(function() {
    
    function initializeCarousels() {
        const carousels = document.querySelectorAll('.carousel');
        
        carousels.forEach(carouselEl => {
            const existingInstance = bootstrap.Carousel.getInstance(carouselEl);
            if (existingInstance) {
                existingInstance.dispose();
            }

            const newCarousel = new bootstrap.Carousel(carouselEl, {
                interval: 3000,
                ride: 'carousel',
                pause: 'hover'
            });
            
            newCarousel.cycle(); 
        });
    }

    initializeCarousels();

    $(document).on('click', '.luxury-pagination a', function(event) {
        event.preventDefault();
        
        let url = $(this).attr('href');

        $.ajax({
            url: url,
            type: "GET",
            beforeSend: function() {
                $('#product-data-container').animate({ opacity: 0.4 }, 200);
            },
            success: function(data) {
                $('#product-data-container').html(data).animate({ opacity: 1 }, 200);

                if ($("#best-seller-section").length) {
                    $('html, body').animate({
                        scrollTop: $("#best-seller-section").offset().top - 70
                    }, 100);
                }

                setTimeout(function() {
                    initializeCarousels();
                }, 150); 
            },
            error: function() {
                $('#product-data-container').css('opacity', '1');
                alert('Products could not be loaded.');
            }
        });
    });
});
</script>
@endsection

{{-- document.addEventListener('DOMContentLoaded', function() {
        var myCarousel = document.querySelector('#arrivalCarousel');
        if (myCarousel) {
            new bootstrap.Carousel(myCarousel, {
                interval: 3000,
                ride: 'carousel',
                pause: 'hover'
            });
        }
    }); --}}