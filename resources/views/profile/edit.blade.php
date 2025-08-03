@extends('layouts.app')
@section('title', 'Profile – ArtConnect')
@section('content')
<style>
    .btn-success {
        background-color: #388e3c;
        border: none;
        transition: all 0.3s ease;
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 600;
    }
    .btn-success:hover {
        background-color: #2e7031;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(56, 142, 60, 0.3);
    }
    .btn-danger {
        background-color: #dc3545;
        border: none;
        transition: all 0.3s ease;
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 600;
    }
    .btn-danger:hover {
        background-color: #c82333;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
    }
    .btn-primary {
        background-color: #388e3c;
        border: none;
        transition: all 0.3s ease;
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 600;
    }
    .btn-primary:hover {
        background-color: #2e7031;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(56, 142, 60, 0.3);
    }
    .btn-secondary {
        background-color: #6c757d;
        border: none;
        transition: all 0.3s ease;
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 600;
    }
    .btn-secondary:hover {
        background-color: #5a6268;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(108, 117, 125, 0.3);
    }
    .profile-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }
    .profile-card:hover {
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        transform: translateY(-2px);
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            @if(auth()->user()->role === 'artist')
                <div class="mb-4 text-end">
                    <a href="{{ route('artworks.create') }}" class="btn btn-success">
                        <i class="fas fa-upload me-2"></i>Upload Artwork
                    </a>
                </div>
            @endif
            
            <div class="profile-card p-4 mb-4">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="profile-card p-4 mb-4">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="profile-card p-4">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
