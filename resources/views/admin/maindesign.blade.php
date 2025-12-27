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
    
    @vite('resources/css/app.css', 'resources/js/app.js')
    <!-- custom CSS -->
    {{-- <link href="{{ asset('css/admin.css') }}" rel="stylesheet"> --}}
    {{-- @stack('styles') --}}
</head>
<body>
<div class="d-flex">
    <!-- Sidebar -->

    @include('admin.sidebar')
    <!-- Main content -->
    {{-- <div class="flex-grow-1 p-4">
        <h2>@yield('page-title', 'Dashboard')</h2>
        <hr>
        @yield('dashboard')
        @yield('add_category')
        @yield('view_category')
        @yield('update_category')
        @yield('add_product')
        @yield('view_product')
        @yield('update_product')
        @yield('view_orders')
    </div> --}}
</div>
<!-- Footer -->
{{-- <footer class="text-center text-white fixed-bottom bg-dark py-3 align-items-center p-4 mt-5">
    <p class="mb-1">&copy; 2025 MyShop. All Rights Reserved.</p>

    <div>
        <i class="bi bi-facebook"></i>
        <i class="bi bi-twitter"></i>
        <i class="bi bi-instagram"></i>
    </div>
</footer> --}}
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Auto-hide alerts (Bootstrap)
    setTimeout(() => {
        document.querySelectorAll('.alert').forEach(alert => {
            let bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 2000);
</script>
</body>
</html>
