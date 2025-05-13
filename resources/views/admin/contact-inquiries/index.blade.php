@extends('layouts.admin')

@section('title', 'Contact Inquiries - Admin')

@section('content')
    <div class="mb-4">
        <h3 class="text-lg font-medium text-gray-900">Contact Inquiries</h3>
    </div>

    <div class="mb-4">
        <div class="flex space-x-4">
            <a href="{{ route('admin.contact-inquiries.index') }}" class="px-3 py-2 {{ request()->routeIs('admin.contact-inquiries.index') && !request()->query('status') ? 'bg-indigo-100 text-indigo-800 font-medium rounded-md' : 'text-gray-600 hover:bg-gray-100 rounded-md' }}">
                All
            </a>
            <a href="{{ route('admin.contact-inquiries.index', ['status' => 'pending']) }}" class="px-3 py-2 {{ request()->query('status') == 'pending' ? 'bg-indigo-100 text-indigo-800 font-medium rounded-md' : 'text-gray-600 hover:bg-gray-100 rounded-md' }}">
                Pending
            </a>
            <a href="{{ route('admin.contact-inquiries.index', ['status' => 'replied']) }}" class="px-3 py-2 {{ request()->query('status') == 'replied' ? 'bg-indigo-100 text-indigo-800 font-medium rounded-md' : 'text-gray-600 hover:bg-gray-100 rounded-md' }}">
                Replied
            </a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Inquiry ID
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Customer
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Message Preview
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
                @forelse($inquiries as $inquiry)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            #{{ $inquiry->id }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $inquiry->name }}</div>
                            <div class="text-sm text-gray-500">{{ $inquiry->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ Str::limit($inquiry->message, 50) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusClasses = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'replied' => 'bg-green-100 text-green-800',
                                ];
                                $statusClass = $statusClasses[$inquiry->status] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                {{ ucfirst($inquiry->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $inquiry->created_at->format('M d, Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('admin.contact-inquiries.show', $inquiry) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                            No inquiries found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $inquiries->links() }}
    </div>
@endsection