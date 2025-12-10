@extends('admin.maindesign')

@section('add_product')
<div class="card shadow-sm p-4">
    <h4 class="mb-3">Add New Products</h4>
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
        <div class="alert alert-success alert-dismissible fade show" role="alert"><strong>{{ session('success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Add product Form --}}
    <form action="" method="POST">
        @csrf

        <div class="mb-3">
            <label for="product_name" class="form-label">product Name</label>
            <input
                type="text"
                name="product"
                class="form-control"
                id="product"
                placeholder="Enter product name"
                required
            >
        </div>

        <button type="submit" class="btn btn-primary">Add Product</button>
        <a href="{{ route('admin.viewproduct') }}" class="btn btn-secondary px-4">Back</a>

    </form>
</div>
</div>
@endsection
