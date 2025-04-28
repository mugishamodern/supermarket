{{-- resources/views/categories/index.blade.php --}}
@extends('layouts.app')

@section('content')
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">All Categories</h2>
            <div class="w-24 h-1 bg-red-600 mx-auto"></div>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($categories as $category)
            <div class="category-item" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <a href="{{ route('categories.show', $category->slug) }}" class="block">
                    <div class="category-card bg-white rounded-xl overflow-hidden shadow-md">
                        <div class="relative overflow-hidden">
                            <img src="{{ $category->image ? asset('storage/'.$category->image) : asset('images/category-placeholder.jpg') }}" 
                                alt="{{ $category->name }}" 
                                class="w-full h-48 object-cover transform hover:scale-110 transition duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent flex items-end">
                                <h5 class="text-white font-semibold p-4 text-lg">{{ $category->name }}</h5>
                            </div>
                        </div>
                        <div class="p-4 text-center">
                            <p class="text-gray-600 mb-3">{{ Str::limit($category->description, 60) }}</p>
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
@endsection