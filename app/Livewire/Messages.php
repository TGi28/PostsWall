<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Chat;
use App\Events\MessageCreated;
use App\Models\Message;

class Messages extends Component
{
    public $chat;
    public $messages = [];
    public $messageText = '';

    public function getListeners()
    {
        return [
            'message-received' => 'loadMessages',
            'echo:message-channel,.message-event' => 'loadMessages',
        ];
    }

    public function mount(Chat $chat)
    {
        $this->chat = $chat;
        $this->loadMessages();
    }

    public function storeMessage()
    {

        $message = Message::create([
            'chat_id' => $this->chat->id,
            'message' => $this->messageText,
            'user_id' => auth()->id(),
        ]);

        $this->messages[] = $message;
        
        // Broadcast new message event
        event(new MessageCreated());
        $this->messageText = '';
        $this->dispatch('scroll-to-bottom', ['chat_id' => $this->chat->id]);
    }

    public function loadMessages()
    {
        $this->messages = $this->chat->messages()->latest()->get();
        $this->dispatch('scroll-to-bottom', ['chat_id' => $this->chat->id]);
    }

    public function destroyComment(Message $message)
    {
        $message->delete();
        $this->loadMessages();
    }

    public function render()
    {
        return view('livewire.messages');
    }
}
