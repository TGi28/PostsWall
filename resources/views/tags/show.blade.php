<x-base-layout>
    <x-slot:heading>
        <h1 class="sm:text-[40px] text-[35px] font-bold tracking-tight text-gray-900">{{ Str::ucfirst($tag->name) }}</h1>
    </x-slot:heading>
    <x-post-card :posts="$posts"></x-post-card>
    <div class="mt-4">{{ $posts->links() }}</div>
</x-base-layout>