<x-layout>
    <x-slot:heading>
        <h1 class="sm:text-[40px] text-[35px] font-bold tracking-tight">Tags</h1>
    </x-slot:heading>
    @foreach ($tags->sortByDesc(function($tag) {
        return $tag->posts->count();
    }) as $tag)
        <div class="text-center">
            <div class="text-[50px] font-bold text-sky-500">{{ Str::ucfirst($tag->name) }}</div>
        </div>
        <x-post-card :posts="$tag->posts"></x-post-card>
        @if($tag->posts->count() > 3)
            <div class="text-right mt-2 mb-4 text-[30px]">
                <a href="/tags/{{ $tag->id }}" class="text-sky-500 hover:underline">View all {{ $tag->posts->count() }} posts &rarr;</a>
            </div>
        @endif
    @endforeach
</x-layout>