@extends('masterdesign')
@section('product_details')
{{-- {{ dd($product) }} --}}

    {{-- Success message --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert"><strong>{{ session('success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="row g-5">

        <div class="col-lg-5 col-md-6 col-sm-12 text-center">
            <div class="p-3 shadow-sm rounded">
                <img src="{{ asset('storage/products/' . $product->product_image) }}"
                    class="img-fluid rounded"
                    style="max-height: 380px; object-fit: contain;">
            </div>
        </div>

        <div class="col-lg-7 col-md-6 col-sm-12">

            <h2 class="fw-bold">{{ $product->product_title }}</h2>

            {{-- Price --}}
            <h4 class="text-success fw-bold mt-3">
                ${{ number_format($product->product_price, 2) }}
            </h4>

            {{-- Short Description --}}
            <p class="mt-3">
                {{ $product->product_description }}
            </p>

            {{-- Stock --}}
            <p class="mt-2">
                @if ($product->product_quantity > 0)
                    <span class="badge bg-success">In Stock</span>
                @else
                    <span class="badge bg-danger">Out of Stock</span>
                @endif
            </p>

            {{-- Add to Cart --}}
            <div class="mt-4 d-flex gap-3">

                <form action="{{ route('add_to_cart', $product->id) }}" method="POST">
                    @csrf
                    <button class="btn btn-primary btn-lg px-4">
                        <i class="bi bi-cart-plus me-1"></i> Add to Cart
                    </button>
                </form>

                <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-lg">
                    <i class="bi bi-arrow-left"></i> Back
                </a>

            </div>

        </div>

    </div>
    <hr class="my-5">

    <h4 class="fw-bold mb-4">Related Products</h4>

    <div class="row g-4">

        @foreach($related as $item)
            <div class="col-6 col-md-4 col-lg-3">
                <a href="{{ route('product.details', $item->id) }}" class="text-decoration-none">
                    <div class="card shadow-sm product-card h-100">
                        <img src="{{ asset('storage/products/' . $item->product_image) }}"
                             class="card-img-top"
                             style="height:220px; object-fit:cover;">

                        <div class="card-body">
                            <h6 class="fw-semibold">{{ $item->product_title }}</h6>
                            <p class="text-primary fw-bold mb-0">
                                ${{ number_format($item->product_price, 2) }}
                            </p>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach

    </div>

</div>

@endsection
