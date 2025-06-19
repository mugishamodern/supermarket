@extends('layouts.app')

@section('title', 'My Wishlist - Mukora Supermarket')

@section('styles')
<link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
@endsection

@include('partials.header')

@section('content')
<!-- Hero Section -->
<section class="hero-section flex items-center justify-center">
    <div class="container mx-auto text-center px-4">
        <h1 class="text-4xl md:text-6xl font-bold mb-4 text-white animate__animated animate__fadeInDown">My Wishlist</h1>
        <p class="text-lg md:text-xl text-white animate__animated animate__fadeInUp animate__delay-1s">Save your favorite products for later</p>
    </div>
</section>

<!-- Wishlist Content -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="mb-8" data-aos="fade-up">
            <nav aria-label="breadcrumb">
                <ol class="flex space-x-2 text-sm text-gray-600">
                    <li><a href="{{ route('products.index') }}" class="text-red-600 hover:underline">Home</a></li>
                    <li><span class="text-gray-400">/</span></li>
                    <li class="text-gray-800">My Wishlist</li>
                </ol>
            </nav>
        </div>

        @if(count($wishlistItems) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($wishlistItems as $item)
                    <div class="wishlist-card bg-white rounded-xl shadow-md overflow-hidden" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="relative">
                            <img src="{{ $item->product->image ? asset('storage/'.$item->product->image) : asset('images/product-placeholder.jpg') }}" 
                                 alt="{{ $item->product->name }}" 
                                 class="w-full h-48 object-cover">
                            
                            <!-- Remove from wishlist button -->
                            <form action="{{ route('wishlist.remove', $item->id) }}" method="POST" class="absolute top-2 right-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white rounded-full w-8 h-8 flex items-center justify-center transition">
                                    <i class="fas fa-times text-sm"></i>
                                </button>
                            </form>
                        </div>
                        
                        <div class="p-4">
                            <h3 class="text-lg font-semibold mb-2">{{ $item->product->name }}</h3>
                            <p class="text-gray-600 text-sm mb-3">{{ Str::limit($item->product->description, 80) }}</p>
                            
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-red-600 font-bold text-lg">UGX {{ number_format($item->product->price) }}</span>
                                <span class="text-sm text-gray-500">{{ $item->product->category->name ?? 'Uncategorized' }}</span>
                            </div>
                            
                            <div class="flex space-x-2">
                                <form action="{{ route('wishlist.move-to-cart', $item->id) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition">
                                        <i class="fas fa-cart-plus mr-2"></i> Add to Cart
                                    </button>
                                </form>
                                
                                <a href="{{ route('products.show', $item->product->slug) }}" 
                                   class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded-lg transition">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-8 text-center" data-aos="fade-up" data-aos-delay="500">
                <a href="{{ route('products.index') }}" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-8 rounded-lg transition transform hover:scale-105">
                    <i class="fas fa-shopping-bag mr-2"></i> Continue Shopping
                </a>
            </div>
        @else
            <div class="text-center py-16" data-aos="fade-up">
                <i class="fas fa-heart text-6xl text-gray-400 mb-4"></i>
                <h3 class="text-2xl font-semibold mb-4">Your Wishlist is Empty</h3>
                <p class="text-gray-600 mb-6">Start adding products to your wishlist to save them for later.</p>
                <div class="flex justify-center gap-4">
                    <a href="{{ route('products.index') }}" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-8 rounded-lg transition transform hover:scale-105">
                        Start Shopping
                    </a>
                    <a href="{{ route('cart.index') }}" class="bg-white border border-gray-800 text-gray-800 hover:bg-gray-800 hover:text-white font-semibold py-3 px-8 rounded-lg transition transform hover:scale-105">
                        <i class="fas fa-shopping-cart mr-2"></i> View Cart
                    </a>
                </div>
            </div>
        @endif
    </div>
</section>

@include('partials.footer')
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        AOS.init();
        
        // Show success/error messages
        @if(session('success'))
            Swal.fire({
                title: 'Success!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonColor: '#dc3545'
            });
        @endif
        
        @if(session('error'))
            Swal.fire({
                title: 'Error!',
                text: '{{ session('error') }}',
                icon: 'error',
                confirmButtonColor: '#dc3545'
            });
        @endif
    });
</script>
@endsection 