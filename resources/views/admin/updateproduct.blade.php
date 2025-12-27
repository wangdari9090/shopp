@extends('layouts.admin_main')
@section('page-title', 'Edit Product')

@section('content')
<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                
                <div class="card-header bg-white py-3 border-bottom-0 text-center">
                    <h4 class="fw-bold mb-0" style="color: var(--forest);">Edit Product Details</h4>
                    <p class="text-muted small">Update information for "{{ $product->product_title }}"</p>
                </div>

                <div class="card-body p-4">
                    {{-- Success message --}}
                    @if (session('success'))
                        <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <strong>{{ session('success') }}</strong>
                            <button class="btn-close shadow-none" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.products.update', $product->id) }}"
                          method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-4">
                            {{-- Title --}}
                            <div class="col-12">
                                <label class="form-label fw-bold" style="color: var(--forest);">Product Title</label>
                                <input type="text" name="product_title" 
                                       class="form-control @error('product_title') is-invalid @enderror"
                                       value="{{ old('product_title', $product->product_title) }}">
                                @error('product_title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Description --}}
                            <div class="col-12">
                                <label class="form-label fw-bold" style="color: var(--forest);">Description</label>
                                {{-- Note: Textarea content must be on one line to avoid extra spaces --}}
                                <textarea name="product_description" rows="4" class="form-control">{{ old('product_description', $product->product_description) }}</textarea>
                            </div>

                            {{-- Price & Quantity --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold" style="color: var(--forest);">Price ($)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">$</span>
                                    <input type="number" step="0.01" name="product_price" 
                                           class="form-control border-start-0"
                                           value="{{ old('product_price', $product->product_price) }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold" style="color: var(--forest);">Stock Quantity</label>
                                <input type="number" name="product_quantity" class="form-control"
                                       value="{{ old('product_quantity', $product->product_quantity) }}">
                            </div>

                            <hr class="my-4 text-muted opacity-25">

                            {{-- Current vs New Image --}}
                            <div class="col-md-4 text-center border-end d-none d-md-block">
                                <label class="form-label d-block fw-bold mb-3" style="color: var(--forest);">Current Image</label>
                                @if($product->product_image)
                                    <img src="{{ asset('storage/products/' . $product->product_image) }}"
                                         class="rounded shadow-sm border p-1"
                                         style="width:120px; height:120px; object-fit:cover;">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center mx-auto" style="width:120px; height:120px;">
                                        <i class="bi bi-image text-muted fs-2"></i>
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-8">
                                <label class="form-label fw-bold" style="color: var(--forest);">Replace Product Image</label>
                                <input type="file" name="product_image" class="form-control mb-2" id="imageInput">
                                <small class="text-muted"><i class="bi bi-info-circle me-1"></i> Leave empty to keep the current image. Max size: 2MB.</small>
                                
                                {{-- JS Preview Container --}}
                                <div id="previewContainer" class="mt-3 d-none">
                                    <p class="small fw-bold text-success mb-2">New image preview:</p>
                                    <img id="imagePreview" src="#" class="rounded shadow-sm border p-1" style="width:100px; height:100px; object-fit:cover;">
                                </div>
                            </div>
                        </div>

                        {{-- Footer Buttons --}}
                        <div class="d-flex justify-content-between align-items-center mt-5 pt-3 border-top">
                            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary px-4">
                                <i class="bi bi-arrow-left me-1"></i> Back
                            </a>
                            <button type="submit" class="btn btn-gold px-5 fw-bold">
                                <i class="bi bi-save me-1"></i> Update Product
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('imageInput').onchange = evt => {
        const [file] = document.getElementById('imageInput').files
        if (file) {
            document.getElementById('previewContainer').classList.remove('d-none');
            document.getElementById('imagePreview').src = URL.createObjectURL(file)
        }
    }
</script>
@endsection