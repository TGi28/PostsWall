<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-full">
      <div class="mt-8 ml-8">
        <a href="/" class="text-white bg-sky-500 hover:bg-sky-400 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-[12px] lg:text-[20px] px-5 py-2.5 text-center inline-flex items-center dark:bg-sky-500 dark:hover:bg-sky-400 dark:focus:ring-blue-800">
            &larr; Back
            </a>  
      </div>
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
          <img src="{{ asset('images/TGi.png') }}" alt="TGi" class="m-auto h-auto">
          <h2 class="mt-7 text-center text-2xl/9 font-bold tracking-tight text-gray-900">Create a new account</h2>
        </div>
        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
          @session('status')
            <div class="text-red-500 text-[18px] mt-1">{{ $value }}</div>
          @endsession
          <form class="space-y-6" action="/register" method="POST">
            @csrf
            <div>
                <label for="first_name" class="block text-sm/6 font-medium text-gray-900">First name</label>
                <div class="mt-2">
                  <input type="first_name" name="first_name" id="first_name" autocomplete="first_name" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-sky-500 sm:text-sm/6">
                </div>
                @error('first_name')
                  <div class="text-red-500 text-[18px] mt-1">{{ $message }}</div>
                @enderror
              </div>
            <div>
            <label for="last_name" class="block text-sm/6 font-medium text-gray-900">Last name</label>
            <div class="mt-2">
                <input type="last_name" name="last_name" id="last_name" autocomplete="last_name" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-sky-500 sm:text-sm/6">
            </div>
              @error('last_name')
                <div class="text-red-500 text-[18px] mt-1">{{ $message }}</div>
              @enderror
            </div>
            <div>
              <label for="email" class="block text-sm/6 font-medium text-gray-900">Email address</label>
              <div class="mt-2">
                <input type="email" name="email" id="email" autocomplete="email" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-sky-500 sm:text-sm/6">
              </div>
              @error('email')
                <div class="text-red-500 text-[18px] mt-1">{{ $message }}</div>
              @enderror
            </div>
      
            <div>
              <div class="flex items-center justify-between">
                <label for="password" class="block text-sm/6 font-medium text-gray-900">Password</label>
              </div>
              <div class="mt-2">
                <input type="password" name="password" id="password" autocomplete="current-password" required class="block w-full rounded-md px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-sky-500 sm:text-sm/6">
              </div>
              @error('password')
                <div class="text-red-500 text-[18px] mt-1">{{ $message }}</div>
              @enderror
            </div>
      
            <div>
              <button type="submit" class="flex w-full justify-center rounded-md bg-sky-500 px-3 py-1.5 text-[18px] font-semibold shadow-xs hover:bg-sky-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-500">Register</button>
            </div>
          </form>
        </div>
      </div>
</body>