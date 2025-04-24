@extends('layouts.app')

@section('title', 'Mukora Supermarket - Kasese\'s Premier Shopping Destination')

@section('styles')
<style>
    .hero-section {
        background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('\uploads\images\supermarket-bg.jpg');
        background-size: cover;
        background-position: center;
        color: white;
        padding: 100px 0;
    }
    
    .category-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        margin-bottom: 20px;
    }
    
    .category-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }
    
    .product-card {
        transition: transform 0.3s ease;
        margin-bottom: 20px;
    }
    
    .product-card:hover {
        transform: translateY(-5px);
    }
    
    .testimonial-section {
        background-color: #f8f9fa;
        padding: 60px 0;
    }
    
    .testimonial-card {
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
        background-color: white;
    }
    
    .feature-icon {
        font-size: 2.5rem;
        color: #dc3545;
        margin-bottom: 15px;
    }
</style>
@endsection
@include('partials.header')
@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container text-center">
        <h1 class="display-4 mb-4">Welcome to Mukora Supermarket</h1>
        <p class="lead mb-5">Kasese's premier shopping destination for fresh produce, quality goods, and exceptional service</p>
        <div>
            <a href="{{ route('products.index') }}" class="btn btn-danger btn-lg me-3">Shop Now</a>
            <a href="#featured" class="btn btn-outline-light btn-lg">Featured Products</a>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-5">Shop by Category</h2>
        <div class="row">
            @foreach($categories as $category)
            <div class="col-md-3 col-6">
                <a href="{{ route('categories.show', $category->slug) }}" class="text-decoration-none">
                    <div class="category-card text-center">
                        <div class="rounded overflow-hidden mb-3">
                            <img src="{{ $category->image ?? '/images/category-placeholder.jpg' }}" alt="{{ $category->name }}" class="img-fluid">
                        </div>
                        <h5 class="mb-0">{{ $category->name }}</h5>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Products Section -->
