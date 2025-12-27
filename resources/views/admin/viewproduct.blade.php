@extends('layouts.admin_main')
@section('page-title', 'View Products')

@section('content')
<div class="container-fluid py-4">
    <div class="card border-0 shadow-sm mx-auto" style="max-width: 1200px;">
        
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom-0">
            <h5 class="mb-0 fw-bold" style="color: var(--forest);">Product Inventory</h5>
            <a href="{{ route('admin.products.create') }}" class="btn btn-gold px-4">
                <i class="bi bi-plus-lg me-1"></i> Add Product
            </a>
        </div>

        <div class="card-body">
            {{-- Success Message --}}
            @if(session('success'))
                <div class="alert alert-success border-0 small shadow-sm alert-dismissible fade show mb-4">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr style="font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">
                            <th class="ps-4">No.</th>
                            <th>Image</th>
                            <th>Product Details</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $key => $product)
                            <tr>
                                <td class="ps-4 fw-bold text-muted">
                                    {{ ($products->currentPage() - 1) * $products->perPage() + $loop->iteration }}
                                </td>
                                <td>
                                    @foreach($product->product_image as $image)
                                        <img src="{{ asset('storage/products/' . $image) }}" class="img-thumbnail" style="width: 100px;">
                                    @endforeach
                                </td>
                                <td>
                                    <div class="fw-bold" style="color: var(--forest);">{{ $product->product_title }}</div>
                                    <div class="small text-muted text-truncate" style="max-width: 200px;">
                                        {{ $product->product_description ?? 'No description' }}
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border fw-normal">
                                        {{ $product->category->category ?? 'Uncategorized' }}
                                    </span>
                                </td>
                                <td class="fw-bold text-dark">
                                    ${{ number_format($product->product_price, 2) }}
                                </td>
                                <td>
                                    @if($product->product_quantity <= 5)
                                        <span class="text-danger fw-bold"><i class="bi bi-exclamation-triangle-fill"></i> {{ $product->product_quantity }}</span>
                                    @else
                                        {{ $product->product_quantity }}
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        {{-- Edit Button --}}
                                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-outline-secondary">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        {{-- Delete Button (Using Form for safety) --}}
                                        <form action="{{ route('admin.products.delete', $product->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                    onclick="return confirm('Permanent delete this product?');">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="bi bi-box-seam fs-1 d-block mb-2"></i>
                                    No products found in the database.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
@endsection