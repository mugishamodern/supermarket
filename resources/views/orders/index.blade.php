@extends('layouts.app')

@section('title', 'My Orders - Mukora Supermarket')
@include('partials.header')
@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>My Orders</h1>
        <a href="{{ route('products.index') }}" class="btn btn-danger">
            <i class="fas fa-shopping-basket me-2"></i>Continue Shopping
        </a>
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
    
    @if($orders->isEmpty())
        <div class="card shadow-sm">
            <div class="card-body text-center py-5">
                <i class="fas fa-shopping-bag fa-4x text-muted mb-3"></i>
                <h3>No orders yet</h3>
                <p class="text-muted">You haven't placed any orders yet</p>
                <a href="{{ route('products.index') }}" class="btn btn-danger">
                    <i class="fas fa-shopping-basket me-2"></i>Start Shopping
                </a>
            </div>
        </div>
    @else
        <div class="card shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Order #</th>
                            <th>Date</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Payment</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td><a href="{{ route('orders.show', $order->id) }}" class="text-decoration-none">#{{ $order->id }}</a></td>
                                <td>{{ $order->created_at->format('M d, Y') }}</td>
                                <td>{{ $order->orderItems->sum('quantity') }} items</td>
                                <td>UGX {{ number_format($order->total_amount) }}</td>
                                <td>
                                    @php
                                        $statusColors = [
                                            'pending' => 'warning',
                                            'processing' => 'info',
                                            'completed' => 'success',
                                            'cancelled' => 'danger'
                                        ];
                                        $statusColor = $statusColors[$order->status] ?? 'secondary';
                                    @endphp
                                    <span class="badge bg-{{ $statusColor }}">{{ ucfirst($order->status) }}</span>
                                </td>
                                <td>
                                    @php
                                        $paymentStatusColors = [
                                            'pending' => 'warning',
                                            'paid' => 'success',
                                            'failed' => 'danger'
                                        ];
                                        $paymentStatusColor = $paymentStatusColors[$order->payment_status] ?? 'secondary';
                                    @endphp
                                    <span class="badge bg-{{ $paymentStatusColor }}">{{ ucfirst($order->payment_status) }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-outline-dark">
                                        View Details
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection