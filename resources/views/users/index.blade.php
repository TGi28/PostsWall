<x-layout>
    <x-slot:heading>
        <h1 class="sm:text-[40px] text-[35px] font-bold text-center sm:text-left tracking-tight">Authors</h1>
    </x-slot:heading>
    <x-author-card :users="$users" />
    <div class="mt-4">{{ $users->links() }}</div>
</x-layout>