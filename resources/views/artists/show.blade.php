@extends('layouts.app')
@section('title', $artist->name . ' – Artist Profile – ArtConnect')
@section('content')

<div class="container">
    <!-- Artist Header -->
    <div class="row mb-4">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <div class="flex-shrink-0 me-4">
                            <img src="{{ $artist->profile_picture_url }}" 
                                 class="rounded-circle" width="120" height="120" 
                                 alt="{{ $artist->name }}"
                                 onerror="this.onerror=null; this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTIwIiBoZWlnaHQ9IjEyMCIgdmlld0JveD0iMCAwIDEyMCAxMjAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxjaXJjbGUgY3g9IjYwIiBjeT0iNjAiIHI9IjYwIiBmaWxsPSIjMjhBNzdBIi8+CjxzdmcgeD0iMjgiIHk9IjI4IiB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0id2hpdGUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxwYXRoIGQ9Ik0xMiAxMmMyLjIxIDAgNC0xLjc5IDQtNHMtMS43OS00LTQtNC00IDEuNzktNCA0IDEuNzkgNCA0IDR6bTAgMmMtMi42NyAwLTggMS4zNC04IDR2MmgxNnYtMmMwLTIuNjYtNS4zMy00LTgtNHoiLz4KPC9zdmc+CjwvY2lyY2xlPgo='">
                        </div>
                        <div class="flex-grow-1">
                            <h1 class="h2 mb-2">{{ $artist->name }}</h1>
                            <p class="text-muted mb-3">
                                <i class="fas fa-palette me-2"></i>Artist
                            </p>
                            
                            <div class="mb-3">
                                @if($artist->is_available)
                                    <span class="badge bg-success fs-6">
                                        <i class="fas fa-check-circle me-1"></i>Available for Commissions
                                    </span>
                                @else
                                    <span class="badge bg-danger fs-6">
                                        <i class="fas fa-times-circle me-1"></i>Currently Unavailable
                                    </span>
                                @endif
                            </div>
                            
                            @if($artist->bio)
                                <p class="lead mb-3">{{ $artist->bio }}</p>
                            @endif

                            <!-- Artist Stats -->
                            <div class="row text-center">
                                <div class="col-3">
                                    <div class="h4 text-success mb-1">{{ $stats['total_artworks'] }}</div>
                                    <small class="text-muted">Artworks</small>
                                </div>
                                <div class="col-3">
                                    <div class="h4 text-info mb-1">{{ $stats['completed_commissions'] }}</div>
                                    <small class="text-muted">Completed</small>
                                </div>
                                <div class="col-3">
                                    <div class="h4 text-warning mb-1">{{ $stats['average_rating'] > 0 ? $stats['average_rating'] : 'N/A' }}</div>
                                    <small class="text-muted">Rating</small>
                                </div>
                                <div class="col-3">
                                    <div class="h4 text-primary mb-1">{{ $stats['total_ratings'] }}</div>
                                    <small class="text-muted">Reviews</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Rating Summary -->
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-warning text-white">
                    <h6 class="mb-0"><i class="fas fa-star me-2"></i>Rating Summary</h6>
                </div>
                <div class="card-body text-center">
                    @if($stats['average_rating'] > 0)
                        <div class="display-6 text-warning mb-2">{{ $stats['average_rating'] }}</div>
                        <div class="mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $stats['average_rating'])
                                    <i class="fas fa-star fa-lg text-warning"></i>
                                @elseif($i - 0.5 <= $stats['average_rating'])
                                    <i class="fas fa-star-half-alt fa-lg text-warning"></i>
                                @else
                                    <i class="far fa-star fa-lg text-warning"></i>
                                @endif
                            @endfor
                        </div>
                        <small class="text-muted">{{ $stats['total_ratings'] }} rating{{ $stats['total_ratings'] != 1 ? 's' : '' }}</small>
                    @else
                        <div class="text-muted">No ratings yet</div>
                    @endif
                </div>
            </div>

            <!-- Commission Rating -->
            @if($stats['commission_rating'] > 0)
                <div class="card shadow-sm mb-3">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0"><i class="fas fa-handshake me-2"></i>Commission Rating</h6>
                    </div>
                    <div class="card-body text-center">
                        <div class="h4 text-info mb-2">{{ $stats['commission_rating'] }}</div>
                        <div class="mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $stats['commission_rating'])
                                    <i class="fas fa-star text-info"></i>
                                @elseif($i - 0.5 <= $stats['commission_rating'])
                                    <i class="fas fa-star-half-alt text-info"></i>
                                @else
                                    <i class="far fa-star text-info"></i>
                                @endif
                            @endfor
                        </div>
                        <small class="text-muted">From {{ $stats['completed_commissions'] }} commission{{ $stats['completed_commissions'] != 1 ? 's' : '' }}</small>
                    </div>
                </div>
            @endif

            <!-- Contact/Commission Button -->
            @auth
                @if(auth()->user()->role === 'client')
                    <div class="d-grid">
                        <a href="#" class="btn btn-success btn-lg">
                            <i class="fas fa-envelope me-2"></i>Request Commission
                        </a>
                    </div>
                @endif
            @endauth
        </div>
    </div>

    <!-- Artist Skills and Styles -->
    @if($artist->artworks->count() > 0)
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="fas fa-brush me-2"></i>Artistic Styles & Skills</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($artist->artworks->pluck('category')->unique() as $category)
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="d-flex align-items-center p-3 border rounded">
                                        <i class="fas fa-palette text-success me-3"></i>
                                        <div>
                                            <strong>{{ ucfirst($category) }}</strong>
                                            <div class="text-muted small">
                                                {{ $artist->artworks->where('category', $category)->count() }} artwork{{ $artist->artworks->where('category', $category)->count() != 1 ? 's' : '' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Work Experience -->
    @if($artist->workExperiences->count() > 0)
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-briefcase me-2"></i>Work Experience & Projects</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($artist->workExperiences as $experience)
                                <div class="col-lg-6 mb-3">
                                    <div class="border rounded p-3 h-100">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h6 class="mb-1">{{ $experience->position }}</h6>
                                            <span class="badge bg-primary">{{ $experience->project_type }}</span>
                                        </div>
                                        <p class="text-muted mb-2">{{ $experience->company_name }}</p>
                                        <p class="small mb-2">{{ $experience->description }}</p>
                                        <div class="d-flex justify-content-between text-muted small">
                                            <span>{{ $experience->start_date->format('M Y') }} - 
                                                {{ $experience->is_current ? 'Present' : $experience->end_date->format('M Y') }}</span>
                                            <span>{{ $experience->duration }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Artworks Gallery -->
    @if($artist->artworks->count() > 0)
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0"><i class="fas fa-images me-2"></i>Artwork Portfolio</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            @foreach($artist->artworks->take(6) as $artwork)
                                <div class="col-md-4 col-lg-3">
                                    <div class="card h-100">
                                        <img src="{{ asset('storage/' . $artwork->image) }}" 
                                             class="card-img-top" alt="{{ $artwork->title }}" 
                                             style="height: 200px; object-fit: cover;">
                                        <div class="card-body">
                                            <h6 class="card-title">{{ $artwork->title }}</h6>
                                            <span class="badge bg-success mb-2">{{ ucfirst($artwork->category) }}</span>
                                            <p class="card-text small text-muted">{{ Str::limit($artwork->description, 60) }}</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                @if($artwork->average_rating > 0)
                                                    <div class="text-warning">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            @if($i <= $artwork->average_rating)
                                                                <i class="fas fa-star"></i>
                                                            @elseif($i - 0.5 <= $artwork->average_rating)
                                                                <i class="fas fa-star-half-alt"></i>
                                                            @else
                                                                <i class="far fa-star"></i>
                                                            @endif
                                                        @endfor
                                                    </div>
                                                @endif
                                                <a href="{{ route('artworks.show', $artwork) }}" class="btn btn-outline-primary btn-sm">View</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        @if($artist->artworks->count() > 6)
                            <div class="text-center mt-3">
                                <a href="{{ route('gallery') }}?artist={{ $artist->id }}" class="btn btn-outline-success">
                                    <i class="fas fa-images me-2"></i>View All {{ $artist->artworks->count() }} Artworks
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Back to Artists -->
    <div class="text-center mb-4">
        <a href="{{ route('artists.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Artists
        </a>
    </div>
</div>

@endsection 