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

</head>

<body
    class="bg-gradient-to-br from-yellow-50 to-white min-h-screen flex flex-col items-center justify-between text-gray-800">

    <!-- Header -->
    <header class="w-full max-w-6xl flex justify-between items-center p-6">
        <div class="flex items-center gap-3">
            <a href="{{ url()->current() }}" class="group focus:outline-none">
                <img src="{{ asset('storage/logos/logo.png') }}" alt="Logo EncargaYa" class="h-12 w-auto transition duration-200 group-hover:brightness-110 group-hover:drop-shadow-lg cursor-pointer" style="cursor: pointer;">
            </a>
            <h1 class="text-2xl font-extrabold text-yellow-600">EncargaYa</h1>
        </div>

        @if (Route::has('login'))
            <nav class="space-x-3">
                @auth
                    <a href="{{ url('/dashboard') }}"
                        class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="px-4 py-2 border border-yellow-500 text-yellow-600 rounded hover:bg-yellow-100 transition">
                        Iniciar Sesión
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition">
                            Registrarse
                        </a>
                    @endif
                @endauth
            </nav>
        @endif
    </header>

    <!-- Hero Main Section -->
    <main class="flex flex-col items-center text-center px-4 py-12 max-w-3xl">
        <h2 class="text-4xl md:text-5xl font-bold text-gray-900 leading-tight mb-6">
            Productos únicos, estilo moderno, todo en un solo lugar
        </h2>
        <p class="text-lg text-gray-700 mb-8">
            <strong>EncargaYa</strong> es tu tienda virtual confiable donde encuentras lo último en moda, tecnología,
            hogar y más. Ofrecemos una selección de productos increíbles, muchos inspirados en plataformas como Amazon,
            Shein y otras tiendas populares.
        </p>

        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('catalogo.publico') }}"
                class="px-6 py-3 bg-yellow-500 text-white rounded-md font-semibold hover:bg-yellow-600 transition">
                Explorar Catálogo
            </a>

            <a href="#como-funciona"
                class="px-6 py-3 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-100 transition">
                ¿Cómo funciona?
            </a>

        </div>
    </main>
    <!-- Sección: ¿Cómo funciona? -->
    <section id="como-funciona" class="w-full max-w-6xl mt-20 bg-white py-16 px-6 rounded-xl shadow-md">
        <h2 class="text-3xl font-bold text-center text-yellow-600 mb-10">¿Cómo funciona EncargaYa?</h2>

        <div class="grid md:grid-cols-4 gap-8 text-center">
            <!-- Paso 1 -->
            <div class="flex flex-col items-center">
                <div
                    class="bg-yellow-100 text-yellow-600 w-16 h-16 flex items-center justify-center rounded-full shadow mb-4">
                    <i class="fas fa-search text-2xl"></i>
                </div>
                <h3 class="font-semibold text-lg mb-2">Explora productos</h3>
                <p class="text-sm text-gray-600">Revisa nuestro catálogo o dinos qué deseas comprar.</p>
            </div>

            <!-- Paso 2 -->
            <div class="flex flex-col items-center">
                <div
                    class="bg-yellow-100 text-yellow-600 w-16 h-16 flex items-center justify-center rounded-full shadow mb-4">
                    <i class="fas fa-cart-plus text-2xl"></i>
                </div>
                <h3 class="font-semibold text-lg mb-2">Solicita tu pedido</h3>
                <p class="text-sm text-gray-600">Regístrate, selecciona el producto y solicita tu compra fácilmente.</p>
            </div>

            <!-- Paso 3 -->
            <div class="flex flex-col items-center">
                <div
                    class="bg-yellow-100 text-yellow-600 w-16 h-16 flex items-center justify-center rounded-full shadow mb-4">
                    <i class="fas fa-money-bill-wave text-2xl"></i>
                </div>
                <h3 class="font-semibold text-lg mb-2">Realiza el pago</h3>
                <p class="text-sm text-gray-600">Te confirmamos el precio y el método de pago más conveniente para ti.
                </p>
            </div>

            <!-- Paso 4 -->
            <div class="flex flex-col items-center">
                <div
                    class="bg-yellow-100 text-yellow-600 w-16 h-16 flex items-center justify-center rounded-full shadow mb-4">
                    <i class="fas fa-box-open text-2xl"></i>
                </div>
                <h3 class="font-semibold text-lg mb-2">Recibe tu producto</h3>
                <p class="text-sm text-gray-600">Te avisamos cuando llegue. Puedes recogerlo o solicitar envío.</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="w-full text-center py-6 text-sm text-gray-500 bg-white mt-auto shadow-inner">
        &copy; {{ date('Y') }} EncargaYa. Todos los derechos reservados.
    </footer>

</body>

</html>
