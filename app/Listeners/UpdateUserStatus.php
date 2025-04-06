<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use App\Events\UserOnlineStatusChanged;

class UpdateUserStatus 
{
    public function handle($event)
    {
        $user = $event->user;

        // Determine status based on event type
        $status = $event instanceof Login ? 'online' : 'offline';

        // Check if the user is away based on activity (can be part of the logic elsewhere)
        // For example, you could also check for idle time and change status to 'away'

        // Update the user's status to the appropriate value
        $user->update(['status' => $status]);

        // Broadcast the status change
        broadcast(new UserOnlineStatusChanged($user, $status));
    }
}

