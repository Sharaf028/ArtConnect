<?php

namespace App\Http\Controllers;

use App\Models\Commission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CommissionController extends Controller
{
    /**
     * Show the commission request form
     */
    public function create(User $artist)
    {
        if ($artist->role !== 'artist') {
            abort(404);
        }

        if (!Auth::user()->is_available && Auth::user()->role === 'artist') {
            return redirect()->back()->with('error', 'This artist is not currently available for new commissions.');
        }

        return view('commissions.create', compact('artist'));
    }

    /**
     * Store a new commission request
     */
    public function store(Request $request, User $artist)
    {
        if ($artist->role !== 'artist') {
            abort(404);
        }

        $validated = $request->validate([
            'work_type' => 'required|string|max:255',
            'deadline' => 'required|date|after:today',
            'budget_min' => 'nullable|numeric|min:0',
            'budget_max' => 'nullable|numeric|min:0|gte:budget_min',
            'description' => 'required|string|min:10',
            'references' => 'nullable|string|max:1000',
        ]);

        $commission = Commission::create([
            'client_id' => Auth::id(),
            'artist_id' => $artist->id,
            'work_type' => $validated['work_type'],
            'deadline' => $validated['deadline'],
            'budget_min' => $validated['budget_min'],
            'budget_max' => $validated['budget_max'],
            'description' => $validated['description'],
            'references' => $validated['references'],
            'status' => Commission::STATUS_PENDING,
        ]);

        return redirect()->route('commissions.show', $commission)
            ->with('success', 'Commission request sent successfully! The artist will review and respond soon.');
    }

    /**
     * Display the commission details
     */
    public function show(Commission $commission)
    {
        // Check if user has access to this commission
        if (Auth::id() !== $commission->client_id && Auth::id() !== $commission->artist_id) {
            abort(403);
        }

        return view('commissions.show', compact('commission'));
    }

    /**
     * Show the artist's job inbox (pending commissions)
     */
    public function inbox()
    {
        $this->authorize('viewInbox');

        $pendingCommissions = Commission::where('artist_id', Auth::id())
            ->where('status', Commission::STATUS_PENDING)
            ->with('client')
            ->latest()
            ->paginate(10);

        $acceptedCommissions = Commission::where('artist_id', Auth::id())
            ->whereIn('status', [Commission::STATUS_ACCEPTED, Commission::STATUS_IN_PROGRESS])
            ->with('client')
            ->latest()
            ->paginate(10);

        return view('commissions.inbox', compact('pendingCommissions', 'acceptedCommissions'));
    }

    /**
     * Show the client's sent commissions
     */
    public function sent()
    {
        $this->authorize('viewSent');

        $sentCommissions = Commission::where('client_id', Auth::id())
            ->with('artist')
            ->latest()
            ->paginate(10);

        return view('commissions.sent', compact('sentCommissions'));
    }

    /**
     * Show all commissions for the authenticated user
     */
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role === 'artist') {
            $commissions = Commission::where('artist_id', $user->id)
                ->with('client')
                ->latest()
                ->paginate(15);
        } else {
            $commissions = Commission::where('client_id', $user->id)
                ->with('artist')
                ->latest()
                ->paginate(15);
        }

        return view('commissions.index', compact('commissions'));
    }

    /**
     * Artist accepts a commission
     */
    public function accept(Commission $commission)
    {
        $this->authorize('accept', $commission);

        $validated = request()->validate([
            'artist_message' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
        ]);

        $commission->update([
            'status' => Commission::STATUS_ACCEPTED,
            'accepted_at' => now(),
            'artist_message' => $validated['artist_message'],
            'price' => $validated['price'],
        ]);

        return redirect()->route('commissions.show', $commission)
            ->with('success', 'Commission accepted successfully!');
    }

    /**
     * Artist rejects a commission
     */
    public function reject(Commission $commission)
    {
        $this->authorize('reject', $commission);

        $validated = request()->validate([
            'artist_message' => 'required|string|min:10|max:1000',
        ]);

        $commission->update([
            'status' => Commission::STATUS_REJECTED,
            'artist_message' => $validated['artist_message'],
        ]);

        return redirect()->route('commissions.show', $commission)
            ->with('success', 'Commission rejected.');
    }

    /**
     * Artist marks commission as in progress
     */
    public function startWork(Commission $commission)
    {
        $this->authorize('startWork', $commission);

        $commission->update([
            'status' => Commission::STATUS_IN_PROGRESS,
        ]);

        return redirect()->route('commissions.show', $commission)
            ->with('success', 'Work started on commission!');
    }

    /**
     * Artist marks commission as completed
     */
    public function complete(Commission $commission)
    {
        $this->authorize('complete', $commission);

        $commission->update([
            'status' => Commission::STATUS_COMPLETED,
            'completed_at' => now(),
        ]);

        return redirect()->route('commissions.show', $commission)
            ->with('success', 'Commission marked as completed!');
    }

    /**
     * Client confirms completion and rates the artist
     */
    public function confirmCompletion(Request $request, Commission $commission)
    {
        $this->authorize('confirmCompletion', $commission);

        $validated = $request->validate([
            'rating' => 'required|integer|between:1,5',
            'review' => 'required|string|min:10|max:1000',
        ]);

        $commission->update([
            'rating' => $validated['rating'],
            'review' => $validated['review'],
        ]);

        return redirect()->route('commissions.show', $commission)
            ->with('success', 'Commission completed and artist rated!');
    }

    /**
     * Cancel a commission (only by client before acceptance)
     */
    public function cancel(Commission $commission)
    {
        $this->authorize('cancel', $commission);

        $commission->update([
            'status' => Commission::STATUS_CANCELLED,
        ]);

        return redirect()->route('commissions.index')
            ->with('success', 'Commission cancelled successfully.');
    }
}
