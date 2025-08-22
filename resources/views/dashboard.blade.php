<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Welcome to ArtConnect!</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Browse Artists Card -->
                        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg p-6 text-white">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-xl font-semibold mb-2">Browse Artists</h4>
                                    <p class="text-green-100 mb-4">Find talented artists by style, skills, and ratings</p>
                                    <a href="{{ route('artists.index') }}" class="inline-flex items-center px-4 py-2 bg-white text-green-600 rounded-md hover:bg-green-50 transition-colors">
                                        <i class="fas fa-palette mr-2"></i>
                                        Browse Artists
                                    </a>
                                </div>
                                <div class="text-4xl text-green-200">
                                    <i class="fas fa-palette"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Gallery Card -->
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg p-6 text-white">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-xl font-semibold mb-2">Art Gallery</h4>
                                    <p class="text-blue-100 mb-4">Explore amazing artworks from our community</p>
                                    <a href="{{ route('gallery') }}" class="inline-flex items-center px-4 py-2 bg-white text-blue-600 rounded-md hover:bg-blue-50 transition-colors">
                                        <i class="fas fa-images mr-2"></i>
                                        View Gallery
                                    </a>
                                </div>
                                <div class="text-4xl text-blue-200">
                                    <i class="fas fa-images"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Profile Card -->
                        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg p-6 text-white">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-xl font-semibold mb-2">Your Profile</h4>
                                    <p class="text-purple-100 mb-4">Manage your profile and settings</p>
                                    <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-white text-purple-600 rounded-md hover:bg-purple-50 transition-colors">
                                        <i class="fas fa-user-edit mr-2"></i>
                                        Edit Profile
                                    </a>
                                </div>
                                <div class="text-4xl text-purple-200">
                                    <i class="fas fa-user"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(auth()->user()->role === 'artist')
                        <div class="mt-8 p-4 bg-green-50 border border-green-200 rounded-lg">
                            <h4 class="text-green-800 font-semibold mb-2">Artist Dashboard</h4>
                            <p class="text-green-700 mb-3">As an artist, you can upload artworks, manage your portfolio, and connect with clients.</p>
                            <a href="{{ route('artworks.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">
                                <i class="fas fa-plus mr-2"></i>
                                Upload New Artwork
                            </a>
                        </div>
                    @endif

                    @if(auth()->user()->role === 'client')
                        <div class="mt-8 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                            <h4 class="text-blue-800 font-semibold mb-2">Client Dashboard</h4>
                            <p class="text-blue-700 mb-3">As a client, you can browse artists, view portfolios, and request commissions.</p>
                            <a href="{{ route('artists.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                                <i class="fas fa-search mr-2"></i>
                                Find Artists
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
