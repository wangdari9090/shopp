@extends('admin.maindesign')
@section('page-title', 'View Products')

@section('view_product')
<div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-2">

    <!-- Add Product Button (Right) -->
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary ms-5">
        <i class="bi bi-plus-lg me-1"></i> Add Product
    </a>

</div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Table wrapper for horizontal scroll on mobile --}}
    <div class="table-responsive col-lg-9 ms-5">
    <table class="table table-bordered table-striped align-middle text-center">
    <thead class="table-dark">
        <tr>
            <th>No.</th>
            <th>Image</th>
            <th>Title</th>
            <th>Description</th>
            <th>Category</th>
            <th>Price</th>
            <th>Qty</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        @forelse($products as $key => $product)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>
                    @if($product->product_image)
                        <img src="{{ asset('storage/products/'.$product->product_image) }}"
                             class="img-fluid rounded"
                             style="width:50px;height:50px;object-fit:cover;">
                    @else
                        <span class="text-muted">No Image</span>
                    @endif
                </td>
                <td>{{ $product->product_title }}</td>
                <td class="text-truncate" style="max-width:150px;">
                    {{ $product->product_description ?? 'N/A' }}
                </td>
                <td>
                    {{ $product->category->category ?? 'No Category' }}
                </td>

                <td>${{ number_format($product->product_price, 2) }}</td>
                <td>{{ $product->product_quantity }}</td>
                <td>
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-pencil-square"></i>
                    </a>

                    <a href="{{ route('admin.products.delete', $product->id) }}"
                       onclick="return confirm('Delete this?');"
                       class="btn btn-sm btn-danger">
                        <i class="bi bi-trash"></i>
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8">No products found.</td>
            </tr>
        @endforelse
    </tbody>
    </table>
    <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $products->links() }}
        </div>
    </div>
</div>

@endsection
