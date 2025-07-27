<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forgot Password – ArtConnect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #e8f5e9 0%, #a5d6a7 100%);
            font-family: 'Nunito', sans-serif;
        }
        .forgot-header {
            background: linear-gradient(135deg, #66bb6a 0%, #388e3c 100%);
            color: #fff;
            border-radius: 1rem 1rem 0 0;
            padding: 2rem 1rem 1rem 1rem;
            text-align: center;
        }
        .card {
            border-radius: 1rem;
            box-shadow: 0 4px 24px rgba(56, 142, 60, 0.08);
        }
        .form-label {
            color: #388e3c;
            font-weight: 600;
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
</head>
<body>
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="col-md-6 col-lg-5">
            <div class="card">
                <div class="forgot-header">
                    <h2 class="fw-bold mb-0">Forgot Password</h2>
                    <p class="mb-0">Reset your password</p>
                </div>
                <div class="card-body p-4">
                    <div class="mb-4 text-muted">
                        Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
                    </div>
                    @if (session('status'))
                        <div class="alert alert-success mb-4">{{ session('status') }}</div>
                    @endif
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <!-- Email Address -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <a href="{{ route('login') }}" class="small">Back to Login</a>
                            <button type="submit" class="btn btn-success px-4">Email Password Reset Link</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
