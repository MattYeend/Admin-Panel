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
        return $user->isAdmin() || $user->isEditor();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $authUser, User $user): bool
    {
        return $authUser->isEditor() || $authUser->isAdmin() || 
                ($authUser->department && $authUser->department->dept_lead_id === $user->id);
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
    public function update(User $authUser, User $user): bool
    {
        return $authUser->isAdmin() || $authUser->isEditor() || 
                ($authUser->department && $authUser->department->dept_lead_id === $user->id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $authUser, User $user): bool
    {
        // Prevent users from deleting their own account
        if ($authUser->id === $user->id) {
            return false;
        }

        return $authUser->isAdmin(); // Allow only admins to delete users (not editors)
    }
}
