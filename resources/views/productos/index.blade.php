<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Catálogo de Productos
        </h2>
    </x-slot>

    <div class="bg-white p-6 rounded shadow">
        <a href="{{ route('productos.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Agregar Producto</a>

        <div class="overflow-x-auto mt-8">
            <div class="shadow-lg rounded-lg border border-gray-200">
            <table class="min-w-full bg-white rounded-lg overflow-hidden">
                <thead>
                <tr class="bg-gradient-to-r from-blue-700 to-blue-400 text-white">
                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider rounded-tl-lg">Imagen</th>
                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Nombre</th>
                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Precio Venta</th>
                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Estado</th>
                    <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider" colspan="2" rounded-tr-lg>Acciones</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($productos as $producto)
                    <tr class="border-b last:border-b-0 hover:bg-blue-50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center">
                        @if ($producto->imagenes->first())
                            <img src="{{ asset('storage/' . $producto->imagenes->first()->ruta) }}"
                            alt="Imagen"
                            class="w-16 h-16 object-cover rounded-lg shadow border border-gray-200">
                        @else
                            <span class="text-gray-400 italic">Sin imagen</span>
                        @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 font-semibold text-gray-800">
                        <span class="block truncate max-w-xs">{{ $producto->nombre }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-block bg-green-50 text-green-700 px-3 py-1 rounded font-bold shadow-sm">
                        L {{ number_format($producto->precio_venta, 2) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @if ($producto->disponible)
                        <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10" stroke="currentColor" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4" />
                            </svg>
                            Disponible
                        </span>
                        @else
                        <span class="inline-flex items-center px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10" stroke="currentColor" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 9l-6 6" />
                            </svg>
                            Agotado
                        </span>
                        @endif
                    </td>
                    <td class="px-3 py-4 text-center">
                        <a href="{{ route('productos.edit', $producto) }}"
                        class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow transition-colors font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 13l6-6 3 3-6 6H9v-3z" />
                        </svg>
                        Editar
                        </a>
                    </td>
                    <td class="px-3 py-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                        <a href="{{ route('productos.show', $producto->id) }}"
                            class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded shadow transition-colors font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Ver
                        </a>
                        <form action="{{ route('productos.toggleVisibilidad', $producto->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-indigo-600 px-2 py-1 rounded transition-colors">
                            @if($producto->visible)
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <span>Ocultar</span>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.956 9.956 0 012.293-3.95M6.873 6.873A9.956 9.956 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.956 9.956 0 01-4.293 5.95M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                                </svg>
                                <span>Mostrar</span>
                            @endif
                            </button>
                        </form>
                        </div>
                    </td>
                    </tr>
                @empty
                    <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-400 text-lg font-semibold bg-gray-50 rounded-b-lg">
                        No hay productos registrados.
                    </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            </div>
        </div>
    </div>
</x-app-layout>
