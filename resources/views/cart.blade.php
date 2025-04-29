@extends('layouts.app')

@section('title', 'Your Shopping Cart - Mukora Supermarket')
@include('partials.header')
@section('content')
<div class="container py-5">
    <h1 class="mb-4">Your Shopping Cart</h1>
    
    @if(count($cartItems) > 0)
        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm mb-4">
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
                                        <tr>
                                            <td>
                                                <img src="{{ $item['image'] ?? '/images/product-placeholder.jpg' }}" 
                                                    alt="{{ $item['name'] }}" class="img-fluid rounded" width="80">
                                            </td>
                                            <td>
                                                <h5 class="mb-0">{{ $item['name'] }}</h5>
                                            </td>
                                            <td class="text-center">UGX {{ number_format($item['price']) }}</td>
                                            <td class="text-center">
                                                <form action="{{ route('cart.update', $item['id']) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div class="input-group input-group-sm quantity-selector" style="width: 120px;">
                                                        <button type="button" class="btn btn-outline-secondary quantity-decrease">
                                                            <i class="fas fa-minus"></i>
                                                        </button>
                                                        <input type="number" name="quantity" class="form-control text-center quantity-input" 
                                                            value="{{ $item['quantity'] }}" min="1" onchange="this.form.submit()">
                                                        <button type="button" class="btn btn-outline-secondary quantity-increase">
                                                            <i class="fas fa-plus"></i>
                                                        </button>
                                                    </div>
                                                </form>
                                            </td>
                                            <td class="text-center">UGX {{ number_format($item['total']) }}</td>
                                            <td class="text-center">
                                                <form action="{{ route('cart.remove', $item['id']) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="fas fa-trash"></i> Remove
                                                    </button>
                                                </form>
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
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Order Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <span>Subtotal</span>
                            <span>UGX {{ number_format($totalAmount) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Shipping Fee</span>
                            <span>Free</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <strong>Total</strong>
                            <strong class="text-danger">UGX {{ number_format($totalAmount) }}</strong>
                        </div>
                        
                        <a href="{{ route('checkout.index') }}" class="btn btn-danger w-100">
                            Proceed to Checkout
                        </a>
                    </div>
                </div>
                
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="mb-3">Have a promo code?</h5>
                        <form>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Enter promo code">
                                <button class="btn btn-outline-danger" type="button">Apply</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="card shadow-sm">
            <div class="card-body text-center py-5">
                <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                <h3>Your cart is empty</h3>
                <p class="mb-4">Looks like you haven't added any products to your cart yet.</p>
                <a href="{{ route('products.index') }}" class="btn btn-danger">Start Shopping</a>
            </div>
        </div>
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
                inputField.trigger('change');
            }
        });
        
        // Quantity increase button
        $('.quantity-increase').click(function() {
            var inputField = $(this).closest('.quantity-selector').find('.quantity-input');
            var value = parseInt(inputField.val());
            inputField.val(value + 1);
            inputField.trigger('change');
        });
    });
</script>
@endsection