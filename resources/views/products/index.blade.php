@extends('layouts.app')
@section('title', 'Shop Products - Mukora Supermarket')

@section('styles')
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f8f9fa;
    }

    .hero-section {
        background: linear-gradient(135deg, #dc3545, #f8f9fa);
        color: white;
        padding: 60px 0;
        text-align: center;
        border-radius: 10px;
        margin-bottom: 40px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .hero-section h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .hero-section p {
        font-size: 1.2rem;
        opacity: 0.9;
    }

    .search-bar {
        max-width: 500px;
        margin: 20px auto;
    }

    .search-bar input {
        border-radius: 25px;
        height: 50px;
        border: 1px solid #ddd;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .search-bar input:focus {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }

    .sidebar {
        position: sticky;
        top: 100px;
    }

    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 10px;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15) !important;
    }

    .category-list a {
        transition: color 0.3s ease, padding-left 0.3s ease;
    }

    .category-list a:hover,
    .category-list a.active {
        color: #dc3545 !important;
        padding-left: 10px;
    }

    .product-card img {
        height: 200px;
        object-fit: cover;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        transition: transform 0.3s ease;
    }

    .product-card:hover img {
        transform: scale(1.05);
    }

    .product-card .card-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .product-card .card-text {
        font-size: 0.9rem;
        line-height: 1.4;
    }

    .btn-outline-danger {
        border-radius: 5px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 10px rgba(220, 53, 69, 0.3);
    }

    .filter-card .form-range::-webkit-slider-thumb {
        background: #dc3545;
    }

    .filter-card .form-range::-moz-range-thumb {
        background: #dc3545;
    }

    .sort-select {
        border-radius: 5px;
        border: 1px solid #ddd;
        padding: 8px;
        font-size: 0.9rem;
        transition: border-color 0.3s ease;
    }

    .sort-select:focus {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }

    .pagination .page-link {
        color: #dc3545;
        border-radius: 5px;
        margin: 0 5px;
        transition: background-color 0.3s ease;
    }

    .pagination .page-link:hover {
        background-color: #dc3545;
        color: white;
    }

    .pagination .page-item.active .page-link {
        background-color: #dc3545;
        border-color: #dc3545;
        color: white;
    }

    @media (max-width: 768px) {
        .hero-section h1 {
            font-size: 1.8rem;
        }

        .hero-section p {
            font-size: 1rem;
        }

        .product-card img {
            height: 150px;
        }
    }
</style>
@endsection
@include('partials.header')
@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <h1>Explore Mukora Supermarket</h1>
        <p>Discover a wide range of quality products at unbeatable prices!</p>
        <div class="search-bar">
            <input type="text" class="form-control" placeholder="Search products..." id="searchInput">
        </div>
    </div>
</section>

<div class="container py-5">
    <div class="row">
        <!-- Sidebar - Categories -->
        <div class="col-lg-3 mb-4 sidebar">
            <div class="card shadow-sm mb-4 filter-card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Categories</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0 category-list">
                        <li class="mb-2">
                            <a href="{{ route('products.index') }}" 
                               class="text-decoration-none text-dark {{ request()->routeIs('products.index') && !request()->has('category') ? 'active' : '' }}">
                                All Products
                            </a>
                        </li>
                        @foreach($categories as $category)
                            <li class="mb-2">
                                <a href="{{ route('products.index', ['category' => $category->slug]) }}" 
                                   class="text-decoration-none text-dark {{ request('category') == $category->slug ? 'active' : '' }}">
                                    {{ $category->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            
            <div class="card shadow-sm filter-card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Filter by Price</h5>
                </div>
                <div class="card-body">
                    <h6>Price Range</h6>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span id="minPrice">UGX 0</span>
                            <span id="maxPrice">UGX 500,000</span>
                        </div>
                        <input type="range" class="form-range" min="0" max="500000" step="10000" value="500000" id="priceRange">
                    </div>
                    <div class="text-center">
                        <button type="button" class="btn btn-sm btn-outline-danger" id="applyFilter">Apply Filter</button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="mb-0">
                    {{ request('category') ? ucfirst(str_replace('-', ' ', request('category'))) : 'All Products' }}
                </h1>
                <div class="d-flex align-items-center">
                    <span class="me-2">Sort by:</span>
                    <select class="sort-select" id="sortOptions">
                        <option value="latest" {{ request('sort') == 'latest' || !request('sort') ? 'selected' : '' }}>Latest</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name</option>
                    </select>
                </div>
            </div>
            
            @if($products->isEmpty())
                <div class="alert alert-info shadow-sm">
                    No products found. Please try a different search or category.
                </div>
            @else
                <div class="row">
                    @foreach($products as $product)
                        <div class="col-md-4 col-6 mb-4">
                            <div class="card h-100 border-0 shadow-sm product-card">
                                <a href="{{ route('products.show', $product->slug) }}">
                                <img src="{{ $product->image ? asset('storage/'.$product->image) : asset('images/product-placeholder.jpg') }}" 
                                         alt="{{ $product->name }}" class="card-img-top">
                                </a>
                                <div class="card-body">
                                    <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none text-dark">
                                        <h5 class="card-title">{{ $product->name }}</h5>
                                    </a>
                                    <p class="card-text text-muted mb-2">{{ Str::limit($product->description, 50) }}</p>
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <span class="fw-bold text-danger">UGX {{ number_format($product->price) }}</span>
                                        <button class="btn btn-outline-danger btn-sm add-to-cart" data-product-id="{{ $product->id }}">
                                            <i class="fas fa-shopping-cart"></i> Add to Cart
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="d-flex justify-content-center mt-4">
                    {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>
@include('partials.footer')
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Sort options
        $('#sortOptions').change(function() {
            const urlParams = new URLSearchParams(window.location.search);
            urlParams.set('sort', $(this).val());
            window.location.search = urlParams.toString();
        });

        // Search functionality
        $('#searchInput').on('keyup', function(e) {
            if (e.key === 'Enter') {
                const query = $(this).val();
                const urlParams = new URLSearchParams(window.location.search);
                urlParams.set('search', query);
                window.location.search = urlParams.toString();
            }
        });

        // Price filter
        $('#priceRange').on('input', function() {
            const value = $(this).val();
            $('#maxPrice').text('UGX ' + Number(value).toLocaleString());
        });

        $('#applyFilter').click(function() {
            const maxPrice = $('#priceRange').val();
            const urlParams = new URLSearchParams(window.location.search);
            urlParams.set('max_price', maxPrice);
            window.location.search = urlParams.toString();
        });

        // Add to cart functionality
        $('.add-to-cart').click(function() {
            const productId = $(this).data('product-id');
            const $button = $(this);

            // Add animation
            $button.html('<i class="fas fa-spinner fa-spin"></i>').prop('disabled', true);

            // AJAX request to add item to cart
            $.ajax({
                url: `/cart/add/${productId}`,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // Show success message
                    Swal.fire({
                        title: 'Added to Cart!',
                        text: 'Product has been added to your cart',
                        icon: 'success',
                        confirmButtonColor: '#dc3545'
                    });

                    // Update cart count in navbar
                    $('#cart-count').text(response.cartCount);

                    // Reset button
                    $button.html('<i class="fas fa-shopping-cart"></i> Add to Cart').prop('disabled', false);
                },
                error: function() {
                    // Show error message
                    Swal.fire({
                        title: 'Oops!',
                        text: 'Something went wrong. Please try again.',
                        icon: 'error',
                        confirmButtonColor: '#dc3545'
                    });

                    // Reset button
                    $button.html('<i class="fas fa-shopping-cart"></i> Add to Cart').prop('disabled', false);
                }
            });
        });
    });
</script>
@endsection