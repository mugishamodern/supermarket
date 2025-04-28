{{-- resources/views/categories/show.blade.php --}}
@extends('layouts.app')

@section('content')
<section class="py-16">
    <div class="container mx-auto px-4">
        <!-- Category Header -->
        <div class="flex flex-col items-center mb-12">
            <div class="relative w-full h-64 md:h-80 mb-6 rounded-xl overflow-hidden">
                <img src="{{ $category->image ? asset('storage/'.$category->image) : asset('images/category-placeholder.jpg') }}" 
                    alt="{{ $category->name }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
                    <h1 class="text-4xl md:text-5xl font-bold text-white">{{ $category->name }}</h1>
                </div>
            </div>
            @if($category->description)
            <div class="max-w-3xl text-center">
                <p class="text-gray-700">{{ $category->description }}</p>
            </div>
            @endif
            <div class="w-24 h-1 bg-red-600 mt-6"></div>
        </div>
        
        <!-- Products Grid -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold mb-6">Products in this category</h2>
            
            @if($products->count() > 0)
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($products as $product)
                <div class="product-card bg-white rounded-xl overflow-hidden shadow-md" data-aos="fade-up">
                    <a href="{{ route('products.show', $product->slug) }}">
                        <div class="relative overflow-hidden">
                            <img src="{{ $product->image ? asset('storage/'.$product->image) : asset('images/product-placeholder.jpg') }}" 
                                alt="{{ $product->name }}" 
                                class="w-full h-48 object-cover transform hover:scale-110 transition duration-500">
                            @if($product->is_featured)
                            <span class="absolute top-2 right-2 bg-red-600 text-white text-xs px-2 py-1 rounded">Featured</span>
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="font-medium text-lg mb-1">{{ $product->name }}</h3>
                            <p class="text-gray-500 text-sm mb-2">{{ Str::limit($product->short_description, 60) }}</p>
                            <div class="flex justify-between items-center">
                                <span class="font-bold text-red-600">${{ number_format($product->price, 2) }}</span>
                                <button class="add-to-cart px-3 py-1 bg-gray-200 hover:bg-red-600 hover:text-white rounded transition">
                                    <i class="fas fa-shopping-cart mr-1"></i> Add
                                </button>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            
            <div class="mt-8">
                {{ $products->links() }}
            </div>
            @else
            <div class="text-center py-12 bg-gray-50 rounded-lg">
                <p class="text-gray-500">No products found in this category.</p>
                <a href="{{ route('products.index') }}" class="inline-block mt-4 px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                    Browse All Products
                </a>
            </div>
            @endif
        </div>
        
        <!-- Related Categories -->
        @if($relatedCategories->count() > 0)
        <div>
            <h2 class="text-2xl font-bold mb-6">Related Categories</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($relatedCategories as $relCategory)
                <a href="{{ route('categories.show', $relCategory->slug) }}" 
                   class="bg-white p-4 rounded-lg shadow-sm hover:shadow-md transition flex items-center space-x-3">
                    <div class="w-12 h-12 rounded-full overflow-hidden">
                        <img src="{{ $relCategory->image ? asset('storage/'.$relCategory->image) : asset('images/category-placeholder.jpg') }}" 
                             alt="{{ $relCategory->name }}" class="w-full h-full object-cover">
                    </div>
                    <span class="font-medium">{{ $relCategory->name }}</span>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>
@endsection