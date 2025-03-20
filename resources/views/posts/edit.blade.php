<x-base-layout>
    <x-slot:heading>
        <h1 class="text-3xl font-bold tracking-tight">Edit post "{{ $post->title }}"</h1>
    </x-slot:heading>
    <form action="{{ route('posts.update', $post->id) }}" method="POST">
    @csrf
    @method('patch')
    
        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12">
                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <x-form-field>
                        <x-form-label for="title">Title</x-form-label>
                        <div class="mt-2">
                            <x-form-input value="{{ $post->title }}" type="text" name="title" id="title" placeholder="Sharks and dolphins" required></x-form-input>
                            <x-form-error name="title"></x-form-error>
                        </div>
                    </x-form-field>

                    <div class="col-span-full">
                        <label for="description" class="block text-[20px] font-medium">Description</label>
                        <div class="mt-2 bg-white">
                            <div id="editor" class="block w-full h-full rounded-md px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" required>{!! $post->description !!}</div>
                            <input class="hidden" type="text" id="hiddenContent" name="description">
                        </div>
                        @error('description')
                            <div class="text-red-500 text-[14px] mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <x-form-field>
                        <x-form-label for="tag">Tag</x-form-label>
                        <div class="mt-2">
                            <x-form-input type="text" name="tag" id="tag" value="{{ $post->tags->pluck('name')->implode(', ') }}"></x-form-input>
                            <x-form-error name="tag"></x-form-error>
                        </div>
                    </x-form-field>
                </div>
            </div>
        </div>
        <div class="mt-6 flex items-center justify-end gap-x-6">
            <a href="/posts/{{ $post->id }}" class="text-sm/6 font-semibold text-gray-900">Cancel</a>
            <x-form-button>Update</x-form-button>
        </div>
    </form>
</x-base-layout>