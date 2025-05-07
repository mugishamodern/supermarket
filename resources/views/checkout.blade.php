@extends('layouts.app')

@section('title', 'Checkout - Mukora Supermarket')

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
    .checkout-card, .summary-card {
        transition: all 0.3s ease;
    }
    .checkout-card:hover, .summary-card:hover {
        transform: translateY(-8px);
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
    .form-check-input:checked {
        background-color: #dc3545;
        border-color: #dc3545;
    }
    .form-check-label:hover {
        cursor: pointer;
    }
</style>
@endsection

@include('partials.header')

@section('content')
<!-- Hero Section -->
<section class="hero-section flex items-center justify-center parallax">
    <div class="container mx-auto text-center px-4">
        <h1 class="text-4xl md:text-6xl font-bold mb-4 text-white animate__animated animate__fadeInDown">Checkout</h1>
        <p class="text-lg md:text-xl text-white animate__animated animate__fadeInUp animate__delay-1s">Complete your order in a few simple steps</p>
    </div>
</section>

<!-- Checkout Content -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Checkout Form -->
            <div class="lg:col-span-2">
                <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form">
                    @csrf

                    <!-- Delivery Address -->
                    <div class="checkout-card bg-white rounded-xl shadow-md mb-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="p-6 border-b">
                            <h5 class="text-xl font-semibold">1. Delivery Address</h5>
                        </div>
                        <div class="p-6">
                            @if(count($addresses) > 0)
                                <div class="space-y-4 mb-4">
                                    @foreach($addresses as $address)
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="address_id" 
                                                   id="address{{ $address->id }}" value="{{ $address->id }}"
                                                   {{ $address->id === $defaultAddress->id ? 'checked' : '' }}>
                                            <label class="form-check-label block ml-3" for="address{{ $address->id }}">
                                                <strong class="text-gray-800">{{ $address->address_line }}</strong>
                                                <p class="text-gray-600 text-sm mb-1">
                                                    {{ $address->city }} | {{ $address->phone_number }}
                                                    @if($address->is_default)
                                                        <span class="inline-block bg-red-600 text-white text-xs px-2 py-1 rounded-full">Default</span>
                                                    @endif
                                                </p>
                                                @if($address->notes)
                                                    <small class="text-gray-600">{{ $address->notes }}</small>
                                                @endif
                                            </label>
                                        </div>
                                    @endforeach
                                </div>

                                <button type="button" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition transform hover:scale-105" 
                                        data-bs-toggle="collapse" data-bs-target="#newAddressForm">
                                    <i class="fas fa-plus mr-2"></i> Add New Address
                                </button>

                                <div class="collapse mt-4" id="newAddressForm">
                                    <div class="bg-gray-100 p-6 rounded-lg">
                                        <h6 class="text-lg font-semibold mb-3">New Delivery Address</h6>
                                        <div class="mb-3">
                                            <label for="address_line" class="block text-sm font-medium text-gray-700">Address Line</label>
                                            <input type="text" class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-600" id="address_line" name="new_address_line">
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                                            <div>
                                                <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                                                <input type="text" class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-600" id="city" name="new_city">
                                            </div>
                                            <div>
                                                <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                                <input type="text" class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-600" id="phone_number" name="new_phone_number">
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="notes" class="block text-sm font-medium text-gray-700">Delivery Instructions (Optional)</label>
                                            <textarea class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-600" id="notes" name="new_notes" rows="2"></textarea>
                                        </div>
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" id="is_default" name="new_is_default">
                                            <label class="form-check-label text-sm text-gray-700" for="is_default">
                                                Set as default address
                                            </label>
                                        </div>
                                        <button type="button" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition transform hover:scale-105" id="saveNewAddress">Save Address</button>
                                    </div>
                                </div>
                            @else
                                <div class="bg-yellow-100 p-4 rounded-lg mb-4">
                                    <p class="text-yellow-700">You don't have any saved addresses. Please add one below.</p>
                                </div>

                                <div class="bg-white p-6 rounded-lg">
                                    <h6 class="text-lg font-semibold mb-3">New Delivery Address</h6>
                                    <div class="mb-3">
                                        <label for="address_line" class="block text-sm font-medium text-gray-700">Address Line</label>
                                        <input type="text" class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-600" id="address_line" name="new_address_line" required>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                                        <div>
                                            <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                                            <input type="text" class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-600" id="city" name="new_city" required>
                                        </div>
                                        <div>
                                            <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                            <input type="text" class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-600" id="phone_number" name="new_phone_number" required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="notes" class="block text-sm font-medium text-gray-700">Delivery Instructions (Optional)</label>
                                        <textarea class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-600" id="notes" name="new_notes" rows="2"></textarea>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="is_default" name="new_is_default" checked>
                                        <label class="form-check-label text-sm text-gray-700" for="is_default">
                                            Set as default address
                                        </label>
                                    </div>
                                    <button type="button" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition transform hover:scale-105" id="saveNewAddress">Save Address</button>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="checkout-card bg-white rounded-xl shadow-md mb-6" data-aos="fade-up" data-aos-delay="200">
                        <div class="p-6 border-b">
                            <h5 class="text-xl font-semibold">2. Payment Method</h5>
                        </div>
                        <div class="p-6 space-y-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" 
                                       id="cashOnDelivery" value="cash_on_delivery" checked>
                                <label class="form-check-label flex items-center" for="cashOnDelivery">
                                    <i class="fas fa-money-bill-wave fa-2x text-green-600 mr-3"></i>
                                    <div>
                                        <strong class="text-gray-800">Cash on Delivery</strong>
                                        <p class="text-gray-600 text-sm mb-0">Pay when your order arrives</p>
                                    </div>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" 
                                       id="mobileMoney" value="mobile_money">
                                <label class="form-check-label flex items-center" for="mobileMoney">
                                    <i class="fas fa-mobile-alt fa-2x text-blue-600 mr-3"></i>
                                    <div>
                                        <strong class="text-gray-800">Mobile Money</strong>
                                        <p class="text-gray-600 text-sm mb-0">Pay using MTN Mobile Money or Airtel Money</p>
                                    </div>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" 
                                       id="creditCard" value="credit_card">
                                <label class="form-check-label flex items-center" for="creditCard">
                                    <i class="fas fa-credit-card fa-2x text-teal-600 mr-3"></i>
                                    <div>
                                        <strong class="text-gray-800">Credit/Debit Card</strong>
                                        <p class="text-gray-600 text-sm mb-0">Pay securely using your credit or debit card</p>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Order Notes -->
                    <div class="checkout-card bg-white rounded-xl shadow-md mb-6" data-aos="fade-up" data-aos-delay="300">
                        <div class="p-6 border-b">
                            <h5 class="text-xl font-semibold">3. Order Notes (Optional)</h5>
                        </div>
                        <div class="p-6">
                            <label for="orderNotes" class="block text-sm font-medium text-gray-700">Add any special instructions or requests regarding your order:</label>
                            <textarea class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-600" id="orderNotes" name="notes" rows="3"></textarea>
                        </div>
                    </div>

                    <div class="flex justify-between items-center mb-6" data-aos="fade-up" data-aos-delay="400">
                        <a href="{{ route('cart.index') }}" class="bg-white border border-gray-800 text-gray-800 hover:bg-gray-800 hover:text-white font-semibold py-2 px-6 rounded-lg transition transform hover:scale-105">
                            <i class="fas fa-arrow-left mr-2"></i> Back to Cart
                        </a>
                    </div>
                </form>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="summary-card bg-white rounded-xl shadow-md sticky top-6" data-aos="fade-up" data-aos-delay="500">
                    <div class="p-6 border-b">
                        <h5 class="text-xl font-semibold">Order Summary</h5>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3 mb-4">
                            @foreach($cartItems as $item)
                                <div class="flex justify-between">
                                    <div>
                                        <span class="text-gray-800">{{ $item['name'] }}</span>
                                        <small class="block text-gray-600">{{ $item['quantity'] }} x UGX {{ number_format($item['price']) }}</small>
                                    </div>
                                    <span class="text-gray-800">UGX {{ number_format($item['total']) }}</span>
                                </div>
                            @endforeach
                        </div>
                        <hr class="my-4">
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="text-gray-800">UGX {{ number_format($totalAmount) }}</span>
                        </div>
                        <div class="flex justify-between mb-4">
                            <span class="text-gray-600">Shipping Fee</span>
                            <span class="text-gray-800">Free</span>
                        </div>
                        <div class="flex justify-between mb-4">
                            <strong class="text-gray-800">Total</strong>
                            <strong class="text-red-600">UGX {{ number_format($totalAmount) }}</strong>
                        </div>
                        <button type="submit" form="checkout-form" class="block w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-3 rounded-lg transition transform hover:scale-105">
                            Place Order
                        </button>
                        <div class="text-center mt-3">
                            <small class="text-gray-600">
                                By placing your order, you agree to our 
                                <a href="{{ route('terms') }}" class="text-red-600 hover:underline">Terms of Service</a> and 
                                <a href="{{ route('privacy') }}" class="text-red-600 hover:underline">Privacy Policy</a>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                    Swal.fire({
                        title: 'Success!',
                        text: 'Address saved successfully',
                        icon: 'success',
                        confirmButtonColor: '#dc3545'
                    }).then(() => {
                        location.reload();
                    });
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