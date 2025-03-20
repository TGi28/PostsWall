<div wire:poll.30s>
    @if($isOnline === true)
        <div class="bg-green-500 w-5 h-5 rounded-full"></div>
    @else
        <div class="bg-gray-500 w-5 h-5 rounded-full"></div>
    @endif
</div>
