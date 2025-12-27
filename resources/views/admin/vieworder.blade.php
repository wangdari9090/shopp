@extends('layouts.admin_main')

@section('content')
<div class="container-fluid">

    <h3 class="mb-4 fw-bold">All Orders</h3>

    <div class="card shadow-sm">
        <div class="card-body table-responsive">

            <table class="table table-bordered table-hover align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th>No.</th>
                        <th>Customer Name</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Product</th>
                        <th>Image</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($orders as $key => $order)
                        <tr>
                            <td>{{ $key + 1 }}</td>

                            <td>{{ $order->receiver_name ?? $order->user->name }}</td>

                            <td>{{ $order->receiver_address }}</td>

                            <td>{{ $order->receiver_phone }}</td>

                            <td>{{ $order->product->product_title }}</td>

                            <td>
                                <img src="{{ asset('storage/products/' . $order->product->product_image) }}"
                                     width="60" height="60"
                                     class="rounded"
                                     style="object-fit: cover;">
                            </td>

                            <td>
                                ${{ number_format($order->product->product_price, 2) }}
                            </td>
                           <td>
                                @if($order->status == 'pending')
                                    <span class="badge bg-secondary mb-2 d-block">Pending</span>
                                @elseif($order->status == 'on_the_way')
                                    <span class="badge bg-warning text-dark mb-2 d-block">On the Way</span>
                                @elseif($order->status == 'delivered')
                                    <span class="badge bg-success mb-2 d-block">Delivered</span>
                                @else
                                    <span class="badge bg-light text-dark mb-2 d-block">Unknown</span>
                                @endif

                                <div class="d-flex justify-content-center gap-1">
                                    @if($order->status == 'pending')
                                    <form action="{{ route('admin.updateOrderStatus', $order->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="on_the_way">
                                        <button type="submit" class="btn btn-sm btn-warning p-1">
                                            <i class="bi bi-truck"></i>
                                        </button>
                                    </form>
                                    @endif
                                    @if($order->status != 'delivered')
                                    <form action="{{ route('admin.updateOrderStatus', $order->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="delivered">
                                        <button type="submit" class="btn btn-sm btn-success p-1">
                                            <i class="bi bi-check-lg"></i>
                                        </button>
                                    </form>
                                    @endif

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-muted">No orders found</td>
                        </tr>
                    @endforelse
                </tbody>

            </table>

        </div>
    </div>

</div>
@endsection
