<!-- resources/views/admin/orders/show.blade.php -->
@extends('layouts.admin')

@section('title', 'Order #{{ $order->id }} - Admin')

@section('content')
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-900">Order #{{ $order->id }} Details</h3>
            <div class="flex space-x-3">
                <a href="{{ route('admin.orders.edit', $order->id) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                    Edit Order
                </a>
                <a href="{{ route('admin.orders.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                    Back to Orders
                </a>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
        <div class="px-4 py-5 sm:px-6 flex justify-between">
            <div>
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Order Summary
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Placed on {{ $order->created_at->format('F j, Y \a\t g:i A') }}
                </p>
            </div>
            <div>
                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{ $order->status_badge_class }}">
                    {{ ucfirst($order->status) }}
                </span>
            </div>
        </div>
        <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">
                        Customer Name
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        {{ $order->user->name }}
                    </dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">
                        Email Address
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        {{ $order->user->email }}
                    </dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">
                        Total Amount
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        UGX {{ number_format($order->total_amount, 2) }}
                    </dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">
                        Payment Method
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        {{ $order->payment_method_name }}
                    </dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">
                        Payment Status
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $order->payment_status_badge_class }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">
                        Last Updated
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        {{ $order->updated_at->format('F j, Y \a\t g:i A') }}
                    </dd>
                </div>
            </dl>
        </div>
    </div>

    <!-- Customer Address -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Delivery Address
            </h3>
        </div>
        <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
            @if($order->address)
                <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">
                            Street Address
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $order->address->street_address }}
                        </dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">
                            City
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $order->address->city }}
                        </dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">
                            State/Province
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $order->address->state }}
                        </dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">
                            Postal Code
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $order->address->postal_code }}
                        </dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">
                            Phone Number
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $order->address->phone_number }}
                        </dd>
                    </div>
                </dl>
            @else
                <p class="text-sm text-gray-500">No address information available.</p>
            @endif
        </div>
    </div>

    <!-- Order Items -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Order Items
            </h3>
        </div>
        <div class="border-t border-gray-200">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Product
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Price
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Quantity
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($order->items as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-lg object-cover" 
                                                 src="{{ $item->product->image ?? '/images/product-placeholder.jpg' }}" 
                                                 alt="{{ $item->product->name }}">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $item->product->name }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $item->product->category->name ?? 'Uncategorized' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    UGX {{ number_format($item->price, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $item->quantity }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    UGX {{ number_format($item->price * $item->quantity, 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Order Notes -->
    @if($order->notes || $order->admin_notes)
        <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Order Notes
                </h3>
            </div>
            <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                @if($order->notes)
                    <div class="mb-4">
                        <dt class="text-sm font-medium text-gray-500">Customer Notes</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $order->notes }}</dd>
                    </div>
                @endif
                @if($order->admin_notes)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Admin Notes</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $order->admin_notes }}</dd>
                    </div>
                @endif
            </div>
        </div>
    @endif

    <!-- Quick Status Update -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Quick Status Update
            </h3>
        </div>
        <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
            <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-6 gap-6">
                    <div class="col-span-1 md:col-span-3">
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select id="status" name="status" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    <div class="col-span-1 md:col-span-3">
                        <label for="payment_status" class="block text-sm font-medium text-gray-700">Payment Status</label>
                        <select id="payment_status" name="payment_status" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>Failed</option>
                        </select>
                    </div>
                    <div class="col-span-1 md:col-span-6">
                        <label for="admin_notes" class="block text-sm font-medium text-gray-700">Admin Notes</label>
                        <textarea id="admin_notes" name="admin_notes" rows="3" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ $order->admin_notes ?? '' }}</textarea>
                    </div>
                </div>
                <div class="mt-6">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-md transition">
                        Update Order
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection