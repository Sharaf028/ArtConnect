<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artwork;
use Illuminate\Support\Facades\Auth;

class ArtworkController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index']);
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
        $query = Artwork::query();
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        $artworks = $query->latest()->paginate(12);
        return view('artworks.gallery', compact('artworks'));
    }
}
