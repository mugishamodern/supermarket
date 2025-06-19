@extends('layouts.app')

@section('title', 'About Us - Mukora Supermarket')

@section('styles')
<link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
@endsection

@include('partials.header')

@section('content')
<!-- Hero Section -->
<section class="hero-section flex items-center justify-center parallax">
    <div class="container mx-auto text-center px-4">
        <h1 class="text-4xl md:text-6xl font-bold mb-4 text-white animate__animated animate__fadeInDown">About Mukora Supermarket</h1>
        <p class="text-lg md:text-xl text-white animate__animated animate__fadeInUp animate__delay-1s">Serving Kasese with Quality and Care Since 2015</p>
    </div>
</section>

<!-- Our Story Section -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12" data-aos="fade-up">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Our Story</h2>
            <div class="w-24 h-1 bg-red-600 mx-auto mb-4"></div>
            <p class="text-gray-600 max-w-2xl mx-auto">Mukora Supermarket was founded with a vision to bring quality products and exceptional service to the heart of Kasese. Since our establishment in 2015, we've grown from a small family-run store to Kasese's premier shopping destination, supporting local farmers and serving our community with pride.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="flex justify-center" data-aos="fade-right">
                <img src="{{ asset('/uploads/images/store.png') }}" alt="Our Store" class="rounded-xl shadow-lg object-cover w-full h-96">
            </div>
            <div class="flex flex-col justify-center" data-aos="fade-left">
                <h3 class="text-2xl font-semibold mb-4">A Commitment to Community</h3>
                <p class="text-gray-600 mb-4">We partner with local farmers and suppliers to bring fresh, high-quality products to our shelves. Our dedication to sustainability and community support has made us a trusted name in Kasese.</p>
                <a href="#contact" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-6 rounded-lg w-max transition transform hover:scale-105">Contact Us</a>
            </div>
        </div>
    </div>
</section>

<!-- Our Mission, Vision, and Values -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12" data-aos="fade-up">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Our Core Principles</h2>
            <div class="w-24 h-1 bg-red-600 mx-auto"></div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="value-card bg-gray-50 p-6 rounded-xl shadow-md text-center" data-aos="fade-up" data-aos-delay="100">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Our Mission</h3>
                <p class="text-gray-600 text-sm">To provide high-quality products at affordable prices while fostering community growth and sustainability.</p>
            </div>
            <div class="value-card bg-gray-50 p-6 rounded-xl shadow-md text-center" data-aos="fade-up" data-aos-delay="200">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Our Vision</h3>
                <p class="text-gray-600 text-sm">To be the leading supermarket in Kasese, known for exceptional service and community engagement.</p>
            </div>
            <div class="value-card bg-gray-50 p-6 rounded-xl shadow-md text-center" data-aos="fade-up" data-aos-delay="300">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Our Values</h3>
                <p class="text-gray-600 text-sm">Integrity, quality, and community are at the heart of everything we do.</p>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="py-16 bg-gray-100">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12" data-aos="fade-up">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Meet Our Team</h2>
            <div class="w-24 h-1 bg-red-600 mx-auto"></div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            @foreach([
                ['name' => 'Mr Mukora', 'role' => 'Founder & CEO', 'image' => '/uploads/images/john.jpg'],
                ['name' => 'Mukora Collins', 'role' => 'Store Manager', 'image' => '/uploads/images/john.jpg'],
                ['name' => 'Mukora Canary', 'role' => 'Operations Lead', 'image' => '/uploads/images/john.jpg'],
                ['name' => 'Mukora Clinton', 'role' => 'Customer Service Head', 'image' => '/uploads/images/john.jpg']
            ] as $member)
            <div class="bg-white rounded-xl shadow-md overflow-hidden" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <img src="{{ asset($member['image']) }}" alt="{{ $member['name'] }}" class="w-full h-64 object-cover">
                <div class="p-4 text-center">
                    <h5 class="text-lg font-semibold">{{ $member['name'] }}</h5>
                    <p class="text-gray-600 text-sm">{{ $member['role'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-16 bg-red-600 text-white">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-4" data-aos="fade-up">Join Our Community</h2>
        <p class="text-lg mb-6 max-w-2xl mx-auto" data-aos="fade-up" data-aos-delay="100">Shop with us today and experience the Mukora difference. Your satisfaction is our priority!</p>
        <a href="{{ route('products.index') }}" class="bg-white text-red-600 font-semibold py-3 px-8 rounded-lg hover:bg-gray-100 transition transform hover:scale-105" data-aos="fade-up" data-aos-delay="200">Shop Now</a>
    </div>
</section>
@include('partials.footer')
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        AOS.init({
            duration: 800,
            once: true
        });
    });
</script>
@endsection