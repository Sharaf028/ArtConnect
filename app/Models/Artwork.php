<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artwork extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'description', 'image', 'category',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(ArtworkLike::class);
    }

    public function isLikedBy($user)
    {
        if (!$user) return false;
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    public function getLikesCountAttribute()
    {
        return $this->likes()->count();
    }

    public function ratings()
    {
        return $this->hasMany(ArtworkRating::class);
    }

    public function getAverageRatingAttribute()
    {
        $ratings = $this->ratings();
        if ($ratings->count() === 0) {
            return 0;
        }
        return round($ratings->avg('rating'), 1);
    }

    public function getRatingsCountAttribute()
    {
        return $this->ratings()->count();
    }

    public function favorites()
    {
        return $this->hasMany(ArtworkFavorite::class);
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites()->count();
    }

    public function isFavoritedBy($user)
    {
        if (!$user) return false;
        return $this->favorites()->where('user_id', $user->id)->exists();
    }
}
