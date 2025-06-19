@extends('layouts.app')

@section('title', 'Contact Us - Mukora Supermarket')

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
        <h1 class="text-4xl md:text-6xl font-bold mb-4 text-white animate__animated animate__fadeInDown">Contact Us</h1>
        <p class="text-lg md:text-xl text-white animate__animated animate__fadeInUp animate__delay-1s">We're here to assist you with all your shopping needs!</p>
    </div>
</section>

<!-- Contact Information -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12" data-aos="fade-up">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Get in Touch</h2>
            <div class="w-24 h-1 bg-red-600 mx-auto"></div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="contact-card bg-white p-6 rounded-xl shadow-md text-center" data-aos="fade-up" data-aos-delay="100">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Our Location</h3>
                <p class="text-gray-600 text-sm">Main Street, Kasese Town, Uganda</p>
            </div>
            <div class="contact-card bg-white p-6 rounded-xl shadow-md text-center" data-aos="fade-up" data-aos-delay="200">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Phone Number</h3>
                <p class="text-gray-600 text-sm">+256 123 456 789</p>
            </div>
            <div class="contact-card bg-white p-6 rounded-xl shadow-md text-center" data-aos="fade-up" data-aos-delay="300">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Email Address</h3>
                <p class="text-gray-600 text-sm">info@mukorasupermarket.com</p>
            </div>
        </div>
    </div>
</section>

<!-- Contact Form -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-lg mx-auto">
            <h2 class="text-3xl font-bold text-center mb-6" data-aos="fade-up">Send Us a Message</h2>
            <form id="contact-form" class="space-y-4" data-aos="fade-up" data-aos-delay="100">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                    <input type="text" id="name" name="name" class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600" required>
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                    <input type="email" id="email" name="email" class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600" required>
                </div>
                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                    <textarea id="message" name="message" rows="5" class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600" required></textarea>
                </div>
                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-3 rounded-lg transition transform hover:scale-105">Send Message</button>
            </form>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="py-16 bg-gray-100">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12" data-aos="fade-up">
            <h2 class="text-3xl font-bold mb-4">Visit Us</h2>
            <div class="w-24 h-1 bg-red-600 mx-auto"></div>
        </div>
        <div class="rounded-xl overflow-hidden shadow-lg" data-aos="fade-up" data-aos-delay="100">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.7568372982587!2d30.08251511475412!3d0.1831619996846174!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMCoxMScwMC4wIk4gMzDCsDA1JzAwLjAiRQ!5e0!3m2!1sen!2sug!4v1635781234567!5m2!1sen!2sug" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>
</section>
@include('partials.footer')
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        AOS.init({
            duration: 800,
            once: true
        });

        // Contact form submission
        document.getElementById('contact-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            fetch('/contact/submit', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                Swal.fire({
                    title: 'Success!',
                    text: 'Your message has been sent successfully.',
                    icon: 'success',
                    confirmButtonColor: '#dc3545'
                });
                this.reset();
            })
            .catch(error => {
                Swal.fire({
                    title: 'Error!',
                    text: 'Something went wrong. Please try again.',
                    icon: 'error',
                    confirmButtonColor: '#dc3545'
                });
            });
        });
    });
</script>
@endsection