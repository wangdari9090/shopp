<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Luxury Watches')</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,700&family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    
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
                <li class="nav-item"><a class="nav-link custom-nav-link" href="#best-seller-section">Shop</a></li>
                <li class="nav-item"><a class="nav-link custom-nav-link" href="{{route('contact')}}">Contact</a></li>
            </ul>

            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('cart.index') }}" class="position-relative d-inline-block text-dark text-decoration-none mx-3">
    <i class="bi bi-cart serif fs-4"></i> @if($globalCartCount > 0)
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" 
              style="font-size: 0.6rem; padding: 0.35em 0.65em;">
            {{ $globalCartCount }}
        </span>
    @endif
</a>

                @auth
                    {{-- Show User Name --}}
                    <span class="fw-semibold text-dark small border-end pe-3 d-none d-md-inline">
                        Hi, {{ Auth::user()->name }}
                    </span>

                    {{-- Direct Logout Button --}}
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3 py-1 fw-bold" style="font-size: 0.75rem;">LOGOUT
                        </button>
                    </form>
                @else
                    <a href="{{ route('login.show') }}" class="btn btn-nav-theme px-4 rounded-pill fw-bold">Login</a>
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