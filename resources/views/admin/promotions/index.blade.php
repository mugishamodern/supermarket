@extends('layouts.admin')

@section('header')
    Promotions Management
@endsection

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Promotions</h2>
        <a href="{{ route('admin.promotions.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md">Add Promotion</a>
    </div>
    @if(session('success'))
        <div class="mb-4 p-4 rounded-md bg-green-100 text-green-800">
            {{ session('success') }}
        </div>
    @endif
    <div class="bg-white shadow rounded-lg overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Discount</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Start</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">End</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($promotions as $promotion)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $promotion->title }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $promotion->category_id ? ($promotion->category->name ?? 'Unknown') : 'All' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $promotion->discount_percentage }}%</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($promotion->start_date)->format('Y-m-d') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($promotion->end_date)->format('Y-m-d') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($promotion->is_active)
                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Active</span>
                            @else
                                <span class="px-2 py-1 bg-gray-200 text-gray-800 rounded-full text-xs">Inactive</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap flex gap-2">
                            <a href="{{ route('admin.promotions.edit', $promotion) }}" class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('admin.promotions.destroy', $promotion) }}" method="POST" onsubmit="return confirm('Delete this promotion?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">No promotions found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">
        {{ $promotions->links() }}
    </div>
@endsection 