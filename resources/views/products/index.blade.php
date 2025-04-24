@extends('layouts.app')

@section('title', 'Shop Products - Mukora Supermarket')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Sidebar - Categories -->
        <div class="col-lg-3 mb-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Categories</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <a href="{{ route('products.index') }}" class="text-decoration-none {{ request()->routeIs('products.index') && !request()->has('category') ? 'text-danger fw-bold' : 'text-dark' }}">
                                All Products
                            </a>
                        </li>
                        @foreach($categories as $category)
                            <li class="mb-2">
                                <a href="{{ route('products.index', ['category' => $category->slug]) }}" 
                                   class="text-decoration-none {{ request('category') == $category->slug ? 'text-danger fw-bold' : 'text-dark' }}">
                                    {{ $category->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Filter</h5>
                </div>
                <div class="card-body">
                    <h6>Price Range</h6>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Min: UGX 0</span>
                            <span>Max: UGX 500,000</span>
                        </div>
                        <input type="range" class="form-range" min="0" max="500000" step="10000" id="priceRange">
                    </div>
                    <div class="text-center">
                        <button type="button" class="btn btn-sm btn-outline-danger">Apply Filter</button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="mb-0">{{ request('category') ? ucfirst(str_replace('-', ' ', request('category'))) : 'All Products' }}</h1>
                
                <div class="d-flex align-items-center">
                    <span class="me-2">Sort by:</span>
                    <select class="form-select form-select-sm" id="sortOptions">
                        <option value="latest" {{ request('sort') == 'latest' || !request('sort') ? 'selected' : '' }}>Latest</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name</option>
                    </select>
                </div>
            </div>
            
            @if($products->isEmpty())
                <div class="alert alert-info">
                    No products found. Please try a different search or category.
                </div>
            @else
                <div class="row">
                    @foreach($products as $product)
                        <div class="col-md-4 col-6 mb-4">
                            <div class="card h-100 border-0 shadow-sm product-card">
                                <a href="{{ route('products.show', $product->slug) }}">
                                    <img src="{{ $product->image ?? '/images/product-placeholder.jpg' }}" 
                                         alt="{{ $product->name }}" class="card-img-top">
                                </a>
                                <div class="card-body">
                                    <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none text-dark">
                                        <h5 class="card-title">{{ $product->name }}</h5>
                                    </a>
                                    <p class="card-text text-muted mb-1">{{ Str::limit($product->description, 50) }}</p>
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <span class="fw-bold text-danger">UGX {{ number_format($product->price) }}</span>
                                        <button class="btn btn-outline-danger add-to-cart" data-product-id="{{ $product->id }}">
                                            <i class="fas fa-shopping-cart"></i> Add
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="d-flex justify-content-center mt-4">
                    {{ $products->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
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
        
        // Add to cart functionality
        $('.add-to-cart').click(function() {
            const productId = $(this).data('product-id');
            
            // Add animation
            $(this).html('<i class="fas fa-spinner fa-spin"></i>');
            
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
                    $('.add-to-cart[data-product-id="'+productId+'"]').html('<i class="fas fa-shopping-cart"></i> Add');
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
                    $('.add-to-cart[data-product-id="'+productId+'"]').html('<i class="fas fa-shopping-cart"></i> Add');
                }
            });
        });
    });
</script>
@endsection