@extends('admin.maindesign') 
@section('page-title', 'View Products')

@section('view_product')
<div class="card shadow-sm p-3 p-md-4">
    <h4 class="mb-3">All Products</h4>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Table wrapper for horizontal scroll on mobile --}}
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th class="text-nowrap" style="width:3%;">#</th>
                    <th class="text-nowrap" style="width:7%;">Image</th>
                    <th class="text-nowrap" style="width:15%;">Title</th>
                    <th class="text-nowrap" style="width:10%;">Category</th>
                    <th class="text-nowrap" style="width:7%;">Price</th>
                    <th class="text-nowrap" style="width:8%;">Discount</th>
                    <th class="text-nowrap" style="width:5%;">Qty</th>
                    <th class="text-nowrap" style="width:8%;">SKU</th>
                    <th class="text-nowrap" style="width:7%;">Status</th>
                    <th class="text-nowrap" style="width:15%;">Tags</th>
                    <th class="text-nowrap" style="width:10%;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $key => $product)
                    <tr>
                        <td class="text-center">{{ $key + 1 }}</td>

                        {{-- Image --}}
                        <td>
                            @if($product->image)
                                <img src="{{ asset('storage/'.$product->image) }}" 
                                     alt="{{ $product->title }}" 
                                     class="img-fluid rounded mx-auto d-block"
                                     style="width:50px; height:50px; object-fit:cover;">
                            @else
                                <span class="text-muted">No Image</span>
                            @endif
                        </td>

                        {{-- Title --}}
                        <td class="text-truncate" style="max-width:120px;" title="{{ $product->title }}">
                            {{ $product->title }}
                        </td>

                        {{-- Category --}}
                        <td class="text-truncate" style="max-width:100px;" title="{{ $product->category->category ?? 'N/A' }}">
                            {{ $product->category->category ?? 'N/A' }}
                        </td>

                        {{-- Price --}}
                        <td>${{ number_format($product->price, 2) }}</td>

                        {{-- Discount Price --}}
                        <td>
                            @if($product->discount_price)
                                ${{ number_format($product->discount_price, 2) }}
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>

                        {{-- Quantity --}}
                        <td>{{ $product->quantity }}</td>

                        {{-- SKU --}}
                        <td class="text-truncate" style="max-width:80px;" title="{{ $product->sku }}">
                            {{ $product->sku }}
                        </td>

                        {{-- Status --}}
                        <td>
                            @if($product->status == 'active')
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>

                        {{-- Tags --}}
                        <td class="text-truncate" style="max-width:120px;" title="{{ $product->tags }}">
                            {{ $product->tags }}
                        </td>

                        {{-- Actions --}}
                        <td class="text-nowrap">
                            <a href="{{ route('admin.updateproduct', $product->id) }}" 
                               class="btn btn-sm btn-primary mb-1 me-1">
                                <i class="bi bi-pencil-square"></i>
                            </a>

                            <a href="{{ route('admin.deleteproduct', $product->id) }}"
                               class="btn btn-sm btn-danger mb-1"
                               onclick="return confirm('Are you sure you want to delete this product?');">
                                <i class="bi bi-trash text-white"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="text-center">No products found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
