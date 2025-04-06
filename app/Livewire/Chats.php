<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Chat;
use App\Events\MessageCreated;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\WithFileUploads;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Chats extends Component
{
    use WithPagination, WithoutUrlPagination, WithFileUploads;

    public $perPage = 50;
    public $chat;
    public $messages = [];
    public $searchUser = '';
    public $messageText = '';
    public $fileText = '';
    public $page = 1;
    public $messageSearch = '';
    public $editingMessageId = null;
    public $replyMessage = null;
    public $availableUsers = [];
    public $searchedMessages = [];
    public $focusedMessageId = null;
    public $hasMorePages = true;
    public $hasMoreMessagesAfter = false;
    public $file = [];
    public $fileView = null;
    public $previewUrl;
    public $authId;
    public $authUser;

    public $otherUser = null;

    public function getListeners()
{
    return [
        'newChat' => 'newChat',
        'focus-message' => 'focusMessage',
        'load-surrounding-messages' => 'loadSurroundingMessages',
        'message-received' => 'fetchNewMessages',
    ];
}




    public function mount()
    {
        $this->authId = auth()->id();
        $this->authUser = auth()->user();
        $this->previewUrl = null;
    }
    

    public function newChat($userId)
    {
    $chat = Chat::create();  // Create the chat first
    $this->chat = $chat;
    
    // Attach authenticated user and the other user
    $chat->participants()->attach([auth()->id(), $userId]);
    
    $this->loadMessages();
    }

    public function fetchNewMessages()
    {   
        if($this->chat === null) {
            return;
        }
        // Load the latest message and add it to the existing messages list
        $latestMessage = Message::where('chat_id', $this->chat->id)
            ->latest()
            ->first();

        if ($latestMessage && !$this->messages->contains('id', $latestMessage->id)) {
            $this->messages->push($latestMessage);
            $this->dispatch('scroll-to-bottom'); // Auto-scroll
        }
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
            ->take(9)
            ->get();

        $this->availableUsers = $availableUsers;
    }

    public function cancelSearch() {
        $this->searchUser = '';
        $this->availableUsers = [];
    }

    public function searchMessage() {
        if($this->messageSearch === '') {
            return;
        }
        $query = $this->messageSearch;
        $searchedMessages = Message::where('chat_id', $this->chat->id)
        ->where('message', 'LIKE', "%{$query}%")
        ->with('user','repliedMessage.user')
        ->get();
        $this->searchedMessages = $searchedMessages;
    }

    public function focusMessage($data)
    {
        
        if (is_array($data) && isset($data['messageId'])) {
            $this->focusedMessageId = $data['messageId'];
        } else {
            $this->focusedMessageId = $data;
        }
    }

    public function loadSurroundingMessages($data)
    {
        $focusedMessageId = $data['focusedMessageId'];
        
        // Get the current chat
        $chat = $this->chat;
        
        if (!$chat) {
            return;
        }
        
        // Find the focused message first
        $focusedMessage = $this->messages->find($focusedMessageId);
        
        if (!$focusedMessage) {
            $focusedMessage = Message::find($focusedMessageId);
            $messagesBeforeAfter = Message::where('chat_id', $chat->id)
                ->where(function($query) use ($focusedMessage) {
                    $query->where('created_at', '<', $focusedMessage->created_at)
                        ->orWhere('created_at', '>', $focusedMessage->created_at)
                        ->orWhere('id', $focusedMessage->id);
                })
                ->orderBy('created_at', 'asc')
                ->with(['user', 'repliedMessage.user'])
                ->get();
            
            // Get 20 messages before the focused message
            $messagesBefore = $messagesBeforeAfter->where('created_at', '<', $focusedMessage->created_at)
                ->sortByDesc('created_at')
                ->take(40);
                
            // Get 20 messages after the focused message
            $messagesAfter = $messagesBeforeAfter->where('created_at', '>', $focusedMessage->created_at)
                ->take(40);
            
            // Combine the messages (before + focused + after)
            $surroundingMessages = $messagesBefore->reverse()
                ->push($focusedMessage)
                ->concat($messagesAfter);
            
                $this->messages = $surroundingMessages;
                
                $this->focusedMessageId = $focusedMessageId;
                
                $this->checkMoreMessagesAfter();
        }
        $this->dispatch('scroll-to-focused-message', ['messageId' => $focusedMessageId]);
    }

    public function scrollBottom()
    {
        $this->dispatch('scroll-to-bottom');
    }

    public function unfocusMessage()
    {
        $this->focusedMessageId = null;
    }

    public function closeChat()
    {
        $this->chat = null;
        $this->messages = [];
        $this->page = 1;
        $this->replyMessage = null;
        $this->editingMessageId = null;
        $this->messageText = '';
        $this->searchedMessages = [];
        $this->messageSearch = '';
        $this->hasMorePages = true;
    }

    public function setChat($chatId)
    {
        $this->chat = Chat::with([
            'participants', 
            'messages',
        ])->find($chatId);
        
        $this->dispatch('chatSelected', $chatId); // Add this line for the MessageSearch component
        $this->perPage = 50;
        $this->loadMessages();
        $totalMessages = $this->chat->messages()->count();
        if($totalMessages <= $this->perPage) {
            $this->hasMorePages = false;
        } else {
            $this->hasMorePages = true;
        }
        $this->dispatch('scroll-to-bottom');
    }
    public function loadMessages()
    {
        if($this->chat === null) {
            return;
        }
    
        $messages = $this->chat->messages()
            ->with([
                'user',
                'repliedMessage'
            ])
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage)
            ->reverse();
        $this->messages = $messages;
    }

    public function loadMoreBefore()
    {
        if($this->chat === null || !$this->hasMorePages) {
            return false;
        }
        
        $this->perPage += 50;
        $this->loadMessages();
        
        // Check if we've loaded all messages
        $totalMessages = $this->chat->messages()->count();
        if($totalMessages <= $this->perPage) {
            $this->hasMorePages = false;
        }
        
    }

    public function resetToLatest()
    {
        $this->hasMorePages = true;
        $this->perPage = 50;
        $this->loadMessages();
    }

    public function loadMoreAfter(){
        if ($this->chat === null) {
            return;
        }
        
        // Get the last message ID - this is incorrect, should use $this->messages collection
        $lastMessageId = $this->messages->last()->id ?? 0;
        
        // Load more messages after this ID
        $newMessages = $this->chat->messages()
            ->where('id', '>', $lastMessageId)
            ->with(['user', 'repliedMessage.user'])  // Added .user to load reply user data
            ->orderBy('created_at', 'asc')
            ->take(50)
            ->get();
        
        if ($newMessages->count() > 0) {
            // Append new messages to the collection
            $this->messages = $this->messages->concat($newMessages);
            
            // Check if there are more messages after these
            $this->checkMoreMessagesAfter();
        } else {
            $this->hasMoreMessagesAfter = false;
        }
        
        $this->dispatch('has-more-after', ['hasMore' => $this->hasMoreMessagesAfter]);
    }

    private function checkMoreMessagesAfter()
    {
        if ($this->chat === null) {
            $this->hasMoreMessagesAfter = false;
            return;
        }
        
        // This is incorrect, should use $this->messages collection
        $lastMessageId = $this->messages->last()->id;
        $hasMore = $this->chat->messages()
        ->where('id', '>', $lastMessageId)
        ->exists();
        $this->hasMoreMessagesAfter = $hasMore;
    }

    public function storeMessage()
    {
        if(trim($this->messageText) === '') {
            return;
        }
        
        $message = Message::create([
            'chat_id' => $this->chat->id,
            'message' => $this->messageText,
            'user_id' => auth()->id(),
        ]);
        
        $this->messageText = '';
        $this->loadMessages();

        $receiver = $this->chat->otherParticipant;
        
        broadcast(new MessageCreated( $receiver->id))->toOthers();
        $this->dispatch('scroll-to-bottom');
    }
    
    public function sendReply()
    {
        if(trim($this->messageText) === '') {
            return;
        }
        
        $message = Message::create([
            'chat_id' => $this->chat->id,
            'message' => $this->messageText,
            'user_id' => auth()->id(),
            'replied_to' => $this->replyMessage->id,
        ]);
        
        $this->replyMessage = null;
        $this->messageText = '';
        
        // Reset pagination and reload messages
        $this->loadMessages();
    
        broadcast(new MessageCreated())->toOthers();
        $this->dispatch('scroll-to-bottom');
    }
    
    public function destroyMessage(Message $message)
    {   
        if($message->file) {
            $filePath = public_path('storage/' . $message->file);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
        $message->delete();

        broadcast(new MessageCreated())->toOthers();
        $this->loadMessages();
    }

    public function editMessage($messageId)
    {
        $this->editingMessageId = $messageId;
        $this->messageText = Message::find($messageId)->message;
    }
    
    public function updateMessage()
    {
        Message::find($this->editingMessageId)->update([
                'message' => $this->messageText,
                'is_edited' => true,
            ]);
        $this->editingMessageId = null;
        $this->messageText = '';
        $this->loadMessages();
        broadcast(new MessageCreated())->toOthers();
    }
    
    public function replyToMessage($messageId)
    {
        $this->replyMessage = Message::with('user')->find($messageId);
    }

    public function cancelReply(){
        $this->replyMessage = null;
    }

    public function addEmoji($emoji){
        $this->messageText = ($this->messageText ?? '') . $emoji;
    }

    public function isMobile()
    {
        $userAgent = request()->header('User-Agent');
        return preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i', $userAgent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($userAgent, 0, 4));
    }

    public function updatedFile() {
        $this->filePreview();
    }

    public function filePreview() {
        $this->previewUrl = [];
        foreach ($this->file as $file) {
            $this->previewUrl[] = $file->temporaryUrl();
        }
    }

    public function fileMessagePreview($filePath)
    {
        $this->previewUrl = $filePath;
    }
    

    public function cancelFilePreview() {
        $this->previewUrl = null;
        $this->fileText = '';
        $this->file = null;
        $this->fileView = null;
    }

    public function sendFile() {
        if ($this->file) {
            $filePaths = [];
            foreach ($this->file as $file) {
                $filePath = $file->storeAs('chats', $file, 'public');
                $filePaths[] = $filePath;
            }
            $message = Message::create([
                'chat_id' => $this->chat->id,
                'message' => $this->fileText,
                'file' => json_encode($filePaths),
                'user_id' => auth()->id(),
            ]);
            $this->file = null;
            $this->fileText = '';
            $this->previewUrl = null;
            $this->loadMessages();
            broadcast(new MessageCreated())->toOthers();
            $this->dispatch('scroll-to-bottom');
        }
    }
    public function removeFile($index)
        {
            // Create a new array without the file at the specified index
            $files = $this->file;
            unset($files[$index]);
            $this->file = array_values($files); // Reset array keys
            
            // Update preview URLs
            $this->filePreview();
            
            // If no files left, reset the preview
            if (empty($this->file)) {
                $this->cancelFilePreview();
            }
        }
    public function render()
    {
        $chats = auth()->user()->chat;
        
        return view('livewire.chats', compact('chats'));
    }
}





