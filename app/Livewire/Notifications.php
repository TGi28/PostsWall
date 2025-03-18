<?php

namespace App\Livewire;

use Illuminate\Console\View\Components\Alert;
use Livewire\Component;
use function React\Promise\Timer\timeout;

class Notifications extends Component
{
    // Replace the protected $listeners property with a getListeners method
    public function getListeners()
    {
        return [
            'notificationAdded' => 'loadNotifications',
            'notification-received' => 'loadNotifications',
            'echo:my-channel,.my-event' => 'loadNotifications',
        ];
    }
    
    public $notifications = [];

    public $unreadCount = 0;
    public function mount() {
        $this->loadNotifications();
    }
    
    public function loadNotifications() {
        $this->notifications = auth()->user()->notifications()->latest()->take(5)->get();
        $this->unreadCount = auth()->user()->notifications()->where('is_read', 0)->count();
    }


    public function markAsRead($id)
    {
        auth()->user()->notifications()->where('id', $id)->update(['is_read' => 1]);
        $this->loadNotifications();
    }
    
    public function render()
    {
        return view('livewire.notifications');
    }
}
