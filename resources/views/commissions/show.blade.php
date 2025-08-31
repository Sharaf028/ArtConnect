@extends('layouts.app')
@section('title', 'Commission Details - ArtConnect')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <!-- Page Header -->
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('commissions.index') }}" class="btn btn-outline-secondary me-3">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h1 class="h3 mb-0">Commission Details</h1>
            </div>
            
            <!-- Status Banner -->
            <div class="mb-4">
                @if($commission->status === 'pending')
                    <div class="alert alert-warning border-warning">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-clock fs-4 me-3 text-warning"></i>
                            <div>
                                <h5 class="mb-1">Pending Response</h5>
                                <p class="mb-0">Waiting for the artist to review your request.</p>
                            </div>
                        </div>
                    </div>
                @elseif($commission->status === 'accepted')
                    <div class="alert alert-success border-success">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle fs-4 me-3 text-success"></i>
                            <div>
                                <h5 class="mb-1">Commission Accepted</h5>
                                <p class="mb-0">The artist has accepted your commission request!</p>
                            </div>
                        </div>
                    </div>
                @elseif($commission->status === 'in_progress')
                    <div class="alert alert-info border-info">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-paint-brush fs-4 me-3 text-info"></i>
                            <div>
                                <h5 class="mb-1">Work in Progress</h5>
                                <p class="mb-0">The artist is currently working on your commission.</p>
                            </div>
                        </div>
                    </div>
                @elseif($commission->status === 'completed')
                    <div class="alert alert-secondary border-secondary">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-star fs-4 me-3 text-secondary"></i>
                            <div>
                                <h5 class="mb-1">Commission Completed</h5>
                                <p class="mb-0">Your commission is ready! Please review and rate the work.</p>
                            </div>
                        </div>
                    </div>
                @elseif($commission->status === 'rejected')
                    <div class="alert alert-danger border-danger">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-times-circle fs-4 me-3 text-danger"></i>
                            <div>
                                <h5 class="mb-1">Commission Rejected</h5>
                                <p class="mb-0">The artist has declined this commission request.</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="row">
                <!-- Main Commission Details -->
                <div class="col-lg-8">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h3 class="card-title mb-4">Project Details</h3>
                            
                            <div class="row mb-4">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-medium text-muted">Work Type</label>
                                    <p class="mb-0">{{ ucfirst(str_replace('_', ' ', $commission->work_type)) }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-medium text-muted">Deadline</label>
                                    <p class="mb-0">
                                        {{ $commission->deadline->format('M d, Y') }}
                                        @if($commission->is_overdue ?? false)
                                            <span class="text-danger ms-2">(Overdue)</span>
                                        @else
                                            <span class="text-muted ms-2">({{ $commission->days_until_deadline ?? 'N/A' }} days left)</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-medium text-muted">Budget Range</label>
                                    <p class="mb-0">{{ $commission->budget_range ?? 'Not specified' }}</p>
                                </div>
                                @if($commission->price)
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-medium text-muted">Agreed Price</label>
                                    <p class="mb-0">${{ number_format($commission->price, 2) }}</p>
                                </div>
                                @endif
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-medium text-muted">Project Description</label>
                                <div class="bg-light rounded p-3">
                                    <p class="mb-0 white-space-pre-wrap">{{ $commission->description }}</p>
                                </div>
                            </div>

                            @if($commission->references)
                            <div class="mb-4">
                                <label class="form-label fw-medium text-muted">References & Inspiration</label>
                                <div class="bg-light rounded p-3">
                                    <p class="mb-0 white-space-pre-wrap">{{ $commission->references }}</p>
                                </div>
                            </div>
                            @endif

                            @if($commission->artist_message)
                            <div class="mb-4">
                                <label class="form-label fw-medium text-muted">Artist's Response</label>
                                <div class="alert alert-info border-info">
                                    <p class="mb-0 white-space-pre-wrap">{{ $commission->artist_message }}</p>
                                </div>
                            </div>
                            @endif

                            @if($commission->client_message)
                            <div class="mb-4">
                                <label class="form-label fw-medium text-muted">Client's Message</label>
                                <div class="alert alert-success border-success">
                                    <p class="mb-0 white-space-pre-wrap">{{ $commission->client_message }}</p>
                                </div>
                            </div>
                            @endif

                            @if($commission->rating)
                            <div class="mb-4">
                                <label class="form-label fw-medium text-muted">Rating & Review</label>
                                <div class="alert alert-warning border-warning">
                                    <div class="d-flex align-items-center mb-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $commission->rating)
                                                <i class="fas fa-star text-warning"></i>
                                            @else
                                                <i class="far fa-star text-warning"></i>
                                            @endif
                                        @endfor
                                        <span class="ms-2 small text-muted">{{ $commission->rating }}/5</span>
                                    </div>
                                    <p class="mb-0">{{ $commission->review }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar - Actions & Info -->
                <div class="col-lg-4">
                    
                    <!-- Commission Info Card -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Commission Info</h4>
                            
                            <div class="mb-3">
                                <strong class="text-muted">Status:</strong>
                                <span class="ms-2 badge 
                                    @if($commission->status === 'pending') bg-warning text-dark
                                    @elseif($commission->status === 'accepted') bg-success
                                    @elseif($commission->status === 'in_progress') bg-info
                                    @elseif($commission->status === 'completed') bg-secondary
                                    @elseif($commission->status === 'rejected') bg-danger
                                    @else bg-light text-dark
                                    @endif">
                                    {{ ucfirst(str_replace('_', ' ', $commission->status)) }}
                                </span>
                            </div>
                            
                            <div class="mb-3">
                                <strong class="text-muted">Created:</strong>
                                <span class="ms-2">{{ $commission->created_at->format('M d, Y') }}</span>
                            </div>
                            
                            @if($commission->accepted_at)
                            <div class="mb-3">
                                <strong class="text-muted">Accepted:</strong>
                                <span class="ms-2">{{ $commission->accepted_at->format('M d, Y') }}</span>
                            </div>
                            @endif
                            
                            @if($commission->completed_at)
                            <div class="mb-3">
                                <strong class="text-muted">Completed:</strong>
                                <span class="ms-2">{{ $commission->completed_at->format('M d, Y') }}</span>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Actions</h4>
                            
                            @if(auth()->id() === $commission->artist_id)
                                <!-- Artist Actions -->
                                @if($commission->status === 'pending')
                                    <button type="button" onclick="openAcceptModal()" 
                                            class="btn btn-success w-100 mb-2">
                                        <i class="fas fa-check me-2"></i>Accept Commission
                                    </button>
                                    <button type="button" onclick="openRejectModal()" 
                                            class="btn btn-danger w-100 mb-2">
                                        <i class="fas fa-times me-2"></i>Reject Commission
                                    </button>
                                @elseif($commission->status === 'accepted')
                                    <form method="POST" action="{{ route('commissions.start-work', $commission) }}" class="w-100 mb-2">
                                        @csrf
                                        <button type="submit" class="btn btn-info w-100">
                                            <i class="fas fa-paint-brush me-2"></i>Start Work
                                        </button>
                                    </form>
                                @elseif($commission->status === 'in_progress')
                                    <form method="POST" action="{{ route('commissions.complete', $commission) }}" class="w-100 mb-2">
                                        @csrf
                                        <button type="submit" class="btn btn-secondary w-100">
                                            <i class="fas fa-check-double me-2"></i>Mark as Completed
                                        </button>
                                    </form>
                                @endif
                            @else
                                <!-- Client Actions -->
                                @if($commission->status === 'pending')
                                    <form method="POST" action="{{ route('commissions.cancel', $commission) }}" class="w-100 mb-2">
                                        @csrf
                                        <button type="submit" class="btn btn-danger w-100">
                                            <i class="fas fa-times me-2"></i>Cancel Request
                                        </button>
                                    </form>
                                @elseif($commission->status === 'completed' && !$commission->rating)
                                    <button type="button" onclick="openRatingModal()" 
                                            class="btn btn-warning w-100 mb-2">
                                        <i class="fas fa-star me-2"></i>Rate & Review
                                    </button>
                                @endif
                            @endif
                            
                            <a href="{{ route('commissions.index') }}" class="btn btn-outline-secondary w-100">
                                <i class="fas fa-arrow-left me-2"></i>Back to Commissions
                            </a>
                        </div>
                    </div>
                </div>
            </div>
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
            <form method="POST" action="{{ route('commissions.accept', $commission) }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="price" class="form-label">Agreed Price ($)</label>
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
            <form method="POST" action="{{ route('commissions.reject', $commission) }}">
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
            <form method="POST" action="{{ route('commissions.confirm-completion', $commission) }}">
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
    function openAcceptModal() {
        new bootstrap.Modal(document.getElementById('acceptModal')).show();
    }
    
    function openRejectModal() {
        new bootstrap.Modal(document.getElementById('rejectModal')).show();
    }
    
    function openRatingModal() {
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
