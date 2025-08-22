<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArtworkFavorite extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'artwork_id',
    ];

    /**
     * Get the user who favorited the artwork.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the artwork that was favorited.
     */
    public function artwork()
    {
        return $this->belongsTo(Artwork::class);
    }
}
