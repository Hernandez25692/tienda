<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Catálogo de Productos
        </h2>
    </x-slot>

    <div class="bg-white p-6 rounded shadow">
        @auth
            @if (Auth::user()->role === 'admin')
                <a href="{{ route('productos.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded mb-6 inline-block">
                    Agregar Producto
                </a>
            @endif
        @endauth

        <!-- Filtros -->
        <form method="GET" action="{{ route('productos.index') }}" class="mb-8 grid md:grid-cols-6 gap-4 items-end">
            <div>
                <label for="nombre" class="text-sm text-gray-600">Nombre:</label>
                <input type="text" name="nombre" id="nombre" value="{{ request('nombre') }}"
                       class="w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div>
                <label for="estado" class="text-sm text-gray-600">Estado:</label>
                <select name="estado" id="estado"
                        class="w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Todos</option>
                    <option value="disponible" {{ request('estado') === 'disponible' ? 'selected' : '' }}>Disponible</option>
                    <option value="agotado" {{ request('estado') === 'agotado' ? 'selected' : '' }}>Agotado</option>
                </select>
            </div>

            <div>
                <label for="precio_min" class="text-sm text-gray-600">Precio mínimo:</label>
                <input type="number" step="0.01" name="precio_min" id="precio_min" value="{{ request('precio_min') }}"
                       class="w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div>
                <label for="precio_max" class="text-sm text-gray-600">Precio máximo:</label>
                <input type="number" step="0.01" name="precio_max" id="precio_max" value="{{ request('precio_max') }}"
                       class="w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div>
                <label for="ordenar" class="text-sm text-gray-600">Ordenar por:</label>
                <select name="ordenar" id="ordenar"
                        class="w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Más recientes</option>
                    <option value="nombre_asc" {{ request('ordenar') === 'nombre_asc' ? 'selected' : '' }}>Nombre A-Z</option>
                    <option value="nombre_desc" {{ request('ordenar') === 'nombre_desc' ? 'selected' : '' }}>Nombre Z-A</option>
                    <option value="precio_asc" {{ request('ordenar') === 'precio_asc' ? 'selected' : '' }}>Precio ↑</option>
                    <option value="precio_desc" {{ request('ordenar') === 'precio_desc' ? 'selected' : '' }}>Precio ↓</option>
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded shadow">
                    Filtrar
                </button>
                <a href="{{ route('productos.index') }}"
                   class="w-full bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-4 py-2 rounded shadow text-center">
                    Limpiar
                </a>
            </div>
        </form>

        <!-- Grid de productos -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse ($productos as $producto)
                <div class="bg-white border border-gray-200 rounded-lg shadow hover:shadow-md transition p-4 flex flex-col justify-between">
                    @if ($producto->imagenes->first())
                        <img src="{{ asset('storage/' . $producto->imagenes->first()->ruta) }}"
                             alt="{{ $producto->nombre }}"
                             class="w-full h-48 object-cover rounded mb-3">
                    @else
                        <div class="w-full h-48 bg-gray-100 flex items-center justify-center rounded mb-3 text-gray-400">
                            <span>Sin imagen</span>
                        </div>
                    @endif

                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-gray-800 truncate">{{ $producto->nombre }}</h3>
                        <p class="text-yellow-600 font-semibold text-base mt-1">
                            L {{ number_format($producto->precio_venta, 2) }}
                        </p>

                        <p class="text-sm mt-2">
                            @if ($producto->disponible)
                                <span class="inline-flex items-center px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">
                                    Disponible
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold">
                                    Agotado
                                </span>
                            @endif
                        </p>
                    </div>

                    <div class="mt-4 flex flex-wrap gap-2">
                        <a href="{{ route('productos.show', $producto->id) }}"
                           class="flex-1 text-center bg-indigo-600 hover:bg-indigo-700 text-white text-sm py-2 rounded">
                            Ver
                        </a>

                        @auth
                            @if (Auth::user()->role === 'admin')
                                <a href="{{ route('productos.edit', $producto) }}"
                                   class="flex-1 text-center bg-blue-600 hover:bg-blue-700 text-white text-sm py-2 rounded">
                                    Editar
                                </a>
                                <form action="{{ route('productos.toggleVisibilidad', $producto->id) }}" method="POST" class="w-full">
                                    @csrf
                                    <button type="submit"
                                            class="w-full mt-2 text-sm py-2 rounded bg-gray-100 hover:bg-gray-200 text-gray-700">
                                        {{ $producto->visible ? 'Ocultar' : 'Mostrar' }}
                                    </button>
                                </form>
                            @endif
                        @endauth
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center text-gray-500 py-8">
                    No hay productos registrados.
                </div>
            @endforelse
        </div>

        <!-- Paginación -->
        <div class="mt-8">
            {{ $productos->links() }}
        </div>
    </div>
</x-app-layout>
