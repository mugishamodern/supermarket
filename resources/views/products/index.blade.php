@extends('layouts.app')

@section('title', 'Shop Products - Mukora Supermarket')

@section('styles')
<link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
@endsection

@include('partials.header')

@section('content')
<!-- Hero Section -->
<section class="hero-section bg-gradient-to-r from-red-600 to-red-800 text-white py-16">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4" data-aos="fade-up">Our Products</h1>
        <p class="text-xl mb-8 max-w-2xl mx-auto" data-aos="fade-up" data-aos-delay="100">Discover our wide range of quality products sourced from local farmers and trusted suppliers.</p>
        <div class="search-bar max-w-md mx-auto flex items-center bg-white rounded-lg shadow-md overflow-hidden" data-aos="fade-up" data-aos-delay="200">
            <input type="text" class="w-full px-4 py-3 text-gray-800 focus:outline-none" placeholder="Search products..." id="searchInput" value="{{ request('search', '') }}">
            <button type="button" id="searchButton" class="px-4 py-3 bg-red-600 text-white font-semibold hover:bg-red-700 transition">Search</button>
        </div>
    </div>
</section>

<!-- Products Content -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-10">
            <!-- Sidebar - Categories -->
            <aside class="sidebar space-y-8">
                <div class="filter-card bg-white rounded-2xl shadow-lg mb-6 divide-y divide-gray-100" data-aos="fade-up" data-aos-delay="100">
                    <div class="p-6">
                        <h5 class="text-xl font-bold mb-4">Categories</h5>
                        <ul class="space-y-2">
                            <li>
                                <a href="{{ route('products.index') }}" 
                                   class="block px-3 py-2 rounded-lg transition {{ request()->routeIs('products.index') && !request()->has('category') ? 'bg-red-50 text-red-700 font-semibold' : 'text-gray-800 hover:bg-gray-100' }}">
                                    All Products
                                </a>
                            </li>
                            @foreach($categories as $category)
                                <li>
                                    <a href="{{ route('products.index', ['category' => $category->slug]) }}" 
                                       class="block px-3 py-2 rounded-lg transition {{ request('category') == $category->slug ? 'bg-red-50 text-red-700 font-semibold' : 'text-gray-800 hover:bg-gray-100' }}">
                                        {{ $category->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="filter-card bg-white rounded-2xl shadow-lg divide-y divide-gray-100" data-aos="fade-up" data-aos-delay="200">
                    <div class="p-6">
                        <h5 class="text-xl font-bold mb-4">Filter by Price</h5>
                        <h6 class="text-sm font-medium mb-3">Price Range</h6>
                        <div class="flex justify-between mb-3 text-sm text-gray-600">
                            <span id="minPrice">UGX 0</span>
                            <span id="maxPrice">UGX 500,000</span>
                        </div>
                        <input type="range" class="form-range w-full" min="0" max="500000" step="10000" value="500000" id="priceRange">
                        <div class="flex gap-2 mt-4">
                            <button type="button" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition w-full" id="applyFilter">Apply</button>
                            <button type="button" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-2 px-4 rounded-lg transition w-full" id="resetFilter">Reset</button>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Main Content -->
            <main class="lg:col-span-3">
                <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-8 gap-4" data-aos="fade-up">
                    <h1 class="text-3xl font-extrabold tracking-tight">
                        {{ request('category') ? ucfirst(str_replace('-', ' ', request('category'))) : 'All Products' }}
                    </h1>
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-gray-600">Sort by:</span>
                        <select class="sort-select px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-600 bg-white" id="sortOptions">
                            <option value="latest" {{ request('sort') == 'latest' || !request('sort') ? 'selected' : '' }}>Latest</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name</option>
                        </select>
                    </div>
                </div>

                @if($products->isEmpty())
                    <div class="bg-white rounded-2xl shadow-lg p-8 text-center" data-aos="fade-up" data-aos-delay="100">
                        <p class="text-gray-600">No products found. Please try a different search or category.</p>
                    </div>
                @else
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                        @foreach($products as $product)
                            <div class="product-card bg-white rounded-xl shadow-md overflow-hidden flex flex-col transition-transform duration-200 hover:-translate-y-1 hover:shadow-xl p-2" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}" style="min-width:0;">
                                <a href="{{ route('products.show', $product->slug) }}" class="block aspect-w-1 aspect-h-1 bg-gray-100 overflow-hidden rounded-lg relative">
                                    <img src="{{ $product->image ? asset('storage/'.$product->image) : asset('images/product-placeholder.jpg') }}" 
                                         alt="{{ $product->name }}" class="object-cover w-full h-full transition-transform duration-200 hover:scale-105" style="max-height:120px;" loading="lazy">
                                    @if($product->activePromotion())
                                        <span class="absolute top-2 left-2 bg-red-600 text-white text-xs font-bold px-2 py-1 rounded">-{{ $product->activePromotion()->discount_percentage }}%</span>
                                    @endif
                                </a>
                                <div class="p-2 flex flex-col flex-1">
                                    <a href="{{ route('products.show', $product->slug) }}" class="text-gray-900 hover:text-red-600">
                                        <h5 class="card-title font-semibold text-base mb-1 truncate">{{ $product->name }}</h5>
                                    </a>
                                    <p class="text-gray-500 text-xs mb-2 flex-1">{{ Str::limit($product->description, 40) }}</p>
                                    <div class="flex justify-between items-center mt-auto">
                                        <div>
                                            @if($product->activePromotion())
                                                <span class="font-bold text-sm text-red-600">UGX {{ number_format($product->discountedPrice()) }}</span>
                                                <span class="text-xs text-gray-400 line-through ml-1">UGX {{ number_format($product->price) }}</span>
                                            @else
                                                <span class="font-bold text-sm text-red-600">UGX {{ number_format($product->price) }}</span>
                                            @endif
                                        </div>
                                        <button class="add-to-cart border border-red-600 text-red-600 hover:bg-red-600 hover:text-white font-semibold py-1 px-2 rounded-lg transition flex items-center gap-1 text-xs" 
                                                data-product-id="{{ $product->id }}">
                                            <i class="fas fa-shopping-cart"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="flex justify-center mt-10" data-aos="fade-up" data-aos-delay="300">
                        {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </main>
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
        document.getElementById('sortOptions').addEventListener('change', function() {
            const urlParams = new URLSearchParams(window.location.search);
            urlParams.set('sort', this.value);
            window.location.search = urlParams.toString();
        });

        // Search functionality
        const searchInput = document.getElementById('searchInput');
        const searchButton = document.getElementById('searchButton');
        function doSearch() {
            const query = searchInput.value;
            const urlParams = new URLSearchParams(window.location.search);
            urlParams.set('search', query);
            window.location.search = urlParams.toString();
        }
        searchInput.addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                doSearch();
            }
        });
        searchButton.addEventListener('click', doSearch);

        // Price filter
        document.getElementById('priceRange').addEventListener('input', function() {
            const value = this.value;
            document.getElementById('maxPrice').textContent = 'UGX ' + Number(value).toLocaleString();
        });

        document.getElementById('applyFilter').addEventListener('click', function() {
            const maxPrice = document.getElementById('priceRange').value;
            const urlParams = new URLSearchParams(window.location.search);
            urlParams.set('max_price', maxPrice);
            window.location.search = urlParams.toString();
        });

        document.getElementById('resetFilter').addEventListener('click', function() {
            const urlParams = new URLSearchParams(window.location.search);
            urlParams.delete('max_price');
            urlParams.delete('sort');
            urlParams.delete('search');
            window.location.search = urlParams.toString();
        });
    });
</script>
@endsection