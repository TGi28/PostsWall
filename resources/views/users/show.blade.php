<x-layout>
    <div class="absolute left-10 top-30 text-[20px]"><a href="{{ url()->previous() }}"><span>&larr;</span> All authors</a></div>
    <x-slot:heading>
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">{{ $user->first_name }} {{ $user->last_name }}</h1>
    </x-slot:heading>
    <h2 class="font-bold text-[40px] text-center">Posts:</h2>
    <ul class="grid grid-cols-4 gap-3 text-center mt-4">
        @foreach($user->posts as $post)
            <li class="relative p-2 border-2 border-gray-500 rounded-lg hover:text-sky-800 text-[25px]">
                <a href="/posts/{{ $post->slug }}">
                    <h3 class="line-clamp-1 mt-2">{{ $post->title }}</h3>
                    <p class="line-clamp-2 text-[17px]">{{ html_entity_decode(strip_tags($post->description)) }}</p>
                    <span class="flex items-center text-[15px] absolute top-0 right-1 gap-1">{{ $post->views }} <img width="20" height="20" src="https://img.icons8.com/material-outlined/24/visible--v1.png" alt="visible--v1"/></span>
                </a>
            </li>
        @endforeach
    </ul>
</x-layout>