@extends('layouts.app')

@section('title', 'My Orders - Mukora Supermarket')

@section('styles')
<link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
@endsection

@include('partials.header')

@section('content')
<!-- Hero Section -->
<section class="hero-section flex items-center justify-center parallax">
    <div class="container mx-auto text-center px-4">
        <h1 class="text-4xl md:text-6xl font-bold mb-4 text-white animate__animated animate__fadeInDown">My Orders</h1>
        <p class="text-lg md:text-xl text-white animate__animated animate__fadeInUp animate__delay-1s">View and manage your purchase history</p>
    </div>
</section>

<!-- Orders Content -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-8" data-aos="fade-up">
            <h2 class="text-3xl font-bold">My Orders</h2>
            <a href="{{ route('products.index') }}" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-6 rounded-lg transition transform hover:scale-105">
                <i class="fas fa-shopping-basket mr-2"></i> Continue Shopping
            </a>
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

        @if($orders->isEmpty())
            <div class="empty-card bg-white rounded-xl shadow-md text-center py-16" data-aos="fade-up" data-aos-delay="200">
                <i class="fas fa-shopping-bag text-6xl text-gray-400 mb-4"></i>
                <h3 class="text-2xl font-semibold mb-4">No orders yet</h3>
                <p class="text-gray-600 mb-6">You haven't placed any orders yet.</p>
                <a href="{{ route('products.index') }}" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-8 rounded-lg transition transform hover:scale-105">
                    <i class="fas fa-shopping-basket mr-2"></i> Start Shopping
                </a>
            </div>
        @else
            <div class="order-card bg-white rounded-xl shadow-md overflow-hidden" data-aos="fade-up" data-aos-delay="200">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="py-3 px-6">Order #</th>
                                <th class="py-3 px-6">Date</th>
                                <th class="py-3 px-6">Items</th>
                                <th class="py-3 px-6">Total</th>
                                <th class="py-3 px-6">Status</th>
                                <th class="py-3 px-6">Payment</th>
                                <th class="py-3 px-6"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="py-4 px-6">
                                        <a href="{{ route('orders.show', $order->id) }}" class="text-red-600 hover:underline">#{{ $order->id }}</a>
                                    </td>
                                    <td class="py-4 px-6">{{ $order->created_at->format('M d, Y') }}</td>
                                    <td class="py-4 px-6">{{ $order->orderItems->sum('quantity') }} items</td>
                                    <td class="py-4 px-6">UGX {{ number_format($order->total_amount) }}</td>
                                    <td class="py-4 px-6">
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
                                    </td>
                                    <td class="py-4 px-6">
                                        @php
                                            $paymentStatusColors = [
                                                'pending' => 'yellow-500',
                                                'paid' => 'green-500',
                                                'failed' => 'red-500'
                                            ];
                                            $paymentStatusColor = $paymentStatusColors[$order->payment_status] ?? 'gray-500';
                                        @endphp
                                        <span class="badge bg-{{ $paymentStatusColor }} text-white">{{ ucfirst($order->payment_status) }}</span>
                                    </td>
                                    <td class="py-4 px-6">
                                        <a href="{{ route('orders.show', $order->id) }}" class="bg-white border border-gray-800 text-gray-800 hover:bg-gray-800 hover:text-white font-semibold py-1 px-3 rounded-lg transition transform hover:scale-105">
                                            View Details
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="flex justify-center mt-8" data-aos="fade-up" data-aos-delay="300">
                {{ $orders->links('pagination::bootstrap-5') }}
            </div>
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
    });
</script>
@endsection