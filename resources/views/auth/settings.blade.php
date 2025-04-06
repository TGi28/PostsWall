<x-base-layout>
    <x-slot:heading>
        <h1 class="sm:text-[40px] text-[35px] font-bold tracking-tight text-gray-900">Settings</h1>
    </x-slot:heading>
    @session('status')
        <div class="text-green-500 text-[18px] mt-1">{{ $value }}</div>
    @endsession
    <div class="mt-10 text-[20px] sm:mx-auto sm:w-full sm:max-w-sm">
        <form class="space-y-6" action="/settings" method="POST">
          @csrf
          @method('patch')
          <div>
              <label for="name" class="block font-medium text-[35px]">First and Last name</label>
              <div class="mt-2">
                <input value="{{ auth()->user()->name }}" type="name" name="name" id="name" autocomplete="name" required class="block w-full rounded-md bg-white px-3 py-1.5 text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-sky-500">
              </div>
              @error('name')
                <div class="text-red-500 text-[18px] mt-1">{{ $message }}</div>
              @enderror
            </div>
          <div>
            <label for="email" class="block font-medium text-[35px]">Email address</label>
            <div class="mt-2">
              <input value="{{ auth()->user()->email }}" type="email" name="email" id="email" autocomplete="email" required class="block w-full rounded-md bg-white px-3 py-1.5 text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-sky-500">
            </div>
            @error('email')
                <div class="text-red-500 text-[18px] mt-1">{{ $message }}</div>
              @enderror
          </div>    
          <div class="flex justify-center">
            <button type="submit" class="rounded-md bg-sky-500 px-3 py-1.5 font-semibold text-white shadow-xs hover:bg-sky-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-500">Save</button>
          </div>
        </form>

</x-base-layout>