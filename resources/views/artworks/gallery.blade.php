@extends('layouts.app')
@section('title', 'Gallery – ArtConnect')
@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <form method="GET" action="{{ route('gallery') }}" class="d-flex align-items-center">
            <label for="category" class="me-2 fw-semibold text-success">Filter by Category:</label>
            <select name="category" id="category" class="form-select w-auto me-2" onchange="this.form.submit()">
                <option value="">All</option>
                <option value="digital" {{ request('category') == 'digital' ? 'selected' : '' }}>Digital</option>
                <option value="traditional" {{ request('category') == 'traditional' ? 'selected' : '' }}>Traditional</option>
                <option value="oil" {{ request('category') == 'oil' ? 'selected' : '' }}>Oil</option>
                <option value="watercolor" {{ request('category') == 'watercolor' ? 'selected' : '' }}>Watercolor</option>
                <option value="glass painting" {{ request('category') == 'glass painting' ? 'selected' : '' }}>Glass Painting</option>
                <option value="sketches" {{ request('category') == 'sketches' ? 'selected' : '' }}>Sketches</option>
            </select>
            @auth
                <div class="form-check ms-3">
                    <input class="form-check-input" type="checkbox" name="favorites" value="1" id="favorites" {{ request('favorites') ? 'checked' : '' }} onchange="this.form.submit()">
                    <label class="form-check-label text-success fw-semibold" for="favorites">
                        <i class="fas fa-heart me-1"></i>My Favorites
                    </label>
                </div>
            @endauth
        </form>
    </div>
</div>
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
<div class="row g-4">
    @forelse($artworks as $artwork)
        <div class="col-md-4 col-lg-3">
            <div class="card h-100 shadow-sm">
                <img src="{{ asset('storage/' . $artwork->image) }}" class="card-img-top" alt="{{ $artwork->title }}" style="object-fit:cover; height:220px;">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title mb-1">{{ $artwork->title }}</h5>
                    <p class="mb-1 text-muted small">By {{ $artwork->user->name ?? 'Unknown' }}</p>
                    <span class="badge bg-success mb-2" style="width:fit-content;">{{ ucfirst($artwork->category) }}</span>
                    <p class="card-text flex-grow-1">{{ Str::limit($artwork->description, 60) }}</p>
                    <div class="d-flex gap-2 mt-auto">
                        @auth
                            <form method="POST" action="{{ route('artworks.favorite', $artwork) }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-info btn-sm" title="{{ $artwork->isFavoritedBy(auth()->user()) ? 'Remove from favorites' : 'Save for later' }}">
                                    <i class="fas fa-{{ $artwork->isFavoritedBy(auth()->user()) ? 'heart' : 'bookmark' }}"></i>
                                </button>
                            </form>
                        @endauth
                        <a href="{{ route('artworks.show', $artwork) }}" class="btn btn-outline-success btn-sm">View Details</a>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info text-center">No artworks found.</div>
        </div>
    @endforelse
</div>
<div class="mt-4">
    {{ $artworks->withQueryString()->links() }}
</div>
@endsection 