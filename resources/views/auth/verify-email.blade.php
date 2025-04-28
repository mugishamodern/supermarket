@extends('layouts.app')

@section('title', 'Verify Email - Mukora Supermarket')

@section('styles')
<style>
    body {
        background-color: #f8f9fa;
        font-family: 'Poppins', sans-serif;
    }
    
    .verify-section {
        padding: 80px 0;
        min-height: calc(100vh - 200px);
        display: flex;
        align-items: center;
    }
    
    .verify-container {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        padding: 40px;
    }
    
    .verify-header {
        text-align: center;
        margin-bottom: 30px;
    }
    
    .verify-logo {
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
    
    .mail-icon {
        font-size: 3rem;
        color: #dc3545;
        margin: 15px 0;
    }
    
    .success-message {
        background-color: #d4edda;
        color: #155724;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 25px;
        text-align: center;
        border-left: 4px solid #28a745;
    }
    
    .btn-resend {
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
    
    .btn-resend:hover {
        background-color: #c82333;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(220, 53, 69, 0.4);
    }
    
    .btn-logout {
        background-color: transparent;
        border: 1px solid #6c757d;
        border-radius: 5px;
        color: #6c757d;
        font-size: 14px;
        font-weight: 600;
        height: 50px;
        transition: all 0.3s ease;
        padding: 0 25px;
    }
    
    .btn-logout:hover {
        background-color: #f8f9fa;
        color: #5a6268;
    }
    
    .action-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 30px;
    }
    
    @media (max-width: 576px) {
        .action-row {
            flex-direction: column;
            gap: 15px;
        }
        
        .btn-resend, .btn-logout {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')
<section class="verify-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="verify-container">
                    <div class="verify-header">
                        <img src="\uploads\images\mukora-logo.png" alt="Mukora Supermarket Logo" class="verify-logo">
                        <h2>Verify Your Email</h2>
                        <div class="text-center">
                            <i class="fas fa-envelope mail-icon"></i>
                        </div>
                    </div>
                    
                    <p class="instruction-text">
                        Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.
                    </p>
                    
                    @if (session('status') == 'verification-link-sent')
                        <div class="success-message">
                            A new verification link has been sent to the email address you provided during registration.
                        </div>
                    @endif
                    
                    <div class="action-row">
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit" class="btn btn-resend">
                                Resend Verification Email
                            </button>
                        </form>
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-logout">
                                Log Out
                            </button>
                        </form>
                    </div>
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