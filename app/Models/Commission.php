<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Commission extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'artist_id',
        'work_type',
        'deadline',
        'budget_min',
        'budget_max',
        'description',
        'references',
        'status',
        'price',
        'rating',
        'review',
        'accepted_at',
        'completed_at',
        'artist_message',
        'client_message',
    ];

    protected $casts = [
        'deadline' => 'date',
        'accepted_at' => 'datetime',
        'completed_at' => 'datetime',
        'budget_min' => 'decimal:2',
        'budget_max' => 'decimal:2',
        'price' => 'decimal:2',
    ];

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_ACCEPTED = 'accepted';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_COMPLETED = 'completed';
    const STATUS_REJECTED = 'rejected';
    const STATUS_CANCELLED = 'cancelled';

    /**
     * Get the client who commissioned the work.
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    /**
     * Get the artist who was commissioned.
     */
    public function artist(): BelongsTo
    {
        return $this->belongsTo(User::class, 'artist_id');
    }

    /**
     * Get the artwork that was commissioned.
     */
    public function artwork(): BelongsTo
    {
        return $this->belongsTo(Artwork::class);
    }

    /**
     * Check if the commission is pending response from artist
     */
    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    /**
     * Check if the commission is accepted
     */
    public function isAccepted(): bool
    {
        return $this->status === self::STATUS_ACCEPTED;
    }

    /**
     * Check if the commission is in progress
     */
    public function isInProgress(): bool
    {
        return $this->status === self::STATUS_IN_PROGRESS;
    }

    /**
     * Check if the commission is completed
     */
    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    /**
     * Check if the commission is rejected
     */
    public function isRejected(): bool
    {
        return $this->status === self::STATUS_REJECTED;
    }

    /**
     * Get the budget range as a formatted string
     */
    public function getBudgetRangeAttribute(): string
    {
        if ($this->budget_min && $this->budget_max) {
            return '$' . number_format($this->budget_min, 2) . ' - $' . number_format($this->budget_max, 2);
        } elseif ($this->budget_min) {
            return '$' . number_format($this->budget_min, 2) . '+';
        } elseif ($this->budget_max) {
            return 'Up to $' . number_format($this->budget_max, 2);
        }
        return 'Not specified';
    }

    /**
     * Get days until deadline
     */
    public function getDaysUntilDeadlineAttribute(): int
    {
        if (!$this->deadline) return 0;
        return now()->diffInDays($this->deadline, false);
    }

    /**
     * Check if deadline is overdue
     */
    public function getIsOverdueAttribute(): bool
    {
        return $this->deadline && now()->isAfter($this->deadline);
    }
}
