@extends('layouts.app')

@section('title', 'Order Details - Mukora Supermarket')
@include('partials.header')
@section('content')
<div class="container py-5">
    <div class="mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <h1>Order #{{ $order->id }}</h1>
            <a href="{{ route('orders.index') }}" class="btn btn-outline-dark">
                <i class="fas fa-arrow-left me-2"></i> Back to Orders
            </a>
        </div>
        <div class="text-muted">
            Placed on {{ $order->created_at->format('M d, Y, h:i A') }}
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <!-- Order Status -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Order Status</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            @php
                                $statusColors = [
                                    'pending' => 'warning',
                                    'processing' => 'info',
                                    'completed' => 'success',
                                    'cancelled' => 'danger'
                                ];
                                $statusColor = $statusColors[$order->status] ?? 'secondary';
                            @endphp
                            <span class="badge bg-{{ $statusColor }} py-2 px-3">{{ ucfirst($order->status) }}</span>
                        </div>
                        
                        @if($order->status === 'pending')
                            <form action="{{ route('orders.update', $order->id) }}" method="POST" 
                                onsubmit="return confirm('Are you sure you want to cancel this order?');">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-outline-danger">Cancel Order</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Order Items</h5>
                </div>
                <div class="card-body">
                    @foreach($order->orderItems as $item)
                        <div class="d-flex mb-3">
                            <div class="me-3">
                                @if($item->product && $item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}" 
                                        alt="{{ $item->product->name }}" class="rounded"
                                        style="width: 64px; height: 64px; object-fit: cover;">
                                @else
                                    <div class="bg-light rounded" style="width: 64px; height: 64px;">
                                        <div class="d-flex align-items-center justify-content-center h-100 text-muted">
                                            <i class="fas fa-image"></i>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-fill">
                                <div class="d-flex justify-content-between mb-1">
                                    <h6 class="mb-0">{{ $item->product ? $item->product->name : 'Product Unavailable' }}</h6>
                                    <span>UGX {{ number_format($item->price * $item->quantity) }}</span>
                                </div>
                                <div class="text-muted">
                                    <small>{{ $item->quantity }} x UGX {{ number_format($item->price) }}</small>
                                </div>
                            </div>
                        </div>
                        @if(!$loop->last)
                            <hr>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Delivery Information -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Delivery Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <h6>Delivery Address</h6>
                            <p class="mb-1">{{ $order->address->address_line }}</p>
                            <p class="mb-1">{{ $order->address->city }}</p>
                            <p class="mb-0">Phone: {{ $order->address->phone_number }}</p>
                            @if($order->address->notes)
                                <p class="text-muted mt-2 mb-0"><small>{{ $order->address->notes }}</small></p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h6>Payment Method</h6>
                            @php
                                $paymentIcons = [
                                    'cash_on_delivery' => 'fas fa-money-bill-wave text-success',
                                    'mobile_money' => 'fas fa-mobile-alt text-primary',
                                    'credit_card' => 'fas fa-credit-card text-info'
                                ];
                                $paymentLabel = [
                                    'cash_on_delivery' => 'Cash on Delivery',
                                    'mobile_money' => 'Mobile Money',
                                    'credit_card' => 'Credit/Debit Card'
                                ];
                                $icon = $paymentIcons[$order->payment_method] ?? 'fas fa-money-bill-wave';
                                $label = $paymentLabel[$order->payment_method] ?? 'Unknown Method';
                            @endphp
                            <p><i class="{{ $icon }} me-2"></i> {{ $label }}</p>
                            
                            @php
                                $paymentStatusColors = [
                                    'pending' => 'warning',
                                    'paid' => 'success',
                                    'failed' => 'danger'
                                ];
                                $paymentStatusColor = $paymentStatusColors[$order->payment_status] ?? 'secondary';
                            @endphp
                            <p>Status: <span class="badge bg-{{ $paymentStatusColor }}">{{ ucfirst($order->payment_status) }}</span></p>
                        </div>
                    </div>
                    
                    @if($order->notes)
                        <div class="mt-3">
                            <h6>Order Notes</h6>
                            <p class="mb-0">{{ $order->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card shadow-sm mb-4 sticky-lg-top" style="top: 20px;">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Order Summary</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal ({{ $order->orderItems->sum('quantity') }} items)</span>
                            <span>UGX {{ number_format($order->total_amount) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Shipping Fee</span>
                            <span>Free</span>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <strong>Total</strong>
                        <strong class="text-danger">UGX {{ number_format($order->total_amount) }}</strong>
                    </div>
                    
                    <div class="text-center mt-4">
                        @if($order->status === 'pending')
                            <a href="#" class="btn btn-success btn-sm w-100 mb-2">
                                <i class="fas fa-question-circle me-2"></i>Need Help?
                            </a>
                        @endif
                        
                        <a href="{{ route('products.index') }}" class="btn btn-danger btn-sm w-100">
                            <i class="fas fa-shopping-basket me-2"></i>Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection