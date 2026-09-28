<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Admin can see listing of all users.
     */
    public function viewAny(User $current)
    {
        return $current->hasRole('admin');
    }

    /**
     * Admin can view any user.
     * Users can only view themselves.
     */
    public function view(User $current, User $target)
    {
        return $current->hasRole('admin') || $current->id === $target->id;
    }

    /**
     * Admin can create users.
     * Users cannot create new users.
     */
    public function create(User $current)
    {
        return $current->hasRole('admin');
    }

    /**
     * Admin can update ANY user.
     * Users can update ONLY their own information.
     */
    public function update(User $current, User $target)
    {
        // Admins can update everyone
        if ($current->hasRole('admin')) {
            return true;
        }

        // User can only update themselves
        return $current->id === $target->id;
    }

    /**
     * Admin can delete any user (except themselves in controller check).
     * Users cannot delete anyone.
     */
    public function delete(User $current, User $target)
    {
        return $current->hasRole('admin');
    }

    /**
     * Custom gate for AJAX status updates (admin-only).
     */
    public function updateStatus(User $current)
    {
        return $current->hasRole('admin');
    }
}
