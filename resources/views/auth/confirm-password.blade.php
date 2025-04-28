@extends('layouts.app')

@section('title', 'Confirm Password - Mukora Supermarket')

@section('styles')
<style>
    body {
        background-color: #f8f9fa;
        font-family: 'Poppins', sans-serif;
    }
    
    .confirm-section {
        padding: 80px 0;
        min-height: calc(100vh - 200px);
        display: flex;
        align-items: center;
    }
    
    .confirm-container {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        padding: 40px;
    }
    
    .confirm-header {
        text-align: center;
        margin-bottom: 30px;
    }
    
    .confirm-logo {
        max-width: 150px;
        margin-bottom: 20px;
    }
    
    .security-message {
        font-size: 16px;
        line-height: 1.6;
        color: #666;
        margin-bottom: 25px;
        text-align: center;
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 5px;
        border-left: 4px solid #dc3545;
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
    
    .btn-confirm {
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
    
    .btn-confirm:hover {
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
        justify-content: flex-end;
        margin-top: 30px;
    }
    
    .security-icon {
        color: #dc3545;
        font-size: 2rem;
        margin-bottom: 15px;
    }
</style>
@endsection

@section('content')
<section class="confirm-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="confirm-container">
                    <div class="confirm-header">
                        <img src="\uploads\images\mukora-logo.png" alt="Mukora Supermarket Logo" class="confirm-logo">
                        <h2>Security Verification</h2>
                        <div class="text-center">
                            <i class="fas fa-shield-alt security-icon"></i>
                        </div>
                    </div>
                    
                    <div class="security-message">
                        This is a secure area of the application. Please confirm your password before continuing.
                    </div>
                    
                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf
                        
                        <!-- Password -->
                        <div class="form-group">
                            <label for="password" class="form-label">Password</label>
                            <input id="password" class="form-control @error('password') is-invalid @enderror"
                                   type="password" name="password" required autocomplete="current-password">
                            @error('password')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="action-row">
                            <button type="submit" class="btn btn-confirm">
                                Confirm
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