@extends('layouts.admin_main')

@section('content')
<div id="order-table-container">
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold text-dark mb-0">Order Management</h3>
            <span class="badge bg-soft-forest text-forest px-3 py-2 border">
                Total Orders: {{ $orders->total() }}
            </span>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-muted small text-uppercase">
                            <tr>
                                <th class="ps-4">Voucher</th>
                                <th>Customer</th>
                                <th>Shipping Address</th>
                                <th>Items</th>
                                <th class="text-center">Payment</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                        @forelse($orders as $order)
        <tr>
            <td class="ps-4">
                <div class="fw-bold text-dark">#{{ str_pad($order->user_order_number, 4, '0', STR_PAD_LEFT) }}</div>
                <div class="text-muted" style="font-size: 0.7rem;">{{ $order->created_at->format('d M, Y') }}</div>
            </td>

            <td>
                <div class="fw-bold text-dark">{{ $order->user->name }}</div>
                <div class="small text-muted"><i class="bi bi-telephone me-1"></i>{{ $order->receiver_phone }}</div>
            </td>

            <td style="max-width: 180px;">
                <div class="small text-secondary text-truncate" title="{{ $order->receiver_address }}">
                    {{ Str::limit($order->receiver_address, 40) }}
                </div>
            </td>

            <td>
        <div class="mb-2">
            <span class="badge bg-soft-info text-info border-info px-2" style="font-size: 0.7rem;">
                Total: {{ $order->items->sum('quantity') }} Pcs
            </span>
        </div>

        <div class="d-flex flex-column gap-1">
            @foreach($order->items as $item)
        <div class="d-flex align-items-center bg-light rounded p-1" style="font-size: 0.75rem;">
            <span class="fw-bold text-primary me-1">{{ $item->quantity }}x</span>
            <span class="text-truncate" style="max-width: 120px;">{{ $item->product->product_title }}</span>
        </div>
    @endforeach
        </div>
    </td>

            <td class="text-center">
                <div class="small text-uppercase text-muted mb-1" style="font-size: 0.6rem; letter-spacing: 0.5px;">
                    {{ str_replace('_', ' ', $order->payment_method) }}
                </div>
                
                @if($order->payment && $order->payment->status === 'paid')
                    <span class="badge bg-soft-success text-success border-0 px-3">
                        <i class="bi bi-check-circle-fill me-1"></i> Paid
                    </span>
                @else
                    <form action="{{ route('admin.order.confirm-payment', $order->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-warning py-1 px-3 rounded-pill" style="font-size: 0.7rem;">
                            Confirm Money
                        </button>
                    </form>
                @endif
            </td>

            <td class="text-center">
        <div class="fw-bold text-dark">${{ number_format($order->total_price, 2) }}</div>
        <div class="text-muted small" style="font-size: 0.65rem;">
            Avg: ${{ number_format($order->total_price / max($order->items->sum('quantity'), 1), 2) }}/pc
        </div>
    </td>
    <td class="text-center" style="width: 140px;">
        <select class="status-updater no-arrow form-select form-select-sm fw-bold border-0 
                {{ $order->status == 'pending' ? 'status-pending' : '' }}
                {{ $order->status == 'confirmed' ? 'status-confirmed' : '' }}
                {{ $order->status == 'out_for_delivery' ? 'status-shipped' : '' }}
                {{ $order->status == 'delivered' ? 'status-delivered' : '' }}
                {{ $order->status == 'cancelled' ? 'status-cancelled' : '' }}" 
                data-id="{{ $order->id }}"
                style="border-radius: 6px; cursor: pointer; font-size: 0.7rem; height: 28px; padding: 2px 8px;">
            
            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>⏳ Processing</option>
            <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>📦 Confirmed</option>
            <option value="out_for_delivery" {{ $order->status == 'out_for_delivery' ? 'selected' : '' }}>🚚 Shipped</option>
            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>✅ Delivered</option>
            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>❌ Cancelled</option>
        </select>
    </td>

    <td class="text-center">
        <div class="dropdown">
            <button class="btn btn-sm btn-light border" type="button" data-bs-toggle="dropdown">
                <i class="bi bi-three-dots"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                <li>
        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editItems{{ $order->id }}">
            <i class="bi bi-pencil me-2"></i>Edit Items
        </button>
    </li>
                
                <li>
                    <form action="{{ route('admin.orders.togglePayment', $order->id) }}" method="POST">
                        @csrf
                        <button class="dropdown-item" type="submit">
                            <i class="bi bi-currency-exchange me-2"></i>Reverse Payment
                        </button>
                    </form>
                </li>
                
                <li><hr class="dropdown-divider"></li>
                
                <li>
                    <form action="{{ route('admin.orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                        @csrf
                        <button class="dropdown-item text-danger" type="submit">
                            <i class="bi bi-trash me-2"></i>Cancel Order
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </td>
        </tr>
    @empty
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
    @foreach($orders as $order)
    <div class="modal fade" id="editItems{{ $order->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold">Edit Order #{{ $order->user_order_number }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                
                <form action="{{ route('admin.order.editItems', $order->id) }}" method="POST">
                    @csrf 
                    @method('PUT')
                    
                    <div class="modal-body">
                        <h6 class="text-uppercase text-muted small fw-bold mb-3">Shipping Information</h6>
                        <div class="mb-3">
                            <label class="form-label small">Receiver Name</label>
                            <input type="text" name="receiver_name" class="form-control form-control-sm" value="{{ $order->user->name }}">
                        </div>
                        <div class="mb-3">
        <label class="form-label small">Receiver Phone</label>
        <input type="text" 
            name="receiver_phone" 
            class="form-control form-control-sm" 
            value="{{ $order->receiver_phone }}"
            oninput="this.value = this.value.replace(/[^0-9]/g, '');" 
            placeholder="09XXXXXXXXX"
            required>
        <small class="text-muted" style="font-size: 0.65rem;">Please Enter Number</small>
    </div>
                        <div class="mb-4">
                            <label class="form-label small">Shipping Address</label>
                            <textarea name="receiver_address" class="form-control form-control-sm" rows="2">{{ $order->receiver_address }}</textarea>
                        </div>

                        <h6 class="text-uppercase text-muted small fw-bold mb-3 border-top pt-3">Order Items</h6>
                        @foreach($order->items as $item)
                            <div class="d-flex align-items-center justify-content-between mb-2 p-2 bg-light rounded">
                                    <div class="fw-bold text-dark">{{ $item->product->product_title }}</div>
                                    <div class="text-muted">${{ number_format($item->product->product_price, 2) }} / unit</div>
                            </div>
                        @endforeach
                    </div>

                    <div class="modal-footer bg-light border-0">
                        <button type="button" class="btn btn-sm btn-secondary px-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-sm btn-primary px-4">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>
