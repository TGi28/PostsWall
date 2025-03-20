<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class UserStatus extends Component
{
    public $user;
    public $isOnline;

    public function mount(User $user) {
        $this->user = $user;
        $this->checkStatus();
    }

    public function getListeners() {
        return [
            // The event name needs to match exactly what's in the broadcastAs method
            "echo-public:user-status.user-status-changed" => "updateStatus"
        ];
    }

    public function checkStatus() {
        $this->isOnline = $this->user->isOnline();
    }

    public function updateStatus($payload)
    {
        // Debug the payload to see what's coming in
        \Log::info('Status update received', $payload);
        
        // Check if this update is for our user
        if (isset($payload['user']) && isset($payload['user']['id']) && $payload['user']['id'] == $this->user->id) {
            $this->isOnline = $payload['status'] === 'online';
            // Force a re-render
            $this->dispatch('user-status-updated');
        }
    }
    
    public function render()
    {
        // Always check the current status before rendering
        $this->checkStatus();
        return view('livewire.user-status');
    }
}
