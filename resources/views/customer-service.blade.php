@extends('layouts.app')

@section('title', 'Customer Service - Mukora Supermarket')

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
    .service-card {
        transition: all 0.3s ease;
    }
    .service-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }
    .parallax {
        background-attachment: fixed;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }
    .form-control:focus {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }
    .contact-info li {
        margin-bottom: 15px;
    }
</style>
@endsection

@include('partials.header')

@section('content')
<!-- Hero Section -->
<section class="hero-section flex items-center justify-center parallax">
    <div class="container mx-auto text-center px-4">
        <h1 class="text-4xl md:text-6xl font-bold mb-4 text-white animate__animated animate__fadeInDown">Customer Service</h1>
        <p class="text-lg md:text-xl text-white animate__animated animate__fadeInUp animate__delay-1s">We’re here to assist you with all your shopping needs</p>
    </div>
</section>

<!-- Customer Service Content -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Contact Information -->
            <div class="service-card bg-white rounded-xl shadow-md p-6" data-aos="fade-up" data-aos-delay="100">
                <h2 class="text-2xl font-bold mb-4 text-gray-800">Get in Touch</h2>
                <p class="text-gray-600 mb-6">Our team is ready to help with any questions or concerns about your orders, payments, or deliveries.</p>
                <ul class="contact-info list-unstyled">
                    <li><i class="fas fa-map-marker-alt text-red-600 me-2"></i> Main Street, Kasese Town, Uganda</li>
                    <li><i class="fas fa-phone text-red-600 me-2"></i> +256 776 123456</li>
                    <li><i class="fas fa-envelope text-red-600 me-2"></i> info@mukorasupermarket.com</li>
                    <li><i class="fas fa-clock text-red-600 me-2"></i> Open daily: 8:00 AM - 9:00 PM</li>
                </ul>
                <div class="mt-6">
                    <p class="text-gray-600 mb-4">Explore more:</p>
                    <a href="{{ route('faqs') }}" class="text-red-600 hover:underline mr-4">FAQs</a>
                    <a href="{{ route('refund') }}" class="text-red-600 hover:underline mr-4">Refund Policy</a>
                    <a href="{{ route('orders.index') }}" class="text-red-600 hover:underline">My Orders</a>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="service-card bg-white rounded-xl shadow-md p-6" data-aos="fade-up" data-aos-delay="200">
                <h2 class="text-2xl font-bold mb-4 text-gray-800">Send Us a Message</h2>
                <p class="text-gray-600 mb-6">Fill out the form below, and we’ll get back to you within 24 hours.</p>
                <form action="{{ route('customer-service.store') }}" method="POST" id="contact-form">
                    @csrf
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Your Name</label>
                        <input type="text" class="form-control mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-600" id="name" name="name" required>
                        @error('name')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Your Email</label>
                        <input type="email" class="form-control mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-600" id="email" name="email" required>
                        @error('email')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="message" class="block text-sm font-medium text-gray-700">Your Message</label>
                        <textarea class="form-control mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-600" id="message" name="message" rows="5" required></textarea>
                        @error('message')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-3 rounded-lg transition transform hover:scale-105">
                        <i class="fas fa-paper-plane mr-2"></i> Send Message
                    </button>
                </form>
            </div>
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
            once: true,
            disable: 'mobile' // Disable AOS on mobile to prevent conflicts
        });

        // Form submission with SweetAlert feedback
        const contactForm = document.getElementById('contact-form');
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(contactForm);

            fetch(contactForm.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Your message has been sent. We’ll get back to you soon!',
                        icon: 'success',
                        confirmButtonColor: '#dc3545'
                    }).then(() => {
                        contactForm.reset();
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: data.message || 'There was an error sending your message.',
                        icon: 'error',
                        confirmButtonColor: '#dc3545'
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    title: 'Error!',
                    text: 'There was an error sending your message.',
                    icon: 'error',
                    confirmButtonColor: '#dc3545'
                });
            });
        });
    });
</script>
@endsection