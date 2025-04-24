<!-- resources/views/partials/_header.blade.php -->
<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="\uploads\images\mukora-logo.png" alt="Mukora Supermarket" height="40">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('products*') ? 'active' : '' }}" href="{{ route('products') }}">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('promotions*') ? 'active' : '' }}" href="{{ route('promotions') }}">Promotions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('about*') ? 'active' : '' }}" href="{{ route('about') }}">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('contact*') ? 'active' : '' }}" href="{{ route('contact') }}">Contact</a>
                    </li>
                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-danger btn-sm" href="{{ route('cart') }}">
                            <i class="fas fa-shopping-cart me-1"></i> Cart
                            <span class="badge bg-light text-dark ms-1">0</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>