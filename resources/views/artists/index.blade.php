@extends('layouts.app')
@section('title', 'Browse Artists – ArtConnect')
@section('content')

<div class="container-fluid">
    <div class="row">
        <!-- Filters Sidebar -->
        <div class="col-lg-3">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filters</h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('artists.index') }}" id="artistFilters">
                        <!-- Search -->
                        <div class="mb-3">
                            <label for="search" class="form-label fw-semibold">Search Artists</label>
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="{{ request('search') }}" placeholder="Name, bio, style...">
                        </div>

                        <!-- Category Filter -->
                        <div class="mb-3">
                            <label for="category" class="form-label fw-semibold">Art Style</label>
                            <select class="form-select" id="category" name="category">
                                <option value="">All Styles</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                        {{ ucfirst($category) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Skill Filter -->
                        <div class="mb-3">
                            <label for="skill" class="form-label fw-semibold">Skills/Project Types</label>
                            <select class="form-select" id="skill" name="skill">
                                <option value="">All Skills</option>
                                @foreach($skills as $skill)
                                    <option value="{{ $skill }}" {{ request('skill') == $skill ? 'selected' : '' }}>
                                        {{ ucfirst($skill) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Rating Filter -->
                        <div class="mb-3">
                            <label for="min_rating" class="form-label fw-semibold">Minimum Rating</label>
                            <select class="form-select" id="min_rating" name="min_rating">
                                <option value="">Any Rating</option>
                                <option value="4" {{ request('min_rating') == '4' ? 'selected' : '' }}>4+ Stars</option>
                                <option value="4.5" {{ request('min_rating') == '4.5' ? 'selected' : '' }}>4.5+ Stars</option>
                                <option value="5" {{ request('min_rating') == '5' ? 'selected' : '' }}>5 Stars Only</option>
                            </select>
                        </div>

                        <!-- Availability Filter -->
                        <div class="mb-3">
                            <label for="availability" class="form-label fw-semibold">Availability</label>
                            <select class="form-select" id="availability" name="availability">
                                <option value="">Any Availability</option>
                                <option value="available" {{ request('availability') == 'available' ? 'selected' : '' }}>Available</option>
                                <option value="unavailable" {{ request('availability') == 'unavailable' ? 'selected' : '' }}>Unavailable</option>
                            </select>
                        </div>

                        <!-- Sort Options -->
                        <div class="mb-3">
                            <label for="sort" class="form-label fw-semibold">Sort By</label>
                            <select class="form-select" id="sort" name="sort">
                                <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name</option>
                                <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Rating</option>
                                <option value="artworks" {{ request('sort') == 'artworks' ? 'selected' : '' }}>Artworks Count</option>
                                <option value="commissions" {{ request('sort') == 'commissions' ? 'selected' : '' }}>Commissions</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="order" class="form-label fw-semibold">Order</label>
                            <select class="form-select" id="order" name="order">
                                <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>Ascending</option>
                                <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>Descending</option>
                            </select>
                        </div>

                        <!-- Filter Buttons -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-search me-2"></i>Apply Filters
                            </button>
                            <a href="{{ route('artists.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Clear Filters
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Artists Grid -->
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">
                    <i class="fas fa-palette me-2 text-success"></i>
                    Browse Artists
                    @if(request()->anyFilled(['search', 'category', 'skill', 'min_rating', 'availability']))
                        <small class="text-muted">(Filtered Results)</small>
                    @endif
                </h2>
                <div class="text-muted">
                    {{ $artists->total() }} artist{{ $artists->total() != 1 ? 's' : '' }} found
                </div>
            </div>

            @if($artists->count() > 0)
                <div class="row g-4">
                    @foreach($artists as $artist)
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 shadow-sm hover-shadow">
                                <div class="card-body">
                                    <!-- Artist Avatar and Basic Info -->
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="flex-shrink-0">
                                            <img src="{{ $artist->profile_picture_url }}" 
                                                 class="rounded-circle" width="50" height="50" 
                                                 alt="{{ $artist->name }}"
                                                 onerror="this.onerror=null; this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNTAiIGhlaWdodD0iNTAiIHZpZXdCb3g9IjAgMCA1MCA1MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPGNpcmNsZSBjeD0iMjUiIGN5PSIyNSIgcj0iMjUiIGZpbGw9IiMyOEE3N0EiLz4KPHN2ZyB4PSIxMiIgeT0iMTIiIHdpZHRoPSIyNiIgaGVpZ2h0PSIyNiIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJ3aGl0ZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTEyIDEyYzIuMjEgMCA0LTEuNzkgNC00cy0xLjc5LTQtNC00LTQgMS43OS00IDQgMS43OSA0IDQgNHptMCAyYy0yLjY3IDAtOCAxLjM0LTggNHYyaDE2di0yYzAtMi42Ni01LjMzLTQtOC00eiIvPgo8L3N2Zz4KPC9jaXJjbGU+Cg=='">
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h5 class="card-title mb-1">
                                                <a href="{{ route('artists.show', $artist) }}" class="text-decoration-none text-dark">
                                                    {{ $artist->name }}
                                                </a>
                                            </h5>
                                            <div class="mb-2">
                                                @if($artist->is_available)
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-check-circle me-1"></i>Available
                                                    </span>
                                                @else
                                                    <span class="badge bg-danger">
                                                        <i class="fas fa-times-circle me-1"></i>Unavailable
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="d-flex align-items-center">
                                                @if($artist->average_rating > 0)
                                                    <div class="text-warning me-2">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            @if($i <= $artist->average_rating)
                                                                <i class="fas fa-star"></i>
                                                            @elseif($i - 0.5 <= $artist->average_rating)
                                                                <i class="fas fa-star-half-alt"></i>
                                                            @else
                                                                <i class="far fa-star"></i>
                                                            @endif
                                                        @endfor
                                                    </div>
                                                    <small class="text-muted">({{ $artist->total_ratings }})</small>
                                                @else
                                                    <small class="text-muted">No ratings yet</small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Artist Bio -->
                                    @if($artist->bio)
                                        <p class="card-text text-muted small mb-3">
                                            {{ Str::limit($artist->bio, 100) }}
                                        </p>
                                    @endif

                                    <!-- Artist Stats -->
                                    <div class="row text-center mb-3">
                                        <div class="col-4">
                                            <div class="fw-bold text-success">{{ $artist->artworks_count }}</div>
                                            <small class="text-muted">Artworks</small>
                                        </div>
                                        <div class="col-4">
                                            <div class="fw-bold text-info">{{ $artist->artist_commissions_count }}</div>
                                            <small class="text-muted">Commissions</small>
                                        </div>
                                        <div class="col-4">
                                            <div class="fw-bold text-warning">{{ $artist->average_rating > 0 ? $artist->average_rating : 'N/A' }}</div>
                                            <small class="text-muted">Rating</small>
                                        </div>
                                    </div>

                                    <!-- Artist Skills (from artworks) -->
                                    @if($artist->artworks->count() > 0)
                                        <div class="mb-3">
                                            <small class="text-muted d-block mb-1">Styles:</small>
                                            <div class="d-flex flex-wrap gap-1">
                                                @foreach($artist->artworks->take(3)->pluck('category')->unique() as $category)
                                                    <span class="badge bg-light text-dark border">{{ ucfirst($category) }}</span>
                                                @endforeach
                                                @if($artist->artworks->pluck('category')->unique()->count() > 3)
                                                    <span class="badge bg-light text-dark border">+{{ $artist->artworks->pluck('category')->unique()->count() - 3 }} more</span>
                                                @endif
                                            </div>
                                        </div>
                                    @endif

                                    <!-- View Profile Button -->
                                    <div class="d-grid">
                                        <a href="{{ route('artists.show', $artist) }}" class="btn btn-outline-success btn-sm">
                                            <i class="fas fa-eye me-2"></i>View Profile
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $artists->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-search fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">No artists found</h4>
                    <p class="text-muted">Try adjusting your filters or search terms.</p>
                    <a href="{{ route('artists.index') }}" class="btn btn-success">
                        <i class="fas fa-times me-2"></i>Clear All Filters
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Auto-submit sidebar selects
    document.querySelectorAll('#artistFilters select').forEach(select => {
        select.addEventListener('change', function() {
            document.getElementById('artistFilters').submit();
        });
    });
</script>
@endpush 