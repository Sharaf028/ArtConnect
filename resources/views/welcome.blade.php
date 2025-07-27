<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ArtConnect – A Community Platform for Artists</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background: linear-gradient(135deg, #e8f5e9 0%, #a5d6a7 100%);
        }
        .navbar {
            background-color: #388e3c !important;
            animation: slideDown 0.8s ease-out;
        }
        .navbar-brand, .nav-link, .navbar-text {
            color: #fff !important;
        }
        .hero {
            background: linear-gradient(135deg, #66bb6a 0%, #388e3c 100%);
            color: #fff;
            padding: 100px 0 80px 0;
            text-align: center;
            animation: fadeInUp 1s ease-out;
            position: relative;
            overflow: hidden;
        }
        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            animation: float 20s ease-in-out infinite;
        }
        .hero .container {
            position: relative;
            z-index: 2;
        }
        .section {
            padding: 80px 0;
            animation: fadeInUp 1s ease-out;
            position: relative;
        }
        .section-title {
            color: #388e3c;
            font-weight: bold;
            animation: fadeInUp 1.2s ease-out;
            position: relative;
            margin-bottom: 3rem;
        }
        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, #66bb6a, #388e3c);
            border-radius: 2px;
        }
        .feature-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            border: none;
            position: relative;
            overflow: hidden;
        }
        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #66bb6a, #388e3c);
        }
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }
        .feature-icon {
            font-size: 3rem;
            color: #43a047;
            animation: bounceIn 1s ease-out;
            margin-bottom: 1rem;
            display: block;
        }
        .stats-section {
            background: linear-gradient(135deg, #388e3c 0%, #2e7031 100%);
            color: white;
            padding: 60px 0;
        }
        .stat-item {
            text-align: center;
            padding: 2rem;
        }
        .stat-number {
            font-size: 3rem;
            font-weight: bold;
            color: #a5d6a7;
            display: block;
        }
        .stat-label {
            font-size: 1.1rem;
            opacity: 0.9;
        }
        .how-it-works-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 1rem;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            border-left: 4px solid #388e3c;
        }
        .how-it-works-card:hover {
            transform: translateX(10px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
        .step-number {
            background: #388e3c;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-bottom: 1rem;
        }
        .gallery-preview {
            background: white;
            border-radius: 20px;
            padding: 3rem;
            box-shadow: 0 15px 40px rgba(0,0,0,0.1);
            text-align: center;
        }
        .btn {
            transition: all 0.3s ease;
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: 600;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        .btn-success {
            background: linear-gradient(45deg, #388e3c, #66bb6a);
            border: none;
        }
        .btn-outline-success {
            border: 2px solid #388e3c;
            color: #388e3c;
        }
        .btn-outline-success:hover {
            background: #388e3c;
            color: white;
        }
        
        /* Animations */
        @keyframes slideDown {
            from {
                transform: translateY(-100%);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        
        @keyframes fadeInUp {
            from {
                transform: translateY(30px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        
        @keyframes bounceIn {
            0% {
                transform: scale(0.3);
                opacity: 0;
            }
            50% {
                transform: scale(1.05);
            }
            70% {
                transform: scale(0.9);
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        /* Stagger animations */
        .feature-card:nth-child(1) { animation-delay: 0.1s; }
        .feature-card:nth-child(2) { animation-delay: 0.2s; }
        .feature-card:nth-child(3) { animation-delay: 0.3s; }
        .feature-card:nth-child(4) { animation-delay: 0.4s; }
        
        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark fixed-top shadow">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#"><i class="fas fa-palette me-2"></i>ArtConnect</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                @auth
                    <li class="nav-item"><a class="nav-link" href="{{ url('/profile') }}"><i class="fas fa-user me-1"></i>Profile</a></li>
                    <li class="nav-item"><a class="nav-link" href="#gallery"><i class="fas fa-images me-1"></i>Browse</a></li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-link nav-link" style="display:inline; padding:0;"><i class="fas fa-sign-out-alt me-1"></i>Logout</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}"><i class="fas fa-sign-in-alt me-1"></i>Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}"><i class="fas fa-user-plus me-1"></i>Register</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<div class="hero">
    <div class="container">
        <h1 class="display-3 fw-bold mb-4"><i class="fas fa-palette me-3"></i>Welcome to ArtConnect</h1>
        <p class="lead fs-4 mb-4">A Community Platform for Artists to Support, Share, and Grow</p>
        <p class="fs-5 mb-5">Share your work, get feedback, collaborate, and connect with clients or fellow artists.</p>
        @guest
            <a href="{{ route('register') }}" class="btn btn-light btn-lg px-5 py-3"><i class="fas fa-rocket me-2"></i>Get Started</a>
        @endguest
    </div>
</div>

<div class="section bg-white" id="about">
    <div class="container">
        <h2 class="section-title text-center">About ArtConnect</h2>
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="feature-card">
                    <i class="fas fa-lightbulb feature-icon"></i>
                    <p class="fs-5">Many talented artists, especially students and freelancers, struggle with marketing, exposure, and collaboration. ArtConnect is a platform where artists can share their work, get feedback, collaborate, and connect with clients for new opportunities.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="stats-section">
    <div class="container">
        <div class="row">
            <div class="col-md-3 stat-item">
                <span class="stat-number">500+</span>
                <div class="stat-label">Artists</div>
            </div>
            <div class="col-md-3 stat-item">
                <span class="stat-number">1000+</span>
                <div class="stat-label">Artworks</div>
            </div>
            <div class="col-md-3 stat-item">
                <span class="stat-number">200+</span>
                <div class="stat-label">Projects</div>
            </div>
            <div class="col-md-3 stat-item">
                <span class="stat-number">50+</span>
                <div class="stat-label">Clients</div>
            </div>
        </div>
    </div>
</div>

<div class="section" id="features" style="background: #e8f5e9;">
    <div class="container">
        <h2 class="section-title text-center">Features</h2>
        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="feature-card">
                    <i class="fas fa-paint-brush feature-icon"></i>
                    <h5 class="fw-bold">Share Artworks</h5>
                    <p>Upload and showcase your creations with the community. Get exposure and recognition for your talent.</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="feature-card">
                    <i class="fas fa-hands-helping feature-icon"></i>
                    <h5 class="fw-bold">Collaborate</h5>
                    <p>Connect and work with other artists on exciting projects. Build meaningful partnerships.</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="feature-card">
                    <i class="fas fa-comments feature-icon"></i>
                    <h5 class="fw-bold">Get Feedback</h5>
                    <p>Receive constructive feedback from peers and grow your skills. Learn from the community.</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="feature-card">
                    <i class="fas fa-briefcase feature-icon"></i>
                    <h5 class="fw-bold">Hire & Get Hired</h5>
                    <p>Clients can discover and hire talented artists for their projects. Find new opportunities.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="section bg-white" id="how-it-works">
    <div class="container">
        <h2 class="section-title text-center">How It Works</h2>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="how-it-works-card">
                    <div class="step-number">1</div>
                    <h5 class="fw-bold">Register as an Artist or Client</h5>
                    <p class="mb-0">Choose your role and create your profile to get started.</p>
                </div>
                <div class="how-it-works-card">
                    <div class="step-number">2</div>
                    <h5 class="fw-bold">Artists Upload Artworks</h5>
                    <p class="mb-0">Share your creations with details, images, and descriptions.</p>
                </div>
                <div class="how-it-works-card">
                    <div class="step-number">3</div>
                    <h5 class="fw-bold">Browse and Discover</h5>
                    <p class="mb-0">Explore amazing art from talented artists around the world.</p>
                </div>
                <div class="how-it-works-card">
                    <div class="step-number">4</div>
                    <h5 class="fw-bold">Connect and Grow</h5>
                    <p class="mb-0">Build relationships, collaborate, and grow your artistic career.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="section" id="gallery" style="background: #e8f5e9;">
    <div class="container">
        <div class="gallery-preview">
            <h2 class="section-title mb-4">Gallery Preview</h2>
            <p class="fs-5 text-muted mb-4">Discover amazing artworks from our talented community</p>
            <a href="{{ route('gallery') }}" class="btn btn-outline-success btn-lg"><i class="fas fa-images me-2"></i>Explore Gallery</a>
        </div>
    </div>
</div>

<footer class="py-4 text-center" style="background: #388e3c; color: #fff;">
    <div class="container">
        <small>&copy; {{ date('Y') }} ArtConnect. All rights reserved.</small>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
