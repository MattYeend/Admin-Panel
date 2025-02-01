<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $authUser, User $user): bool
    {
        return $authUser->isSuperAdmin() || $authUser->isAdmin() || $authUser->cSuite() ||
                ($authUser->department && $authUser->department->dept_lead_id === $user->id);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $authUser, User $user): bool
    {
        return $authUser->isAdmin() || $authUser->isSuperAdmin() ||
                ($authUser->department && $authUser->department->dept_lead_id === $user->id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $authUser, User $user): bool
    {
        return $authUser->isSuperAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        //
    }

    public function viewSensitiveDocs(User $authUser, User $user)
    {
        $isAdminOrLead = $authUser->id === $user->department->dept_lead_id;
        $allowed = $authUser->isSuperAdmin() || $authUser->isAdmin() || $authUser->cSuite();
        return $isAdminOrLead || $allowed;
    }
}