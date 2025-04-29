@extends('layouts.app')

@section('title', 'My Profile - Dashboard')

@section('styles')
<!-- Including styles like in feedback page -->
<link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style>
    .profile-header {
        background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('/uploads/images/profile-bg.jpg');
        background-size: cover;
        background-position: center;
        height: 30vh;
    }
    
    .profile-card {
        transition: all 0.3s ease;
    }
    
    .profile-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    
    .action-button {
        transition: all 0.3s ease;
    }
    
    .action-button:hover {
        transform: scale(1.05);
    }
    
    .pulse-button {
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.7); }
        70% { box-shadow: 0 0 0 10px rgba(59, 130, 246, 0); }
        100% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0); }
    }
    
    /* Fade in animation */
    .fade-in {
        animation: fadeIn 0.8s ease-in forwards;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection

@include('partials.header')

@section('content')
<!-- Hero Section -->
<section class="profile-header flex items-center justify-center">
    <div class="container mx-auto text-center px-4">
        <h1 class="text-4xl md:text-5xl font-bold mb-4 text-white animate__animated animate__fadeInDown">My Profile Dashboard</h1>
        <p class="text-xl mb-6 text-white animate__animated animate__fadeInUp animate__delay-1s">Manage your account information and preferences</p>
    </div>
</section>

<div class="container mx-auto px-4 py-16">
    <!-- Profile Information -->
    <div class="profile-card bg-white shadow-lg rounded-2xl p-8 mb-8 animate__animated animate__fadeInUp">
        <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-3xl font-bold mb-2">Profile Information</h2>
                <div class="w-20 h-1 bg-blue-600 mb-4"></div>
            </div>
            <a href="{{ route('user.edit') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-full transition action-button pulse-button mt-4 md:mt-0 text-center">
                Edit Profile
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-gray-700">
            <div class="space-y-4">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <p class="font-medium text-gray-600">Name</p>
                    <p class="text-xl">{{ $user->name }}</p>
                </div>
                
                <div class="bg-blue-50 p-4 rounded-lg">
                    <p class="font-medium text-gray-600">Email</p>
                    <p class="text-xl">{{ $user->email }}</p>
                </div>
            </div>
            
            <div class="space-y-4">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <p class="font-medium text-gray-600">Email Verified</p>
                    <div class="flex items-center mt-1">
                        @if($user->email_verified_at)
                            <div class="flex items-center bg-green-100 text-green-800 px-3 py-1 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Verified</span>
                            </div>
                        @else
                            <div class="flex items-center bg-red-100 text-red-800 px-3 py-1 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                <span>Not Verified</span>
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="bg-blue-50 p-4 rounded-lg">
                    <p class="font-medium text-gray-600">Member Since</p>
                    <p class="text-xl">{{ $user->created_at->format('M d, Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Methods -->
    <div class="profile-card bg-white shadow-lg rounded-2xl p-8 mb-8 animate__animated animate__fadeInUp animate__delay-1s">
        <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-3xl font-bold mb-2">Payment Methods</h2>
                <div class="w-20 h-1 bg-blue-600 mb-4"></div>
            </div>
            <button onclick="toggleSection('paymentMethodsSection')" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-3 px-6 rounded-full transition action-button mt-4 md:mt-0">
                <span id="paymentToggleText">Hide Section</span>
            </button>
        </div>
        <div id="paymentMethodsSection" class="text-gray-700">
            <div class="bg-gray-50 p-6 rounded-xl border border-dashed border-gray-300">
                <div class="flex flex-col items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                    <p class="text-lg font-medium mb-2">No payment methods available</p>
                    <p class="text-gray-500 text-center">This feature will be available once payment methods are implemented.</p>
                    <button class="mt-6 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-full transition action-button">
                        Add Payment Method
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders -->
    <div class="profile-card bg-white shadow-lg rounded-2xl p-8 mb-8 animate__animated animate__fadeInUp animate__delay-2s">
        <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-3xl font-bold mb-2">My Orders</h2>
                <div class="w-20 h-1 bg-blue-600 mb-4"></div>
            </div>
            <button onclick="toggleSection('ordersSection')" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-3 px-6 rounded-full transition action-button mt-4 md:mt-0">
                <span id="ordersToggleText">Hide Section</span>
            </button>
        </div>
        <div id="ordersSection" class="text-gray-700">
            <div class="bg-gray-50 p-6 rounded-xl border border-dashed border-gray-300">
                <div class="flex flex-col items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <p class="text-lg font-medium mb-2">No orders available</p>
                    <p class="text-gray-500 text-center">This feature will be available once orders are implemented.</p>
                    <button class="mt-6 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-full transition action-button">
                        Browse Products
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Account Settings -->
    <div class="profile-card bg-white shadow-lg rounded-2xl p-8 animate__animated animate__fadeInUp animate__delay-3s">
        <div class="mb-6">
            <h2 class="text-3xl font-bold mb-2">Account Settings</h2>
            <div class="w-20 h-1 bg-blue-600 mb-4"></div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="#" class="bg-blue-50 hover:bg-blue-100 p-6 rounded-xl border border-blue-100 transition flex flex-col items-center justify-center text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-blue-600 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                <h3 class="font-bold text-lg mb-1">Change Password</h3>
                <p class="text-gray-600 text-sm">Update your password regularly for better security</p>
            </a>
            
            <a href="#" class="bg-blue-50 hover:bg-blue-100 p-6 rounded-xl border border-blue-100 transition flex flex-col items-center justify-center text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-blue-600 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <h3 class="font-bold text-lg mb-1">Manage Addresses</h3>
                <p class="text-gray-600 text-sm">Add or edit your delivery addresses</p>
            </a>
            
            <form action="{{ route('logout') }}" method="POST" class="w-full">
                @csrf
                <button type="submit" class="w-full h-full bg-red-50 hover:bg-red-100 p-6 rounded-xl border border-red-100 transition flex flex-col items-center justify-center text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-red-600 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <h3 class="font-bold text-lg mb-1">Logout</h3>
                    <p class="text-gray-600 text-sm">Sign out from your account</p>
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Script for toggle functionality -->
<script>
function toggleSection(id) {
    const section = document.getElementById(id);
    section.classList.toggle('hidden');
    
    // Update toggle button text
    if (id === 'paymentMethodsSection') {
        const toggleText = document.getElementById('paymentToggleText');
        toggleText.textContent = section.classList.contains('hidden') ? 'Show Section' : 'Hide Section';
    } else if (id === 'ordersSection') {
        const toggleText = document.getElementById('ordersToggleText');
        toggleText.textContent = section.classList.contains('hidden') ? 'Show Section' : 'Hide Section';
    }
}
</script>
@endsection