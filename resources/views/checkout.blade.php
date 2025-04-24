@extends('layouts.app')

@section('title', 'Checkout - Mukora Supermarket')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <h1 class="mb-4">Checkout</h1>
            
            <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form">
                @csrf
                
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">1. Delivery Address</h5>
                    </div>
                    <div class="card-body">
                        @if(count($addresses) > 0)
                            <div class="mb-3">
                                @foreach($addresses as $address)
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" name="address_id" 
                                            id="address{{ $address->id }}" value="{{ $address->id }}"
                                            {{ $address->id === $defaultAddress->id ? 'checked' : '' }}>
                                        <label class="form-check-label d-block ms-2" for="address{{ $address->id }}">
                                            <strong>{{ $address->address_line }}</strong>
                                            <p class="text-muted mb-1">
                                                {{ $address->city }} | {{ $address->phone_number }}
                                                @if($address->is_default)
                                                    <span class="badge bg-danger">Default</span>
                                                @endif
                                            </p>
                                            @if($address->notes)
                                                <small class="text-muted">{{ $address->notes }}</small>
                                            @endif
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            
                            <button type="button" class="btn btn-outline-danger mb-3" data-bs-toggle="collapse" 
                                data-bs-target="#newAddressForm">
                                <i class="fas fa-plus me-2"></i> Add New Address
                            </button>
                            
                            <div class="collapse" id="newAddressForm">
                                <div class="card card-body bg-light">
                                    <h6 class="mb-3">New Delivery Address</h6>
                                    <div class="mb-3">
                                        <label for="address_line" class="form-label">Address Line</label>
                                        <input type="text" class="form-control" id="address_line" name="new_address_line">
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="city" class="form-label">City</label>
                                            <input type="text" class="form-control" id="city" name="new_city">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="phone_number" class="form-label">Phone Number</label>
                                            <input type="text" class="form-control" id="phone_number" name="new_phone_number">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="notes" class="form-label">Delivery Instructions (Optional)</label>
                                        <textarea class="form-control" id="notes" name="new_notes" rows="2"></textarea>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="is_default" name="new_is_default">
                                        <label class="form-check-label" for="is_default">
                                            Set as default address
                                        </label>
                                    </div>
                                    <button type="button" class="btn btn-danger" id="saveNewAddress">Save Address</button>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-warning">
                                You don't have any saved addresses. Please add one below.
                            </div>
                            
                            <div class="card card-body">
                                <h6 class="mb-3">New Delivery Address</h6>
                                <div class="mb-3">
                                    <label for="address_line" class="form-label">Address Line</label>
                                    <input type="text" class="form-control" id="address_line" name="new_address_line" required>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="city" class="form-label">City</label>
                                        <input type="text" class="form-control" id="city" name="new_city" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone_number" class="form-label">Phone Number</label>
                                        <input type="text" class="form-control" id="phone_number" name="new_phone_number" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="notes" class="form-label">Delivery Instructions (Optional)</label>
                                    <textarea class="form-control" id="notes" name="new_notes" rows="2"></textarea>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="is_default" name="new_is_default" checked>
                                    <label class="form-check-label" for="is_default">
                                        Set as default address
                                    </label>
                                </div>
                                <button type="button" class="btn btn-danger" id="saveNewAddress">Save Address</button>
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">2. Payment Method</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="payment_method" 
                                id="cashOnDelivery" value="cash_on_delivery" checked>
                            <label class="form-check-label" for="cashOnDelivery">
                                <div class="d-flex align-items-center">
                                    <div class="me-3">
                                        <i class="fas fa-money-bill-wave fa-2x text-success"></i>
                                    </div>
                                    <div>
                                        <strong>Cash on Delivery</strong>
                                        <p class="text-muted mb-0">Pay when your order arrives</p>
                                    </div>
                                </div>
                            </label>
                        </div>
                        
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="payment_method" 
                                id="mobileMoney" value="mobile_money">
                            <label class="form-check-label" for="mobileMoney">
                                <div class="d-flex align-items-center">
                                    <div class="me-3">
                                        <i class="fas fa-mobile-alt fa-2x text-primary"></i>
                                    </div>
                                    <div>
                                        <strong>Mobile Money</strong>
                                        <p class="text-muted mb-0">Pay using MTN Mobile Money or Airtel Money</p>
                                    </div>
                                </div>
                            </label>
                        </div>
                        
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="payment_method" 
                                id="creditCard" value="credit_card">
                            <label class="form-check-label" for="creditCard">
                                <div class="d-flex align-items-center">
                                    <div class="me-3">
                                        <i class="fas fa-credit-card fa-2x text-info"></i>
                                    </div>
                                    <div>
                                        <strong>Credit/Debit Card</strong>
                                        <p class="text-muted mb-0">Pay securely using your credit or debit card</p>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">3. Order Notes (Optional)</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="orderNotes" class="form-label">Add any special instructions or requests regarding your order:</label>
                            <textarea class="form-control" id="orderNotes" name="notes" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between mb-5">
                    <a href="{{ route('cart.index') }}" class="btn btn-outline-dark">
                        <i class="fas fa-arrow-left me-2"></i> Back to Cart
                    </a>
                </div>
            </form>
        </div>
        
        <div class="col-lg-4">
            <div class="card shadow-sm mb-4 sticky-lg-top" style="top: 20px;">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Order Summary</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        @foreach($cartItems as $item)
                            <div class="d-flex justify-content-between mb-3">
                                <div>
                                    <span>{{ $item['name'] }}</span>
                                    <small class="d-block text-muted">{{ $item['quantity'] }} x UGX {{ number_format($item['price']) }}</small>
                                </div>
                                <span>UGX {{ number_format($item['total']) }}</span>
                            </div>
                        @endforeach
                    </div>
                    
                    <hr>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal</span>
                        <span>UGX {{ number_format($totalAmount) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Shipping Fee</span>
                        <span>Free</span>
                    </div>
                    <div class="d-flex justify-content-between mb-4">
                        <strong>Total</strong>
                        <strong class="text-danger">UGX {{ number_format($totalAmount) }}</strong>
                    </div>
                    
                    <button type="submit" form="checkout-form" class="btn btn-danger btn-lg w-100">
                        Place Order
                    </button>
                    
                    <div class="text-center mt-3">
                        <small class="text-muted">
                            By placing your order, you agree to our 
                            <a href="#">Terms of Service</a> and 
                            <a href="#">Privacy Policy</a>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Save new address via AJAX
        $('#saveNewAddress').click(function() {
            const addressLine = $('input[name="new_address_line"]').val();
            const city = $('input[name="new_city"]').val();
            const phoneNumber = $('input[name="new_phone_number"]').val();
            const notes = $('textarea[name="new_notes"]').val();
            const isDefault = $('input[name="new_is_default"]').is(':checked') ? 1 : 0;
            
            if (!addressLine || !city || !phoneNumber) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Please fill in all required fields',
                    icon: 'error',
                    confirmButtonColor: '#dc3545'
                });
                return;
            }
            
            $.ajax({
                url: "{{ route('profile.address.store') }}",
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    address_line: addressLine,
                    city: city,
                    phone_number: phoneNumber,
                    notes: notes,
                    is_default: isDefault
                },
                success: function(response) {
                    // Refresh the page to show the new address
                    location.reload();
                },
                error: function(xhr) {
                    let errorMessage = 'There was an error saving your address';
                    
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        const errors = xhr.responseJSON.errors;
                        errorMessage = Object.values(errors)[0][0];
                    }
                    
                    Swal.fire({
                        title: 'Error!',
                        text: errorMessage,
                        icon: 'error',
                        confirmButtonColor: '#dc3545'
                    });
                }
            });
        });
        
        // Form validation before submission
        $('#checkout-form').submit(function(e) {
            const addressId = $('input[name="address_id"]:checked').val();
            
            if (!addressId) {
                e.preventDefault();
                Swal.fire({
                    title: 'Error!',
                    text: 'Please select a delivery address',
                    icon: 'error',
                    confirmButtonColor: '#dc3545'
                });
            }
        });
    });
</script>
@endsection