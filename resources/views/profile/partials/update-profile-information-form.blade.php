<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('messages.profile_info') }}</h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ __('messages.profile_msg') }}</p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf @method('patch')
        <div>
            <x-input-label for="name" :value="__('messages.name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>
        <div>
            <x-input-label for="email" :value="__('messages.email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('messages.save') }}</x-primary-button>
            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600 dark:text-gray-400">{{ __('messages.saved') }}</p>
            @endif
        </div>
    </form>
</section>