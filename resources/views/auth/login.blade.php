@extends('layouts.app')

@section('title', 'Login - Mukora Supermarket')

@section('styles')
<style>
    body {
        background-color: #f8f9fa;
        font-family: 'Poppins', sans-serif;
    }
    
    .login-section {
        padding: 80px 0;
        min-height: calc(100vh - 200px);
        display: flex;
        align-items: center;
    }
    
    .login-container {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        padding: 40px;
    }
    
    .login-header {
        text-align: center;
        margin-bottom: 30px;
    }
    
    .login-logo {
        max-width: 150px;
        margin-bottom: 20px;
    }
    
    .form-group {
        margin-bottom: 25px;
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
    
    .btn-login {
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
        width: 100%;
        margin-top: 10px;
    }
    
    .btn-login:hover {
        background-color: #c82333;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(220, 53, 69, 0.4);
    }
    
    .remember-forgot {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    
    .forgot-link {
        color: #dc3545;
        text-decoration: none;
        font-size: 14px;
        transition: color 0.3s ease;
    }
    
    .forgot-link:hover {
        color: #c82333;
        text-decoration: underline;
    }
    
    .remember-me {
        display: flex;
        align-items: center;
    }
    
    .remember-me input {
        margin-right: 8px;
    }
    
    .error-message {
        color: #dc3545;
        font-size: 14px;
        margin-top: 5px;
    }
    
    .register-link {
        text-align: center;
        margin-top: 25px;
        font-size: 15px;
    }
    
    .register-link a {
        color: #dc3545;
        font-weight: 600;
        transition: color 0.3s ease;
    }
    
    .register-link a:hover {
        color: #c82333;
        text-decoration: underline;
    }
</style>
@endsection

@section('content')
<section class="login-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="login-container">
                    <div class="login-header">
                        <img src="\uploads\images\mukora-logo.png" alt="Mukora Supermarket Logo" class="login-logo">
                        <h2>Customer Login</h2>
                        <p class="text-muted">Sign in to your account</p>
                    </div>
                    
                    <x-auth-session-status class="alert alert-info" :status="session('status')" />
                    
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        
                        <!-- Email Address -->
                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <input id="email" class="form-control @error('email') is-invalid @enderror" 
                                   type="email" name="email" value="{{ old('email') }}" 
                                   required autofocus autocomplete="username">
                            @error('email')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Password -->
                        <div class="form-group">
                            <label for="password" class="form-label">Password</label>
                            <input id="password" class="form-control @error('password') is-invalid @enderror"
                                   type="password" name="password" required autocomplete="current-password">
                            @error('password')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Remember Me and Forgot Password -->
                        <div class="remember-forgot">
                            <div class="remember-me">
                                <input id="remember_me" type="checkbox" name="remember">
                                <label for="remember_me">Remember me</label>
                            </div>
                            
                            @if (Route::has('password.request'))
                                <a class="forgot-link" href="{{ route('password.request') }}">
                                    Forgot password?
                                </a>
                            @endif
                        </div>
                        
                        <button type="submit" class="btn btn-login">
                            Log In
                        </button>
                        
                        <div class="register-link">
                            Don't have an account? 
                            <a href="{{ route('register') }}">Register here</a>
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