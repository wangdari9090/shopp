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

    <style>
        body {
            background-color: #f8f9fa;
        }
        /* Hero Section */
        .hero {
            background: url('https://images.unsplash.com/photo-1612832020634-5d80bfc7e9ed?auto=format&fit=crop&w=1950&q=80') center/cover no-repeat;
            height: 500px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            position: relative;
        }
        .hero::after {
            content: "";
            position: absolute;
            top:0; left:0;
            width: 100%; height: 100%;
            background-color: rgba(0,0,0,0.5);
        }
        .hero-content {
            position: relative;
            z-index: 1;
        }
        .product-card {
            transition: transform 0.3s;
        }
        .product-card:hover {
            transform: translateY(-5px);
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold fs-3" href="#">MyShop</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Shop</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Categories</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Cart</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
                @if(Auth::check())
                <li class="nav-item"><a class="nav-link " href="{{ route('dashboard') }}">Dashboard</a></li>
                @else
                <li class="nav-item"><a class="nav-link " href="{{ route('login') }}">Login</a></li>
                <li class="nav-item"><a class="nav-link " href="{{ route('register') }}">Sign up</a></li>
                @endif
            </ul>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="hero mb-5">
    <div class="hero-content text-center">
        <h1 class="display-4 fw-bold">Discover Amazing Products</h1>
        <p class="lead">Best deals and latest products just for you.</p>
        <a href="#" class="btn btn-primary btn-lg mt-3">Shop Now</a>
    </div>
</section>

<!-- Products Section -->
<section class="container">
    <h2 class="mb-4 fw-bold">Featured Products</h2>
    <div class="row g-4">
        <!-- Product Card -->
        <div class="col-md-3">
            <div class="card product-card shadow-sm">
                <img src="https://images.unsplash.com/photo-1606813907025-9737bde20b2a?auto=format&fit=crop&w=400&q=80" class="card-img-top" alt="Product 1">
                <div class="card-body">
                    <h5 class="card-title">Product 1</h5>
                    <p class="card-text">$49.99</p>
                    <a href="#" class="btn btn-primary w-100">Add to Cart</a>
                </div>
            </div>
        </div>

        <!-- Product Card -->
        <div class="col-md-3">
            <div class="card product-card shadow-sm">
                <img src="https://images.unsplash.com/photo-1612831455541-efcb1733c38b?auto=format&fit=crop&w=400&q=80" class="card-img-top" alt="Product 2">
                <div class="card-body">
                    <h5 class="card-title">Product 2</h5>
                    <p class="card-text">$29.99</p>
                    <a href="#" class="btn btn-primary w-100">Add to Cart</a>
                </div>
            </div>
        </div>

        <!-- Product Card -->
        <div class="col-md-3">
            <div class="card product-card shadow-sm">
                <img src="https://images.unsplash.com/photo-1606813997594-39c928cf2e52?auto=format&fit=crop&w=400&q=80" class="card-img-top" alt="Product 3">
                <div class="card-body">
                    <h5 class="card-title">Product 3</h5>
                    <p class="card-text">$59.99</p>
                    <a href="#" class="btn btn-primary w-100">Add to Cart</a>
                </div>
            </div>
        </div>

        <!-- Product Card -->
        <div class="col-md-3">
            <div class="card product-card shadow-sm">
                <img src="https://images.unsplash.com/photo-1581291518857-4e27b48ff24e?auto=format&fit=crop&w=400&q=80" class="card-img-top" alt="Product 4">
                <div class="card-body">
                    <h5 class="card-title">Product 4</h5>
                    <p class="card-text">$39.99</p>
                    <a href="#" class="btn btn-primary w-100">Add to Cart</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-dark text-white mt-5 py-4">
    <div class="container text-center">
        <p>&copy; 2025 MyShop. All Rights Reserved.</p>
        <div class="mt-2">
            <i class="bi bi-facebook me-2"></i>
            <i class="bi bi-twitter me-2"></i>
            <i class="bi bi-instagram"></i>
        </div>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
