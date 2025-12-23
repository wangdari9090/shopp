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
    @vite('resources/css/master.css')
    @vite('resources/css/hero.css')



</head>
<body>

@include('navbar')

@yield('hero')

<main class="pt-5 pb-5">
    <section class="container my-5">
        @yield('index')
        @yield('user_dashboard')
        @yield('login')
        @yield('register')
        @yield('product_details')
        @yield('view_cart')
        @yield('checkout')
        @yield('contact')
        @yield('category_products')
    </section>
</main>


<!-- Footer -->
<footer class="text-center text-white fixed-bottom bg-dark py-3 align-items-center p-4 mt-5">
    <p class="mb-1">&copy; 2025 MyShop. All Rights Reserved.</p>

    <div>
        <i class="bi bi-facebook"></i>
        <i class="bi bi-twitter"></i>
        <i class="bi bi-instagram"></i>
    </div>
</footer>

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
