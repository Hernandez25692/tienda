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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">

    <style>
        /* Garantiza que el nav tenga altura consistente y el main lo respete */
        :root {
            --navbar-height: 5rem;
            /* 80px, igual que h-20 */
        }

        @media (max-width: 768px) {
            :root {
                --navbar-height: 4.5rem;
                /* 72px para móviles */
            }
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-100 min-h-screen">

    @auth
        <!-- Navbar superior -->
        <nav x-data="{ open: false, dropdownOpen: false }"
            class="fixed top-0 left-0 w-full bg-white shadow-lg z-50 border-b border-gray-100 transition-all duration-300"
            style="height: var(--navbar-height);">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full">
                <div class="flex justify-between items-center h-full">
                    <!-- Logo -->
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('productos.index') }}"
                            class="group transition duration-300 flex items-center space-x-2">
                            <span
                                class="text-3xl font-black bg-gradient-to-r from-yellow-400 via-orange-400 to-yellow-600 bg-clip-text text-transparent drop-shadow-lg tracking-tight transition-transform duration-300 group-hover:scale-105">
                                <span class="inline-block align-middle -mt-1">
                                    <i class="fas fa-bolt text-yellow-400 drop-shadow-md animate-pulse"></i>
                                </span>
                                Encarga<span class="text-orange-500">Ya</span>
                            </span>
                        </a>
                    </div>

                    <!-- Desktop menu -->
                    <div class="hidden md:flex items-center space-x-1">
                        <a href="{{ route('dashboard') }}"
                            class="group flex items-center gap-2 px-4 py-2 rounded-lg text-gray-700 hover:text-yellow-600 transition-all duration-300 font-medium hover:bg-yellow-50">
                            <i
                                class="fas fa-chart-line text-yellow-500 group-hover:text-yellow-600 transition-all duration-300"></i>
                            <span
                                class="relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-yellow-500 after:transition-all after:duration-300 group-hover:after:w-full">
                                Dashboard
                            </span>
                        </a>
                        <a href="{{ route('productos.index') }}"
                            class="group flex items-center gap-2 px-4 py-2 rounded-lg text-gray-700 hover:text-yellow-600 transition-all duration-300 font-medium hover:bg-yellow-50">
                            <i
                                class="fas fa-box-open text-yellow-500 group-hover:text-yellow-600 transition-all duration-300"></i>
                            <span
                                class="relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-yellow-500 after:transition-all after:duration-300 group-hover:after:w-full">
                                Catálogo
                            </span>
                        </a>
                        <a href="{{ route('pedidos.mis') }}"
                            class="group flex items-center gap-2 px-4 py-2 rounded-lg text-gray-700 hover:text-yellow-600 transition-all duration-300 font-medium hover:bg-yellow-50">
                            <i
                                class="fas fa-clipboard-list text-yellow-500 group-hover:text-yellow-600 transition-all duration-300"></i>
                            <span
                                class="relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-yellow-500 after:transition-all after:duration-300 group-hover:after:w-full">
                                Mis pedidos
                            </span>

                        </a>
                        <a href="{{ route('ayuda') }}"
                            class="group flex items-center gap-2 px-4 py-2 rounded-lg text-gray-700 hover:text-yellow-600 transition-all duration-300 font-medium hover:bg-yellow-50">
                            <i
                                class="fas fa-question-circle text-yellow-500 group-hover:text-yellow-600 transition-all duration-300"></i>
                            <span
                                class="relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-yellow-500 after:transition-all after:duration-300 group-hover:after:w-full">
                                Ayuda
                            </span>
                        </a>

                        <a href="{{ route('carrito.index') }}"
                            class="group flex items-center gap-2 px-4 py-2 rounded-lg text-gray-700 hover:text-yellow-600 transition-all duration-300 font-medium hover:bg-yellow-50 relative">
                            <i
                                class="fas fa-shopping-cart text-yellow-500 group-hover:text-yellow-600 transition-all duration-300"></i>
                            <span
                                class="relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-yellow-500 after:transition-all after:duration-300 group-hover:after:w-full">
                                Carrito
                            </span>
                            @if (auth()->check() && optional(auth()->user()->cartItems)->count() > 0)
                                <span
                                    class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                                    {{ auth()->user()->cartItems->count() }}
                                </span>
                            @endif
                        </a>
                        @if (Auth::user()->role === 'admin')
                            <div x-data="{ adminMenuOpen: false }" class="relative">
                                <button @click="adminMenuOpen = !adminMenuOpen"
                                    class="group flex items-center gap-2 px-4 py-2 rounded-lg text-gray-700 hover:text-yellow-600 transition-all duration-300 font-medium hover:bg-yellow-50">
                                    <i
                                        class="fas fa-cog text-yellow-500 group-hover:text-yellow-600 transition-all duration-300"></i>
                                    <span
                                        class="relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-yellow-500 after:transition-all after:duration-300 group-hover:after:w-full">
                                        Administración
                                    </span>
                                    <i class="fas fa-chevron-down text-xs transition-transform duration-200"
                                        :class="{ 'transform rotate-180': adminMenuOpen }"></i>
                                </button>
                                <div x-show="adminMenuOpen" @click.outside="adminMenuOpen = false"
                                    x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="opacity-0 scale-95"
                                    x-transition:enter-end="opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="opacity-100 scale-100"
                                    x-transition:leave-end="opacity-0 scale-95"
                                    class="absolute right-0 mt-2 w-56 origin-top-right bg-white rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 z-50">
                                    <div class="py-1">
                                        <a href="{{ route('admin.pedidos.index') }}"
                                            class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:bg-yellow-50 hover:text-yellow-600 transition-colors duration-200">
                                            <i class="fas fa-tasks text-yellow-500 w-5"></i>
                                            Gestionar Pedidos
                                        </a>
                                        <a href="{{ route('admin.clientes.index') }}"
                                            class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:bg-yellow-50 hover:text-yellow-600 transition-colors duration-200">
                                            <i class="fas fa-users text-yellow-500 w-5"></i>
                                            Clientes
                                        </a>
                                        <a href="{{ route('categorias.index') }}"
                                            class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:bg-yellow-50 hover:text-yellow-600 transition-colors duration-200">
                                            <i class="fas fa-tags text-yellow-500 w-5"></i>
                                            Categorías
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div x-data="{ profileMenuOpen: false }" class="relative">
                            <button @click="profileMenuOpen = !profileMenuOpen"
                                class="flex items-center gap-2 px-4 py-2 rounded-full bg-gray-100 hover:bg-gray-200 transition-colors duration-200">
                                <span class="font-medium text-gray-700">{{ Auth::user()->name }}</span>
                                <img class="h-8 w-8 rounded-full object-cover"
                                    src="{{ Auth::user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&color=FFFFFF&background=F59E0B' }}"
                                    alt="{{ Auth::user()->name }}">
                            </button>
                            <div x-show="profileMenuOpen" @click.outside="profileMenuOpen = false"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                                class="absolute right-0 mt-2 w-48 origin-top-right bg-white rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 z-50">
                                <div class="py-1">
                                    <a href="{{ route('profile.index') }}"
                                        class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:bg-yellow-50 hover:text-yellow-600 transition-colors duration-200">
                                        <i class="fas fa-user-circle text-yellow-500 w-5"></i>
                                        Perfil
                                    </a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="w-full text-left flex items-center gap-2 px-4 py-2 text-red-600 hover:bg-red-50 transition-colors duration-200">
                                            <i class="fas fa-sign-out-alt text-red-500 w-5"></i>
                                            Cerrar sesión
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Mobile menu button -->
                    <div class="md:hidden flex items-center space-x-4">
                        <a href="{{ route('carrito.index') }}" class="relative text-gray-700 hover:text-yellow-600">
                            <i class="fas fa-shopping-cart text-xl"></i>
                            @if (auth()->check() && optional(auth()->user()->cartItems)->count() > 0)
                                <span
                                    class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                                    {{ auth()->user()->cartItems->count() }}
                                </span>
                            @endif
                        </a>
                        <button @click="open = !open"
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:bg-gray-100 focus:outline-none transition"
                            aria-label="Abrir menú">
                            <svg x-show="!open" class="w-7 h-7" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            <svg x-show="open" x-cloak class="w-7 h-7" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile menu -->
            <div x-show="open" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="md:hidden bg-white border-t border-gray-200 px-4 pb-6 pt-3 space-y-2 shadow-lg"
                style="position: absolute; left: 0; right: 0; top: var(--navbar-height);">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center space-x-2">
                        <img class="h-8 w-8 rounded-full object-cover"
                            src="{{ Auth::user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&color=FFFFFF&background=F59E0B' }}"
                            alt="{{ Auth::user()->name }}">
                        <span class="font-medium">{{ Auth::user()->name }}</span>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-red-500 hover:text-red-700">
                            <i class="fas fa-sign-out-alt text-xl"></i>
                        </button>
                    </form>
                </div>
                <a href="{{ route('dashboard') }}"
                    class="group flex items-center gap-3 px-3 py-3 rounded-lg text-gray-700 hover:bg-yellow-50 transition-colors duration-200 font-medium border-b border-gray-100">
                    <i class="fas fa-chart-line text-yellow-500 w-6 text-center"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('productos.index') }}"
                    class="group flex items-center gap-3 px-3 py-3 rounded-lg text-gray-700 hover:bg-yellow-50 transition-colors duration-200 font-medium border-b border-gray-100">
                    <i class="fas fa-box-open text-yellow-500 w-6 text-center"></i>
                    <span>Catálogo</span>
                </a>
                <a href="{{ route('pedidos.mis') }}"
                    class="group flex items-center gap-3 px-3 py-3 rounded-lg text-gray-700 hover:bg-yellow-50 transition-colors duration-200 font-medium border-b border-gray-100">
                    <i class="fas fa-clipboard-list text-yellow-500 w-6 text-center"></i>
                    <span>Mis pedidos</span>
                </a>
                <a href="{{ route('ayuda') }}"
                    class="group flex items-center gap-3 px-3 py-3 rounded-lg text-gray-700 hover:bg-yellow-50 transition-colors duration-200 font-medium border-b border-gray-100">
                    <i class="fas fa-question-circle text-yellow-500 w-6 text-center"></i>
                    <span>Ayuda</span>
                </a>

                <a href="{{ route('carrito.index') }}"
                    class="group flex items-center gap-3 px-3 py-3 rounded-lg text-gray-700 hover:bg-yellow-50 transition-colors duration-200 font-medium border-b border-gray-100">
                    <div class="relative">
                        <i class="fas fa-shopping-cart text-yellow-500 w-6 text-center"></i>
                        @if (auth()->check() && optional(auth()->user()->cartItems)->count() > 0)
                            <span
                                class="absolute -top-1 -right-3 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                                {{ auth()->user()->cartItems->count() }}
                            </span>
                        @endif
                    </div>
                    <span>Carrito</span>
                </a>
                @if (Auth::user()->role === 'admin')
                    <div x-data="{ adminMobileMenuOpen: false }" class="border-b border-gray-100">
                        <button @click="adminMobileMenuOpen = !adminMobileMenuOpen"
                            class="w-full flex items-center justify-between px-3 py-3 rounded-lg text-gray-700 hover:bg-yellow-50 transition-colors duration-200 font-medium">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-cog text-yellow-500 w-6 text-center"></i>
                                <span>Administración</span>
                            </div>
                            <i class="fas fa-chevron-down text-xs transition-transform duration-200"
                                :class="{ 'transform rotate-180': adminMobileMenuOpen }"></i>
                        </button>
                        <div x-show="adminMobileMenuOpen" class="pl-12 space-y-2 py-2 bg-gray-50 rounded-lg">
                            <a href="{{ route('admin.pedidos.index') }}"
                                class="block px-3 py-2 text-gray-700 hover:bg-yellow-100 hover:text-yellow-600 transition-colors duration-200 rounded">
                                Gestionar Pedidos
                            </a>
                            <a href="{{ route('admin.clientes.index') }}"
                                class="block px-3 py-2 text-gray-700 hover:bg-yellow-100 hover:text-yellow-600 transition-colors duration-200 rounded">
                                Clientes
                            </a>
                            <a href="{{ route('categorias.index') }}"
                                class="block px-3 py-2 text-gray-700 hover:bg-yellow-100 hover:text-yellow-600 transition-colors duration-200 rounded">
                                Categorías
                            </a>
                        </div>
                    </div>
                @endif
                <a href="{{ route('profile.index') }}"
                    class="group flex items-center gap-3 px-3 py-3 rounded-lg text-gray-700 hover:bg-yellow-50 transition-colors duration-200 font-medium">
                    <i class="fas fa-user-circle text-yellow-500 w-6 text-center"></i>
                    <span>Perfil</span>
                </a>
            </div>
        </nav>

        <!-- Contenido principal -->
        <div class="w-full" style="padding-top: var(--navbar-height); min-height: 100vh;">
            @isset($header)
                <header class="bg-white shadow rounded-lg mb-6">
                    <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6">
                        <h1 class="text-2xl font-bold text-gray-800">
                            {{ $header }}
                        </h1>
                    </div>
                </header>
            @endisset

            <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
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
    @stack('scripts')

</body>

</html>
