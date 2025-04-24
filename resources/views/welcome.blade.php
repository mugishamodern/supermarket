@extends('layouts.app')

@section('title', 'Welcome to Mukora Supermarket - Kasese\'s Shopping Destination')

@section('styles')
<style>
    body {
        background-color: #f8f9fa;
        font-family: 'Poppins', sans-serif;
        overflow-x: hidden;
    }
    
    .welcome-hero {
        background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('/images/supermarket-entrance.jpg');
        background-size: cover;
        background-position: center;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-align: center;
    }
    
    .logo-container {
        margin-bottom: 30px;
    }
    
    .logo {
        max-width: 200px;
        filter: drop-shadow(0 5px 15px rgba(0,0,0,0.2));
    }
    
    .welcome-title {
        font-size: 3.5rem;
        font-weight: 700;
        margin-bottom: 20px;
        text-shadow: 2px 2px 8px rgba(0,0,0,0.5);
    }
    
    .welcome-subtitle {
        font-size: 1.5rem;
        margin-bottom: 40px;
        text-shadow: 1px 1px 4px rgba(0,0,0,0.5);
    }
    
    .enter-btn {
        font-size: 1.2rem;
        padding: 12px 40px;
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 1px;
        box-shadow: 0 5px 15px rgba(220, 53, 69, 0.4);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .enter-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(220, 53, 69, 0.6);
    }
    
    .features-section {
        padding: 60px 0;
        background-color: white;
    }
    
    .feature-item {
        text-align: center;
        padding: 30px 20px;
        transition: transform 0.3s ease;
    }
    
    .feature-item:hover {
        transform: translateY(-10px);
    }
    
    .feature-icon {
        font-size: 2.5rem;
        color: #dc3545;
        margin-bottom: 20px;
    }
    
    .animation-float {
        animation: float 6s ease-in-out infinite;
    }
    
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
        100% { transform: translateY(0px); }
    }
    
    .brands-section {
        padding: 50px 0;
        background-color: #f8f9fa;
    }
    
    .brand-logo {
        height: 60px;
        filter: grayscale(100%);
        opacity: 0.6;
        transition: all 0.3s ease;
    }
    
    .brand-logo:hover {
        filter: grayscale(0%);
        opacity: 1;
    }
    
    .location-info {
        background-color: white;
        padding: 60px 0;
    }
    
    .map-container {
        height: 300px;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    
    .footer {
        background-color: #212529;
        color: rgba(255,255,255,0.7);
        padding: 30px 0;
        font-size: 0.9rem;
    }
    
    .social-links a {
        color: white;
        margin: 0 10px;
        font-size: 1.2rem;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .welcome-title {
            font-size: 2.5rem;
        }
        
        .welcome-subtitle {
            font-size: 1.2rem;
        }
    }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="welcome-hero">
    <div class="container">
        <div class="logo-container animation-float">
            <img src="\uploads\images\mukora-logo.png" alt="Mukora Supermarket Logo" class="logo">
        </div>
        <h1 class="welcome-title">Welcome to Mukora Supermarket</h1>
        <p class="welcome-subtitle">Kasese's premier shopping destination for quality goods and exceptional service</p>
        <a href="{{ route('home') }}" class="btn btn-danger btn-lg enter-btn">Enter Store</a>
    </div>
</section>

<!-- Features Section -->
<section class="features-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-shopping-basket"></i>
                    </div>
                    <h4>Extensive Selection</h4>
                    <p class="text-muted">Thousands of products to choose from, including local and imported goods.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-truck"></i>
                    </div>
                    <h4>Fast Delivery</h4>
                    <p class="text-muted">Same-day delivery available within Kasese town and surrounding areas.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-tags"></i>
                    </div>
                    <h4>Special Offers</h4>
                    <p class="text-muted">Weekly promotions and exclusive deals for our loyal customers.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h4>Customer Support</h4>
                    <p class="text-muted">Our friendly team is ready to assist you with any inquiries.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Brands Section -->
<section class="brands-section">
    <div class="container">
        <h3 class="text-center mb-5">Trusted Brands We Carry</h3>
        <div class="row align-items-center justify-content-between">
            <div class="col-md-2 col-4 mb-4 text-center">
                <img src="/images/brands/brand1.png" alt="Brand" class="brand-logo">
            </div>
            <div class="col-md-2 col-4 mb-4 text-center">
                <img src="/images/brands/brand2.png" alt="Brand" class="brand-logo">
            </div>
            <div class="col-md-2 col-4 mb-4 text-center">
                <img src="/images/brands/brand3.png" alt="Brand" class="brand-logo">
            </div>
            <div class="col-md-2 col-4 mb-4 text-center">
                <img src="/images/brands/brand4.png" alt="Brand" class="brand-logo">
            </div>
            <div class="col-md-2 col-4 mb-4 text-center">
                <img src="/images/brands/brand5.png" alt="Brand" class="brand-logo">
            </div>
            <div class="col-md-2 col-4 mb-4 text-center">
                <img src="/images/brands/brand6.png" alt="Brand" class="brand-logo">
            </div>
        </div>
    </div>
</section>

<!-- Store Location Section -->
<section class="location-info">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h3>Visit Our Store</h3>
                <p class="lead">Experience the comfort of shopping at Mukora Supermarket, conveniently located in the heart of Kasese.</p>
                <ul class="list-unstyled mt-4">
                    <li class="mb-3"><i class="fas fa-map-marker-alt text-danger me-2"></i> Main Street, Kasese Town, Uganda</li>
                    <li class="mb-3"><i class="fas fa-phone text-danger me-2"></i> +256 776 123456</li>
                    <li class="mb-3"><i class="fas fa-clock text-danger me-2"></i> Open daily: 8:00 AM - 9:00 PM</li>
                    <li><i class="fas fa-envelope text-danger me-2"></i> info@mukorasupermarket.com</li>
                </ul>
                <div class="mt-4">
                    <a href="/contact" class="btn btn-outline-danger">Contact Us</a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="map-container">
                    <!-- Replace with your actual Google Maps embed code -->
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63799.41743292506!2d29.99106!3d0.18333!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x175e5996cece6d2b%3A0x4b2b58af6cf2271f!2sKasese%2C%20Uganda!5e0!3m2!1sen!2sus!4v1682531234567!5m2!1sen!2sus" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-6 text-center text-md-start">
                <p>&copy; {{ date('Y') }} Mukora Supermarket. All rights reserved.</p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
        </div>
    </div>
</footer>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
<script>
    $(document).ready(function() {
        // Add smooth scrolling to all links
        $("a").on('click', function(event) {
            if (this.hash !== "") {
                event.preventDefault();
                var hash = this.hash;
                $('html, body').animate({
                    scrollTop: $(hash).offset().top
                }, 800, function(){
                    window.location.hash = hash;
                });
            }
        });
        
        // Add animation on scroll
        $(window).scroll(function() {
            $('.feature-item').each(function() {
                var position = $(this).offset().top;
                var scroll = $(window).scrollTop();
                var windowHeight = $(window).height();
                if (scroll + windowHeight > position + 100) {
                    $(this).addClass('animated fadeInUp');
                }
            });
        });
    });
</script>
@endsection