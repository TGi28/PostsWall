<x-base-layout>
    <x-slot:heading>
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">Settings</h1>
    </x-slot:heading>
    @session('status')
        <div class="text-green-500 text-[18px] mt-1">{{ $value }}</div>
    @endsession
    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
        <form class="space-y-6" action="/settings" method="POST">
          @csrf
          @method('patch')
          <div>
              <label for="name" class="block text-sm/6 font-medium">First and Last name</label>
              <div class="mt-2">
                <input value="{{ auth()->user()->name }}" type="name" name="name" id="name" autocomplete="name" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-sky-500 sm:text-sm/6">
              </div>
              @error('name')
                <div class="text-red-500 text-[18px] mt-1">{{ $message }}</div>
              @enderror
            </div>
          <div>
            <label for="email" class="block text-sm/6 font-medium">Email address</label>
            <div class="mt-2">
              <input value="{{ auth()->user()->email }}" type="email" name="email" id="email" autocomplete="email" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-sky-500 sm:text-sm/6">
            </div>
            @error('email')
                <div class="text-red-500 text-[18px] mt-1">{{ $message }}</div>
              @enderror
          </div>    
          <div>
            <button type="submit" class="flex w-full justify-center rounded-md bg-sky-500 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-sky-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-500">Save</button>
          </div>
        </form>

</x-base-layout>