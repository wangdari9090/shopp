<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    @vite(['resources/css/admin.css', 'resources/js/admin.js'])
</head>
<body>

<nav id="sidebar">
    <div class="sidebar-header">
        <span class="logo-icon">TP</span>
        <span class="logo-text">TIMEPIECE</span>
    </div>
    
    <ul class="nav flex-column">
        <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link d-flex justify-content-between align-items-center" 
               data-bs-toggle="collapse" href="#categoryMenu" role="button" aria-expanded="false">
                <div>
                    <i class="bi bi-folder2"></i>
                    <span>Categories</span>
                </div>
                <i class="bi bi-chevron-down arrow-icon"></i>
            </a>
            <div class="collapse" id="categoryMenu">
                <ul class="nav flex-column submenu">
                    <li><a href="{{ route('admin.categories.index') }}" class="nav-link"><i class="bi bi-list-ul"></i> View Categories</a></li>
                    <li><a href="{{ route('admin.categories.create') }}" class="nav-link"><i class="bi bi-plus-circle"></i> Add Category</a></li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link d-flex justify-content-between align-items-center" 
               data-bs-toggle="collapse" href="#productMenu" role="button" aria-expanded="false">
                <div>
                    <i class="bi bi-watch"></i>
                    <span>Products</span>
                </div>
                <i class="bi bi-chevron-down arrow-icon"></i>
            </a>
            <div class="collapse" id="productMenu">
                <ul class="nav flex-column submenu">
                    <li><a href="{{ route('admin.products.index') }}" class="nav-link"><i class="bi bi-list-ul"></i> View Products</a></li>
                    <li><a href="{{ route('admin.products.create') }}" class="nav-link"><i class="bi bi-plus-circle"></i> Add Product</a></li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a href="{{ route('orders.index') }}" class="nav-link">
                <i class="bi bi-bag-check"></i>
                <span>Orders</span>
            </a>
        </li>
    </ul>
</nav>

    <div id="main-wrapper">
        <header class="top-bar">
            <button id="toggleBtn">
                <i class="bi bi-list"></i>
            </button>
            <div class="user-profile">
                <div class="d-flex align-items-center gap-3">
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
        </header>

        <main class="content-body">
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>