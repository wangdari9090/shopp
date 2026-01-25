<div class="row g-4">
    @foreach($products as $product)
    <div class="col-6 col-md-4 col-lg-3">
        <div class="product-arrival-card-carousel border rounded">
            <a href="{{ route('product.details', $product->id) }}" class="text-decoration-none">
                <div class="img-wrap p-3">
                    <img src="{{ asset('storage/products/' . ($product->product_image[0] ?? 'default.jpg')) }}" 
                         class="w-100 h-100 object-fit-contain">
                </div>
                <div class="p-3 text-center border-top bg-white">
                    <h6 class="product-name text-dark mb-1 fw-bold">{{ Str::limit($product->product_title, 20) }}</h6>
                    <p class="text-success fw-bold mb-0">${{ number_format($product->product_price, 2) }}</p>
                </div>
            </a>
        </div>
    </div>
    @endforeach
</div>

<div class="luxury-pagination mt-4">
    {{ $products->links('pagination::bootstrap-5') }}
</div>