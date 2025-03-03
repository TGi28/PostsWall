<x-layout>
    <x-slot:heading>
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">Login</h1>
    </x-slot:heading>
    @session('status')
        <div class="text-red-500 text-[14px] mt-1">{{ $value }}</div>
    @endsession
    <form action="/login" method="POST">
        @csrf

        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12 flex justify-center">
                <div class="mt-10 flex flex-col text-center gap-8 justify-center w-8/12">
                    <x-form-field>
                        <x-form-label class="text-[30px]" for="email">Email</x-form-label>
                        <div class="mt-2">
                            <x-form-input value="{{ old('email') }}" type="text" name="email" id="email" required></x-form-input>
                            <x-form-error name="email"></x-form-error>
                        </div>
                    </x-form-field>

                    <x-form-field>
                        <x-form-label class="text-[30px]" for="password">Password</x-form-label>
                        <div class="mt-2">
                            <x-form-input type="password" name="password" id="password" required></x-form-input>
                            <x-form-error name="password"></x-form-error>
                        </div>
                    </x-form-field>
                </div>
            </div>
        <div class="mt-6 flex items-center justify-end gap-x-6">
        <button type="button" class="text-sm/6 font-semibold text-gray-900"><a href="/">Cancel</a></button>
            <x-form-button>Login</x-form-button>
        </div>
        </div>

    </form>

</x-layout>