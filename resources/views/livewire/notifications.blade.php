<div class="flex relative" x-data="{ open: false }">
  <!-- Bell Icon Button -->
  <button @click="open = !open" class="text-gray-900 dark:text-white font-medium rounded-full inline-flex items-center mr-4 relative" type="button">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 md:size-9">
          <path fill-rule="evenodd" d="M5.25 9a6.75 6.75 0 0 1 13.5 0v.75c0 2.123.8 4.057 2.118 5.52a.75.75 0 0 1-.297 1.206c-1.544.57-3.16.99-4.831 1.243a3.75 3.75 0 1 1-7.48 0 24.585 24.585 0 0 1-4.831-1.244.75.75 0 0 1-.298-1.205A8.217 8.217 0 0 0 5.25 9.75V9Zm4.502 8.9a2.25 2.25 0 1 0 4.496 0 25.057 25.057 0 0 1-4.496 0Z" clip-rule="evenodd" />
      </svg>
      @if($unreadCount > 0)
          <div class="absolute top-0 right-0 text-[13px] text-sky-500 font-bold bg-white px-1 rounded-full">{{ $unreadCount }}</div>
      @endif                
  </button>

  <!-- Notifications Dropdown -->
  <div x-show="open" @click.outside="open = false" x-effect="if (open) $wire.loadNotifications()"
       class="absolute z-10 right-0 mt-12 bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700">
      <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
        @if($notifications != [])
          @forelse ($notifications->where('is_read', 0) as $notification)
              <li wire:key="{{ $notification->id }}" class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 {{ $notification->is_read ? 'opacity-50' : '' }}">
                  <p class="text-sm text-gray-900 dark:text-white">{{ $notification->description }}</p>
                  @if(!$notification->is_read)
                      <button wire:click="markAsRead({{ $notification->id }})" class="text-xs text-blue-500 hover:underline">
                          Mark as read
                      </button>
                  @endif
              </li>
          @empty
              <div class="px-4 py-2 text-sm text-gray-500 dark:text-gray-400">
                  No notifications
              </div>
          @endforelse
        @endif
      </ul>
  </div>
</div>
