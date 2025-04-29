@extends('layouts.app')
@section('title', '{{ $product->name }} - Mukora Supermarket')
@include('partials.header')
@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="row">
                        <!-- Product Image -->
                        <div class="col-lg-6 mb-4">
                        <img src="{{ $product->image ? asset('storage/'.$product->image) : asset('images/product-placeholder.jpg') }}" 
                                 alt="{{ $product->name }}" 
                                 class="img-fluid rounded" 
                                 style="max-height: 500px; object-fit: cover;">
                        </div>
                        
                        <!-- Product Details -->
                        <div class="col-lg-6">
                            <h1 class="mb-3">{{ $product->name }}</h1>
                            <p class="text-muted mb-4">{{ $product->description }}</p>
                            <div class="mb-4">
                                <span class="fw-bold text-danger fs-3">UGX {{ number_format($product->price) }}</span>
                            </div>
                            <div class="d-flex align-items-center mb-4">
                                <button class="btn btn-outline-danger add-to-cart" 
                                        data-product-id="{{ $product->id }}">
                                    <i class="fas fa-shopping-cart"></i> Add to Cart
                                </button>
                                <a href="{{ route('products.index') }}" 
                                   class="btn btn-outline-secondary ms-3">
                                    Back to Products
                                </a>
                            </div>
                            <!-- Category Information -->
                            <div class="border-top pt-3">
                                <h6 class="mb-2">Category</h6>
                                <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" 
                                   class="text-decoration-none text-dark">
                                    {{ $product->category->name }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('partials.footer')
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
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
                    $('.add-to-cart').html('<i class="fas fa-shopping-cart"></i> Add to Cart');
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
                    $('.add-to-cart').html('<i class="fas fa-shopping-cart"></i> Add to Cart');
                }
            });
        });
    });
</script>
@endsection