@extends('layouts.app')
@section('title', $artwork->title . ' – ArtConnect')
@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<div class="row">
    <div class="col-lg-8">
        <!-- Artwork Display -->
        <div class="card shadow-sm mb-4">
            <div class="card-body p-0">
                <img src="{{ asset('storage/' . $artwork->image) }}" 
                     class="img-fluid w-100" 
                     alt="{{ $artwork->title }}"
                     style="max-height: 600px; object-fit: contain;">
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Artwork Info -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h2 class="card-title text-success mb-2">{{ $artwork->title }}</h2>
                <p class="text-muted mb-2">
                    <i class="fas fa-user me-1"></i>
                    By {{ $artwork->user->name ?? 'Unknown Artist' }}
                </p>
                <span class="badge bg-success mb-3">{{ ucfirst($artwork->category) }}</span>
                
                @if($artwork->description)
                    <p class="card-text">{{ $artwork->description }}</p>
                @endif
                
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-heart text-danger me-1"></i>
                        <span class="fw-semibold">{{ $artwork->likes_count }} likes</span>
                    </div>
                    
                    @auth
                        <div class="d-flex gap-2">
                            <form method="POST" action="{{ route('artworks.favorite', $artwork) }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-info btn-sm" title="{{ $artwork->isFavoritedBy(Auth::user()) ? 'Remove from favorites' : 'Save for later' }}">
                                    <i class="fas fa-{{ $artwork->isFavoritedBy(Auth::user()) ? 'heart' : 'bookmark' }} me-1"></i>
                                    {{ $artwork->isFavoritedBy(Auth::user()) ? 'Saved' : 'Save' }}
                                </button>
                            </form>
                            <form method="POST" action="{{ route('artworks.like', $artwork) }}" class="d-inline">
                                @csrf
                                @if($artwork->isLikedBy(Auth::user()))
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-heart me-1"></i>Unlike
                                    </button>
                                @else
                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                        <i class="far fa-heart me-1"></i>Like
                                    </button>
                                @endif
                            </form>
                        </div>
                    @endauth
                </div>
                
                <hr>
                <small class="text-muted">
                    <i class="fas fa-calendar me-1"></i>
                    Posted {{ $artwork->created_at->diffForHumans() }}
                </small>
            </div>
        </div>
    </div>
</div>

<!-- Comments Section -->
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">
                    <i class="fas fa-comments me-2"></i>
                    Comments ({{ $artwork->comments->count() }})
                </h5>
            </div>
            <div class="card-body">
                @auth
                    <!-- Add Comment Form -->
                    <form method="POST" action="{{ route('comments.store') }}" class="mb-4">
                        @csrf
                        <input type="hidden" name="artwork_id" value="{{ $artwork->id }}">
                        <div class="mb-3">
                            <label for="content" class="form-label">Add a comment:</label>
                            <textarea class="form-control" id="content" name="content" rows="3" 
                                      placeholder="Share your thoughts about this artwork..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-paper-plane me-1"></i>Post Comment
                        </button>
                    </form>
                @else
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-1"></i>
                        Please <a href="{{ route('login') }}" class="alert-link">login</a> to leave a comment.
                    </div>
                @endauth
                
                <hr>
                
                <!-- Comments List -->
                @forelse($artwork->comments as $comment)
                    <div class="d-flex mb-3">
                        <div class="flex-shrink-0">
                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" 
                                 style="width: 40px; height: 40px;">
                                <i class="fas fa-user"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1 fw-semibold">{{ $comment->user->name }}</h6>
                                    <p class="mb-1">{{ $comment->content }}</p>
                                    <small class="text-muted">
                                        {{ $comment->created_at->diffForHumans() }}
                                    </small>
                                </div>
                                <div class="d-flex align-items-center">
                                    @auth
                                        <form method="POST" action="{{ route('comments.like', $comment->id) }}" class="me-2">
                                            @csrf
                                            @if($comment->isLikedBy(Auth::user()))
                                                <button type="submit" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-thumbs-up me-1"></i>{{ $comment->likes_count }}
                                                </button>
                                            @else
                                                <button type="submit" class="btn btn-sm btn-outline-primary">
                                                    <i class="far fa-thumbs-up me-1"></i>{{ $comment->likes_count }}
                                                </button>
                                            @endif
                                        </form>
                                        
                                        @if(Auth::id() === $comment->user_id)
                                            <form method="POST" action="{{ route('comments.destroy', $comment->id) }}" 
                                                  onsubmit="return confirm('Are you sure you want to delete this comment?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-comments fa-2x mb-3"></i>
                        <p>No comments yet. Be the first to share your thoughts!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Back to Gallery -->
<div class="mt-4">
    <a href="{{ route('gallery') }}" class="btn btn-outline-success">
        <i class="fas fa-arrow-left me-1"></i>Back to Gallery
    </a>
</div>
@endsection 