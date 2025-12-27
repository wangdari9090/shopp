@extends('layouts.admin_main')
@section('page-title', 'Add New Product')

@section('content')
<div class="container-fluid py-3">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                
                <div class="card-header bg-white py-4 border-bottom-0 text-center">
                    <h4 class="fw-bold mb-0" style="color: var(--forest);">Add New Product</h4>
                    <p class="text-muted small">Fill in the details to list a new item in your inventory</p>
                </div>

                <div class="card-body p-4 pt-0">
                    {{-- Display errors --}}
                    @if ($errors->any())
                        <div class="alert alert-danger border-0 small shadow-sm alert-dismissible fade show" role="alert" id="auto-close-alert">
                            <div class="d-flex">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <div>
                                    <ul class="mb-0 list-unstyled">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close" style="font-size: 0.6rem;"></button>
                        </div>
                    @endif

                    {{-- Success message --}}
                     @if (session('success'))
                        <div class="alert alert-success border-0 small shadow-sm alert-dismissible fade show" role="alert" id="auto-close-alert">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close" style="font-size: 0.6rem;"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-4">
                            {{-- Title --}}
                            <div class="col-12">
                                <label class="form-label fw-bold" style="color: var(--forest);">Product Title</label>
                                <input type="text" name="product_title" class="form-control" 
                                       placeholder="e.g. Premium Silk Scarf" value="{{ old('product_title') }}" required>
                            </div>

                            {{-- Description --}}
                            <div class="col-12">
                                <label class="form-label fw-bold" style="color: var(--forest);">Product Description</label>
                                <textarea name="product_description" class="form-control" rows="4" 
                                          placeholder="Describe the product features...">{{ old('product_description') }}</textarea>
                            </div>

                            {{-- Category --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold" style="color: var(--forest);">Category</label>
                                <select name="category_id" class="form-select" required>
                                    <option value="" disabled selected>-- Select Category --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->category }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Price --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold" style="color: var(--forest);">Price ($)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">$</span>
                                    <input type="number" step="0.01" name="product_price" class="form-control border-start-0" 
                                           placeholder="0.00" required>
                                </div>
                            </div>

                            {{-- Quantity --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold" style="color: var(--forest);">Stock Quantity</label>
                                <input type="number" name="product_quantity" class="form-control" placeholder="0" required>
                            </div>

                            {{-- Multiple Images --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold" style="color: var(--forest);">Product Gallery (Multiple)</label>
                                <input type="file" name="product_image[]" id="imageInput" class="form-control" multiple required>
                                <small class="text-muted d-block mt-1">
                                    <i class="bi bi-info-circle me-1"></i> Ctrl+Click to select multiple photos.
                                </small>
                            </div>

                            {{-- Preview Container --}}
                            <div class="col-12">
                                <div id="imagePreview" class="d-flex flex-wrap gap-3 mt-2 p-3 bg-light rounded border border-dashed">
                                    <div class="text-center w-100 py-3 text-muted" id="previewPlaceholder">
                                        <i class="bi bi-images fs-2 d-block"></i>
                                        <span class="small">Image previews will appear here</span>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-5 pt-3 border-top">
                            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary px-4">
                                <i class="bi bi-arrow-left me-1"></i> Back to List
                            </a>
                            <button type="submit" class="btn btn-gold px-5 fw-bold">
                                <i class="bi bi-cloud-arrow-up me-1"></i> Save Product
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('imageInput').addEventListener('change', function(event) {
    const previewContainer = document.getElementById('imagePreview');
    const placeholder = document.getElementById('previewPlaceholder');
    
    previewContainer.innerHTML = ''; 

    const files = event.target.files;
    if (files.length > 0) {
        [...files].forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = (e) => {
                const imgWrapper = document.createElement('div');
                imgWrapper.classList.add('position-relative');
                imgWrapper.innerHTML = `
                    <img src="${e.target.result}" class="rounded shadow-sm border p-1 bg-white" 
                         style="width: 110px; height: 110px; object-fit: cover;">
                    <span class="badge bg-gold position-absolute top-0 start-0 m-1 shadow-sm" 
                          style="color: var(--forest); border: 1px solid var(--forest);">#${index + 1}</span>
                `;
                previewContainer.appendChild(imgWrapper);
            };
            reader.readAsDataURL(file);
        });
    } else {
        previewContainer.appendChild(placeholder);
    }
});
</script>

<style>
    .bg-gold { background-color: var(--gold) !important; }
    .border-dashed { border-style: dashed !important; }
</style>
@endsection