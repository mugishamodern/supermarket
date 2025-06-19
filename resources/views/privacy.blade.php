@extends('layouts.app')

@section('title', 'Privacy Policy - Mukora Supermarket')

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
        <h1 class="text-4xl md:text-6xl font-bold mb-4 text-white animate__animated animate__fadeInDown">Privacy Policy</h1>
        <p class="text-lg md:text-xl text-white animate__animated animate__fadeInUp animate__delay-1s">Your privacy matters to us</p>
    </div>
</section>

<!-- Privacy Policy Content -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-3xl font-bold mb-6" data-aos="fade-up">Our Privacy Commitment</h2>
            <div class="space-y-8" data-aos="fade-up" data-aos-delay="100">
                <div>
                    <h3 class="text-xl font-semibold mb-2">1. Introduction</h3>
                    <p class="text-gray-600">At Mukora Supermarket, we are committed to protecting your privacy. This Privacy Policy explains how we collect, use, and safeguard your personal information when you use our website.</p>
                </div>
                <div>
                    <h3 class="text-xl font-semibold mb-2">2. Information We Collect</h3>
                    <p class="text-gray-600">We may collect personal information such as your name, email address, phone number, and payment details when you place an order, subscribe to our newsletter, or contact us.</p>
                </div>
                <div>
                    <h3 class="text-xl font-semibold mb-2">3. How We Use Your Information</h3>
                    <p class="text-gray-600">Your information is used to process orders, improve our services, send promotional offers, and respond to inquiries. We do not sell or share your information with third parties except as required by law or to fulfill your orders.</p>
                </div>
                <div>
                    <h3 class="text-xl font-semibold mb-2">4. Cookies</h3>
                    <p class="text-gray-600">We use cookies to enhance your browsing experience, analyze website traffic, and personalize content. You can manage cookie preferences through your browser settings.</p>
                </div>
                <div>
                    <h3 class="text-xl font-semibold mb-2">5. Data Security</h3>
                    <p class="text-gray-600">We implement industry-standard security measures to protect your data. However, no method of transmission over the internet is 100% secure, and we cannot guarantee absolute security.</p>
                </div>
                <div>
                    <h3 class="text-xl font-semibold mb-2">6. Your Rights</h3>
                    <p class="text-gray-600">You have the right to access, correct, or delete your personal information. Contact us at <a href="mailto:info@mukorasupermarket.com" class="text-red-600 hover:underline">info@mukorasupermarket.com</a> to exercise these rights.</p>
                </div>
                <div>
                    <h3 class="text-xl font-semibold mb-2">7. Changes to This Policy</h3>
                    <p class="text-gray-600">We may update this Privacy Policy from time to time. Changes will be posted on this page, and we encourage you to review it periodically.</p>
                </div>
                <div>
                    <h3 class="text-xl font-semibold mb-2">8. Contact Us</h3>
                    <p class="text-gray-600">If you have any questions about this Privacy Policy, please contact us at <a href="mailto:info@mukorasupermarket.com" class="text-red-600 hover:underline">info@mukorasupermarket.com</a>.</p>
                </div>
            </div>
        </div>
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