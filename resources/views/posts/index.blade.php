<x-base-layout>
    <x-slot:heading>
        <h1 class="sm:text-[40px] text-[35px] font-bold tracking-tight text-white dark:text-gray-900 text-center sm:text-left">All posts</h1>
        <div class="flex items-center gap-4 w-full sm:w-1/2 mt-3 sm:mt-0">
            <form class="flex-1" action="{{ route('posts.search') }}" method="GET">   
              <div class="flex">
                <label for="search-dropdown" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Your Email</label>
                <button id="dropdown-button" data-dropdown-toggle="dropdown" class="shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-900 bg-gray-100 border border-gray-300 rounded-s-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700 dark:text-white dark:border-gray-600" type="button">Sort <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                </svg></button>
                <div id="dropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700">
                    <ul class="py-2 text-sm text-gray-900 dark:text-white" aria-labelledby="dropdown-button" id="menu">
                    <li>
                      <a href="{{ route('posts.index', ['sort' => 'views']) }}" class="block px-4 py-2 text-sm {{ request('sort') == 'views' ? "font-bold text-sky-500" : 'font-normal ' }}" role="menuitem" tabindex="-1" id="menu-item-1">Popular</a>
                    </li>
                    <li>
                      <a href="{{ route('posts.index', ['sort' => 'latest']) }}" class="block px-4 py-2 text-sm {{ request('sort') == 'latest' ? "font-bold text-sky-500" : 'font-normal' }}" role="menuitem" tabindex="-1" id="menu-item-0">Latest</a>
                    </li>
                    <li>
                      <a href="{{ route('posts.index', ['sort' => 'oldest']) }}" class="block px-4 py-2 text-sm {{ request('sort') == 'oldest' ? "font-bold text-sky-500" : 'font-normal' }}" role="menuitem" tabindex="-1" id="menu-item-1">Oldest</a>
                    </li>
                    </ul>
                </div>
                <div class="relative w-full">
                    <input type="search" id="search-dropdown" name="query" class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-e-lg border-s-gray-50 border-s-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-s-gray-700  dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500" placeholder="Search..." required />
                    <button type="submit" class="absolute top-0 end-0 p-2.5 text-sm font-medium h-full text-white bg-sky-500 rounded-e-lg border border-sky-500 hover:bg-sky-600 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-sky-500 dark:hover:bg-sky-600 dark:focus:ring-sky-700">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                        <span class="sr-only">Search</span>
                    </button>
                </div>
            </div>
            </form>
        </div>
    </x-slot:heading>
    <ul class="grid grid-cols-1 sm:grid-rows-1 gap-3 text-center mt-2">
        @foreach($posts as $post)
            <x-post-card :$post />
        @endforeach
    </ul>
    <div class="mt-4">{{ $posts->appends(['sort' => request('sort')])->links() }}</div>
</x-base-layout>