@extends('layouts.app')

@section('title', 'FAQs - Mukora Supermarket')

@section('styles')
<link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
<style>
    .hero-section {
        background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('/Uploads/images/supermarket-bg.jpg');
        background-size: cover;
        background-position: center;
        height: 60vh;
    }
    .faq-card {
        transition: all 0.3s ease;
    }
    .faq-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
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
    .accordion-button {
        color: #343a40;
        background-color: #ffffff;
        font-weight: 600;
        transition: background-color 0.2s ease, color 0.2s ease;
    }
    .accordion-button:not(.collapsed) {
        color: #dc3545;
        background-color: #f8f9fa;
    }
    .accordion-button:focus {
        box-shadow: none;
        border-color: rgba(0, 0, 0, 0.125);
    }
    .accordion-body {
        background-color: #ffffff;
        color: #4b5563;
        transition: opacity 0.3s ease;
        opacity: 1;
    }
    .accordion-collapse {
        transition: height 0.3s ease;
    }
</style>
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
            <div class="accordion" id="faqAccordion">
                <!-- FAQ 1 -->
                <div class="accordion-item border-b">
                    <h3 class="accordion-header" id="headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                            How do I place an order on Mukora Supermarket?
                        </button>
                    </h3>
                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            To place an order, browse our <a href="{{ route('products.index') }}" class="text-red-600 hover:underline">products</a>, add items to your cart, and proceed to checkout. You’ll need to select a delivery address, choose a payment method (Cash on Delivery or MTN MomoPay), and confirm your order. You must be logged in to complete the checkout process.
                        </div>
                    </div>
                </div>
                <!-- FAQ 2 -->
                <div class="accordion-item border-b">
                    <h3 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            What payment methods do you accept?
                        </button>
                    </h3>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            We accept <strong>Cash on Delivery</strong> (pay when your order arrives) and <strong>MTN MomoPay</strong> (pay securely via MTN Mobile Money). During checkout, select your preferred method and follow the instructions.
                        </div>
                    </div>
                </div>
                <!-- FAQ 3 -->
                <div class="accordion-item border-b">
                    <h3 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            What are your delivery areas and fees?
                        </button>
                    </h3>
                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            We offer free delivery within Kasese Town and surrounding areas. For other locations in Uganda, please <a href="{{ route('contact') }}" class="text-red-600 hover:underline">contact us</a> to confirm availability and any applicable fees.
                        </div>
                    </div>
                </div>
                <!-- FAQ 4 -->
                <div class="accordion-item border-b">
                    <h3 class="accordion-header" id="headingFour">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            How long does delivery take?
                        </button>
                    </h3>
                    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Delivery within Kasese Town typically takes 1–2 business days after order confirmation. For other areas, delivery may take 3–5 business days, depending on your location. You can track your order status in the <a href="{{ route('orders.index') }}" class="text-red-600 hover:underline">My Orders</a> section.
                        </div>
                    </div>
                </div>
                <!-- FAQ 5 -->
                <div class="accordion-item border-b">
                    <h3 class="accordion-header" id="headingFive">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                            Can I return or exchange an item?
                        </button>
                    </h3>
                    <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Yes, we accept returns or exchanges within 7 days of delivery, provided the item is unused and in its original packaging. Please review our <a href="{{ route('refund') }}" class="text-red-600 hover:underline">Refund Policy</a> and <a href="{{ route('contact') }}" class="text-red-600 hover:underline">contact us</a> to initiate a return.
                        </div>
                    </div>
                </div>
                <!-- FAQ 6 -->
                <div class="accordion-item border-b">
                    <h3 class="accordion-header" id="headingSix">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                            How do I use MTN MomoPay to pay for my order?
                        </button>
                    </h3>
                    <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            At checkout, select MTN MomoPay, enter your MTN Mobile Money number (e.g., 25677XXXXXXX), and submit your order. You’ll receive a prompt on your phone to authorize the payment using your MTN Mobile Money PIN. Once confirmed, your order status will update in the <a href="{{ route('orders.index') }}" class="text-red-600 hover:underline">My Orders</a> section.
                        </div>
                    </div>
                </div>
                <!-- FAQ 7 -->
                <div class="accordion-item border-b">
                    <h3 class="accordion-header" id="headingSeven">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                            What should I do if I have an issue with my order?
                        </button>
                    </h3>
                    <div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            If you encounter any issues, please <a href="{{ route('contact') }}" class="text-red-600 hover:underline">contact us</a> via email (info@mukorasupermarket.com) or phone (+256 776 123456). You can also submit feedback through our <a href="{{ route('feedback.create') }}" class="text-red-600 hover:underline">Feedback</a> page.
                        </div>
                    </div>
                </div>
                <!-- FAQ 8 -->
                <div class="accordion-item">
                    <h3 class="accordion-header" id="headingEight">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                            Do you offer promotions or discounts?
                        </button>
                    </h3>
                    <div id="collapseEight" class="accordion-collapse collapse" aria-labelledby="headingEight" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Yes, we regularly offer special deals and discounts. Check our <a href="{{ route('promotions') }}" class="text-red-600 hover:underline">Special Offers</a> page for the latest promotions or follow us on social media for updates.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact CTA -->
        <div class="text-center mt-8" data-aos="fade-up" data-aos-delay="200">
            <p class="text-gray-600 mb-4">Still have questions? We’re here to help!</p>
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