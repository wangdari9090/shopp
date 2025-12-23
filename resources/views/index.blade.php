@extends('masterdesign')

@section('hero')
<section class="hero-section position-relative d-flex align-items-center justify-content-center text-center"
    style="height: 90vh; background: url('https://i.pinimg.com/736x/10/0a/f4/100af42bfdb0c1c4700f35b674abbf13.jpg') center/cover no-repeat;">

    <!-- Dark Gradient Overlay -->
    <div class="position-absolute top-0 start-0 w-100 h-100"
         style="background: linear-gradient(to bottom, rgba(0,0,0,0.6), rgba(0,0,0,0.4));">
    </div>

    <!-- Content -->
    <div class="content text-white position-relative glass-card p-4 px-md-5">
        <h1 class="display-3 fw-bold mb-3">Discover Premium Collections</h1>
        <p class="lead mb-4">Where fashion meets technology — shop the latest releases</p>

        <a href="#categories" class="btn btn-primary btn-lg rounded-pill px-5 shadow">
            Shop Now
        </a>
    </div>
</section>
@endsection

@section('index')

    <!-- Featured Products Section -->
<section class="container my-5">
    <h2 class="fw-bold text-center mb-4">Featured Products</h2>

    <div class="row g-4">

        @foreach($products ?? [] as $product)
        <div class="col-6 col-md-4 col-lg-3">
            <div class="product-card">
                <a href="{{ route('product.details', $product->id) }}">
                    <img src="{{ asset('storage/products/'.$product->product_image) }}" class="product-img w-100" alt="Product">
                </a>

                <div class="p-3">
                    <h6 class="fw-semibold">{{ $product->product_title }}</h6>
                    <p class="text-primary fw-bold">${{ $product->product_price }}</p>

                    <a href="{{ route('product.details', $product->id) }}" class="btn btn-outline-dark w-100 rounded-pill">View Details</a>
                </div>
            </div>
        </div>
        @endforeach

    </div>
</section>
<!-- Categories -->
<section id="categories" class="categories-section container my-5">
    <h2 class="fw-bold text-center mb-4">Shop by Watch Category</h2>

    <div class="row g-4 justify-content-center">

        <div class="col-6 col-md-4 col-lg-3">
            <a href="{{ route('category.products', 1) }}" class="text-decoration-none text-dark">
                <div class="category-box text-center">
                    <i class="bi bi-smartwatch fs-1"></i>
                    <h5 class="fw-semibold mt-2">Smartwatches</h5>
                </div>
            </a>
        </div>

        <div class="col-6 col-md-4 col-lg-3">
            <a href="{{ route('category.products', 2) }}" class="text-decoration-none text-dark">
                <div class="category-box text-center">
                    <i class="bi bi-watch fs-1"></i>
                    <h5 class="fw-semibold mt-2">Luxury Watches</h5>
                </div>
            </a>
        </div>

        <div class="col-6 col-md-4 col-lg-3">
            <a href="{{ route('category.products', 3) }}" class="text-decoration-none text-dark">
                <div class="category-box text-center">
                    <i class="bi bi-clock-history fs-1"></i>
                    <h5 class="fw-semibold mt-2">Automatic Watches</h5>
                </div>
            </a>
        </div>

        <div class="col-6 col-md-4 col-lg-3">
            <a href="{{ route('category.products', 4) }}" class="text-decoration-none text-dark">
                <div class="category-box text-center">
                    <i class="bi bi-stopwatch fs-1"></i>
                    <h5 class="fw-semibold mt-2">Chronograph Watches</h5>
                </div>
            </a>
        </div>

        <div class="col-6 col-md-4 col-lg-3">
            <a href="{{ route('category.products', 5) }}" class="text-decoration-none text-dark">
                <div class="category-box text-center">
                    <i class="bi bi-droplet fs-1"></i>
                    <h5 class="fw-semibold mt-2">Diver Watches</h5>
                </div>
            </a>
        </div>

        <div class="col-6 col-md-4 col-lg-3">
            <a href="{{ route('category.products', 6) }}" class="text-decoration-none text-dark">
                <div class="category-box text-center">
                    <i class="bi bi-compass fs-1"></i>
                    <h5 class="fw-semibold mt-2">Field Watches</h5>
                </div>
            </a>
        </div>

    </div>
</section>

<!-- Top Collections -->
<section class="container my-5">
    <h2 class="fw-bold text-center mb-4">Top Collections</h2>

<div class="row g-4 mb-">

    @foreach($collections ?? [] as $product)
   <div class="col-12 col-md-6 col-lg-4">

    <a href="{{ route('product.details', $product->id) }}" class="text-decoration-none">

        <div class="collection-card position-relative rounded-4 overflow-hidden shadow-sm">

            <img src="{{ asset('storage/products/'.$product->product_image) }}"
                 class="w-100"
                 style="height: 300px; object-fit: cover;">

            <div class="position-absolute top-0 start-0 w-100 h-100"
                 style="background: linear-gradient(to bottom, rgba(0,0,0,0.1), rgba(0,0,0,0.7));">
            </div>

            <div class="position-absolute bottom-0 start-0 p-4 text-white">

                <h3 class="fw-bold mb-1">{{ $product->product_title }}</h3>

                <span class="btn btn-light rounded-pill px-4 mt-2">
                    View Details
                </span>

            </div>

        </div>

    </a>

</div>

    @endforeach

</div>

</section>

@endsection
