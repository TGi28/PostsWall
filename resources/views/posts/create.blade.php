<x-base-layout>
    <x-slot:heading>
        <h1 class="text-3xl font-bold tracking-tight">Create a new Post</h1>
    </x-slot:heading>       
    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12">
                <h2 class="text-[30px] font-bold">New Post</h2>

                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-">
                    <x-form-field>
                        <x-form-label for="title">Title</x-form-label>
                        <div class="mt-2">
                            <x-form-input type="text" name="title" id="title" placeholder="Sharks and dolphins" required></x-form-input>
                            <x-form-error name="title"></x-form-error>
                        </div>
                    </x-form-field>

                    <div class="col-span-full">
                        <label for="description" class="block text-[20px] font-medium">Description</label>
                        <div class="mt-2 bg-white">
                            <div id="editor" class="block w-full h-full px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" required></div>
                            <input class="hidden" type="text" id="hiddenContent" name="description">
                        </div>
                        @error('description')
                            <div class="text-red-500 text-[14px] mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <x-form-field>
                        <x-form-label for="preview">Post preview</x-form-label>
                        <div class="text-[15px]" >Must be 400x400px</div>
                        <div class="mt-2 bg-white p-2 rounded-md">
                            <input type="file" name="preview" id="filePreview" class="text-gray-900">
                            <x-form-error name="preview"></x-form-error>
                        </div>
                    </x-form-field>

                    <x-form-field>
                        <x-form-label for="poster">Poster</x-form-label>
                        <div class="text-[15px]" >Must be 1000x400px</div>
                            <div class="mt-2 bg-white p-2 rounded-md">
                            <input type="file" name="poster" id="filePoster" class="text-gray-900">
                            <x-form-error name="poster"></x-form-error>
                        </div>
                    </x-form-field>

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
            <button type="button" class="text-sm/6 font-semibold p-2 rounded-md dark:bg-white dark:text-gray-900 bg-gray-900 text-white"><a href="/">Cancel</a></button>
            <x-form-button>Create</x-form-button>
        </div>
        </div>

    </form>
</x-base-layout>