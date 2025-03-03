@props(['name'])
@error($name)
    <div class="text-red-500 text-[14px] mt-1">{{ $message }}</div>
@enderror