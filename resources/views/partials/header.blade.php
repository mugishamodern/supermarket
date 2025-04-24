<!-- resources/views/partials/_header.blade.php -->
<header class="bg-white shadow-sm border-bottom">
    <!-- Top bar with contact info -->
    <div class="bg-dark text-white py-2">
        <div class="container d-flex justify-content-between align-items-center small">
            <div>
                <span class="me-3"><i class="fas fa-phone-alt me-1"></i> +256 123 456 789</span>
                <span><i class="fas fa-envelope me-1"></i> info@mukorasupermarket.com</span>
            </div>
            <div>
                @auth
                    <a href="{{ route('user.profile') }}" class="text-white me-3">My Account</a>
                    <a href="{{ route('orders.index') }}" class="text-white me-3">My Orders</a>
                @else
                    <a href="{{ route('login') }}" class="text-white me-3">Login</a>
                    <a href="{{ route('register') }}" class="text-white">Register</a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Main navbar -->
    <div class="container py-3">
        <div class="row align-items-center">
            <!-- Logo -->
            <div class="col-lg-3 col-md-3 col-6 mb-2 mb-md-0">
                <a href="{{ route('home') }}" class="d-flex align-items-center text-decoration-none">
                    <img src="/uploads/images/mukora-logo.png" alt="Mukora Supermarket" height="40" class="me-2">
                    <span class="h5 text-dark mb-0 d-none d-sm-inline fw-semibold">Mukora Supermarket</span>
                </a>
            </div>

            <!-- Search Bar -->
            <div class="col-lg-5 col-md-5 d-none d-md-block d-flex align-items-center" style="margin-top: 20px;">
                <form action="{{ route('products.index') }}" method="GET" class="d-flex">
                    <input type="text" name="search" class="form-control shadow-sm" placeholder="Search for products...">
                    <button type="submit" class="btn btn-outline-danger ms-2">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>

            <!-- Cart and Mobile Toggle -->
            <div class="col-lg-4 col-md-4 col-6 d-flex justify-content-end">
                <a href="{{ route('cart.index') }}" class="btn btn-outline-danger position-relative me-2">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="badge bg-danger position-absolute top-0 start-100 translate-middle">0</span>
                </a>

                <button class="navbar-toggler btn btn-outline-dark d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="navbar navbar-expand-md navbar-light border-top border-bottom bg-light py-1">
        <div class="container">
        <div class="collapse navbar-collapse show" id="navbarNav">
                <ul class="navbar-nav mx-auto py-2">
                    <li class="nav-item px-3">
                        <a class="nav-link {{ Request::is('/') ? 'active fw-bold text-danger' : 'text-dark' }}" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item px-3">
                        <a class="nav-link {{ Request::is('products*') ? 'active fw-bold text-danger' : 'text-dark' }}" href="{{ route('products.index') }}">Products</a>
                    </li>
                    <li class="nav-item px-3">
                        <a class="nav-link {{ Request::is('promotions*') ? 'active fw-bold text-danger' : 'text-dark' }}" href="{{ route('promotions') }}">Promotions</a>
                    </li>
                    <li class="nav-item px-3">
                        <a class="nav-link {{ Request::is('about*') ? 'active fw-bold text-danger' : 'text-dark' }}" href="{{ route('about') }}">About Us</a>
                    </li>
                    <li class="nav-item px-3">
                        <a class="nav-link {{ Request::is('contact*') ? 'active fw-bold text-danger' : 'text-dark' }}" href="{{ route('contact') }}">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Mobile Search -->
    <div class="container d-md-none py-2">
        <form action="{{ route('products.index') }}" method="GET" class="d-flex">
            <input type="text" name="search" class="form-control shadow-sm" placeholder="Search for products...">
            <button type="submit" class="btn btn-outline-danger ms-2">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>
</header>
