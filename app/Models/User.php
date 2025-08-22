<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'profile_picture',
        'bio',
        'is_available',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_available' => 'boolean',
    ];

    /**
     * Get the artworks for the user.
     */
    public function artworks()
    {
        return $this->hasMany(\App\Models\Artwork::class);
    }

    /**
     * Get the average rating for all user's artworks.
     */
    public function getAverageRatingAttribute()
    {
        $artworks = $this->artworks();
        if ($artworks->count() === 0) {
            return 0;
        }
        
        $totalRating = 0;
        $totalRatings = 0;
        
        foreach ($artworks->get() as $artwork) {
            $totalRating += $artwork->average_rating * $artwork->ratings_count;
            $totalRatings += $artwork->ratings_count;
        }
        
        if ($totalRatings === 0) {
            return 0;
        }
        
        return round($totalRating / $totalRatings, 1);
    }

    /**
     * Get the total number of ratings received.
     */
    public function getTotalRatingsAttribute()
    {
        return $this->artworks()->withCount('ratings')->get()->sum('ratings_count');
    }

    /**
     * Get commissions where this user is the artist.
     */
    public function artistCommissions()
    {
        return $this->hasMany(Commission::class, 'artist_id');
    }

    /**
     * Get commissions where this user is the client.
     */
    public function clientCommissions()
    {
        return $this->hasMany(Commission::class, 'client_id');
    }

    /**
     * Get completed commissions count.
     */
    public function getCompletedCommissionsAttribute()
    {
        return $this->artistCommissions()->where('status', 'completed')->count();
    }

    /**
     * Get average rating from completed commissions.
     */
    public function getCommissionAverageRatingAttribute()
    {
        $completedCommissions = $this->artistCommissions()->where('status', 'completed')->whereNotNull('rating');
        if ($completedCommissions->count() === 0) {
            return 0;
        }
        return round($completedCommissions->avg('rating'), 1);
    }

    /**
     * Get the user's favorite artworks.
     */
    public function favoriteArtworks()
    {
        return $this->hasMany(ArtworkFavorite::class);
    }

    /**
     * Get the count of favorite artworks.
     */
    public function getFavoritesCountAttribute()
    {
        return $this->favoriteArtworks()->count();
    }

    public function workExperiences()
    {
        return $this->hasMany(WorkExperience::class);
    }


    public function getProfilePictureUrlAttribute()
        {
            if ($this->profile_picture && Storage::disk('public')->exists($this->profile_picture)) {
                return asset('storage/' . $this->profile_picture);
            }
            
            // Return the same default profile picture for everyone
            return asset('images/default-user.png');
    }
}
