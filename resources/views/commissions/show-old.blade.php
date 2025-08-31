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

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Main Commission Details -->
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Project Details</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Work Type</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ ucfirst(str_replace('_', ' ', $commission->work_type)) }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Deadline</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                        {{ $commission->deadline->format('M d, Y') }}
                                        @if($commission->is_overdue)
                                            <span class="text-red-600 dark:text-red-400 ml-2">(Overdue)</span>
                                        @else
                                            <span class="text-gray-500 dark:text-gray-400 ml-2">({{ $commission->days_until_deadline }} days left)</span>
                                        @endif
                                    </p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Budget Range</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $commission->budget_range }}</p>
                                </div>
                                @if($commission->price)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Agreed Price</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white">${{ number_format($commission->price, 2) }}</p>
                                </div>
                                @endif
                            </div>

                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Project Description</label>
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                    <p class="text-sm text-gray-900 dark:text-white whitespace-pre-wrap">{{ $commission->description }}</p>
                                </div>
                            </div>

                            @if($commission->references)
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">References & Inspiration</label>
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                    <p class="text-sm text-gray-900 dark:text-white whitespace-pre-wrap">{{ $commission->references }}</p>
                                </div>
                            </div>
                            @endif

                            @if($commission->artist_message)
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Artist's Response</label>
                                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                                    <p class="text-sm text-blue-900 dark:text-blue-100 whitespace-pre-wrap">{{ $commission->artist_message }}</p>
                                </div>
                            </div>
                            @endif

                            @if($commission->client_message)
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Client's Message</label>
                                <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
                                    <p class="text-sm text-green-900 dark:text-green-100 whitespace-pre-wrap">{{ $commission->client_message }}</p>
                                </div>
                            </div>
                            @endif

                            @if($commission->rating)
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Rating & Review</label>
                                <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
                                    <div class="flex items-center mb-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $commission->rating)
                                                <i class="fas fa-star text-yellow-500"></i>
                                            @else
                                                <i class="far fa-star text-yellow-500"></i>
                                            @endif
                                        @endfor
                                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ $commission->rating }}/5</span>
                                    </div>
                                    <p class="text-sm text-yellow-900 dark:text-yellow-100">{{ $commission->review }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar - Actions & Info -->
                <div class="lg:col-span-1">
                    
                    <!-- Commission Info Card -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Commission Info</h4>
                            
                            <div class="space-y-3">
                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Status:</span>
                                    <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($commission->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                        @elseif($commission->status === 'accepted') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                        @elseif($commission->status === 'in_progress') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                        @elseif($commission->status === 'completed') bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200
                                        @elseif($commission->status === 'rejected') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                        @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200
                                        @endif">
                                        {{ ucfirst(str_replace('_', ' ', $commission->status)) }}
                                    </span>
                                </div>
                                
                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Created:</span>
                                    <span class="ml-2 text-sm text-gray-900 dark:text-white">{{ $commission->created_at->format('M d, Y') }}</span>
                                </div>
                                
                                @if($commission->accepted_at)
                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Accepted:</span>
                                    <span class="ml-2 text-sm text-gray-900 dark:text-white">{{ $commission->accepted_at->format('M d, Y') }}</span>
                                </div>
                                @endif
                                
                                @if($commission->completed_at)
                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Completed:</span>
                                    <span class="ml-2 text-sm text-gray-900 dark:text-white">{{ $commission->completed_at->format('M d, Y') }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Actions</h4>
                            
                            <div class="space-y-3">
                                @if(auth()->id() === $commission->artist_id)
                                    <!-- Artist Actions -->
                                    @if($commission->status === 'pending')
                                        <button type="button" onclick="openAcceptModal()" 
                                                class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition duration-150">
                                            <i class="fas fa-check mr-2"></i>Accept Commission
                                        </button>
                                        <button type="button" onclick="openRejectModal()" 
                                                class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition duration-150">
                                            <i class="fas fa-times mr-2"></i>Reject Commission
                                        </button>
                                    @elseif($commission->status === 'accepted')
                                        <form method="POST" action="{{ route('commissions.start-work', $commission) }}" class="w-full">
                                            @csrf
                                            <button type="submit" 
                                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-150">
                                                <i class="fas fa-paint-brush mr-2"></i>Start Work
                                            </button>
                                        </form>
                                    @elseif($commission->status === 'in_progress')
                                        <form method="POST" action="{{ route('commissions.complete', $commission) }}" class="w-full">
                                            @csrf
                                            <button type="submit" 
                                                    class="w-full bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-4 rounded-lg transition duration-150">
                                                <i class="fas fa-check-double mr-2"></i>Mark as Completed
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    <!-- Client Actions -->
                                    @if($commission->status === 'pending')
                                        <form method="POST" action="{{ route('commissions.cancel', $commission) }}" class="w-full">
                                            @csrf
                                            <button type="submit" 
                                                    class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition duration-150">
                                                <i class="fas fa-times mr-2"></i>Cancel Request
                                            </button>
                                        </form>
                                    @elseif($commission->status === 'completed' && !$commission->rating)
                                        <button type="button" onclick="openRatingModal()" 
                                                class="w-full bg-yellow-600 hover:bg-yellow-700 text-white font-medium py-2 px-4 rounded-lg transition duration-150">
                                            <i class="fas fa-star mr-2"></i>Rate & Review
                                        </button>
                                    @endif
                                @endif
                                
                                <a href="{{ route('commissions.index') }}" 
                                   class="w-full bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition duration-150 inline-block text-center">
                                    <i class="fas fa-arrow-left mr-2"></i>Back to Commissions
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Accept Commission Modal -->
    <div id="acceptModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Accept Commission</h3>
                <form method="POST" action="{{ route('commissions.accept', $commission) }}">
                    @csrf
                    <div class="mb-4">
                        <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Agreed Price ($)</label>
                        <input type="number" name="price" id="price" step="0.01" min="0" required
                               class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    </div>
                    <div class="mb-4">
                        <label for="artist_message" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Message to Client</label>
                        <textarea name="artist_message" id="artist_message" rows="4" required
                                  placeholder="Provide details about how you'll approach this project, timeline, and any questions..."
                                  class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></textarea>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeAcceptModal()" 
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-lg transition duration-150">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition duration-150">
                            Accept Commission
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Reject Commission Modal -->
    <div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Reject Commission</h3>
                <form method="POST" action="{{ route('commissions.reject', $commission) }}">
                    @csrf
                    <div class="mb-4">
                        <label for="reject_message" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Reason for Rejection</label>
                        <textarea name="artist_message" id="reject_message" rows="4" required
                                  placeholder="Please provide a reason for rejecting this commission..."
                                  class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></textarea>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeRejectModal()" 
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-lg transition duration-150">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition duration-150">
                            Reject Commission
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Rating Modal -->
    <div id="ratingModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Rate & Review Artist</h3>
                <form method="POST" action="{{ route('commissions.confirm-completion', $commission) }}">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Rating</label>
                        <div class="flex space-x-2">
                            @for($i = 1; $i <= 5; $i++)
                                <input type="radio" name="rating" value="{{ $i }}" id="rating_{{ $i }}" class="hidden" required>
                                <label for="rating_{{ $i }}" class="cursor-pointer text-2xl text-gray-300 hover:text-yellow-400 transition-colors">
                                    <i class="far fa-star"></i>
                                </label>
                            @endfor
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="review" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Review</label>
                        <textarea name="review" id="review" rows="4" required
                                  placeholder="Share your experience working with this artist..."
                                  class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></textarea>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeRatingModal()" 
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-lg transition duration-150">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="bg-yellow-600 hover:bg-yellow-700 text-white font-medium py-2 px-4 rounded-lg transition duration-150">
                            Submit Review
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openAcceptModal() {
            document.getElementById('acceptModal').classList.remove('hidden');
        }
        
        function closeAcceptModal() {
            document.getElementById('acceptModal').classList.add('hidden');
        }
        
        function openRejectModal() {
            document.getElementById('rejectModal').classList.remove('hidden');
        }
        
        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
        }
        
        function openRatingModal() {
            document.getElementById('ratingModal').classList.remove('hidden');
        }
        
        function closeRatingModal() {
            document.getElementById('ratingModal').classList.add('hidden');
        }
        
        // Star rating interaction
        document.querySelectorAll('input[name="rating"]').forEach(input => {
            input.addEventListener('change', function() {
                const rating = parseInt(this.value);
                document.querySelectorAll('label[for^="rating_"] i').forEach((star, index) => {
                    if (index < rating) {
                        star.classList.remove('far');
                        star.classList.add('fas');
                        star.classList.add('text-yellow-400');
                    } else {
                        star.classList.remove('fas');
                        star.classList.remove('text-yellow-400');
                        star.classList.add('far');
                    }
                });
            });
        });
        
        // Close modals when clicking outside
        window.addEventListener('click', function(event) {
            if (event.target.classList.contains('fixed')) {
                event.target.classList.add('hidden');
            }
        });
    </script>
        </div>
    </div>
</div>

@endsection
