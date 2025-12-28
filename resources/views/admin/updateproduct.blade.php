@extends('layouts.admin_main')
@section('page-title', 'Edit Product: ' . $product->product_title)

@section('content')
<div class="container-fluid py-3">
    <div class="row justify-content-center">
        <div class="col-lg-10"> {{-- Wider layout to accommodate side-by-side preview --}}
            <div class="card border-0 shadow-sm">
                
                <div class="card-header bg-white py-4 border-bottom-0 text-center">
                    <h4 class="fw-bold mb-0" style="color: var(--forest);">Edit Product</h4>
                    <p class="text-muted small">Update the information for <strong>{{ $product->product_title }}</strong></p>
                </div>

                <div class="card-body p-4 pt-0">
                    {{-- Alert Messages --}}
                    @if ($errors->any())
                        <div class="alert alert-danger border-0 small shadow-sm alert-dismissible fade show" role="alert">
                            <ul class="mb-0 list-unstyled">
                                @foreach ($errors->all() as $error)
                                    <li><i class="bi bi-exclamation-circle me-2"></i>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success border-0 small shadow-sm alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') {{-- Required for Update --}}

                        <div class="row g-4">
                            {{-- Left Side: Details --}}
                            <div class="col-lg-7">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label fw-bold" style="color: var(--forest);">Product Title</label>
                                        <input type="text" name="product_title" class="form-control" 
                                               value="{{ old('product_title', $product->product_title) }}" required>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label fw-bold" style="color: var(--forest);">Product Description</label>
                                        <textarea name="product_description" class="form-control" rows="5">{{ old('product_description', $product->product_description) }}</textarea>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold" style="color: var(--forest);">Category</label>
                                        <select name="category_id" class="form-select" required>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                                    {{ $category->category }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label fw-bold" style="color: var(--forest);">Price ($)</label>
                                        <input type="number" step="0.01" name="product_price" class="form-control" 
                                               value="{{ old('product_price', $product->product_price) }}" required>
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label fw-bold" style="color: var(--forest);">Stock</label>
                                        <input type="number" name="product_quantity" class="form-control" 
                                               value="{{ old('product_quantity', $product->product_quantity) }}" required>
                                    </div>
                                </div>
                            </div>

                            {{-- Right Side: Image Management --}}
                           {{-- Right Side: Image Management --}}
<div class="col-lg-5">
    <div class="p-4 bg-white rounded border shadow-sm">
        <label class="form-label fw-bold d-block mb-3" style="color: var(--forest);">
            <i class="bi bi-images me-2"></i>Gallery Management
        </label>

        {{-- Existing Images with Delete Option --}}
        <div class="mb-4">
            <span class="small fw-bold text-muted text-uppercase d-block mb-3">Current Gallery</span>
            <div class="d-flex flex-wrap gap-3">
                @if($product->product_image && count($product->product_image) > 0)
                    @foreach($product->product_image as $img)
                        <div class="position-relative gallery-item">
                            <img src="{{ asset('storage/products/'.$img) }}" 
                                 class="rounded border shadow-sm" 
                                 style="width: 85px; height: 85px; object-fit: cover;">
                            
                            {{-- Checkbox hidden, toggled by the X button --}}
                            <input type="checkbox" name="remove_images[]" value="{{ $img }}" id="del-{{ $loop->index }}" class="d-none">
                            
                            <button type="button" 
                                    onclick="markForDeletion(this, 'del-{{ $loop->index }}')"
                                    class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 p-0 d-flex align-items-center justify-content-center shadow"
                                    style="width: 22px; height: 22px; border-radius: 50%; border: 2px solid white;">
                                <i class="bi bi-x" style="font-size: 1.2rem;"></i>
                            </button>
                        </div>
                    @endforeach
                @else
                    <div class="text-center w-100 py-3 border rounded bg-light">
                        <p class="text-muted small mb-0">No images in gallery</p>
                    </div>
                @endif
            </div>
        </div>

        <hr class="my-4">

        {{-- Add New Images --}}
        <div class="mb-3">
            <label class="small fw-bold text-muted text-uppercase d-block mb-2">Add New Photos</label>
            <div class="input-group">
                <input type="file" name="product_image[]" id="imageInput" class="form-control" multiple>
            </div>
            <small class="text-muted mt-2 d-block" style="font-size: 0.75rem;">
                <i class="bi bi-info-circle me-1"></i> These will be added to your current gallery.
            </small>
        </div>

        {{-- Preview for newly selected files --}}
        <div id="imagePreview" class="d-flex flex-wrap gap-2 mt-2"></div>
    </div>
</div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-5 pt-3 border-top">
                            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary px-4">
                                <i class="bi bi-arrow-left me-1"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-dark px-5 fw-bold" style="background-color: var(--forest);">
                                <i class="bi bi-check2-circle me-1"></i> Update Product
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
    previewContainer.innerHTML = ''; 

    const files = event.target.files;
    if (files.length > 0) {
        [...files].forEach((file) => {
            const reader = new FileReader();
            reader.onload = (e) => {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('rounded', 'shadow-sm', 'border', 'p-1', 'bg-white');
                img.style.width = "70px";
                img.style.height = "70px";
                img.style.objectFit = "cover";
                previewContainer.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    }
});
function markForDeletion(btn, inputId) {
    const checkbox = document.getElementById(inputId);
    const imgWrapper = btn.parentElement;

    if (!checkbox.checked) {
        checkbox.checked = true;
        imgWrapper.style.opacity = '0.3';
        imgWrapper.style.filter = 'grayscale(100%)';
        btn.innerHTML = '<i class="bi bi-arrow-counterclockwise"></i>';
        btn.classList.replace('btn-danger', 'btn-warning');
    } else {
        checkbox.checked = false;
        imgWrapper.style.opacity = '1';
        imgWrapper.style.filter = 'none';
        btn.innerHTML = '<i class="bi bi-x"></i>';
        btn.classList.replace('btn-warning', 'btn-danger');
    }
}

document.getElementById('imageInput').addEventListener('change', function(event) {
    const previewContainer = document.getElementById('imagePreview');
    previewContainer.innerHTML = ''; 
    const files = event.target.files;
    if (files.length > 0) {
        [...files].forEach((file) => {
            const reader = new FileReader();
            reader.onload = (e) => {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('rounded', 'border', 'p-1', 'bg-white', 'shadow-sm');
                img.style.width = "60px";
                img.style.height = "60px";
                img.style.objectFit = "cover";
                img.style.border = "2px dashed #198754";
                previewContainer.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    }
});
</script>

<style>
    .form-control:focus, .form-select:focus {
        border-color: var(--forest);
        box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.1);
    }
</style>
@endsection