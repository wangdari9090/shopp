<nav class="navbar navbar-expand-lg navbar-expand-md shadow-sm fixed-top">
    <div class="container">
        <a class="navbar-brand fw-bold fs-3" href="{{ route('index') }}">MyShop</a>

        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse text-center" id="navbarNav">
            <ul class="navbar-nav ms-auto gap-lg-4">
                <li class="nav-item"><a class="nav-link fs-6" href="{{ route('index') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link fs-6" href="#">Shop</a></li>
                <li class="nav-item"><a class="nav-link fs-6" href="#">Categories</a></li>
                <li class="nav-item"><a class="nav-link fs-6" href="#">Contact</a></li>
                <li class="nav-item position-relative">
                    <a href="{{ route('viewcart', 'id') }}" class="nav-link p-0 position-relative d-inline-block">

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
                @if(Auth::check())
                    <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a></li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                    <li class="nav-item"><a class="nav-link btn btn-primary px-3 rounded-pill" href="{{ route('register') }}">Sign Up</a></li>
                @endif
            </ul>
        </div>
    </div>
</nav>

<nav class="sidebar" id="adminSidebar">
    <h4 class="text-center text-white mb-4 fw-bold pt-3">Admin Panel</h4>

    <ul class="nav flex-column px-2">

        <!-- Dashboard -->
        <li class="nav-item mb-1">
            <a class="nav-link text-white sidebar-link" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
        </li>

        <!-- Category Dropdown -->
        <li class="nav-item mb-1">
            <a class="nav-link text-white sidebar-link dropdown-toggle" data-bs-toggle="collapse" href="#categoryMenu">
                <i class="bi bi-tags me-2"></i> Categories
            </a>

            <ul class="collapse list-unstyled ps-4" id="categoryMenu">
                <li><a href="{{ route('admin.addcategory') }}" class="dropdown-item-side">➤ Add Category</a></li>
                <li><a href="{{ route('admin.viewcategory') }}" class="dropdown-item-side">➤ View Categories</a></li>
            </ul>
        </li>

        <!-- Users -->
        <li class="nav-item mb-1">
            <a class="nav-link text-white sidebar-link dropdown-toggle" data-bs-toggle="collapse" href="#usersMenu">
                <i class="bi bi-people me-2"></i> Users
            </a>
            <ul class="collapse list-unstyled ps-4" id="usersMenu">
                <li><a href="#" class="dropdown-item-side">➤ All Users</a></li>
                <li><a href="#" class="dropdown-item-side">➤ Add User</a></li>
            </ul>
        </li>

        <!-- Products -->
        <li class="nav-item mb-1">
            <a class="nav-link text-white sidebar-link dropdown-toggle" data-bs-toggle="collapse" href="#productMenu">
                <i class="bi bi-box-seam me-2"></i> Products
            </a>
            <ul class="collapse list-unstyled ps-4" id="productMenu">
                <li><a href="{{ route('admin.addproduct') }}" class="dropdown-item-side">➤ Add Product</a></li>
                <li><a href="{{ route('admin.viewproduct') }}" class="dropdown-item-side">➤ View Products</a></li>
            </ul>
        </li>

        <!-- Orders -->
        <li class="nav-item mb-1">
            <a class="nav-link text-white sidebar-link" href="#">
                <i class="bi bi-basket me-2"></i> Orders
            </a>
        </li>

        <!-- Logout -->
        <li class="nav-item mt-3 px-2">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-danger w-100">Logout</button>
            </form>
        </li>

    </ul>
</nav>
