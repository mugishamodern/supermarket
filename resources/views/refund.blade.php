@extends('layouts.app')

@section('title', 'Refund Policy - Mukora Supermarket')

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
        <h1 class="text-4xl md:text-6xl font-bold mb-4 text-white animate__animated animate__fadeInDown">Refund Policy</h1>
        <p class="text-lg md:text-xl text-white animate__animated animate__fadeInUp animate__delay-1s">Our commitment to your satisfaction</p>
    </div>
</section>

<!-- Refund Policy Content -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Mukora Supermarket Refund Policy</h2>
                <div class="w-24 h-1 bg-red-600 mx-auto mb-4"></div>
                <p class="text-gray-600 max-w-2xl mx-auto">We strive to ensure your shopping experience is seamless. Our refund policy is designed to be fair and transparent, ensuring your satisfaction with every purchase.</p>
            </div>

            <div class="space-y-8" data-aos="fade-up" data-aos-delay="100">
                <div class="policy-card bg-white p-6 rounded-xl shadow-md">
                    <h3 class="text-xl font-semibold mb-2">1. Eligibility for Refunds</h3>
                    <p class="text-gray-600">Items purchased from Mukora Supermarket are eligible for a refund within 14 days of delivery or purchase, provided they meet the following conditions:</p>
                    <ul class="list-disc pl-6 mt-2 text-gray-600">
                        <li>The item is unused, in its original packaging, and in the same condition as when received.</li>
                        <li>A valid proof of purchase (receipt or order confirmation) is provided.</li>
                        <li>The item is not a perishable product, custom-made, or marked as non-returnable.</li>
                    </ul>
                </div>

                <div class="policy-card bg-white p-6 rounded-xl shadow-md">
                    <h3 class="text-xl font-semibold mb-2">2. Non-Returnable Items</h3>
                    <p class="text-gray-600">Certain items are not eligible for refunds or returns, including:</p>
                    <ul class="list-disc pl-6 mt-2 text-gray-600">
                        <li>Perishable goods (e.g., fresh produce, dairy, or frozen items).</li>
                        <li>Personal care products, if opened or used.</li>
                        <li>Gift cards or promotional vouchers.</li>
                        <li>Items purchased during clearance sales or marked as final sale.</li>
                    </ul>
                </div>

                <div class="policy-card bg-white p-6 rounded-xl shadow-md">
                    <h3 class="text-xl font-semibold mb-2">3. Refund Process</h3>
                    <p class="text-gray-600">To initiate a refund, please follow these steps:</p>
                    <ol class="list-decimal pl-6 mt-2 text-gray-600">
                        <li>Contact our customer service team at <a href="mailto:help@mukorasupermarket.com" class="text-red-600 hover:underline">help@mukorasupermarket.com</a> or +256 700 123456 within 14 days of purchase.</li>
                        <li>Provide your order number and details of the item(s) you wish to return.</li>
                        <li>Return the item to our store at Main Street, Kasese Town, Uganda, or arrange for a pickup (if applicable).</li>
                        <li>Once the return is received and inspected, we will notify you of the approval or rejection of your refund.</li>
                        <li>Approved refunds will be processed within 7 business days to your original payment method.</li>
                    </ol>
                </div>

                <div class="policy-card bg-white p-6 rounded-xl shadow-md">
                    <h3 class="text-xl font-semibold mb-2">4. Defective or Damaged Items</h3>
                    <p class="text-gray-600">If you receive a defective, damaged, or incorrect item, please contact us immediately within 48 hours of receipt. We will:</p>
                    <ul class="list-disc pl-6 mt-2 text-gray-600">
                        <li>Arrange for a replacement or issue a full refund, including any shipping costs.</li>
                        <li>Provide a prepaid return label for defective items (if applicable).</li>
                    </ul>
                    <p class="text-gray-600 mt-2">Please include photos of the damaged or defective item when contacting us to expedite the process.</p>
                </div>

                <div class="policy-card bg-white p-6 rounded-xl shadow-md">
                    <h3 class="text-xl font-semibold mb-2">5. Shipping Costs</h3>
                    <p class="text-gray-600">For eligible returns:</p>
                    <ul class="list-disc pl-6 mt-2 text-gray-600">
                        <li>Mukora Supermarket will cover return shipping costs for defective or incorrect items.</li>
                        <li>For other returns, the customer is responsible for return shipping costs, unless otherwise stated.</li>
                    </ul>
                </div>

                <div class="policy-card bg-white p-6 rounded-xl shadow-md">
                    <h3 class="text-xl font-semibold mb-2">6. Refunds for Online Purchases</h3>
                    <p class="text-gray-600">For items purchased online, you may return them either by:</p>
                    <ul class="list-disc pl-6 mt-2 text-gray-600">
                        <li>Visiting our physical store in Kasese with the item and proof of purchase.</li>
                        <li>Shipping the item back to us (customer covers shipping unless the item is defective).</li>
                    </ul>
                    <p class="text-gray-600 mt-2">Refunds will be issued to the original payment method used during purchase.</p>
                </div>

                <div class="policy-card bg-white p-6 rounded-xl shadow-md">
                    <h3 class="text-xl font-semibold mb-2">7. Changes to This Policy</h3>
                    <p class="text-gray-600">We may update this Refund Policy from time to time to reflect changes in our practices or legal requirements. Updates will be posted on this page, and we encourage you to review it periodically.</p>
                </div>

                <div class="policy-card bg-white p-6 rounded-xl shadow-md">
                    <h3 class="text-xl font-semibold mb-2">8. Contact Us</h3>
                    <p class="text-gray-600">If you have any questions about our Refund Policy or need assistance with a return, please reach out to us:</p>
                    <ul class="list-disc pl-6 mt-2 text-gray-600">
                        <li>Email: <a href="mailto:help@mukorasupermarket.com" class="text-red-600 hover:underline">help@mukorasupermarket.com</a></li>
                        <li>Phone: +256 700 123456</li>
                        <li>Address: Main Street, Kasese Town, Uganda</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-16 bg-red-600 text-white">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-4" data-aos="fade-up">Shop with Confidence</h2>
        <p class="text-lg mb-6 max-w-2xl mx-auto" data-aos="fade-up" data-aos-delay="100">Our hassle-free refund policy ensures your satisfaction. Explore our products today!</p>
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