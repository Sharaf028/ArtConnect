<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArtworkRating extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'artwork_id',
        'rating',
        'comment',
    ];

    /**
     * Get the user who made the rating.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the artwork that was rated.
     */
    public function artwork()
    {
        return $this->belongsTo(Artwork::class);
    }
}
