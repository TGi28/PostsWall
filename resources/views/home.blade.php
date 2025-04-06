<x-base-layout>
    <x-slot:heading>
        <h1 class="sm:text-[40px] text-[35px] text-center sm:text-left font-bold tracking-tight bg-gray-800 dark:bg-white text-white dark:text-gray-900">Home</h1>
    </x-slot:heading>
    <div class="mb-8">
        <h2 class="text-center text-[66px] font-bold mb-4">Popular posts</h2>
        <ul class="grid grid-cols-1 sm:grid-rows-1 gap-3 text-center mt-2">
            @foreach($posts as $post)
                <x-post-card :$post />
            @endforeach
        </ul>
    </div>
    <div class="mb-8">
        <h2 class="text-center text-[66px] font-bold mb-4">Popular authors</h2>
        <x-author-card :users="$users"></x-author-card>
    </div>
    <div class="mb-8">
        <h2 class="text-center text-[66px] font-bold mb-4">Popular tags</h2>
        <div class="grid-cols-3 grid gap-6">
            @foreach ($tags->sortByDesc(function($tag) {
                return $tag->posts->count();
            }) as $tag)
                <a href="/tags/{{ $tag->id }}" class="text-center border border-sky-500 rounded-md p-3">
                    <div class="text-[50px] font-bold text-sky-500">{{ Str::ucfirst($tag->name) }}</div>
                </a>
            @endforeach
        </div>
    </div>
</x-base-layout>