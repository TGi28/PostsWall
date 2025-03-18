<x-layout>
    <x-slot:heading>
        <div class="flex gap-3">
            <div>
                @if($user->avatar)
                    <img class="w-[150px] h-[150px] rounded-full object-cover" src="{{ asset($user->avatar) }}" alt="{{ $user->first_name }}">
                @endif               
            </div>
            
                <livewire:subscribers :user="$user"/>
            </div>
        </div>
    </x-slot:heading>
    <h2 class="font-bold text-[40px] text-center">Posts</h2>
    <x-post-card :posts="$user->posts"></x-post-card>
</x-layout>