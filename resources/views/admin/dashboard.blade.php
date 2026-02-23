@extends('layouts.admin_main')

@section('page-title', 'Executive Dashboard')

@section('content')
<div id="ajax-container">
    <div class="container-fluid">
        <div class="row g-4 my-3 px-4">
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

        <div class="row g-4 px-5">
            <div class="table-container shadow-sm border-0">
                <div class="p-4 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="fw-bold m-0" style="color: var(--forest);">Recent Acquisitions</h5>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm text-white px-3" style="background: var(--forest);">View All</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-luxury m-0">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Client Name</th>
                                <th>Item Name</th>
                                <th>Amount</th>
                                <th class="text-center">Status</th>
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
                                    @if($order->items->count() > 0)
                                        {{ $order->items->first()->product->product_title }}
                                        @if($order->items->count() > 1)
                                            <span class="badge bg-light text-dark">+{{ $order->items->count() - 1 }} more</span>
                                        @endif
                                    @endif
                                </td>
                                <td class="fw-bold text-dark">${{ number_format($order->total_price, 2) }}</td>
                                <td class="text-center">
                                    @if($order->status == 'pending')
                                        <span class="badge-status status-pending">⏳ Processing</span>
                                    @elseif($order->status == 'confirmed')
                                        <span class="badge-status status-confirmed">📦 Confirmed</span>
                                    @elseif($order->status == 'out_for_delivery')
                                        <span class="badge-status status-shipped">🚚 Shipped</span>
                                    @elseif($order->status == 'delivered')
                                        <span class="badge-status status-delivered">✅ Delivered</span>
                                    @elseif($order->status == 'cancelled')
                                        <span class="badge-status status-cancelled">❌ Cancelled</span>
                                    @endif
                                </td>
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
</div>

<style>
    :root { --forest: #0d3b26; --gold: #c5a059; }
    .card-stat { border: none; border-radius: 12px; background: #ffffff; transition: transform 0.3s ease, box-shadow 0.3s ease; }
    .card-stat:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.05) !important; }
    .icon-circle { width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; }
    .bg-soft-forest { background-color: rgba(13, 59, 38, 0.1); color: var(--forest); }
    .bg-soft-gold { background-color: rgba(197, 160, 89, 0.1); color: var(--gold); }
    .table-container { background: white; border-radius: 15px; overflow: hidden; }
    .table-luxury thead { background: #fcfcfc; }
    .table-luxury thead th { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; font-weight: 700; color: #888; border-top: none; padding: 1.25rem; }
    .table-luxury tbody td { padding: 1.25rem; vertical-align: middle; color: #333; border-bottom: 1px solid #f1f1f1; }
    
    /* New Status Badge Styles (Non-Selectable) */
    .badge-status {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 0.7rem;
        font-weight: 700;
        min-width: 100px;
    }
    .status-pending { background-color: #f8f9fa; color: #6c757d; border: 1px solid #dee2e6; }
    .status-confirmed { background-color: #e3f2fd; color: #0d6efd; border: 1px solid #bbdefb; }
    .status-shipped { background-color: #fff3e0; color: #ef6c00; border: 1px solid #ffe0b2; }
    .status-delivered { background-color: #e8f5e9; color: #2e7d32; border: 1px solid #c8e6c9; }
    .status-cancelled { background-color: #ffebee; color: #c62828; border: 1px solid #ffcdd2; }
</style>

{{-- <script>
// Logic for handling AJAX pagination on dashboard
document.addEventListener('click', function(e) {
    const link = e.target.closest('.luxury-pagination a');
    if (link) {
        e.preventDefault();
        const url = link.getAttribute('href');
        const container = document.getElementById('ajax-container');
        container.style.opacity = '0.5';

        fetch(url, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.text())
        .then(html => {
            container.innerHTML = html;
            container.style.opacity = '1';
            window.history.pushState({}, '', url);
        })
        .catch(error => {
            console.error('Error:', error);
            container.style.opacity = '1';
        });
    }
});
</script> --}}
@endsection