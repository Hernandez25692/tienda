<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="bg-white rounded-xl shadow-md p-8 max-w-md w-full">
            <div class="flex flex-col items-center mb-6">
                <img src="{{ asset('storage/logos/logo1.png') }}" alt="Logo EncargaYa" class="h-16 mb-4">
                <h1 class="text-2xl font-bold text-gray-800 mb-2">¿Olvidaste tu contraseña?</h1>
                <p class="text-sm text-gray-600 text-center">
                    Ingresa tu correo para enviarte un enlace de restablecimiento.
                </p>
            </div>

            <!-- Mensaje de sesión -->
            @if (session('status'))
                <div class="mb-4 text-green-600 bg-green-100 border border-green-200 rounded p-3 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Errores de validación -->
            @if ($errors->any())
                <div class="mb-4 text-red-600 bg-red-100 border border-red-200 rounded p-3 text-sm">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Correo electrónico -->
                <div>
                    <x-input-label for="email" :value="'Correo electrónico'" />
                    <x-text-input
                        id="email"
                        class="block mt-1 w-full rounded shadow-sm focus:border-yellow-500 text-sm"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                        autofocus
                    />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600" />
                </div>

                <div class="mt-6">
                    <x-primary-button class="w-full bg-yellow-500 hover:bg-yellow-600 text-white rounded shadow-sm text-sm">
                        Enviar enlace de restablecimiento
                    </x-primary-button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <a href="{{ route('login') }}" class="text-sm text-gray-500 hover:text-yellow-600 underline">
                    &larr; Volver al inicio de sesión
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>
