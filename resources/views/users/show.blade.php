<x-layout>
    <x-slot:heading>
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">{{ $user->first_name }} {{ $user->last_name }}</h1>
    </x-slot:heading>
    <h2 class="font-bold text-[40px] text-center">Posts:</h2>
    <ul class="grid grid-cols-4 gap-3 text-center mt-4">
        @foreach($user->posts as $post)
        <li class="border-2 bg-white border-gray-500 rounded-lg hover:text-sky-800 text-[25px] text-black">
            <img class="object-cover w-full h-auto rounded-t-md" src="{{ $post->poster }}" alt="{{ $post->title }}">
                <div class="p-3">
                    <h3 class="line-clamp-1 mt-2">
                        {{ $post['title'] }} 
                    </h3>
                    <p class="line-clamp-6 text-[17px]">{{ html_entity_decode(strip_tags($post->description)) }}</p>
                    <div class="flex justify-between items-center mt-4">
                        <span class="text-[15px] flex items-center gap-1">{{ $post->views }} <img width="20" height="20" src="https://img.icons8.com/material-outlined/24/visible--v1.png" alt="visible--v1"/></span>
                        <div class="text-right text-[15px] text-sky-500">{{ $post->created_at->diffForHumans() }}</div>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
</x-layout>