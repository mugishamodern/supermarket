<!-- resources/views/admin/orders/index.blade.php -->
@extends('layouts.admin')

@section('title', 'Orders Management - Admin')

@section('content')
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-900">Orders Management</h3>
            <a href="{{ route('admin.orders.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                Create New Order
            </a>
        </div>
    </div>

    <!-- Status Filter -->
    <div class="mb-6">
        <div class="flex space-x-4">
            <a href="{{ route('admin.orders.index') }}" class="px-3 py-2 {{ request()->routeIs('admin.orders.index') && !request()->query('status') ? 'bg-indigo-100 text-indigo-800 font-medium rounded-md' : 'text-gray-600 hover:bg-gray-100 rounded-md' }}">
                All
            </a>
            <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="px-3 py-2 {{ request()->query('status') == 'pending' ? 'bg-indigo-100 text-indigo-800 font-medium rounded-md' : 'text-gray-600 hover:bg-gray-100 rounded-md' }}">
                Pending
            </a>
            <a href="{{ route('admin.orders.index', ['status' => 'processing']) }}" class="px-3 py-2 {{ request()->query('status') == 'processing' ? 'bg-indigo-100 text-indigo-800 font-medium rounded-md' : 'text-gray-600 hover:bg-gray-100 rounded-md' }}">
                Processing
            </a>
            <a href="{{ route('admin.orders.index', ['status' => 'completed']) }}" class="px-3 py-2 {{ request()->query('status') == 'completed' ? 'bg-indigo-100 text-indigo-800 font-medium rounded-md' : 'text-gray-600 hover:bg-gray-100 rounded-md' }}">
                Completed
            </a>
            <a href="{{ route('admin.orders.index', ['status' => 'cancelled']) }}" class="px-3 py-2 {{ request()->query('status') == 'cancelled' ? 'bg-indigo-100 text-indigo-800 font-medium rounded-md' : 'text-gray-600 hover:bg-gray-100 rounded-md' }}">
                Cancelled
            </a>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Order ID
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Customer
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Amount
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Payment Method
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($orders as $order)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                #{{ $order->id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $order->user->name }}</div>
                                <div class="text-sm text-gray-500">{{ $order->user->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">UGX {{ number_format($order->total_amount, 2) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $order->payment_method_name }}</div>
                                <div class="text-sm text-gray-500">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $order->payment_status_badge_class }}">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $order->status_badge_class }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $order->created_at->format('M d, Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                        View
                                    </a>
                                    <a href="{{ route('admin.orders.edit', $order->id) }}" class="text-blue-600 hover:text-blue-900">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this order?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                No orders found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($orders->hasPages())
        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    @endif
@endsection