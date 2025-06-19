@extends('layouts.app')

@section('title', 'Submit Feedback - Mukora Supermarket')

@section('styles')
<!-- Including the same styles from home page -->
<link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
@endsection

@include('partials.header')

@section('content')
<!-- Hero Section -->
<section class="feedback-section flex items-center justify-center">
    <div class="container mx-auto text-center px-4">
        <h1 class="text-4xl md:text-5xl font-bold mb-4 text-white animate__animated animate__fadeInDown">Share Your Experience</h1>
        <p class="text-xl mb-6 text-white animate__animated animate__fadeInUp animate__delay-1s">We value your feedback to improve our services</p>
    </div>
</section>

<!-- Feedback Form Section -->
<section class="py-16">
    <div class="container mx-auto px-4 max-w-3xl">
        @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-8 rounded-lg shadow-md fade-in" role="alert">
            <div class="flex items-center">
                <svg class="h-6 w-6 text-green-500 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-medium">Success!</span>
                <span class="ml-2">{{ session('success') }}</span>
            </div>
        </div>
        @endif

        <div class="form-card bg-white rounded-2xl shadow-lg p-8 animate__animated animate__fadeInUp">
            <div class="mb-8 text-center">
                <h2 class="text-3xl font-bold mb-4">Submit Your Feedback</h2>
                <div class="w-24 h-1 bg-red-600 mx-auto"></div>
                <p class="text-gray-600 mt-4">Your opinion helps us serve you better</p>
            </div>

            <form action="{{ route('feedback.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-gray-700 font-medium mb-2">Your Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600 focus:border-transparent transition">
                        @error('name')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="location" class="block text-gray-700 font-medium mb-2">Your Location</label>
                        <input type="text" name="location" id="location" value="{{ old('location') }}" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600 focus:border-transparent transition">
                        @error('location')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div>
                    <label for="message" class="block text-gray-700 font-medium mb-2">Your Message</label>
                    <textarea name="message" id="message" rows="5" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600 focus:border-transparent transition">{{ old('message') }}</textarea>
                    @error('message')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="photo" class="block text-gray-700 font-medium mb-2">Upload Your Photo (optional)</label>
                    <div class="flex items-center justify-center w-full">
                        <label for="photo" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                            </div>
                            <input id="photo" name="photo" type="file" class="hidden" accept="image/*" />
                        </label>
                    </div>
                    @error('photo')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="rating" class="block text-gray-700 font-medium mb-2">Your Rating</label>
                    <div class="flex items-center space-x-1">
                        <input type="range" name="rating" id="rating" min="1" max="5" step="0.1" value="{{ old('rating', 5) }}" required
                            class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                        <span id="rating-value" class="text-lg font-bold ml-4 text-red-600">5.0</span>
                    </div>
                    @error('rating')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="text-center pt-4">
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-8 rounded-full transition transform hover:scale-105 pulse-button">
                        Submit Feedback
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- Why Your Feedback Matters Section -->
<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold mb-4">Why Your Feedback Matters</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">At Mukora Supermarket, we're committed to continuous improvement through your valuable input.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center p-6 bg-white rounded-xl shadow-md hover:shadow-xl transition">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <h5 class="font-bold text-lg mb-2">Improve Our Products</h5>
                <p class="text-gray-600">Your feedback helps us stock what you need and love.</p>
            </div>
            
            <div class="text-center p-6 bg-white rounded-xl shadow-md hover:shadow-xl transition">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                    </svg>
                </div>
                <h5 class="font-bold text-lg mb-2">Enhance Service</h5>
                <p class="text-gray-600">We continuously train our staff based on your comments.</p>
            </div>
            
            <div class="text-center p-6 bg-white rounded-xl shadow-md hover:shadow-xl transition">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h5 class="font-bold text-lg mb-2">Innovate</h5>
                <p class="text-gray-600">Your ideas inspire new services and shopping experiences.</p>
            </div>
        </div>
    </div>
</section>

<script>
    // Update rating value display
    const ratingSlider = document.getElementById('rating');
    const ratingValue = document.getElementById('rating-value');
    
    if(ratingSlider && ratingValue) {
        ratingSlider.addEventListener('input', function() {
            ratingValue.textContent = parseFloat(this.value).toFixed(1);
        });
    }
</script>
@endsection