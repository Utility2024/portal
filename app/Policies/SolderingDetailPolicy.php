<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SolderingDetail;
use Illuminate\Auth\Access\HandlesAuthorization;

class SolderingDetailPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isEditor() || $user->isUser();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SolderingDetail $solderingDetail): bool
    {
        return $user->isAdmin() || $user->isEditor() || $user->isUser();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isEditor();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SolderingDetail $solderingDetail): bool
    {
        return $user->isAdmin() || $user->isEditor();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SolderingDetail $solderingDetail): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, SolderingDetail $solderingDetail): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, SolderingDetail $solderingDetail): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, SolderingDetail $solderingDetail): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->isAdmin();
    }
}
