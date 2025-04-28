@extends('layouts.app')

@section('title', 'Register - Mukora Supermarket')

@section('styles')
<style>
    body {
        background-color: #f8f9fa;
        font-family: 'Poppins', sans-serif;
    }
    
    .register-section {
        padding: 60px 0;
        min-height: calc(100vh - 200px);
        display: flex;
        align-items: center;
    }
    
    .register-container {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        padding: 40px;
        margin-bottom: 30px;
    }
    
    .register-header {
        text-align: center;
        margin-bottom: 30px;
    }
    
    .register-logo {
        max-width: 150px;
        margin-bottom: 20px;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
        display: block;
    }
    
    .form-control {
        height: 50px;
        border-radius: 5px;
        border: 1px solid #ddd;
        padding: 10px 15px;
        font-size: 16px;
        transition: all 0.3s ease;
    }
    
    .form-control:focus {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }
    
    .btn-register {
        background-color: #dc3545;
        border: none;
        border-radius: 5px;
        color: white;
        font-size: 16px;
        font-weight: 600;
        height: 50px;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s ease;
        padding: 0 30px;
    }
    
    .btn-register:hover {
        background-color: #c82333;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(220, 53, 69, 0.4);
    }
    
    .login-link {
        color: #dc3545;
        text-decoration: none;
        font-size: 15px;
        transition: color 0.3s ease;
    }
    
    .login-link:hover {
        color: #c82333;
        text-decoration: underline;
    }
    
    .error-message {
        color: #dc3545;
        font-size: 14px;
        margin-top: 5px;
    }
    
    .action-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 25px;
    }
    
    @media (max-width: 576px) {
        .action-row {
            flex-direction: column;
            gap: 20px;
        }
        
        .btn-register {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')
<section class="register-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="register-container">
                    <div class="register-header">
                        <img src="\uploads\images\mukora-logo.png" alt="Mukora Supermarket Logo" class="register-logo">
                        <h2>Create Your Account</h2>
                        <p class="text-muted">Join Mukora Supermarket to enjoy exclusive offers and easy shopping</p>
                    </div>
                    
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        
                        <!-- Name -->
                        <div class="form-group">
                            <label for="name" class="form-label">Full Name</label>
                            <input id="name" class="form-control @error('name') is-invalid @enderror" 
                                   type="text" name="name" value="{{ old('name') }}" 
                                   required autofocus autocomplete="name">
                            @error('name')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Email Address -->
                        <div class="form-group">
                            <label for="email" class="form-label">Email Address</label>
                            <input id="email" class="form-control @error('email') is-invalid @enderror" 
                                   type="email" name="email" value="{{ old('email') }}" 
                                   required autocomplete="username">
                            @error('email')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Password -->
                        <div class="form-group">
                            <label for="password" class="form-label">Password</label>
                            <input id="password" class="form-control @error('password') is-invalid @enderror"
                                   type="password" name="password" required autocomplete="new-password">
                            @error('password')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Confirm Password -->
                        <div class="form-group">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror"
                                   type="password" name="password_confirmation" required autocomplete="new-password">
                            @error('password_confirmation')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="action-row">
                            <a class="login-link" href="{{ route('login') }}">
                                Already have an account? Login
                            </a>
                            
                            <button type="submit" class="btn btn-register">
                                Register
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
@include('partials.footer')
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
@endsection