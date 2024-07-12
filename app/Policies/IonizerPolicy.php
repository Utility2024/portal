<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Ionizer;
use Illuminate\Auth\Access\HandlesAuthorization;

class IonizerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_ionizer');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Ionizer $ionizer): bool
    {
        return $user->can('view_ionizer');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_ionizer');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Ionizer $ionizer): bool
    {
        return $user->can('update_ionizer');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Ionizer $ionizer): bool
    {
        return $user->can('delete_ionizer');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_ionizer');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, Ionizer $ionizer): bool
    {
        return $user->can('force_delete_ionizer');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_ionizer');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, Ionizer $ionizer): bool
    {
        return $user->can('restore_ionizer');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_ionizer');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, Ionizer $ionizer): bool
    {
        return $user->can('replicate_ionizer');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_ionizer');
    }
}
