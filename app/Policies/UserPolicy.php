<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Admin can view any user; user can view only self
     */
    public function view(User $current, User $target)
    {
        return $current->hasRole('admin') || $current->id === $target->id;
    }

    /**
     * Admin can create users
     */
    public function create(User $current)
    {
        return $current->hasRole('admin');
    }

    /**
     * Admin CANNOT edit users.
     * User can edit only themself.
     */
    public function update(User $current, User $target)
    {
        // user editing self
        if ($current->id === $target->id) {
            return true;
        }

        // admin editing others → NOT ALLOWED
        return false;
    }

    /**
     * Admin CAN delete users. User CANNOT.
     */
    public function delete(User $current, User $target)
    {
        return $current->hasRole('admin');
    }
}
