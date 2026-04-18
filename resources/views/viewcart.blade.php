@extends('layouts.usermain')

@section('content')
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;1,600&family=Inter:wght@300;400;600&display=swap"
        rel="stylesheet">
    <div class="container mt-3">
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show serif small" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    <div class="container py-3 mt-4" id="cart-container">
        {{-- Header --}}
        <div class="row mb-5 align-items-end">
            <div class="col-md-8">
                <h1 class="serif display-5 fw-bold mb-0">Your Selection</h1>
                <p class="text-muted small text-uppercase tracking-widest mt-2">Personal Curated Timepieces</p>
            </div>
            <div class="col-md-4 text-md-end">
                <span class="small text-muted"><span id="total-count">{{ $count }}</span> Items in Bag</span>
            </div>
        </div>

        @if($cart->isEmpty())
            <div class="text-center py-5 border-top border-bottom">
                <h2 class="serif py-5 italic">Your collection is empty.</h2>
                <a href="{{ route('index') }}" class="btn-confirm px-5 d-inline-block text-decoration-none">BROWSE THE
                    COLLECTION</a>
            </div>
        @else
            <form action="{{ route('order.confirm') }}" id="order-form" method="POST">
                @csrf
                <div class="row g-4">
                    {{-- 1. Product Table Column --}}
                    <div class="col-lg-4">
                        <h6 class="serif mb-4 text-uppercase tracking-widest">Selected Items</h6>
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th colspan="2">Description</th>
                                    <th class="text-end">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cart as $item)
                                    <tr id="row-{{ $item->id }}">
                                        <td style="width: 80px;">
                                            <div class="watch-img-container border">
                                                <img src="{{ asset('storage/products/' . (is_array($item->product->product_image) ? $item->product->product_image[0] : $item->product->product_image)) }}"
                                                    class="img-fluid" alt="Product">
                                            </div>
                                        </td>
                                        <td class="ps-3">
                                            <h6 class="serif mb-1" style="font-size: 0.9rem;">{{ $item->product->product_title }}
                                            </h6>
                                            <div class="d-flex align-items-center mt-2">
                                                <div class="qty-control border px-1 py-0"
                                                    style="background: #fdfdfd; scale: 0.8; transform-origin: left;">
                                                    <button type="button" onclick="updateQty({{ $item->id }}, 'reduce')"
                                                        class="btn btn-sm p-1 text-dark border-0 shadow-none"><i
                                                            class="bi bi-dash"></i></button>
                                                    <span class="mx-2 fw-bold small"
                                                        id="qty-{{ $item->id }}">{{ $item->quantity }}</span>
                                                    <button type="button" onclick="updateQty({{ $item->id }}, 'increase')"
                                                        class="btn btn-sm p-1 text-dark border-0 shadow-none"><i
                                                            class="bi bi-plus"></i></button>
                                                </div>
                                                <button type="button" onclick="removeItem({{ $item->id }})"
                                                    class="btn p-0 text-danger ms-2 opacity-50 bg-transparent border-0">
                                                    <i class="bi bi-trash3" style="font-size: 0.8rem;"></i>
                                                </button>
                                            </div>
                                        </td>
                                        <td class="text-end fw-light serif small">
                                            $<span
                                                id="total-{{ $item->id }}">{{ number_format($item->product->product_price * $item->quantity, 2) }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{-- Totals moved inside this column for better flow --}}
                        <div class="summary-container mt-4 pt-3 border-top">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="small text-muted text-uppercase">Subtotal</span>
                                <span class="small fw-bold">$<span
                                        id="subtotal-val">{{ number_format($subtotal, 2) }}</span></span>
                            </div>
                            <div class="d-flex justify-content-between align-items-end pt-3 border-top mt-3 mb-4">
                                <h6 class="serif mb-0 text-uppercase">Total Due</h6>
                                <h5 class="serif mb-0 fw-bold" style="color: #b19470;">$<span
                                        id="total-due">{{ number_format($subtotal, 2) }}</span></h5>
                            </div>
                        </div>
                    </div>

                    {{-- 2. Delivery Details Column --}}
                    <div class="col-lg-4 border-start px-lg-4">
                        <h6 class="serif mb-4 text-uppercase tracking-widest">Delivery Details</h6>
                        <div class="mb-4 position-relative pb-3">
                            <label class="small text-muted text-uppercase fw-bold">Contact Number</label>
                            <input type="text" name="receiver_phone"
                                class="form-control fancy-input shadow-none @error('receiver_phone') is-invalid @enderror"
                                value="{{ old('receiver_phone') }}" placeholder="+95..." required>
                            @error('receiver_phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-4 position-relative pb-3">
                            <label class="small text-muted text-uppercase fw-bold">Shipping Address</label>
                            <textarea required name="receiver_address"
                                class="form-control fancy-input shadow-none @error('receiver_address') is-invalid @enderror"
                                rows="3" placeholder="Full Street Address">{{ old('receiver_address') }}</textarea>
                            @error('receiver_address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- 3. Payment Method Column --}}
                    <div class="col-lg-4 border-start px-lg-4 position-relative">

                        <div id="payment-error-msg" class="text-danger small serif italic mb-5 text-center w-100"
                            style="display: none; position: absolute; top: -30px; left: 0; animation: fadeIn 0.3s;">
                            <i class="bi bi-exclamation-circle me-1"></i> Please select a payment method to continue.
                        </div>
                        <h6 class="serif mb-4 text-uppercase tracking-widest">Payment Method</h6>

                        <div class="payment-selection-grid">
                            <label class="payment-card">
                                <input type="radio" name="payment_method" value="cod" onclick="toggleSubMethods('none')">
                                <div class="card-content">
                                    <i class="bi bi-cash-stack"></i>
                                    <span>Cash on Delivery</span>
                                </div>
                            </label>

                            <label class="payment-card">
                                <input type="radio" name="payment_method" value="online_banking"
                                    onclick="toggleSubMethods('bank')">
                                <div class="card-content">
                                    <i class="bi bi-bank"></i>
                                    <span>Mobile Banking</span>
                                </div>
                            </label>

                            <label class="payment-card">
                                <input type="radio" name="payment_method" value="card" onclick="toggleSubMethods('card')">
                                <div class="card-content">
                                    <i class="bi bi-credit-card-2-front"></i>
                                    <span>Credit / Debit Card</span>
                                </div>
                            </label>
                        </div>

                        {{-- Bank Selection List --}}
                        <div id="bank-list" class="sub-method-container mt-3" style="display: none;">
                            <label class="small text-muted text-uppercase fw-bold mb-2 d-block">Choose Your Bank</label>
                            <select name="bank_name" class="form-select fancy-input py-2">
                                <option value="">-- Select Bank --</option>
                                <option value="AA Bank">KBZ Bank</option>
                                <option value="BB Bank">AYA Bank</option>
                                <option value="Kpay">Wave Money</option>
                            </select>
                        </div>

                        {{-- Card Selection List --}}
                        <div id="card-list" class="sub-method-container mt-3" style="display: none;">
                            <label class="small text-muted text-uppercase fw-bold mb-2 d-block">Select Card Provider</label>
                            <select name="card_type" class="form-select fancy-input py-2">
                                <option value="">-- Select Card --</option>
                                <option value="Visa">Visa Card</option>
                                <option value="Mastercard">Mastercard</option>
                                <option value="Paypal">Paypal</option>
                            </select>
                        </div>

                        @error('payment_method') <div class="text-danger small mt-2">{{ $message }}</div> @enderror

                        <div class="mt-3">
                            <button type="submit" class="btn btn-confirm w-100 text-uppercase fw-bold py-3">Confirm
                                Order</button>
                        </div>
                    </div>

                </div>
            </form>
        @endif
    </div>

    <style>
        .invalid-feedback {
            display: block !important;
            height: 35px;
            line-height: 1;
            overflow: hidden;
        }

        .fancy-input {
            border: none;
            border-bottom: 1px solid #e0e0e0;
            border-radius: 0;
            padding: 12px 0;
            background: transparent !important;
            transition: border-color 0.4s;
        }

        .fancy-input:focus {
            box-shadow: none;
            border-bottom-color: #1a1a1a;
        }

        .table th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 1.5px;
            border: none;
            color: #888;
        }

        .table td {
            border-bottom: 1px solid #f0f0f0;
            padding: 20px 0;
        }

        .btn-confirm {
            background: #1a1a1a;
            color: white;
            border-radius: 0;
            padding: 10px;
            letter-spacing: 2px;
            font-size: 0.8rem;
            transition: all 0.3s;
            border: 1px solid #1a1a1a;
        }

        .btn-confirm:hover {
            background: #333;
            color: white;
            transform: translateY(-4px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .watch-img-container {
            position: relative;
            overflow: hidden;
            background: #fff;
            border-color: #f0f0f0 !important;
        }

        .payment-selection-grid {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .payment-card {
            cursor: pointer;
            width: 100%;
        }

        .payment-card input {
            display: none;
        }

        .card-content {
            border: 1px solid #e0e0e0;
            padding: 15px;
            display: flex;
            align-items: center;
            gap: 15px;
            transition: all 0.3s;
            background: #fff;
        }

        .card-content i {
            font-size: 1.2rem;
            color: #888;
        }

        .card-content span {
            font-size: 0.85rem;
            font-weight: 500;
            color: #444;
        }

        .payment-card input:checked+.card-content {
            border-color: #b19470;
            background: #fdfaf5;
        }

        .payment-card input:checked+.card-content i {
            color: #b19470;
        }

        .payment-card input:checked+.card-content span {
            color: #1a1a1a;
            font-weight: 600;
        }

        .qty-control {
            display: inline-flex;
            align-items: center;
        }

        .sub-method-container {
            animation: fadeIn 0.4s ease;
            padding: 15px;
            background: #fdfaf5;
            border: 1px dashed #b19470;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-select.fancy-input {
            border: none;
            border-bottom: 1px solid #e0e0e0;
            border-radius: 0;
            font-size: 0.85rem;
        }
    </style>

    <script data-navigate-once>
        document.addEventListener('livewire:navigated', function () {
            window.updateQty = function (id, action) {
                fetch(`/cart/update/${id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ action: action })
                })
                    .then(async response => {
                        const data = await response.json();

                        if (response.ok) {
                            if (parseInt(data.newCount) === 0) {
                                location.reload();
                                return;
                            }
                            if (data.removed) {
                                const row = document.getElementById(`row-${id}`);
                                if (row) row.remove();
                            } else {
                                document.getElementById(`qty-${id}`).innerText = data.newQty;
                                document.getElementById(`total-${id}`).innerText = data.newItemTotal;
                            }
                            document.getElementById('subtotal-val').innerText = data.newSubtotal;
                            document.getElementById('total-due').innerText = data.newSubtotal;
                            document.getElementById('total-count').innerText = data.newCount;

                            const badge = document.getElementById('cart-count');
                            if (badge) badge.innerText = data.newCount;
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch(error => console.error('Error:', error));
            };
            window.removeItem = function (id) {
                if (!confirm('Remove this item?')) return;
                fetch(`/cart/remove/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById(`row-${id}`).remove();
                            document.getElementById('subtotal-val').innerText = data.newSubtotal;
                            document.getElementById('total-due').innerText = data.newSubtotal;
                            document.getElementById('total-count').innerText = data.newCount;
                            if (data.newCount == 0) location.reload();
                        }
                    });
            };

            window.toggleSubMethods = function (type) {
                const bankList = document.getElementById('bank-list');
                const cardList = document.getElementById('card-list');

                bankList.style.display = 'none';
                cardList.style.display = 'none';
                bankList.querySelector('select').value = "";
                cardList.querySelector('select').value = "";

                if (type === 'bank') {
                    bankList.style.display = 'block';
                } else if (type === 'card') {
                    cardList.style.display = 'block';
                }
            }
            const orderForm = document.getElementById('order-form');
            if (orderForm) {
                orderForm.addEventListener('submit', function (e) {
                    const paymentMethod = document.querySelector('input[name="payment_method"]:checked');
                    const btn = this.querySelector('button[type="submit"]');

                    if (!paymentMethod) {
                        e.preventDefault();
                        const errorMsg = document.getElementById('payment-error-msg');
                        errorMsg.style.display = 'block';
                        errorMsg.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        return;
                    }

                    if (paymentMethod.value === 'online_banking') {
                        const bankName = document.querySelector('select[name="bank_name"]').value;
                        if (!bankName) {
                            e.preventDefault();
                            alert('Please select your Bank Name.');
                            return;
                        }
                    }

                    if (paymentMethod.value === 'card') {
                        const cardType = document.querySelector('select[name="card_type"]').value;
                        if (!cardType) {
                            e.preventDefault();
                            alert('Please select your Card Type.');
                            return;
                        }
                    }

                    btn.disabled = true;
                    btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> PROCESSING...';
                });
            }
        });
    </script>
@endsection