<!-- resources/views/admin/orders/index.blade.php -->
@extends('layouts.admin')

@section('header')
    Orders Management
@endsection

@section('content')
    <div class="mb-4">
        <h3 class="text-lg font-medium text-gray-900">All Orders</h3>
    </div>

    <div class="mb-4">
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

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Order ID
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Customer
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Total
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Date
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($orders as $order)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            #{{ $order->id }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $order->user->name }}</div>
                            <div class="text-sm text-gray-500">{{ $order->user->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">${{ number_format($order->total_amount, 2) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusClasses = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'processing' => 'bg-blue-100 text-blue-800',
                                    'completed' => 'bg-green-100 text-green-800',
                                    'cancelled' => 'bg-red-100 text-red-800',
                                ];
                                $statusClass = $statusClasses[$order->status] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $order->created_at->format('M d, Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('admin.orders.show', $order) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                            No orders found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $orders->links() }}
    </div>
@endsection