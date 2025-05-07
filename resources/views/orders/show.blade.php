@extends('layouts.app')

@section('title', 'Order Details - Mukora Supermarket')

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
    .order-card, .summary-card {
        transition: all 0.3s ease;
    }
    .order-card:hover, .summary-card:hover {
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
    .badge {
        padding: 0.5rem 1rem;
        border-radius: 9999px;
    }
</style>
@endsection

@include('partials.header')

@section('content')
<!-- Hero Section -->
<section class="hero-section flex items-center justify-center parallax">
    <div class="container mx-auto text-center px-4">
        <h1 class="text-4xl md:text-6xl font-bold mb-4 text-white animate__animated animate__fadeInDown">Order #{{ $order->id }}</h1>
        <p class="text-lg md:text-xl text-white animate__animated animate__fadeInUp animate__delay-1s">Review your order details</p>
    </div>
</section>

<!-- Order Details Content -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="mb-8" data-aos="fade-up">
            <div class="flex justify-between items-center mb-2">
                <h2 class="text-3xl font-bold">Order #{{ $order->id }}</h2>
                <a href="{{ route('orders.index') }}" class="bg-white border border-gray-800 text-gray-800 hover:bg-gray-800 hover:text-white font-semibold py-2 px-6 rounded-lg transition transform hover:scale-105">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Orders
                </a>
            </div>
            <p class="text-gray-600">Placed on {{ $order->created_at->format('M d, Y, h:i A') }}</p>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg" data-aos="fade-up" data-aos-delay="100">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg" data-aos="fade-up" data-aos-delay="100">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Order Information -->
            <div class="lg:col-span-2">
                <!-- Order Status -->
                <div class="order-card bg-white rounded-xl shadow-md mb-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="p-6 border-b">
                        <h5 class="text-xl font-semibold">Order Status</h5>
                    </div>
                    <div class="p-6 flex justify-between items-center">
                        <div>
                            @php
                                $statusColors = [
                                    'pending' => 'yellow-500',
                                    'processing' => 'blue-500',
                                    'completed' => 'green-500',
                                    'cancelled' => 'red-500'
                                ];
                                $statusColor = $statusColors[$order->status] ?? 'gray-500';
                            @endphp
                            <span class="badge bg-{{ $statusColor }} text-white">{{ ucfirst($order->status) }}</span>
                        </div>
                        @if($order->status === 'pending')
                            <form action="{{ route('orders.update', $order->id) }}" method="POST" 
                                  onsubmit="return confirm('Are you sure you want to cancel this order?');">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition transform hover:scale-105">Cancel Order</button>
                            </form>
                        @endif
                    </div>
                </div>

                <!-- Order Items -->
                <div class="order-card bg-white rounded-xl shadow-md mb-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="p-6 border-b">
                        <h5 class="text-xl font-semibold">Order Items</h5>
                    </div>
                    <div class="p-6">
                        @foreach($order->orderItems as $item)
                            <div class="flex mb-4">
                                <div class="mr-4">
                                    @if($item->product && $item->product->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}" 
                                             alt="{{ $item->product->name }}" 
                                             class="rounded-lg w-16 h-16 object-cover">
                                    @else
                                        <div class="bg-gray-100 rounded-lg w-16 h-16 flex items-center justify-center">
                                            <i class="fas fa-image text-gray-400"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <div class="flex justify-between mb-1">
                                        <h6 class="text-lg font-medium">{{ $item->product ? $item->product->name : 'Product Unavailable' }}</h6>
                                        <span class="text-gray-800">UGX {{ number_format($item->price * $item->quantity) }}</span>
                                    </div>
                                    <p class="text-gray-600 text-sm">{{ $item->quantity }} x UGX {{ number_format($item->price) }}</p>
                                </div>
                            </div>
                            @if(!$loop->last)
                                <hr class="my-2">
                            @endif
                        @endforeach
                    </div>
                </div>

                <!-- Delivery Information -->
                <div class="order-card bg-white rounded-xl shadow-md mb-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="p-6 border-b">
                        <h5 class="text-xl font-semibold">Delivery Information</h5>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <h6 class="text-lg font-medium mb-2">Delivery Address</h6>
                                <p class="text-gray-600 mb-1">{{ $order->address->address_line }}</p>
                                <p class="text-gray-600 mb-1">{{ $order->address->city }}</p>
                                <p class="text-gray-600 mb-0">Phone: {{ $order->address->phone_number }}</p>
                                @if($order->address->notes)
                                    <p class="text-gray-600 text-sm mt-2">{{ $order->address->notes }}</p>
                                @endif
                            </div>
                            <div>
                                <h6 class="text-lg font-medium mb-2">Payment Method</h6>
                                @php
                                    $paymentIcons = [
                                        'cash_on_delivery' => 'fas fa-money-bill-wave text-green-600',
                                        'mobile_money' => 'fas fa-mobile-alt text-blue-600',
                                        'credit_card' => 'fas fa-credit-card text-teal-600'
                                    ];
                                    $paymentLabel = [
                                        'cash_on_delivery' => 'Cash on Delivery',
                                        'mobile_money' => 'Mobile Money',
                                        'credit_card' => 'Credit/Debit Card'
                                    ];
                                    $icon = $paymentIcons[$order->payment_method] ?? 'fas fa-money-bill-wave text-gray-600';
                                    $label = $paymentLabel[$order->payment_method] ?? 'Unknown Method';
                                @endphp
                                <p class="text-gray-600"><i class="{{ $icon }} mr-2"></i> {{ $label }}</p>
                                @php
                                    $paymentStatusColors = [
                                        'pending' => 'yellow-500',
                                        'paid' => 'green-500',
                                        'failed' => 'red-500'
                                    ];
                                    $paymentStatusColor = $paymentStatusColors[$order->payment_status] ?? 'gray-500';
                                @endphp
                                <p class="text-gray-600">Status: <span class="badge bg-{{ $paymentStatusColor }} text-white">{{ ucfirst($order->payment_status) }}</span></p>
                            </div>
                        </div>
                        @if($order->notes)
                            <div class="mt-4">
                                <h6 class="text-lg font-medium mb-2">Order Notes</h6>
                                <p class="text-gray-600">{{ $order->notes }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="summary-card bg-white rounded-xl shadow-md sticky top-6" data-aos="fade-up" data-aos-delay="500">
                    <div class="p-6 border-b">
                        <h5 class="text-xl font-semibold">Order Summary</h5>
                    </div>
                    <div class="p-6">
                        <div class="space-y-2 mb-4">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal ({{ $order->orderItems->sum('quantity') }} items)</span>
                                <span class="text-gray-800">UGX {{ number_format($order->total_amount) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Shipping Fee</span>
                                <span class="text-gray-800">Free</span>
                            </div>
                        </div>
                        <hr class="my-4">
                        <div class="flex justify-between mb-4">
                            <strong class="text-gray-800">Total</strong>
                            <strong class="text-red-600">UGX {{ number_format($order->total_amount) }}</strong>
                        </div>
                        <div class="space-y-2 text-center">
                            @if($order->status === 'pending')
                                <a href="{{ route('contact') }}" class="block bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition transform hover:scale-105">
                                    <i class="fas fa-question-circle mr-2"></i> Need Help?
                                </a>
                            @endif
                            <a href="{{ route('products.index') }}" class="block bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition transform hover:scale-105">
                                <i class="fas fa-shopping-basket mr-2"></i> Continue Shopping
                            </a>
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
    });
</script>
@endsection