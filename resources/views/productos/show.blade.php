<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">
            Catálogo - {{ $producto->nombre }}
        </h2>
    </x-slot>

    <div x-data="{
        imagenSeleccionada: '{{ $producto->imagenes->first() ? asset('storage/' . $producto->imagenes->first()->ruta) : '' }}'
    }" class="max-w-6xl mx-auto py-10 px-4 sm:px-6 lg:px-8">

        <div class="bg-white shadow-xl rounded-2xl p-8 lg:flex gap-8">
            <!-- Miniaturas -->
            <div class="flex flex-col gap-4 w-full lg:w-1/5">
                @foreach ($producto->imagenes as $img)
                    <img src="{{ asset('storage/' . $img->ruta) }}"
                        class="w-full h-20 object-cover border cursor-pointer rounded hover:ring-2 hover:ring-blue-400 transition"
                        @click="imagenSeleccionada = '{{ asset('storage/' . $img->ruta) }}'"
                        alt="Miniatura de {{ $producto->nombre }}">
                @endforeach
            </div>

            <!-- Imagen Principal -->
            <div class="flex-1 flex justify-center items-start">
                <div class="w-full max-w-md overflow-hidden border rounded-xl relative group">
                    <img :src="imagenSeleccionada" alt="Imagen seleccionada"
                        class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110 cursor-zoom-in">
                </div>
            </div>

            <!-- Detalles del producto -->
            <div class="w-full lg:w-2/5 flex flex-col justify-center">
                <h3 class="text-3xl font-bold text-gray-800 mb-3">{{ $producto->nombre }}</h3>

                <div class="text-gray-600 text-base mb-4">
                    {{ $producto->descripcion }}
                </div>

                <div class="mb-4">
                    <span class="text-gray-500 font-medium">Precio:</span>
                    <span class="text-2xl font-semibold text-green-600">
                        L {{ number_format($producto->precio_venta, 2) }}
                    </span>
                </div>

                <div class="mb-4">
                    <span class="text-gray-500 font-medium">Estado:</span>
                    <span
                        class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                        {{ $producto->disponible ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $producto->disponible ? 'Disponible' : 'Agotado' }}
                    </span>
                </div>

                <!-- Formulario unificado -->
                <form action="{{ route('carrito.agregar') }}" method="POST" class="mt-4">
                    @csrf
                    <input type="hidden" name="producto_id" value="{{ $producto->id }}">

                    <label class="block text-sm font-medium text-gray-700 mb-1">Comentario (talla, color, etc):</label>
                    <textarea name="comentario" rows="2" class="w-full border-gray-300 rounded-md shadow-sm mb-3"
                        placeholder="Ej: Talla M, color negro, modelo ajustado"></textarea>

                    @if ($producto->disponible)
                        <button type="submit"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-3 px-6 rounded-lg shadow transition">
                            Agregar al pedido
                        </button>
                    @else
                        <button type="button"
                            class="mt-4 bg-gray-400 text-white font-semibold py-3 px-6 rounded-lg shadow cursor-not-allowed"
                            disabled>
                            Producto agotado
                        </button>
                    @endif
                </form>

                @if ($producto->link_compra)
                    <a href="{{ $producto->link_compra }}" target="_blank"
                        class="mt-4 inline-block text-sm text-blue-600 hover:underline">
                        Ver en proveedor
                    </a>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
