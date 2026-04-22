<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Luxury Watches')</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,700&family=Montserrat:wght@400;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')

</head>

<body class="bg-white">

    <nav class="navbar home-nav navbar-expand-lg sticky-top py-4">
        <div class="container">
            <a class="navbar-brand fw-black text-forest tracking-widest" href="/">TIMEPIECE</a>

            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse"
                data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav mx-auto gap-lg-4">
                    <li class="nav-item">
                        <a class="nav-link custom-nav-link" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link custom-nav-link" href="#best-seller-section">Shop</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link custom-nav-link" href="{{route('contact')}}">Contact</a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-3">
                    @if(!Auth::check() || Auth::user()->user_type !== 'admin')
                        <a href="{{ route('cart.index') }}"
                            class="position-relative d-inline-block text-dark text-decoration-none mx-3">
                            <i class="bi bi-cart serif fs-4"></i>
                            <span id="cart-count"
                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                style="font-size: 0.6rem; padding: 0.35em 0.65em; {{ $globalCartCount > 0 ? '' : 'display: none;' }}">
                                {{ $globalCartCount }}
                            </span>
                        </a>
                    @endif
                    @auth
                        <span class="fw-semibold text-dark small border-end pe-3 d-none d-md-inline">
                            Hi, {{ Auth::user()->name }}
                        </span>
                        <form action="{{ route('logout') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3 py-1 fw-bold"
                                style="font-size: 0.75rem;">LOGOUT</button>
                        </form>
                    @else
                        <a href="{{ route('login.show') }}" class="btn btn-nav-theme px-4 rounded-pill fw-bold">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main id="spa-main-wrapper">
        @yield('hero')
        @yield('content')
    </main>

    <footer class="py-5 border-top text-center text-muted">
        <p>&copy; 2025 Luxury Watches. All rights reserved.</p>
    </footer>


    @stack('scripts')

    <style>
        #spa-loading-bar {
            position: fixed;
            top: 0;
            left: 0;
            height: 3px;
            z-index: 99999;
            background: linear-gradient(90deg, #198754, #b19470);
            width: 0;
            pointer-events: none;
            transition: width 0.4s ease;
        }
    </style>
    <div id="spa-loading-bar"></div>

    <script>
        /* ── Global helpers ── */
        function updateCartBadge(count) {
            const badge = document.getElementById('cart-count');
            localStorage.setItem('cart_count', count);
            if (badge) {
                badge.innerText = count;
                badge.style.display = parseInt(count) > 0 ? 'inline-block' : 'none';
            }
        }

        function _spaPostNavigate() {
            // Sync cart badge from localStorage
            const saved = localStorage.getItem('cart_count');
            if (saved !== null) {
                const badge = document.getElementById('cart-count');
                if (badge) {
                    badge.innerText = saved;
                    badge.style.display = parseInt(saved) > 0 ? 'inline-block' : 'none';
                }
            }
            // CSRF for jQuery
            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
            // Bootstrap carousels
            document.querySelectorAll('.carousel').forEach(el => {
                try { bootstrap.Carousel.getOrCreateInstance(el).cycle(); } catch (e) { }
            });
        }

        // Initial cart setup
        if (localStorage.getItem('cart_count') === null) {
            localStorage.setItem('cart_count', '{{ $globalCartCount }}');
        }
        @guest
            localStorage.removeItem('cart_count');
        @endguest

        window.addEventListener('storage', (event) => {
            if (event.key === 'cart_updated' || event.key === 'cart_count') {
                updateCartBadge(event.newValue);
            }
        });

        /* ── SPA Navigation System ── */
        (function () {
            const mainEl = document.getElementById('spa-main-wrapper');
            const bar = document.getElementById('spa-loading-bar');
            if (!mainEl) return;

            // Store initial state
            history.replaceState({ spaUrl: location.href }, document.title, location.href);

            function showBar() { bar.style.width = '0'; requestAnimationFrame(() => bar.style.width = '70%'); }
            function hideBar() { bar.style.width = '100%'; setTimeout(() => bar.style.width = '0', 350); }

            function execScripts(container) {
                container.querySelectorAll('script').forEach(old => {
                    const s = document.createElement('script');
                    [...old.attributes].forEach(a => s.setAttribute(a.name, a.value));
                    s.textContent = old.textContent;
                    old.parentNode.replaceChild(s, old);
                });
            }

            function isLocal(link) {
                const href = link.getAttribute('href');
                if (!href || href === '#' || href.startsWith('#') || href.startsWith('javascript:')
                    || href.startsWith('mailto:') || href.startsWith('tel:')) return false;
                if (link.target === '_blank' || link.hasAttribute('download')) return false;
                try { return new URL(link.href, location.origin).origin === location.origin; }
                catch { return false; }
            }

            function navigate(url, push) {
                showBar();
                fetch(url, { credentials: 'same-origin', headers: { 'Accept': 'text/html' } })
                    .then(r => {
                        if (r.redirected) { window.location.href = r.url; return null; }
                        if (!r.ok) throw new Error(r.status);
                        return r.text();
                    })
                    .then(html => {
                        if (!html) return;
                        const doc = new DOMParser().parseFromString(html, 'text/html');

                        // Swap title
                        document.title = doc.title || 'Luxury Watches';

                        // Update CSRF
                        const nc = doc.querySelector('meta[name="csrf-token"]');
                        if (nc) document.querySelector('meta[name="csrf-token"]').content = nc.content;

                        // Swap main content
                        const newMain = doc.getElementById('spa-main-wrapper');
                        if (newMain) {
                            mainEl.innerHTML = newMain.innerHTML;
                            execScripts(mainEl);
                        }

                        // Update nav (cart badge, login state)
                        const newNav = doc.querySelector('nav.home-nav');
                        const curNav = document.querySelector('nav.home-nav');
                        if (newNav && curNav) curNav.innerHTML = newNav.innerHTML;

                        if (push) history.pushState({ spaUrl: url }, document.title, url);

                        // Scroll
                        const hash = new URL(url, location.origin).hash;
                        if (hash) {
                            const t = document.querySelector(hash);
                            if (t) t.scrollIntoView({ behavior: 'smooth' });
                        } else {
                            window.scrollTo({ top: 0, behavior: 'instant' });
                        }

                        _spaPostNavigate();
                        hideBar();
                    })
                    .catch(err => { console.error('SPA nav failed:', err); hideBar(); window.location.href = url; });
            }

            // Intercept link clicks
            document.addEventListener('click', function (e) {
                // Don't intercept if inside a form (like logout)
                if (e.target.closest('form')) return;
                const link = e.target.closest('a');
                if (!link) return;
                const href = link.getAttribute('href');
                if (href && href.startsWith('#')) return;
                if (isLocal(link)) {
                    e.preventDefault();
                    if (link.href !== location.href) navigate(link.href, true);
                }
            });

            // Back / Forward
            window.addEventListener('popstate', function (e) {
                if (e.state && e.state.spaUrl) navigate(e.state.spaUrl, false);
            });

            // Expose for programmatic SPA navigation (e.g. after AJAX form submissions)
            window._spaNavigate = function(url) { navigate(url, true); };

            // Run post-navigate on first load
            _spaPostNavigate();
        })();
    </script>
</body>

</html>