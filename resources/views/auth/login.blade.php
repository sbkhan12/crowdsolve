<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <img src="/images/logo.png" alt="CrowdSolve Logo" class="w-20 h-20 mx-auto">
            </a>
            <h2 class="text-center mt-3 text-lg font-semibold text-gray-700">CrowdSolve Login</h2>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email')" />
                <x-input id="email" class="block mt-1 w-full"
                         type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />
                <x-input id="password" class="block mt-1 w-full"
                         type="password" name="password" required autocomplete="current-password" />
            </div>

            <!-- Role Info (non-editable) -->
            <div class="mt-4 text-sm text-gray-600">
                <p><strong>Note:</strong> Your dashboard and permissions depend on your assigned role:</p>
                <ul class="list-disc list-inside text-xs mt-2 text-gray-500">
                    <li>👤 <strong>Citizen:</strong> Report and vote on issues</li>
                    <li>🧠 <strong>Expert:</strong> Review and suggest solutions</li>
                    <li>🏛️ <strong>Authority:</strong> Assign and manage problems</li>
                    <li>🛡️ <strong>Admin:</strong> Full access to user and issue management</li>
                </ul>
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox"
                           class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                           name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-between mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900"
                       href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-button class="ml-3">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
