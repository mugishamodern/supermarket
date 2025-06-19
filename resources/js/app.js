import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// ===== GLOBAL UTILITIES =====
window.MukoraApp = {
    // Show notification
    showNotification: function(message, type = 'info', duration = 3000) {
        // Remove existing notifications
        const existingNotifications = document.querySelectorAll('.notification');
        existingNotifications.forEach(notification => notification.remove());
        
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.innerHTML = `
            <div class="flex items-center justify-between">
                <span>${message}</span>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-2 text-white hover:text-gray-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        `;
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.classList.add('show');
        }, 100);
        
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.parentElement.removeChild(notification);
                }
            }, 300);
        }, duration);
    },

    // Format currency
    formatCurrency: function(amount) {
        return new Intl.NumberFormat('en-UG', {
            style: 'currency',
            currency: 'UGX'
        }).format(amount);
    },

    // Debounce function
    debounce: function(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    },

    // Check if user is authenticated
    isAuthenticated: function() {
        return document.querySelector('meta[name="user-authenticated"]')?.content === 'true';
    },

    // Get CSRF token
    getCsrfToken: function() {
        return document.querySelector('meta[name="csrf-token"]')?.content;
    }
};

// ===== CART FUNCTIONALITY =====
class CartManager {
    constructor() {
        this.init();
    }

    init() {
        this.bindEvents();
        this.updateCartCount();
    }

    bindEvents() {
        // Add to cart buttons - handle both data-product-id and data-id
        document.addEventListener('click', (e) => {
            if (e.target.closest('.add-to-cart')) {
                e.preventDefault();
                e.stopPropagation();
                const button = e.target.closest('.add-to-cart');
                const productId = button.dataset.productId || button.dataset.id;
                if (productId) {
                    this.addToCart(productId, button);
                }
            }
        });

        // Quantity controls
        document.addEventListener('click', (e) => {
            if (e.target.closest('.quantity-decrease')) {
                e.preventDefault();
                const button = e.target.closest('.quantity-decrease');
                const itemId = button.dataset.itemId;
                this.updateQuantity(itemId, -1);
            }

            if (e.target.closest('.quantity-increase')) {
                e.preventDefault();
                const button = e.target.closest('.quantity-increase');
                const itemId = button.dataset.itemId;
                this.updateQuantity(itemId, 1);
            }
        });

        // Remove from cart
        document.addEventListener('click', (e) => {
            if (e.target.closest('.remove-from-cart')) {
                e.preventDefault();
                const button = e.target.closest('.remove-from-cart');
                const productId = button.dataset.productId;
                this.removeFromCart(productId);
            }
        });

        // Clear cart
        document.addEventListener('click', (e) => {
            if (e.target.closest('.clear-cart')) {
                e.preventDefault();
                this.clearCart();
            }
        });
    }

