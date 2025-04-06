<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class UserStatus extends Component
{
    public $user;
    public $status;
    public $userId;

    protected $listeners = [
        'user-status-changed' => 'checkUserStatus',
    ];

    public function mount($userId = null)
    {
        $this->userId = $userId;

        if ($userId) {
            $this->user = User::find($userId);
            $this->status = $this->user ? $this->user->status : 'offline';
        }
    }

    public function checkUserStatus($event)
    {
        if (isset($event['user_id']) && $this->user && $this->user->id == $event['user_id']) {
            $this->status = $event['status'];
        }
    }

    public function render()
    {
        return view('livewire.user-status');
    }
}
