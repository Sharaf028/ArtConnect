<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Sent Commission Requests') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Header with Actions -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                Sent Commission Requests
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Track all commission requests you've sent to artists
                            </p>
                        </div>
                        
                        <div class="flex space-x-3">
                            <a href="{{ route('commissions.index') }}" 
                               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition duration-150">
                                <i class="fas fa-list mr-2"></i>All Commissions
                            </a>
                            <a href="{{ route('artists.index') }}" 
                               class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-md transition duration-150">
                                <i class="fas fa-search mr-2"></i>Find Artists
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-clock text-yellow-500 text-2xl"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Pending</h3>
                                <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">
                                    {{ $sentCommissions->where('status', 'pending')->count() }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle text-green-500 text-2xl"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Accepted</h3>
                                <p class="text-2xl font-bold text-green-600 dark:text-green-400">
                                    {{ $sentCommissions->where('status', 'accepted')->count() }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-paint-brush text-blue-500 text-2xl"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">In Progress</h3>
                                <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                                    {{ $sentCommissions->where('status', 'in_progress')->count() }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-star text-purple-500 text-2xl"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Completed</h3>
                                <p class="text-2xl font-bold text-purple-600 dark:text-purple-400">
                                    {{ $sentCommissions->where('status', 'completed')->count() }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sent Commissions List -->
            @if($sentCommissions->count() > 0)
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="space-y-4">
                        @foreach($sentCommissions as $commission)
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-3 mb-3">
                                        <img src="{{ $commission->artist->profile_picture_url }}" 
                                             alt="{{ $commission->artist->name }}" 
                                             class="w-12 h-12 rounded-full object-cover">
                                        <div>
                                            <h4 class="font-medium text-gray-900 dark:text-white">{{ $commission->artist->name }}</h4>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Artist</p>
                                        </div>
                                        
                                        <div class="ml-auto">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                @if($commission->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                                @elseif($commission->status === 'accepted') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                                @elseif($commission->status === 'in_progress') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                                @elseif($commission->status === 'completed') bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200
                                                @elseif($commission->status === 'rejected') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                                @elseif($commission->status === 'cancelled') bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200
                                                @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200
                                                @endif">
                                                {{ ucfirst(str_replace('_', ' ', $commission->status)) }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-3">
                                        <div>
                                            <span class="text-sm text-gray-500 dark:text-gray-400">Work Type:</span>
                                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ ucfirst(str_replace('_', ' ', $commission->work_type)) }}</p>
                                        </div>
                                        <div>
                                            <span class="text-sm text-gray-500 dark:text-gray-400">Deadline:</span>
                                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $commission->deadline->format('M d, Y') }}
                                                @if($commission->is_overdue)
                                                    <span class="text-red-600 dark:text-red-400 ml-1">(Overdue)</span>
                                                @else
                                                    <span class="text-gray-500 dark:text-gray-400 ml-1">({{ $commission->days_until_deadline }} days left)</span>
                                                @endif
                                            </p>
                                        </div>
                                        <div>
                                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $commission->price ? 'Price:' : 'Budget:' }}
                                            </span>
                                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                                @if($commission->price)
                                                    ${{ number_format($commission->price, 2) }}
                                                @else
                                                    {{ $commission->budget_range }}
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <span class="text-sm text-gray-500 dark:text-gray-400">Description:</span>
                                        <p class="text-sm text-gray-900 dark:text-white line-clamp-2">{{ Str::limit($commission->description, 200) }}</p>
                                    </div>
                                    
                                    <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400">
                                        <span>Sent {{ $commission->created_at->diffForHumans() }}</span>
                                        @if($commission->accepted_at)
                                            <span>Accepted {{ $commission->accepted_at->diffForHumans() }}</span>
                                        @endif
                                        @if($commission->completed_at)
                                            <span>Completed {{ $commission->completed_at->diffForHumans() }}</span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="flex flex-col space-y-2 ml-4">
                                    <a href="{{ route('commissions.show', $commission) }}" 
                                       class="inline-flex items-center px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md transition duration-150">
                                        <i class="fas fa-eye mr-2"></i>View Details
                                    </a>
                                    
                                    @if($commission->status === 'pending')
                                        <form method="POST" action="{{ route('commissions.cancel', $commission) }}" class="w-full">
                                            @csrf
                                            <button type="submit" 
                                                    onclick="return confirm('Are you sure you want to cancel this commission request?')"
                                                    class="inline-flex items-center px-3 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-md transition duration-150 w-full">
                                                <i class="fas fa-times mr-2"></i>Cancel Request
                                            </button>
                                        </form>
                                    @elseif($commission->status === 'completed' && !$commission->rating)
                                        <button onclick="openRatingModal({{ $commission->id }})" 
                                                class="inline-flex items-center px-3 py-2 bg-yellow-600 hover:bg-yellow-700 text-white text-sm font-medium rounded-md transition duration-150">
                                            <i class="fas fa-star mr-2"></i>Rate & Review
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <!-- Pagination -->
                    @if($sentCommissions->hasPages())
                    <div class="mt-6">
                        {{ $sentCommissions->links() }}
                    </div>
                    @endif
                </div>
            </div>
            @else
            <!-- Empty State -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-12 text-center">
                    <i class="fas fa-paper-plane text-gray-400 text-6xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No Commission Requests Sent</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-6">
                        You haven't sent any commission requests yet. Start by finding an artist you'd like to work with!
                    </p>
                    <a href="{{ route('artists.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition duration-150">
                        <i class="fas fa-search mr-2"></i>Browse Artists
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Rating Modal -->
    <div id="ratingModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Rate & Review Artist</h3>
                <form id="ratingForm" method="POST" class="space-y-4">
                    @csrf
                    <div>
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
                    <div>
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
        function openRatingModal(commissionId) {
            const form = document.getElementById('ratingForm');
            form.action = `/commissions/${commissionId}/confirm-completion`;
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
        
        // Close modal when clicking outside
        window.addEventListener('click', function(event) {
            if (event.target.classList.contains('fixed')) {
                event.target.classList.add('hidden');
            }
        });
    </script>
</x-app-layout>
