<x-base-layout>
    <x-slot:heading>
        <div class="flex justify-between w-full">
            <div>
                    <div class="flex flex-col">
                        <div class="flex items-center">
                            <h1 class="text-[35px] font-bold tracking-tight text-white dark:text-gray-900">{{ $post['title'] }}</h1>
                            @auth    
                                @if( auth()->id() == $post->user_id) 
                                    <a href="/posts/{{ $post->slug }}/edit" class="inline-flex ml-2 justify-center gap-x-1.5 rounded-md bg-white p-1 text-sm font-semibold text-gray-900 ring-1 shadow-xs ring-gray-300 ring-inset hover:bg-gray-50">
                                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="24" height="24" viewBox="0 0 24 24">
                                            <path d="M 18.414062 2 C 18.158062 2 17.902031 2.0979687 17.707031 2.2929688 L 15.707031 4.2929688 L 14.292969 5.7070312 L 3 17 L 3 21 L 7 21 L 21.707031 6.2929688 C 22.098031 5.9019687 22.098031 5.2689063 21.707031 4.8789062 L 19.121094 2.2929688 C 18.926094 2.0979687 18.670063 2 18.414062 2 z M 18.414062 4.4140625 L 19.585938 5.5859375 L 18.292969 6.8789062 L 17.121094 5.7070312 L 18.414062 4.4140625 z M 15.707031 7.1210938 L 16.878906 8.2929688 L 6.171875 19 L 5 19 L 5 17.828125 L 15.707031 7.1210938 z"></path>
                                        </svg>
                                    </a>
                                    <form class="inline-flex" action="{{ route('posts.destroy', $post->slug) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this post?');">
                                        @csrf
                                        @method('DELETE')
                                    <button type="submit" class="inline-flex ml-2 justify-center gap-x-1.5 rounded-md bg-white p-1 text-sm font-semibold ring-1 shadow-xs ring-gray-300 ring-inset hover:bg-gray-50">
                                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="24" height="24" viewBox="0 0 24 24">
                                            <path d="M 10.806641 2 C 10.289641 2 9.7956875 2.2043125 9.4296875 2.5703125 L 9 3 L 4 3 A 1.0001 1.0001 0 1 0 4 5 L 20 5 A 1.0001 1.0001 0 1 0 20 3 L 15 3 L 14.570312 2.5703125 C 14.205312 2.2043125 13.710359 2 13.193359 2 L 10.806641 2 z M 4.3652344 7 L 5.8925781 20.263672 C 6.0245781 21.253672 6.877 22 7.875 22 L 16.123047 22 C 17.121047 22 17.974422 21.254859 18.107422 20.255859 L 19.634766 7 L 4.3652344 7 z"></path>
                                        </svg>
                                    </button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                        
                    </div>
                    <div class="text-[16px] sm:text-[20px] font-bold">{{ $post->formatted_date }}
                    </div>
                <div class="flex gap-1 font-bold text-sm mt-2">
                    @foreach($post->tags as $tag)
                    <a href="/tags/{{ $tag->id }}" class="bg-sky-300 p-1 rounded-md text-gray-800 dark:text-gray-900">{{ $tag->name }}</a>
                    @endforeach
                </div>
            </div>
            <div class="flex items-end flex-col justify-between">
                <span class="text-[17px] flex items-center gap-1">{{ $post->views }} 
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 text-white dark:text-gray-900">
                        <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                        <path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z" clip-rule="evenodd" />
                    </svg>   
                </span>
                

                <div class="flex items-center gap-2">
                    <a class="text-sky-500 text-[16px] sm:text-[20px] font-bold hover:underline" href="/authors/{{ $post->user->slug }}">
                        {{ $post->user->first_name }} {{ $post->user->last_name }}
                    </a>
                    @if($post->user->avatar !== null)
                        <img class="w-[50px] h-[50px] rounded-full object-cover" src="{{ asset($post->user->avatar) }}" alt="{{ $post->user->first_name }}">
                    @endif
                </div> 
            </div>
        </div>
    </x-slot:heading>

    <div class=" flex flex-col justify-center gap-4 bg-white rounded-md">
        <img src="{{ asset('storage/'.$post->poster) }}" alt="">
        <div class="text-[20px] post-content text-gray-900 p-4">{!! $post->description !!}</div>
    </div>
    <div class="flex justify-between mt-5 border-gray-50">
        <livewire:reactions :post="$post" />
    </div>
    <livewire:comments :post="$post" />
</x-base-layout>