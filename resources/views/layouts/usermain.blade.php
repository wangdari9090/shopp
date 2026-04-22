<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Luxury Watches')</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,700&family=Montserrat:wght@400;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    @livewireStyles
</head>

<body class="bg-white">

    <nav class="navbar home-nav navbar-expand-lg sticky-top py-4">
        <div class="container">
            <a class="navbar-brand fw-black text-forest tracking-widest" href="/" wire:navigate>TIMEPIECE</a>

            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse"
                data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav mx-auto gap-lg-4">
                    <li class="nav-item">
                        <a class="nav-link custom-nav-link" wire:navigate href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link custom-nav-link" href="#best-seller-section">Shop</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link custom-nav-link" wire:navigate href="{{route('contact')}}">Contact</a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-3">
                    @if(!Auth::check() || Auth::user()->user_type !== 'admin')
                        <a href="{{ route('cart.index') }}" wire:navigate
                            class="position-relative d-inline-block text-dark text-decoration-none mx-3">
                            <i class="bi bi-cart serif fs-4"></i>
                            <span id="cart-count"
                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                style="font-size: 0.6rem; padding: 0.35em 0.65em; {{ $globalCartCount > 0 ? '' : 'display: none;' }}">
                                {{ $globalCartCount }}
                            </span>
                        </a>
                    @endif
                    @auth
                        <span class="fw-semibold text-dark small border-end pe-3 d-none d-md-inline">
                            Hi, {{ Auth::user()->name }}
                        </span>
                        <form action="{{ route('logout') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3 py-1 fw-bold"
                                style="font-size: 0.75rem;">LOGOUT</button>
                        </form>
                    @else
                        <a href="{{ route('login.show') }}" wire:navigate
                            class="btn btn-nav-theme px-4 rounded-pill fw-bold">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main id="spa-main-wrapper">
        @yield('hero')
        @yield('content')
    </main>

    <footer class="py-5 border-top text-center text-muted">
        <p>&copy; 2025 Luxury Watches. All rights reserved.</p>
    </footer>

    @livewireScripts
    @stack('scripts')

    <script>
        function updateCartBadge(count) {
            const badge = document.getElementById('cart-count');
            localStorage.setItem('cart_count', count);

            if (badge) {
                badge.innerText = count;
                if (parseInt(count) > 0) {
                    badge.style.display = 'inline-block';
                } else {
                    badge.style.display = 'none';
                }
            }
        }

        document.addEventListener('livewire:navigated', () => {
            const savedCount = localStorage.getItem('cart_count');
            if (savedCount !== null) {
                const badge = document.getElementById('cart-count');
                if (badge) {
                    badge.innerText = savedCount;
                    badge.style.display = (parseInt(savedCount) > 0) ? 'inline-block' : 'none';
                }
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });

        if (localStorage.getItem('cart_count') === null) {
            localStorage.setItem('cart_count', '{{ $globalCartCount }}');
        }

        @guest
            localStorage.removeItem('cart_count');
        @endguest
        window.addEventListener('storage', (event) => {
            if (event.key === 'cart_updated' || event.key === 'cart_count') {
                updateCartBadge(event.newValue);
            }
        });
    </script>
</body>

</html>