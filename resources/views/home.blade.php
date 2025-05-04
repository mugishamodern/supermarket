@extends('layouts.app')

@section('title', 'Mukora Supermarket - Kasese\'s Premier Shopping Destination')

@section('styles')
<link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style>
    .hero-section {
        background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('/uploads/images/supermarket-bg.jpg');
        background-size: cover;
        background-position: center;
        height: 80vh;
    }
    
    .category-card {
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    
    .category-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
    }
    
    .product-card {
        transition: all 0.3s ease;
    }
    
    .product-card:hover {
        transform: translateY(-8px);
    }
    
    .pulse-button {
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7); }
        70% { box-shadow: 0 0 0 10px rgba(220, 53, 69, 0); }
        100% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0); }
    }
    
    .slick-dots li button:before {
        color: #dc3545;
    }
    
    .testimonial-slide {
        opacity: 0.5;
        transform: scale(0.85);
        transition: all 0.5s ease;
    }

    /* hide scrollbar */
    .scrollbar-hide::-webkit-scrollbar { display: none; }
    .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    
    .slick-center .testimonial-slide {
        opacity: 1;
        transform: scale(1);
    }
    
    .counter-number {
        font-size: 2.5rem;
        font-weight: bold;
        color: #dc3545;
    }
    
    /* Custom loader animation */
    .loader {
        width: 20px;
        height: 20px;
        border: 3px solid #ffffff;
        border-bottom-color: transparent;
        border-radius: 50%;
        display: inline-block;
        box-sizing: border-box;
        animation: rotation 1s linear infinite;
    }

    @keyframes rotation {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    /* Fade in animation */
    .fade-in {
        animation: fadeIn 0.8s ease-in forwards;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    /* Parallax effect */
    .parallax {
        background-attachment: fixed;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }
</style>
@endsection

@include('partials.header')

@section('content')
<!-- Hero Section with Parallax and Animated Text -->
<section class="hero-section flex items-center justify-center parallax">
    <div class="container mx-auto text-center px-4">
        <h1 class="text-5xl md:text-7xl font-bold mb-6 text-white animate__animated animate__fadeInDown">Welcome to Mukora Supermarket</h1>
        <p class="text-xl md:text-2xl mb-10 text-white animate__animated animate__fadeInUp animate__delay-1s">Kasese's premier shopping destination for fresh produce, quality goods, and exceptional service</p>
        <div class="animate__animated animate__fadeInUp animate__delay-2s">
            <a href="{{ route('products.index') }}" class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-8 rounded-full inline-block mr-4 transition transform hover:scale-105 pulse-button">
                Shop Now
            </a>
            <a href="#featured" class="bg-transparent border-2 border-white text-white font-bold py-3 px-8 rounded-full inline-block hover:bg-white hover:text-red-600 transition">
                Featured Products
            </a>
        </div>
    </div>
</section>

<!-- Announcement Banner with Countdown Timer -->
<div class="bg-red-600 text-white py-3 relative overflow-hidden" id="announcement-banner">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div class="flex items-center mb-3 md:mb-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                </svg>
                <p class="font-medium text-sm md:text-base">Special Weekend Sale! Up to 30% off on all electronics</p>
            </div>
            <div class="flex items-center">
                <span class="text-sm mr-2">Ends in:</span>
                <div class="flex space-x-2" id="countdown-timer">
                    <div class="bg-white text-red-600 rounded px-2 py-1 text-xs font-bold" id="countdown-days">00</div>
                    <div class="bg-white text-red-600 rounded px-2 py-1 text-xs font-bold" id="countdown-hours">00</div>
                    <div class="bg-white text-red-600 rounded px-2 py-1 text-xs font-bold" id="countdown-minutes">00</div>
                    <div class="bg-white text-red-600 rounded px-2 py-1 text-xs font-bold" id="countdown-seconds">00</div>
                </div>
            </div>
        </div>
    </div>
    <button class="absolute top-1/2 right-4 transform -translate-y-1/2 text-white" id="close-banner">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
        </svg>
    </button>
</div>

<!-- Categories Section with Animation -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Shop by Category</h2>
            <div class="w-24 h-1 bg-red-600 mx-auto"></div>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($categories as $category)
            <div class="category-item" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <a href="{{ route('categories.show', $category->slug) }}" class="block">
                    <div class="category-card bg-white rounded-xl overflow-hidden shadow-md">
                        <div class="relative overflow-hidden">
                        <img src="{{ $category->image ? asset('storage/'.$category->image) : asset('images/category-placeholder.jpg') }}" 
                                class="w-full h-48 object-cover transform hover:scale-110 transition duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent flex items-end">
                                <h5 class="text-white font-semibold p-4 text-lg">{{ $category->name }}</h5>
                            </div>
                        </div>
                        <div class="p-4 text-center">
                            <span class="inline-block px-4 py-1 bg-red-100 text-red-600 rounded-full text-sm font-medium">
                                Shop Now
                            </span>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Products Section with Carousel -->
<section class="py-24 bg-gradient-to-b from-white to-gray-50" id="featured">
    <div class="container mx-auto px-4">
        <!-- Section Header -->
        <div class="text-center mb-16">
            <span class="inline-block px-4 py-1.5 bg-red-100 text-red-600 font-medium text-sm rounded-full mb-3">Top Selection</span>
            <h2 class="text-4xl font-bold text-gray-800 mb-4">Featured Products</h2>
            <p class="text-gray-600 max-w-xl mx-auto">Handpicked quality products selected just for you, updated regularly with our best offerings</p>
            <div class="w-24 h-1 bg-red-600 mx-auto mt-6"></div>
        </div>
        
        <!-- Products Grid -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($featuredProducts as $product)
            <div class="px-3">
                <div class="product-card group bg-white rounded-3xl overflow-hidden border border-gray-100 transition-all duration-300 hover:shadow-2xl">
                    <!-- Product Image Container - Square Aspect Ratio -->
                    <div class="relative aspect-square overflow-hidden">
                        <!-- Product Image -->
                        <img src="{{ $product->image ? asset('storage/'.$product->image) : asset('images/product-placeholder.jpg') }}" 
                            class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                        
                        <!-- Featured Badge -->
                        <div class="absolute top-4 left-4">
                            <span class="badge bg-red-600 text-white px-3 py-1.5 rounded-full text-xs font-bold shadow-lg">Featured</span>
                        </div>
                        
                        <!-- Quick Action Buttons -->
                        <div class="absolute right-4 top-4 flex flex-col space-y-2 transform translate-x-12 group-hover:translate-x-0 transition-transform duration-300">
                            <button class="quick-view-btn bg-white text-gray-800 rounded-full w-10 h-10 flex items-center justify-center shadow-lg hover:bg-red-600 hover:text-white transition-colors" 
                                data-product-id="{{ $product->id }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                            <button class="add-to-wishlist bg-white text-gray-800 rounded-full w-10 h-10 flex items-center justify-center shadow-lg hover:bg-red-600 hover:text-white transition-colors" 
                                data-product-id="{{ $product->id }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </button>
                        </div>
                        
                        <!-- Add to Cart Button Overlay -->
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4 translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                            <button class="add-to-cart bg-red-600 hover:bg-red-700 text-white w-full py-2.5 rounded-xl text-sm font-medium transition flex items-center justify-center" 
                                data-product-id="{{ $product->id }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Add to Cart
                            </button>
                        </div>
                    </div>
                    
                    <!-- Product Info -->
                    <div class="p-5">
                        <!-- Product Name -->
                        <h5 class="font-bold text-lg mb-1 text-gray-800 line-clamp-1">{{ $product->name }}</h5>
                        
                        <!-- Product Description -->
                        <p class="text-gray-600 text-xs mb-3 line-clamp-2">{{ Str::limit($product->description, 60) }}</p>
                        
                        <!-- Ratings -->
                        <div class="flex text-yellow-400 mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                            </svg>
                        </div>
                        
                        <!-- Price -->
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-red-600 text-xl">UGX {{ number_format($product->price) }}</span>
                            <button class="add-to-cart bg-red-600 hover:bg-red-700 text-white p-2 rounded-full shadow-md transition transform hover:scale-105" 
                                data-product-id="{{ $product->id }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- View All Button -->
        <div class="mt-16 text-center">
            <a href="{{ route('products.index') }}" class="inline-flex items-center px-8 py-4 bg-red-600 text-white font-semibold rounded-xl hover:bg-red-700 transition shadow-lg group">
                View All Products
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
            </a>
        </div>
    </div>
</section>

<!-- Special Offers Banner with Parallax -->
<section class="py-12">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @foreach($featuredCategories as $category)
                <div class="relative rounded-2xl overflow-hidden shadow-lg h-72 transform transition hover:scale-105" 
                    style="background: url('{{ Storage::url($category->image) }}') no-repeat center center; background-size: cover;">
                    <div class="absolute inset-0 bg-gradient-to-r from-black/80 to-transparent">
                        <div class="flex flex-col justify-center h-full p-8 text-white">
                            <h3 class="text-3xl font-bold mb-2">{{ $category->name }}</h3>
                            <a href="{{ route('categories.show', $category->slug) }}" 
                                class="bg-white text-red-600 font-semibold px-6 py-2 rounded-lg hover:bg-red-600 hover:text-white transition w-max">
                                Shop Now
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Stats Counter Section -->
<section class="py-16 bg-gray-100">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold mb-2">Our Impact</h2>
            <p class="text-gray-600">Growing stronger with the Kasese community</p>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
            <div class="bg-white p-6 rounded-xl shadow-md">
                <div class="counter-number" data-target="5000">10</div>
                <p class="text-gray-600 mt-2">Happy Customers</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-md">
                <div class="counter-number" data-target="100">20</div>
                <p class="text-gray-600 mt-2">Local Farmers</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-md">
                <div class="counter-number" data-target="2500">30</div>
                <p class="text-gray-600 mt-2">Products</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-md">
                <div class="counter-number" data-target="10">40</div>
                <p class="text-gray-600 mt-2">Years of Service</p>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Why Choose Mukora Supermarket?</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">We're committed to providing the best shopping experience with quality products and exceptional service.</p>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="text-center p-6 bg-white rounded-xl shadow-md hover:shadow-xl transition feature-card">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                    </svg>
                </div>
                <h5 class="font-bold text-lg mb-2">Fast Delivery</h5>
                <p class="text-gray-600 text-sm">Same-day delivery within Kasese</p>
            </div>
            
            <div class="text-center p-6 bg-white rounded-xl shadow-md hover:shadow-xl transition feature-card">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h5 class="font-bold text-lg mb-2">Fresh Products</h5>
                <p class="text-gray-600 text-sm">Sourced directly from local farmers</p>
            </div>
            
            <div class="text-center p-6 bg-white rounded-xl shadow-md hover:shadow-xl transition feature-card">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <h5 class="font-bold text-lg mb-2">Secure Payment</h5>
                <p class="text-gray-600 text-sm">Multiple secure payment options</p>
            </div>
            
            <div class="text-center p-6 bg-white rounded-xl shadow-md hover:shadow-xl transition feature-card">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z" />
                    </svg>
                </div>
                <h5 class="font-bold text-lg mb-2">Easy Returns</h5>
                <p class="text-gray-600 text-sm">No-questions-asked return policy</p>
            </div>
        </div>
    </div>
</section>

<section class="py-16 bg-gray-50">
  <div class="container mx-auto px-4">
    <div class="text-center mb-12">
      <h2 class="text-3xl md:text-4xl font-bold mb-4">What Our Customers Say</h2>
      <p class="text-gray-600 max-w-2xl mx-auto">Don't just take our word for it—hear what our customers have to say about their shopping experience.</p>
    </div>

    <div class="relative">
      <div id="testimonialSlider" class="flex space-x-6 overflow-x-auto snap-x snap-mandatory scrollbar-hide">
        @foreach($feedbacks as $feedback)
          <div class="flex-shrink-0 w-full sm:w-3/4 md:w-1/2 lg:w-1/3 snap-center px-2">
            <div class="bg-white p-6 rounded-2xl shadow-md">
              <div class="flex items-center space-x-4 mb-4">
               {{-- <img src="{{ $feedback->image ? asset('storage/'.$feedback->image) : asset('images/feedback-placeholder.jpg') }}" alt="{{ $feedback->name }}" class="w-16 h-16 rounded-full object-cover border-2 border-red-600"> --}}
                <div>
                  <h5 class="font-semibold text-lg">{{ $feedback->name }}</h5>
                  <p class="text-gray-500 text-sm">{{ $feedback->location }}</p>
                </div>
              </div>
              <div class="relative mb-4">
                  <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                </svg>
                <p class="text-gray-600 italic pl-6">{{ $feedback->message }}</p>
              </div>
              <div class="flex text-yellow-400">
                @for ($i = 1; $i <= floor($feedback->rating); $i++)
                  <i class="fas fa-star"></i>
                @endfor
                @if ($feedback->rating - floor($feedback->rating) >= 0.5)
                  <i class="fas fa-star-half-alt"></i>
                @endif
              </div>
            </div>
          </div>
        @endforeach
      </div>

      <button id="prevBtn" class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-white p-2 rounded-full shadow-md hover:bg-gray-100 focus:outline-none">
        <svg class="h-6 w-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
      </button>
      <button id="nextBtn" class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-white p-2 rounded-full shadow-md hover:bg-gray-100 focus:outline-none">
        <svg class="h-6 w-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
      </button>
    </div>
    <!-- Contribute Feedback Button -->
    <div class="text-center mt-12">
      <a href="{{ route('feedback.create') }}" class="inline-block px-8 py-3 bg-red-600 text-white font-semibold rounded-lg shadow-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-opacity-50">
        Contribute Feedback
      </a>
    </div>
  </div>
</section>



<!-- Newsletter Section with Animated Background -->
<section class="py-16 bg-gray-900 text-white relative overflow-hidden">
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-3xl mx-auto text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-6">Subscribe to Our Newsletter</h2>
            <p class="text-gray-300 mb-8">Get the latest updates, offers and special promotions delivered directly to your inbox.</p>
            
            <form id="newsletter-form" class="flex flex-col md:flex-row gap-4 max-w-lg mx-auto">
                <input type="email" class="flex-grow px-4 py-3 rounded-lg text-gray-800 focus:outline-none focus:ring-2 focus:ring-red-600" placeholder="Your Email Address" required>
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-3 rounded-lg transition transform hover:scale-105">
                    Subscribe
                </button>
            </form>
            
            <div class="mt-8 grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                <div>
                    <p class="text-gray-400 text-sm">Weekly Updates</p>
                </div>
                <div>
                    <p class="text-gray-400 text-sm">Exclusive Offers</p>
                </div>
                <div>
                    <p class="text-gray-400 text-sm">Seasonal Recipes</p>
                </div>
                <div>
                    <p class="text-gray-400 text-sm">New Product Alerts</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Animated background elements -->
    <div class="absolute inset-0 z-0 overflow-hidden">
        <div class="absolute w-32 h-32 bg-red-600 rounded-full top-1/4 left-1/4 animate-pulse" style="opacity: 0.3;"></div>
        <div class="absolute w-40 h-40 bg-red-700 rounded-full top-3/4 left-1/3 animate-pulse" style="animation-delay: 1s; opacity: 0.2;"></div>
        <div class="absolute w-24 h-24 bg-red-500 rounded-full top-1/3 right-1/4 animate-pulse" style="animation-delay: 2s; opacity: 0.3;"></div>
        <div class="absolute w-36 h-36 bg-red-800 rounded-full bottom-1/4 right-1/3 animate-pulse" style="animation-delay: 1.5s; opacity: 0.2;"></div>
    </div>
</section>

<!-- Quick Shopping Component -->
<div class="fixed bottom-8 right-8 z-50" id="quick-shop">
    <button id="quick-shop-toggle" class="bg-red-600 hover:bg-red-700 text-white w-16 h-16 rounded-full shadow-lg flex items-center justify-center transition-transform transform hover:scale-110">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
        </svg>
    </button>
    
    <div id="quick-shop-panel" class="hidden bg-white rounded-lg shadow-xl p-4 mb-4 w-72">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-lg">Quick Shop</h3>
            <button id="close-quick-shop" class="text-gray-500 hover:text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>
        
        <div class="mb-4">
            <input type="text" id="quick-search" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600" placeholder="Search products...">
        </div>
        
        <div class="mb-4 max-h-60 overflow-y-auto" id="quick-products">
            <!-- Quick access products will be loaded here -->
            <div class="text-center text-gray-500 py-4">
                Type to search products...
            </div>
        </div>
        
        <a href="{{ route('cart.index') }}" class="block w-full bg-red-600 hover:bg-red-700 text-white text-center font-semibold py-2 rounded-lg transition">
            Go to Cart (<span id="quick-cart-count">0</span>)
        </a>
    </div>
</div>

<!-- Modal for Quick Product View -->
<div id="quick-view-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-black opacity-50 transition-opacity" id="modal-overlay"></div>
        
        <div class="relative bg-white rounded-lg max-w-md w-full mx-auto shadow-xl transition transform">
            <div class="absolute top-3 right-3">
                <button id="close-modal" class="bg-gray-100 rounded-full p-2 hover:bg-gray-200 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
            
            <div id="modal-content" class="p-6">
                <!-- Content will be loaded here -->
                <div class="flex justify-center items-center h-40">
                    <div class="loader border-red-600"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Back to Top Button -->
<button id="back-to-top" class="fixed bottom-8 left-8 z-50 bg-red-600 text-white w-12 h-12 rounded-full shadow-lg flex items-center justify-center opacity-0 invisible transition-all">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
    </svg>
</button>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Alpine.js for data & controls (only tailwind classes in CSS) -->
<script src="//unpkg.com/alpinejs" defer></script></script>
<script>
// SET your offer end time here (Year, Month (0-11), Day, Hour, Minute, Second)
const endDate = new Date("2025-05-01T23:59:59").getTime();

// Countdown
const countdown = setInterval(function() {
    const now = new Date().getTime();
    const distance = endDate - now;

    if (distance < 0) {
        clearInterval(countdown);
        document.getElementById("countdown-timer").innerHTML = "<span class='text-sm'>Expired</span>";
        return;
    }

    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

    document.getElementById("countdown-days").innerText = String(days).padStart(2, '0');
    document.getElementById("countdown-hours").innerText = String(hours).padStart(2, '0');
    document.getElementById("countdown-minutes").innerText = String(minutes).padStart(2, '0');
    document.getElementById("countdown-seconds").innerText = String(seconds).padStart(2, '0');
}, 1000);

// Close banner
document.getElementById('close-banner').addEventListener('click', function() {
    document.getElementById('announcement-banner').style.display = 'none';
});
      document.addEventListener('alpine:init', () => {
    Alpine.data('testimonials', () => ({
      testimonials: [
        {
          name: 'Jane Doe', location: 'Kasese Town',
          photo: '/images/customer1.jpg',
          quote: '“I love shopping at Mukora… convenient!”',
          stars: '★★★★★'
        },
        {
          name: 'John Smith', location: 'Kisinga',
          photo: '/images/customer2.jpg',
          quote: '“Fast and reliable with excellent customer service.”',
          stars: '★★★★½'
        },
        {
          name: 'Sarah Johnson', location: 'Kilembe',
          photo: '/images/customer3.jpg',
          quote: '“Best supermarket in Kasese!”',
          stars: '★★★★★'
        },
        {
          name: 'Michael Kiiza', location: 'Bwera',
          photo: '/images/customer4.jpg',
          quote: '“Their loyalty program is excellent.”',
          stars: '★★★★★'
        },
      ],
      init() {
        this.$nextTick(() => {
          const slider = this.$refs.slider;
          document.getElementById('prevBtn').onclick = () => slider.scrollBy({ left: -slider.clientWidth * 0.8, behavior: 'smooth' });
          document.getElementById('nextBtn').onclick = () => slider.scrollBy({ left: slider.clientWidth * 0.8, behavior: 'smooth' });
        });
      }
    }));
  });

    $(document).ready(function() {
        // Initialize AOS animations
        AOS.init({
            duration: 800,
            once: true
        });
        
        // Hero section text animation
        setTimeout(function() {
            $('.hero-section h1').addClass('animate__animated animate__fadeInDown');
            setTimeout(function() {
                $('.hero-section p').addClass('animate__animated animate__fadeInUp');
                setTimeout(function() {
                    $('.hero-section div').addClass('animate__animated animate__fadeInUp');
                }, 500);
            }, 500);
        }, 300);
        
        // Countdown timer
        function updateCountdown() {
            const now = new Date();
            const targetDate = new Date();
            targetDate.setDate(targetDate.getDate() + 3); // 3 days from now
            targetDate.setHours(23, 59, 59);
            
            const diff = targetDate - now;
            
            const days = Math.floor(diff / (1000 * 60 * 60 * 24));
            const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);
            
            $('#countdown-days').text(days.toString().padStart(2, '0'));
            $('#countdown-hours').text(hours.toString().padStart(2, '0'));
            $('#countdown-minutes').text(minutes.toString().padStart(2, '0'));
            $('#countdown-seconds').text(seconds.toString().padStart(2, '0'));
        }
        
        updateCountdown();
        setInterval(updateCountdown, 1000);
        
        // Close announcement banner
        $('#close-banner').click(function() {
            $('#announcement-banner').slideUp();
        });
        
        // Initialize product slider
        $('.product-slider').slick({
            slidesToShow: 4,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 3000,
            dots: true,
            arrows: true,
            prevArrow: '<button class="slick-prev hidden md:block absolute top-1/2 -left-4 transform -translate-y-1/2 z-10 bg-white p-2 rounded-full shadow-md hover:shadow-lg"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg></button>',
            nextArrow: '<button class="slick-next hidden md:block absolute top-1/2 -right-4 transform -translate-y-1/2 z-10 bg-white p-2 rounded-full shadow-md hover:shadow-lg"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg></button>',
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 3
                    }
                },
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
        
        // Initialize testimonial slider
        $('.testimonial-slider').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 4000,
            dots: true,
            arrows: false,
            centerMode: true,
            centerPadding: '0',
            responsive: [
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 2,
                        centerMode: false
                    }
                },
                {
                    breakpoint: 576,
                    settings: {
                        slidesToShow: 1,
                        centerMode: false
                    }
                }
            ]
        });
        
        // Number counter animation
        function animateCounters() {
            $('.counter-number').each(function() {
                const $this = $(this);
                const target = parseInt($this.data('target'));
                
                // Only animate if in viewport
                if ($this.isInViewport()) {
                    $({ Counter: 0 }).animate({
                        Counter: target
                    }, {
                        duration: 2000,
                        easing: 'swing',
                        step: function() {
                            $this.text(Math.ceil(this.Counter));
                        },
                        complete: function() {
                            $this.text(target);
                        }
                    });
                    
                    // Remove the data-target to prevent re-animation
                    $this.removeAttr('data-target');
                }
            });
        }
        
        // Check if element is in viewport
        $.fn.isInViewport = function() {
            const elementTop = $(this).offset().top;
            const elementBottom = elementTop + $(this).outerHeight();
            const viewportTop = $(window).scrollTop();
            const viewportBottom = viewportTop + $(window).height();
            return elementBottom > viewportTop && elementTop < viewportBottom;
        };
        
        // Run counter animation on scroll
        $(window).on('scroll', animateCounters);
        animateCounters(); // Run once on page load
        
        // Feature card hover animation for desktop
        if (window.matchMedia('(min-width: 768px)').matches) {
            $('.feature-card').mouseenter(function() {
                $(this).find('svg').addClass('animate-bounce');
                setTimeout(() => {
                    $(this).find('svg').removeClass('animate-bounce');
                }, 1000);
            });
        }
        
        // Back to top button
        $(window).scroll(function() {
            if ($(this).scrollTop() > 300) {
                $('#back-to-top').css({
                    opacity: '1',
                    visibility: 'visible'
                });
            } else {
                $('#back-to-top').css({
                    opacity: '0',
                    visibility: 'hidden'
                });
            }
        });
        
        $('#back-to-top').click(function() {
            $('html, body').animate({
                scrollTop: 0
            }, 800);
            return false;
        });
        
        // Add to cart functionality with improved animation
        $('.add-to-cart').click(function() {
            const $btn = $(this);
            const productId = $btn.data('product-id');
            
            // Add loading animation
            $btn.prop('disabled', true).html('<span class="loader"></span>');
            
            // AJAX request to add item to cart
            $.ajax({
                url: `/cart/add/${productId}`,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // Cart button animation
                    const $cartBtn = $('#quick-shop-toggle');
                    $cartBtn.addClass('animate__animated animate__rubberBand');
                    setTimeout(() => {
                        $cartBtn.removeClass('animate__animated animate__rubberBand');
                    }, 1000);
                    
                    // Show success message
                    Swal.fire({
                        title: 'Added to Cart!',
                        text: 'Product has been added to your cart',
                        icon: 'success',
                        confirmButtonColor: '#dc3545',
                        showClass: {
                            popup: 'animate__animated animate__fadeInDown'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutUp'
                        }
                    });
                    
                    // Update cart count in navbar and quick cart
                    $('#cart-count, #quick-cart-count').text(response.cartCount);
                    
                    // Reset button
                    $btn.prop('disabled', false).html(`
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
    </svg>
    Add to Cart
`);
                },
                error: function(xhr) {
                    // Error handling
                    Swal.fire({
                        title: 'Error!',
                        text: xhr.responseJSON?.message || 'Could not add product to cart',
                        icon: 'error',
                        confirmButtonColor: '#dc3545'
                    });
                    
                    // Reset button
                    $btn.prop('disabled', false).html(`
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Add to Cart
                    `);
                }
            });
        });
        
        // Quick Shop functionality
        $('#quick-shop-toggle').click(function() {
            $('#quick-shop-panel').toggleClass('hidden');
        });
        
        $('#close-quick-shop').click(function() {
            $('#quick-shop-panel').addClass('hidden');
        });
        
        // Quick search functionality
        $('#quick-search').on('input', function() {
            const query = $(this).val();
            if (query.length > 2) {
                // AJAX request to search products
                $.ajax({
                    url: '/search',
                    method: 'GET',
                    data: { query: query },
                    success: function(data) {
                        let productsHtml = '';
                        
                        if (data.products.length > 0) {
                            data.products.forEach(product => {
                                productsHtml += `
                                    <div class="flex items-center p-2 hover:bg-gray-100 rounded-lg cursor-pointer quick-product-item" data-product-id="${product.id}">
                                        <img src="${product.image}" alt="${product.name}" class="w-12 h-12 object-cover rounded">
                                        <div class="ml-3 flex-grow">
                                            <h4 class="font-medium text-sm">${product.name}</h4>
                                            <p class="text-red-600 text-xs font-bold">${product.price}</p>
                                        </div>
                                        <button class="quick-add-to-cart bg-red-600 hover:bg-red-700 text-white rounded-full p-1" data-product-id="${product.id}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                            </svg>
                                        </button>
                                    </div>
                                `;
                            });
                        } else {
                            productsHtml = '<div class="text-center text-gray-500 py-4">No products found</div>';
                        }
                        
                        $('#quick-products').html(productsHtml);
                    }
                });
            } else if (query.length === 0) {
                $('#quick-products').html('<div class="text-center text-gray-500 py-4">Type to search products...</div>');
            }
        });
        
        // Handle clicking on product in quick search
        $(document).on('click', '.quick-product-item', function() {
            const productId = $(this).data('product-id');
            showQuickView(productId);
        });
        
        // Quick add to cart from search results
        $(document).on('click', '.quick-add-to-cart', function(e) {
            e.stopPropagation();
            const productId = $(this).data('product-id');
            
            // AJAX request to add item to cart
            $.ajax({
                url: `/cart/add/${productId}`,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // Update cart count
                    $('#cart-count, #quick-cart-count').text(response.cartCount);
                    
                    // Show mini notification
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Added to cart',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });
        });
        
        // Quick view product functionality
        function showQuickView(productId) {
            $('#quick-view-modal').removeClass('hidden');
            
            // AJAX request to get product details
            $.ajax({
                url: `/products/${productId}/quick-view`,
                method: 'GET',
                success: function(data) {
                    $('#modal-content').html(data);
                },
                error: function() {
                    $('#modal-content').html(`
                        <div class="text-center py-8">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-red-600 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="text-lg font-bold mb-2">Error Loading Product</h3>
                            <p class="text-gray-500">Unable to load product details. Please try again.</p>
                        </div>
                    `);
                }
            });
        }
        
        // Close modal when clicking overlay or close button
        $('#modal-overlay, #close-modal').click(function() {
            $('#quick-view-modal').addClass('hidden');
        });
        
        // Newsletter form submission
        $('#newsletter-form').submit(function(e) {
            e.preventDefault();
            const email = $(this).find('input[type="email"]').val();
            
            // AJAX request to subscribe to newsletter
            $.ajax({
                url: '/newsletter/subscribe',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: { email: email },
                success: function() {
                    Swal.fire({
                        title: 'Thank You!',
                        text: 'You have successfully subscribed to our newsletter',
                        icon: 'success',
                        confirmButtonColor: '#dc3545'
                    });
                    $('#newsletter-form')[0].reset();
                },
                error: function() {
                    Swal.fire({
                        title: 'Oops!',
                        text: 'Something went wrong. Please try again.',
                        icon: 'error',
                        confirmButtonColor: '#dc3545'
                    });
                }
            });
        });
    });
</script>