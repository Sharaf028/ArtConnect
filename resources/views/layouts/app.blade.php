<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'ArtConnect')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background: linear-gradient(135deg, #e8f5e9 0%, #a5d6a7 100%);
            font-family: 'Nunito', sans-serif;
        }
        .navbar {
            background-color: #388e3c !important;
        }
        .navbar-brand, .nav-link, .navbar-text {
            color: #fff !important;
        }
        .navbar-brand {
            font-weight: bold;
            letter-spacing: 1px;
        }
        .btn-success {
            background-color: #388e3c;
            border: none;
        }
        .btn-success:hover {
            background-color: #2e7031;
        }
        a {
            color: #388e3c;
        }
        a:hover {
            color: #2e7031;
        }
    </style>
    @stack('styles')
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark shadow">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ url('/') }}"><i class="fas fa-palette"></i></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                @auth
                    <li class="nav-item"><a class="nav-link" href="{{ url('/profile') }}" title="Profile"><i class="fas fa-user me-1"></i>Profile</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/gallery') }}" title="Browse"><i class="fas fa-images me-1"></i>Browse</a></li>
                    @if(auth()->user()->role === 'client')
                        <li class="nav-item"><a class="nav-link" href="{{ route('artists.index') }}" title="Artists"><i class="fas fa-palette me-1"></i>Artists</a></li>
                    @endif
                    <li class="nav-item"><a class="nav-link" href="{{ route('commissions.index') }}" title="My Commissions"><i class="fas fa-handshake me-1"></i>{{ auth()->user()->role === 'artist' ? 'My Commissions' : 'My Requests' }}</a></li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link p-0" style="vertical-align: middle;" title="Logout"><i class="fas fa-sign-out-alt me-1"></i>Logout</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}" title="Login"><i class="fas fa-sign-in-alt me-1"></i>Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}" title="Register"><i class="fas fa-user-plus me-1"></i>Register</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
<div class="container py-5">
    @yield('content')
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
