<div class="space-y-4" x-data="{ activeChat: null }">
    <sidebar>
        <div class="relative w-full mt-2">
            <input type="search" wire:model="searchUser" id="search-dropdown" name="query" class="block p-2.5 w-full z-20 text-sm text-gray-900 dark:bg-gray-50 rounded-lg border-s-gray-50 border-s-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 bg-gray-700 dark:border-s-gray-700  dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500" placeholder="Search users..." required />
            <button wire:click="search" class="absolute top-0 end-0 p-2.5 text-sm font-medium h-full text-white bg-sky-500 rounded-e-lg border border-sky-500 hover:bg-sky-600 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-sky-500 dark:hover:bg-sky-600 dark:focus:ring-sky-700">
                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                </svg>
                <span class="sr-only">Search</span>
            </button>
        </div>
        <ul class="p-2 mt-2 text-sm text-gray-700 dark:text-gray-200 grid grid-cols-3 justify-items-center">
            @foreach ($availableUsers as $user)
                <li class="flex items-center gap-1 mb-2">
                    @if($user->avatar !== null)
                        <img class="w-[50px] h-[50px] rounded-full object-cover" src="{{ asset($user->avatar) }}" alt="{{ $user->name }}">
                    @endif
                    <button class="text-[25px] mb-2 p-2 hover:bg-gray-400 rounded-md" wire:click="newChat({{ $user->id }})">
                        {{ $user->name }}
                    </button>
                </li>
            @endforeach
        </ul>
          @foreach ($chats as $chat)
              <div class="chat-container mb-3">
                  <a href="javascript:void(0)" 
                     @click.prevent="
                        activeChat = (activeChat == {{ $chat->id }}) ? null : {{ $chat->id }}; 
                        $nextTick(() => { @this.setChat({{ $chat->id }}) });
                     " 
                     x-bind:class="activeChat === {{ $chat->id }} ? 'dark:bg-white bg-gray-400' : 'bg-gray-800 dark:bg-gray-300'" 
                     class="border-2 border-gray-500 rounded-lg block dark:text-gray-900 text-white hover:shadow-sky-500 hover:shadow-md p-4">
                      <div class="flex items-center justify-between">
                          <div class="flex items-center gap-3">
                              <img src="@if( $chat->participants->where('id','!=', auth()->id())->first()->avatar !==null) {{ asset($chat->participants->where('id','!=', auth()->id())->first()->avatar) }} @else {{ asset('images/avatars/avatar-default.jpg') }} @endif" alt="User Avatar" class="w-20 h-20 rounded-full">
                              
                              <div class="flex flex-col">
                                  <div class="flex items-center gap-2">
                                      <div class="lg:text-[30px] sm:text-[20px] text-[15px] font-bold">
                                          {{ $chat->participants->where('id','!=', auth()->id())->first()->name }} 
                                        </div>
                                        <livewire:user-status :key="'user-status-'.$chat->id" :user="$chat->participants->where('id','!=', auth()->id())->first()" />
                                  </div>
                                  @if ($chat->messages->isNotEmpty())
                                  <div class="text-[20px]">
                                      {{ $chat->messages->last()->message }}
                                  </div>
                                  @endif
                              </div>
                          </div>
                          @if ($chat->messages->isNotEmpty())
                          <div class="flex flex-col self-start">
                              <div class="sm:text-[20px] text-[12px]">
                                  {{ $chat->messages->last()->formatted_date }}
                              </div>
                          </div>
                          @endif
                      </div>
                  </a>
              </div>
              <main>
                      <div x-show="activeChat == {{ $chat->id }}" x-transition class="chat-content mt-2 sm:w-2/3 sm:fixed sm:right-0 sm:top-[60px]">
                        <div x-data="{ scrollToBottom() { 
                            $nextTick(() => {
                                const container = $refs.messagesContainer;
                                container?.lastElementChild?.scrollIntoView();
                            });
                        }}"
                         x-init="scrollToBottom()"
                         @scroll-to-bottom.window="scrollToBottom()"
                         class="text-gray-900 dark:text-white h-screen flex flex-col overflow-y-auto"
                        >
                        <!-- Messages Container -->
                        <ul x-ref="messagesContainer"
                            class="bg-gray-400 flex-grow flex flex-col gap-3 justify-end items-start sm:pb-32 pb-9 pl-3">
                            @foreach($messages as $message)
                                <li class="flex items-center gap-2" id="message-{{ $message->id }}">
                                    <img src="@if ($message->user->avatar) {{ asset($message->user->avatar) }} @else {{ asset('images/avatars/avatar-default.jpg') }} @endif"
                                         alt="User Avatar"
                                         class="w-10 h-10 rounded-full">
                                    <div class="flex gap-4 border p-2 rounded-lg shadow {{ $message->user_id !== auth()->id() ? 'dark:bg-white dark:text-gray-900 bg-gray-900 text-white' : 'bg-sky-500' }}">
                                        <div>{{ $message->message }}</div>
                                        <p class="text-[12px] mt-1 self-end">
                                            {{ $message->formatted_date }}
                                        </p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        
                        <!-- Message Input Form -->
                        <form wire:submit.prevent="storeMessage" class="flex w-full">
                            @csrf
                            <div class="fixed bottom-0 sm:left-auto left-0  sm:w-2/3 w-full bg-white p-2 border-t flex items-center">
                                <input wire:model.defer="messageText"
                                       wire:ignore
                                       type="text"
                                       name="message_text"
                                       id="message_text"
                                       class="flex-grow rounded-lg py-1.5 px-2 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none sm:text-sm/6 border border-gray-300"
                                       autocomplete="off">
                                <button type="submit"
                                        @click="scrollToBottom"
                                        class="inline-flex ml-2 justify-center gap-x-1.5 rounded-md bg-white p-2 text-sm font-semibold text-gray-900 ring-1 shadow-xs ring-gray-300 ring-inset hover:bg-gray-50">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         viewBox="0 0 24 24"
                                         fill="currentColor"
                                         class="size-5">
                                        <path fill-rule="evenodd"
                                              d="M12.97 3.97a.75.75 0 0 1 1.06 0l7.5 7.5a.75.75 0 0 1 0 1.06l-7.5 7.5a.75.75 0 1 1-1.06-1.06l6.22-6.22H3a.75.75 0 0 1 0-1.5h16.19l-6.22-6.22a.75.75 0 0 1 0-1.06Z"
                                              clip-rule="evenodd"/>
                                    </svg>
                                </button>
                            </div>
                        </form>
                        
                        </div>
                      </div>
              </main>
              @endforeach
            </div>
          </sidebar>
      </div>

