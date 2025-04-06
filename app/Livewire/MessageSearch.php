<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Message;

class MessageSearch extends Component
{
    public $chat;
    public $searchQuery = '';
    public $searchedMessages = [];
    
    protected $listeners = ['chatSelected'];
    
    public function chatSelected($chatId)
    {
        $this->chat = $chatId;
        error_log('Chat ID received: ' . $chatId);
        $this->reset('searchedMessages', 'searchQuery');
    }
    
    public function searchMessage()
    {
        if($this->searchQuery === '' || !$this->chat) {
            return;
        }
        
        $query = $this->searchQuery;
        $this->searchedMessages = Message::where('chat_id', $this->chat)
            ->where('message', 'LIKE', "%{$query}%")
            ->orderBy('created_at', 'desc')
            ->with('user')
            ->get();
            
        $this->dispatch('search-results-updated');
    }
    
    public function cancelMessageSearch()
    {
        $this->searchedMessages = [];
        $this->searchQuery = '';
    }
    
    public function focusMessage($messageId)
    {
        $message = Message::find($messageId);
        
        if ($message) {
            // Get the message timestamp to find messages before and after
            
            // Dispatch event to load these messages in the chat component
            $this->dispatch('load-surrounding-messages', [
                'focusedMessageId' => $messageId
            ]);
            
            // Then focus the message
            $this->dispatch('focus-message', ['messageId' => $messageId]);
        }
        
        $this->cancelMessageSearch();
    }
    
    public function render()
    {
        return view('livewire.message-search');
    }
}
