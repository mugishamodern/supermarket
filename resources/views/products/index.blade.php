@extends('layouts.app')

@section('title', 'Shop Products - Mukora Supermarket')

@section('styles')
<link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
<style>
    .hero-section {
        background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('/uploads/images/supermarket-bg.jpg');
        background-size: cover;
        background-position: center;
        height: 60vh;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: white;
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
    .filter-card, .product-card {
        transition: all 0.3s ease;
        border-radius: 10px;
    }
    .filter-card:hover, .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }
    .category-list a {
        transition: color 0.3s ease, padding-left 0.3s ease;
    }
    .category-list a:hover, .category-list a.active {
        color: #dc3545;
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
    .form-range::-webkit-slider-thumb {
        background: #dc3545;
    }
    .form-range::-moz-range-thumb {
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
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .parallax {
        background-attachment: fixed;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }
    @media (max-width: 768px) {
        .hero-section {
            height: 50vh;
        }
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
<section class="hero-section parallax">
    <div class="container">
        <h1 class="text-4xl md:text-5xl font-bold mb-4 animate__animated animate__fadeInDown">Explore Mukora Supermarket</h1>
        <p class="text-lg md:text-xl mb-6 animate__animated animate__fadeInUp animate__delay-1s">Discover a wide range of quality products at unbeatable prices!</p>
        <div class="search-bar max-w-md mx-auto" data-aos="fade-up" data-aos-delay="200">
            <input type="text" class="w-full px-4 py-3 text-gray-800" placeholder="Search products..." id="searchInput">
        </div>
    </div>
</section>

<!-- Products Content -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Sidebar - Categories -->
            <div class="sidebar">
                <div class="filter-card bg-white rounded-xl shadow-md mb-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="p-6 border-b">
                        <h5 class="text-xl font-semibold">Categories</h5>
                    </div>
                    <div class="p-6">
                        <ul class="space-y-3">
                            <li>
                                <a href="{{ route('products.index') }}" 
                                   class="text-gray-800 hover:text-red-600 transition {{ request()->routeIs('products.index') && !request()->has('category') ? 'active' : '' }}">
                                    All Products
                                </a>
                            </li>
                            @foreach($categories as $category)
                                <li>
                                    <a href="{{ route('products.index', ['category' => $category->slug]) }}" 
                                       class="text-gray-800 hover:text-red-600 transition {{ request('category') == $category->slug ? 'active' : '' }}">
                                        {{ $category->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="filter-card bg-white rounded-xl shadow-md" data-aos="fade-up" data-aos-delay="200">
                    <div class="p-6 border-b">
                        <h5 class="text-xl font-semibold">Filter by Price</h5>
                    </div>
                    <div class="p-6">
                        <h6 class="text-sm font-medium mb-3">Price Range</h6>
                        <div class="flex justify-between mb-3 text-sm text-gray-600">
                            <span id="minPrice">UGX 0</span>
                            <span id="maxPrice">UGX 500,000</span>
                        </div>
                        <input type="range" class="form-range w-full" min="0" max="500000" step="10000" value="500000" id="priceRange">
                        <div class="text-center mt-4">
                            <button type="button" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition transform hover:scale-105" id="applyFilter">Apply Filter</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:col-span-3">
                <div class="flex justify-between items-center mb-6" data-aos="fade-up">
                    <h1 class="text-3xl font-bold">
                        {{ request('category') ? ucfirst(str_replace('-', ' ', request('category'))) : 'All Products' }}
                    </h1>
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-gray-600">Sort by:</span>
                        <select class="sort-select px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-600" id="sortOptions">
                            <option value="latest" {{ request('sort') == 'latest' || !request('sort') ? 'selected' : '' }}>Latest</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name</option>
                        </select>
                    </div>
                </div>

                @if($products->isEmpty())
                    <div class="bg-white rounded-xl shadow-md p-6 text-center" data-aos="fade-up" data-aos-delay="100">
                        <p class="text-gray-600">No products found. Please try a different search or category.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                        @foreach($products as $product)
                            <div class="product-card bg-white rounded-xl shadow-md overflow-hidden" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                                <a href="{{ route('products.show', $product->slug) }}">
                                    <img src="{{ $product->image ? asset('storage/'.$product->image) : asset('images/product-placeholder.jpg') }}" 
                                         alt="{{ $product->name }}" class="w-full">
                                </a>
                                <div class="p-4">
                                    <a href="{{ route('products.show', $product->slug) }}" class="text-gray-800 hover:text-red-600">
                                        <h5 class="card-title font-semibold">{{ $product->name }}</h5>
                                    </a>
                                    <p class="text-gray-600 text-sm mb-3">{{ Str::limit($product->description, 50) }}</p>
                                    <div class="flex justify-between items-center">
                                        <span class="font-bold text-red-600">UGX {{ number_format($product->price) }}</span>
                                        <button class="add-to-cart btn-outline-danger border border-red-600 text-red-600 hover:bg-red-600 hover:text-white font-semibold py-1 px-3 rounded-lg transition" 
                                                data-product-id="{{ $product->id }}">
                                            <i class="fas fa-shopping-cart mr-2"></i> Add to Cart
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="flex justify-center mt-8" data-aos="fade-up" data-aos-delay="300">
                        {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

@include('partials.footer')
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        AOS.init({
            duration: 800,
            once: true
        });

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
            $button.html('<i class="fas fa-spinner fa-spin mr-2"></i> Adding...').prop('disabled', true);

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
                    $button.html('<i class="fas fa-shopping-cart mr-2"></i> Add to Cart').prop('disabled', false);
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
                    $button.html('<i class="fas fa-shopping-cart mr-2"></i> Add to Cart').prop('disabled', false);
                }
            });
        });
    });
</script>
@endsection