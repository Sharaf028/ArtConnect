<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'artist_id',
        'artwork_id',
        'status',
        'price',
        'description',
        'rating',
        'review',
    ];

    /**
     * Get the client who commissioned the work.
     */
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    /**
     * Get the artist who was commissioned.
     */
    public function artist()
    {
        return $this->belongsTo(User::class, 'artist_id');
    }

    /**
     * Get the artwork that was commissioned.
     */
    public function artwork()
    {
        return $this->belongsTo(Artwork::class);
    }
}
