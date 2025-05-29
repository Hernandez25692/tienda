<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>EncargaYa</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100">

    @auth
        <div x-data="{ sidebarOpen: true }" x-init="$store.sidebar = { sidebarOpen: sidebarOpen }" class="flex min-h-screen">
            <!-- Sidebar -->
            <div :class="sidebarOpen ? 'w-64' : 'w-16'"
                class="bg-white border-r transition-all duration-300 ease-in-out overflow-hidden shadow-md">
                <div class="h-16 flex items-center justify-between px-4 border-b bg-white">
                    <div class="flex items-center space-x-2" x-show="sidebarOpen">
                        <img src="{{ asset('storage/logos/logo.png') }}" alt="Logo EncargaYa" class="h-8">
                        <span class="font-bold text-yellow-500 text-lg">EncargaYa</span>
                    </div>
                    <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 focus:outline-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>

                <nav class="px-4 pt-4 space-y-2 text-sm">
                    <x-nav-item route="dashboard" icon="📊" label="Dashboard" />
                    <x-nav-item route="productos.index" icon="📦" label="Catálogo" />
                    <x-nav-item route="pedidos.mis" icon="📝" label="Mis pedidos" />
                    <x-nav-item route="carrito.index" icon="🛒" label="Carrito" />

                    @if (Auth::user()->role === 'admin')
                        <hr class="my-2 border-t border-gray-200" />
                        <x-nav-item route="admin.pedidos.index" icon="📋" label="Gestionar Pedidos" />
                        <x-nav-item route="admin.clientes.index" icon="👥" label="Clientes" />
                        <x-nav-item route="categorias.index" icon="🏷️" label="Categorías" />
                    @endif

                    <hr class="my-2 border-t border-gray-200" />

                    <x-nav-item route="profile.edit" icon="👤" label="Perfil" />

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="flex items-center w-full text-left px-3 py-2 rounded hover:bg-red-100 text-red-600">
                            🚪 <span class="ml-2" x-show="sidebarOpen">Cerrar sesión</span>
                        </button>
                    </form>
                </nav>
            </div>

            <!-- Contenido principal -->
            <div class="flex-1 bg-gray-50">
                @isset($header)
                    <header class="bg-white shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <main class="p-4">
                    {{ $slot }}
                </main>
            </div>
        </div>
    @endauth

    @guest
        <div class="min-h-screen flex flex-col justify-center items-center bg-gray-100">
            <main class="w-full max-w-md px-6">
                {{ $slot }}
            </main>
        </div>
    @endguest
    <footer class="bg-blue-900 text-white mt-8">
        <div class="max-w-7xl mx-auto px-6 py-10 flex flex-col md:flex-row md:justify-between gap-8">
            <!-- Contacto -->
            <div class="flex-1">
                <h3 class="font-semibold text-lg mb-3 text-yellow-400">Contacto</h3>
                <ul class="space-y-2 text-sm">
                    <li class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-yellow-400" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16 12a4 4 0 01-8 0m8 0a4 4 0 00-8 0m8 0V8a4 4 0 00-8 0v4m8 0v4a4 4 0 01-8 0v-4" />
                        </svg>
                        <a href="mailto:soporte@encargaya.com" class="hover:underline">soporte@encargaya.com</a>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-400" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.472-.148-.67.15-.197.297-.767.967-.94 1.164-.173.198-.347.223-.644.075-.297-.149-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.447-.52.149-.174.198-.298.298-.497.099-.198.05-.372-.025-.521-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.372-.01-.571-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.099 3.205 5.077 4.372.711.306 1.263.489 1.695.625.712.227 1.36.195 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.288.173-1.413-.074-.124-.272-.198-.57-.347z" />
                        </svg>
                        <a href="https://wa.me/5215555555555" target="_blank" class="hover:underline flex items-center">
                            +52 1 555 555 5555
                        </a>
                    </li>
                </ul>
            </div>
            <!-- Enlaces rápidos -->
            <div class="flex-1">
                <h3 class="font-semibold text-lg mb-3 text-yellow-400">Enlaces rápidos</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('dashboard') }}" class="hover:text-yellow-400 transition">Inicio</a></li>
                    <li><a href="{{ route('productos.index') }}" class="hover:text-yellow-400 transition">Catálogo</a></li>
                    <li><a href="{{ route('profile.edit') }}" class="hover:text-yellow-400 transition">Perfil</a></li>
                    <li><a href="#" class="hover:text-yellow-400 transition">Ayuda</a></li>
                </ul>
            </div>
            <!-- Redes sociales -->
            <div class="flex-1">
                <h3 class="font-semibold text-lg mb-3 text-yellow-400">Síguenos</h3>
                <div class="flex space-x-4 mt-2">
                    <a href="https://facebook.com/encargaya" target="_blank"
                        class="bg-white/10 hover:bg-yellow-400 hover:text-blue-900 transition rounded-full p-2">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M22.675 0h-21.35C.595 0 0 .592 0 1.326v21.348C0 23.406.595 24 1.325 24H12.82v-9.294H9.692v-3.622h3.127V8.413c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.797.143v3.24l-1.918.001c-1.504 0-1.797.715-1.797 1.763v2.313h3.587l-.467 3.622h-3.12V24h6.116C23.406 24 24 23.406 24 22.674V1.326C24 .592 23.406 0 22.675 0" />
                        </svg>
                    </a>
                    <a href="https://instagram.com/encargaya" target="_blank"
                        class="bg-white/10 hover:bg-yellow-400 hover:text-blue-900 transition rounded-full p-2">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2.163c3.204 0 3.584.012 4.85.07 1.366.062 2.633.334 3.608 1.308.974.974 1.246 2.241 1.308 3.608.058 1.266.07 1.646.07 4.85s-.012 3.584-.07 4.85c-.062 1.366-.334 2.633-1.308 3.608-.974.974-2.241 1.246-3.608 1.308-1.266.058-1.646.07-4.85.07s-3.584-.012-4.85-.07c-1.366-.062-2.633-.334-3.608-1.308-.974-.974-1.246-2.241-1.308-3.608C2.175 15.647 2.163 15.267 2.163 12s.012-3.584.07-4.85c.062-1.366.334-2.633 1.308-3.608C4.515 2.497 5.782 2.225 7.148 2.163 8.414 2.105 8.794 2.163 12 2.163zm0-2.163C8.741 0 8.332.013 7.052.072 5.775.13 4.602.388 3.635 1.355 2.668 2.322 2.41 3.495 2.352 4.772.013 8.332 0 8.741 0 12c0 3.259.013 3.668.072 4.948.058 1.277.316 2.45 1.283 3.417.967.967 2.14 1.225 3.417 1.283C8.332 23.987 8.741 24 12 24c3.259 0 3.668-.013 4.948-.072 1.277-.058 2.45-.316 3.417-1.283.967-.967 1.225-2.14 1.283-3.417.059-1.28.072-1.689.072-4.948 0-3.259-.013-3.668-.072-4.948-.058-1.277-.316-2.45-1.283-3.417-.967-.967-2.14-1.225-3.417-1.283C15.668.013 15.259 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zm0 10.162a3.999 3.999 0 1 1 0-7.998 3.999 3.999 0 0 1 0 7.998zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z" />
                        </svg>
                    </a>
                    <a href="https://tiktok.com/@encargaya" target="_blank"
                        class="bg-white/10 hover:bg-yellow-400 hover:text-blue-900 transition rounded-full p-2">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M21.5 8.5a5.5 5.5 0 0 1-5.5-5.5h-3v14.25a2.25 2.25 0 1 1-2.25-2.25c.414 0 .75-.336.75-.75s-.336-.75-.75-.75A3.75 3.75 0 1 0 13 21V7.5h1.5a7 7 0 0 0 7 7v-2a5 5 0 0 1-5-5z" />
                        </svg>
                    </a>
                </div>
            </div>
            
            </div>
        </div>
        <div class="border-t border-white/10">
            <p class="text-center text-xs md:text-sm py-4 text-white/80">
                © 2025 EncargaYa – Tu compra confiable al alcance de un clic
            </p>
        </div>
    </footer>


</body>

</html>
