<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artwork;
use App\Models\ArtworkLike;
use Illuminate\Support\Facades\Auth;

class ArtworkController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    // Show the artwork upload form (only for artists)
    public function create()
    {
        if (Auth::user()->role !== 'artist') {
            abort(403, 'Only artists can upload artworks.');
        }
        return view('artworks.create');
    }

    // Store the uploaded artwork
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'artist') {
            abort(403, 'Only artists can upload artworks.');
        }
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|in:digital,traditional,oil,watercolor,glass painting,sketches',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:4096',
        ]);
        $imagePath = $request->file('image')->store('artworks', 'public');
        Artwork::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'image' => $imagePath,
        ]);
        return redirect()->route('gallery')->with('success', 'Artwork uploaded successfully!');
    }

    // Display the gallery of artworks
    public function index(Request $request)
    {
        $query = Artwork::with('user');
        
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        
        if ($request->filled('artist')) {
            $query->where('user_id', $request->artist);
        }
        
        if ($request->filled('favorites') && auth()->check()) {
            $query->whereHas('favorites', function($q) {
                $q->where('user_id', auth()->id());
            });
        }
        
        $artworks = $query->latest()->paginate(12);
        return view('artworks.gallery', compact('artworks'));
    }

    // Show individual artwork details
    public function show(Artwork $artwork)
    {
        $artwork->load(['user', 'comments.user']);
        return view('artworks.show', compact('artwork'));
    }

    // Like an artwork
    public function like(Artwork $artwork)
    {
        $user = Auth::user();
        
        $existingLike = ArtworkLike::where('user_id', $user->id)
                                  ->where('artwork_id', $artwork->id)
                                  ->first();
        
        if ($existingLike) {
            // Unlike
            $existingLike->delete();
            return back()->with('success', 'Artwork unliked!');
        } else {
            // Like
            ArtworkLike::create([
                'user_id' => $user->id,
                'artwork_id' => $artwork->id
            ]);
            return back()->with('success', 'Artwork liked!');
        }
    }

    // Favorite an artwork
    public function favorite(Artwork $artwork)
    {
        $user = Auth::user();
        
        $existingFavorite = \App\Models\ArtworkFavorite::where('user_id', $user->id)
                                                      ->where('artwork_id', $artwork->id)
                                                      ->first();
        
        if ($existingFavorite) {
            // Remove from favorites
            $existingFavorite->delete();
            return back()->with('success', 'Removed from favorites!');
        } else {
            // Add to favorites
            \App\Models\ArtworkFavorite::create([
                'user_id' => $user->id,
                'artwork_id' => $artwork->id
            ]);
            return back()->with('success', 'Added to favorites!');
        }
    }
}
