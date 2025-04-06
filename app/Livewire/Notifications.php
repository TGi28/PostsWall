<?php

namespace App\Livewire;

use Illuminate\Console\View\Components\Alert;
use Livewire\Component;
use function React\Promise\Timer\timeout;

class Notifications extends Component
{
    public $authUser;
    // Replace the protected $listeners property with a getListeners method
    public function getListeners()
    {
        return [
            'notification-received' => 'countUnreadNotifications',
        ];
    }
    
    public $notifications = [];

    public $unreadCount = 0;
    public function mount() {
        $this->authUser = auth()->user();
        $this->countUnreadNotifications();
    }
    
    public function loadNotifications() {
        $this->notifications = $this->authUser->notifications()->with('user')->latest()->limit(5)->get();
        
    }

    public function countUnreadNotifications() {
        $this->unreadCount = $this->authUser->notifications->where('is_read', 0)->count();
    }


    public function markAsRead($id)
    {
        $this->authUser->notifications()->where('id', $id)->delete();
        $this->loadNotifications();
        $this->countUnreadNotifications();
    }
    
    public function render()
    {
        return view('livewire.notifications');
    }
}
