@extends('layouts.usermain')

@section('content')
<section class="py-5 bg-light">
    <div class="container">
        <div class="mb-5 text-center">
            {{-- This shows the name of the category you clicked --}}
            <h2 class="section-title-luxury mb-0">{{ $category->category_name }} Collection</h2>
            <p class="text-success fw-bold small text-uppercase tracking-widest">Premium Selection</p>
        </div>

       <div id="product-data-container">
    <div class="row g-4">
        @foreach($products as $product)
        <div class="col-6 col-md-4 col-lg-3">
            <div class="product-card-luxury position-relative bg-white shadow-sm border-0 h-100 transition-all" style="border-radius: 8px; overflow: hidden;">
                
                {{-- Top Badge: Minimalist Style --}}
                <div class="position-absolute top-0 start-0 p-2" style="z-index: 10;">
                    <span class="text-uppercase fw-bold tracking-widest bg-white px-2 py-1 shadow-sm" 
                          style="font-size: 0.6rem; color: #b19470; border-left: 2px solid #b19470;">
                        Top Rated
                    </span>
                </div>

                {{-- Product Visual Area --}}
                <a href="{{ route('product.details', $product->id) }}" wire:navigate class="text-decoration-none">
                    <div id="bestSellerCarousel{{ $product->id }}" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="3000">
                        <div class="carousel-inner">
                            @foreach($product->product_image as $imgIndex => $image)
                                <div class="carousel-item {{ $imgIndex === 0 ? 'active' : '' }}">
                                    <div class="img-wrap d-flex align-items-center justify-content-center" style="height: 220px; background: #fdfdfd;">
                                        <img src="{{ asset('storage/products/'.$image) }}" 
                                             class="img-fluid p-3" 
                                             style="max-height: 100%; object-fit: contain; transition: 0.5s;" 
                                             alt="{{ $product->product_title }}">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </a>

                {{-- Product Information --}}
                <div class="p-3 text-center">
                    <a href="{{ route('product.details', $product->id) }}" wire:navigate class="text-decoration-none">
                        <h6 class="serif text-dark mb-1 fw-bold text-uppercase tracking-tight" style="font-size: 0.8rem; height: 2.4em; overflow: hidden;">
                            {{ Str::limit($product->product_title, 35) }}
                        </h6>
                    </a>
                    
                    <div class="price-luxury mt-2" style="color: #b19470; font-family: 'Inter', sans-serif; font-weight: 600; font-size: 1rem;">
                        ${{ number_format($product->product_price, 2) }}
                    </div>
                    
                    <div class="mt-3">
                        <a href="{{ route('product.details', $product->id) }}" 
                           class="btn-discover-link text-uppercase text-muted text-decoration-none fw-bold" 
                           style="font-size: 0.65rem; letter-spacing: 2px; border-bottom: 1px solid #eee;">
                            View Detail
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<style>
    .product-card-luxury { transition: transform 0.3s ease, box-shadow 0.3s ease; }
    .product-card-luxury:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important; }
    .btn-discover-link:hover { color: #b19470 !important; border-bottom-color: #b19470 !important; }
    .luxury-pagination .pagination { margin-bottom: 0; }
    .luxury-pagination .page-link { border: none; color: #1a1a1a; font-size: 0.8rem; padding: 8px 16px; margin: 0 2px; }
    .luxury-pagination .page-item.active .page-link { background-color: #1a1a1a; color: #fff; border-radius: 4px; }
</style>
    </div>
</section>
@endsection