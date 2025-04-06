<div class="space-y-4" x-data="{ activeChat: null }" >
    @if($previewUrl)
        <div x-transition class="fixed top-0 left-0 w-full h-full py-10 bg-black bg-opacity-75 z-50 flex items-center justify-center">
            @if($file && is_array($file))
                <form wire:submit.prevent="sendFile" class="max-w-4xl max-h-screen">
                    @csrf
                    <button type="button" @click="$wire.cancelFilePreview()" class="text-white z-50 fixed top-4 right-4 bg-gray-800 rounded-full p-2 hover:bg-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                    <div class="bg-white p-4 rounded-lg shadow-md flex flex-col overflow-y-auto max-h-screen">
                        <div class="grid grid-cols-1 md:grid-cols-2 items-center gap-4 mb-3">
                            @foreach ($file as $index => $fileItem)
                                <div class="{{ $index == 0 ? 'col-span-3' : 'col-span-1' }} relative">
                                    <img src="{{ $fileItem->temporaryUrl() }}" alt="File Preview {{ $index + 1 }}" class="{{ $index == 0 ? 'w-full h-[400px]' : 'w-full h-[150px]' }} object-cover rounded">
                                    <button type="button" wire:click="removeFile({{ $index }})" class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                        <div class="flex items-center gap-2">
                            <input wire:model.defer="fileText" id="fileText" type="text" name="fileText" placeholder="Add a caption..." class="flex-grow rounded-lg py-1.5 px-2 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none sm:text-sm/6 border border-gray-900">
                            <button type="submit" class="bg-sky-500 hover:bg-sky-600 text-white p-2 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                    <path d="M3.478 2.404a.75.75 0 0 0-.926.941l2.432 7.905H13.5a.75.75 0 0 1 0 1.5H4.984l-2.432 7.905a.75.75 0 0 0 .926.94 60.519 60.519 0 0 0 18.445-8.986.75.75 0 0 0 0-1.218A60.517 60.517 0 0 0 3.478 2.404Z" />
                                </svg>     
                            </button>
                        </div>
                    </div>
                </form>
            @else
                <div class="max-h-full">
                    <button type="button" @click="$wire.cancelFilePreview()" class="text-white z-50 fixed top-4 right-4 bg-gray-800 rounded-full p-2 hover:bg-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                    <div class="p-4 rounded-lg shadow-md">
                        <img src="{{ asset($previewUrl) }}" alt="Image Preview" class="w-[1000px] h-[1000px] object-contain">
                    </div>
                </div>
            @endif
        </div>
    @endif
    <sidebar>
        <div @if($this->isMobile()) x-show="activeChat == null" @endif class="relative w-full mt-2 mb-2" x-data="{ searchBody : false }" @if($availableUsers != []) @click.outside="searchBody = false; $wire.cancelSearch()" @endif>
            <div class="flex items-center text-white dark:bg-gray-50 rounded-lg border-s-gray-50 border-s-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 bg-gray-700 dark:border-s-gray-700  dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-900 dark:focus:border-blue-500">
                <input wire:model="searchUser" id="search-dropdown" name="query" class="block p-2.5 w-full text-sm rounded-l-lg"  placeholder="Search users..." required  autocomplete="off"/>
                @if($availableUsers != [])
                    <button class="p-1 bg-transparent mr-1" wire:click="cancelSearch" @click="searchBody = false">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                            <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                          </svg>                      
                    </button>
                @endif
                <button @click="searchBody = true" wire:click="search" class="p-3 text-sm font-medium h-full text-white bg-sky-500 rounded-r-lg border border-sky-500 hover:bg-sky-600 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-sky-500 dark:hover:bg-sky-600 dark:focus:ring-sky-700">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                    <span class="sr-only">Search</span>
                </button>
            </div>
            <ul x-show="searchBody" class="{{ $availableUsers !=[] ? 'bg-gray-500' : 'bg-transparent' }} absolute top-10 left-2 z-50 p-2 mt-1 rounded-b-md text-sm  text-gray-700 dark:text-gray-200 flex flex-col max-h-96 overflow-y-auto justify-items-center">
                @foreach ($availableUsers as $availableUser)
                    <li>
                        <button class="text-[25px] p-2 hover:bg-gray-400 rounded-md flex items-center gap-1" wire:click="newChat({{ $availableUser->id }})">
                            @if($availableUser->avatar !== null)
                                <img class="w-[50px] h-[50px] rounded-full object-cover" src="{{ asset($availableUser->avatar) }}" alt="{{ $availableUser->name }}">
                            @endif
                            {{ $availableUser->name }}
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>
          @foreach ($chats as $chat)
              <div class="chat-container mb-3 px-2">
                  <!-- Modify the chat selection click handler -->
                  <a 
                     @click.prevent="
                     if(activeChat === {{ $chat->id }}){
                         activeChat = null;
                         $wire.closeChat();
                     } else {
                         activeChat = {{ $chat->id }};
                         $wire.setChat({{ $chat->id }}, true);
                     }
                     $nextTick(() => {
                        if (activeChat !== null && document.getElementById('message_text-{{ $chat->id }}')) {
                           $focus.focus(document.getElementById('message_text-{{ $chat->id }}'));
                        }
                     })
                     " 
                     x-bind:class="activeChat == {{ $chat->id }} ? 'dark:bg-white bg-gray-400 fixed z-50 top-0 left-0 w-full rounded-t-md' : 'bg-gray-800 dark:bg-gray-300 rounded-lg'" 
                     class="border-2 border-gray-500 block sm:rounded-lg sm:static dark:text-gray-900 text-white hover:shadow-sky-500 hover:shadow-md p-4"
                     @if($this->isMobile()) x-show="activeChat == null || activeChat == {{ $chat->id }}" @endif
                     >
                      <div class="flex items-center justify-between">
                        @if($this->isMobile())
                            <button 
                                x-show="activeChat == {{ $chat->id }}"
                                wire:click="activeChat = null; $wire.closeChat()"
                                class=" text-gray-900"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                    <path fill-rule="evenodd" d="M11.03 3.97a.75.75 0 0 1 0 1.06l-6.22 6.22H21a.75.75 0 0 1 0 1.5H4.81l6.22 6.22a.75.75 0 1 1-1.06 1.06l-7.5-7.5a.75.75 0 0 1 0-1.06l7.5-7.5a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                                  </svg>                              
                            </button>
                        @endif
                          <div class="flex items-center gap-3">
                              <img src="@if( $chat->otherParticipant->avatar !==null) {{ asset($chat->otherParticipant->avatar) }} @else {{ asset('images/avatars/avatar-default.jpg') }} @endif" alt="User Avatar" class="rounded-full  sm:w-20 sm:h-20" x-bind:class=" activeChat == {{  $chat->id }} ? 'w-14 h-14 ' : 'w-20 h-20' ">
                              
                              <div class="flex flex-col">
                                  <div class="flex items-center gap-2">
                                      <div class="lg:text-[30px] sm:text-[20px] text-[20px] font-bold">
                                          {{ $chat->otherParticipant->name }} 
                                        </div>
                                        <livewire:user-status :key="'user-status-'.$chat->otherParticipant->id" :userId="$chat->otherParticipant->id" />
                                  </div>
                                  @if ($chat->messages->isNotEmpty())
                                  <div class="text-[20px] line-clamp-1 sm:block " x-bind:class=" activeChat == {{  $chat->id }} ? 'hidden' : 'block' ">
                                    @if($chat->messages->last()->user_id === $authId)
                                    <span class="text-sky-500">You:</span>
                                    @if($chat->messages->last()->file)
                                        <span class="font-bold text-sky-800">Images:{{ $chat->messages->last()->file }}</span>
                                    @endif
                                    @endif
                                      {{ $chat->messages->last()->message }}
                                  </div>
                                  @endif
                              </div>
                          </div>
                          @if ($chat->messages->isNotEmpty())
                          <div class="sm:flex self-start " x-bind:class=" activeChat == {{  $chat->id }} ? 'hidden' : 'flex' ">
                              <div class="sm:text-[20px] text-[12px]">
                                  {{ $chat->messages->last()->formatted_date }}
                              </div>
                          </div>
                          @endif
                      </div>
                  </a>
              </div>
    </sidebar>  
              <main class="$wire.chat">
                      <div x-show="activeChat == {{ $chat->id }}" x-transition class="chat-content sm:w-2/3 sm:fixed sm:right-0 sm:top-[60px]" data-active-chat-id="{{ $chat->id }}">
                        <div x-data="{ 
                            scrollToBottom() { 
                                $nextTick(() => {
                                    const container = $refs.messagesContainer;
                                    container?.lastElementChild?.scrollIntoView();
                                });
                            },
                            isLoading: false,
                            showJumpButton: false,
                            lastScrollTop: 0,
                        }"
                            x-init="
                                scrollToBottom();
                            "
                            @scroll-to-bottom.window="scrollToBottom()"
                            @scroll-to-focused-message.window="
                                $nextTick(() => {
                                    const focusedElement = document.getElementById('message-' + $event.detail.messageId);
                                    if (focusedElement) {
                                        focusedElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                    }
                                })
                            "
                            class="text-gray-900 dark:text-white h-screen flex flex-col overflow-y-auto relative"
                            @scroll.debounce.300ms="
                                if ($el.scrollTop == 0 && !isLoading && $wire.hasMorePages && !$wire.focusedMessageId) { 
                                    isLoading = true;
                                    showJumpButton = true;
                                    lastScrollTop = $el.scrollHeight;
                                    $wire.loadMoreBefore().then(() => {
                                        isLoading = false;
                                        $el.scrollTop = $el.scrollHeight - lastScrollTop;
                                    });
                                } else if ($el.scrollHeight - $el.scrollTop - $el.clientHeight < 30 && showJumpButton) {
                                    showJumpButton = false;
                                    $wire.resetToLatest();
                                } else if ($el.scrollHeight - $el.scrollTop - $el.clientHeight < 10 && $wire.hasMoreMessagesAfter) {
                                    
                                    $wire.loadMoreAfter();
                                }
                            ">
                        
                        <!-- Loading indicator -->
                        <div x-show="isLoading" class="flex justify-center items-center p-4">
                            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-sky-500"></div>
                        </div>
                        
                        <!-- Jump to Latest Button -->
                        <button 
                            x-show="showJumpButton"
                            @click="scrollToBottom(); showJumpButton = false; $wire.resetToLatest()"
                            class="fixed bottom-20 right-10 bg-sky-500 text-white rounded-full p-3 shadow-lg hover:bg-sky-600 z-50 flex items-center gap-2"
                        >
                            <span>Latest Messages</span>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm-.53 14.03a.75.75 0 001.06 0l3-3a.75.75 0 10-1.06-1.06l-1.72 1.72V8.25a.75.75 0 00-1.5 0v5.69l-1.72-1.72a.75.75 0 00-1.06 1.06l3 3z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        
                        
                        <!-- Messages Container -->
                        <ul x-ref="messagesContainer"
                            class="{{ $replyMessage != null ? 'pb-16 sm:pb-52' : 'pb-16 sm:pb-32' }} bg-gray-400 flex-grow flex flex-col gap-2 justify-end items-start px-2 sm:px-3 border-l border-t">
                            @php
                                $currentDate = null;
                                $previousMessageUserId = null;
                            @endphp
                            @foreach ($messages as $index => $message)
                                @php
                                    $messageDate = $message->created_at->format('Y-m-d');
                                    $showDateSeparator = $currentDate !== $messageDate;
                                    $currentDate = $messageDate;
                                    
                                    // Check if this is the last message from the current user
                                    $nextMessage = $messages[$index - 1] ?? null;
                                    $isLastMessageFromUser = !$nextMessage || $nextMessage->user_id !== $message->user_id || $nextMessage->created_at->format('Y-m-d') !== $messageDate;
                                    
                                    // Determine if we should show the avatar
                                    $showAvatar = $isLastMessageFromUser;
                                @endphp
                                
                                @if($showDateSeparator)
                                    <li class="w-full flex justify-center my-2">
                                        <div class="bg-gray-600 text-white px-4 py-1 rounded-full text-sm">
                                            @if($message->created_at->isToday())
                                                Today
                                            @elseif($message->created_at->isYesterday())
                                                Yesterday
                                            @else
                                                {{ $message->created_at->format('F j, Y') }}
                                            @endif
                                        </div>
                                    </li>
                                @endif
                                
                                <li class="{{ $message->user->id == $authId ? 'flex-row self-start ' : 'flex-row-reverse self-end' }} flex items-center gap-2 relative sm:self-start sm:flex-row " id="message-{{ $message->id }}" 
                                    x-data="{messageTools: false, isBlinking: false}" 
                                    @if($this->isMobile())  
                                        @click="$dispatch('close-other-tools', {exceptId: {{ $message->id }}}); messageTools = !messageTools"
                                    @else
                                        @contextmenu.prevent="$dispatch('close-other-tools', {exceptId: {{ $message->id }}}); messageTools = true"
                                    @endif
                                        @click.outside="messageTools = false"
                                    @if($focusedMessageId == $message->id) 
                                    x-init="$nextTick(() => {
                                        isBlinking = true; 
                                        setTimeout(function() {
                                            isBlinking = false;
                                            $wire.unfocusMessage();
                                        }, 2000); 
                                        $el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                    })" 
                                    @endif
                                    @close-other-tools.window="if($event.detail.exceptId !== {{ $message->id }}) messageTools = false">
                                    @if(!$this->isMobile())
                                        @if($showAvatar)
                                        <img src="{{ $message->user_id === $authId ? ($authUser->avatar ? asset($authUser->avatar) : asset('images/avatars/avatar-default.jpg')) : ($chat->otherParticipant->avatar ? asset($chat->otherParticipant->avatar) : asset('images/avatars/avatar-default.jpg')) }}"
                                            alt="User Avatar"
                                            class="w-10 h-10 rounded-full self-end shadow-sm shadow-black">
                                        @else
                                        <div class="w-10 h-10"></div>
                                        @endif
                                    @endif   
                                    <div class="flex flex-col border transition-all duration-300 p-2 rounded-lg {{ $message->user_id !== $authId ? 'dark:bg-white dark:text-gray-900 bg-gray-900 text-white' : 'bg-sky-500 text-white' }}"
                                        x-bind:class=" isBlinking ? 'ring-2 ring-orange-500 shadow-xl shadow-orange-500 border-orange-500' : 'shadow-sm shadow-black' ">
                                        @if($message->replied_to)
                                        <button class="{{ $authId != $message->user_id ? 'border-sky-500' : 'border-white' }} border-l-4 text-white self-start bg-sky-900 p-2 mb-1 rounded-md text-[10px] md:text-[15px] text-left" id="message-toReply-{{ $message->repliedMessage->id }}" @click="$wire.focusMessage({{ $message->repliedMessage->id }})">
                                            <div>{{ $message->repliedMessage->user_id === $authId ? $authUser->name : $chat->otherParticipant->name }}</div>
                                            <div class="sm:max-w-screen-sm max-w-60 line-clamp-1">{{ $message->repliedMessage->message }}</div>
                                        </button>
                                        @endif
                                        @if($message->file)
                                        <div class="grid grid-cols-1 gap-2 md:grid-cols-2 items-center p-2 rounded-lg {{ $message->user_id !== $authId ? 'dark:bg-white dark:text-gray-900 bg-gray-900 text-white' : 'bg-sky-500 text-white' }}">
                                            @foreach (json_decode($message->file, true) as $index => $image)    
                                                <button wire:click="fileMessagePreview('{{ $image }}')" 
                                                    class="{{ $index == 0 ? 'col-span-3' : 'col-span-1' }}">
                                                    <img src="{{ asset($image) }}" 
                                                        class="{{ $index == 0 ? 'w-full h-[400px]' : 'w-full h-[150px]' }} object-cover rounded-md">
                                                </button>
                                            @endforeach
                                        </div>                                        
                                        @endif
                                        <div class="flex gap-4 justify-between">
                                            <div class="sm:max-w-screen-sm max-w-60 text-[12px] md:text-[17px] self-center">{{ $message->message }}</div>
                                            <div class="flex items-center gap-1">
                                                <div class="text-[9px] sm:text-[12px] mt-2 self-end">
                                                    @if($message->is_edited)
                                                    edited
                                                    @endif
                                                    {{ $message->formatted_date }}
                                                </div>
                                                
                                                <div x-show="messageTools" x-transition class="@if($this->isMobile()) {{  $message->user->id == $authId ? '-right-14' : '-left-14'   }} @endif flex flex-col justify-center items-start gap-1 absolute bottom-0 -right-14 z-50 text-[15px] bg-gray-600 p-2 rounded-md" id="message-tools-{{ $message->id }}">
                                                    <button class="p-1 rounded-md hover:bg-gray-500 text-white" wire:click="replyToMessage({{ $message->id }})" @click="messageTools = !messageTools; $nextTick(() => { $focus.focus(document.getElementById('message_text-{{ $chat->id }}')) })">Reply</button>
                                                    @if($message->user_id == $authId)   
                                                        <button class="p-1 rounded-md hover:bg-gray-500" wire:click="editMessage({{ $message->id }})" @click="messageTools = !messageTools">Edit</button>
                                                        <button class="p-1 rounded-md hover:bg-gray-500" wire:click="destroyMessage({{ $message }})">Delete</button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        
                        <livewire:message-search :key="'message-search-'.$chat->id" :chat="$chat->id" />
                        
                        @if($editingMessageId != null)
                            <form wire:submit.prevent="updateMessage" class="flex w-full" @keyup.escape="$wire.cancelEdit()" x-init="$nextTick(() => $focus.focus($refs.editInput))">
                                @csrf
                                <div class="fixed bottom-0 sm:left-auto left-0  sm:w-2/3 w-full bg-gray-800 p-2 border-t border-l flex items-center">
                                    <button wire:click.prevent="cancelEdit" class="inline-flex mr-2 justify-center gap-x-1.5 rounded-md bg-white p-2 text-sm font-semibold text-gray-900 ring-1 shadow-xs ring-gray-300 ring-inset hover:bg-gray-50">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                            <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                                          </svg>                                      
                                    </button>
                                    <input wire:model.defer="messageText"
                                        x-ref="editInput"
                                        type="text"
                                        name="edit_text"
                                        id="edit_text"
                                        class="flex-grow rounded-lg py-1.5 px-2 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none sm:text-sm/6 border border-gray-300"
                                        autocomplete="off"
                                        @keydown.enter="$event.preventDefault(); $wire.updateMessage();">
                                    <button type="submit"
                                            class="inline-flex ml-2 justify-center gap-x-1.5 rounded-md bg-white p-2 text-sm font-semibold text-gray-900 ring-1 shadow-xs ring-gray-300 ring-inset hover:bg-gray-50">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                                <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32L19.513 8.2Z" />
                                            </svg>                                          
                                    </button>
                                </div>
                            </form>
                        @else    
                            <form @if($replyMessage === null) wire:submit.prevent="storeMessage" @else wire:submit.prevent="sendReply"  @keyup.escape="$wire.cancelReply()" @endif class="flex w-full">
                                @csrf
                                <div class="fixed bottom-0 sm:left-auto left-0  sm:w-2/3 w-full bg-gray-800 p-2 border-t border-l" >
                                    @if($replyMessage != null)
                                        <div class="flex justify-between">
                                            <div class="flex flex-col">
                                                <div class="text-[14px] mb-1 ml-1 self-start">
                                                   Reply to: {{ $replyMessage->user->name }}
                                                </div>
                                                <div class="border p-2 rounded-lg shadow bg-sky-500 self-start mb-2 line-clamp-1">
                                                    {{ $replyMessage->message }}
                                                </div>
                                            </div>
                                            <button class="self-start p-1" wire:click.prevent="cancelReply">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                                    <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                                                  </svg>                                                  
                                            </button>
                                        </div>
                                    @endif
                                    <div class="flex items-center gap-2" x-data="{ showEmojis: false}">
                                        <input wire:model="file" type="file" id="file-upload-{{ $chat->id }}" class="hidden" accept="image/*" multiple/>
                                        <button @click.prevent="document.getElementById('file-upload-{{ $chat->id }}').click()" class="inline-flex justify-center gap-x-1.5 rounded-md bg-white p-2 text-sm font-semibold text-gray-900 ring-1 shadow-xs ring-gray-300 ring-inset hover:bg-gray-50">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                                                <path fill-rule="evenodd" d="M18.97 3.659a2.25 2.25 0 0 0-3.182 0l-10.94 10.94a3.75 3.75 0 1 0 5.304 5.303l7.693-7.693a.75.75 0 0 1 1.06 1.06l-7.693 7.693a5.25 5.25 0 1 1-7.424-7.424l10.939-10.94a3.75 3.75 0 1 1 5.303 5.304L9.097 18.835l-.008.008-.007.007-.002.002-.003.002A2.25 2.25 0 0 1 5.91 15.66l7.81-7.81a.75.75 0 0 1 1.061 1.06l-7.81 7.81a.75.75 0 0 0 1.054 1.068L18.97 6.84a2.25 2.25 0 0 0 0-3.182Z" clip-rule="evenodd" />
                                              </svg>                                              
                                        </button>
                                        <input wire:model.defer="messageText"
                                            x-ref="messageInput"
                                            type="text"
                                            name="message_text"
                                            id="message_text-{{ $chat->id  }}"
                                            class="flex-grow rounded-lg py-1.5 px-2 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none sm:text-sm/6 border border-gray-300"
                                            autocomplete="off"
                                            @if($replyMessage)
                                            @keydown.enter="$event.preventDefault(); $wire.sendReply()"
                                            @else
                                            @keydown.enter="$event.preventDefault(); $wire.storeMessage()"
                                            @endif>
                                            @if(!$this->isMobile())
                                                <div @mouseenter.prevent="showEmojis = !showEmojis"  class="inline-flex justify-center gap-x-1.5 rounded-md bg-white p-2 text-sm font-semibold text-gray-900 ring-1 shadow-xs ring-gray-300 ring-inset hover:bg-gray-50">
                                                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="size-5" viewBox="0 0 122.88 122.88" style="enable-background:new 0 0 122.88 122.88" xml:space="preserve"><style type="text/css">.st0{fill-rule:evenodd;clip-rule:evenodd;}</style><g><path class="st0" d="M61.44,0c33.93,0,61.44,27.51,61.44,61.44c0,33.93-27.51,61.44-61.44,61.44C27.51,122.88,0,95.37,0,61.44 C0,27.51,27.51,0,61.44,0L61.44,0z M104.43,61.18c-0.85,54.05-85.13,54.05-85.97,0C44.54,92.83,72.74,97.25,104.43,61.18 L104.43,61.18z M25.45,46.12c-0.44,1.5-2.01,2.36-3.51,1.92c-1.5-0.44-2.36-2.01-1.92-3.51c1.02-3.44,2.9-6.14,5.27-8.03 c2.4-1.92,5.27-2.99,8.25-3.16c2.95-0.17,5.99,0.55,8.77,2.21c2.96,1.77,5.6,4.62,7.43,8.6c0.65,1.42,0.02,3.1-1.4,3.75 c-1.42,0.65-3.1,0.02-3.75-1.4c-1.32-2.87-3.16-4.88-5.19-6.1c-1.77-1.06-3.7-1.52-5.55-1.41c-1.83,0.1-3.58,0.76-5.03,1.92 C27.32,42.09,26.12,43.84,25.45,46.12L25.45,46.12L25.45,46.12z M78.17,46.12c-0.44,1.5-2.01,2.36-3.51,1.92 c-1.5-0.44-2.36-2.01-1.92-3.51c1.02-3.44,2.9-6.14,5.27-8.03c2.35-1.88,5.24-2.99,8.25-3.16c2.95-0.17,6,0.55,8.77,2.21 c2.96,1.77,5.59,4.62,7.43,8.6c0.65,1.42,0.02,3.1-1.4,3.75c-1.42,0.65-3.1,0.02-3.75-1.4c-1.32-2.87-3.15-4.88-5.19-6.1 c-1.77-1.06-3.7-1.52-5.55-1.41c-1.83,0.1-3.58,0.76-5.03,1.92C80.04,42.1,78.84,43.84,78.17,46.12L78.17,46.12L78.17,46.12z"/></g></svg>                                              
                                                </div>
                                            @endif
                                        <button type="submit"
                                                @click="scrollToBottom"
                                                class="inline-flex justify-center gap-x-1.5 rounded-md bg-white p-2 text-sm font-semibold text-gray-900 ring-1 shadow-xs ring-gray-300 ring-inset hover:bg-gray-50">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                                                    <path d="M3.478 2.404a.75.75 0 0 0-.926.941l2.432 7.905H13.5a.75.75 0 0 1 0 1.5H4.984l-2.432 7.905a.75.75 0 0 0 .926.94 60.519 60.519 0 0 0 18.445-8.986.75.75 0 0 0 0-1.218A60.517 60.517 0 0 0 3.478 2.404Z" />
                                                  </svg>                                                  
                                        </button>
                                        @if(!$this->isMobile())
                                        <div 
                                            x-show="showEmojis"
                                            x-transition
                                            @mouseleave.debounce.500ms="showEmojis = false; $focus.focus(document.getElementById('message_text-{{ $chat->id }}'))"
                                            class="absolute bottom-16 right-6 z-50 text-[15px] bg-gray-600 p-2 rounded-md">
                                            
                                            <div class="grid grid-cols-8 gap-1">
                                                @foreach([ "😀", "😁", "😂", "🤣", "😃", "😄", "😅", "😆", "😉", "😊", "😋", "😎", "😍", "😘", "🥰", "😗", "😙", "😚", "🤗",
                                                        "🤩", "🤔", "🤨", "😐", "😑", "😶", "🙄", "😏", "😣", "😥", "😮", "🤐", "😯", "😪", "😫", "🥱", "😴", "😌", "🤤",
                                                        "😛", "😜", "😝", "🤪", "🤑", "🤠", "😈", "👿", "👹", "👺", "🤡", "💀", "☠️", "👻", "👽", "👾", "🤖", "😺", "😸",
                                                        "😹", "😻", "😼", "😽", "🙀", "😿", "😾"] as $emoji)
                                                    <button type="button" 
                                                            class="text-2xl hover:bg-gray-100 p-1 rounded" 
                                                            @click="$wire.addEmoji('{{ $emoji }}'); if (!event.shiftKey) { showEmojis = false; $nextTick(() => { $focus.focus(document.getElementById('message_text-{{ $chat->id }}')) }) }">
                                                        {{ $emoji }}
                                                    </button>
                                                @endforeach
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        @endif
                        </div>
                      </div>
              </main>
              @endforeach
            </div>
            <script>
                window.authId = {{ auth()->id() }};
            </script>
      </div>