<section class="py-5 bg-light" id="featured">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Featured Products</h2>
            <a href="{{ route('products.index') }}" class="btn btn-outline-danger">View All</a>
        </div>
        <div class="row product-slider">
            @foreach($featuredProducts as $product)
            <div class="col-md-3 col-6">
                <div class="product-card card h-100 border-0 shadow-sm">
                    <div class="position-relative">
                        <img src="{{ $product->image ?? '/images/product-placeholder.jpg' }}" alt="{{ $product->name }}" class="card-img-top">
                        <div class="position-absolute top-0 end-0 p-2">
                            <span class="badge bg-danger">Featured</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text text-muted mb-1">{{ Str::limit($product->description, 50) }}</p>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="fw-bold text-danger">UGX {{ number_format($product->price) }}</span>
                            <button class="btn btn-sm btn-outline-danger add-to-cart" data-product-id="{{ $product->id }}">
                                <i class="fas fa-shopping-cart"></i> Add
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Special Offers Banner -->
<section class="py-4">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="position-relative rounded overflow-hidden" style="height: 250px;">
                    <img src="/images/fresh-produce.jpg" alt="Fresh Produce" class="w-100 h-100" style="object-fit: cover;">
                    <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center p-4" style="background: rgba(0,0,0,0.4);">
                        <h3 class="text-white">Fresh Produce</h3>
                        <p class="text-white mb-3">Farm to table, every day of the week</p>
                        <a href="{{ route('categories.show', 'fresh-produce') }}" class="btn btn-light">Shop Now</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="position-relative rounded overflow-hidden" style="height: 250px;">
                    <img src="/images/household-essentials.jpg" alt="Household Essentials" class="w-100 h-100" style="object-fit: cover;">
                    <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center p-4" style="background: rgba(0,0,0,0.4);">
                        <h3 class="text-white">Household Essentials</h3>
                        <p class="text-white mb-3">Everything you need for your home</p>
                        <a href="{{ route('categories.show', 'household-essentials') }}" class="btn btn-light">Shop Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-5">Why Choose Mukora Supermarket?</h2>
        <div class="row text-center">
            <div class="col-md-3 col-6 mb-4">
                <div class="feature-icon">
                    <i class="fas fa-truck"></i>
                </div>
                <h5>Fast Delivery</h5>
                <p class="text-muted">Same-day delivery within Kasese</p>
            </div>
            <div class="col-md-3 col-6 mb-4">
                <div class="feature-icon">
                    <i class="fas fa-leaf"></i>
                </div>
                <h5>Fresh Products</h5>
                <p class="text-muted">Sourced directly from local farmers</p>
            </div>
            <div class="col-md-3 col-6 mb-4">
                <div class="feature-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h5>Secure Payment</h5>
                <p class="text-muted">Multiple secure payment options</p>
            </div>
            <div class="col-md-3 col-6 mb-4">
                <div class="feature-icon">
                    <i class="fas fa-undo"></i>
                </div>
                <h5>Easy Returns</h5>
                <p class="text-muted">No-questions-asked return policy</p>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="bg-gray-50 py-16 px-4">
  <div class="max-w-7xl mx-auto">
    <h2 class="text-3xl md:text-4xl font-bold text-center text-gray-800 mb-12">
      What Our Customers Say
    </h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      <!-- Testimonial 1 -->
      <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-xl transition">
        <div class="flex items-center space-x-4 mb-4">
          <img src="/images/customer1.jpg" alt="Customer" class="w-14 h-14 rounded-full object-cover">
          <div>
            <h5 class="font-semibold text-gray-800">Jane Doe</h5>
            <small class="text-gray-500">Kasese Town</small>
          </div>
        </div>
        <p class="text-gray-600 italic mb-4">
          "I love shopping at Mukora Supermarket. Their products are always fresh, and the staff is incredibly helpful."
        </p>
        <div class="text-yellow-400 flex gap-1 text-lg">
          <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
        </div>
      </div>

      <!-- Testimonial 2 -->
      <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-xl transition">
        <div class="flex items-center space-x-4 mb-4">
          <img src="/images/customer2.jpg" alt="Customer" class="w-14 h-14 rounded-full object-cover">
          <div>
            <h5 class="font-semibold text-gray-800">John Smith</h5>
            <small class="text-gray-500">Kisinga</small>
          </div>
        </div>
        <p class="text-gray-600 italic mb-4">
          "The online delivery service is a game-changer! I can get everything I need without leaving my home. Fast and reliable."
        </p>
        <div class="text-yellow-400 flex gap-1 text-lg">
          <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
        </div>
      </div>

      <!-- Testimonial 3 -->
      <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-xl transition">
        <div class="flex items-center space-x-4 mb-4">
          <img src="/images/customer3.jpg" alt="Customer" class="w-14 h-14 rounded-full object-cover">
          <div>
            <h5 class="font-semibold text-gray-800">Sarah Johnson</h5>
            <small class="text-gray-500">Kilembe</small>
          </div>
        </div>
        <p class="text-gray-600 italic mb-4">
          "The variety of products is impressive. I can find everything from local produce to imported goods all in one place."
        </p>
        <div class="text-yellow-400 flex gap-1 text-lg">
          <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Newsletter Section -->
<section class="py-5 bg-danger text-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 mb-4 mb-md-0">
                <h3>Subscribe to Our Newsletter</h3>
                <p>Get the latest updates, offers and special promotions delivered directly to your inbox.</p>
            </div>
            <div class="col-md-6">
                <form class="d-flex" id="newsletter-form">
                    <input type="email" class="form-control" placeholder="Your Email Address" required>
                    <button type="submit" class="btn btn-light ms-2">Subscribe</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize product slider
        $('.product-slider').slick({
            slidesToShow: 4,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 3000,
            dots: true,
            arrows: false,
            responsive: [
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 3
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2
                    }
                },
                {
                    breakpoint: 576,
                    settings: {
                        slidesToShow: 1
                    }
                }
            ]
        });
        
        // Initialize testimonial slider
        $('.testimonial-slider').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 4000,
            dots: true,
            arrows: false,
            responsive: [
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 2
                    }
                },
                {
                    breakpoint: 576,
                    settings: {
                        slidesToShow: 1
                    }
                }
            ]
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
        
        // Newsletter subscription
        $('#newsletter-form').submit(function(e) {
            e.preventDefault();
            
            const email = $(this).find('input[type="email"]').val();
            
            // Show success message (in a real app, you'd send this to server)
            Swal.fire({
                title: 'Thank You!',
                text: 'You have been subscribed to our newsletter',
                icon: 'success',
                confirmButtonColor: '#dc3545'
            });
            
            // Reset form
            $(this)[0].reset();
        });
    });
</script>
@endsection