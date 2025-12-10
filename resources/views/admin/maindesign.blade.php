<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- custom CSS -->
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    @stack('styles')
    <style>
        body {
            background-color: #f4f6f9;
        }
        .sidebar {
            background-color: #343a40;
            min-height: 100vh;
        }
        .sidebar .nav-link {
            color: #fff;
        }
        .sidebar .nav-link:hover {
            background-color: #495057;
            border-radius: 5px;
        }
        .card-icon {
            font-size: 2rem;
        }
    </style>
</head>
<body>
<div class="d-flex">
    <!-- Sidebar -->
    <nav class="sidebar p-3 flex-shrink-0" style="width: 220px;">
        <h4 class="text-center text-white mb-4">Admin Panel</h4>
        <ul class="nav flex-column">
            <li class="nav-item mb-2">
                <a class="nav-link text-white d-flex align-items-center" href="">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link text-white d-flex align-items-center" href="#">
                    <i class="bi bi-people me-2"></i> Users
                </a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link text-white d-flex align-items-center" href="#">
                    <i class="bi bi-box-seam me-2"></i> Products
                </a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link text-white d-flex align-items-center" href="#">
                    <i class="bi bi-basket me-2"></i> Orders
                </a>
            </li>
            <li class="nav-item mt-3">
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
                {{-- <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger w-100">
                        <i class="bi bi-box-arrow-right me-1"></i> Logout
                    </button>
                </form> --}}
            </li>
        </ul>
    </nav>

    <!-- Main content -->
    <div class="flex-grow-1 p-4">
        <h2>@yield('page-title', 'Dashboard')</h2>
        <hr>
        @yield('content')
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
