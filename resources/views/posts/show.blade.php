<x-layout>
        <div class="absolute left-10 top-30 text-[20px]"><a href="{{ route('posts.index', ['sort'=>session('posts_sort','latest')]) }}"><span>&larr;</span> All posts</a></div>
    <x-slot:heading>
        <div class="flex justify-between items-center w-full">
            <div>
                <div class="flex items-center">
                    <h1 class="text-3xl font-bold tracking-tight text-gray-900">{{ $post['title'] }}</h1>
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
                            <button type="submit" class="inline-flex ml-2 justify-center gap-x-1.5 rounded-md bg-white p-1 text-sm font-semibold text-gray-900 ring-1 shadow-xs ring-gray-300 ring-inset hover:bg-gray-50">
                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="24" height="24" viewBox="0 0 24 24">
                                    <path d="M 10.806641 2 C 10.289641 2 9.7956875 2.2043125 9.4296875 2.5703125 L 9 3 L 4 3 A 1.0001 1.0001 0 1 0 4 5 L 20 5 A 1.0001 1.0001 0 1 0 20 3 L 15 3 L 14.570312 2.5703125 C 14.205312 2.2043125 13.710359 2 13.193359 2 L 10.806641 2 z M 4.3652344 7 L 5.8925781 20.263672 C 6.0245781 21.253672 6.877 22 7.875 22 L 16.123047 22 C 17.121047 22 17.974422 21.254859 18.107422 20.255859 L 19.634766 7 L 4.3652344 7 z"></path>
                                </svg>
                            </button>
                            </form>
                        @endif
                    @endauth
                </div>
                <div class="flex gap-1 font-bold text-sm mt-2">
                    @foreach($post->tags as $tag)
                    <div class="bg-sky-300 p-1 rounded-md">{{ $tag->name }}</div>
                    @endforeach
                </div>
            </div>
            <span class="text-[17px] flex items-center gap-1 self-center ml-3">{{ $post->views }} <img width="24" height="24" src="https://img.icons8.com/material-outlined/24/visible--v1.png" alt="visible--v1"/></span>
        </div>
    </x-slot:heading>

    <div class="border-b border-gray-900/10">
        <div class="text-[20px] mb-6 post-content">{!! $post->description !!}</div>
    </div>
    <div class="text-right">
        <p class="text-[20px] mt-2">Created <span class="font-bold">{{ $post->created_at->diffForHumans() }}</span> by <a class="text-sky-500 hover:underline" href="/users/{{ $post->user->slug }}">{{ $post->user->first_name }} {{ $post->user->last_name }}</a> </p>
    </div>
    <div class="mt-6">
        @if($post->comments->count() > 10)
        <button data-collapse-toggle="commentsSection" aria-expanded="false" type="button" class="flex items-baseline">
            <h2 class="text-[20px] font-bold mb-3">Comments ({{ $post->comments->count() }})</h2>
            <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
            </svg>      
        </button>

            <!-- Dropdown menu -->
            <div id="commentsSection" class="hidden">
            @else
            <h2 class="text-[20px] font-bold mb-3">Comments ({{ $post->comments->count() }})</h2>
            @endif

                <ul class="flex flex-col items-start">
                @foreach($post->comments as $comment)
                    <li class="mt-2 border border-sky-500 p-2 rounded-lg" id="comment-{{ $comment->id }}">
                        <div class="flex justify-between">
                            <div>{{ $comment->comment_text }}</div>
                            @auth    
                                @if( auth()->id() == $post->user_id) 
                                    <form action="{{ route('comments.destroy', $comment) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="ml-1 self-end p-1 text-sm hover:bg-gray-50">
                                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="15" height="15" viewBox="0 0 30 30">
                                            <path d="M 7 4 C 6.744125 4 6.4879687 4.0974687 6.2929688 4.2929688 L 4.2929688 6.2929688 C 3.9019687 6.6839688 3.9019687 7.3170313 4.2929688 7.7070312 L 11.585938 15 L 4.2929688 22.292969 C 3.9019687 22.683969 3.9019687 23.317031 4.2929688 23.707031 L 6.2929688 25.707031 C 6.6839688 26.098031 7.3170313 26.098031 7.7070312 25.707031 L 15 18.414062 L 22.292969 25.707031 C 22.682969 26.098031 23.317031 26.098031 23.707031 25.707031 L 25.707031 23.707031 C 26.098031 23.316031 26.098031 22.682969 25.707031 22.292969 L 18.414062 15 L 25.707031 7.7070312 C 26.098031 7.3170312 26.098031 6.6829688 25.707031 6.2929688 L 23.707031 4.2929688 C 23.316031 3.9019687 22.682969 3.9019687 22.292969 4.2929688 L 15 11.585938 L 7.7070312 4.2929688 C 7.5115312 4.0974687 7.255875 4 7 4 z"></path>
                                        </svg>
                                    </button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                        <div>
                            <p class="text-[12px] mt-1">
                                <a class="text-sky-500 hover:underline" href="/users/{{ $comment->user->slug }}">{{ $comment->user->first_name }} {{ $comment->user->last_name }}</a>
                            on {{ $comment->formatted_date }}</p>
                        </div>
                    </li>
                @endforeach
                </ul>
                @auth
                    <form action="{{ route('comments.store', $post) }}" method="POST">
                    @csrf
                        <div class="mt-6">
                        <label class="block font-bold text-[18px] text-gray-900">Write a comment</label>
                        <div class="flex items-end mt-1">
                            <textarea rows="3" type="text" name="comment_text" id="comment_text" class="block min-w-0 max-w-sm rounded-lg grow py-1.5 px-2 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none sm:text-sm/6"></textarea>
                            <button type="submit" class="inline-flex ml-2 justify-center gap-x-1.5 rounded-md bg-white p-2 text-sm font-semibold text-gray-900 ring-1 shadow-xs ring-gray-300 ring-inset hover:bg-gray-50">Publish</button>
                        </div>
                        </div>
                    </form>
                @endauth
                @guest
                    <p class="text-[18px] mt-6">You need to be logged in to comment.</p>
                @endguest
            @if($post->comments->count() > 10)
            </div>
            @endif
    </div>
</x-layout>