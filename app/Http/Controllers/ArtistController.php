<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Artwork;
use App\Models\WorkExperience;
use Illuminate\Support\Facades\DB;

class ArtistController extends Controller
{
    /**
     * Display a listing of artists with filtering options
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'artist')
            ->with(['artworks', 'workExperiences'])
            ->withCount(['artworks', 'artistCommissions']);

        // Filter by category (artwork style)
        if ($request->filled('category')) {
            $query->whereHas('artworks', function ($q) use ($request) {
                $q->where('category', $request->category);
            });
        }

        // Filter by skill (project type from work experience)
        if ($request->filled('skill')) {
            $query->whereHas('workExperiences', function ($q) use ($request) {
                $q->where('project_type', 'like', '%' . $request->skill . '%');
            });
        }

        // Filter by minimum rating
        if ($request->filled('min_rating')) {
            $query->whereHas('artworks', function ($q) use ($request) {
                $q->where('average_rating', '>=', $request->min_rating);
            });
        }

        // Filter by availability status
        if ($request->filled('availability')) {
            if ($request->availability === 'available') {
                $query->where('is_available', true);
            } elseif ($request->availability === 'unavailable') {
                $query->where('is_available', false);
            }
        }

        // Search by name or bio
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('bio', 'like', '%' . $search . '%');
            });
        }

        // Sort options
        $sortBy = $request->get('sort', 'name');
        $sortOrder = $request->get('order', 'asc');
        
        switch ($sortBy) {
            case 'rating':
                $query->orderBy(DB::raw('(SELECT AVG(average_rating) FROM artworks WHERE user_id = users.id)'), $sortOrder);
                break;
            case 'artworks':
                $query->orderBy('artworks_count', $sortOrder);
                break;
            case 'commissions':
                $query->orderBy('artist_commissions_count', $sortOrder);
                break;
            default:
                $query->orderBy('name', $sortOrder);
        }

        $artists = $query->paginate(12);

        // Get available categories and skills for filter options
        $categories = Artwork::distinct()->pluck('category')->sort();
        $skills = WorkExperience::distinct()->pluck('project_type')->filter()->sort();

        return view('artists.index', compact('artists', 'categories', 'skills'));
    }

    /**
     * Display the specified artist's profile
     */
    public function show(User $artist)
    {
        if ($artist->role !== 'artist') {
            abort(404);
        }

        $artist->load(['artworks', 'workExperiences', 'artistCommissions']);
        
        // Get artist statistics
        $stats = [
            'total_artworks' => $artist->artworks->count(),
            'average_rating' => $artist->average_rating,
            'total_ratings' => $artist->total_ratings,
            'completed_commissions' => $artist->completed_commissions,
            'commission_rating' => $artist->commission_average_rating,
        ];

        return view('artists.show', compact('artist', 'stats'));
    }
} 