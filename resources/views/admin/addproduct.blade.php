@extends('admin.maindesign')

@section('add_product')
<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-lg-7 col-md-9 col-sm-12">

            <div class="card border-0 shadow rounded-3 p-4">
                <h4 class="mb-3 fw-bold text-center">Add New Product</h4>

                {{-- Display errors --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Success message --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>{{ session('success') }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-3">

                        {{-- Title --}}
                        <div class="col-12">
                            <label class="form-label fw-semibold">Title</label>
                            <input type="text" name="product_title" class="form-control">
                        </div>

                        {{-- Description --}}
                        <div class="col-12">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea name="product_description" class="form-control" rows="3"></textarea>
                        </div>

                        {{-- Category --}}
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold">Category</label>
                            <select name="category_id" class="form-select" required>
                                <option value="">-- Select Category --</option>

                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">
                                        {{ $category->category }}
                                    </option>
                                @endforeach
                            </select>
                        </div>


                        {{-- Price --}}
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold">Price</label>
                            <input type="number" step="0.01" name="product_price" class="form-control">
                        </div>
                        {{-- Quantity --}}
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold">Quantity</label>
                            <input type="number" name="product_quantity" class="form-control">
                        </div>

                        {{-- Image --}}
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold">Product Image</label>
                            <input type="file" name="product_image" class="form-control" required>
                        </div>

                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <button type="submit" class="btn btn-primary px-4">Add Product</button>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary px-4">Back</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

@endsection
