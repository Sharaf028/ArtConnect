@extends('layouts.app')
@section('title', 'Job Inbox - ArtConnect')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <!-- Page Header -->
            <div class="mb-4">
                <h1 class="h3 mb-2"><i class="fas fa-inbox me-2"></i>Job Inbox</h1>
                <p class="text-muted mb-4">Manage your commission requests and active projects</p>
            </div>
            
            <!-- Stats Overview -->
            <div class="row mb-4">
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm text-center h-100">
                        <div class="card-body">
                            <i class="fas fa-clock text-warning fs-2 mb-3"></i>
                            <h5 class="card-title">Pending</h5>
                            <h2 class="card-text text-warning fw-bold">{{ $pendingCommissions->total() }}</h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm text-center h-100">
                        <div class="card-body">
                            <i class="fas fa-paint-brush text-primary fs-2 mb-3"></i>
                            <h5 class="card-title">Active</h5>
                            <h2 class="card-text text-primary fw-bold">{{ $acceptedCommissions->total() }}</h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm text-center h-100">
                        <div class="card-body">
                            <i class="fas fa-star text-success fs-2 mb-3"></i>
                            <h5 class="card-title">Completed</h5>
                            <h2 class="card-text text-success fw-bold">{{ auth()->user()->completedCommissions ?? 0 }}</h2>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Commissions -->
            @if($pendingCommissions->count() > 0)
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-clock me-2"></i>
                        Pending Commissions ({{ $pendingCommissions->total() }})
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach($pendingCommissions as $commission)
                        <div class="col-12">
                            <div class="card border">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <div class="d-flex align-items-center mb-3">
                                                <img src="{{ $commission->client->profile_picture_url }}" 
                                                     alt="{{ $commission->client->name }}" 
                                                     class="rounded-circle me-3" width="40" height="40" style="object-fit: cover;">
                                                <div>
                                                    <h6 class="mb-1">{{ $commission->client->name }}</h6>
                                                    <small class="text-muted">{{ $commission->created_at->diffForHumans() }}</small>
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
                                                    <strong class="small text-muted">Budget:</strong>
                                                    <p class="small mb-0">{{ $commission->budget_range ?? 'Not specified' }}</p>
                                                </div>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <strong class="small text-muted">Description:</strong>
                                                <p class="small mb-0">{{ Str::limit($commission->description, 150) }}</p>
                                            </div>
                                            
                                            @if($commission->references)
                                            <div>
                                                <strong class="small text-muted">References:</strong>
                                                <p class="small mb-0">{{ Str::limit($commission->references, 100) }}</p>
                                            </div>
                                            @endif
                                        </div>
                                        
                                        <div class="col-lg-4">
                                            <div class="d-flex flex-column gap-2">
                                                <a href="{{ route('commissions.show', $commission) }}" 
                                                   class="btn btn-primary btn-sm">
                                                    <i class="fas fa-eye me-2"></i>View Details
                                                </a>
                                                
                                                <button onclick="openAcceptModal({{ $commission->id }})" 
                                                        class="btn btn-success btn-sm">
                                                    <i class="fas fa-check me-2"></i>Accept
                                                </button>
                                                
                                                <button onclick="openRejectModal({{ $commission->id }})" 
                                                        class="btn btn-danger btn-sm">
                                                    <i class="fas fa-times me-2"></i>Reject
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <!-- Pagination -->
                    @if($pendingCommissions->hasPages())
                    <div class="mt-4">
                        {{ $pendingCommissions->links() }}
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Active Commissions -->
            @if($acceptedCommissions->count() > 0)
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-paint-brush me-2"></i>
                        Active Commissions ({{ $acceptedCommissions->total() }})
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach($acceptedCommissions as $commission)
                        <div class="col-12">
                            <div class="card border">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <div class="d-flex align-items-center mb-3">
                                                <img src="{{ $commission->client->profile_picture_url }}" 
                                                     alt="{{ $commission->client->name }}" 
                                                     class="rounded-circle me-3" width="40" height="40" style="object-fit: cover;">
                                                <div>
                                                    <h6 class="mb-1">{{ $commission->client->name }}</h6>
                                                    <small class="text-muted">
                                                        Accepted {{ $commission->accepted_at->diffForHumans() }}
                                                    </small>
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
                                                    <strong class="small text-muted">Price:</strong>
                                                    <p class="small mb-0">${{ number_format($commission->price, 2) }}</p>
                                                </div>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <strong class="small text-muted">Status:</strong>
                                                <span class="badge 
                                                    @if($commission->status === 'accepted') bg-success
                                                    @else bg-primary
                                                    @endif">
                                                    {{ ucfirst(str_replace('_', ' ', $commission->status)) }}
                                                </span>
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-4">
                                            <div class="d-flex flex-column gap-2">
                                                <a href="{{ route('commissions.show', $commission) }}" 
                                                   class="btn btn-primary btn-sm">
                                                    <i class="fas fa-eye me-2"></i>View Details
                                                </a>
                                                
                                                @if($commission->status === 'accepted')
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
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <!-- Pagination -->
                    @if($acceptedCommissions->hasPages())
                    <div class="mt-4">
                        {{ $acceptedCommissions->links() }}
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Empty State -->
            @if($pendingCommissions->count() === 0 && $acceptedCommissions->count() === 0)
            <div class="card shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="fas fa-inbox text-muted display-1 mb-4"></i>
                    <h3 class="h5 mb-2">No Commissions Yet</h3>
                    <p class="text-muted mb-4">You haven't received any commission requests yet. Keep building your portfolio to attract clients!</p>
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
                        <label for="price" class="form-label">Agreed Price ($)</label>
                        <input type="number" name="price" id="price" step="0.01" min="0" required class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="artist_message" class="form-label">Message to Client</label>
                        <textarea name="artist_message" id="artist_message" rows="4"
                                  placeholder="Provide details about how you'll approach this project, timeline, and any questions (optional)..."
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
</script>

@endsection
