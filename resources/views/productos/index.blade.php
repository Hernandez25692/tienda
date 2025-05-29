<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl sm:text-2xl text-indigo-900 leading-tight tracking-tight">
                Catálogo de Productos
            </h2>
            @auth
                @if (Auth::user()->role === 'admin')
                    <a href="{{ route('productos.create') }}"
                       class="inline-flex items-center gap-2 bg-yellow-400 hover:bg-yellow-300 text-indigo-900 font-semibold px-4 py-2 rounded-lg shadow transition text-sm sm:text-base">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                        Agregar Producto
                    </a>
                @endif
            @endauth
        </div>
    </x-slot>

    <div class="bg-gray-100 min-h-screen py-4 px-2 sm:px-6">
        <!-- Filtros Modal -->
        <div x-data="{ open: false }" class="mb-6">
            <button @click="open = true"
                class="flex items-center gap-2 bg-indigo-900 hover:bg-yellow-400 hover:text-indigo-900 text-yellow-400 font-semibold px-5 py-2 rounded-full shadow transition text-base focus:outline-none">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                Filtros
            </button>
            <!-- Modal -->
            <div x-show="open" x-transition class="fixed inset-0 z-40 flex items-center justify-center bg-black bg-opacity-40">
                <div @click.away="open = false"
                     class="bg-white rounded-xl shadow-2xl w-full max-w-2xl mx-2 p-6 relative border border-gray-200">
                    <button @click="open = false"
                        class="absolute top-3 right-3 text-gray-400 hover:text-indigo-900 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                    <h3 class="text-lg font-bold text-indigo-900 mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2a1 1 0 01.894.553l7 14A1 1 0 0117 18H3a1 1 0 01-.894-1.447l7-14A1 1 0 0110 2z"/>
                        </svg>
                        Filtrar productos
                    </h3>
                    <form method="GET" action="{{ route('productos.index') }}" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="nombre" class="block text-xs font-semibold text-gray-600 mb-1">Nombre</label>
                            <input type="text" name="nombre" id="nombre" value="{{ request('nombre') }}"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-yellow-400 focus:ring-yellow-400 text-sm px-3 py-2">
                        </div>
                        <div>
                            <label for="categoria_id" class="block text-xs font-semibold text-gray-600 mb-1">Categoría</label>
                            <select name="categoria_id" id="categoria_id"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-yellow-400 focus:ring-yellow-400 text-sm px-3 py-2">
                                <option value="">Todas</option>
                                @foreach (\App\Models\Categoria::all() as $cat)
                                    <option value="{{ $cat->id }}" {{ request('categoria_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="precio_min" class="block text-xs font-semibold text-gray-600 mb-1">Precio mínimo</label>
                            <input type="number" step="0.01" name="precio_min" id="precio_min" value="{{ request('precio_min') }}"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-yellow-400 focus:ring-yellow-400 text-sm px-3 py-2">
                        </div>
                        <div>
                            <label for="precio_max" class="block text-xs font-semibold text-gray-600 mb-1">Precio máximo</label>
                            <input type="number" step="0.01" name="precio_max" id="precio_max" value="{{ request('precio_max') }}"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-yellow-400 focus:ring-yellow-400 text-sm px-3 py-2">
                        </div>
                        <div>
                            <label for="estado" class="block text-xs font-semibold text-gray-600 mb-1">Estado</label>
                            <select name="estado" id="estado"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-yellow-400 focus:ring-yellow-400 text-sm px-3 py-2">
                                <option value="">Todos</option>
                                <option value="disponible" {{ request('estado') === 'disponible' ? 'selected' : '' }}>Disponible</option>
                                <option value="agotado" {{ request('estado') === 'agotado' ? 'selected' : '' }}>Agotado</option>
                            </select>
                        </div>
                        <div>
                            <label for="ordenar" class="block text-xs font-semibold text-gray-600 mb-1">Ordenar por</label>
                            <select name="ordenar" id="ordenar"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-yellow-400 focus:ring-yellow-400 text-sm px-3 py-2">
                                <option value="">Más recientes</option>
                                <option value="nombre_asc" {{ request('ordenar') === 'nombre_asc' ? 'selected' : '' }}>Nombre A-Z</option>
                                <option value="nombre_desc" {{ request('ordenar') === 'nombre_desc' ? 'selected' : '' }}>Nombre Z-A</option>
                                <option value="precio_asc" {{ request('ordenar') === 'precio_asc' ? 'selected' : '' }}>Precio ↑</option>
                                <option value="precio_desc" {{ request('ordenar') === 'precio_desc' ? 'selected' : '' }}>Precio ↓</option>
                            </select>
                        </div>
                        <div class="col-span-full flex gap-2 mt-2">
                            <button type="submit"
                                class="flex-1 bg-yellow-400 hover:bg-yellow-300 text-indigo-900 font-bold px-4 py-2 rounded-lg shadow transition">
                                Buscar
                            </button>
                            <a href="{{ route('productos.index') }}"
                                class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-4 py-2 rounded-lg shadow text-center transition">
                                Limpiar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script src="//unpkg.com/alpinejs" defer></script>

        <!-- Grid de productos -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse ($productos as $producto)
                <div class="bg-white border border-gray-200 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-200 p-3 flex flex-col group relative overflow-hidden">
                    <a href="{{ route('productos.show', $producto->id) }}" class="block rounded-xl overflow-hidden">
                        @if ($producto->imagenes->first())
                            <img src="{{ asset('storage/' . $producto->imagenes->first()->ruta) }}"
                                 alt="{{ $producto->nombre }}"
                                 class="w-full h-48 sm:h-56 object-cover transition-transform duration-200 group-hover:scale-105 group-hover:brightness-95">
                        @else
                            <div class="w-full h-48 sm:h-56 bg-gray-100 flex items-center justify-center rounded-xl text-gray-400 text-2xl">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 11l4 4 4-4" />
                                </svg>
                            </div>
                        @endif
                    </a>
                    <div class="flex-1 flex flex-col mt-3">
                        <h3 class="text-lg font-bold text-indigo-900 truncate mb-1">{{ $producto->nombre }}</h3>
                        @if ($producto->categoria)
                            <p class="text-xs text-gray-500 mb-1 flex items-center gap-1">
                                <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm0 2h12v10H4V5z"/>
                                </svg>
                                {{ $producto->categoria->nombre }}
                            </p>
                        @endif
                        <p class="text-yellow-500 font-bold text-base mb-2">
                            L {{ number_format($producto->precio_venta, 2) }}
                        </p>
                        <div class="flex items-center gap-2 mb-2">
                            @if ($producto->disponible)
                                <span class="inline-flex items-center px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold gap-1">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <circle cx="10" cy="10" r="10"/>
                                    </svg>
                                    Disponible
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold gap-1">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <circle cx="10" cy="10" r="10"/>
                                    </svg>
                                    Agotado
                                </span>
                            @endif
                        </div>
                        <div class="mt-auto flex flex-col gap-2">
                            @auth
                                @if (Auth::user()->role === 'admin')
                                    <a href="{{ route('productos.show', $producto->id) }}"
                                       class="w-full text-center bg-indigo-900 hover:bg-yellow-400 hover:text-indigo-900 text-yellow-400 font-bold py-2 rounded-lg shadow transition-all duration-150 text-sm flex items-center justify-center gap-2 group-hover:scale-105">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Ver producto
                                    </a>
                                @endif
                            @endauth
                            @auth
                                @if (Auth::user()->role === 'admin')
                                    <a href="{{ route('productos.edit', $producto) }}"
                                       class="w-full text-center bg-yellow-400 hover:bg-yellow-300 text-indigo-900 font-bold py-2 rounded-lg shadow transition text-sm">
                                        Editar
                                    </a>
                                    <form action="{{ route('productos.toggleVisibilidad', $producto->id) }}" method="POST" class="w-full">
                                        @csrf
                                        <button type="submit"
                                            class="w-full mt-2 text-xs py-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold transition">
                                            {{ $producto->visible ? 'Ocultar' : 'Mostrar' }}
                                        </button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            @empty
               
            @endforelse
        </div>

        <!-- Paginación moderna -->
        @if ($productos->hasPages())
            <nav class="mt-10 flex justify-center">
            <ul class="inline-flex items-center space-x-2 bg-white rounded-xl shadow-lg px-4 py-3">
                {{-- Previous Page Link --}}
                @if ($productos->onFirstPage())
                <li>
                    <span class="px-4 py-2 rounded-lg bg-gray-100 text-gray-400 font-bold shadow cursor-not-allowed select-none">
                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                    </span>
                </li>
                @else
                <li>
                    <a href="{{ $productos->previousPageUrl() }}"
                       class="px-4 py-2 rounded-lg bg-indigo-900 text-yellow-400 font-bold shadow hover:bg-yellow-400 hover:text-indigo-900 transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                    </a>
                </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($productos->links()->elements[0] as $page => $url)
                @if (is_string($page))
                    <li>
                    <span class="px-4 py-2 rounded-lg bg-gray-100 text-gray-400 font-bold shadow select-none">{{ $page }}</span>
                    </li>
                @else
                    <li>
                    @if ($productos->currentPage() == $page)
                        <span class="px-4 py-2 rounded-lg bg-yellow-400 text-indigo-900 font-bold shadow-lg border-2 border-indigo-900 select-none">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}"
                           class="px-4 py-2 rounded-lg bg-white text-indigo-900 font-bold shadow hover:bg-yellow-400 hover:text-indigo-900 transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                        {{ $page }}
                        </a>
                    @endif
                    </li>
                @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($productos->hasMorePages())
                <li>
                    <a href="{{ $productos->nextPageUrl() }}"
                       class="px-4 py-2 rounded-lg bg-indigo-900 text-yellow-400 font-bold shadow hover:bg-yellow-400 hover:text-indigo-900 transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                    </a>
                </li>
                @else
                <li>
                    <span class="px-4 py-2 rounded-lg bg-gray-100 text-gray-400 font-bold shadow cursor-not-allowed select-none">
                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                    </span>
                </li>
                @endif
            </ul>
            </nav>
        @endif

        <!-- Mensaje amigable si no hay productos -->
        @if ($productos->isEmpty())
            <div class="flex flex-col items-center justify-center py-16">
            <img src="{{ asset('storage/logos/logo1.png') }}" 
                 alt="Sin productos"
                 class="w-24 h-24 mb-6 opacity-80 drop-shadow-lg">
            <h2 class="text-2xl font-bold text-indigo-900 mb-2">¡No hay productos disponibles!</h2>
            <p class="text-gray-500 mb-4 text-center max-w-xs">
                Actualmente no hay productos en el catálogo.<br>
                ¡Explora otras categorías o vuelve más tarde para descubrir nuevas ofertas!
            </p>
            <a href="{{ route('productos.index') }}"
               class="inline-block bg-yellow-400 hover:bg-yellow-300 text-indigo-900 font-bold px-6 py-3 rounded-lg shadow transition text-base">
                Explorar catálogo
            </a>
            </div>
        @endif

        <!-- Responsive: scroll horizontal en móvil -->
        <style>
            @media (max-width: 640px) {
            .productos-scroll {
                display: flex;
                overflow-x: auto;
                gap: 1.5rem;
                padding-bottom: 1rem;
            }
            .productos-scroll > div {
                min-width: 85vw;
                flex: 0 0 auto;
            }
            }
        </style>
        <script>
            // Agrega la clase productos-scroll a la grid en móvil
            document.addEventListener('DOMContentLoaded', function () {
            if (window.innerWidth <= 640) {
                let grid = document.querySelector('.grid.grid-cols-1');
                if (grid) grid.classList.add('productos-scroll');
            }
            });
        </script>
    </div>
</x-app-layout>
