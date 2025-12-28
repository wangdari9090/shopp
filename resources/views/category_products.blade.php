@extends('layouts.usermain')

@section('content')
<section class="py-5 bg-light">
    <div class="container">
        <div class="mb-5 text-center">
            {{-- This shows the name of the category you clicked --}}
            <h2 class="section-title-luxury mb-0">{{ $category->category_name }} Collection</h2>
            <p class="text-success fw-bold small text-uppercase tracking-widest">Premium Selection</p>
        </div>

        <div class="row g-4">
            @forelse($products as $product)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="product-arrival-card-carousel shadow-sm bg-white overflow-hidden">
                        {{-- Image Logic --}}
                        @php $img = is_array($product->product_image) ? $product->product_image[0] : $product->product_image; @endphp
                        <img src="{{ asset('storage/products/'.$img) }}" class="w-100" style="height: 250px; object-fit: cover;">
                        
                        <div class="p-3 text-center">
                            <h6 class="fw-bold">{{ $product->product_title }}</h6>
                            <div class="text-success">${{ number_format($product->product_price, 2) }}</div>
                            <a href="{{ route('product.details', $product->id) }}" class="btn btn-sm btn-outline-success mt-2">View Details</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">No products found in this category yet.</p>
                    <a href="/" class="btn btn-success">Continue Shopping</a>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection