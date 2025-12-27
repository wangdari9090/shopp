@extends('layouts.admin_main')

@section('content')
<div class="container-fluid py-4">
    <div class="mx-auto" style="max-width: 600px;">
        
        <div class="mb-4">
            <h4 class="fw-bold" style="color: var(--forest);">Add New Category</h4>
            <p class="text-muted small">Select a watch category to add to your inventory.</p>
        </div>

        <div class="card border-0 shadow-sm p-4">
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

            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="category_name" class="form-label fw-bold small text-uppercase" style="color: var(--forest);">
                        Category Name
                    </label>
                    <select name="category" id="category_name" class="form-select border-light-subtle shadow-none py-2" required>
                        <option value="" disabled selected>-- Select Category --</option>
                        <option value="Smartwatches">Smartwatches</option>
                        <option value="Luxury Watches">Luxury Watches</option>
                        <option value="Automatic Watches">Automatic Watches</option>
                        <option value="Chronograph Watches">Chronograph Watches</option>
                        <option value="Diver Watches">Diver Watches</option>
                        <option value="Field Watches">Field Watches</option>
                    </select>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn add-cate px-4">
                        <i class="bi bi-plus-circle me-1"></i> Add Category
                    </button>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary px-4">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection