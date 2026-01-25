@extends('layouts.usermain')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;1,600&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

<div class="container py-5 mt-4" id="cart-container">
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
            <a href="{{ route('index') }}" class="btn-confirm px-5 d-inline-block text-decoration-none">BROWSE THE COLLECTION</a>
        </div>
    @else
    <div class="row g-4">
        <div class="col-lg-4">
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
                                <img src="{{ asset('storage/products/' . (is_array($item->product->product_image) ? $item->product->product_image[0] : $item->product->product_image)) }}" class="img-fluid" alt="Product">
                            </div>
                        </td>
                        <td class="ps-3">
                            <h6 class="serif mb-1" style="font-size: 0.9rem;">{{ $item->product->product_title }}</h6>
                            <div class="d-flex align-items-center mt-2">
                                <div class="d-flex align-items-center border px-1 py-0" style="background: #fdfdfd; scale: 0.8; transform-origin: left;">
                                    {{-- AJAX Buttons --}}
                                    <button type="button" onclick="updateQty({{ $item->id }}, 'reduce')" class="btn btn-sm p-1 text-dark border-0 shadow-none"><i class="bi bi-dash"></i></button>
                                    <span class="mx-2 fw-bold small qty-val" id="qty-{{ $item->id }}">{{ $item->quantity }}</span>
                                    <button type="button" onclick="updateQty({{ $item->id }}, 'increase')" class="btn btn-sm p-1 text-dark border-0 shadow-none"><i class="bi bi-plus"></i></button>
                                </div>
                                <button type="button" onclick="removeItem({{ $item->id }})" class="btn p-0 text-danger ms-2 opacity-50 bg-transparent border-0">
                                    <i class="bi bi-trash3" style="font-size: 0.8rem;"></i>
                                </button>
                            </div>
                        </td>
                        <td class="text-end fw-light serif small">
                            $<span class="item-total" id="total-{{ $item->id }}">{{ number_format($item->product->product_price * $item->quantity, 2) }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="col-lg-4">
            <h6 class="serif mb-4 text-uppercase tracking-widest">Your Order Summary</h6>
            <div class="summary-container p-4">
                <div class="border-top pt-3">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="small text-muted text-uppercase">Subtotal</span>
                        <span class="small fw-bold">$<span id="subtotal-val">{{ number_format($subtotal, 2) }}</span></span>
                    </div>
                    <div class="d-flex justify-content-between align-items-end pt-3 border-top mb-4">
                        <h5 class="serif mb-0 text-uppercase">Total Due</h5>
                        <h4 class="serif mb-0" style="color: var(--luxury-gold); font-weight: bold;">$<span id="total-due">{{ number_format($subtotal, 2) }}</span></h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 border-start border-end px-lg-4">
            <form action="{{ route('order.confirm') }}" id="order-form" method="POST">
                @csrf
                <h6 class="serif mb-4 text-uppercase tracking-widest">Delivery Details</h6>
                <div class="mb-4 position-relative pb-3">
                    <label class="small text-muted text-uppercase fw-bold">Contact Number</label>
                    <input type="text" name="receiver_phone" class="form-control fancy-input shadow-none @error('receiver_phone') is-invalid @enderror" value="{{ old('receiver_phone') }}">
                </div>
                <div class="mb-5 position-relative pb-3">
                    <label class="small text-muted text-uppercase fw-bold">Shipping Address</label>
                    <textarea name="receiver_address" class="form-control fancy-input shadow-none @error('receiver_address') is-invalid @enderror" rows="3" placeholder="Full Street Address">{{ old('receiver_address') }}</textarea>
                </div>
                <button type="submit" class="btn btn-confirm w-100 text-uppercase fw-bold">Confirm Order</button>
            </form>
        </div>
    </div>
    @endif
</div>

<script data-navigate-once>
document.addEventListener('livewire:navigated', function() {
    // 1. Image Switcher (no change needed here)
    window.changeMainImage = function(src, thumb) {
        const mainImg = document.getElementById('mainProductImage');
        mainImg.style.opacity = '0';
        setTimeout(() => {
            mainImg.src = src;
            mainImg.style.opacity = '1';
        }, 300);
        $('.thumb-box').removeClass('border-success');
        $(thumb).addClass('border-success');
    };

    // 2. AJAX Form Submission
    const cartForm = document.getElementById('addToCartForm');
    
    if (cartForm) {
        cartForm.addEventListener('submit', function(e) {
            e.preventDefault(); // CRITICAL: This stops the page reload

            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalContent = submitBtn.innerHTML;

            // Visual feedback: disable button
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';

            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest', // Tells Laravel it's an AJAX request
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                }
            })
            .then(response => {
                if (response.status === 401) {
                    window.location.href = "{{ route('login.show') }}";
                    return;
                }
                return response.json();
            })
            .then(data => {
                if (data && data.success) {
                    // Update the cart badge (ensure your navbar badge has id="cart-count")
                    const badge = document.getElementById('cart-count');
                    if (badge) {
                        badge.innerText = data.newCount;
                        badge.classList.remove('d-none'); // Show if it was hidden
                    }

                    // Success animation on button
                    submitBtn.innerHTML = '<i class="bi bi-check2"></i> ADDED';
                    submitBtn.classList.replace('btn-success', 'btn-dark');

                    setTimeout(() => {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalContent;
                        submitBtn.classList.replace('btn-dark', 'btn-success');
                    }, 2000);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalContent;
            });
        });
    }

    // 3. Qty +/- Buttons (no refresh logic)
    const qtyInput = document.getElementById('product-qty');
    const plusBtn = document.getElementById('plus-btn');
    const minusBtn = document.getElementById('minus-btn');

    if (qtyInput && plusBtn) {
        plusBtn.onclick = () => {
            let val = parseInt(qtyInput.value) || 1;
            if (val < qtyInput.max) qtyInput.value = val + 1;
        };
        minusBtn.onclick = () => {
            let val = parseInt(qtyInput.value) || 1;
            if (val > 1) qtyInput.value = val - 1;
        };
    }
});
</script>

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
        border-bottom-color: var(--luxury-dark);
    }
    
    .table th { font-weight: 600; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 1.5px; border: none; color: #888; }
    .table td { border-bottom: 1px solid #f0f0f0; padding: 25px 0; }
    
    .btn-confirm {
        background: var(--forest);
        color:white;
        border-radius: 5px;
        padding: 10px;
        letter-spacing: 2px;
        font-size: 0.8rem;
        transition: all 0.3s;
        border: 1px solid var(--forest);
    }
    .btn-confirm:hover {
        background: var(--forest);
        color:white;
    transform: translateY(-4px); 
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }

  .watch-img-container {
        position: relative;
        overflow: hidden;
        background: #fff;
        border-color: #f0f0f0 !important;
    }
    
</style>
@endsection