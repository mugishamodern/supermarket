<!-- resources/views/partials/_footer.blade.php --> 
<footer class="footer">     
    <div class="container">         
        <div class="row">             
            <div class="col-md-4 mb-4 mb-md-0">                 
                <h5 class="text-white mb-3">Mukora Supermarket</h5>                 
                <p>Your premium shopping destination in Kasese, providing quality products and exceptional service since 2010.</p>                 
                <div class="social-links mt-3">                     
                    <a href="#"><i class="fab fa-facebook"></i></a>                     
                    <a href="#"><i class="fab fa-instagram"></i></a>                     
                    <a href="#"><i class="fab fa-twitter"></i></a>                     
                    <a href="#"><i class="fab fa-whatsapp"></i></a>                 
                </div>             
            </div>             
            <div class="col-md-3 mb-4 mb-md-0">                 
                <h5 class="text-white mb-3">Quick Links</h5>                 
                <ul class="list-unstyled footer-links">                     
                    <li><a href="{{ route('home.index') }}">Home</a></li>                     
                    <li><a href="{{ route('products.index') }}">Products</a></li>                     
                    <li><a href="{{ route('promotions') }}">Special Offers</a></li>                     
                    <li><a href="{{ route('about') }}">About Us</a></li>                     
                    <li><a href="{{ route('contact') }}">Contact Us</a></li>                 
                </ul>             
            </div>
            <div class="col-md-3 mb-4 mb-md-0">                 
                <h5 class="text-white mb-3">Legal Policies</h5>                 
                <ul class="list-unstyled footer-links">                     
                    <li><a href="{{ route('terms') }}">Terms and Conditions</a></li>                     
                    <li><a href="{{ route('privacy') }}">Privacy policies</a></li>                     
                    <li><a href="{{ route('refund') }}">Refund Policies</a></li>                                      
                </ul>             
            </div>             
            <div class="col-md-3">                 
                <h5 class="text-white mb-3">Contact Info</h5>                 
                <ul class="list-unstyled contact-info">                     
                    <li><i class="fas fa-map-marker-alt text-danger me-2"></i> Main Street, Kasese Town, Uganda</li>                     
                    <li><i class="fas fa-phone text-danger me-2"></i> +256 776 123456</li>                     
                    <li><i class="fas fa-clock text-danger me-2"></i> Open daily: 8:00 AM - 9:00 PM</li>                     
                    <li><i class="fas fa-envelope text-danger me-2"></i> info@mukorasupermarket.com</li>                 
                </ul>             
            </div>         
        </div>         
        <hr class="mt-2 mb-2" style="border-color: rgba(255,255,255,0.1);">         
        <div class="row">             
            <div class="col-md-3 text-center text-md-start">                 
                <p class="mb-0">&copy; {{ date('Y') }} Mukora Supermarket. All rights reserved.</p>             
            </div>             
            <div class="col-md-3 text-center text-md-end">                 
                <p class="mb-0">Designed with <i class="fas fa-heart text-danger"></i> in Kasese</p>             
            </div>         
        </div>     
    </div> 
</footer>  

<style>     
    .footer {         
        background-color: #212529;         
        color: rgba(255,255,255,0.7);         
        padding: 50px 0 30px;         
        font-size: 0.9rem;     
    }          
    .footer h5 {         
        font-weight: 600;         
        margin-bottom: 20px;     
    }          
    .footer-links li {         
        margin-bottom: 10px;     
    }          
    .footer-links a {         
        color: rgba(255,255,255,0.7);         
        text-decoration: none;         
        transition: all 0.3s ease;     
    }          
    .footer-links a:hover {         
        color: #dc3545;         
        text-decoration: none;         
        padding-left: 5px;     
    }          
    .contact-info li {         
        margin-bottom: 15px;     
    }          
    .social-links a {         
        color: white;         
        margin-right: 15px;         
        font-size: 1.2rem;         
        transition: all 0.3s ease;     
    }          
    .social-links a:hover {         
        color: #dc3545;         
        transform: translateY(-3px);     
    } 
</style>