@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-10">
    <h1 class="text-4xl font-bold mb-8 text-center text-gray-800">My Profile Dashboard</h1>

    <!-- Profile Information -->
    <div class="bg-white shadow-lg rounded-2xl p-8 mb-8 transition-transform hover:scale-105">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-semibold text-gray-700">Profile Information</h2>
            <a href="{{ route('user.edit') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg transition">
                Edit Profile
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-600">
            <div class="space-y-2">
                <p><strong>Name:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Email Verified:</strong> 
                    <span class="inline-block px-2 py-1 rounded-full text-xs 
                        {{ $user->email_verified_at ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $user->email_verified_at ? 'Yes' : 'No' }}
                    </span>
                </p>
                <p><strong>Joined:</strong> {{ $user->created_at->format('M d, Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Payment Methods -->
    <div class="bg-white shadow-lg rounded-2xl p-8 mb-8 transition-transform hover:scale-105">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-semibold text-gray-700">Payment Methods</h2>
            <button onclick="toggleSection('paymentMethodsSection')" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-2 px-4 rounded-lg transition">
                Toggle
            </button>
        </div>
        <div id="paymentMethodsSection" class="text-gray-600">
            <p>No payment methods available.</p>
            <p class="text-gray-400 text-sm mt-2">This feature will be available once payment methods are implemented.</p>
        </div>
    </div>

    <!-- Orders -->
    <div class="bg-white shadow-lg rounded-2xl p-8 mb-8 transition-transform hover:scale-105">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-semibold text-gray-700">My Orders</h2>
            <button onclick="toggleSection('ordersSection')" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-2 px-4 rounded-lg transition">
                Toggle
            </button>
        </div>
        <div id="ordersSection" class="text-gray-600">
            <p>No orders available.</p>
            <p class="text-gray-400 text-sm mt-2">This feature will be available once orders are implemented.</p>
        </div>
    </div>

    <!-- Account Settings -->
    <div class="bg-white shadow-lg rounded-2xl p-8 transition-transform hover:scale-105">
        <h2 class="text-2xl font-semibold text-gray-700 mb-6">Account Settings</h2>
        <ul class="space-y-4 text-gray-600">
            <li>
                <a href="#" class="block bg-blue-100 hover:bg-blue-200 text-blue-700 font-semibold py-2 px-4 rounded-lg transition">Change Password</a>
            </li>
            <li>
                <a href="#" class="block bg-blue-100 hover:bg-blue-200 text-blue-700 font-semibold py-2 px-4 rounded-lg transition">Manage Addresses</a>
            </li>
            <li>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="block bg-red-100 hover:bg-red-200 text-red-700 font-semibold py-2 px-4 rounded-lg transition">
                        Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>
</div>

<!-- Simple JavaScript for toggle -->
<script>
function toggleSection(id) {
    const section = document.getElementById(id);
    section.classList.toggle('hidden');
}
</script>
@endsection
