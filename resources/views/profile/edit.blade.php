@extends('layouts.app')

@section('styles')
<link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
@endsection

@include('partials.header')

@section('title', 'Edit Profile - Mukora Supermarket')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Edit Profile</h1>
        <a href="{{ route('user.profile') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-2 px-4 rounded-lg transition">Back to Profile</a>
    </div>
    <div class="space-y-8">
        <div class="bg-white shadow rounded-2xl p-6">
            @include('profile.partials.update-profile-information-form')
        </div>
        <div class="bg-white shadow rounded-2xl p-6">
            @include('profile.partials.update-password-form')
        </div>
        <div class="bg-white shadow rounded-2xl p-6">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</div>
@endsection
