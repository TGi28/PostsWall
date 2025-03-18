<div class="mt-6 text-gray-900 dark:text-white">
    @if($post->comments->count() > 10)
    <button data-collapse-toggle="commentsSection" aria-expanded="false" type="button" class="flex items-baseline">
        <h2 class="text-[20px] font-bold mb-3">Comments ({{ $post->comments->count() }})</h2>
        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
        </svg>      
    </button>

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
                            @if( auth()->id() == $comment->user_id) 
                                <form wire:submit.prevent="destroyComment({{ $comment->id }})">
                                @csrf
                                <button type="submit" class="ml-1 self-end p-1 text-sm ">
                                    <svg class="dark:text-white text-gray-900" fill="currentColor" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="15" height="15" viewBox="0 0 30 30">
                                        <path d="M 7 4 C 6.744125 4 6.4879687 4.0974687 6.2929688 4.2929688 L 4.2929688 6.2929688 C 3.9019687 6.6839688 3.9019687 7.3170313 4.2929688 7.7070312 L 11.585938 15 L 4.2929688 22.292969 C 3.9019687 22.683969 3.9019687 23.317031 4.2929688 23.707031 L 6.2929688 25.707031 C 6.6839688 26.098031 7.3170313 26.098031 7.7070312 25.707031 L 15 18.414062 L 22.292969 25.707031 C 22.682969 26.098031 23.317031 26.098031 23.707031 25.707031 L 25.707031 23.707031 C 26.098031 23.316031 26.098031 22.682969 25.707031 22.292969 L 18.414062 15 L 25.707031 7.7070312 C 26.098031 7.3170312 26.098031 6.6829688 25.707031 6.2929688 L 23.707031 4.2929688 C 23.316031 3.9019687 22.682969 3.9019687 22.292969 4.2929688 L 15 11.585938 L 7.7070312 4.2929688 C 7.5115312 4.0974687 7.255875 4 7 4 z"></path>
                                    </svg>
                                </button>
                                </form>
                            @endif
                        @endauth
                    </div>
                    <div>
                        <p class="text-[12px] mt-1">
                            <a class="text-sky-500 hover:underline" href="/authors/{{ $comment->user->slug }}">{{ $comment->user->first_name }} {{ $comment->user->last_name }}</a>
                        at {{ $comment->formatted_date }}</p>
                    </div>
                </li>
            @endforeach
            </ul>
            @auth
                <form wire:submit.prevent="storeComment">
                @csrf
                    <div class="mt-6">
                    <label class="block font-bold text-[18px]">Write a comment</label>
                    <div class="flex items-end mt-1">
                        <textarea wire:model.live="commentText" rows="3" type="text" name="comment_text" id="comment_text" class="block min-w-0 max-w-sm rounded-lg grow py-1.5 px-2 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none sm:text-sm/6" required></textarea>
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