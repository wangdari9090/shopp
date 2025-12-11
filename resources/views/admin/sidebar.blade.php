<nav class="sidebar p-3 flex-shrink-0" id="adminSidebar">
    <h4 class="text-center text-white mb-4 fw-bold">Admin Panel</h4>

    <ul class="nav flex-column">

        <!-- Dashboard -->
        <li class="nav-item mb-1">
            <a class="nav-link text-white d-flex align-items-center sidebar-link" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
        </li>

        <!-- Category Dropdown -->
        <li class="nav-item mb-1">
            <a class="nav-link text-white d-flex align-items-center sidebar-link dropdown-toggle" data-bs-toggle="collapse" href="#categoryMenu">
                <i class="bi bi-tags me-2"></i> Categories
            </a>

            <ul class="collapse list-unstyled ps-4" id="categoryMenu">
                <li><a href="{{ route('admin.addcategory') }}" class="dropdown-item-side">➤ Add Category</a></li>
                <li><a href="{{ route('admin.viewcategory') }}" class="dropdown-item-side">➤ View Categories</a></li>
            </ul>
        </li>

        <!-- Users Dropdown -->
        <li class="nav-item mb-1">
            <a class="nav-link text-white d-flex align-items-center sidebar-link dropdown-toggle" data-bs-toggle="collapse" href="#usersMenu">
                <i class="bi bi-people me-2"></i> Users
            </a>

            <ul class="collapse list-unstyled ps-4" id="usersMenu">
                <li><a href="#" class="dropdown-item-side">➤ All Users</a></li>
                <li><a href="#" class="dropdown-item-side">➤ Add User</a></li>
            </ul>
        </li>

        <!-- Products Dropdown -->
        <li class="nav-item mb-1">
            <a class="nav-link text-white d-flex align-items-center sidebar-link dropdown-toggle" data-bs-toggle="collapse" href="#productMenu">
                <i class="bi bi-box-seam me-2"></i> Products
            </a>

            <ul class="collapse list-unstyled ps-4" id="productMenu">
                <li><a href="{{ route('admin.addproduct') }}" class="dropdown-item-side">➤ Add Product</a></li>
                <li><a href="{{ route('admin.viewproduct') }}" class="dropdown-item-side">➤ View Products</a></li>
            </ul>
        </li>

        <!-- Orders -->
        <li class="nav-item mb-1">
            <a class="nav-link text-white d-flex align-items-center sidebar-link" href="#">
                <i class="bi bi-basket me-2"></i> Orders
            </a>
        </li>

        <!-- Logout -->
        <li class="nav-item mt-3">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-danger w-100">Logout</button>
            </form>
        </li>

    </ul>
</nav>
