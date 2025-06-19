@extends('layouts.admin')

@section('title', 'Contact Inquiry #{{ $contactInquiry->id }} - Admin')

@section('content')
    <div class="mb-4">
        <h3 class="text-lg font-medium text-gray-900">Contact Inquiry #{{ $contactInquiry->id }}</h3>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow-sm rounded-lg divide-y divide-gray-200">
        <div class="p-6 flex justify-between items-center">
            <h4 class="text-md font-medium text-gray-900">Inquiry Details</h4>
            <a href="{{ route('admin.contact-inquiries.index') }}" class="text-indigo-600 hover:text-indigo-900">Back to List</a>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Inquiry Details -->
                <div>
                    <div class="mb-4">
                        <h6 class="text-sm font-medium text-gray-500 uppercase">Name</h6>
                        <p class="text-sm text-gray-900">{{ $contactInquiry->name }}</p>
                    </div>
                    <div class="mb-4">
                        <h6 class="text-sm font-medium text-gray-500 uppercase">Email</h6>
                        <p class="text-sm text-gray-900">{{ $contactInquiry->email }}</p>
                    </div>
                    <div class="mb-4">
                        <h6 class="text-sm font-medium text-gray-500 uppercase">Received</h6>
                        <p class="text-sm text-gray-900">{{ $contactInquiry->created_at->format('M d, Y H:i') }}</p>
                    </div>
                    <div class="mb-4">
                        <h6 class="text-sm font-medium text-gray-500 uppercase">Status</h6>
                        @php
                            $statusClasses = [
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'replied' => 'bg-green-100 text-green-800',
                            ];
                            $statusClass = $statusClasses[$contactInquiry->status] ?? 'bg-gray-100 text-gray-800';
                        @endphp
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                            {{ ucfirst($contactInquiry->status) }}
                        </span>
                    </div>
                    @if ($contactInquiry->replied_at)
                        <div class="mb-4">
    <h6 class="text-sm font-medium text-gray-500 uppercase">Replied At</h6>
    @if ($contactInquiry->replied_at instanceof \Illuminate\Support\Carbon)
        <p class="text-sm text-gray-900">{{ $contactInquiry->replied_at->format('M d, Y H:i') }}</p>
    @elseif ($contactInquiry->replied_at)
        <p class="text-sm text-gray-900">{{ $contactInquiry->replied_at }}</p>
    @else
        <p class="text-sm text-gray-500">Not yet replied</p>
    @endif
</div>
                    @endif
                    <div>
                        <h6 class="text-sm font-medium text-gray-500 uppercase">Message</h6>
                        <p class="text-sm text-gray-900 bg-gray-50 p-3 rounded">{{ $contactInquiry->message }}</p>
                    </div>
                </div>

                <!-- Reply Form -->
                <div>
                    <h6 class="text-sm font-medium text-gray-500 uppercase mb-3">Send a Reply</h6>
                    <form action="{{ route('admin.contact-inquiries.reply', $contactInquiry) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="reply" class="block text-sm font-medium text-gray-700">Your Reply</label>
                            <textarea class="mt-1 w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm" id="reply" name="reply" rows="8" required>{{ old('reply') }}</textarea>
                            @error('reply')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">
                            Send Reply
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection