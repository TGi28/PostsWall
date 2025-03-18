<div x-data="{ scrollToBottom() { 
    $nextTick(() => {
        const container = $refs.messagesContainer;
        container?.lastElementChild?.scrollIntoView({ behavior: 'smooth' });
    });
}}"
 x-init="scrollToBottom()"
 @scroll-to-bottom.window="scrollToBottom()"
 class="text-gray-900 dark:text-white h-screen flex flex-col overflow-y-auto"
>
<!-- Messages Container -->
<ul x-ref="messagesContainer"
    class="bg-gray-400 flex-grow flex flex-col gap-3 justify-end items-start pb-32 pl-3">
    @foreach($chat->messages as $message)
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
    <div class="fixed bottom-0 w-2/3 bg-white p-2 border-t flex items-center">
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
