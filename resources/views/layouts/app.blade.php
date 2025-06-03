<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>EncargaYa</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100">

    @auth
        <!-- Navbar superior -->
        <nav x-data="{ open: false }" class="fixed top-0 left-0 w-full bg-white shadow-lg z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <!-- Logo -->
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('productos.index') }}">
                            <img src="{{ asset('storage/logos/logo.png') }}" alt="Logo" class="h-8">
                        </a>
                        <span class="font-bold text-yellow-500 text-lg">EncargaYa</span>
                    </div>
                    <!-- Menú en pantallas grandes -->
                    <div class="hidden md:flex items-center space-x-6">
                        <a href="{{ route('dashboard') }}"
                            class="flex items-center gap-2 px-3 py-2 rounded-md text-gray-700 hover:bg-yellow-100 hover:text-yellow-600 transition font-medium">
                            📊 <span>Dashboard</span>
                        </a>
                        <a href="{{ route('productos.index') }}"
                            class="flex items-center gap-2 px-3 py-2 rounded-md text-gray-700 hover:bg-yellow-100 hover:text-yellow-600 transition font-medium">
                            📦 <span>Catálogo</span>
                        </a>
                        <a href="{{ route('pedidos.mis') }}"
                            class="flex items-center gap-2 px-3 py-2 rounded-md text-gray-700 hover:bg-yellow-100 hover:text-yellow-600 transition font-medium">
                            📝 <span>Mis pedidos</span>
                        </a>
                        <a href="{{ route('carrito.index') }}"
                            class="flex items-center gap-2 px-3 py-2 rounded-md text-gray-700 hover:bg-yellow-100 hover:text-yellow-600 transition font-medium">
                            🛒 <span>Carrito</span>
                        </a>
                        @if (Auth::user()->role === 'admin')
                            <a href="{{ route('admin.pedidos.index') }}"
                                class="flex items-center gap-2 px-3 py-2 rounded-md text-gray-700 hover:bg-yellow-100 hover:text-yellow-600 transition font-medium">
                                📋 <span>Gestionar Pedidos</span>
                            </a>
                            <a href="{{ route('admin.clientes.index') }}"
                                class="flex items-center gap-2 px-3 py-2 rounded-md text-gray-700 hover:bg-yellow-100 hover:text-yellow-600 transition font-medium">
                                👥 <span>Clientes</span>
                            </a>
                            <a href="{{ route('categorias.index') }}"
                                class="flex items-center gap-2 px-3 py-2 rounded-md text-gray-700 hover:bg-yellow-100 hover:text-yellow-600 transition font-medium">
                                🏷️ <span>Categorías</span>
                            </a>
                        @endif
                        <a href="{{ route('profile.index') }}"
                            class="flex items-center gap-2 px-3 py-2 rounded-md text-gray-700 hover:bg-yellow-100 hover:text-yellow-600 transition font-medium">
                            👤 <span>Perfil</span>
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="flex items-center gap-2 px-3 py-2 rounded-md text-red-600 hover:bg-red-50 hover:text-red-700 transition font-medium">
                                🚪 <span>Cerrar sesión</span>
                            </button>
                        </form>
                    </div>
                    <!-- Botón menú móvil -->
                    <div class="md:hidden">
                        <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:bg-gray-100 focus:outline-none transition">
                            <svg x-show="!open" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            <svg x-show="open" x-cloak class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Menú móvil -->
            <div x-show="open" x-transition
                class="md:hidden bg-white border-t border-gray-200 px-4 pb-4 pt-2 space-y-2 shadow-lg">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-2 px-3 py-2 rounded-md text-gray-700 hover:bg-yellow-100 hover:text-yellow-600 transition font-medium">
                    📊 <span>Dashboard</span>
                </a>
                <a href="{{ route('productos.index') }}"
                    class="flex items-center gap-2 px-3 py-2 rounded-md text-gray-700 hover:bg-yellow-100 hover:text-yellow-600 transition font-medium">
                    📦 <span>Catálogo</span>
                </a>
                <a href="{{ route('pedidos.mis') }}"
                    class="flex items-center gap-2 px-3 py-2 rounded-md text-gray-700 hover:bg-yellow-100 hover:text-yellow-600 transition font-medium">
                    📝 <span>Mis pedidos</span>
                </a>
                <a href="{{ route('carrito.index') }}"
                    class="flex items-center gap-2 px-3 py-2 rounded-md text-gray-700 hover:bg-yellow-100 hover:text-yellow-600 transition font-medium">
                    🛒 <span>Carrito</span>
                </a>
                @if (Auth::user()->role === 'admin')
                    <a href="{{ route('admin.pedidos.index') }}"
                        class="flex items-center gap-2 px-3 py-2 rounded-md text-gray-700 hover:bg-yellow-100 hover:text-yellow-600 transition font-medium">
                        📋 <span>Gestionar Pedidos</span>
                    </a>
                    <a href="{{ route('admin.clientes.index') }}"
                        class="flex items-center gap-2 px-3 py-2 rounded-md text-gray-700 hover:bg-yellow-100 hover:text-yellow-600 transition font-medium">
                        👥 <span>Clientes</span>
                    </a>
                    <a href="{{ route('categorias.index') }}"
                        class="flex items-center gap-2 px-3 py-2 rounded-md text-gray-700 hover:bg-yellow-100 hover:text-yellow-600 transition font-medium">
                        🏷️ <span>Categorías</span>
                    </a>
                @endif
                <a href="{{ route('profile.index') }}"
                    class="flex items-center gap-2 px-3 py-2 rounded-md text-gray-700 hover:bg-yellow-100 hover:text-yellow-600 transition font-medium">
                    👤 <span>Perfil</span>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="flex items-center gap-2 px-3 py-2 rounded-md text-red-600 hover:bg-red-50 hover:text-red-700 transition font-medium w-full text-left">
                        🚪 <span>Cerrar sesión</span>
                    </button>
                </form>
            </div>
        </nav>

        <!-- Contenido principal -->
        <div class="pt-20 px-4">
            @isset($header)
                <header class="bg-white shadow mb-4">
                    <div class="max-w-7xl mx-auto py-6 px-4">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main>
                {{ $slot }}
            </main>
        </div>
    @endauth

    @guest
        <div class="min-h-screen flex flex-col justify-center items-center bg-gray-100">
            <main class="w-full max-w-md px-6">
                {{ $slot }}
            </main>
        </div>
    @endguest

    @include('components.footer')

</body>
</html>
