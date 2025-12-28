@extends('layouts.admin_main')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-dark mb-0">Order Management</h3>
        <span class="badge bg-soft-forest text-forest px-3 py-2 border">
            Total Orders: {{ count($orders) }}
        </span>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0"> {{-- Removed padding to let table be full-width --}}
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small text-uppercase">
                        <tr>
                            <th class="ps-4">No.</th>
                            <th>Customer info</th>
                            <th>Shipping Address</th>
                            <th>Product Detail</th>
                            <th class="text-center">Total Price</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($orders as $key => $order)
                            <tr>
                                <td class="ps-4 text-muted">{{ $key + 1 }}</td>
                                
                                {{-- Customer Info --}}
                                <td>
                                    <div class="fw-bold text-dark">{{ $order->receiver_name ?? $order->user->name }}</div>
                                    <div class="small text-muted"><i class="bi bi-telephone me-1"></i>{{ $order->receiver_phone }}</div>
                                </td>

                                {{-- Address --}}
                                <td style="max-width: 200px;">
                                    <span class="small text-secondary">{{ $order->receiver_address }}</span>
                                </td>

                                {{-- Product info --}}
                                <td>
    <div class="d-flex align-items-center">
        @if($order->product)
            {{-- Check if image is an array and get the first one --}}
            @php 
                $firstImage = is_array($order->product->product_image) 
                    ? ($order->product->product_image[0] ?? 'default.png') 
                    : ($order->product->product_image ?? 'default.png');
            @endphp
            <img src="{{ asset('storage/products/' . $firstImage) }}"
                 width="45" height="45"
                 class="rounded border me-3 shadow-sm"
                 style="object-fit: cover;">
            
            <div class="small fw-bold text-truncate" style="max-width: 150px;">
                {{ $order->product->product_title }}
            </div>
        @else
            {{-- Fallback if the product was deleted --}}
            <span class="text-danger small"><i class="bi bi-exclamation-triangle"></i> Product Deleted</span>
        @endif
    </div>
</td>

                                {{-- Price --}}
                                <td class="text-center">
                                   <span class="fw-bold text-dark">
                                        @if($order->product)
                                            ${{ number_format($order->product->product_price, 2) }}
                                        @else
                                            <span class="text-muted small">N/A (Product Deleted)</span>
                                        @endif
                                    </span>
                                </td>

                                {{-- Status Badge --}}
                                <td class="text-center">
                                    @if($order->status == 'pending')
                                        <span class="badge rounded-pill bg-light text-secondary border px-3">Pending</span>
                                    @elseif($order->status == 'on_the_way')
                                        <span class="badge rounded-pill bg-warning text-dark px-3">On the Way</span>
                                    @elseif($order->status == 'delivered')
                                        <span class="badge rounded-pill bg-success px-3">Delivered</span>
                                    @else
                                        <span class="badge rounded-pill bg-light text-dark border px-3">Unknown</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted italic">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    No orders found in the database.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="d-flex justify-content-between align-items-center p-4 border-top">
    <div class="small text-muted">
        Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of {{ $orders->total() }} vouchers
    </div>
    
    <div class="luxury-pagination">
        {{ $orders->links('pagination::bootstrap-5') }}
    </div>
</div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-soft-forest {
        background-color: rgba(25, 135, 84, 0.05);
    }
    .text-forest {
        color: var(--forest);
    }
    .table thead th {
        font-weight: 600;
        letter-spacing: 0.5px;
        padding-top: 15px;
        padding-bottom: 15px;
    }
    .table tbody td {
        padding-top: 15px;
        padding-bottom: 15px;
    }
    .btn-outline-warning:hover { color: #856404 !important; }
    .btn-outline-success:hover { color: #155724 !important; }
</style>
@endsection