<style>
    .bg-soft-forest { background-color: rgba(25, 135, 84, 0.05); }
    .bg-soft-info { background-color: rgba(13, 202, 240, 0.1); }
    .bg-soft-success { background-color: rgba(25, 135, 84, 0.1); }
    .text-forest { color: #198754; }
    .table thead th { font-weight: 600; letter-spacing: 0.5px; padding: 15px 10px; border-bottom: 2px solid #f8f9fa; }
    .table tbody td { padding: 12px 10px; }
    .transition-all { transition: all 0.3s; }
    .status-pending { background-color: rgba(108, 117, 125, 0.1) !important; color: #6c757d !important; }
    .status-confirmed { background-color: rgba(13, 202, 240, 0.1) !important; color: #0dcaf0 !important; }
    .status-shipped { background-color: rgba(255, 193, 7, 0.1) !important; color: #ffc107 !important; }
    .status-delivered { background-color: rgba(25, 135, 84, 0.1) !important; color: #198754 !important; }
    .status-cancelled { background-color: rgba(220, 53, 69, 0.1) !important; color: #dc3545 !important; }
    .container-fluid { transition: opacity 0.2s ease-in-out; }
</style>
<script>
document.addEventListener('change', function(e) {
    if (e.target.classList.contains('status-updater')) {
        const id = e.target.getAttribute('data-id');
        const status = e.target.value;
        const container = document.getElementById('order-table-container');
        container.style.opacity = '0.5';

        fetch(`/admin/orders/${id}/status`, {
            method: 'PATCH', 
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ status: status })
        })
        .then(response => {
            if (!response.ok) throw new Error('Update failed');
            return response.text();
        })
        .then(html => {
            container.innerHTML = html;
            container.style.opacity = '1';
        })
        .catch(error => {
            console.error('Error:', error);
            container.style.opacity = '1';
            alert('Failed to update status. Please check your routes.');
        });
    }
});
</script>
@endsection