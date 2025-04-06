<div class="fixed top-28 sm:top-20 right-10" x-data="{ messageSearch : false }" @mouseleave="messageSearch = false; $wire.cancelMessageSearch()">
    <div class="flex items-center text-white dark:bg-gray-50 rounded-lg focus:ring-blue-500 focus:border-blue-500 bg-gray-700 dark:placeholder-gray-400 dark:text-gray-900 dark:focus:border-blue-500">
        <input
            x-show="messageSearch"
            x-transition
            @keydown.enter="$wire.searchMessage()"
            wire:model="searchQuery"
            placeholder="Search..."
            class="block p-2.5 w-full text-sm rounded-l-lg"
            type="text"
        />
        <button class="p-3 text-sm font-medium h-full text-white bg-sky-500 rounded-lg border border-sky-500 hover:bg-sky-600 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-sky-500 dark:hover:bg-sky-600 dark:focus:ring-sky-700" wire:click.prevent="searchMessage" @mouseenter="messageSearch = true">
            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
            </svg>
        </button>
    </div>
    <div class="{{ $searchedMessages !=[] ? 'bg-gray-500' : 'bg-transparent' }} mt-1 max-h-64 overflow-y-auto p-2 flex flex-col" x-show="messageSearch">
        @foreach ($searchedMessages as $searchedMessage)
            <button class="{{ $searchedMessage->user_id !== auth()->id() ? 'dark:bg-white dark:text-gray-900 bg-gray-900 text-white' : 'bg-sky-500 text-white' }} flex flex-col mb-2 border p-2 rounded-lg shadow" @click="$wire.focusMessage({{ $searchedMessage->id }})">
                <div class="flex justify-between">
                    <div class="text-[13px]">{{ $searchedMessage->user->name }}</div>
                    <div class="text-[12px]">
                        {{ $searchedMessage->created_at->format('Y-m-d') }}
                    </div>
                </div>
                <div class="self-start">
                    <div class="max-w-sm line-clamp-1">{{ $searchedMessage->message }}</div>
                </div>
            </button>
        @endforeach
    </div>
</div>
