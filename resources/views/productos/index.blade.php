<x-app-layout>
    @auth
        @if (Auth::user()->role === 'admin')
            <x-slot name="header">
                <div class="flex items-center justify-between px-2 sm:px-4 py-2 sm:py-4">
                    <h2 class="font-bold text-base sm:text-2xl text-indigo-900 leading-tight tracking-tight truncate">
                        Catálogo de Productos
                    </h2>
                    <a href="{{ route('productos.create') }}"
                        class="inline-flex items-center gap-1 bg-yellow-400 hover:bg-yellow-300 text-indigo-900 font-semibold px-2 py-1 sm:px-4 sm:py-2 rounded-lg shadow transition text-xs sm:text-base focus:outline-none focus:ring-2 focus:ring-yellow-500"
                        aria-label="Agregar producto">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                            aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        <span class="hidden sm:inline">Agregar</span>
                        <span class="sm:hidden">+</span>
                    </a>
                </div>
            </x-slot>
        @endif
    @endauth

    <div class="container mx-auto px-2 sm:px-4 bg-gray-100 min-h-screen py-2 sm:py-4">
        @php
            $hayFiltro =
                request()->filled('nombre') ||
                request()->filled('categoria_id') ||
                request()->filled('precio_min') ||
                request()->filled('precio_max') ||
                request()->filled('estado') ||
                request()->filled('ordenar');
        @endphp

        <!-- Filtros Modal Mejorado -->
        <div x-data="{ open: false, showAdvanced: false }" class="mb-2 sm:mb-4">
            <button id="btn-filtros" @click="open = true"
                class="fixed bottom-3 left-1/2 -translate-x-1/2 z-50 sm:static sm:translate-x-0 sm:bottom-auto sm:left-auto flex items-center gap-1
                    bg-indigo-900 hover:bg-yellow-400 hover:text-indigo-900 text-yellow-400 font-semibold px-4 py-1.5 sm:px-6 sm:py-2 rounded-full shadow transition text-sm focus:outline-none focus:ring-2 focus:ring-yellow-500
                    {{ $hayFiltro ? 'border-2 border-red-500 animate-pulse' : '' }}"
                aria-haspopup="dialog" aria-controls="modal-filtros" :aria-expanded="open">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                    aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <span class="hidden sm:inline">Filtros</span>
                <span class="sm:hidden">Filtrar</span>
                @if ($hayFiltro)
                    <span class="ml-1 w-2 h-2 rounded-full bg-red-500 border-2 border-white animate-pulse"></span>
                @endif
            </button>
            <!-- Modal -->
            <div x-show="open" x-transition.opacity
                class="fixed inset-0 z-40 flex items-center justify-center bg-black bg-opacity-40" role="dialog"
                aria-modal="true" id="modal-filtros">
                <div @click.away="open = false"
                    class="relative w-11/12 max-w-xs sm:max-w-md md:max-w-lg bg-white rounded-xl shadow-2xl border border-gray-200 p-2 sm:p-6 mx-2 flex flex-col"
                    style="max-height: 90vh; overflow-y:auto;">
                    <button @click="open = false"
                        class="absolute top-2 right-2 text-gray-400 hover:text-indigo-900 transition focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        aria-label="Cerrar filtros">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                            aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                    <h3 class="text-base font-bold text-indigo-900 mb-2 flex items-center gap-2">
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path
                                d="M10 2a1 1 0 01.894.553l7 14A1 1 0 0117 18H3a1 1 0 01-.894-1.447l7-14A1 1 0 0110 2z" />
                        </svg>
                        Filtrar productos
                    </h3>
                    <form method="GET" action="{{ route('productos.index') }}"
                        class="flex flex-col gap-2 overflow-y-auto" style="max-height: 70vh;">
                        <div>
                            <label for="nombre" class="block text-xs font-semibold text-gray-600 mb-1">Nombre</label>
                            <input type="text" name="nombre" id="nombre" value="{{ request('nombre') }}"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-yellow-400 focus:ring-yellow-400 text-xs px-2 py-1.5"
                                autocomplete="off">
                        </div>
                        <div>
                            <label for="categoria_id"
                                class="block text-xs font-semibold text-gray-600 mb-1">Categoría</label>
                            <select name="categoria_id" id="categoria_id"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-yellow-400 focus:ring-yellow-400 text-xs px-2 py-1.5">
                                <option value="">Todas</option>
                                @foreach (\App\Models\Categoria::all() as $cat)
                                    <option value="{{ $cat->id }}"
                                        {{ request('categoria_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex gap-1">
                            <div class="flex-1">
                                <label for="precio_min" class="block text-xs font-semibold text-gray-600 mb-1">Precio
                                    mín.</label>
                                <input type="number" step="0.01" name="precio_min" id="precio_min"
                                    value="{{ request('precio_min') }}"
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-yellow-400 focus:ring-yellow-400 text-xs px-2 py-1.5">
                            </div>
                            <div class="flex-1">
                                <label for="precio_max" class="block text-xs font-semibold text-gray-600 mb-1">Precio
                                    máx.</label>
                                <input type="number" step="0.01" name="precio_max" id="precio_max"
                                    value="{{ request('precio_max') }}"
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-yellow-400 focus:ring-yellow-400 text-xs px-2 py-1.5">
                            </div>
                        </div>
                        <!-- Filtros avanzados -->
                        <div x-data="{ open: false }" class="mt-1">
                            <button type="button" @click="open = !open"
                                class="w-full flex items-center justify-between text-xs font-semibold text-indigo-900 bg-gray-100 rounded-lg px-2 py-1.5 mb-1 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                aria-expanded="false" aria-controls="filtros-avanzados">
                                Más filtros
                                <svg :class="{ 'rotate-180': open }" class="w-4 h-4 transition-transform" fill="none"
                                    stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="open" x-transition class="space-y-2" id="filtros-avanzados">
                                <div>
                                    <label for="estado"
                                        class="block text-xs font-semibold text-gray-600 mb-1">Estado</label>
                                    <select name="estado" id="estado"
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-yellow-400 focus:ring-yellow-400 text-xs px-2 py-1.5">
                                        <option value="">Todos</option>
                                        <option value="disponible"
                                            {{ request('estado') === 'disponible' ? 'selected' : '' }}>Disponible
                                        </option>
                                        <option value="agotado"
                                            {{ request('estado') === 'agotado' ? 'selected' : '' }}>Agotado</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="ordenar"
                                        class="block text-xs font-semibold text-gray-600 mb-1">Ordenar por</label>
                                    <select name="ordenar" id="ordenar"
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-yellow-400 focus:ring-yellow-400 text-xs px-2 py-1.5">
                                        <option value="">Más recientes</option>
                                        <option value="nombre_asc"
                                            {{ request('ordenar') === 'nombre_asc' ? 'selected' : '' }}>Nombre A-Z
                                        </option>
                                        <option value="nombre_desc"
                                            {{ request('ordenar') === 'nombre_desc' ? 'selected' : '' }}>Nombre Z-A
                                        </option>
                                        <option value="precio_asc"
                                            {{ request('ordenar') === 'precio_asc' ? 'selected' : '' }}>Precio ↑
                                        </option>
                                        <option value="precio_desc"
                                            {{ request('ordenar') === 'precio_desc' ? 'selected' : '' }}>Precio ↓
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col gap-2 mt-2">
                            <button type="submit"
                                class="w-full bg-yellow-400 hover:bg-yellow-300 text-indigo-900 font-bold px-4 py-2 rounded-lg shadow transition text-base focus:outline-none focus:ring-2 focus:ring-yellow-500">
                                Buscar
                            </button>
                            <a href="{{ route('productos.index') }}"
                                class="w-full bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-4 py-2 rounded-lg shadow text-center transition text-base focus:outline-none focus:ring-2 focus:ring-gray-400">
                                Limpiar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script src="//unpkg.com/alpinejs" defer></script>
        <script>
            // Oculta el botón Filtros en móvil al llegar al pie de página
            document.addEventListener('DOMContentLoaded', function() {
                function toggleFiltrosBtn() {
                    const btn = document.getElementById('btn-filtros');
                    if (!btn) return;
                    if (window.innerWidth > 640) {
                        btn.classList.remove('!hidden');
                        return;
                    }
                    const scrollY = window.scrollY || window.pageYOffset;
                    const windowH = window.innerHeight;
                    const docH = document.documentElement.scrollHeight;
                    if (scrollY + windowH >= docH - 30) {
                        btn.classList.add('!hidden');
                    } else {
                        btn.classList.remove('!hidden');
                    }
                }
                window.addEventListener('scroll', toggleFiltrosBtn);
                window.addEventListener('resize', toggleFiltrosBtn);
                toggleFiltrosBtn();
            });
        </script>
        <style>
            . !hidden {
                display: none !important;
            }
        </style>

        <!-- Grid de productos -->
        <div id="productos-lista"
            class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-1 sm:gap-4 overflow-y-auto"
            style="max-height: calc(100vh - 140px);" role="list" aria-label="Lista de productos">
            @foreach ($productos as $producto)
                <div class="bg-white border border-gray-200 rounded-xl shadow group relative flex flex-col p-1 sm:p-3 min-h-0 h-full transition-all duration-200"
                    role="listitem">
                    <a href="{{ route('productos.show', $producto->id) }}"
                        class="block rounded-lg overflow-hidden aspect-square bg-gray-100 flex items-center justify-center h-36 sm:h-44 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                        tabindex="0">
                        @if ($producto->imagenes->first())
                            <img src="{{ asset('storage/' . $producto->imagenes->first()->ruta) }}"
                                alt="{{ $producto->nombre }}"
                                class="w-full h-full object-cover transition-transform duration-200 group-hover:scale-105 group-hover:brightness-95"
                                loading="lazy">
                        @else
                            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor"
                                stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                                <rect x="3" y="5" width="18" height="14" rx="2" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 11l4 4 4-4" />
                            </svg>
                        @endif
                    </a>
                    <div class="flex-1 flex flex-col mt-1 sm:mt-3 min-h-0">
                        <h3 class="text-xs sm:text-sm font-bold text-indigo-900 truncate mb-0.5 leading-tight"
                            title="{{ $producto->nombre }}">
                            {{ $producto->nombre }}
                        </h3>
                        @if ($producto->precio_oferta)
                            <div class="mb-0.5">
                                <span class="text-red-500 font-bold text-sm sm:text-base">L
                                    {{ number_format($producto->precio_oferta, 2) }}</span>
                                <span class="text-gray-400 line-through text-xs sm:text-sm ml-1">L
                                    {{ number_format($producto->precio_venta, 2) }}</span>
                            </div>
                            <span
                                class="text-white bg-red-500 text-[10px] sm:text-xs px-2 py-0.5 rounded-full w-fit font-semibold">¡En
                                oferta!</span>
                        @else
                            <span class="text-yellow-500 font-bold text-xs sm:text-sm truncate mb-0.5">
                                L {{ number_format($producto->precio_venta, 2) }}
                            </span>
                        @endif

                    </div>
                    <!-- Acciones admin solo en desktop/hover -->
                    @auth
                        @if (Auth::user()->role === 'admin')
                            <div class="absolute top-2 right-2 flex-col gap-1 hidden sm:flex group-hover:flex z-10">
                                <a href="{{ route('productos.edit', $producto) }}"
                                    class="bg-yellow-400 hover:bg-yellow-300 text-indigo-900 font-bold px-2 py-1 rounded shadow text-xs mb-1 text-center focus:outline-none focus:ring-2 focus:ring-yellow-500"
                                    aria-label="Editar producto">
                                    <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.232 5.232l3.536 3.536M9 13l6-6m2 2l-6 6m-2 2h6" />
                                    </svg>
                                </a>
                                <form action="{{ route('productos.toggleVisibilidad', $producto->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-2 py-1 rounded text-xs w-full focus:outline-none focus:ring-2 focus:ring-gray-400"
                                        aria-label="{{ $producto->visible ? 'Ocultar' : 'Mostrar' }} producto">
                                        {{ $producto->visible ? 'Ocultar' : 'Mostrar' }}
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endauth
                    <!-- En móvil, toda la tarjeta es clickeable -->
                    <a href="{{ route('productos.show', $producto->id) }}" class="sm:hidden absolute inset-0 z-0"
                        tabindex="-1" aria-label="Ver producto"></a>
                </div>
            @endforeach
        </div>
        <div id="cargando-productos" class="flex justify-center py-4 hidden" aria-live="polite">
            <span class="text-gray-500 text-xs sm:text-sm">Cargando más productos...</span>
        </div>
        <div id="fin-productos" class="flex justify-center py-4 hidden" aria-live="polite">
            <span class="text-gray-400 text-xs sm:text-sm">No hay más productos para mostrar.</span>
        </div>

        <script>
            let paginaActual = {{ $productos->currentPage() }};
            let ultimaPagina = {{ $productos->lastPage() }};
            let cargando = false;

            function cargarMasProductos() {
                if (cargando || paginaActual >= ultimaPagina) return;
                cargando = true;
                document.getElementById('cargando-productos').classList.remove('hidden');
                let params = new URLSearchParams(window.location.search);
                params.set('page', paginaActual + 1);

                fetch("{{ route('productos.index') }}?" + params.toString(), {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(res => res.text())
                    .then(html => {
                        let temp = document.createElement('div');
                        temp.innerHTML = html;
                        let nuevos = temp.querySelectorAll('#productos-lista > div');
                        let lista = document.getElementById('productos-lista');
                        nuevos.forEach(n => lista.appendChild(n));
                        paginaActual++;
                        if (paginaActual >= ultimaPagina) {
                            document.getElementById('fin-productos').classList.remove('hidden');
                        }
                    })
                    .finally(() => {
                        cargando = false;
                        document.getElementById('cargando-productos').classList.add('hidden');
                    });
            }

            document.addEventListener('DOMContentLoaded', function() {
                let lista = document.getElementById('productos-lista');
                lista.addEventListener('scroll', function() {
                    if (lista.scrollTop + lista.clientHeight >= lista.scrollHeight - 100) {
                        cargarMasProductos();
                    }
                });

                function autoCargar() {
                    if (paginaActual < ultimaPagina && lista.scrollHeight <= lista.clientHeight + 10) {
                        cargarMasProductos();
                        setTimeout(autoCargar, 500);
                    }
                }
                autoCargar();
            });
        </script>

        @if ($productos->isEmpty())
            <div class="flex flex-col items-center justify-center py-12 sm:py-16">
                <img src="{{ asset('storage/logos/logo1.png') }}" alt="Sin productos"
                    class="w-16 h-16 sm:w-24 sm:h-24 mb-4 sm:mb-6 opacity-80 drop-shadow-lg">
                <h2 class="text-lg sm:text-2xl font-bold text-indigo-900 mb-1 sm:mb-2">¡No hay productos disponibles!
                </h2>
                <p class="text-gray-500 mb-2 sm:mb-4 text-center max-w-xs text-xs sm:text-base">
                    Actualmente no hay productos en el catálogo.<br>
                    ¡Explora otras categorías o vuelve más tarde para descubrir nuevas ofertas!
                </p>
                <a href="{{ route('productos.index') }}"
                    class="inline-block bg-yellow-400 hover:bg-yellow-300 text-indigo-900 font-bold px-4 py-2 sm:px-6 sm:py-3 rounded-lg shadow transition text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    Explorar catálogo
                </a>
            </div>
        @endif

        <style>
            @media (max-width: 640px) {
                .productos-scroll {
                    display: flex;
                    overflow-x: auto;
                    gap: 1rem;
                    padding-bottom: 0.5rem;
                }

                .productos-scroll>div {
                    min-width: 85vw;
                    flex: 0 0 auto;
                }

                #productos-lista>div {
                    min-height: 0;
                    padding: 0.25rem !important;
                }
            }
        </style>
    </div>
</x-app-layout>
