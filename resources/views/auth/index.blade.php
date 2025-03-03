<x-layout>
    <x-slot:heading>
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</h1>
    </x-slot:heading>
    @if($posts->count() == 0)
        <div class="flex justify-center flex-col items-center">
            <h2 class="font-bold text-[40px] text-center">No posts yet!</h2>
            <a href="/posts/create" class="font-bold text-[30px] text-center text-sky-400 hover:underline">Do you want to create one?</a>
        </div>
    @else
    <h2 class="font-bold text-[40px] text-center">Posts:</h2>
    <ul class="grid grid-cols-4 gap-3 text-center mt-4">
        @foreach($posts as $post)
            <li class="relative p-2 border-2 border-gray-500 rounded-lg hover:text-sky-800 text-[25px]">
                <a href="/posts/{{ $post->slug }}">
                    <h3 class="line-clamp-1 mt-2">{{ $post->title }}</h3>
                    <p class="line-clamp-2 text-[17px]">{{ html_entity_decode(strip_tags($post->description)) }}</p>
                    <span class="flex items-center text-[15px] absolute top-0 right-1 gap-1">{{ $post->views }} <img width="20" height="20" src="https://img.icons8.com/material-outlined/24/visible--v1.png" alt="visible--v1"/></span>
                </a>
            </li>
        @endforeach
    </ul>
    @endif
</x-layout>