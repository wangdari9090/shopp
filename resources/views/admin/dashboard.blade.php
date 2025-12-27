@extends('layouts.admin_main')

@section('page-title', 'Executive Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row g-4 mb-5">

        <div class="col-xl-3 col-md-6">
            <div class="card card-stat shadow-sm p-4">
                <div class="d-flex align-items-center">
                    <div class="icon-circle bg-soft-gold me-3">
                        <i class="bi bi-bag-check"></i>
                    </div>
                    <div>
                        <h6 class="text-muted small mb-1">Total Orders</h6>
                        <h4 class="fw-bold mb-0">156</h4>
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
                        <h6 class="text-muted small mb-1">New Clients</h6>
                        <h4 class="fw-bold mb-0">42</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card card-stat shadow-sm p-4 border-start border-danger border-4">
                <div class="d-flex align-items-center">
                    <div class="icon-circle bg-light text-danger me-3">
                        <i class="bi bi-exclamation-octagon"></i>
                    </div>
                    <div>
                        <h6 class="text-muted small mb-1">Low Inventory</h6>
                        <h4 class="fw-bold mb-0 text-danger">8 Items</h4>
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
                        <h4 class="fw-bold mb-0">$24,850.00</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
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
                            <tr>
                                <td class="fw-bold">#WA-9921</td>
                                <td>Alexander Pierce</td>
                                <td class="small text-muted">Rolex Datejust 41</td>
                                <td class="fw-bold text-dark">$9,200</td>
                                <td><span class="badge-status bg-success-subtle text-success">Completed</span></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">#WA-9922</td>
                                <td>Sophia Laurent</td>
                                <td class="small text-muted">Cartier Santos Large</td>
                                <td class="fw-bold text-dark">$7,100</td>
                                <td><span class="badge-status bg-warning-subtle text-warning text-dark">Processing</span></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">#WA-9923</td>
                                <td>Marcus Aurelius</td>
                                <td class="small text-muted">Omega Speedmaster</td>
                                <td class="fw-bold text-dark">$6,400</td>
                                <td><span class="badge-status bg-info-subtle text-info text-dark">Shipped</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm p-4" style="border-radius: 15px;">
                <h5 class="fw-bold mb-4" style="color: var(--forest);">Inventory Alerts</h5>
                <div class="d-flex align-items-center mb-4">
                    <div class="flex-shrink-0">
                        <div class="rounded bg-light p-2" style="width: 50px; height: 50px;">
                           <i class="bi bi-watch text-muted fs-4"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="mb-0 small fw-bold">Patek Philippe Nautilus</h6>
                        <small class="text-danger fw-semibold">1 Piece Remaining</small>
                    </div>
                </div>
                <div class="d-flex align-items-center mb-4">
                    <div class="flex-shrink-0">
                        <div class="rounded bg-light p-2" style="width: 50px; height: 50px;">
                           <i class="bi bi-watch text-muted fs-4"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="mb-0 small fw-bold">Audemars Piguet Royal Oak</h6>
                        <small class="text-warning fw-semibold">2 Pieces Remaining</small>
                    </div>
                </div>
                <hr>
                <button class="btn btn-outline-dark btn-sm w-100 py-2">Manage All Inventory</button>
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

    /* Luxury Table */
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

    /* Badge Styles */
    .badge-status {
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
    }
</style>

@endsection