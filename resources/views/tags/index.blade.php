<x-layout>
    <x-slot:heading>
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">Tags</h1>
    </x-slot:heading>
    @foreach ($tags->sortByDesc(function($tag) {
        return $tag->posts->count();
    }) as $tag)
        <div class="text-center">
            <div class="text-[50px] font-bold text-sky-500">{{ Str::ucfirst($tag->name) }}</div>
        </div>
    <ul class=" text-center grid grid-cols-3 gap-4 mb-4">
    @foreach ($tag->posts->sortByDesc('views')->take(3) as $post)
            <a href="/posts/{{ $post->slug }}">
                <li class="p-3 border-2 border-gray-500 rounded-lg hover:text-sky-800 text-[25px] relative">
                    <h3 class="line-clamp-1 mt-2">
                        {{ $post['title'] }} 
                    </h3>
                    <span class="text-[15px] absolute top-1 right-2 flex items-center gap-1">{{ $post->views }} <img width="20" height="20" src="https://img.icons8.com/material-outlined/24/visible--v1.png" alt="visible--v1"/></span>
                    <p class="line-clamp-6 text-[17px]">{{ html_entity_decode(strip_tags($post->description)) }}</p>
                    <div class="text-right text-[15px] mt-4">{{ $post->created_at->diffForHumans() }}</div>
                </li>
            </a>
            @endforeach
        </ul>
        @if($tag->posts->count() > 3)
            <div class="text-right mt-2 mb-4 text-[20px]">
                <a href="/tags/{{ $tag->id }}" class="text-sky-500 hover:underline">View all {{ $tag->posts->count() }} posts &rarr;</a>
            </div>
        @endif
    @endforeach
</x-layout>