    async addToCart(productId, button) {
        if (!productId) {
            MukoraApp.showNotification('Invalid product ID', 'error');
            return;
        }

        const originalContent = button.innerHTML;
        button.disabled = true;
        button.innerHTML = '<span class="loader"></span>';

        try {
            const response = await fetch(`/cart/add/${productId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': MukoraApp.getCsrfToken(),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (response.ok && data.success) {
                this.updateCartCount(data.cartCount);
                MukoraApp.showNotification(data.message || 'Product added to cart successfully!', 'success');
                
                // Animate cart button
                const cartBtn = document.getElementById('cart-count');
                if (cartBtn) {
                    cartBtn.classList.add('animate-pulse');
                    setTimeout(() => cartBtn.classList.remove('animate-pulse'), 1000);
                }
            } else {
                MukoraApp.showNotification(data.message || 'Failed to add product to cart', 'error');
            }
        } catch (error) {
            console.error('Cart error:', error);
            MukoraApp.showNotification('Network error. Please try again.', 'error');
        } finally {
            button.disabled = false;
            button.innerHTML = originalContent;
        }
    }

    async updateQuantity(itemId, change) {
        const input = document.querySelector(`.quantity-input[data-item-id="${itemId}"]`);
        if (!input) return;

        const currentValue = parseInt(input.value);
        const newValue = currentValue + change;
        const maxValue = parseInt(input.getAttribute('max')) || 999;

        if (newValue < 1 || newValue > maxValue) {
            MukoraApp.showNotification('Invalid quantity', 'error');
            return;
        }

        input.value = newValue;

        try {
            const response = await fetch(`/cart/update/${itemId}`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': MukoraApp.getCsrfToken(),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ quantity: newValue })
            });

            if (response.ok) {
                // Reload page to update totals
                window.location.reload();
            } else {
                const data = await response.json();
                MukoraApp.showNotification(data.message || 'Failed to update quantity', 'error');
            }
        } catch (error) {
            console.error('Update quantity error:', error);
            MukoraApp.showNotification('Network error. Please try again.', 'error');
        }
    }

    async removeFromCart(productId) {
        if (!confirm('Are you sure you want to remove this item from your cart?')) {
            return;
        }

        try {
            const response = await fetch(`/cart/remove/${productId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': MukoraApp.getCsrfToken(),
                    'Accept': 'application/json'
                }
            });

            if (response.ok) {
                window.location.reload();
            } else {
                MukoraApp.showNotification('Failed to remove item from cart', 'error');
            }
        } catch (error) {
            console.error('Remove from cart error:', error);
            MukoraApp.showNotification('Network error. Please try again.', 'error');
        }
    }

    async clearCart() {
        if (!confirm('Are you sure you want to clear your entire cart?')) {
            return;
        }

        try {
            const response = await fetch('/cart/clear', {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': MukoraApp.getCsrfToken(),
                    'Accept': 'application/json'
                }
            });

            if (response.ok) {
                window.location.reload();
            } else {
                MukoraApp.showNotification('Failed to clear cart', 'error');
            }
        } catch (error) {
            console.error('Clear cart error:', error);
            MukoraApp.showNotification('Network error. Please try again.', 'error');
        }
    }

    async updateCartCount() {
        try {
            const response = await fetch('/cart/count');
            const data = await response.json();
            
            const cartCountElements = document.querySelectorAll('#cart-count, .cart-count');
            cartCountElements.forEach(element => {
                element.textContent = data.count;
            });
        } catch (error) {
            console.error('Failed to update cart count:', error);
        }
    }
}

// ===== WISHLIST FUNCTIONALITY =====
class WishlistManager {
    constructor() {
        this.init();
    }

    init() {
        this.bindEvents();
    }

    bindEvents() {
        document.addEventListener('click', (e) => {
            if (e.target.closest('.add-to-wishlist')) {
                e.preventDefault();
                e.stopPropagation();
                const button = e.target.closest('.add-to-wishlist');
                const productId = button.dataset.productId;
                if (productId) {
                    this.addToWishlist(productId, button);
                }
            }
        });

        document.addEventListener('click', (e) => {
            if (e.target.closest('.remove-from-wishlist')) {
                e.preventDefault();
                const button = e.target.closest('.remove-from-wishlist');
                const wishlistId = button.dataset.wishlistId;
                this.removeFromWishlist(wishlistId);
            }
        });

        document.addEventListener('click', (e) => {
            if (e.target.closest('.move-to-cart')) {
                e.preventDefault();
                const button = e.target.closest('.move-to-cart');
                const wishlistId = button.dataset.wishlistId;
                this.moveToCart(wishlistId);
            }
        });
    }

