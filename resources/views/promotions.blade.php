@extends('layouts.app')

@section('title', 'Promotions - Mukora Supermarket')

@section('styles')
<link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
@endsection

@include('partials.header')

@section('content')
<!-- Hero Section -->
<section class="hero-section flex items-center justify-center parallax bg-cover bg-center min-h-[60vh]" style="background-image: linear-gradient(rgba(0,0,0,0.6),rgba(0,0,0,0.6)), url('/Uploads/images/promotions-bg.jpg');">
    <div class="container mx-auto text-center px-4">
        <h1 class="text-4xl md:text-6xl font-bold mb-4 text-white animate__animated animate__fadeInDown">Special Promotions</h1>
        <p class="text-lg md:text-xl text-white animate__animated animate__fadeInUp animate__delay-1s">Discover exclusive deals and save big at Mukora Supermarket!</p>
        <a href="#promotions" class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-8 rounded-full inline-block mt-6 transition transform hover:scale-105 animate__animated animate__fadeInUp animate__delay-2s pulse-button">
            View Offers
        </a>
    </div>
</section>

<!-- Promotions Section -->
<section class="py-16 bg-gray-50" id="promotions">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12" data-aos="fade-up">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Current Promotions</h2>
            <div class="w-24 h-1 bg-red-600 mx-auto mb-4"></div>
            <p class="text-gray-600 max-w-2xl mx-auto">Take advantage of our limited-time offers and enjoy great savings on your favorite products.</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach([
                [
                    'title' => 'Weekend Electronics Sale',
                    'description' => 'Up to 30% off on all electronics, including TVs, smartphones, and more!',
                    'image' => 'images/promotions/electronics.jpg',
                    'end_date' => '2025-05-10T23:59:59',
                    'slug' => 'electronics-sale'
                ],
                [
                    'title' => 'Fresh Produce Discount',
                    'description' => 'Buy one, get one free on selected fruits and vegetables.',
                    'image' => 'images/promotions/produce.jpg',
                    'end_date' => '2025-05-15T23:59:59',
                    'slug' => 'produce-discount'
                ],
                [
                    'title' => 'Back-to-School Bundle',
                    'description' => 'Save 20% on school supplies when you spend UGX 50,000 or more.',
                    'image' => 'images/promotions/school.jpg',
                    'end_date' => '2025-05-20T23:59:59',
                    'slug' => 'school-bundle'
                ]
            ] as $promo)
            <div class="promo-card bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:-translate-y-2 hover:shadow-lg" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="relative">
                    <img src="{{ asset($promo['image']) }}" alt="{{ $promo['title'] }}" class="w-full h-48 object-cover">
                    <div class="absolute top-4 left-4">
                        <span class="bg-red-600 text-white px-3 py-1.5 rounded-full text-xs font-bold shadow-lg">Limited Time</span>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-2">{{ $promo['title'] }}</h3>
                    <p class="text-gray-600 text-sm mb-4">{{ $promo['description'] }}</p>
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-sm font-medium">Ends in:</span>
                        <div class="flex space-x-2 countdown-timer" data-end-date="{{ $promo['end_date'] }}">
                            <div class="bg-red-100 text-red-600 rounded px-2 py-1 text-xs font-bold" data-days>00</div>
                            <div class="bg-red-100 text-red-600 rounded px-2 py-1 text-xs font-bold" data-hours>00</div>
                            <div class="bg-red-100 text-red-600 rounded px-2 py-1 text-xs font-bold" data-minutes>00</div>
                            <div class="bg-red-100 text-red-600 rounded px-2 py-1 text-xs font-bold" data-seconds>00</div>
                        </div>
                    </div>
                    <a href="{{ route('products.index') }}" class="block bg-red-600 hover:bg-red-700 text-white font-semibold py-2 rounded-lg text-center transition transform hover:scale-105">
                        Shop Now
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Upcoming Promotions Teaser -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12" data-aos="fade-up">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Upcoming Deals</h2>
            <div class="w-24 h-1 bg-red-600 mx-auto mb-4"></div>
            <p class="text-gray-600 max-w-2xl mx-auto">Stay tuned for more exciting offers coming your way!</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="relative rounded-xl overflow-hidden shadow-lg h-72 bg-cover bg-center" data-aos="fade-right">
                <div class="absolute inset-0 bg-gradient-to-r from-black/80 to-transparent">
                    <div class="flex flex-col justify-center h-full p-8 text-white">
                        <h3 class="text-2xl font-bold mb-2">Mid-Month Madness</h3>
                        <p class="text-sm mb-4">Get ready for huge discounts on household essentials starting May 15!</p>
                        <a href="{{ route('products.index') }}" class="bg-white text-red-600 font-semibold px-6 py-2 rounded-lg hover:bg-red-600 hover:text-white transition w-max">Browse Products</a>
                    </div>
                </div>
            </div>
            <div class="relative rounded-xl overflow-hidden shadow-lg h-72 bg-cover bg-center" data-aos="fade-left">
                <div class="absolute inset-0 bg-gradient-to-r from-black/80 to-transparent">
                    <div class="flex flex-col justify-center h-full p-8 text-white">
                        <h3 class="text-2xl font-bold mb-2">Seasonal Specials</h3>
                        <p class="text-sm mb-4">Exclusive offers on seasonal items launching May 20!</p>
                        <a href="{{ route('products.index') }}" class="bg-white text-red-600 font-semibold px-6 py-2 rounded-lg hover:bg-red-600 hover:text-white transition w-max">Browse Products</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Newsletter Call-to-Action -->
