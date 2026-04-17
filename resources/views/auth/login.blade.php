<x-guest-layout>
    <x-slot name="beforePanel">
        <div class="rounded-lg border border-blue-200 bg-blue-50 px-4 py-3 text-sm text-blue-900 shadow-sm dark:border-blue-700 dark:bg-blue-950/40 dark:text-blue-100">
            <p class="font-semibold">{{ __('Demo account') }}</p>
            <div class="mt-2 grid gap-1">
                <p><span class="font-semibold">{{ __('messages.email') }}:</span> demo@demo.com</p>
                <p><span class="font-semibold">{{ __('messages.current_password') }}:</span> Demo.1234</p>
            </div>
        </div>
    </x-slot>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div>
            <x-input-label for="email" :value="__('messages.email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('messages.current_password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('messages.remember_me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-blue-600 rounded-md" href="{{ route('password.request') }}">
                    {{ __('messages.forgot_password') }}
                </a>
            @endif
            <x-primary-button class="ms-3">
                {{ __('messages.login') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
