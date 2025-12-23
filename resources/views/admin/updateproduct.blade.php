@extends('admin.maindesign')

@section('update_product')
<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-lg-7 col-md-9 col-sm-12">

            <div class="card border-0 shadow rounded-3 p-4">

                <h4 class="mb-3 fw-bold text-center">Update Product</h4>

                {{-- Success message --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <strong>{{ session('success') }}</strong>
                        <button class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- Validation errors --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.products.update', $product->id) }}"
                      method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-3">

                        {{-- Title --}}
                        <div class="col-12">
                            <label class="form-label fw-semibold">Title</label>
                            <input type="text" name="product_title" class="form-control"
                                value="{{ old('product_title', $product->product_title) }}">
                        </div>

                        {{-- Description --}}
                        <div class="col-12">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea name="product_description" rows="3" class="form-control">
                                {{ old('product_description', $product->product_description) }}
                            </textarea>
                        </div>

                        {{-- Price --}}
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold">Price</label>
                            <input type="number" step="0.01" name="product_price" class="form-control"
                                value="{{ old('product_price', $product->product_price) }}">
                        </div>

                        {{-- Quantity --}}
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold">Quantity</label>
                            <input type="number" name="product_quantity" class="form-control"
                                value="{{ old('product_quantity', $product->product_quantity) }}">
                        </div>

                        {{-- Current Image --}}
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold">Current Image</label><br>

                            @if($product->product_image)
                                <img src="{{ asset('storage/products/' . $product->product_image) }}"
                                     class="rounded shadow"
                                     style="width:80px;height:80px;object-fit:cover;">
                            @else
                                <p class="text-muted">No Image</p>
                            @endif
                        </div>

                        {{-- New Image --}}
                        <div class="col-12">
                            <label class="form-label fw-semibold">Replace Image</label>
                            <input type="file" name="product_image" class="form-control">
                        </div>

                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <button type="submit" class="btn btn-primary px-4">Update Product</button>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary px-4">Back</a>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
@endsection
