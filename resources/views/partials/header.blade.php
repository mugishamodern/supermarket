<!-- resources/views/partials/_header.blade.php -->
<header class="bg-white shadow-sm">
    <!-- Main header with search -->
    <div class="container py-3">
        <div class="row align-items-center">
            <!-- Toggle button for mobile -->
            <div class="col-auto d-md-none">
                <button class="btn border-0" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <i class="fas fa-bars"></i>
                </button>
            </div>

            <!-- Logo -->
            <div class="col-auto">
                <a href="{{ route('home') }}" class="text-decoration-none">
                    <img src="/udploads/images/mukora-logo.png" alt="Mukora Supermarket" height="35">
                </a>
            </div>

            <!-- Search Bar -->
            <div class="col">
                <form action="{{ route('products.index') }}" method="GET" class="d-flex">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control border-end-0" placeholder="Search products, brands and categories">
                        <button type="submit" class="btn btn-warning text-white px-4">
                            Search
                        </button>
                    </div>
                </form>
            </div>

            <!-- Account -->
            <div class="col-auto ms-3">
                <div class="dropdown">
                    <a href="#" class="text-decoration-none text-dark d-flex align-items-center" data-bs-toggle="dropdown">
                        <i class="far fa-user-circle me-2 fs-4"></i>
                        <div class="d-none d-lg-block">
                            <span>Account</span>
                            <i class="fas fa-chevron-down small ms-1"></i>
                        </div>
                    </a>
                    <ul class="dropdown-menu shadow">
                        @auth
                            <li><a class="dropdown-item" href="{{ route('user.profile') }}">My Profile</a></li>
                            <li><a class="dropdown-item" href="{{ route('orders.index') }}">My Orders</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        @else
                            <li><a class="dropdown-item" href="{{ route('login') }}">Login</a></li>
                            <li><a class="dropdown-item" href="{{ route('register') }}">Register</a></li>
                        @endauth
                    </ul>
                </div>
            </div>

            <!-- Help -->
            <div class="col-auto d-none d-lg-block">
                <div class="dropdown">
                    <a href="#" class="text-decoration-none text-dark d-flex align-items-center" data-bs-toggle="dropdown">
                        <i class="far fa-question-circle me-2 fs-4"></i>
                        <span>Help</span>
                        <i class="fas fa-chevron-down small ms-1"></i>
                    </a>
                    <ul class="dropdown-menu shadow">
                        <li><a class="dropdown-item" href="#">Customer Service</a></li>
                        <li><a class="dropdown-item" href="#">FAQs</a></li>
                        <li><a class="dropdown-item" href="{{ route('contact') }}">Contact Us</a></li>
                    </ul>
                </div>
            </div>

            <!-- Cart -->
            <div class="col-auto">
                <a href="{{ route('cart.index') }}" class="text-decoration-none text-dark d-flex align-items-center">
                    <div class="position-relative">
                        <i class="fas fa-shopping-cart fs-4"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark">
                            0
                        </span>
                    </div>
                    <span class="ms-2 d-none d-lg-inline">Cart</span>
                </a>
            </div>
        </div>
    </div>

   <!-- Categories Navigation -->
<nav class="navbar navbar-expand-md navbar-light bg-white border-top">
    <div class="container">
        <!-- Mobile Toggle Button (Missing in original) -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                @php
                    $navItems = [
                        ['route' => 'home', 'name' => 'Home', 'path' => '/'],
                        ['route' => 'products.index', 'name' => 'Products', 'path' => 'products*'],
                        ['route' => 'promotions', 'name' => 'Promotions', 'path' => 'promotions*'], 
                        ['route' => 'about', 'name' => 'About Us', 'path' => 'about*'],
                        ['route' => 'contact', 'name' => 'Contact', 'path' => 'contact*']
                    ];
                @endphp
                
                @foreach($navItems as $item)
                    <li class="nav-item mx-2">
                        <a class="nav-link {{ Request::is($item['path']) ? 'active fw-bold' : '' }}" 
                           href="{{ route($item['route']) }}">
                            {{ $item['name'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</nav>
    <!-- Breadcrumb Navigation -->
<div class="breadcrumb-container py-2 bg-light border-bottom">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb m-0" style="--bs-breadcrumb-divider: '>';">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}" class="text-decoration-none text-muted small">Home</a>
                </li>
                
                @if(isset($breadcrumbs) && is_array($breadcrumbs))
                    @foreach($breadcrumbs as $breadcrumb)
                        @if($loop->last)
                            <li class="breadcrumb-item active small" aria-current="page">
                                {{ $breadcrumb['name'] }}
                            </li>
                        @else
                            <li class="breadcrumb-item">
                                <a href="{{ $breadcrumb['url'] }}" class="text-decoration-none text-muted small">
                                    {{ $breadcrumb['name'] }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                @elseif(isset($category))
                    <li class="breadcrumb-item active small" aria-current="page">
                        {{ $category->name }}
                    </li>
                @elseif(isset($product))
                    @if(isset($product->category))
                        <li class="breadcrumb-item">
                            <a href="{{ route('products.category', $product->category->slug) }}" class="text-decoration-none text-muted small">
                                {{ $product->category->name }}
                            </a>
                        </li>
                    @endif
                    <li class="breadcrumb-item active small" aria-current="page">
                        {{ $product->name }}
                    </li>
                @elseif(isset($title))
                    <li class="breadcrumb-item active small" aria-current="page">
                        {{ $title }}
                    </li>
                @endif
            </ol>
        </nav>
    </div>
</div>
</header>