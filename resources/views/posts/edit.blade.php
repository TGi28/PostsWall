<x-layout>
    <x-slot:heading>
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">Edit post "{{ $post->title }}"</h1>
    </x-slot:heading>
    <form action="{{ route('posts.update', $post->slug) }}" method="POST">
    @csrf
    @method('patch')
    
        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12">
                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <x-form-field>
                        <x-form-label for="title">Title</x-form-label>
                        <div class="mt-2">
                            <x-form-input type="text" name="title" id="title" placeholder="$10000" value="{{ $post->title }}"></x-form-input>
                            <x-form-error name="title"></x-form-error>
                        </div>
                    </x-form-field>

                    <div class="sm:col-span-4">
                        <label for="description" class="block text-sm/6 font-medium text-gray-900">Description</label>
                        <div class="mt-2">
                            <div class="flex flex-col pl-3 pr-3 outline-1 -outline-offset-1 outline-gray-300 focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-600">
                               <div class="mt-2" id="editor" style="height: 300px;">{!! $post->description !!}</div>
                                <input type="hidden" name="description" id="hiddenContent">
                            </div>
                            @error('description')
                                <div class="text-red-500 text-[14px] mt-1">{{ $message }}</div>
                            @enderror
                        </div>
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
            <a href="/posts/{{ $post->slug }}" class="text-sm/6 font-semibold text-gray-900">Cancel</a>
            <x-form-button>Update</x-form-button>
        </div>
    </form>
</x-layout>