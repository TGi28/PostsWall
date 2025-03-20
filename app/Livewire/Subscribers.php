<?php

namespace App\Livewire;

use Livewire\Component;
use App\Events\NotificationCreated;
use App\Models\User;

class Subscribers extends Component
{
    public $user;
    public $subscribed = false;

    public function mount(User $user) {
        $this->user = $user;
        if (auth()->check()) {
            $subscriptions = auth()->user()->subscriptions ?? [];
            $this->subscribed = isset($subscriptions[$user->id]) && $subscriptions[$user->id] === 1;
        }
    }

    public function subscribe()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        
        $user = auth()->user();
        $subscriptions = $user->subscriptions ?? [];
        $subscriptions[$this->user->id] = 1;
        $this->user->increment('subscribers');
        $this->subscribed = true;
        
        $user->subscriptions = $subscriptions;
        $user->save();
        $this->user->notifications()->create([
            'name' => 'New Subscriber',
            'description' => 'You have a new subscriber - ' . $user->name,
            'user_id' => $this->user->id,
            'is_read' => 0,
        ]);
        event(new NotificationCreated('New Subscriber'));
    }

    public function unsubscribe() {
        $user = auth()->user();
        $subscriptions = $user->subscriptions ?? [];
        $subscriptions[$this->user->id] = 0;
        $this->user->decrement('subscribers');
        $this->subscribed = false;
        
        $user->subscriptions = $subscriptions;
        $user->save();
    }

    public function render()
    {
        return view('livewire.subscribers');
    }
}
