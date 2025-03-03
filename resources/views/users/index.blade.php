<x-layout>
    <x-slot:heading>
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">Authors</h1>
    </x-slot:heading>
    <ul class="grid grid-cols-4 gap-3 text-center">
        @foreach($users as $user)
            <a href="{{ ($user == auth()->user()) ? '/profile' : '/authors/'.$user->slug }}"  class="p-2 border-2 border-gray-500 rounded-lg block hover:text-sky-500">
                <div class="text-[30px] ">{{ $user->first_name }} {{ $user->last_name }}</div>
                <div class="flex gap-4 justify-center">
                    <div class="text-sky-500 text-[15px]">Total posts: {{ $user->posts->count() }}</div>
                    <div class="text-sky-500 text-[15px]">Total views: {{ $user->posts->sum('views') }}</div>
                </div>
            </a>
        @endforeach
    </ul>
    <div class="mt-4">{{ $users->links() }}</div>
</x-layout>