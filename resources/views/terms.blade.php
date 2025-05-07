@extends('layouts.app')

@section('title', 'Terms and Conditions - Mukora Supermarket')

@section('styles')
<link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
<style>
    .hero-section {
        background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('/uploads/images/supermarket-bg.jpg');
        background-size: cover;
        background-position: center;
        height: 60vh;
    }
    .fade-in {
        animation: fadeIn 0.8s ease-in forwards;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
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
<!-- Hero Section -->
<section class="hero-section flex items-center justify-center parallax">
    <div class="container mx-auto text-center px-4">
        <h1 class="text-4xl md:text-6xl font-bold mb-4 text-white animate__animated animate__fadeInDown">Terms and Conditions</h1>
        <p class="text-lg md:text-xl text-white animate__animated animate__fadeInUp animate__delay-1s">Understand the terms of using our services</p>
    </div>
</section>

<!-- Terms Content -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-3xl font-bold mb-6" data-aos="fade-up">Terms of Service</h2>
            <div class="space-y-8" data-aos="fade-up" data-aos-delay="100">
                <div>
                    <h3 class="text-xl font-semibold mb-2">1. Acceptance of Terms</h3>
                    <p class="text-gray-600">By accessing or using the Mukora Supermarket website, you agree to be bound by these Terms and Conditions. If you do not agree, please do not use our services.</p>
                </div>
                <div>
                    <h3 class="text-xl font-semibold mb-2">2. Use of the Website</h3>
                    <p class="text-gray-600">You agree to use the website for lawful purposes only. You must not use the website to engage in any activity that violates local or international laws.</p>
                </div>
                <div>
                    <h3 class="text-xl font-semibold mb-2">3. Product Information</h3>
                    <p class="text-gray-600">We strive to provide accurate product descriptions and pricing. However, we do not warrant that all information is error-free. Prices and availability are subject to change without notice.</p>
                </div>
                <div>
                    <h3 class="text-xl font-semibold mb-2">4. Orders and Payments</h3>
                    <p class="text-gray-600">All orders are subject to acceptance and availability. We reserve the right to refuse or cancel orders at our discretion. Payments must be made through our secure payment gateways.</p>
                </div>
                <div>
                    <h3 class="text-xl font-semibold mb-2">5. Returns and Refunds</h3>
                    <p class="text-gray-600">We offer a no-questions-asked return policy within 14 days of purchase, provided items are in their original condition. Refunds will be processed within 7 business days.</p>
                </div>
                <div>
                    <h3 class="text-xl font-semibold mb-2">6. Limitation of Liability</h3>
                    <p class="text-gray-600">Mukora Supermarket shall not be liable for any indirect, incidental, or consequential damages arising from the use of our website or products.</p>
                </div>
                <div>
                    <h3 class="text-xl font-semibold mb-2">7. Changes to Terms</h3>
                    <p class="text-gray-600">We may update these Terms and Conditions from time to time. Changes will be posted on this page, and continued use of the website constitutes acceptance of the updated terms.</p>
                </div>
                <div>
                    <h3 class="text-xl font-semibold mb-2">8. Contact Us</h3>
                    <p class="text-gray-600">If you have any questions about these Terms, please contact us at <a href="mailto:info@mukorasupermarket.com" class="text-red-600 hover:underline">info@mukorasupermarket.com</a>.</p>
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