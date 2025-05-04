@extends('layouts.app')

@section('title', 'Forgot Password - Mukora Supermarket')

@section('styles')
<style>
    body {
        background-color: #f8f9fa;
        font-family: 'Poppins', sans-serif;
    }
    
    .forgot-section {
        padding: 80px 0;
        min-height: calc(100vh - 200px);
        display: flex;
        align-items: center;
    }
    
    .forgot-container {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        padding: 40px;
    }
    
    .forgot-header {
        text-align: center;
        margin-bottom: 30px;
    }
    
    .forgot-logo {
        max-width: 150px;
        margin-bottom: 20px;
    }
    
    .instruction-text {
        font-size: 16px;
        line-height: 1.6;
        color: #666;
        margin-bottom: 25px;
        text-align: center;
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
    
    .btn-submit {
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
    
    .btn-submit:hover {
        background-color: #c82333;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(220, 53, 69, 0.4);
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
        margin-top: 30px;
    }
    
    .back-to-login {
        color: #dc3545;
        text-decoration: none;
        font-size: 15px;
        transition: color 0.3s ease;
    }
    
    .back-to-login:hover {
        color: #c82333;
        text-decoration: underline;
    }
    
    .status-message {
        background-color: #e8f4f8;
        color: #0c5460;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
        text-align: center;
    }
</style>
@endsection

@section('content')
<section class="forgot-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="forgot-container">
                    <div class="forgot-header">
                        <img src="\uploads\images\mukora-logo.png" alt="Mukora Supermarket Logo" class="forgot-logo">
                        <h2>Forgot Password</h2>
                    </div>
                    
                    <p class="instruction-text">
                        Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
                    </p>
                    
                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="status-message">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        
                        <!-- Email Address -->
                        <div class="form-group">
                            <label for="email" class="form-label">Email Address</label>
                            <input id="email" class="form-control @error('email') is-invalid @enderror" 
                                   type="email" name="email" value="{{ old('email') }}" 
                                   required autofocus>
                            @error('email')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="action-row">
                            <a href="{{ route('login') }}" class="back-to-login">
                                <i class="fas fa-arrow-left mr-1"></i> Back to login
                            </a>
                            
                            <button type="submit" class="btn btn-submit">
                                <a href="{{ route('password.email') }}">
                                    Send Reset Link
                                </a>
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