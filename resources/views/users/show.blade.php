<x-base-layout>
    <x-slot:heading>
        <div class="flex gap-3">
            <div>
                @if($user->avatar)
                    <img class="w-[150px] h-[150px] rounded-full object-cover" src="{{ asset($user->avatar) }}" alt="{{ $user->name }}">
                @endif               
            </div>
            
                <livewire:subscribers :user="$user"/>
            </div>
        </div>
    </x-slot:heading>
    @if($user->posts->isNotEmpty())
        <h2 class="font-bold text-[40px] text-center mt-3">Posts</h2>
    @else
        <h2 class="font-bold text-[40px] text-center mt-3">No posts yet</h2>
    @endif
    <ul class="grid grid-cols-1 sm:grid-rows-1 gap-3 text-center mt-2">
        @php
            $posts = $user->posts;
        @endphp
        @foreach($posts as $post)
        <a href="/posts/{{ $post->id }}">
            <li class="flex sm:flex-row flex-col border-2 bg-gray-800 text-white dark:bg-white border-gray-500 rounded-lg hover:text-gray-200 dark:hover:text-gray-800 text-[25px] dark:text-black hover:shadow-sky-500 hover:shadow-md">
                <img class="object-cover w-full sm:w-1/3 h-[200px] sm:h-auto rounded-t-md sm:rounded-l-md sm:rounded-tr-none" src="{{ asset('storage/'.$post->preview) }}" alt="{{ $post->title }}">
                    <div class="relative sm:w-2/3">
                            <div class="p-3 pl-5">
                                <h3 class="line-clamp-1 mt-2 text-left text-[30px] sm:text-[35px] font-bold">
                                    {{ $post['title'] }} 
                                </h3>
                                <div class="flex gap-1 font-bold text-[13px] text-gray-900">
                                    @foreach($post->tags as $tag)
                                    <div class="bg-sky-300 p-1 mt-1 mb-2 rounded-md">{{ $tag->name }}</div>
                                    @endforeach
                                </div>
                                <p class="line-clamp-3 sm:line-clamp-6 text-[18px] sm:text-[22px] text-left">{{ html_entity_decode(strip_tags($post->description)) }}</p>
                                <div class="flex gap-3 mt-3 items-center dark:text-gray-900 text-white">
                                  <div class="flex items-center gap-2 rounded-md">
                                      <div>{{ $post->likes }}</div>
                                      <div disabled class="text-white dark:text-gray-900">
                                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                              <path d="M7.493 18.5c-.425 0-.82-.236-.975-.632A7.48 7.48 0 0 1 6 15.125c0-1.75.599-3.358 1.602-4.634.151-.192.373-.309.6-.397.473-.183.89-.514 1.212-.924a9.042 9.042 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75A.75.75 0 0 1 15 2a2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H14.23c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23h-.777ZM2.331 10.727a11.969 11.969 0 0 0-.831 4.398 12 12 0 0 0 .52 3.507C2.28 19.482 3.105 20 3.994 20H4.9c.445 0 .72-.498.523-.898a8.963 8.963 0 0 1-.924-3.977c0-1.708.476-3.305 1.302-4.666.245-.403-.028-.959-.5-.959H4.25c-.832 0-1.612.453-1.918 1.227Z" />
                                          </svg>                           
                                      </div>
                                  </div>
                                  <div class="flex items-center gap-2 rounded-md">
                                      <div>{{ $post->dislikes }}</div>
                                      <div disabled class="text-white dark:text-gray-900">
                                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                              <path d="M15.73 5.5h1.035A7.465 7.465 0 0 1 18 9.625a7.465 7.465 0 0 1-1.235 4.125h-.148c-.806 0-1.534.446-2.031 1.08a9.04 9.04 0 0 1-2.861 2.4c-.723.384-1.35.956-1.653 1.715a4.499 4.499 0 0 0-.322 1.672v.633A.75.75 0 0 1 9 22a2.25 2.25 0 0 1-2.25-2.25c0-1.152.26-2.243.723-3.218.266-.558-.107-1.282-.725-1.282H3.622c-1.026 0-1.945-.694-2.054-1.715A12.137 12.137 0 0 1 1.5 12.25c0-2.848.992-5.464 2.649-7.521C4.537 4.247 5.136 4 5.754 4H9.77a4.5 4.5 0 0 1 1.423.23l3.114 1.04a4.5 4.5 0 0 0 1.423.23ZM21.669 14.023c.536-1.362.831-2.845.831-4.398 0-1.22-.182-2.398-.52-3.507-.26-.85-1.084-1.368-1.973-1.368H19.1c-.445 0-.72.498-.523.898.591 1.2.924 2.55.924 3.977a8.958 8.958 0 0 1-1.302 4.666c-.245.403.028.959.5.959h1.053c.832 0 1.612-.453 1.918-1.227Z" />
                                          </svg>              
                                      </div>
                                  </div>
                              </div>
                            </div>
                                <span class="absolute top-2 right-2 text-[15px] flex items-center gap-1">{{ $post->views }} 
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 text-white dark:text-gray-900">
                                        <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                        <path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z" clip-rule="evenodd" />
                                    </svg>                                  
                              </span>
                            <div class="divide-gray-400 border-t-2 mt-1 flex justify-between items-center p-3 text-[17px] sm:text-[20px]">
                                <div class="text-sky-500 font-bold">{{ $user->name }}</div>
                                <div class="text-right text-sky-500">{{ $post->created_at->diffForHumans() }}</div>
                            </div>
                    </div>
                </li>
            </a>
        @endforeach
    </ul>
</x-base-layout>