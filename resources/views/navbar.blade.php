
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-expand-md shadow-sm fixed-top">
    <div class="container">
        <a class="navbar-brand fw-bold fs-3" href="{{ route('home') }}">MyShop</a>

        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse text-center" id="navbarNav">
            <ul class="navbar-nav ms-auto gap-lg-4">
                <li class="nav-item"><a class="nav-link fs-6" href="{{ route('home') }}">Home</a></li>
                {{-- <li class="nav-item"><a class="nav-link fs-6" href="#">Shop</a></li> --}}
                {{-- <li class="nav-item"><a class="nav-link fs-6" href="#">Categories</a></li> --}}
                <li class="nav-item"><a class="nav-link fs-6" href="{{ route('contact') }}">Contact</a></li>
                
                @if(Auth::check())
                    <li class="nav-item"><a class="nav-link" href="{{ route('user.dashboard') }}">Dashboard</a></li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                    {{-- <li class="nav-item"><a class="nav-link btn btn-primary px-3 rounded-pill" href="{{ route('register') }}">Sign Up</a></li> --}}
                @endif
                <li class="nav-item position-relative">
                    <a href="{{ route('cart.view', 'id') }}" class="nav-link p-0 position-relative d-inline-block">

                        <!-- Cart Icon -->
                        <i class="bi bi-cart fs-4"></i>

                        <!-- Badge -->
                        @if(isset($count) && $count > 0)
                        <span class="cart-badge badge bg-danger rounded-pill">
                            {{ $count }}
                        </span>
                        @endif

                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>