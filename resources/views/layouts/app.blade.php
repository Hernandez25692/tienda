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

</body>

</html>
