<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserOnlineStatusChanged implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $status;

    public function __construct($user, $status)
    {
        $this->user = $user;
        $this->status = $status;
    }

    public function broadcastOn()
    {
        // Use a public channel for user status
        return new Channel('user-status');
    }

    public function broadcastWith()
    {
        return [
            'user' => [
                'id' => $this->user->id
            ],
            'status' => $this->status
        ];
    }

    public function broadcastAs()
    {
        return 'user-status-changed';
    }
}
