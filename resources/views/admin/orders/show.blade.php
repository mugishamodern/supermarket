<!-- resources/views/admin/orders/show.blade.php -->
@extends('layouts.admin')

@section('header')
    Order #{{ $order->id }} Details
@endsection

@section('content')
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-900">Order Information</h3>
            <a href="{{ route('admin.orders.index') }}" class="text-indigo-600 hover:text-indigo-900">Back to Orders</a>
        </div>
    </div>

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
                @php
                    $statusClasses = [
                        'pending' => 'bg-yellow-100 text-yellow-800',
                        'processing' => 'bg-blue-100 text-blue-800',
                        'completed' => 'bg-green-100 text-green-800',
                        'cancelled' => 'bg-red-100 text-red-800',
                    ];
                    $statusClass = $statusClasses[$order->status] ?? 'bg-gray-100 text-gray-800';
                @endphp
                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{ $statusClass }}">
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
                        ${{ number_format($order->total_amount, 2) }}
                    </dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">
                        Payment Method
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        {{ $order->payment_method ?? 'Not specified' }}
                    </dd>
                </div>
            </dl>
        </div>
    </div>

    <!-- Shipping Address -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Shipping Address
            </h3>
        </div>
        <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
            <address class="text-sm text-gray-900 not-italic">
                {{ $order->shipping_address->full_name ?? $order->user->name }}<br>
                {{ $order->shipping_address->address_line1 ?? 'No address line 1' }}<br>
                @if(isset($order->shipping_address->address_line2) && $order->shipping_address->address_line2)
                    {{ $order->shipping_address->address_line2 }}<br>
                @endif
                {{ $order->shipping_address->city ?? 'No city' }}, {{ $order->shipping_address->state ?? 'No state' }} {{ $order->shipping_address->postal_code ?? 'No postal code' }}<br>
                {{ $order->shipping_address->country ?? 'No country' }}
            </address>
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
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Product
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Price
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Quantity
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Subtotal
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr class="{{ $loop->odd ? 'bg-white' : 'bg-gray-50' }}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if($item->product && $item->product->image)
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded object-cover" src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product_name }}">
                                        </div>
                                    @endif
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $item->product_name }}
                                        </div>
                                        @if($item->product)
                                            <div class="text-sm text-gray-500">
                                                SKU: {{ $item->product->sku ?? 'N/A' }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                ${{ number_format($item->price, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $item->quantity }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                ${{ number_format($item->price * $item->quantity, 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50">
                    <tr>
                        <th colspan="3" class="px-6 py-3 text-right text-sm font-medium text-gray-500">
                            Subtotal
                        </th>
                        <td class="px-6 py-3 text-sm text-gray-900">
                            ${{ number_format($order->subtotal ?? $order->total_amount, 2) }}
                        </td>
                    </tr>
                    @if(isset($order->shipping_cost) && $order->shipping_cost > 0)
                    <tr>
                        <th colspan="3" class="px-6 py-3 text-right text-sm font-medium text-gray-500">
                            Shipping
                        </th>
                        <td class="px-6 py-3 text-sm text-gray-900">
                            ${{ number_format($order->shipping_cost, 2) }}
                        </td>
                    </tr>
                    @endif
                    @if(isset($order->tax) && $order->tax > 0)
                    <tr>
                        <th colspan="3" class="px-6 py-3 text-right text-sm font-medium text-gray-500">
                            Tax
                        </th>
                        <td class="px-6 py-3 text-sm text-gray-900">
                            ${{ number_format($order->tax, 2) }}
                        </td>
                    </tr>
                    @endif
                    <tr>
                        <th colspan="3" class="px-6 py-3 text-right text-sm font-medium text-gray-900">
                            Total
                        </th>
                        <td class="px-6 py-3 text-sm font-medium text-gray-900">
                            ${{ number_format($order->total_amount, 2) }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Order Status Update -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Update Order Status
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
                        <label for="notes" class="block text-sm font-medium text-gray-700">Admin Notes</label>
                        <textarea id="notes" name="notes" rows="3" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ $order->admin_notes ?? '' }}</textarea>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Update Order
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection