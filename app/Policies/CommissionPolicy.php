<?php

namespace App\Policies;

use App\Models\Commission;
use App\Models\User;

class CommissionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true; // Users can view their own commissions
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Commission $commission): bool
    {
        // Users can view commissions they're involved in (client or artist)
        return $user->id === $commission->client_id || $user->id === $commission->artist_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true; // Any authenticated user can create commissions
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Commission $commission): bool
    {
        // Only the artist can update commission details
        return $user->id === $commission->artist_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Commission $commission): bool
    {
        // Only the client can delete/cancel a commission before it's accepted
        return $user->id === $commission->client_id && $commission->status === Commission::STATUS_PENDING;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Commission $commission): bool
    {
        return false; // No restoration needed
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Commission $commission): bool
    {
        return false; // No permanent deletion
    }

    /**
     * Determine whether the user can view the inbox.
     */
    public function viewInbox(User $user): bool
    {
        return $user->role === 'artist';
    }

    /**
     * Determine whether the user can view sent commissions.
     */
    public function viewSent(User $user): bool
    {
        return $user->role === 'client';
    }

    /**
     * Determine whether the user can accept a commission.
     */
    public function accept(User $user, Commission $commission): bool
    {
        return $user->id === $commission->artist_id && $commission->status === Commission::STATUS_PENDING;
    }

    /**
     * Determine whether the user can reject a commission.
     */
    public function reject(User $user, Commission $commission): bool
    {
        return $user->id === $commission->artist_id && $commission->status === Commission::STATUS_PENDING;
    }

    /**
     * Determine whether the user can start work on a commission.
     */
    public function startWork(User $user, Commission $commission): bool
    {
        return $user->id === $commission->artist_id && $commission->status === Commission::STATUS_ACCEPTED;
    }

    /**
     * Determine whether the user can mark a commission as completed.
     */
    public function complete(User $user, Commission $commission): bool
    {
        return $user->id === $commission->artist_id && $commission->status === Commission::STATUS_IN_PROGRESS;
    }

    /**
     * Determine whether the user can confirm completion and rate.
     */
    public function confirmCompletion(User $user, Commission $commission): bool
    {
        return $user->id === $commission->client_id && $commission->status === Commission::STATUS_COMPLETED;
    }

    /**
     * Determine whether the user can cancel a commission.
     */
    public function cancel(User $user, Commission $commission): bool
    {
        return $user->id === $commission->client_id && $commission->status === Commission::STATUS_PENDING;
    }
}
