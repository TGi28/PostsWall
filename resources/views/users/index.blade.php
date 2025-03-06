<x-layout>
    <x-slot:heading>
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">Authors</h1>
    </x-slot:heading>
    <ul class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 text-center">
        @foreach($users as $user)
            <a href="{{ ($user == auth()->user()) ? '/profile' : '/authors/'.$user->slug }}"  class="p-2 border-2 border-gray-500 rounded-lg block hover:text-sky-500 text-white">
                <div class="text-[28px] ">{{ $user->first_name }} {{ $user->last_name }}</div>
                <div class="grid grid-cols-2 gap-4 mt-2">
                    <div class="text-sky-500 text-[15px]">Total posts: {{ $user->posts->count() }}</div>
                    <div class="text-sky-500 text-[15px]">Total views: {{ $user->posts->sum('views') }}</div>
                </div>
            </a>
        @endforeach
    </ul>
    <div class="mt-4">{{ $users->links() }}</div>
</x-layout>