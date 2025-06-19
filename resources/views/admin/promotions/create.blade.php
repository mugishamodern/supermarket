@extends('layouts.admin')

@section('header')
    Add Promotion
@endsection

@section('content')
    <form action="{{ route('admin.promotions.store') }}" method="POST" class="max-w-xl mx-auto bg-white p-6 rounded shadow" autocomplete="off">
        @csrf
        <div class="mb-4">
            <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="description" id="description" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('description') }}</textarea>
            @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="mb-4">
            <label for="category_id" class="block text-sm font-medium text-gray-700">Category (optional)</label>
            <select name="category_id" id="category_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="mb-4">
            <label for="discount_percentage" class="block text-sm font-medium text-gray-700">Discount Percentage</label>
            <input type="number" name="discount_percentage" id="discount_percentage" value="{{ old('discount_percentage') }}" min="1" max="100" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            @error('discount_percentage')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="mb-4">
            <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
            <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            @error('start_date')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="mb-4">
            <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
            <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            @error('end_date')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="mb-4">
            <label for="is_active" class="inline-flex items-center">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm">
                <span class="ml-2 text-sm text-gray-600">Active</span>
            </label>
        </div>
        <div class="mb-4">
            <label for="priority" class="block text-sm font-medium text-gray-700">Priority (optional)</label>
            <input type="number" name="priority" id="priority" value="{{ old('priority') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            @error('priority')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="mb-4">
            <label for="banner_color" class="block text-sm font-medium text-gray-700">Banner Color (optional)</label>
            <input type="text" name="banner_color" id="banner_color" value="{{ old('banner_color', 'red') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            @error('banner_color')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="mt-6 flex justify-end gap-2">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md">Create Promotion</button>
            <a href="{{ route('admin.promotions.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-md">Cancel</a>
        </div>
    </form>
@endsection 