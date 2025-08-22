<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\CommentLike;
use App\Models\Artwork;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $request->validate([
            'artwork_id' => 'required|exists:artworks,id',
            'content' => 'required|string|max:1000',
        ]);

        Comment::create([
            'user_id' => Auth::id(),
            'artwork_id' => $request->artwork_id,
            'content' => $request->content,
        ]);

        return back()->with('success', 'Comment added successfully!');
    }

    public function like($id)
    {
        $comment = Comment::findOrFail($id);
        $user = Auth::user();
        
        $existingLike = CommentLike::where('user_id', $user->id)
                                  ->where('comment_id', $comment->id)
                                  ->first();
        
        if ($existingLike) {
            // Unlike
            $existingLike->delete();
            return back()->with('success', 'Comment unliked!');
        } else {
            // Like
            CommentLike::create([
                'user_id' => $user->id,
                'comment_id' => $comment->id
            ]);
            return back()->with('success', 'Comment liked!');
        }
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        if (Auth::id() !== $comment->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $comment->delete();
        return back()->with('success', 'Comment deleted successfully!');
    }
}
