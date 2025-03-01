<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <form method="POST" action="{{ route('login') }}" style="color: blue">
        @csrf
        <!-- Phone Number -->
        <div>
            <x-input-label for="phone" :value="__('Login (Phone number)')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="tel" name="phone" required autofocus autocomplete="phone" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                          type="password"
                          name="password"
                          required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
            <x-primary-link class="ms-3" href="/auth/telegram/redirect">
                {{ __('with Telegram') }}
            </x-primary-link>
        </div>
    </form>

    <script>
        // Telefon raqami inputiga +998 ni avtomatik qo'shish
        document.getElementById('phone').addEventListener('focus', function() {
            if (!this.value.startsWith('+998')) {
                this.value = '+998';
            }
        });
    </script>
</x-guest-layout>
