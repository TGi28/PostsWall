<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Chat;
use App\Events\MessageCreated;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Chats extends Component
{
    public $chat;
    public $messages = [];
    public $searchUser = '';
    public $messageText = '';

    public $availableUsers = [];

    public function getListeners()
    {
        return [
            'message-received' => 'loadMessages',
            'echo:message-channel,.message-event' => 'loadMessages',
            'newChat' => 'newChat',
        ];
    }

    public function mount(Chat $chat)
    {
        $this->chat = $chat;
        $this->loadMessages();
    }

    public function setChat($chatId)
    {
        // Find the chat with eager loading of participants and their related data
        $this->chat = Chat::with(['participants', 'messages.user'])->find($chatId);
        
        if ($this->chat) {
            $this->loadMessages();
            // Preserve the component state
            $this->dispatch('chat-selected', ['chatId' => $chatId]);
        }
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

    public function newChat($userId)
    {
    $chat = Chat::create();  // Create the chat first
    $this->chat = $chat;
    
    // Attach authenticated user and the other user
    $chat->participants()->attach([auth()->id(), $userId]);
    
    $this->loadMessages();
    }

    public function search() {
        $query = $this->searchUser;
        $existingChatUserIds = Chat::whereHas('participants', function ($query) {
            $query->where('user_id', auth()->id());
        })->with('participants')->get()->flatMap(function ($chat) {
            return $chat->participants->pluck('id');
        })->unique();        
        $availableUsers = User::where('id', '!=', auth()->id())
            ->whereNotIn('id', $existingChatUserIds)
            ->when($query, function ($q) use ($query) {
            $q->where('name', 'LIKE', "%{$query}%");
            })
            ->get();

        $this->availableUsers = $availableUsers;
    }


    public function loadMessages()
    {
        $messages = $this->chat->messages()->with('user')->orderBy('created_at')->take(50)->get();
        $this->messages = $messages;
        $this->dispatch('scroll-to-bottom', ['chat_id' => $this->chat->id]);
    }

    public function destroyMessage(Message $message)
    {
        $message->delete();
        $this->loadMessages();
    }

    public function render()
    {
        $users = User::where('id', '!=', auth()->id())->get();
        $chats = auth()->user()->chat;
        
    
        // Filter out users who are already in a chat with the current user
        $availableUsers = $this->availableUsers;
        $subscribers = auth()->user()->subscriptions;
        return view('livewire.chats', compact('chats', 'subscribers', 'users','availableUsers'));
    }
}