<section class="py-16 bg-gray-900 text-white relative overflow-hidden">
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-3xl mx-auto text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-6" data-aos="fade-up">Never Miss a Deal!</h2>
            <p class="text-gray-300 mb-8" data-aos="fade-up" data-aos-delay="100">Subscribe to our newsletter for the latest promotions and exclusive offers.</p>
            <form id="newsletter-form" class="flex flex-col md:flex-row gap-4 max-w-lg mx-auto" data-aos="fade-up" data-aos-delay="200">
                <input type="email" class="flex-grow px-4 py  py-3 rounded-lg text-gray-800 focus:outline-none focus:ring-2 focus:ring-red-600" placeholder="Your Email Address" required>
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-3 rounded-lg transition transform hover:scale-105">
                    Subscribe
                </button>
            </form>
        </div>
    </div>
    <div class="absolute inset-0 z-0 overflow-hidden">
        <div class="absolute w-32 h-32 bg-red-600 rounded-full top-1/4 left-1/4 animate-pulse opacity-30"></div>
        <div class="absolute w-40 h-40 bg-red-700 rounded-full top-3/4 left-1/3 animate-pulse opacity-20 delay-1000"></div>
    </div>
</section>
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

        // Countdown timers for each promotion
        const countdownTimers = document.querySelectorAll('.countdown-timer');
        countdownTimers.forEach(timer => {
            const endDate = new Date(timer.dataset.endDate).getTime();
            const daysEl = timer.querySelector('[data-days]');
            const hoursEl = timer.querySelector('[data-hours]');
            const minutesEl = timer.querySelector('[data-minutes]');
            const secondsEl = timer.querySelector('[data-seconds]');

            const countdown = setInterval(() => {
                const now = new Date().getTime();
                const distance = endDate - now;

                if (distance < 0) {
                    clearInterval(countdown);
                    daysEl.textContent = '00';
                    hoursEl.textContent = '00';
                    minutesEl.textContent = '00';
                    secondsEl.textContent = '00';
                    return;
                }

                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                daysEl.textContent = String(days).padStart(2, '0');
                hoursEl.textContent = String(hours).padStart(2, '0');
                minutesEl.textContent = String(minutes).padStart(2, '0');
                secondsEl.textContent = String(seconds).padStart(2, '0');
            }, 1000);
        });

        // Newsletter form submission
        document.getElementById('newsletter-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const email = this.querySelector('input[type="email"]').value;

            fetch('/newsletter/subscribe', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ email })
            })
            .then(response => response.json())
            .then(data => {
                Swal.fire({
                    title: 'Thank You!',
                    text: 'You have successfully subscribed to our newsletter.',
                    icon: 'success',
                    confirmButtonColor: '#dc3545'
                });
                this.reset();
            })
            .catch(error => {
                Swal.fire({
                    title: 'Oops!',
                    text: 'Something went wrong. Please try again.',
                    icon: 'error',
                    confirmButtonColor: '#dc3545'
                });
            });
        });
    });
</script>
@endsection