    async addToWishlist(productId, button) {
        if (!MukoraApp.isAuthenticated()) {
            MukoraApp.showNotification('Please login to add items to wishlist', 'info');
            // Redirect to login page
            window.location.href = '/login';
            return;
        }

        if (!productId) {
            MukoraApp.showNotification('Invalid product ID', 'error');
            return;
        }

        const originalContent = button.innerHTML;
        button.disabled = true;
        button.innerHTML = '<span class="loader"></span>';

        try {
            const response = await fetch('/wishlist/add', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': MukoraApp.getCsrfToken(),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ product_id: productId })
            });

            const data = await response.json();

            if (data.success) {
                MukoraApp.showNotification(data.message, 'success');
                // Change button appearance to indicate it's in wishlist
                button.classList.remove('bg-white', 'text-gray-800');
                button.classList.add('bg-red-600', 'text-white');
                const icon = button.querySelector('svg');
                if (icon) icon.setAttribute('fill', 'currentColor');
            } else {
                MukoraApp.showNotification(data.message, 'info');
            }
        } catch (error) {
            console.error('Wishlist error:', error);
            MukoraApp.showNotification('Network error. Please try again.', 'error');
        } finally {
            button.disabled = false;
            button.innerHTML = originalContent;
        }
    }

    async removeFromWishlist(wishlistId) {
        if (!confirm('Are you sure you want to remove this item from your wishlist?')) {
            return;
        }

        try {
            const response = await fetch(`/wishlist/${wishlistId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': MukoraApp.getCsrfToken(),
                    'Accept': 'application/json'
                }
            });

            if (response.ok) {
                window.location.reload();
            } else {
                MukoraApp.showNotification('Failed to remove item from wishlist', 'error');
            }
        } catch (error) {
            console.error('Remove from wishlist error:', error);
            MukoraApp.showNotification('Network error. Please try again.', 'error');
        }
    }

    async moveToCart(wishlistId) {
        try {
            const response = await fetch(`/wishlist/${wishlistId}/move-to-cart`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': MukoraApp.getCsrfToken(),
                    'Accept': 'application/json'
                }
            });

            if (response.ok) {
                window.location.reload();
            } else {
                MukoraApp.showNotification('Failed to move item to cart', 'error');
            }
        } catch (error) {
            console.error('Move to cart error:', error);
            MukoraApp.showNotification('Network error. Please try again.', 'error');
        }
    }
}

// ===== UI COMPONENTS =====
class UIComponents {
    constructor() {
        this.init();
    }

    init() {
        this.initBackToTop();
        this.initModals();
        this.initTooltips();
        this.initAnimations();
        this.initSearch();
    }

    initBackToTop() {
        const backToTopBtn = document.getElementById('back-to-top');
        if (!backToTopBtn) return;

        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                backToTopBtn.classList.add('show');
            } else {
                backToTopBtn.classList.remove('show');
            }
        });

        backToTopBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    initModals() {
        // Modal open
        document.addEventListener('click', (e) => {
            if (e.target.hasAttribute('data-modal')) {
                e.preventDefault();
                const modalId = e.target.getAttribute('data-modal');
                this.openModal(modalId);
            }
        });

        // Modal close
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('modal-close') || e.target.classList.contains('modal-overlay')) {
                e.preventDefault();
                this.closeModal(e.target.closest('.modal'));
            }
        });

        // Close modal on escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                const openModal = document.querySelector('.modal.show');
                if (openModal) {
                    this.closeModal(openModal);
                }
            }
        });
    }

    openModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('show');
            document.body.style.overflow = 'hidden';
        }
    }

    closeModal(modal) {
        if (modal) {
            modal.classList.remove('show');
            document.body.style.overflow = '';
        }
    }

    initTooltips() {
        const tooltips = document.querySelectorAll('[data-tooltip]');
        tooltips.forEach(element => {
            element.classList.add('tooltip');
        });
    }

    initAnimations() {
        // Intersection Observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-slide-up');
                }
            });
        }, observerOptions);

        // Observe elements with animation classes
        const animatedElements = document.querySelectorAll('.animate-on-scroll');
        animatedElements.forEach(el => observer.observe(el));
    }

    initSearch() {
        const searchInput = document.getElementById('search-input');
        if (!searchInput) return;

        const debouncedSearch = MukoraApp.debounce(async (query) => {
            if (query.length < 2) return;

            try {
                const response = await fetch(`/search?q=${encodeURIComponent(query)}`);
                const data = await response.json();
                this.displaySearchResults(data.results);
            } catch (error) {
                console.error('Search error:', error);
            }
        }, 300);

        searchInput.addEventListener('input', (e) => {
            debouncedSearch(e.target.value);
        });
    }

    displaySearchResults(results) {
        const resultsContainer = document.getElementById('search-results');
        if (!resultsContainer) return;

        if (results.length === 0) {
            resultsContainer.innerHTML = '<p class="text-gray-500 p-4">No results found</p>';
            return;
        }

        const html = results.map(item => `
            <div class="search-result-item p-3 hover:bg-gray-50 cursor-pointer border-b border-gray-200">
                <div class="flex items-center space-x-3">
                    <img src="${item.image}" alt="${item.name}" class="w-12 h-12 object-cover rounded">
                    <div>
                        <h4 class="font-medium">${item.name}</h4>
                        <p class="text-red-600 font-bold">${MukoraApp.formatCurrency(item.price)}</p>
                    </div>
                </div>
            </div>
        `).join('');

        resultsContainer.innerHTML = html;
    }
}

// ===== FORM VALIDATION =====
class FormValidator {
    constructor() {
        this.init();
    }

    init() {
        this.bindEvents();
    }

    bindEvents() {
        document.addEventListener('submit', (e) => {
            if (e.target.classList.contains('needs-validation')) {
                e.preventDefault();
                this.validateForm(e.target);
            }
        });

        // Real-time validation
        document.addEventListener('input', (e) => {
            if (e.target.hasAttribute('data-validate')) {
                this.validateField(e.target);
            }
        });
    }

    validateForm(form) {
        const fields = form.querySelectorAll('[data-validate]');
        let isValid = true;

        fields.forEach(field => {
            if (!this.validateField(field)) {
                isValid = false;
            }
        });

        if (isValid) {
            form.submit();
        }
    }

    validateField(field) {
        const value = field.value.trim();
        const rules = field.getAttribute('data-validate').split('|');
        let isValid = true;

        rules.forEach(rule => {
            if (!this.validateRule(value, rule, field)) {
                isValid = false;
            }
        });

        this.showFieldValidation(field, isValid);
        return isValid;
    }

    validateRule(value, rule, field) {
        switch (rule) {
            case 'required':
                return value.length > 0;
            case 'email':
                return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
            case 'min:8':
                return value.length >= 8;
            case 'numeric':
                return /^\d+$/.test(value);
            default:
                return true;
        }
    }

    showFieldValidation(field, isValid) {
        field.classList.remove('is-valid', 'is-invalid');
        field.classList.add(isValid ? 'is-valid' : 'is-invalid');

        // Remove existing validation messages
        const existingMessage = field.parentNode.querySelector('.validation-message');
        if (existingMessage) {
            existingMessage.remove();
        }

        if (!isValid) {
            const message = document.createElement('div');
            message.className = 'validation-message text-red-600 text-sm mt-1';
            message.textContent = field.getAttribute('data-error-message') || 'This field is invalid';
            field.parentNode.appendChild(message);
        }
    }
}

// ===== INITIALIZATION =====
document.addEventListener('DOMContentLoaded', function() {
    // Initialize all components
    new CartManager();
    new WishlistManager();
    new UIComponents();
    new FormValidator();

    // Initialize SweetAlert2 if available
    if (typeof Swal !== 'undefined') {
        // Global SweetAlert configuration
        Swal.mixin({
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            showClass: {
                popup: 'animate__animated animate__fadeInDown'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutUp'
            }
        });
    }

    // Initialize AOS if available
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });
    }

    // Initialize Slick slider if available
    if (typeof $ !== 'undefined' && $.fn.slick) {
        $('.product-slider').slick({
            dots: true,
            infinite: true,
            speed: 300,
            slidesToShow: 4,
            slidesToScroll: 1,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1
                    }
                }
            ]
        });
    }
});

// ===== EXPORT FOR MODULE USAGE =====
export { CartManager, WishlistManager, UIComponents, FormValidator };
