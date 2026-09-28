<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;

class TicketPolicy
{
    /**
     * Admin can view all tickets.
     * User can view only their own tickets.
     */
    public function view(User $user, Ticket $ticket): bool
    {
        return $user->hasRole('admin') || $ticket->user_id === $user->id;
    }
    public function create(User $user): bool
    {
        return $user->hasRole('user');
    }

    /**
     * Only admin can update tickets (resolution, status, image).
     */
    public function update(User $user, Ticket $ticket): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Only admin can delete tickets.
     */
    public function delete(User $user, Ticket $ticket): bool
    {
        return $user->hasRole('admin');
    }
}
