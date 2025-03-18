<div>
    <form wire:submit="storeAvatar" class="p-3 mt-3 rounded-md">
        <div class="flex items-center justify-center w-full">
            <label for="avatar" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer dark:bg-gray-50 bg-gray-700 dark:hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 hover:bg-gray-600">
                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                    @if ($previewUrl)
                        <img src="{{ $previewUrl }}" class="w-32 h-32 object-cover rounded-full mb-4">
                        <button onclick="{{ $previewUrl = null }}">x</button>
                    @else
                        <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                        </svg>
                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                    @endif
                </div>
                <input wire:model="avatar" type="file" id="avatar" class="hidden" accept="image/*" />
            </label>
        </div>
        <div class="text-center mt-4">
            <x-form-button class="text-[30px]">Save</x-form-button>
        </div>
    </form>
</div>
