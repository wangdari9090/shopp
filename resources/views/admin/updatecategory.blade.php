@extends('admin.layout')

@section('page-title', 'Update Product')

@section('update_product')

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Update Product</h4>
        <a href="{{ route('admin.viewproduct') }}" class="btn btn-secondary">Back</a>
    </div>

    <div class="card shadow">
        <div class="card-body">

            <form action="{{ route('admin.updateproduct.post', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Title -->
                <div class="mb-3">
                    <label class="form-label">Product Title</label>
                    <input type="text" name="product_title" class="form-control"
                           value="{{ $product->product_title }}">
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="product_description" class="form-control" rows="3">{{ $product->product_description }}</textarea>
                </div>

                <!-- Price & Quantity -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Price</label>
                        <input type="number" name="product_price" class="form-control"
                               value="{{ $product->product_price }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Quantity</label>
                        <input type="number" name="product_quantity" class="form-control"
                               value="{{ $product->product_quantity }}">
                    </div>
                </div>

                <!-- Category -->
                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <select name="product_category" class="form-control">
                        <option selected>{{ $product->product_category }}</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->category_name }}">{{ $cat->category_name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Current Image -->
                <div class="mb-3">
                    <label class="form-label">Current Image</label><br>
                    @if ($product->product_image)
                        <img src="{{ asset('storage/products/'.$product->product_image) }}"
                             width="80" height="80" class="rounded border" style="object-fit: cover;">
                    @else
                        <p class="text-muted">No image uploaded</p>
                    @endif
                </div>

                <!-- New Image -->
                <div class="mb-3">
                    <label class="form-label">Change Image (optional)</label>
                    <input type="file" name="product_image" class="form-control">
                </div>

                <!-- Submit -->
                <button type="submit" class="btn btn-primary w-100">Update Product</button>

            </form>

        </div>
    </div>
</div>

@endsection
