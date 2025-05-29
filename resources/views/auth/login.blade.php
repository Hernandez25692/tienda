<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Login | EncargaYa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Tailwind (si usas Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 text-gray-800 m-0 p-0">

    <section
        class="min-h-screen w-full flex items-center justify-center px-2 sm:px-4 bg-gradient-to-br from-yellow-100 via-white to-yellow-50 relative overflow-hidden">

        <!-- FONDO ANIMADO -->
        <div class="absolute inset-0 z-0 pointer-events-none">
            <div
                class="absolute top-[-100px] left-[-100px] w-[180px] h-[180px] sm:w-[300px] sm:h-[300px] bg-purple-500 rounded-full opacity-20 blur-3xl">
            </div>
            <div
                class="absolute bottom-[-100px] right-[-100px] w-[220px] h-[220px] sm:w-[400px] sm:h-[400px] bg-indigo-500 rounded-full opacity-20 blur-3xl">
            </div>
        </div>

        <!-- CONTENIDO HORIZONTAL -->
        <div
            class="relative z-10 w-full max-w-lg sm:max-w-2xl md:max-w-4xl lg:max-w-6xl grid grid-cols-1 md:grid-cols-2 bg-white rounded-xl sm:rounded-2xl shadow-2xl overflow-hidden">

            <!-- LADO IZQUIERDO: PRESENTACIÓN -->
            <div class="hidden md:flex bg-gradient-to-br from-yellow-500 to-yellow-600 text-white flex-col justify-center p-6 sm:p-10">
                <div class="flex justify-center">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('storage/logos/logo2.png') }}" alt="Logo"
                            class="h-16 sm:h-24 mb-4 sm:mb-6 object-contain transition-transform duration-300 hover:scale-110 max-w-full">
                    </a>
                </div>
                <h1 class="text-2xl sm:text-4xl font-bold leading-snug">Bienvenido a <span
                        class="text-white underline">EncargaYa</span></h1>
                <p class="mt-2 sm:mt-4 text-base sm:text-lg opacity-90">
                    Tu tienda virtual confiable para productos únicos, modernos y accesibles.
                </p>
                <ul class="mt-4 sm:mt-6 space-y-2 sm:space-y-3 text-xs sm:text-sm">
                    <li><i class="fas fa-box-open mr-2"></i> Catálogo actualizado</li>
                    <li><i class="fas fa-user-check mr-2"></i> Compra segura</li>
                    <li><i class="fas fa-truck-fast mr-2"></i> Entregas a todo el país</li>
                </ul>
            </div>

            <!-- LADO DERECHO: FORMULARIO -->
            <div class="p-4 sm:p-8 md:p-10 bg-white flex items-center justify-center">
                <div class="w-full max-w-xs sm:max-w-sm">
                    <h2 class="text-xl sm:text-2xl font-bold text-center mb-4 sm:mb-6 text-gray-700">Iniciar Sesión</h2>

                    @if (session('status'))
                        <div class="mb-4 text-sm text-green-600 font-medium">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="space-y-4 sm:space-y-5">
                        @csrf

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-xs sm:text-sm font-medium text-gray-700">Correo electrónico</label>
                            <input id="email" name="email" type="email" required autofocus
                                class="mt-1 w-full px-3 py-2 sm:px-4 sm:py-2 rounded border border-gray-300 focus:ring-yellow-500 focus:border-yellow-500 shadow-sm text-sm sm:text-base">
                            <x-input-error :messages="$errors->get('email')" class="text-xs sm:text-sm text-red-600 mt-1" />
                        </div>

                        <!-- Password -->
                        <div x-data="{ show: false }" class="relative">
                            <label for="password" class="block text-xs sm:text-sm font-medium text-gray-700">Contraseña</label>
                            <input :type="show ? 'text' : 'password'" id="password" name="password" required
                                class="mt-1 w-full px-3 py-2 sm:px-4 sm:py-2 rounded border border-gray-300 focus:ring-yellow-500 focus:border-yellow-500 shadow-sm pr-8 sm:pr-10 text-sm sm:text-base">
                            <button type="button" @click="show = !show"
                                class="absolute right-2 sm:right-3 top-8 sm:top-9 text-gray-500 hover:text-gray-700 focus:outline-none"
                                tabindex="-1">
                                <i :class="show ? 'fa fa-eye-slash' : 'fa fa-eye'"></i>
                            </button>
                            <x-input-error :messages="$errors->get('password')" class="text-xs sm:text-sm text-red-600 mt-1" />
                        </div>

                        <!-- Recordarme -->
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-2">
                            <label class="flex items-center text-xs sm:text-sm text-gray-600">
                                <input type="checkbox" name="remember"
                                    class="rounded border-gray-300 text-yellow-600 shadow-sm focus:ring-yellow-500">
                                <span class="ml-2">Recordarme</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}"
                                    class="text-xs sm:text-sm text-yellow-600 hover:underline">
                                    ¿Olvidaste tu contraseña?
                                </a>
                            @endif
                        </div>

                        <!-- Botón -->
                        <div>
                            <button type="submit"
                                class="w-full py-2 px-4 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded shadow transition text-sm sm:text-base">
                                Iniciar sesión
                            </button>
                        </div>
                    </form>

                    <!-- Registro -->
                    <div class="mt-4 sm:mt-6 text-center">
                        <p class="text-xs sm:text-sm text-gray-600">¿No tienes cuenta?</p>
                        <a href="{{ route('register') }}"
                            class="text-yellow-600 hover:text-yellow-800 font-semibold text-xs sm:text-sm mt-1 inline-block">
                            Crear una cuenta
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>

</html>
