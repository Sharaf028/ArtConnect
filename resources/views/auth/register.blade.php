<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register – ArtConnect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #e8f5e9 0%, #a5d6a7 100%);
            font-family: 'Nunito', sans-serif;
        }
        .register-header {
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
                <div class="register-header">
                    <h2 class="fw-bold mb-0">Join ArtConnect</h2>
                    <p class="mb-0">Create your free account</p>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input id="name" type="text" name="name" class="form-control" value="{{ old('name') }}" required autofocus autocomplete="name">
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <!-- Email Address -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" required autocomplete="username">
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input id="password" type="password" name="password" class="form-control" required autocomplete="new-password">
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                        <!-- Confirm Password -->
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" required autocomplete="new-password">
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>
                        <!-- Role Selection -->
                        <div class="mb-3">
                            <label for="role" class="form-label">Register as</label>
                            <select id="role" name="role" class="form-select" required>
                                <option value="artist" {{ old('role') == 'artist' ? 'selected' : '' }}>Artist</option>
                                <option value="client" {{ old('role') == 'client' ? 'selected' : '' }}>Client</option>
                            </select>
                            <x-input-error :messages="$errors->get('role')" class="mt-2" />
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <a href="{{ route('login') }}" class="small">Already registered?</a>
                            <button type="submit" class="btn btn-success px-4">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
