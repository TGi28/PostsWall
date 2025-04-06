<!DOCTYPE html>
  <html lang="en" class="h-full bg-gray-100">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <title>Home Page</title>
      <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
      <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
      <script src="https://cdn.tailwindcss.com"></script>
      @vite(['resources/js/app.js','resources/css/app.css'])
      <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
      @livewireStyles
  </head>
<body class="h-full">
<div class="min-h-full bg-gray-100 dark:bg-gray-800">
  <nav class="bg-gray-100 dark:bg-gray-800 opacity-100 sticky top-0 z-50">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="flex h-16 items-center justify-between">
        <div class="flex items-center">
          <div class="shrink-0 flex items-center gap-2">
            <img src="{{ asset('images/TGi.png') }}" alt="TGi" class="m-auto h-auto">
            @auth
                  <div class="sm:hidden"><livewire:notifications /></div>
            @endauth
          </div>
          <div class="hidden md:block">
            <div class="ml-10 flex items-baseline space-x-4">
                <x-nav-link href="/" :active="request()->is('/')">Home</x-nav-link>
                  <x-nav-link href="/posts?sort=views" :active="(request()->is('posts') || request()->is('search')) && !request()->is('posts/create')">All Posts</x-nav-link>
                  <x-nav-link href="/authors" :active="request()->is('authors')">Authors</x-nav-link>
                  <x-nav-link href="/tags" :active="request()->is('tags')">Tags</x-nav-link>
                  @auth
                    <x-nav-link href="/chats" :active="request()->is('chats')">Chats</x-nav-link>
                    <a href="/posts/create" class="{{  (request()->is('posts/create')) ? 'bg-black text-sky-500' : 'bg-sky-500 text-gray-100'}} rounded-md px-3 py-2 text-sm font-medium">Create Post</a>
                  @endauth
            </div>
          </div>
        </div>
        <div class="hidden md:block">
          <div class="ml-4 flex items-center md:ml-6">
            <div class="relative ml-3">
              <div class="flex">
              @guest
                  
                  <x-nav-link href="/login" :active="request()->is('/login')">Login</x-nav-link>
                  <x-nav-link href="/register" :active="request()->is('/register')">Register</x-nav-link>
              @endguest
              @auth
                <livewire:notifications />
                <div>
                  <button id="dropdownOffsetButton" data-dropdown-toggle="dropdownSkidding" data-dropdown-offset-distance="-20" data-dropdown-offset-skidding="80" data-dropdown-placement="left" class="text-white bg-sky-500 hover:bg-sky-600 focus:outline-none focus:ring-blue-300 font-medium rounded-full inline-flex items-center dark:bg-sky-500 dark:hover:bg-sky-600" type="button">
                    <img class="rounded-full" width="45" height="45" src="@if( auth()->user()->avatar) {{ asset(auth()->user()->avatar) }} @else https://img.icons8.com/fluency-systems-filled/48/user-male-circle.png @endif" alt="user-male-circle"/>
                  </button>
                  <div id="dropdownSkidding" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700">
                      <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                        <li>
                          <a href="/profile" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 hover:text-sky-500">Profile</a>
                        </li>
                        <li>
                          <a href="/settings" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 hover:text-sky-500">Settings</a>
                        </li>
                        <li>
                          <a href="/logout" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 hover:text-sky-500">Sign out</a>
                        </li>
                      </ul>
                  </div>
                </div>
              @endauth
              </div>
            </div>
          </div>
        </div>
        <div class="-mr-2 flex md:hidden items-center">
          <div>
            <div class="flex items-center md:ml-6">
              <div class="relative ml-3">
                <div class="flex items-center gap-3">
                @guest
                    <x-nav-link href="/login" :active="request()->is('/login')">Login</x-nav-link>
                    <x-nav-link href="/register" :active="request()->is('/register')">Register</x-nav-link>
                @endguest
                
                <div class="hidden">
                  @auth
                    <livewire:notifications />
                  @endauth
                </div>
                  
                  @auth
                  <button id="dropdownOffsetButton" data-dropdown-toggle="profileMobile" class="text-white bg-sky-500 hover:bg-sky-600 focus:outline-none focus:ring-blue-300 font-medium rounded-full inline-flex items-center dark:bg-sky-500 dark:hover:bg-sky-600" type="button">
                    <img width="30" height="30" src="https://img.icons8.com/fluency-systems-filled/48/user-male-circle.png" alt="user-male-circle"/>
                  </button>
  
                  <!-- Dropdown menu -->
                  <div id="profileMobile" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700">
                      <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                        <li>
                          <a href="/profile" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 hover:text-sky-500">Profile</a>
                        </li>
                        <li>
                          <a href="/settings" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 hover:text-sky-500">Settings</a>
                        </li>
                        <li>
                          <a href="/logout" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 hover:text-sky-500">Sign out</a>
                        </li>
                      </ul>
                  </div>
                @endauth
                <button id="dropdownOffsetButton" data-dropdown-toggle="mobiledropdownSkidding" class="rounded-md bg-gray-800 p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800 focus:outline-hidden" type="button">
                  <svg class="block size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                  </svg>
                </button>

                <div id="mobiledropdownSkidding" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700">
                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                      <li>
                        <a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 hover:text-sky-500" href="/" :active="request()->is('/')">Home</a>
                      </li>
                      <li>
                        <a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 hover:text-sky-500" href="/posts?sort=views" :active="(request()->is('posts') || request()->is('search')) && !request()->is('posts/create')">All Posts</a>
                      </li>
                      <li>
                        <a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 hover:text-sky-500" href="/authors" :active="request()->is('authors')">Authors</a>
                      </li>
                      <li>
                        <a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 hover:text-sky-500" href="/tags" :active="request()->is('tags')">Tags</a>
                      </li>
                      @auth  
                      <li>
                        <a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 hover:text-sky-500" href="/posts/create" class="{{  (request()->is('posts/create')) ? 'bg-black text-sky-500' : 'bg-sky-500 text-gray-100'}} rounded-md px-3 py-2 text-sm font-medium">Create Post</a>
                      </li>
                      @endauth
                    </ul>
                </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </nav>
  <div class="w-full sm:w-1/3 sm:px-6 lg:px-8 dark:text-gray-900 text-white">
    <livewire:chats />
      </div>
  </div>
  

  @livewireScriptConfig
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
  <script>

    function callHandler() {
    return {
        isReceiving: false,
        isInCall: false,
        peerConnection: null,
        remoteStream: null,

        initPusher() {
          const userId = @json(auth()->id());
            Echo.private(`calls.${userId}`)
                .listen("CallInitiated", (event) => {
                    this.isReceiving = true;
                })
                .listen("CallAccepted", () => {
                    this.startPeerConnection();
                });
        },


        startCall(receiverId) {
            if (typeof Livewire !== "undefined") {
                Livewire.dispatch("initiateCall", receiverId);
            }
        },
        
        acceptCall() {
            this.isReceiving = false;
            this.isInCall = true;
            if (typeof Livewire !== "undefined") {
                Livewire.dispatch("callAccepted");
            }
            this.startPeerConnection();
        },

        startPeerConnection() {
            this.peerConnection = new RTCPeerConnection({
                iceServers: [{ urls: "stun:stun.l.google.com:19302" }],
            });

            navigator.mediaDevices.getUserMedia({ audio: true }).then((stream) => {
                stream.getTracks().forEach((track) => this.peerConnection.addTrack(track, stream));

                this.peerConnection.ontrack = (event) => {
                    document.querySelector("audio").srcObject = event.streams[0];
                };
            });

            this.peerConnection.createOffer().then((offer) => {
                this.peerConnection.setLocalDescription(offer);
                Echo.channel("calls").whisper("call-offer", { offer });
            });

            Echo.channel("calls").listenForWhisper("call-offer", (event) => {
                this.peerConnection.setRemoteDescription(new RTCSessionDescription(event.offer));
                this.peerConnection.createAnswer().then((answer) => {
                    this.peerConnection.setLocalDescription(answer);
                    Echo.channel("calls").whisper("call-answer", { answer });
                });
            });

            Echo.channel("calls").listenForWhisper("call-answer", (event) => {
                this.peerConnection.setRemoteDescription(new RTCSessionDescription(event.answer));
            });
        },

        endCall() {
            this.peerConnection.close();
            this.isInCall = false;
        },
    };
}

  </script>
</body>
</html>
