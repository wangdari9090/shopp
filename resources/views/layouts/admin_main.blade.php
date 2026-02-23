<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    @vite(['resources/css/admin.css', 'resources/js/admin.js'])
    <style>
        .nav-link.active { background-color: rgba(255,255,255,0.1); font-weight: bold; }
        .submenu .nav-link.active { color: #fff !important; background: none; text-decoration: underline; }
    </style>
</head>
<body>

<nav id="sidebar">
    <div class="sidebar-header">
        <span class="logo-icon">TP</span>
        <span class="logo-text">TIMEPIECE</span>
    </div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="nav-link ajax-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2"></i> <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#categoryMenu">
                <div><i class="bi bi-folder2"></i> <span>Categories</span></div>
                <i class="bi bi-chevron-down arrow-icon"></i>
            </a>
            <div class="collapse {{ request()->is('admin/categories*') ? 'show' : '' }}" id="categoryMenu">
                <ul class="nav flex-column submenu">
                    <li><a href="{{ route('admin.categories.index') }}" class="nav-link ajax-link {{ request()->is('admin/categories') ? 'active' : '' }}">View Categories</a></li>
                    <li><a href="{{ route('admin.categories.create') }}" class="nav-link ajax-link {{ request()->is('admin/categories/create') ? 'active' : '' }}">Add Category</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#productMenu">
                <div><i class="bi bi-watch"></i> <span>Products</span></div>
                <i class="bi bi-chevron-down arrow-icon"></i>
            </a>
            <div class="collapse {{ request()->is('admin/products*') ? 'show' : '' }}" id="productMenu">
                <ul class="nav flex-column submenu">
                    <li><a href="{{ route('admin.products.index') }}" class="nav-link ajax-link {{ request()->is('admin/products') ? 'active' : '' }}">View Products</a></li>
                    <li><a href="{{ route('admin.products.create') }}" class="nav-link ajax-link {{ request()->is('admin/products/create') ? 'active' : '' }}">Add Product</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.orders.index') }}" class="nav-link ajax-link {{ request()->is('admin/orders*') ? 'active' : '' }}">
                <i class="bi bi-bag-check"></i> <span>Orders</span>
            </a>
        </li>
    </ul>
</nav>

<div id="main-wrapper">
    <header class="top-bar d-flex justify-content-between align-items-center px-3">
        <button id="toggleBtn" class="btn"><i class="bi bi-list fs-4"></i></button>
        <div class="user-profile">
            @auth
                <div class="d-flex align-items-center gap-3">
                    <span class="fw-semibold text-dark small d-none d-md-inline border-end pe-3">Hi, {{ Auth::user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">LOGOUT</button>
                    </form>
                </div>
            @endauth
        </div>
    </header>
    <main class="content-body">@yield('content')</main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function initBootstrap() {
    document.querySelectorAll('.dropdown-toggle').forEach(el => new bootstrap.Dropdown(el));
    document.querySelectorAll('.modal').forEach(el => new bootstrap.Modal(el));
}

document.addEventListener('click', function (e) {
    const link = e.target.closest('.ajax-link, .pagination a');
    if (!link) return;

    e.preventDefault();
    const url = link.getAttribute('href');
    const contentArea = document.querySelector('.content-body');
    if (!url || url === '#' || !contentArea) return;

    fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(res => res.ok ? res.text() : Promise.reject())
        .then(html => {
            contentArea.innerHTML = html;
            window.history.pushState({path: url}, '', url);
            window.scrollTo(0, 0);
            initBootstrap();

            document.querySelectorAll('#sidebar .nav-link').forEach(el => el.classList.remove('active'));
            link.classList.add('active');
            
            const parentCollapse = link.closest('.collapse');
            if (parentCollapse) {
                const toggle = document.querySelector(`[href="#${parentCollapse.id}"]`);
                if (toggle) toggle.classList.add('active');
            }
        })
        .catch(() => window.location.href = url);
});

window.onpopstate = () => location.reload();
</script>
</body>
</html>