<!-- resources/views/partials/_footer.blade.php --> 
<footer class="footer text-white">
    <!-- Main Footer Content -->
    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Company Info -->
            <div class="space-y-4">
                <div class="flex items-center space-x-2">
                    <img src="/uploads/images/mukora-logo.png" alt="Mukora Supermarket" class="h-8 w-auto">
                    <h3 class="text-xl font-bold text-white">Mukora Supermarket</h3>
                </div>
                <p class="text-gray-300 text-sm leading-relaxed">
                    Your premium shopping destination in Kasese, providing quality products and exceptional service since 2010. We're committed to bringing the best to our community.
                </p>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-red-500 transition-colors duration-300 transform hover:scale-110">
                        <i class="fab fa-facebook text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-red-500 transition-colors duration-300 transform hover:scale-110">
                        <i class="fab fa-instagram text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-red-500 transition-colors duration-300 transform hover:scale-110">
                        <i class="fab fa-twitter text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-red-500 transition-colors duration-300 transform hover:scale-110">
                        <i class="fab fa-whatsapp text-xl"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="space-y-4">
                <h4 class="text-lg font-semibold text-white border-b border-gray-700 pb-2">Quick Links</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('home.index') }}" class="text-gray-300 hover:text-red-500 transition-colors duration-300 flex items-center">
                        <i class="fas fa-chevron-right text-xs mr-2"></i>Home
                    </a></li>
                    <li><a href="{{ route('products.index') }}" class="text-gray-300 hover:text-red-500 transition-colors duration-300 flex items-center">
                        <i class="fas fa-chevron-right text-xs mr-2"></i>Products
                    </a></li>
                    <li><a href="{{ route('promotions') }}" class="text-gray-300 hover:text-red-500 transition-colors duration-300 flex items-center">
                        <i class="fas fa-chevron-right text-xs mr-2"></i>Special Offers
                    </a></li>
                    <li><a href="{{ route('about') }}" class="text-gray-300 hover:text-red-500 transition-colors duration-300 flex items-center">
                        <i class="fas fa-chevron-right text-xs mr-2"></i>About Us
                    </a></li>
                    <li><a href="{{ route('contact') }}" class="text-gray-300 hover:text-red-500 transition-colors duration-300 flex items-center">
                        <i class="fas fa-chevron-right text-xs mr-2"></i>Contact Us
                    </a></li>
                </ul>
            </div>

            <!-- Legal Policies -->
            <div class="space-y-4">
                <h4 class="text-lg font-semibold text-white border-b border-gray-700 pb-2">Legal Policies</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('terms') }}" class="text-gray-300 hover:text-red-500 transition-colors duration-300 flex items-center">
                        <i class="fas fa-chevron-right text-xs mr-2"></i>Terms & Conditions
                    </a></li>
                    <li><a href="{{ route('privacy') }}" class="text-gray-300 hover:text-red-500 transition-colors duration-300 flex items-center">
                        <i class="fas fa-chevron-right text-xs mr-2"></i>Privacy Policy
                    </a></li>
                    <li><a href="{{ route('refund') }}" class="text-gray-300 hover:text-red-500 transition-colors duration-300 flex items-center">
                        <i class="fas fa-chevron-right text-xs mr-2"></i>Refund Policy
                    </a></li>
                    <li><a href="{{ route('faqs') }}" class="text-gray-300 hover:text-red-500 transition-colors duration-300 flex items-center">
                        <i class="fas fa-chevron-right text-xs mr-2"></i>FAQs
                    </a></li>
                </ul>
            </div>

            <!-- Contact Information -->
            <div class="space-y-4">
                <h4 class="text-lg font-semibold text-white border-b border-gray-700 pb-2">Contact Info</h4>
                <div class="space-y-3">
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-map-marker-alt text-red-500 mt-1"></i>
                        <div>
                            <p class="text-gray-300 text-sm">Main Street, Kasese Town</p>
                            <p class="text-gray-300 text-sm">Uganda</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-phone text-red-500"></i>
                        <a href="tel:+256776123456" class="text-gray-300 hover:text-red-500 transition-colors duration-300 text-sm">+256 776 123456</a>
                    </div>
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-clock text-red-500"></i>
                        <div>
                            <p class="text-gray-300 text-sm">Open daily</p>
                            <p class="text-gray-300 text-sm">8:00 AM - 9:00 PM</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-envelope text-red-500"></i>
                        <a href="mailto:info@mukorasupermarket.com" class="text-gray-300 hover:text-red-500 transition-colors duration-300 text-sm">info@mukorasupermarket.com</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Bottom -->
    <div class="border-t border-gray-800">
        <div class="container mx-auto px-4 py-6">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <div class="text-center md:text-left">
                    <p class="text-gray-400 text-sm">
                        &copy; {{ date('Y') }} Mukora Supermarket. All rights reserved.
                    </p>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-400 text-sm">Designed with</span>
                    <i class="fas fa-heart text-red-500 animate-pulse"></i>
                    <span class="text-gray-400 text-sm">in Kasese</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Back to Top Button -->
    <button id="back-to-top" class="fixed bottom-6 right-6 bg-red-600 hover:bg-red-700 text-white p-3 rounded-full shadow-lg transition-all duration-300 transform hover:scale-110 opacity-0 invisible">
        <i class="fas fa-arrow-up"></i>
    </button>
</footer>