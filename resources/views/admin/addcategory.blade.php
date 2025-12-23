@extends('admin.maindesign')

@section('add_category')
<div class="card shadow-sm p-4">
    <h4 class="mb-3">Add New Category</h4>

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
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Add Category Form --}}
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="category_name" class="form-label">Category Name</label>
            <select name="category" id="category_name" class="form-select" required>
                <option value="">-- Select Category --</option>
                <option value="Smartwatches">Smartwatches</option>
                <option value="Luxury Watches">Luxury Watches</option>
                <option value="Automatic Watches">Automatic Watches</option>
                <option value="Chronograph Watches">Chronograph Watches</option>
                <option value="Diver Watches">Diver Watches</option>
                <option value="Field Watches">Field Watches</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Add Category</button>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary px-4">Back</a>
    </form>
</div>
@endsection
