<div class="row g-4">
    @foreach($products as $product)
    <div class="col-6 col-md-4 col-lg-3">
        <div class="product-arrival-card-carousel overflow-hidden">
            <a href="{{ route('product.details', $product->id) }}" class="text-decoration-none">
                <div id="bestSellerCarousel{{ $product->id }}" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="3000">
                    <div class="carousel-inner">
                        @foreach($product->product_image as $imgIndex => $image)
                            <div class="carousel-item {{ $imgIndex === 0 ? 'active' : '' }}">
                                <div class="img-wrap justify-content-center">
                                    <img src="{{ asset('storage/products/'.$image) }}" class="uniform-img-carousel" alt="{{ $product->product_title }}">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </a>
            <div class="p-3 text-center border-top bg-white">
                <a href="{{ route('product.details', $product->id) }}" class="text-decoration-none text-dark">
                    <h6 class="product-name mb-1 fw-bold">{{ Str::limit($product->product_title, 20) }}</h6>
                </a>
                <div class="product-price text-success fw-bold">${{ number_format($product->product_price, 2) }}</div>
                <div class="mt-2">
                    <span class="badge bg-light text-success border border-success-subtle rounded-pill px-3 py-1 fw-bold" style="font-size: 0.65rem;">TOP RATED</span>
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