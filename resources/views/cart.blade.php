@extends('layouts.app')

@section('title', 'Your Shopping Cart - Mukora Supermarket')

@section('styles')
<link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
<style>
    .hero-section {
        background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('/uploads/images/supermarket-bg.jpg');
        background-size: cover;
        background-position: center;
        height: 60vh;
    }
    .cart-card, .summary-card, .promo-card, .info-card {
        transition: all 0.3s ease;
    }
    .cart-card:hover, .summary-card:hover, .promo-card:hover, .info-card:hover {
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
    .quantity-selector button {
        width: 2rem;
    }
    .quantity-selector input {
        width: 3rem;
    }
</style>
@endsection

@include('partials.header')

@section('content')
<!-- Hero Section -->
<section class="hero-section flex items-center justify-center parallax">
    <div class="container mx-auto text-center px-4">
        <h1 class="text-4xl md:text-6xl font-bold mb-4 text-white animate__animated animate__fadeInDown">Your Shopping Cart</h1>
        <p class="text-lg md:text-xl text-white animate__animated animate__fadeInUp animate__delay-1s">Review your items and proceed to checkout</p>
    </div>
</section>

<!-- Cart Content -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="mb-8" data-aos="fade-up">
            <nav aria-label="breadcrumb">
                <ol class="flex space-x-2 text-sm text-gray-600">
                    <li><a href="{{ route('products.index') }}" class="text-red-600 hover:underline">Home</a></li>
                    <li><span class="text-gray-400">/</span></li>
                    <li class="text-gray-800">Shopping Cart</li>
                </ol>
            </nav>
        </div>

        @if(count($cartItems) > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2">
                    <div class="cart-card bg-white rounded-xl shadow-md mb-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="flex justify-between items-center p-6 border-b">
                            <h5 class="text-xl font-semibold">Cart Items ({{ count($cartItems) }})</h5>
                            {{-- <form action="{{#}}" method="POST" onsubmit="return confirm('Are you sure you want to empty your cart?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition transform hover:scale-105">
                                    <i class="fas fa-trash-alt mr-2"></i> Clear Cart
                                </button>
                            </form> --}}
                        </div>
                        <div class="p-6">
                            <div class="overflow-x-auto">
                                <table class="w-full text-left">
                                    <thead>
                                        <tr class="border-b">
                                            <th class="py-3 px-4" style="width: 100px;">Product</th>
                                            <th class="py-3 px-4"></th>
                                            <th class="py-3 px-4 text-center">Price</th>
                                            <th class="py-3 px-4 text-center">Quantity</th>
                                            <th class="py-3 px-4 text-center">Total</th>
                                            <th class="py-3 px-4 text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($cartItems as $item)
                                            <tr id="cart-item-{{ $item['id'] }}" class="border-b hover:bg-gray-50">
                                                <td class="py-4 px-4">
                                                    <img src="{{ $item['image'] ?? '/images/product-placeholder.jpg' }}" 
                                                        alt="{{ $item['name'] }}" class="rounded-lg shadow-sm w-20 h-20 object-cover">
                                                </td>
                                                <td class="py-4 px-4">
                                                    <h5 class="text-lg font-medium">{{ $item['name'] }}</h5>
                                                    @if(isset($item['options']) && count($item['options']) > 0)
                                                        <div class="text-sm text-gray-600 mt-1">
                                                            @foreach($item['options'] as $key => $value)
                                                                <span class="mr-2">{{ ucfirst($key) }}: {{ $value }}</span>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="py-4 px-4 text-center">UGX {{ number_format($item['price']) }}</td>
                                                <td class="py-4 px-4 text-center">
                                                    <form action="{{ route('cart.update', $item['id']) }}" method="POST" class="quantity-form">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="flex items-center justify-center quantity-selector">
                                                            <button type="button" class="quantity-decrease bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-l-lg p-2 transition">
                                                                <i class="fas fa-minus"></i>
                                                            </button>
                                                            <input type="number" name="quantity" class="quantity-input border-t border-b border-gray-300 text-center p-2" 
                                                                value="{{ $item['quantity'] }}" min="1" max="{{ $item['stock'] ?? 100 }}" data-item-id="{{ $item['id'] }}">
                                                            <button type="button" class="quantity-increase bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-r-lg p-2 transition">
                                                                <i class="fas fa-plus"></i>
                                                            </button>
                                                        </div>
                                                        @if(isset($item['stock']) && $item['stock'] < 10)
                                                            <div class="text-yellow-600 text-xs mt-2">Only {{ $item['stock'] }} left</div>
                                                        @endif
                                                    </form>
                                                </td>
                                                <td class="py-4 px-4 text-center">
                                                    <span class="item-total text-nowrap">UGX {{ number_format($item['total']) }}</span>
                                                </td>
                                                <td class="py-4 px-4 text-center">
                                                    <div class="flex flex-col gap-2">
                                                        <button type="button" class="save-for-later bg-white border border-red-600 text-red-600 hover:bg-red-600 hover:text-white font-semibold py-1 px-3 rounded-lg transition" data-id="{{ $item['id'] }}">
                                                            <i class="far fa-heart mr-2"></i> Save
                                                        </button>
                                                        <form action="{{ route('cart.remove', $item['id']) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="bg-white border border-red-600 text-red-600 hover:bg-red-600 hover:text-white font-semibold py-1 px-3 rounded-lg transition">
                                                                <i class="fas fa-trash mr-2"></i> Remove
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-between items-center mb-6" data-aos="fade-up" data-aos-delay="200">
                        <a href="{{ route('products.index') }}" class="bg-white border border-gray-800 text-gray-800 hover:bg-gray-800 hover:text-white font-semibold py-2 px-6 rounded-lg transition transform hover:scale-105">
                            <i class="fas fa-arrow-left mr-2"></i> Continue Shopping
                        </a>
                        <button id="update-cart" class="hidden bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-6 rounded-lg transition transform hover:scale-105">
                            <i class="fas fa-sync-alt mr-2"></i> Update Cart
                        </button>
                    </div>

                    <!-- Recently Viewed Products -->
                    @if(isset($recentlyViewed) && count($recentlyViewed) > 0)
                        <div class="cart-card bg-white rounded-xl shadow-md mb-6" data-aos="fade-up" data-aos-delay="300">
                            <div class="p-6 border-b">
                                <h5 class="text-xl font-semibold">Recently Viewed</h5>
                            </div>
                            <div class="p-6">
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    @foreach($recentlyViewed as $product)
                                        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                                            <img src="{{ $product['image'] ?? '/images/product-placeholder.jpg' }}" 
                                                class="w-full h-32 object-cover" alt="{{ $product['name'] }}">
                                            <div class="p-3">
                                                <h6 class="text-sm font-medium mb-1">{{ $product['name'] }}</h6>
                                                <p class="text-red-600 text-sm mb-2">UGX {{ number_format($product['price']) }}</p>
                                                <button class="add-to-cart bg-red-600 hover:bg-red-700 text-white font-semibold py-1 px-3 rounded-lg w-full transition" 
                                                    data-id="{{ $product['id'] }}">
                                                    <i class="fas fa-cart-plus mr-2"></i> Add to Cart
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="summary-card bg-white rounded-xl shadow-md mb-6 sticky top-6" data-aos="fade-up" data-aos-delay="400">
                        <div class="p-6 border-b">
                            <h5 class="text-xl font-semibold">Order Summary</h5>
                        </div>
                        <div class="p-6">
                            <div class="flex justify-between mb-3">
                                <span>Subtotal ({{ count($cartItems) }} items)</span>
                                <span id="subtotal">UGX {{ number_format($totalAmount) }}</span>
                            </div>
                            <div class="flex justify-between mb-3">
                                <span>Shipping Fee</span>
                                <span id="shipping-fee">Free</span>
                            </div>
                            @if(isset($discount) && $discount > 0)
                                <div class="flex justify-between mb-3 text-green-600">
                                    <span>Discount</span>
                                    <span id="discount">- UGX {{ number_format($discount) }}</span>
                                </div>
                            @endif
                            <hr class="my-4">
                            <div class="flex justify-between mb-4">
                                <strong>Total</strong>
                                <strong class="text-red-600" id="grand-total">UGX {{ number_format($totalAmount - ($discount ?? 0)) }}</strong>
                            </div>
                            <div class="space-y-3">
                                <a href="{{ route('checkout.index') }}" class="block bg-red-600 hover:bg-red-700 text-white font-semibold py-3 rounded-lg text-center transition transform hover:scale-105">
                                    <i class="fas fa-lock mr-2"></i> Proceed to Checkout
                                </a>
                                <button class="express-checkout block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg w-full transition transform hover:scale-105">
                                    <i class="fab fa-paypal mr-2"></i> Express Checkout
                                </button>
                            </div>
                            <div class="mt-4 text-center">
                                <img src="/images/payment-methods.png" alt="Payment Methods" class="inline-block max-h-8">
                            </div>
                        </div>
                    </div>

                    <!-- Promo Code -->
                    <div class="promo-card bg-white rounded-xl shadow-md mb-6" data-aos="fade-up" data-aos-delay="500">
                        <div class="p-6">
                            <h5 class="text-lg font-semibold mb-3">Have a Promo Code?</h5>
                            <form id="promo-form">
                                <div class="flex gap-2">
                                    <input type="text" class="flex-grow px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600" id="promo-code" placeholder="Enter promo code">
                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded-lg transition transform hover:scale-105">Apply</button>
                                </div>
                                <div id="promo-message" class="mt-3"></div>
                            </form>
                        </div>
                    </div>

                    <!-- Delivery Information -->
                    <div class="info-card bg-white rounded-xl shadow-md mb-6" data-aos="fade-up" data-aos-delay="600">
                        <div class="p-6">
                            <h5 class="text-lg font-semibold mb-3">Delivery Information</h5>
                            <p class="text-gray-600 mb-2"><i class="fas fa-truck mr-2 text-red-600"></i> Free delivery on orders above UGX 50,000</p>
                            <p class="text-gray-600 mb-2"><i class="fas fa-clock mr-2 text-red-600"></i> Delivery within 24 hours in Kasese</p>
                            <p class="text-gray-600"><i class="fas fa-shield-alt mr-2 text-red-600"></i> Secure payments</p>
                        </div>
                    </div>

                    <!-- Need Help -->
                    <div class="info-card bg-white rounded-xl shadow-md" data-aos="fade-up" data-aos-delay="700">
                        <div class="p-6">
                            <h5 class="text-lg font-semibold mb-3">Need Help?</h5>
                            <p class="text-gray-600 mb-2"><i class="fas fa-phone-alt mr-2 text-red-600"></i> Call us: +256 700 123456</p>
                            <p class="text-gray-600"><i class="fas fa-envelope mr-2 text-red-600"></i> Email: help@mukorasupermarket.com</p>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="cart-card bg-white rounded-xl shadow-md text-center py-16" data-aos="fade-up">
                <i class="fas fa-shopping-cart text-6xl text-gray-400 mb-4"></i>
                <h3 class="text-2xl font-semibold mb-4">Your Cart is Empty</h3>
                <p class="text-gray-600 mb-6">Looks like you haven't added any products to your cart yet.</p>
                <div class="flex justify-center gap-4">
                    <a href="{{ route('products.index') }}" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-8 rounded-lg transition transform hover:scale-105">
                        Start Shopping
                    </a>
                    @auth
                        <a href="{{ route('wishlist.index') }}" class="bg-white border border-gray-800 text-gray-800 hover:bg-gray-800 hover:text-white font-semibold py-3 px-8 rounded-lg transition transform hover:scale-105">
                            <i class="far fa-heart mr-2"></i> View Wishlist
                        </a>
                    @endauth
                </div>
            </div>

            <!-- Recommended Products -->
            @if(isset($recommendedProducts) && count($recommendedProducts) > 0)
                <div class="mt-8" data-aos="fade-up" data-aos-delay="100">
                    <h3 class="text-2xl font-semibold mb-6">Recommended For You</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach($recommendedProducts as $product)
                            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                                <img src="{{ $product['image'] ?? '/images/product-placeholder.jpg' }}" 
                                    class="w-full h-32 object-cover" alt="{{ $product['name'] }}">
                                <div class="p-3">
                                    <h5 class="text-sm font-medium mb-1">{{ $product['name'] }}</h5>
                                    <p class="text-red-600 text-sm mb-2">UGX {{ number_format($product['price']) }}</p>
                                    <button class="add-to-cart bg-red-600 hover:bg-red-700 text-white font-semibold py-1 px-3 rounded-lg w-full transition" 
                                        data-id="{{ $product['id'] }}">
                                        <i class="fas fa-cart-plus mr-2"></i> Add to Cart
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endif
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
            once: true
        });

        // Quantity decrease button
        $('.quantity-decrease').click(function() {
            var inputField = $(this).closest('.quantity-selector').find('.quantity-input');
            var value = parseInt(inputField.val());
            if (value > 1) {
                inputField.val(value - 1);
                updateItemQuantity(inputField);
            }
        });

        // Quantity increase button
        $('.quantity-increase').click(function() {
            var inputField = $(this).closest('.quantity-selector').find('.quantity-input');
            var value = parseInt(inputField.val());
            var max = parseInt(inputField.attr('max')) || 100;
            if (value < max) {
                inputField.val(value + 1);
                updateItemQuantity(inputField);
            } else {
                Swal.fire({
                    title: 'Warning',
                    text: 'Sorry, maximum available quantity reached',
                    icon: 'warning',
                    confirmButtonColor: '#dc3545'
                });
            }
        });

        // Manual quantity input change
        $('.quantity-input').on('change', function() {
            updateItemQuantity($(this));
        });

        // Update item quantity with delay
        let updateTimeout;
        function updateItemQuantity(inputField) {
            clearTimeout(updateTimeout);
            $('#update-cart').removeClass('hidden');

            updateTimeout = setTimeout(function() {
                const itemId = inputField.data('item-id');
                const quantity = inputField.val();

                $.ajax({
                    url: `/cart/${itemId}`,
                    type: 'PATCH',
                    data: {
                        quantity: quantity,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        // Update item total
                        const rowEl = inputField.closest('tr');
                        rowEl.find('.item-total').text(`UGX ${numberFormat(response.item_total)}`);

                        // Update cart totals
                        $('#subtotal').text(`UGX ${numberFormat(response.subtotal)}`);
                        $('#grand-total').text(`UGX ${numberFormat(response.total)}`);

                        Swal.fire({
                            title: 'Success',
                            text: 'Cart updated successfully',
                            icon: 'success',
                            confirmButtonColor: '#dc3545'
                        });
                        $('#update-cart').addClass('hidden');
                    },
                    error: function(error) {
                        Swal.fire({
                            title: 'Error',
                            text: 'Failed to update cart',
                            icon: 'error',
                            confirmButtonColor: '#dc3545'
                        });
                    }
                });
            }, 500);
        }

        // Format numbers with commas
        function numberFormat(number) {
            return new Intl.NumberFormat('en-US').format(number);
        }

        // Manual cart update button
        $('#update-cart').click(function() {
            $('.quantity-form').each(function() {
                const input = $(this).find('.quantity-input');
                updateItemQuantity(input);
            });
        });

        // Save for later functionality
        $('.save-for-later').click(function() {
            const itemId = $(this).data('id');

            $.ajax({
                url: '/wishlist/add',
                type: 'POST',
                data: {
                    product_id: itemId,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    Swal.fire({
                        title: 'Success',
                        text: 'Item saved to your wishlist',
                        icon: 'success',
                        confirmButtonColor: '#dc3545'
                    });
                },
                error: function(error) {
                    if (error.status === 401) {
                        window.location.href = '/login?redirect=cart';
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: 'Failed to save item',
                            icon: 'error',
                            confirmButtonColor: '#dc3545'
                        });
                    }
                }
            });
        });

        // Promo code application
        $('#promo-form').submit(function(e) {
            e.preventDefault();
            const code = $('#promo-code').val();

            if (!code) {
                $('#promo-message').html('<div class="text-yellow-600 text-sm mt-2">Please enter a promo code</div>');
                return;
            }

            $.ajax({
                url: '/cart/apply-promo',
                type: 'POST',
                data: {
                    code: code,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('#promo-message').html('<div class="text-center py-2"><div class="animate-spin h-5 w-5 border-2 border-t-red-600 rounded-full inline-block"></div> Applying promo code...</div>');
                },
                success: function(response) {
                    if (response.valid) {
                        $('#promo-message').html('<div class="text-green-600 text-sm mt-2">Promo code applied successfully!</div>');

                        // Add discount row if not exists
                        if ($('#discount').length === 0) {
                            const discountRow = `
                                <div class="flex justify-between mb-3 text-green-600">
                                    <span>Discount</span>
                                    <span id="discount">- UGX ${numberFormat(response.discount)}</span>
                                </div>
                            `;
                            $(discountRow).insertBefore('hr');
                        } else {
                            $('#discount').text(`- UGX ${numberFormat(response.discount)}`);
                        }

                        // Update total
                        $('#grand-total').text(`UGX ${numberFormat(response.total)}`);
                    } else {
                        $('#promo-message').html('<div class="text-red-600 text-sm mt-2">Invalid promo code</div>');
                    }
                },
                error: function() {
                    $('#promo-message').html('<div class="text-red-600 text-sm mt-2">Error applying promo code</div>');
                }
            });
        });

        // Express checkout button
        $('#express-checkout').click(function() {
            Swal.fire({
                title: 'Redirecting',
                text: 'Redirecting to express checkout...',
                icon: 'info',
                confirmButtonColor: '#dc3545',
                showConfirmButton: false,
                timer: 1500
            });
            setTimeout(function() {
                window.location.href = "{{ route('checkout.index') }}?express=1";
            }, 1000);
        });

        // Add to cart functionality for recommended products
        $('.add-to-cart').click(function() {
            const productId = $(this).data('id');
            const button = $(this);

            button.prop('disabled', true).html('<span class="animate-spin h-4 w-4 border-2 border-t-white rounded-full inline-block mr-2"></span> Adding...');

            $.ajax({
                url: '/cart/add',
                type: 'POST',
                data: {
                    product_id: productId,
                    quantity: 1,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    Swal.fire({
                        title: 'Success',
                        text: 'Product added to cart',
                        icon: 'success',
                        confirmButtonColor: '#dc3545'
                    });
                    button.prop('disabled', false).html('<i class="fas fa-check mr-2"></i> Added');

                    // Update cart count in header if you have one
                    if (typeof updateCartCount === 'function') {
                        updateCartCount(response.cart_count);
                    }

                    setTimeout(function() {
                        button.html('<i class="fas fa-cart-plus mr-2"></i> Add to Cart');
                    }, 2000);
                },
                error: function() {
                    Swal.fire({
                        title: 'Error',
                        text: 'Failed to add product',
                        icon: 'error',
                        confirmButtonColor: '#dc3545'
                    });
                    button.prop('disabled', false).html('<i class="fas fa-cart-plus mr-2"></i> Add to Cart');
                }
            });
        });
    });
</script>
@endsection