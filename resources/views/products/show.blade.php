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
                        <!-- Product Images Gallery -->
                        <div class="col-lg-6 mb-4">
                            <div x-data="{ active: 0, images: {{ json_encode($product->images ?? ($product->image ? [$product->image] : [])) }} }">
                                <template x-if="images.length">
                                    <img :src="'/storage/' + images[active]" alt="{{ $product->name }}" class="img-fluid rounded w-100 mb-3" style="max-height: 400px; object-fit: cover;" loading="lazy">
                                </template>
                                <template x-if="!images.length">
                                    <img src="{{ asset('images/product-placeholder.jpg') }}" alt="{{ $product->name }}" class="img-fluid rounded w-100 mb-3" style="max-height: 400px; object-fit: cover;" loading="lazy">
                                </template>
                                <div class="flex gap-2 mt-2" x-show="images.length > 1">
                                    <template x-for="(img, idx) in images" :key="idx">
                                        <img :src="'/storage/' + img" @click="active = idx" :class="{'ring-2 ring-red-500': active === idx}" class="h-16 w-16 object-cover rounded cursor-pointer border transition-all duration-200" loading="lazy">
                                    </template>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Product Details -->
                        <div class="col-lg-6">
                            <h1 class="mb-3">{{ $product->name }}</h1>
                            <p class="text-muted mb-4">{{ $product->description }}</p>
                            @php $promotion = $product->activePromotion(); @endphp
                            <div class="mb-4">
                                @if($promotion)
                                    <span class="inline-block bg-red-600 text-white text-xs font-bold px-2 py-1 rounded mb-2">{{ $promotion->discount_percentage }}% OFF</span><br>
                                    <span class="fw-bold text-danger fs-3">UGX {{ number_format($product->discountedPrice()) }}</span>
                                    <span class="line-through text-gray-400 text-base ml-2">UGX {{ number_format($product->price) }}</span>
                                @else
                                    <span class="fw-bold text-danger fs-3">UGX {{ number_format($product->price) }}</span>
                                @endif
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
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection
@endsection