<?php

namespace App\Policies;

use App\Models\Patiant;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PatiantPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
        return in_array($user->role, [
            User::ROLE_ADMIN,
            User::ROLE_DOCTOR,
            User::ROLE_ASSISTANT,
            User::ROLE_RECEPTIONIST,
        ]);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Patiant $patiant): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
        return in_array($user->role, [
            User::ROLE_ADMIN,
            User::ROLE_RECEPTIONIST,
        ]);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Patiant $patiant): bool
    {
        //

        return $user->isAdmin() || $user->isReceptionist();

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Patiant $patiant): bool
    {
        //
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Patiant $patiant): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Patiant $patiant): bool
    {
        //
    }
}
