@extends('layouts.app')

@section('title', 'FAQs - Mukora Supermarket')

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
        <h1 class="text-4xl md:text-6xl font-bold mb-4 text-white animate__animated animate__fadeInDown">Frequently Asked Questions</h1>
        <p class="text-lg md:text-xl text-white animate__animated animate__fadeInUp animate__delay-1s">Find answers to common questions about shopping with Mukora Supermarket</p>
    </div>
</section>

<!-- FAQs Content -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="faq-card bg-white rounded-xl shadow-md p-6" data-aos="fade-up" data-aos-delay="100">
            <h2 class="text-3xl font-bold mb-6 text-gray-800">FAQs</h2>
            <div x-data="{ open: 0 }" class="space-y-2">
                <!-- FAQ 1 -->
                <div class="border-b">
                    <button @click="open === 1 ? open = 0 : open = 1" class="w-full flex justify-between items-center py-4 text-left focus:outline-none">
                        <span class="font-semibold text-lg text-gray-800">How do I place an order on Mukora Supermarket?</span>
                        <svg :class="{'transform rotate-180': open === 1}" class="h-5 w-5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div x-show="open === 1" x-collapse class="pb-4 text-gray-600">
                        To place an order, browse our <a href="{{ route('products.index') }}" class="text-red-600 hover:underline">products</a>, add items to your cart, and proceed to checkout. You'll need to select a delivery address, choose a payment method (Cash on Delivery or MTN MomoPay), and confirm your order. You must be logged in to complete the checkout process.
                    </div>
                </div>
                <!-- FAQ 2 -->
                <div class="border-b">
                    <button @click="open === 2 ? open = 0 : open = 2" class="w-full flex justify-between items-center py-4 text-left focus:outline-none">
                        <span class="font-semibold text-lg text-gray-800">What payment methods do you accept?</span>
                        <svg :class="{'transform rotate-180': open === 2}" class="h-5 w-5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div x-show="open === 2" x-collapse class="pb-4 text-gray-600">
                        We accept <strong>Cash on Delivery</strong> (pay when your order arrives) and <strong>MTN MomoPay</strong> (pay securely via MTN Mobile Money). During checkout, select your preferred method and follow the instructions.
                    </div>
                </div>
                <!-- FAQ 3 -->
                <div class="border-b">
                    <button @click="open === 3 ? open = 0 : open = 3" class="w-full flex justify-between items-center py-4 text-left focus:outline-none">
                        <span class="font-semibold text-lg text-gray-800">What are your delivery areas and fees?</span>
                        <svg :class="{'transform rotate-180': open === 3}" class="h-5 w-5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div x-show="open === 3" x-collapse class="pb-4 text-gray-600">
                        We offer free delivery within Kasese Town and surrounding areas. For other locations in Uganda, please <a href="{{ route('contact') }}" class="text-red-600 hover:underline">contact us</a> to confirm availability and any applicable fees.
                    </div>
                </div>
                <!-- FAQ 4 -->
                <div class="border-b">
                    <button @click="open === 4 ? open = 0 : open = 4" class="w-full flex justify-between items-center py-4 text-left focus:outline-none">
                        <span class="font-semibold text-lg text-gray-800">How long does delivery take?</span>
                        <svg :class="{'transform rotate-180': open === 4}" class="h-5 w-5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div x-show="open === 4" x-collapse class="pb-4 text-gray-600">
                        Delivery within Kasese Town typically takes 1–2 business days after order confirmation. For other areas, delivery may take 3–5 business days, depending on your location. You can track your order status in the <a href="{{ route('orders.index') }}" class="text-red-600 hover:underline">My Orders</a> section.
                    </div>
                </div>
                <!-- FAQ 5 -->
                <div class="border-b">
                    <button @click="open === 5 ? open = 0 : open = 5" class="w-full flex justify-between items-center py-4 text-left focus:outline-none">
                        <span class="font-semibold text-lg text-gray-800">Can I return or exchange an item?</span>
                        <svg :class="{'transform rotate-180': open === 5}" class="h-5 w-5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div x-show="open === 5" x-collapse class="pb-4 text-gray-600">
                        Yes, we accept returns or exchanges within 7 days of delivery, provided the item is unused and in its original packaging. Please review our <a href="{{ route('refund') }}" class="text-red-600 hover:underline">Refund Policy</a> and <a href="{{ route('contact') }}" class="text-red-600 hover:underline">contact us</a> to initiate a return.
                    </div>
                </div>
                <!-- FAQ 6 -->
                <div class="border-b">
                    <button @click="open === 6 ? open = 0 : open = 6" class="w-full flex justify-between items-center py-4 text-left focus:outline-none">
                        <span class="font-semibold text-lg text-gray-800">How do I use MTN MomoPay to pay for my order?</span>
                        <svg :class="{'transform rotate-180': open === 6}" class="h-5 w-5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div x-show="open === 6" x-collapse class="pb-4 text-gray-600">
                        At checkout, select MTN MomoPay, enter your MTN Mobile Money number (e.g., 25677XXXXXXX), and submit your order. You'll receive a prompt on your phone to authorize the payment using your MTN Mobile Money PIN. Once confirmed, your order status will update in the <a href="{{ route('orders.index') }}" class="text-red-600 hover:underline">My Orders</a> section.
                    </div>
                </div>
                <!-- FAQ 7 -->
                <div class="border-b">
                    <button @click="open === 7 ? open = 0 : open = 7" class="w-full flex justify-between items-center py-4 text-left focus:outline-none">
                        <span class="font-semibold text-lg text-gray-800">What should I do if I have an issue with my order?</span>
                        <svg :class="{'transform rotate-180': open === 7}" class="h-5 w-5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div x-show="open === 7" x-collapse class="pb-4 text-gray-600">
                        If you encounter any issues, please <a href="{{ route('contact') }}" class="text-red-600 hover:underline">contact us</a> via email (info@mukorasupermarket.com) or phone (+256 776 123456). You can also submit feedback through our <a href="{{ route('feedback.create') }}" class="text-red-600 hover:underline">Feedback</a> page.
                    </div>
                </div>
                <!-- FAQ 8 -->
                <div>
                    <button @click="open === 8 ? open = 0 : open = 8" class="w-full flex justify-between items-center py-4 text-left focus:outline-none">
                        <span class="font-semibold text-lg text-gray-800">Do you offer promotions or discounts?</span>
                        <svg :class="{'transform rotate-180': open === 8}" class="h-5 w-5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div x-show="open === 8" x-collapse class="pb-4 text-gray-600">
                        Yes, we regularly offer special deals and discounts. Check our <a href="{{ route('promotions') }}" class="text-red-600 hover:underline">Special Offers</a> page for the latest promotions or follow us on social media for updates.
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact CTA -->
        <div class="text-center mt-8" data-aos="fade-up" data-aos-delay="200">
            <p class="text-gray-600 mb-4">Still have questions? We're here to help!</p>
            <a href="{{ route('contact') }}" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-8 rounded-lg transition transform hover:scale-105">
                <i class="fas fa-envelope mr-2"></i> Contact Us
            </a>
        </div>
    </div>
</section>
@include('partials.footer')
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        AOS.init({
            duration: 800,
            once: true, // Ensures animations don't retrigger on scroll
            disable: 'mobile' // Disable AOS on mobile to prevent conflicts
        });
    });
</script>
@endsection