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

<body class="bg-gradient-to-br from-yellow-50 to-white min-h-screen flex flex-col items-center justify-between text-gray-800">

    <!-- MOBILE HEADER -->
    <header class="w-full block md:hidden bg-white/80 backdrop-blur-md shadow-sm px-4 py-3 flex flex-col gap-3">
        <div class="flex items-center justify-between">
            <a href="{{ url()->current() }}" class="focus:outline-none">
                <img src="{{ asset('storage/logos/logo1.png') }}" alt="Logo EncargaYa"
                    class="h-10 w-auto transition duration-200" style="max-width: 140px;">
            </a>
            @if (Route::has('login'))
                <nav class="flex gap-2">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="px-3 py-2 rounded-xl bg-yellow-500 text-white font-semibold shadow hover:bg-yellow-600 text-sm transition">
                            <i class="fa fa-user mr-1"></i> Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="px-3 py-2 rounded-xl border border-yellow-500 text-yellow-600 font-semibold shadow hover:bg-yellow-100 text-sm transition">
                            <i class="fa fa-sign-in-alt mr-1"></i> Iniciar
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="px-3 py-2 rounded-xl bg-yellow-500 text-white font-semibold shadow hover:bg-yellow-600 text-sm transition">
                                <i class="fa fa-user-plus mr-1"></i> Registro
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </div>
    </header>

    <!-- DESKTOP HEADER -->
    <header class="w-full max-w-6xl flex flex-col sm:flex-row justify-between items-center p-4 sm:p-6 gap-3 sm:gap-0 hidden md:flex">
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

    <!-- MOBILE HERO -->
    <main class="block md:hidden w-full flex-1 flex flex-col items-center justify-center px-3 py-6">
        <section class="w-full max-w-md mx-auto flex flex-col items-center text-center gap-4">
            <h2 class="text-2xl font-extrabold text-gray-900 leading-snug mb-1">
                Productos únicos, estilo moderno,<br><span class="text-yellow-500">todo en un solo lugar</span>
            </h2>
            <p class="text-base text-gray-700 mb-2 px-1">
                <strong>EncargaYa</strong> es tu tienda virtual confiable donde encuentras lo último en moda, tecnología, hogar y más. Ofrecemos una selección de productos increíbles, muchos inspirados en plataformas como Amazon, Shein y otras tiendas populares.
            </p>
            <div class="flex flex-col gap-3 w-full mt-2">
                <a href="{{ route('catalogo.publico') }}"
                    class="w-full py-3 rounded-2xl bg-gradient-to-r from-yellow-400 via-orange-400 to-yellow-500 text-white font-bold text-lg shadow-lg hover:bg-gradient-to-r hover:from-orange-500 hover:via-yellow-500 hover:to-orange-600 transition"
                    style="background: linear-gradient(90deg, #facc15 0%, #fb923c 50%, #f59e42 100%); color: #fff;">
                    Explorar Catálogo
                </a>
                <button id="como-funciona-toggle" type="button"
                    class="w-full py-3 rounded-2xl border border-gray-400 text-gray-800 font-semibold text-lg shadow hover:bg-blue-100 hover:text-blue-800 transition"
                    style="border-color: #a3a3a3; color: #222;">
                    ¿Cómo funciona?
                </button>
            </div>
        </section>
    </main>

    <!-- DESKTOP HERO -->
    <main class="hidden md:flex flex-col items-center text-center px-3 py-8 sm:px-4 sm:py-12 max-w-full sm:max-w-3xl w-full">
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
            <a href="#como-funciona"
                class="px-5 py-3 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-100 transition text-center w-full sm:w-auto hidden sm:inline-block">
                ¿Cómo funciona?
            </a>
        </div>
    </main>

    <!-- MOBILE ¿CÓMO FUNCIONA? -->
    <section id="como-funciona"
        class="block md:hidden w-full max-w-md mx-auto mt-6 bg-white/90 rounded-2xl shadow-lg px-4 py-6 transition-all duration-300 hidden">
        <h2 class="text-xl font-bold text-center text-yellow-600 mb-6">¿Cómo funciona EncargaYa?</h2>
        <div class="flex flex-col gap-5">
            <!-- Paso 1 -->
            <div class="flex items-center gap-4 bg-yellow-50 rounded-xl p-4 shadow">
                <div class="bg-yellow-100 text-yellow-600 w-12 h-12 flex items-center justify-center rounded-full shadow">
                    <i class="fas fa-search text-lg"></i>
                </div>
                <div class="flex-1 text-left">
                    <h3 class="font-semibold text-base mb-1">Explora productos</h3>
                    <p class="text-xs text-gray-600">Revisa nuestro catálogo o dinos qué deseas comprar.</p>
                </div>
            </div>
            <!-- Paso 2 -->
            <div class="flex items-center gap-4 bg-yellow-50 rounded-xl p-4 shadow">
                <div class="bg-yellow-100 text-yellow-600 w-12 h-12 flex items-center justify-center rounded-full shadow">
                    <i class="fas fa-cart-plus text-lg"></i>
                </div>
                <div class="flex-1 text-left">
                    <h3 class="font-semibold text-base mb-1">Solicita tu pedido</h3>
                    <p class="text-xs text-gray-600">Regístrate, selecciona el producto y solicita tu compra fácilmente.</p>
                </div>
            </div>
            <!-- Paso 3 -->
            <div class="flex items-center gap-4 bg-yellow-50 rounded-xl p-4 shadow">
                <div class="bg-yellow-100 text-yellow-600 w-12 h-12 flex items-center justify-center rounded-full shadow">
                    <i class="fas fa-money-bill-wave text-lg"></i>
                </div>
                <div class="flex-1 text-left">
                    <h3 class="font-semibold text-base mb-1">Realiza el pago</h3>
                    <p class="text-xs text-gray-600">Te confirmamos el precio y el método de pago más conveniente para ti.</p>
                </div>
            </div>
            <!-- Paso 4 -->
            <div class="flex items-center gap-4 bg-yellow-50 rounded-xl p-4 shadow">
                <div class="bg-yellow-100 text-yellow-600 w-12 h-12 flex items-center justify-center rounded-full shadow">
                    <i class="fas fa-box-open text-lg"></i>
                </div>
                <div class="flex-1 text-left">
                    <h3 class="font-semibold text-base mb-1">Recibe tu producto</h3>
                    <p class="text-xs text-gray-600">Te avisamos cuando llegue. Puedes recogerlo o solicitar envío.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- DESKTOP ¿CÓMO FUNCIONA? -->
    <section id="como-funciona"
        class="w-full max-w-6xl mt-10 sm:mt-20 bg-white py-10 sm:py-16 px-3 sm:px-6 rounded-xl shadow-md
        transition-all duration-300
        sm:block
        hidden md:block">
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

    <!-- MOBILE VIDEO TUTORIAL -->
    <section class="block md:hidden w-full max-w-md mx-auto mt-8 mb-8 bg-white/90 rounded-2xl shadow-lg p-4 flex flex-col gap-4">
        <h2 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
            <span class="inline-block bg-orange-400 text-white rounded-full p-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M15 10l4.553-2.276A1 1 0 0 1 21 8.618v6.764a1 1 0 0 1-1.447.894L15 14M4 6v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </span>
            ¿Cómo realizar un pedido en EncargaYa?
        </h2>
        <div class="w-full aspect-w-16 aspect-h-9 rounded-xl overflow-hidden shadow-md bg-gray-100">
            <iframe src="https://www.youtube.com/embed/Tm6btPjWOUY?rel=0&modestbranding=1&showinfo=0&controls=1"
                title="Cómo realizar un pedido"
                frameborder="0"
                allowfullscreen
                class="w-full h-full"></iframe>
        </div>
    </section>

    <!-- DESKTOP VIDEO TUTORIAL -->
    <section class="w-full max-w-6xl mb-12 mt-8 bg-white rounded-2xl shadow-lg p-4 sm:p-6 md:p-10 flex flex-col gap-6 hidden md:flex">
        <h2 class="text-xl sm:text-2xl font-semibold text-gray-900 flex items-center gap-2">
            <span class="inline-block bg-orange-400 text-white rounded-full p-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M15 10l4.553-2.276A1 1 0 0 1 21 8.618v6.764a1 1 0 0 1-1.447.894L15 14M4 6v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </span>
            ¿Cómo realizar un pedido en EncargaYa?
        </h2>
        <div class="w-full aspect-w-16 aspect-h-9 rounded-xl overflow-hidden shadow-md bg-gray-100">
            <iframe src="https://www.youtube.com/embed/Tm6btPjWOUY?rel=0&modestbranding=1&showinfo=0&controls=1"
                title="Cómo realizar un pedido"
                frameborder="0"
                allowfullscreen
                class="w-full h-full"></iframe>
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

    <!-- MOBILE FOOTER -->
    <footer class="block md:hidden w-full text-center py-4 text-xs text-gray-500 bg-white/80 mt-auto shadow-inner">
        &copy; {{ date('Y') }} EncargaYa. Todos los derechos reservados. V1.0
    </footer>
    <!-- DESKTOP FOOTER -->
    <footer class="hidden md:block w-full text-center py-4 sm:py-6 text-xs sm:text-sm text-gray-500 bg-white mt-auto shadow-inner">
        &copy; {{ date('Y') }} EncargaYa. Todos los derechos reservados. V1.0
    </footer>
</body>
</html>
