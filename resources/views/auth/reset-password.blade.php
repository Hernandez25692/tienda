<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="w-full max-w-md bg-white rounded-xl shadow-md p-8">
            <div class="flex flex-col items-center mb-6">
                <img src="{{ asset('storage/logos/logo1.png') }}" alt="Logo EncargaYa" class="h-16 mb-4">
                <h2 class="text-2xl font-semibold text-gray-700 mb-2">{{ __('Restablecer Contraseña') }}</h2>
                <p class="text-gray-500 text-sm text-center">{{ __('Ingresa tu correo electrónico y la nueva contraseña para restablecer tu cuenta.') }}</p>
            </div>
            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                <!-- Token para restablecer contraseña -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Correo electrónico -->
                <div class="mb-4">
                    <x-input-label for="email" :value="__('Correo electrónico')" class="font-semibold text-gray-700" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600" />
                </div>

                <!-- Contraseña -->
                <div class="mb-4">
                    <x-input-label for="password" :value="__('Contraseña')" class="font-semibold text-gray-700" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600" />
                </div>

                <!-- Confirmar contraseña -->
                <div class="mb-4">
                    <x-input-label for="password_confirmation" :value="__('Confirmar contraseña')" class="font-semibold text-gray-700" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full"
                        type="password"
                        name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-600" />
                </div>

                <div class="flex items-center justify-end mt-6">
                    <button type="submit"
                        class="w-full py-2 px-4 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-lg shadow transition-colors duration-200">
                        {{ __('Restablecer Contraseña') }}
                    </button>
                </div>
            </form>
            <div class="mt-6 text-center">
                <a href="{{ route('login') }}" class="text-yellow-600 hover:underline font-semibold">
                    {{ __('Volver al inicio de sesión') }}
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>
