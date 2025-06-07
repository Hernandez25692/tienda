<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EncargaYa - Tu Tienda Virtual de Confianza</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,600,700" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">

</head>

<body
    class="bg-gradient-to-br from-yellow-50 to-white min-h-screen flex flex-col items-center justify-between text-gray-800">

    <!-- Header -->
    <header class="w-full max-w-6xl flex flex-col sm:flex-row justify-between items-center p-4 sm:p-6 gap-3 sm:gap-0">
        <div class="flex items-center gap-2 sm:gap-3">
            <a href="{{ url()->current() }}" class="group focus:outline-none">
                <img src="{{ asset('storage/logos/logo1.png') }}" alt="Logo EncargaYa"
                    class="h-12 w-auto sm:h-16 transition duration-200 group-hover:brightness-110 group-hover:drop-shadow-lg cursor-pointer"
                    style="max-width: 180px;">
            </a>

        </div>

        @if (Route::has('login'))
            <nav class="flex flex-col sm:flex-row gap-2 sm:gap-3 mt-3 sm:mt-0 w-full sm:w-auto">
                @auth
                    <a href="{{ url('/dashboard') }}"
                        class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition text-center">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="px-4 py-2 border border-yellow-500 text-yellow-600 rounded hover:bg-yellow-100 transition text-center">
                        Iniciar Sesión
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition text-center">
                            Registrarse
                        </a>
                    @endif
                @endauth
            </nav>
        @endif
    </header>

    <!-- Hero Main Section -->
    <main class="flex flex-col items-center text-center px-3 py-8 sm:px-4 sm:py-12 max-w-full sm:max-w-3xl w-full">
        <h2 class="text-2xl sm:text-4xl md:text-5xl font-bold text-gray-900 leading-tight mb-4 sm:mb-6">
            Productos únicos, estilo moderno, todo en un solo lugar
        </h2>
        <p class="text-base sm:text-lg text-gray-700 mb-6 sm:mb-8 px-1 sm:px-0">
            <strong>EncargaYa</strong> es tu tienda virtual confiable donde encuentras lo último en moda, tecnología,
            hogar y más. Ofrecemos una selección de productos increíbles, muchos inspirados en plataformas como Amazon,
            Shein y otras tiendas populares.
        </p>

        <div class="flex flex-col sm:flex-row flex-wrap justify-center gap-3 sm:gap-4 w-full">
            <a href="{{ route('catalogo.publico') }}"
                class="px-5 py-3 bg-yellow-500 text-white rounded-md font-semibold hover:bg-yellow-600 transition text-center w-full sm:w-auto">
                Explorar Catálogo
            </a>
            <!-- Botón solo visible en móvil -->
            <button id="como-funciona-toggle" type="button"
                class="px-5 py-3 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-100 transition text-center w-full sm:hidden">
                ¿Cómo funciona?
            </button>
            <!-- En desktop, el enlace normal -->
            <a href="#como-funciona"
                class="px-5 py-3 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-100 transition text-center w-full sm:w-auto hidden sm:inline-block">
                ¿Cómo funciona?
            </a>
        </div>
    </main>

    <!-- Sección: ¿Cómo funciona? -->
    <section id="como-funciona"
        class="w-full max-w-6xl mt-10 sm:mt-20 bg-white py-10 sm:py-16 px-3 sm:px-6 rounded-xl shadow-md
        transition-all duration-300
        sm:block
        hidden">
        <h2 class="text-2xl sm:text-3xl font-bold text-center text-yellow-600 mb-6 sm:mb-10">¿Cómo funciona EncargaYa?
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 sm:gap-8 text-center">
            <!-- Paso 1 -->
            <div class="flex flex-col items-center">
                <div
                    class="bg-yellow-100 text-yellow-600 w-14 h-14 sm:w-16 sm:h-16 flex items-center justify-center rounded-full shadow mb-3 sm:mb-4">
                    <i class="fas fa-search text-xl sm:text-2xl"></i>
                </div>
                <h3 class="font-semibold text-base sm:text-lg mb-1 sm:mb-2">Explora productos</h3>
                <p class="text-xs sm:text-sm text-gray-600">Revisa nuestro catálogo o dinos qué deseas comprar.</p>
            </div>
            <!-- Paso 2 -->
            <div class="flex flex-col items-center">
                <div
                    class="bg-yellow-100 text-yellow-600 w-14 h-14 sm:w-16 sm:h-16 flex items-center justify-center rounded-full shadow mb-3 sm:mb-4">
                    <i class="fas fa-cart-plus text-xl sm:text-2xl"></i>
                </div>
                <h3 class="font-semibold text-base sm:text-lg mb-1 sm:mb-2">Solicita tu pedido</h3>
                <p class="text-xs sm:text-sm text-gray-600">Regístrate, selecciona el producto y solicita tu compra
                    fácilmente.</p>
            </div>
            <!-- Paso 3 -->
            <div class="flex flex-col items-center">
                <div
                    class="bg-yellow-100 text-yellow-600 w-14 h-14 sm:w-16 sm:h-16 flex items-center justify-center rounded-full shadow mb-3 sm:mb-4">
                    <i class="fas fa-money-bill-wave text-xl sm:text-2xl"></i>
                </div>
                <h3 class="font-semibold text-base sm:text-lg mb-1 sm:mb-2">Realiza el pago</h3>
                <p class="text-xs sm:text-sm text-gray-600">Te confirmamos el precio y el método de pago más conveniente
                    para ti.</p>
            </div>
            <!-- Paso 4 -->
            <div class="flex flex-col items-center">
                <div
                    class="bg-yellow-100 text-yellow-600 w-14 h-14 sm:w-16 sm:h-16 flex items-center justify-center rounded-full shadow mb-3 sm:mb-4">
                    <i class="fas fa-box-open text-xl sm:text-2xl"></i>
                </div>
                <h3 class="font-semibold text-base sm:text-lg mb-1 sm:mb-2">Recibe tu producto</h3>
                <p class="text-xs sm:text-sm text-gray-600">Te avisamos cuando llegue. Puedes recogerlo o solicitar
                    envío.</p>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('como-funciona-toggle');
            const section = document.getElementById('como-funciona');
            if (toggleBtn && section) {
                toggleBtn.addEventListener('click', function() {
                    if (section.classList.contains('hidden')) {
                        section.classList.remove('hidden');
                        section.classList.add('block');
                        section.scrollIntoView({
                            behavior: 'smooth'
                        });
                    } else {
                        section.classList.add('hidden');
                        section.classList.remove('block');
                    }
                });
            }
        });
    </script>

    <!-- Footer -->
    <footer class="w-full text-center py-4 sm:py-6 text-xs sm:text-sm text-gray-500 bg-white mt-auto shadow-inner">
        &copy; {{ date('Y') }} EncargaYa. Todos los derechos reservados. V1.0
    </footer>

</body>

</html>
