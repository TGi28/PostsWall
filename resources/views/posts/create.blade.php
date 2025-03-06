<x-layout>
    <x-slot:heading>
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">Create a new Post</h1>
    </x-slot:heading>       
    <form action="{{ route('posts.store') }}" method="POST">
        @csrf

        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12">
                <h2 class="text-base/7 font-semibold text-white">New Post</h2>
                <p class="mt-1 text-sm/6 text-white">We need title and description of your post, it can be anything!</p>

                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-">
                    <x-form-field>
                        <x-form-label for="title">Title</x-form-label>
                        <div class="mt-2">
                            <x-form-input type="text" name="title" id="title" placeholder="Sharks and dolphins" required></x-form-input>
                            <x-form-error name="title"></x-form-error>
                        </div>
                    </x-form-field>

                    <div class="col-span-full">
                        <label for="editor" class="block text-sm/6 font-medium text-white">Description</label>
                        <div class="mt-2 bg-white">
                            <div name="description" id="editor" class="block w-full h-full rounded-md px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" required></div>
                        </div>
                        @error('description')
                            <div class="text-red-500 text-[14px] mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <x-form-field>
                        <x-form-label for="tag">Tags</x-form-label>
                        <div class="mt-2">
                            <x-form-input type="text" name="tag" id="tag" placeholder="football" required></x-form-input>
                            <x-form-error name="tag"></x-form-error>
                        </div>
                    </x-form-field>
                </div>
            </div>
        <div class="mt-6 flex items-center justify-end gap-x-6">
            <button type="button" class="text-sm/6 font-semibold text-white"><a href="/">Cancel</a></button>
            <x-form-button>Create</x-form-button>
        </div>
        </div>

    </form>
</x-layout>