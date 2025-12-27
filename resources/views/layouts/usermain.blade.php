<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Luxury Watches')</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,700&family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-white">

    <nav class="navbar home-nav navbar-expand-lg sticky-top py-4">
    <div class="container">
        <a class="navbar-brand fw-black text-forest tracking-widest" href="/">TIMEPIECE</a>

        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav mx-auto gap-lg-4">
                <li class="nav-item"><a class="nav-link custom-nav-link" href="/">Home</a></li>
                <li class="nav-item"><a class="nav-link custom-nav-link" href="/shop">Shop</a></li>
                <li class="nav-item"><a class="nav-link custom-nav-link" href="/contact">Contact</a></li>
            </ul>

            <div class="d-flex align-items-center gap-4">
                <a href="/cart" class="nav-icon-themed position-relative">
                    <i class="bi bi-cart3"></i>
                    {{-- <span class="cart-badge-dot"></span> --}}
                </a>

                @auth
                <div class="dropdown">
                    <a href="#" class="nav-icon-themed dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="bi bi-person"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-3">
                        <li><a class="dropdown-item py-2 fw-bold" href="">My Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
                @else
                <a href="{{ route('login.show') }}" class="btn btn-nav-theme">Login</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

    <main>
        @yield('hero')
        @yield('content')
    </main>

    <footer class="py-5 border-top text-center text-muted">
        <p>&copy; 2025 Luxury Watches. All rights reserved.</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>