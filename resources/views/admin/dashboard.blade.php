@extends('layouts.admin_main')

@section('page-title', 'Executive Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row g-4 my-3 px-4">
        {{-- Total Products --}}
        <div class="col-xl-3 col-md-6">
            <div class="card card-stat shadow-sm p-4">
                <div class="d-flex align-items-center">
                    <div class="icon-circle bg-soft-gold me-3">
                        <i class="bi bi-watch"></i>
                    </div>
                    <div>
                        <h6 class="text-muted small mb-1">Total Products</h6>
                        <h4 class="fw-bold mb-0">{{ $totalProducts }}</h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- Member List (Total Users) --}}
        <div class="col-xl-3 col-md-6">
            <div class="card card-stat shadow-sm p-4">
                <div class="d-flex align-items-center">
                    <div class="icon-circle bg-soft-forest me-3">
                        <i class="bi bi-people"></i>
                    </div>
                    <div>
                        <h6 class="text-muted small mb-1">Members</h6>
                        <h4 class="fw-bold mb-0">{{ $totalMembers }}</h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Orders --}}
        <div class="col-xl-3 col-md-6">
            <div class="card card-stat shadow-sm p-4 border-start border-success border-4">
                <div class="d-flex align-items-center">
                    <div class="icon-circle bg-light text-success me-3">
                        <i class="bi bi-bag-check"></i>
                    </div>
                    <div>
                        <h6 class="text-muted small mb-1">Total Orders</h6>
                        <h4 class="fw-bold mb-0">{{ $totalOrders }}</h4>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Monthly Revenue --}}
        <div class="col-xl-3 col-md-6">
            <div class="card card-stat shadow-sm p-4">
                <div class="d-flex align-items-center">
                    <div class="icon-circle bg-soft-forest me-3">
                        <i class="bi bi-currency-dollar"></i>
                    </div>
                    <div>
                        <h6 class="text-muted small mb-1">Monthly Revenue</h6>
                        <h4 class="fw-bold mb-0">${{ number_format($monthlyRevenue, 2) }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <div class="row g-4 px-5">
            <div class="table-container shadow-sm border-0">
                <div class="p-4 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="fw-bold m-0" style="color: var(--forest);">Recent Acquisitions</h5>
                    <button class="btn btn-sm text-white px-3" style="background: var(--forest);">View All</button>
                </div>
                <div class="table-responsive">
                    <table class="table table-luxury m-0">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Client Name</th>
                                <th>Item Name</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
    @foreach($recentOrders as $order)
    <tr>
        <td class="fw-bold">#VO-{{ $order->id }}</td>
        <td>
            <div class="fw-bold">{{ $order->user->name }}</div>
            <small class="text-muted">{{ $order->receiver_phone }}</small>
        </td>
        <td class="small text-muted">
            {{-- Displaying first item name and count if more than one --}}
            @if($order->items->count() > 0)
                {{ $order->items->first()->product->product_title }}
                @if($order->items->count() > 1)
                    <span class="badge bg-light text-dark">+{{ $order->items->count() - 1 }} more</span>
                @endif
            @endif
        </td>
        <td class="fw-bold text-dark">${{ number_format($order->total_price, 2) }}</td>
      <th style="width: 180px;">Status</th> <td style="width: 180px;"> <form action="{{ route('admin.updateOrderStatus', $order->id) }}" method="POST" id="status-form-{{ $order->id }}">
        @csrf
        <select name="status" 
                onchange="this.form.submit()"
                class="form-select form-select-sm fw-bold border-0 
                {{ $order->status == 'pending' ? 'bg-warning text-dark' : '' }}
                {{ $order->status == 'on_the_way' ? 'bg-info text-white' : '' }}
                {{ $order->status == 'delivered' ? 'bg-success text-white' : '' }}" 
                style="border-radius: 8px; cursor: pointer; width: 100%;"> <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>⏳ Processing</option>
            <option value="on_the_way" {{ $order->status == 'on_the_way' ? 'selected' : '' }}>🚚 Shipped</option>
            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>✅ Delivered</option>
        </select>
    </form>
</td>
        {{-- <td class="text-end">
            <a href="{{ url('admin/view_order_details/'.$order->id) }}" class="btn btn-sm btn-outline-dark" style="border-radius: 8px;">
                <i class="bi bi-eye"></i> View
            </a>
        </td> --}}
    </tr>
    @endforeach
</tbody>
                    </table>
<div class="d-flex justify-content-between align-items-center p-4 border-top">
    <div class="small text-muted">
        Showing {{ $recentOrders->firstItem() }} to {{ $recentOrders->lastItem() }} of {{ $recentOrders->total() }} vouchers
    </div>
    
    <div class="luxury-pagination">
        {{ $recentOrders->links('pagination::bootstrap-5') }}
    </div>
</div>
                </div>
            </div>
    </div>
</div>

<style>
    :root {
        --forest: #0d3b26;
        --gold: #c5a059;
    }

    /* Summary Cards */
    .card-stat {
        border: none;
        border-radius: 12px;
        background: #ffffff;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card-stat:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.05) !important;
    }
    .icon-circle {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
    .bg-soft-forest { background-color: rgba(13, 59, 38, 0.1); color: var(--forest); }
    .bg-soft-gold { background-color: rgba(197, 160, 89, 0.1); color: var(--gold); }

  /* Fix to remove the duplicate "Showing..." text from the Bootstrap template */
.luxury-pagination nav div:first-child {
    display: none !important; /* Hides the mobile summary block */
}

.luxury-pagination nav div:last-child p {
    display: none !important; /* Hides the desktop summary text next to buttons */
}

/* Luxury Styling for buttons */

    .table-container {
        background: white;
        border-radius: 15px;
        overflow: hidden;
    }
    .table-luxury thead {
        background: #fcfcfc;
    }
    .table-luxury thead th {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 700;
        color: #888;
        border-top: none;
        padding: 1.25rem;
    }
    .table-luxury tbody td {
        padding: 1.25rem;
        vertical-align: middle;
        color: #333;
        border-bottom: 1px solid #f1f1f1;
    }
    .badge-status {
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
    }
</style>

@endsection