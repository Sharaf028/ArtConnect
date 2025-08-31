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
    .profile-header {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
        border-radius: 15px 15px 0 0;
        padding: 2rem;
        text-align: center;
    }
    .profile-picture {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid white;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        display: block;
        margin: 0 auto;
    }

    .artwork-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 2rem;
        margin-top: 1rem;
    }
    .artwork-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        cursor: pointer;
    }
    .artwork-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    .artwork-card .btn {
        opacity: 0.8;
        transition: opacity 0.3s ease;
    }
    .artwork-card:hover .btn {
        opacity: 1;
    }
    .artwork-link {
        text-decoration: none;
        color: inherit;
        display: block;
    }
    .artwork-link:hover {
        text-decoration: none;
        color: inherit;
    }
    .artwork-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }
    .artwork-info {
        padding: 1rem;
    }
    .bio-textarea {
        min-height: 120px;
        resize: vertical;
    }
    .stats-card {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        border: 1px solid #dee2e6;
    }
    .stats-number {
        font-size: 2rem;
        font-weight: bold;
        color: #28a745;
    }
    .form-control-plaintext {
        padding: 0.375rem 0;
        margin-bottom: 0;
        color: #495057;
        background-color: transparent;
        border: solid transparent;
        border-width: 1px 0;
    }
    .form-control-plaintext:focus {
        outline: 0;
        box-shadow: none;
    }
    .edit-section-divider {
        border-top: 2px solid #e9ecef;
        margin: 2rem 0;
        opacity: 0.5;
    }
    .rating-display {
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
    .text-warning {
        color: #ffc107 !important;
    }
    
    .availability-toggle {
        transition: all 0.3s ease;
        min-width: 120px;
    }
    
    .availability-toggle:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
</style>

<div class="container py-5">
    @if (session('status') === 'profile-updated')
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            Profile updated successfully!
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    <div class="row">
        <!-- Profile Header Section -->
        <div class="col-12 mb-4">
            <div class="profile-card">
                <div class="profile-header">
                    <div class="mb-3 text-center">
                        @if(auth()->user()->profile_picture && file_exists(storage_path('app/public/' . auth()->user()->profile_picture)))
                            <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" alt="Profile Picture" class="profile-picture">
                        @else
                            <div class="profile-picture" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); display: flex; align-items: center; justify-content: center; font-size: 3rem; font-weight: bold; color: white;">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <h2 class="mb-2">{{ auth()->user()->name }}</h2>
                    <p class="mb-1">
                        <i class="fas fa-user-tag me-2"></i>
                        {{ ucfirst(auth()->user()->role) }}
                    </p>
                    <p class="mb-1">
                        @if(auth()->user()->role === 'artist')
                            @if(auth()->user()->is_available)
                                <span class="badge bg-success">
                                    <i class="fas fa-check-circle me-1"></i>Available
                                </span>
                            @else
                                <span class="badge bg-danger">
                                    <i class="fas fa-times-circle me-1"></i>Unavailable
                                </span>
                            @endif
                        @endif
                    </p>
                    <p class="mb-0 text-white-50">
                        <i class="fas fa-calendar-alt me-2"></i>
                        Member since {{ auth()->user()->created_at->format('M Y') }}
                    </p>
                    @if(auth()->user()->role === 'artist')
                        <div class="mt-3 d-flex gap-2 justify-content-center">
                            <a href="{{ route('artworks.create') }}" class="btn btn-light">
                                <i class="fas fa-upload me-2"></i>Upload Artwork
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Stats Section (for Artists) -->
        @if(auth()->user()->role === 'artist')
            <div class="col-12 mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <div class="stats-card">
                            <div class="stats-number">{{ auth()->user()->artworks->count() }}</div>
                            <div class="text-muted">Artworks</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stats-card">
                            <div class="stats-number">{{ auth()->user()->artworks->count() > 0 ? auth()->user()->artworks->count() * 15 : 0 }}</div>
                            <div class="text-muted">Views</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stats-card">
                            <div class="stats-number">
                                @if(auth()->user()->commission_average_rating > 0)
                                    {{ auth()->user()->commission_average_rating }} <i class="fas fa-star text-warning"></i>
                                @else
                                    <span class="text-muted">No ratings</span>
                                @endif
                            </div>
                            <div class="text-muted">Commission Rating</div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Main Content -->
        <div class="col-12">
            <!-- Profile Information Form -->
            <div class="profile-card p-4 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0"><i class="fas fa-user-edit me-2"></i>Profile Information</h4>
                    <button type="button" class="btn btn-success btn-sm" onclick="toggleEditMode()" id="edit-toggle-btn">
                        <i class="fas fa-edit me-1"></i>Edit Profile
                    </button>
                </div>
                
                <!-- View Mode -->
                <div id="view-mode">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Name</label>
                            <p class="form-control-plaintext">{{ $user->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Email</label>
                            <p class="form-control-plaintext">{{ $user->email }}</p>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Bio</label>
                        <p class="form-control-plaintext">{{ $user->bio ?: 'No bio added yet.' }}</p>
                    </div>
                    @if($user->role === 'artist')
                        <div class="mb-3">
                            <label class="form-label fw-bold">Availability Status</label>
                            <div class="d-flex align-items-center">
                                @if($user->is_available)
                                    <span class="badge bg-success me-2">
                                        <i class="fas fa-check-circle me-1"></i>Available
                                    </span>
                                    <small class="text-muted">Currently accepting new projects and commissions</small>
                                @else
                                    <span class="badge bg-danger me-2">
                                        <i class="fas fa-times-circle me-1"></i>Unavailable
                                    </span>
                                    <small class="text-muted">Not currently accepting new work</small>
                                @endif
                            </div>
                        </div>
                    @endif
                    <div class="mb-3">
                        <label class="form-label fw-bold">Role</label>
                        <p class="form-control-plaintext">{{ ucfirst($user->role) }}</p>
                    </div>
                </div>

                <!-- Edit Mode -->
                <div id="edit-mode" style="display: none;">
                    <form id="profile-form" method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('patch')
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input id="name" name="name" type="text" class="form-control" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required autocomplete="username">
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>

                        <div class="mb-3">
                            <label for="bio" class="form-label">Bio</label>
                            <textarea id="bio" name="bio" class="form-control bio-textarea" placeholder="Tell us about yourself, your artistic journey, or what you're looking for...">{{ old('bio', $user->bio) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
                        </div>

                        @if($user->role === 'artist')
                            <div class="mb-3">
                                <label for="is_available" class="form-label">Availability Status</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_available" name="is_available" value="1" {{ old('is_available', $user->is_available) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_available">
                                        I am available for new projects and commissions
                                    </label>
                                </div>
                                <small class="text-muted">Toggle this to let clients know if you're currently accepting new work</small>
                                <x-input-error class="mt-2" :messages="$errors->get('is_available')" />
                            </div>
                        @endif

                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <input id="role" type="text" class="form-control bg-light" value="{{ ucfirst($user->role) }}" readonly>
                        </div>

                        <div class="d-flex gap-2">
                            <x-primary-button>Save Changes</x-primary-button>
                            <button type="button" class="btn btn-secondary" onclick="cancelEdit()">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Divider in edit mode -->
            <div id="edit-divider-1" class="edit-section-divider" style="display: none;"></div>

            <!-- Password Update Form (in edit mode) -->
            <div id="password-section" class="profile-card p-4 mb-4" style="display: none;">
                <h4 class="mb-3"><i class="fas fa-lock me-2"></i>Update Password</h4>
                @include('profile.partials.update-password-form')
            </div>

            <!-- Divider in edit mode -->
            <div id="edit-divider-2" class="edit-section-divider" style="display: none;"></div>

            <!-- Delete Account Form (in edit mode) -->
            <div id="delete-section" class="profile-card p-4" style="display: none;">
                <h4 class="mb-3"><i class="fas fa-trash-alt me-2"></i>Delete Account</h4>
                @include('profile.partials.delete-user-form')
            </div>
        </div>

        <!-- Work Experience Section (for Artists) -->
        @if(auth()->user()->role === 'artist')
            <div class="col-12 mt-4">
                <div class="profile-card p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="mb-0"><i class="fas fa-briefcase me-2"></i>Work Experience</h4>
                        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addWorkExperienceModal">
                            <i class="fas fa-plus me-1"></i>Add Experience
                        </button>
                    </div>
                    
                    @if(auth()->user()->workExperiences->count() > 0)
                        <div class="row">
                            @foreach(auth()->user()->workExperiences->sortByDesc('start_date') as $experience)
                                <div class="col-12 mb-3">
                                    <div class="card border-success">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div class="flex-grow-1">
                                                    <h6 class="card-title text-success mb-1">{{ $experience->position }}</h6>
                                                    <p class="card-subtitle mb-2 text-muted">{{ $experience->company_name }}</p>
                                                    @if($experience->project_type)
                                                        <span class="badge bg-info mb-2">{{ $experience->project_type }}</span>
                                                    @endif
                                                    @if($experience->location)
                                                        <p class="mb-2"><i class="fas fa-map-marker-alt me-1"></i>{{ $experience->location }}</p>
                                                    @endif
                                                    <p class="card-text">{{ $experience->description }}</p>
                                                    <small class="text-muted">
                                                        <i class="fas fa-calendar me-1"></i>
                                                        {{ $experience->start_date->format('M Y') }} - 
                                                        @if($experience->is_current)
                                                            <span class="badge bg-success">Current</span>
                                                        @else
                                                            {{ $experience->end_date->format('M Y') }}
                                                        @endif
                                                        <span class="ms-2">({{ $experience->duration }})</span>
                                                    </small>
                                                </div>
                                                <div class="d-flex gap-2">
                                                    <button type="button" class="btn btn-outline-primary btn-sm" 
                                                            onclick="editWorkExperience({{ $experience->id }}, '{{ $experience->company_name }}', '{{ $experience->position }}', '{{ $experience->description }}', '{{ $experience->project_type }}', '{{ $experience->location }}', '{{ $experience->start_date->format('Y-m-d') }}', '{{ $experience->end_date ? $experience->end_date->format('Y-m-d') : '' }}', {{ $experience->is_current ? 'true' : 'false' }})">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <form method="POST" action="{{ route('work-experience.destroy', $experience) }}" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this work experience?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger btn-sm">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-briefcase fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No work experience added yet.</p>
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addWorkExperienceModal">
                                <i class="fas fa-plus me-1"></i>Add Your First Experience
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <!-- User's Artworks Section (for Artists) - Full Width at Bottom -->
        @if(auth()->user()->role === 'artist')
            <div class="col-12 mt-4">
                <div class="profile-card p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="mb-0"><i class="fas fa-images me-2"></i>My Artworks</h4>
                        <a href="{{ route('artworks.create') }}" class="btn btn-success">
                            <i class="fas fa-upload me-2"></i>Upload New Artwork
                        </a>
                    </div>
                    
                    @if(auth()->user()->artworks->count() > 0)
                        <div class="artwork-grid">
                            @foreach(auth()->user()->artworks->take(12) as $artwork)
                                <div class="artwork-card">
                                    <a href="{{ route('artworks.show', $artwork) }}" class="artwork-link">
                                        @if(file_exists(storage_path('app/public/' . $artwork->image)))
                                            <img src="{{ asset('storage/' . $artwork->image) }}" alt="{{ $artwork->title }}" class="artwork-image">
                                        @else
                                            <div class="artwork-image" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                                                {{ $artwork->title }}
                                            </div>
                                        @endif
                                    </a>
                                    <div class="artwork-info">
                                        <h6 class="mb-1">{{ $artwork->title }}</h6>
                                        <small class="text-muted">{{ ucfirst($artwork->category) }}</small>
                                        <div class="mt-2">
                                            <small class="text-muted">{{ $artwork->created_at->diffForHumans() }}</small>
                                        </div>
                                        <div class="mt-2 d-flex justify-content-between align-items-center">
                                            <div class="artwork-stats">
                                                <small class="text-muted me-3">
                                                    <i class="fas fa-heart text-danger"></i> {{ $artwork->likes_count ?? 0 }}
                                                </small>
                                                <small class="text-muted">
                                                    <i class="fas fa-comment text-primary"></i> {{ $artwork->comments_count ?? 0 }}
                                                </small>
                                            </div>
                                            <div class="d-flex gap-1">
                                                <form method="POST" action="{{ route('artworks.favorite', $artwork) }}" class="d-inline">
                                                    @csrf
                                                                                                               <button type="submit" class="btn btn-outline-info btn-sm" title="{{ $artwork->isFavoritedBy(auth()->user()) ? 'Remove from favorites' : 'Save for later' }}">
                                                               <i class="fas fa-{{ $artwork->isFavoritedBy(auth()->user()) ? 'heart' : 'bookmark' }}"></i>
                                                           </button>
                                                </form>
                                                <a href="{{ route('artworks.show', $artwork) }}" class="btn btn-outline-success btn-sm">
                                                    <i class="fas fa-eye me-1"></i>View
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @if(auth()->user()->artworks->count() > 12)
                            <div class="text-center mt-4">
                                <a href="{{ route('gallery') }}?artist={{ auth()->user()->id }}" class="btn btn-outline-success btn-lg">
                                    <i class="fas fa-images me-2"></i>View All {{ auth()->user()->artworks->count() }} Artworks
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-palette fa-4x text-muted mb-4"></i>
                            <h5 class="text-muted mb-3">No artworks uploaded yet</h5>
                            <p class="text-muted mb-4">Start showcasing your artistic talent by uploading your first artwork!</p>
                            <a href="{{ route('artworks.create') }}" class="btn btn-success btn-lg">
                                <i class="fas fa-upload me-2"></i>Upload Your First Artwork
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <!-- Favorites Section (for all users) -->
        <div class="col-12 mt-4">
            <div class="profile-card p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="mb-0"><i class="fas fa-heart me-2"></i>My Favorites</h4>
                </div>
                
                @if(auth()->user()->favorites_count > 0)
                    <div class="artwork-grid">
                        @foreach(auth()->user()->favoriteArtworks->take(12) as $favorite)
                            <div class="artwork-card">
                                <a href="{{ route('artworks.show', $favorite->artwork) }}" class="artwork-link">
                                    @if(file_exists(storage_path('app/public/' . $favorite->artwork->image)))
                                        <img src="{{ asset('storage/' . $favorite->artwork->image) }}" alt="{{ $favorite->artwork->title }}" class="artwork-image">
                                    @else
                                        <div class="artwork-image" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                                            {{ $favorite->artwork->title }}
                                        </div>
                                    @endif
                                </a>
                                <div class="artwork-info">
                                    <h6 class="mb-1">{{ $favorite->artwork->title }}</h6>
                                    <small class="text-muted">by {{ $favorite->artwork->user->name }}</small>
                                    <div class="mt-2">
                                        <small class="text-muted">{{ $favorite->artwork->created_at->diffForHumans() }}</small>
                                    </div>
                                    <div class="mt-2 d-flex justify-content-between align-items-center">
                                        <div class="artwork-stats">
                                            <small class="text-muted me-3">
                                                <i class="fas fa-heart text-danger"></i> {{ $favorite->artwork->likes_count ?? 0 }}
                                            </small>
                                            <small class="text-muted">
                                                <i class="fas fa-comment text-primary"></i> {{ $favorite->artwork->comments_count ?? 0 }}
                                            </small>
                                        </div>
                                        <a href="{{ route('artworks.show', $favorite->artwork) }}" class="btn btn-outline-success btn-sm">
                                            <i class="fas fa-eye me-1"></i>View
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if(auth()->user()->favorites_count > 12)
                        <div class="text-center mt-4">
                            <a href="{{ route('gallery') }}?favorites=1" class="btn btn-outline-success btn-lg">
                                <i class="fas fa-heart me-2"></i>View All {{ auth()->user()->favorites_count }} Favorites
                            </a>
                        </div>
                    @endif
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-heart fa-4x text-muted mb-4"></i>
                        <h5 class="text-muted mb-3">No favorites yet</h5>
                        <p class="text-muted mb-4">Start exploring the gallery and save artworks you love!</p>
                        <a href="{{ route('gallery') }}" class="btn btn-success btn-lg">
                            <i class="fas fa-search me-2"></i>Explore Gallery
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Client Information Section -->
        @if(auth()->user()->role === 'client')
            <div class="col-12 mt-4">
                <div class="profile-card p-4">
                    <div class="text-center py-5">
                        <i class="fas fa-search fa-4x text-muted mb-4"></i>
                        <h5 class="text-muted mb-3">Ready to discover amazing art?</h5>
                        <p class="text-muted mb-4">Browse our gallery to find talented artists and their incredible artworks!</p>
                        <a href="{{ route('gallery') }}" class="btn btn-success btn-lg">
                            <i class="fas fa-images me-2"></i>Explore Gallery
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Add Work Experience Modal -->
<div class="modal fade" id="addWorkExperienceModal" tabindex="-1" aria-labelledby="addWorkExperienceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="addWorkExperienceModalLabel">
                    <i class="fas fa-plus me-2"></i>Add Work Experience
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('work-experience.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="company_name" class="form-label">Company/Client Name *</label>
                                <input type="text" class="form-control" id="company_name" name="company_name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="position" class="form-label">Position/Role *</label>
                                <input type="text" class="form-control" id="position" name="position" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="project_type" class="form-label">Project Type</label>
                                <input type="text" class="form-control" id="project_type" name="project_type" placeholder="e.g., Restaurant Wall Painting, Logo Design, Digital Art">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="location" class="form-label">Location</label>
                                <input type="text" class="form-control" id="location" name="location" placeholder="City, Country">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description *</label>
                        <textarea class="form-control" id="description" name="description" rows="4" required placeholder="Describe your role, responsibilities, and achievements..."></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="start_date" class="form-label">Start Date *</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" class="form-control" id="end_date" name="end_date">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_current" name="is_current" value="1">
                            <label class="form-check-label" for="is_current">
                                This is my current position
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-1"></i>Save Experience
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Work Experience Modal -->
<div class="modal fade" id="editWorkExperienceModal" tabindex="-1" aria-labelledby="editWorkExperienceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editWorkExperienceModalLabel">
                    <i class="fas fa-edit me-2"></i>Edit Work Experience
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editWorkExperienceForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_company_name" class="form-label">Company/Client Name *</label>
                                <input type="text" class="form-control" id="edit_company_name" name="company_name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_position" class="form-label">Position/Role *</label>
                                <input type="text" class="form-control" id="edit_position" name="position" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_project_type" class="form-label">Project Type</label>
                                <input type="text" class="form-control" id="edit_project_type" name="project_type" placeholder="e.g., Restaurant Wall Painting, Logo Design, Digital Art">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_location" class="form-label">Location</label>
                                <input type="text" class="form-control" id="edit_location" name="location" placeholder="City, Country">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_description" class="form-label">Description *</label>
                        <textarea class="form-control" id="edit_description" name="description" rows="4" required placeholder="Describe your role, responsibilities, and achievements..."></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_start_date" class="form-label">Start Date *</label>
                                <input type="date" class="form-control" id="edit_start_date" name="start_date" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_end_date" class="form-label">End Date</label>
                                <input type="date" class="form-control" id="edit_end_date" name="end_date">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="edit_is_current" name="is_current" value="1">
                            <label class="form-check-label" for="edit_is_current">
                                This is my current position
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Update Experience
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Edit mode toggle functions
function toggleEditMode() {
    const viewMode = document.getElementById('view-mode');
    const editMode = document.getElementById('edit-mode');
    const passwordSection = document.getElementById('password-section');
    const deleteSection = document.getElementById('delete-section');
    const editDivider1 = document.getElementById('edit-divider-1');
    const editDivider2 = document.getElementById('edit-divider-2');
    const editButton = document.getElementById('edit-toggle-btn');
    
    if (viewMode.style.display === 'none') {
        // Switch to view mode
        viewMode.style.display = 'block';
        editMode.style.display = 'none';
        passwordSection.style.display = 'none';
        deleteSection.style.display = 'none';
        editDivider1.style.display = 'none';
        editDivider2.style.display = 'none';
        editButton.innerHTML = '<i class="fas fa-edit me-1"></i>Edit Profile';
    } else {
        // Switch to edit mode
        viewMode.style.display = 'none';
        editMode.style.display = 'block';
        passwordSection.style.display = 'block';
        deleteSection.style.display = 'block';
        editDivider1.style.display = 'block';
        editDivider2.style.display = 'block';
        editButton.innerHTML = '<i class="fas fa-eye me-1"></i>View Profile';
    }
}

function cancelEdit() {
    const viewMode = document.getElementById('view-mode');
    const editMode = document.getElementById('edit-mode');
    const passwordSection = document.getElementById('password-section');
    const deleteSection = document.getElementById('delete-section');
    const editDivider1 = document.getElementById('edit-divider-1');
    const editDivider2 = document.getElementById('edit-divider-2');
    const editButton = document.getElementById('edit-toggle-btn');
    
    viewMode.style.display = 'block';
    editMode.style.display = 'none';
    passwordSection.style.display = 'none';
    deleteSection.style.display = 'none';
    editDivider1.style.display = 'none';
    editDivider2.style.display = 'none';
    editButton.innerHTML = '<i class="fas fa-edit me-1"></i>Edit Profile';
}

function toggleAvailability() {
    const button = event.target;
    const isCurrentlyAvailable = button.classList.contains('btn-success');
    const newStatus = !isCurrentlyAvailable;
    
    // Create form data
    const formData = new FormData();
    formData.append('_token', '{{ csrf_token() }}');
    formData.append('_method', 'PATCH');
    formData.append('is_available', newStatus ? '1' : '0');
    
    // Send AJAX request
    fetch('{{ route("profile.update") }}', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update button appearance
            if (newStatus) {
                button.className = 'btn btn-success';
                button.innerHTML = '<i class="fas fa-check-circle me-2"></i>Available';
            } else {
                button.className = 'btn btn-danger';
                button.innerHTML = '<i class="fas fa-times-circle me-2"></i>Unavailable';
            }
            
            // Update availability badge in profile header
            const availabilityBadge = document.querySelector('.profile-header .badge');
            if (availabilityBadge) {
                if (newStatus) {
                    availabilityBadge.className = 'badge bg-success';
                    availabilityBadge.innerHTML = '<i class="fas fa-check-circle me-1"></i>Available';
                } else {
                    availabilityBadge.className = 'badge bg-danger';
                    availabilityBadge.innerHTML = '<i class="fas fa-times-circle me-1"></i>Unavailable';
                }
            }
            
            // Show success message
            showAlert('Availability updated successfully!', 'success');
        } else {
            showAlert('Failed to update availability. Please try again.', 'danger');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('An error occurred. Please try again.', 'danger');
    });
}

function showAlert(message, type) {
    // Remove existing alerts
    const existingAlert = document.querySelector('.alert');
    if (existingAlert) {
        existingAlert.remove();
    }
    
    // Create new alert
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
    alertDiv.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    // Insert at the top of the container
    const container = document.querySelector('.container');
    container.insertBefore(alertDiv, container.firstChild);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, 5000);
}

function editWorkExperience(id, company, position, description, projectType, location, startDate, endDate, isCurrent) {
    document.getElementById('edit_company_name').value = company;
    document.getElementById('edit_position').value = position;
    document.getElementById('edit_description').value = description;
    document.getElementById('edit_project_type').value = projectType || '';
    document.getElementById('edit_location').value = location || '';
    document.getElementById('edit_start_date').value = startDate;
    document.getElementById('edit_end_date').value = endDate || '';
    document.getElementById('edit_is_current').checked = isCurrent;
    
    const form = document.getElementById('editWorkExperienceForm');
    form.action = `/work-experience/${id}`;
    form.method = 'POST';
    
    // Add method override for PUT request
    const methodInput = document.createElement('input');
    methodInput.type = 'hidden';
    methodInput.name = '_method';
    methodInput.value = 'PUT';
    form.appendChild(methodInput);
    
    const modal = new bootstrap.Modal(document.getElementById('editWorkExperienceModal'));
    modal.show();
}

// Handle current position checkbox functionality
document.addEventListener('DOMContentLoaded', function() {
    const isCurrentCheckboxes = document.querySelectorAll('#is_current, #edit_is_current');
    const endDateInputs = document.querySelectorAll('#end_date, #edit_end_date');
    
    isCurrentCheckboxes.forEach(function(checkbox, index) {
        checkbox.addEventListener('change', function() {
            const endDateInput = endDateInputs[index];
            if (this.checked) {
                endDateInput.value = '';
                endDateInput.disabled = true;
            } else {
                endDateInput.disabled = false;
            }
        });
    });
});
</script>
@endsection
