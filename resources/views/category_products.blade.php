@extends('layouts.usermain')

@section('content')
<div class="container my-5">
    <h2 class="fw-bold mb-4 text-center">{{ $category->category }}</h2>

    <div class="row g-4">
        @forelse($products as $product)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="product-card">
                    <a href="{{ route('product.details', $product->id) }}">
                        <img src="{{ asset('storage/products/'.$product->product_image) }}" class="product-img w-100" alt="{{ $product->product_title }}">
                    </a>
                    <div class="p-3">
                        <h6 class="fw-semibold">{{ $product->product_title }}</h6>
                        <p class="text-primary fw-bold">${{ $product->product_price }}</p>
                        <a href="{{ route('product.details', $product->id) }}" class="btn btn-outline-dark w-100 rounded-pill">View Details</a>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center">No products found in this category.</p>
        @endforelse
    </div>
</div>
@endsection
