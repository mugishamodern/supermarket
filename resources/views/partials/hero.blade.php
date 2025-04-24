<!-- resources/views/partials/_hero.blade.php -->
<section class="welcome-hero">
    <div class="container">
        <div class="logo-container animation-float">
            <img src="\uploads\images\mukora-logo.png" alt="Mukora Supermarket Logo" class="logo">
        </div>
        <h1 class="welcome-title">Welcome to Mukora Supermarket</h1>
        <p class="welcome-subtitle">Kasese's premier shopping destination for quality goods and exceptional service</p>
        <a href="{{ route('home') }}" class="btn btn-danger btn-lg enter-btn">Enter Store</a>
    </div>
</section>

<style>
    .welcome-hero {
        background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('/images/supermarket-entrance.jpg');
        background-size: cover;
        background-position: center;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-align: center;
    }
    
    .logo-container {
        margin-bottom: 30px;
    }
    
    .logo {
        max-width: 200px;
        filter: drop-shadow(0 5px 15px rgba(0,0,0,0.2));
    }
    
    .welcome-title {
        font-size: 3.5rem;
        font-weight: 700;
        margin-bottom: 20px;
        text-shadow: 2px 2px 8px rgba(0,0,0,0.5);
    }
    
    .welcome-subtitle {
        font-size: 1.5rem;
        margin-bottom: 40px;
        text-shadow: 1px 1px 4px rgba(0,0,0,0.5);
    }
    
    .enter-btn {
        font-size: 1.2rem;
        padding: 12px 40px;
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 1px;
        box-shadow: 0 5px 15px rgba(220, 53, 69, 0.4);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .enter-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(220, 53, 69, 0.6);
    }
    
    .animation-float {
        animation: float 6s ease-in-out infinite;
    }
    
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
        100% { transform: translateY(0px); }
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .welcome-title {
            font-size: 2.5rem;
        }
        
        .welcome-subtitle {
            font-size: 1.2rem;
        }
    }
</style>