<div x-data="{ sidebarOpen: true }" class="flex min-h-screen bg-gray-100">

    <!-- Sidebar -->
    <div :class="sidebarOpen ? 'w-64' : 'w-16'"
        class="bg-white border-r transition-all duration-300 ease-in-out overflow-hidden">
        <div class="h-16 flex items-center justify-between px-4 border-b">
            <span class="font-bold text-gray-800 text-lg" x-show="sidebarOpen">🛍️ Tu Tienda</span>
            <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 focus:outline-none">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <nav class="px-4 pt-4 space-y-2">
            <a href="{{ route('dashboard') }}"
                class="flex items-center px-3 py-2 rounded hover:bg-blue-100 {{ request()->routeIs('dashboard') ? 'bg-blue-50 font-bold' : '' }}">
                📊 <span class="ml-2" x-show="sidebarOpen">Dashboard</span>
            </a>

            <a href="{{ route('productos.index') }}"
                class="flex items-center px-3 py-2 rounded hover:bg-blue-100 {{ request()->routeIs('productos.*') ? 'bg-blue-50 font-bold' : '' }}">
                📦 <span class="ml-2" x-show="sidebarOpen">Catálogo</span>
            </a>

            <a href="{{ route('profile.edit') }}"
                class="flex items-center px-3 py-2 rounded hover:bg-blue-100 {{ request()->routeIs('profile.edit') ? 'bg-blue-50 font-bold' : '' }}">
                👤 <span class="ml-2" x-show="sidebarOpen">Perfil</span>
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="flex items-center w-full text-left px-3 py-2 rounded hover:bg-red-100 text-red-600">
                    🚪 <span class="ml-2" x-show="sidebarOpen">Cerrar sesión</span>
                </button>
            </form>
        </nav>
    </div>

    <!-- Contenido Principal -->
    <div class="flex-1 p-4">
        @yield('content')
    </div>
</div>
