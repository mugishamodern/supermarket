@extends('layouts.app')

@section('title', 'Your Shopping Cart - Mukora Supermarket')
@include('partials.header')
@section('content')
<div class="container py-5">
    <div class="mb-4">
        <h1 class="mb-2">Your Shopping Cart</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
            </ol>
        </nav>
    </div>
    
    @if(count($cartItems) > 0)
        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                        <h5 class="mb-0">Cart Items ({{ count($cartItems) }})</h5>
                     {{--     <form action="{{#}}" method="POST" onsubmit="return confirm('Are you sure you want to empty your cart?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-trash-alt me-1"></i> Clear Cart
                            </button>
                        </form>  --}}
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="border-0" width="100">Product</th>
                                        <th class="border-0"></th>
                                        <th class="border-0 text-center">Price</th>
                                        <th class="border-0 text-center">Quantity</th>
                                        <th class="border-0 text-center">Total</th>
                                        <th class="border-0 text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cartItems as $item)
                                        <tr id="cart-item-{{ $item['id'] }}">
                                            <td>
                                                <img src="{{ $item['image'] ?? '/images/product-placeholder.jpg' }}" 
                                                    alt="{{ $item['name'] }}" class="img-fluid rounded shadow-sm" width="80">
                                            </td>
                                            <td>
                                                <h5 class="mb-1">{{ $item['name'] }}</h5>
                                                @if(isset($item['options']) && count($item['options']) > 0)
                                                    <small class="text-muted">
                                                        @foreach($item['options'] as $key => $value)
                                                            <span class="me-2">{{ ucfirst($key) }}: {{ $value }}</span>
                                                        @endforeach
                                                    </small>
                                                @endif
                                            </td>
                                            <td class="text-center align-middle">UGX {{ number_format($item['price']) }}</td>
                                            <td class="text-center align-middle">
                                                <form action="{{ route('cart.update', $item['id']) }}" method="POST" class="d-inline quantity-form">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div class="input-group input-group-sm quantity-selector mx-auto" style="width: 120px;">
                                                        <button type="button" class="btn btn-outline-secondary quantity-decrease">
                                                            <i class="fas fa-minus"></i>
                                                        </button>
                                                        <input type="number" name="quantity" class="form-control text-center quantity-input" 
                                                            value="{{ $item['quantity'] }}" min="1" max="{{ $item['stock'] ?? 100 }}" data-item-id="{{ $item['id'] }}">
                                                        <button type="button" class="btn btn-outline-secondary quantity-increase">
                                                            <i class="fas fa-plus"></i>
                                                        </button>
                                                    </div>
                                                    @if(isset($item['stock']) && $item['stock'] < 10)
                                                        <div class="text-warning small mt-1">Only {{ $item['stock'] }} left</div>
                                                    @endif
                                                </form>
                                            </td>
                                            <td class="text-center align-middle">
                                                <span class="text-nowrap item-total">UGX {{ number_format($item['total']) }}</span>
                                            </td>
                                            <td class="text-center align-middle">
                                                <div class="d-flex flex-column gap-2">
                                                    <button type="button" class="btn btn-sm btn-outline-primary save-for-later" data-id="{{ $item['id'] }}">
                                                        <i class="far fa-heart"></i> Save
                                                    </button>
                                                    <form action="{{ route('cart.remove', $item['id']) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                                            <i class="fas fa-trash"></i> Remove
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
                
                <div class="d-flex justify-content-between mb-5">
                    <a href="{{ route('products.index') }}" class="btn btn-outline-dark">
                        <i class="fas fa-arrow-left me-2"></i> Continue Shopping
                    </a>
                    <div class="d-flex gap-2">
                        <button id="update-cart" class="btn btn-outline-primary d-none">
                            <i class="fas fa-sync-alt me-2"></i> Update Cart
                        </button>
                    </div>
                </div>

                <!-- Recently viewed products -->
                @if(isset($recentlyViewed) && count($recentlyViewed) > 0)
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Recently Viewed</h5>
                    </div>
                    <div class="card-body">
                        <div class="row row-cols-2 row-cols-md-4 g-3">
                            @foreach($recentlyViewed as $product)
                                <div class="col">
                                    <div class="card h-100 border-0 shadow-sm">
                                        <img src="{{ $product['image'] ?? '/images/product-placeholder.jpg' }}" 
                                            class="card-img-top" alt="{{ $product['name'] }}">
                                        <div class="card-body p-3">
                                            <h6 class="card-title mb-1">{{ $product['name'] }}</h6>
                                            <p class="text-danger mb-2">UGX {{ number_format($product['price']) }}</p>
                                            <button class="btn btn-sm btn-outline-danger w-100 add-to-cart" 
                                                data-id="{{ $product['id'] }}">
                                                <i class="fas fa-cart-plus"></i> Add to Cart
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            </div>
            
            <div class="col-lg-4">
                <div class="card shadow-sm mb-4 position-sticky" style="top: 20px;">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Order Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <span>Subtotal ({{ count($cartItems) }} items)</span>
                            <span id="subtotal">UGX {{ number_format($totalAmount) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Shipping Fee</span>
                            <span id="shipping-fee">Free</span>
                        </div>
                        
                        @if(isset($discount) && $discount > 0)
                        <div class="d-flex justify-content-between mb-3 text-success">
                            <span>Discount</span>
                            <span id="discount">- UGX {{ number_format($discount) }}</span>
                        </div>
                        @endif
                        
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <strong>Total</strong>
                            <strong class="text-danger" id="grand-total">UGX {{ number_format($totalAmount - ($discount ?? 0)) }}</strong>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <a href="{{ route('checkout.index') }}" class="btn btn-danger">
                                <i class="fas fa-lock me-2"></i> Proceed to Checkout
                            </a>
                            <button class="btn btn-outline-dark" id="express-checkout">
                                <i class="fab fa-paypal me-2"></i> Express Checkout
                            </button>
                        </div>
                        
                        <div class="mt-3 text-center">
                            <img src="/images/payment-methods.png" alt="Payment Methods" class="img-fluid" style="max-height: 30px;">
                        </div>
                    </div>
                </div>
                
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="mb-3">Have a promo code?</h5>
                        <form id="promo-form">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="promo-code" placeholder="Enter promo code">
                                <button class="btn btn-outline-danger" type="submit">Apply</button>
                            </div>
                            <div id="promo-message"></div>
                        </form>
                    </div>
                </div>
                
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="mb-3">Delivery Information</h5>
                        <p class="mb-2"><i class="fas fa-truck me-2 text-muted"></i> Free delivery on orders above UGX 50,000</p>
                        <p class="mb-2"><i class="fas fa-clock me-2 text-muted"></i> Delivery within 24 hours in Kampala</p>
                        <p class="mb-0"><i class="fas fa-shield-alt me-2 text-muted"></i> Secure payments</p>
                    </div>
                </div>
                
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="mb-3">Need Help?</h5>
                        <p class="mb-2"><i class="fas fa-phone-alt me-2 text-muted"></i> Call us: +256 700 123456</p>
                        <p class="mb-0"><i class="fas fa-envelope me-2 text-muted"></i> Email: help@mukora.com</p>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="card shadow-sm">
            <div class="card-body text-center py-5">
                <i class="fas fa-shopping-cart fa-4x text-muted mb-4"></i>
                <h3>Your cart is empty</h3>
                <p class="mb-4">Looks like you haven't added any products to your cart yet.</p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="{{ route('products.index') }}" class="btn btn-danger">Start Shopping</a>
                    @auth
                        <a href="{{ route('wishlist.index') }}" class="btn btn-outline-dark">
                            <i class="far fa-heart me-2"></i> View Wishlist
                        </a>
                    @endauth
                </div>
            </div>
        </div>
        
        <!-- Recommended products -->
        @if(isset($recommendedProducts) && count($recommendedProducts) > 0)
        <div class="mt-5">
            <h3 class="mb-4">Recommended For You</h3>
            <div class="row row-cols-2 row-cols-md-4 g-4">
                @foreach($recommendedProducts as $product)
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            <img src="{{ $product['image'] ?? '/images/product-placeholder.jpg' }}" 
                                class="card-img-top" alt="{{ $product['name'] }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product['name'] }}</h5>
                                <p class="text-danger mb-2">UGX {{ number_format($product['price']) }}</p>
                                <button class="btn btn-outline-danger w-100 add-to-cart" 
                                    data-id="{{ $product['id'] }}">
                                    <i class="fas fa-cart-plus"></i> Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    @endif
</div>
@include('partials.footer')
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
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
                toastr.warning('Sorry, maximum available quantity reached');
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
            $('#update-cart').removeClass('d-none');
            
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
                        
                        toastr.success('Cart updated successfully');
                        $('#update-cart').addClass('d-none');
                    },
                    error: function(error) {
                        toastr.error('Failed to update cart');
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
                    toastr.success('Item saved to your wishlist');
                },
                error: function(error) {
                    if (error.status === 401) {
                        window.location.href = '/login?redirect=cart';
                    } else {
                        toastr.error('Failed to save item');
                    }
                }
            });
        });
        
        // Promo code application
        $('#promo-form').submit(function(e) {
            e.preventDefault();
            const code = $('#promo-code').val();
            
            if (!code) {
                $('#promo-message').html('<div class="alert alert-warning mt-2">Please enter a promo code</div>');
                return;
            }
            
            // Simulate promo code check
            $.ajax({
                url: '/cart/apply-promo',
                type: 'POST',
                data: {
                    code: code,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('#promo-message').html('<div class="text-center py-2"><div class="spinner-border spinner-border-sm text-danger" role="status"></div> Applying promo code...</div>');
                },
                success: function(response) {
                    if (response.valid) {
                        $('#promo-message').html('<div class="alert alert-success mt-2">Promo code applied successfully!</div>');
                        
                        // Add discount row if not exists
                        if ($('#discount').length === 0) {
                            const discountRow = `
                                <div class="d-flex justify-content-between mb-3 text-success">
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
                        $('#promo-message').html('<div class="alert alert-danger mt-2">Invalid promo code</div>');
                    }
                },
                error: function() {
                    $('#promo-message').html('<div class="alert alert-danger mt-2">Error applying promo code</div>');
                }
            });
        });
        
        // Express checkout button
        $('#express-checkout').click(function() {
            toastr.info('Redirecting to express checkout...');
            // Implementation would go here
            setTimeout(function() {
                window.location.href = "{{ route('checkout.index') }}?express=1";
            }, 1000);
        });
        
        // Add to cart functionality for recommended products
        $('.add-to-cart').click(function() {
            const productId = $(this).data('id');
            const button = $(this);
            
            button.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Adding...');
            
            $.ajax({
                url: '/cart/add',
                type: 'POST',
                data: {
                    product_id: productId,
                    quantity: 1,
                    _token: $('meta[name="csrf-token"]').attr('content')  
                },
                success: function(response) {
                    toastr.success('Product added to cart');
                    button.prop('disabled', false).html('<i class="fas fa-check"></i> Added');
                    
                    // Update cart count in header if you have one
                    if (typeof updateCartCount === 'function') {
                        updateCartCount(response.cart_count);
                    }
                    
                    setTimeout(function() {
                        button.html('<i class="fas fa-cart-plus"></i> Add to Cart');
                    }, 2000);
                },
                error: function() {
                    toastr.error('Failed to add product');
                    button.prop('disabled', false).html('<i class="fas fa-cart-plus"></i> Add to Cart');
                }
            });
        });
        
        // Initialize toastr notification settings
        toastr.options = {
            "closeButton": true,
            "positionClass": "toast-bottom-right",
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "3000"
        };
    });
</script>
@endsection