<x-layout>
    <x-slot:heading>
        <h1 class="sm:text-[40px] text-[35px] font-bold tracking-tight text-gray-900">{{ Str::ucfirst($tag->name) }}</h1>
    </x-slot:heading>
    <ul class="grid grid-cols-1 sm:grid-rows-1 gap-3 text-center mt-2">
        @foreach($posts as $post)
        <a href="/posts/{{ $post->slug }}">
            <li class="flex sm:flex-row flex-col border-2 bg-white border-gray-500 rounded-lg hover:text-sky-800 text-[25px] text-black">
                <img class="object-cover w-full h-auto rounded-t-md sm:rounded-l-md" src="{{ $post->poster }}" alt="{{ $post->title }}">
                    <div class="relative">
                            <div class="p-3 pl-5">
                                <h3 class="line-clamp-1 mt-2 text-left text-[30px] sm:text-[35px] font-bold">
                                    {{ $post['title'] }} 
                                </h3>
                                <div class="flex gap-1 font-bold text-[13px]">
                                    @foreach($post->tags as $tag)
                                    <div class="bg-sky-300 p-1 mt-1 mb-2 rounded-md">{{ $tag->name }}</div>
                                    @endforeach
                                </div>
                                <p class="line-clamp-6 text-[18px] sm:text-[22px] text-left">{{ html_entity_decode(strip_tags($post->description)) }}</p>
                            </div>
                            <span class="absolute top-2 right-2 text-[15px] flex items-center gap-1">{{ $post->views }} <img width="20" height="20" src="https://img.icons8.com/material-outlined/24/visible--v1.png" alt="visible--v1"/></span>
                            <div class="divide-gray-400 border-t-2 mt-1 flex justify-between items-center p-3 text-[17px] sm:text-[20px]">
                                <div class="text-sky-500 font-bold">{{ $post->user->first_name }} {{ $post->user->last_name }}</div>
                                <div class="text-right text-sky-500">{{ $post->created_at->diffForHumans() }}</div>
                            </div>
                    </div>
                </li>
            </a>
        @endforeach
    </ul>
    <div class="mt-4">{{ $posts->links() }}</div>
</x-layout>