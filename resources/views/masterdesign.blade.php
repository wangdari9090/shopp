<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyShop - Home</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    @vite('resources/css/app.css')

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fa;
        }

    </style>

</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg shadow-sm fixed-top">
    <div class="container">
        <a class="navbar-brand fw-bold fs-3" href="#">MyShop</a>

        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse text-center" id="navbarNav">
            <ul class="navbar-nav ms-auto gap-lg-4">
                <li class="nav-item"><a class="nav-link fs-6" href="{{ route('index') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link fs-6" href="#">Shop</a></li>
                <li class="nav-item"><a class="nav-link fs-6" href="#">Categories</a></li>
                <li class="nav-item"><a class="nav-link fs-6" href="#">Contact</a></li>

                @if(Auth::check())
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                    <li class="nav-item"><a class="nav-link btn btn-primary px-3 rounded-pill" href="{{ route('register') }}">Sign Up</a></li>
                @endif
            </ul>
        </div>
    </div>
</nav>

<section class="container my-5">
    @yield('index')
    @yield('product_details')
</section>

<!-- Footer -->
<footer class="text-center text-white">
    <p class="mb-1">&copy; 2025 MyShop. All Rights Reserved.</p>

    <div>
        <i class="bi bi-facebook"></i>
        <i class="bi bi-twitter"></i>
        <i class="bi bi-instagram"></i>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
