@extends('layouts.app')

@section('title', 'My Profile - Dashboard')

@section('styles')
<link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
@endsection

@include('partials.header')

@section('content')

<div class="container mx-auto px-4 py-8 flex flex-col md:flex-row gap-8">
    <!-- Main Content -->
    <main class="flex-1 space-y-8">
        <!-- Profile Header -->
        <section class="bg-white rounded-2xl shadow-lg p-6 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-20 h-20 rounded-full bg-gray-200 flex items-center justify-center text-3xl font-bold text-gray-500">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 mb-1">{{ $user->name }}</h1>
                    <p class="text-gray-600 text-sm mb-1">{{ $user->email }}</p>
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-medium {{ $user->email_verified_at ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $user->email_verified_at ? 'Email Verified' : 'Not Verified' }}
                    </span>
                </div>
            </div>
            <a href="{{ route('user.edit') }}" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded-full transition text-center">Edit Profile</a>
        </section>

        <!-- Account Overview -->
        <section class="bg-white p-6 rounded-2xl shadow-lg">
            <h2 class="text-xl font-bold mb-4 text-gray-800">Account Overview</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="font-medium text-gray-600 mb-1">Member Since</p>
                    <p class="text-lg">{{ $user->created_at->format('M d, Y') }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="font-medium text-gray-600 mb-1">Orders</p>
                    <p class="text-lg">Coming soon</p>
                </div>
            </div>
        </section>

        <!-- Address Book -->
        <section class="bg-white p-6 rounded-2xl shadow-lg">
            <h2 class="text-xl font-bold mb-4 text-gray-800">Address Book</h2>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="font-medium text-gray-600 mb-1">Default Shipping Address</p>
                <p class="text-gray-700">{{ $user->name }}</p>
                <p class="text-gray-700">Sunways hostel Makerere</p>
                <p class="text-gray-700">Kikoni, Kampala Region</p>
                <p class="text-gray-700">+256 785703092</p>
                <a href="#" class="text-blue-600 hover:underline mt-2 inline-block">Edit Address</a>
            </div>
        </section>

        <!-- Account Settings -->
        <section class="bg-white p-6 rounded-2xl shadow-lg">
            <h2 class="text-xl font-bold mb-4 text-gray-800">Account Settings</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <a href="#" class="bg-gray-50 hover:bg-gray-100 p-6 rounded-xl border border-gray-100 transition flex flex-col items-center justify-center text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-red-600 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    <h3 class="font-bold text-base mb-1">Change Password</h3>
                    <p class="text-gray-600 text-xs">Update your password regularly for better security</p>
                </a>
                <a href="#" class="bg-gray-50 hover:bg-gray-100 p-6 rounded-xl border border-gray-100 transition flex flex-col items-center justify-center text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-red-600 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <h3 class="font-bold text-base mb-1">Delete Account</h3>
                    <p class="text-gray-600 text-xs">Permanently remove your account and data</p>
                </a>
            </div>
        </section>
    </main>
</div>