@extends('layouts.app')
@section('title', 'My Commissions - ArtConnect')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <!-- Page Header -->
            <div class="mb-4">
                <h1 class="h3 mb-2">{{ auth()->user()->role === 'artist' ? 'My Commissions' : 'My Hire Requests' }}</h1>
                <p class="text-muted mb-4">
                    {{ auth()->user()->role === 'artist' ? 'Track all your accepted commissions and their progress' : 'Monitor your commission requests and their status' }}
                </p>
            </div>
            
            <!-- Header with Actions -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h3 class="h5 mb-1">{{ auth()->user()->role === 'artist' ? 'My Commissions' : 'My Hire Requests' }}</h3>
                            <p class="text-muted mb-0 small">
                                {{ auth()->user()->role === 'artist' ? 'Track all your accepted commissions and their progress' : 'Monitor your commission requests and their status' }}
                            </p>
                        </div>
                        
                        <div class="d-flex gap-2">
                            <a href="{{ route('artists.index') }}" 
                               class="btn btn-success">
                                <i class="fas fa-search me-2"></i>Find Artists
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Overview -->
            <div class="row mb-4">
                <div class="col-md-3 mb-3">
                    <div class="card shadow-sm text-center h-100">
                        <div class="card-body">
                            <i class="fas fa-clock text-warning fs-2 mb-3"></i>
                            <h5 class="card-title">Pending</h5>
                            <h2 class="card-text text-warning fw-bold">
                                {{ $commissions->where('status', 'pending')->count() }}
                            </h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-3">
                    <div class="card shadow-sm text-center h-100">
                        <div class="card-body">
                            <i class="fas fa-check-circle text-success fs-2 mb-3"></i>
                            <h5 class="card-title">Accepted</h5>
                            <h2 class="card-text text-success fw-bold">
                                {{ $commissions->where('status', 'accepted')->count() }}
                            </h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-3">
                    <div class="card shadow-sm text-center h-100">
                        <div class="card-body">
                            <i class="fas fa-paint-brush text-primary fs-2 mb-3"></i>
                            <h5 class="card-title">In Progress</h5>
                            <h2 class="card-text text-primary fw-bold">
                                {{ $commissions->where('status', 'in_progress')->count() }}
                            </h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-3">
                    <div class="card shadow-sm text-center h-100">
                        <div class="card-body">
                            <i class="fas fa-star text-secondary fs-2 mb-3"></i>
                            <h5 class="card-title">Completed</h5>
                            <h2 class="card-text text-secondary fw-bold">
                                {{ $commissions->where('status', 'completed')->count() }}
                            </h2>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Commissions List -->
            @if($commissions->count() > 0)
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-4">Commission Requests</h5>
                    <div class="row g-3">
                        @foreach($commissions as $commission)
                        <div class="col-12">
                            <div class="card border">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <div class="d-flex align-items-center mb-3">
                                                @if(auth()->user()->role === 'artist')
                                                    <img src="{{ $commission->client->profile_picture_url }}" 
                                                         alt="{{ $commission->client->name }}" 
                                                         class="rounded-circle me-3" width="50" height="50" style="object-fit: cover;">
                                                    <div>
                                                        <h6 class="mb-1">{{ $commission->client->name }}</h6>
                                                        <small class="text-muted">Client</small>
                                                    </div>
                                                @else
                                                    <img src="{{ $commission->artist->profile_picture_url }}" 
                                                         alt="{{ $commission->artist->name }}" 
                                                         class="rounded-circle me-3" width="50" height="50" style="object-fit: cover;">
                                                    <div>
                                                        <h6 class="mb-1">{{ $commission->artist->name }}</h6>
                                                        <small class="text-muted">Artist</small>
                                                    </div>
                                                @endif
                                                
                                                <div class="ms-auto">
                                                    <span class="badge 
                                                        @if($commission->status === 'pending') bg-warning text-dark
                                                        @elseif($commission->status === 'accepted') bg-success
                                                        @elseif($commission->status === 'in_progress') bg-primary
                                                        @elseif($commission->status === 'completed') bg-secondary
                                                        @elseif($commission->status === 'rejected') bg-danger
                                                        @else bg-light text-dark
                                                        @endif">
                                                        {{ ucfirst(str_replace('_', ' ', $commission->status)) }}
                                                    </span>
                                                </div>
                                            </div>
                                    
                                            <div class="row mb-3">
                                                <div class="col-md-4 mb-2">
                                                    <strong class="small text-muted">Work Type:</strong>
                                                    <p class="small mb-0">{{ ucfirst(str_replace('_', ' ', $commission->work_type)) }}</p>
                                                </div>
                                                <div class="col-md-4 mb-2">
                                                    <strong class="small text-muted">Deadline:</strong>
                                                    <p class="small mb-0">
                                                        {{ $commission->deadline->format('M d, Y') }}
                                                        @if($commission->is_overdue ?? false)
                                                            <span class="text-danger ms-1">(Overdue)</span>
                                                        @else
                                                            <span class="text-muted ms-1">({{ $commission->days_until_deadline ?? 'N/A' }} days left)</span>
                                                        @endif
                                                    </p>
                                                </div>
                                                <div class="col-md-4 mb-2">
                                                    <strong class="small text-muted">
                                                        {{ $commission->price ? 'Price:' : 'Budget:' }}
                                                    </strong>
                                                    <p class="small mb-0">
                                                        @if($commission->price)
                                                            BDT {{ number_format($commission->price, 2) }}
                                                        @else
                                                            {{ $commission->budget_range ?? 'Not specified' }}
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <strong class="small text-muted">Description:</strong>
                                                <p class="small mb-0">{{ Str::limit($commission->description, 200) }}</p>
                                            </div>
                                            
                                            <div class="d-flex flex-wrap gap-3 small text-muted">
                                                <span>Created {{ $commission->created_at->diffForHumans() }}</span>
                                                @if($commission->accepted_at)
                                                    <span>Accepted {{ $commission->accepted_at->diffForHumans() }}</span>
                                                @endif
                                                @if($commission->completed_at)
                                                    <span>Completed {{ $commission->completed_at->diffForHumans() }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-4">
                                            <div class="d-flex flex-column gap-2">
                                                <a href="{{ route('commissions.show', $commission) }}" 
                                                   class="btn btn-primary btn-sm">
                                                    <i class="fas fa-eye me-2"></i>View Details
                                                </a>
                                                
                                                @if(auth()->user()->role === 'artist')
                                                    @if($commission->status === 'pending')
                                                        <button onclick="openAcceptModal({{ $commission->id }})" 
                                                                class="btn btn-success btn-sm">
                                                            <i class="fas fa-check me-2"></i>Accept
                                                        </button>
                                                        <button onclick="openRejectModal({{ $commission->id }})" 
                                                                class="btn btn-danger btn-sm">
                                                            <i class="fas fa-times me-2"></i>Reject
                                                        </button>
                                                    @elseif($commission->status === 'accepted')
                                                        <form method="POST" action="{{ route('commissions.start-work', $commission) }}">
                                                            @csrf
                                                            <button type="submit" class="btn btn-info btn-sm w-100">
                                                                <i class="fas fa-paint-brush me-2"></i>Start Work
                                                            </button>
                                                        </form>
                                                    @elseif($commission->status === 'in_progress')
                                                        <form method="POST" action="{{ route('commissions.complete', $commission) }}">
                                                            @csrf
                                                            <button type="submit" class="btn btn-secondary btn-sm w-100">
                                                                <i class="fas fa-check-double me-2"></i>Mark Complete
                                                            </button>
                                                        </form>
                                                    @endif
                                                @else
                                                    @if($commission->status === 'pending')
                                                        <form method="POST" action="{{ route('commissions.cancel', $commission) }}">
                                                            @csrf
                                                            <button type="submit" class="btn btn-danger btn-sm w-100">
                                                                <i class="fas fa-times me-2"></i>Cancel
                                                            </button>
                                                        </form>
                                                    @elseif($commission->status === 'completed' && !$commission->rating)
                                                        <button onclick="openRatingModal({{ $commission->id }})" 
                                                                class="btn btn-warning btn-sm w-100">
                                                            <i class="fas fa-star me-2"></i>Rate & Review
                                                        </button>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <!-- Pagination -->
                    @if($commissions->hasPages())
                    <div class="mt-4">
                        {{ $commissions->links() }}
                    </div>
                    @endif
                </div>
            </div>
            @else
            <!-- Empty State -->
            <div class="card shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="fas fa-folder-open text-muted display-1 mb-4"></i>
                    <h3 class="h5 mb-2">No Commissions Yet</h3>
                    <p class="text-muted mb-4">
                        @if(auth()->user()->role === 'artist')
                            You haven't received any commission requests yet. Keep building your portfolio to attract clients!
                        @else
                            You haven't sent any commission requests yet. Start by finding an artist you'd like to work with!
                        @endif
                    </p>
                    <a href="{{ route('artists.index') }}" 
                       class="btn btn-primary">
                        <i class="fas fa-search me-2"></i>Browse Artists
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Accept Commission Modal -->
<div class="modal fade" id="acceptModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Accept Commission</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="acceptForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="price" class="form-label">Agreed Price (BDT)</label>
                        <input type="number" name="price" id="price" step="0.01" min="0" required class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="artist_message" class="form-label">Message to Client</label>
                        <textarea name="artist_message" id="artist_message" rows="4" required
                                  placeholder="Provide details about how you'll approach this project, timeline, and any questions..."
                                  class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Accept Commission</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reject Commission Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reject Commission</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="rejectForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="reject_message" class="form-label">Reason for Rejection</label>
                        <textarea name="artist_message" id="reject_message" rows="4" required
                                  placeholder="Please provide a reason for rejecting this commission..."
                                  class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject Commission</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Rating Modal -->
<div class="modal fade" id="ratingModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Rate & Review Artist</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="ratingForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Rating</label>
                        <div class="d-flex gap-2">
                            @for($i = 1; $i <= 5; $i++)
                                <input type="radio" name="rating" value="{{ $i }}" id="rating_{{ $i }}" class="d-none" required>
                                <label for="rating_{{ $i }}" class="rating-star fs-3 text-muted" style="cursor: pointer;">
                                    <i class="far fa-star"></i>
                                </label>
                            @endfor
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="review" class="form-label">Review</label>
                        <textarea name="review" id="review" rows="4" required
                                  placeholder="Share your experience working with this artist..."
                                  class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">Submit Review</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openAcceptModal(commissionId) {
        const form = document.getElementById('acceptForm');
        form.action = `/commissions/${commissionId}/accept`;
        new bootstrap.Modal(document.getElementById('acceptModal')).show();
    }
    
    function openRejectModal(commissionId) {
        const form = document.getElementById('rejectForm');
        form.action = `/commissions/${commissionId}/reject`;
        new bootstrap.Modal(document.getElementById('rejectModal')).show();
    }
    
    function openRatingModal(commissionId) {
        const form = document.getElementById('ratingForm');
        form.action = `/commissions/${commissionId}/confirm-completion`;
        new bootstrap.Modal(document.getElementById('ratingModal')).show();
    }
    
    // Star rating interaction
    document.querySelectorAll('input[name="rating"]').forEach(input => {
        input.addEventListener('change', function() {
            const rating = parseInt(this.value);
            document.querySelectorAll('.rating-star').forEach((star, index) => {
                const icon = star.querySelector('i');
                if (index < rating) {
                    icon.classList.remove('far');
                    icon.classList.add('fas');
                    icon.classList.add('text-warning');
                    icon.classList.remove('text-muted');
                } else {
                    icon.classList.remove('fas');
                    icon.classList.remove('text-warning');
                    icon.classList.add('far');
                    icon.classList.add('text-muted');
                }
            });
        });
    });
</script>

@endsection
