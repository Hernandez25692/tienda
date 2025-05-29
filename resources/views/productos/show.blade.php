<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-extrabold text-indigo-900 tracking-tight">
            {{ $producto->nombre }}
        </h2>
    </x-slot>

    <div x-data="{
        imagenSeleccionada: '{{ $producto->imagenes->first() ? asset('storage/' . $producto->imagenes->first()->ruta) : '' }}',
        lightbox: false,
        imagenLightbox: '',
        abrirLightbox(src) { this.imagenLightbox = src;
            this.lightbox = true; },
        cerrarLightbox() { this.lightbox = false; }
    }" class="bg-[#f9fafb] min-h-screen py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto bg-white shadow-xl rounded-2xl p-6 md:p-10 flex flex-col md:flex-row gap-8">
            <!-- Galería de imágenes -->
            <div class="flex flex-col md:w-2/5 gap-4">
                <div class="w-full aspect-square bg-gray-100 rounded-xl overflow-hidden border relative group cursor-zoom-in"
                    @click="abrirLightbox(imagenSeleccionada)">
                    <img :src="imagenSeleccionada" alt="Imagen principal de {{ $producto->nombre }}"
                        class="w-full h-full object-contain transition-transform duration-300 group-hover:scale-110">
                    <span class="absolute bottom-2 right-2 bg-white/80 text-xs px-2 py-1 rounded text-gray-700 shadow">
                        Click para ampliar
                    </span>
                </div>
                <div class="flex gap-2 mt-2 overflow-x-auto">
                    @foreach ($producto->imagenes as $img)
                        <img src="{{ asset('storage/' . $img->ruta) }}"
                            class="w-16 h-16 object-cover border-2 rounded-lg cursor-pointer transition
                                hover:ring-2 hover:ring-indigo-500
                                "
                            :class="imagenSeleccionada === '{{ asset('storage/' . $img->ruta) }}' ? 'ring-2 ring-[#facc15]' : ''"
                            @click="imagenSeleccionada = '{{ asset('storage/' . $img->ruta) }}'"
                            alt="Miniatura de {{ $producto->nombre }}">
                    @endforeach
                </div>
            </div>

            <!-- Lightbox -->
            <template x-if="lightbox">
                <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/80" x-show="lightbox"
                    x-transition @click.self="cerrarLightbox()">
                    <img :src="imagenLightbox"
                        class="max-h-[90vh] max-w-[90vw] rounded shadow-lg border-4 border-white" alt="Imagen ampliada">
                    <button @click="cerrarLightbox()"
                        class="absolute top-6 right-8 text-white text-3xl font-bold">&times;</button>
                </div>
            </template>

            <!-- Detalles del producto -->
            <div class="flex-1 flex flex-col justify-between">
                <div>
                    <h1 class="text-4xl font-bold text-indigo-900 mb-2">{{ $producto->nombre }}</h1>
                    <div class="flex items-center gap-3 mb-3">
                        <span class="text-2xl font-semibold text-[#facc15]">
                            L {{ number_format($producto->precio_venta, 2) }}
                        </span>
                        <span
                            class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                            {{ $producto->disponible ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $producto->disponible ? 'Disponible' : 'Agotado' }}
                        </span>
                    </div>
                    <div class="mb-3">
                        <span class="text-gray-500 font-medium">Categoría:</span>
                        <span class="text-indigo-700 font-semibold">
                            {{ $producto->categoria->nombre ?? 'Sin categoría' }}
                        </span>
                    </div>
                    @if ($producto->etiquetas && $producto->etiquetas->count())
                        <div class="mb-3 flex flex-wrap gap-2">
                            @foreach ($producto->etiquetas as $etiqueta)
                                <span class="bg-indigo-100 text-indigo-700 px-2 py-1 rounded text-xs font-medium">
                                    #{{ $etiqueta->nombre }}
                                </span>
                            @endforeach
                        </div>
                    @endif
                    <div class="text-gray-700 text-base mb-6 leading-relaxed">
                        {{ $producto->descripcion }}
                    </div>
                </div>

                <!-- Botón de acción y formulario -->
                <form action="{{ route('carrito.agregar') }}" method="POST" class="mt-4">
                    @csrf
                    <input type="hidden" name="producto_id" value="{{ $producto->id }}">
                    <input type="hidden" name="cantidad" value="1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Comentario  (Solo aplica para caso de ropa o calzado):</label>
                    <textarea name="comentario" rows="2" class="w-full border-gray-300 rounded-md shadow-sm mb-3"
                        placeholder="Ej: Talla M, color negro, modelo ajustado"></textarea>
                    @if ($producto->disponible)
                        <button type="submit"
                            class="w-full bg-[#facc15] hover:bg-yellow-400 text-indigo-900 font-bold py-3 px-6 rounded-lg shadow transition text-lg">
                            Solicitar producto
                        </button>
                    @else
                        <button type="button"
                            class="w-full bg-gray-400 text-white font-semibold py-3 px-6 rounded-lg shadow cursor-not-allowed text-lg"
                            disabled>
                            Producto agotado
                        </button>
                    @endif
                </form>

                @if (auth()->user()?->is_admin && $producto->link_compra)
                    <a href="{{ $producto->link_compra }}" target="_blank"
                        class="mt-4 inline-block text-sm text-blue-700 hover:underline">
                        Ver en proveedor
                    </a>
                @endif
            </div>
        </div>

        <!-- Más productos similares -->
        @if (isset($similares) && $similares->count())
            <div class="max-w-6xl mx-auto mt-12">
                <h3 class="text-xl font-bold text-indigo-900 mb-4">Más productos similares</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    @foreach ($similares as $sim)
                        <a href="{{ route('productos.show', $sim) }}"
                            class="bg-white rounded-xl shadow hover:shadow-lg transition p-3 flex flex-col items-center">
                            <img src="{{ $sim->imagenes->first() ? asset('storage/' . $sim->imagenes->first()->ruta) : 'https://via.placeholder.com/150' }}"
                                alt="{{ $sim->nombre }}" class="w-24 h-24 object-contain mb-2 rounded">
                            <div class="text-sm font-semibold text-gray-800 text-center">{{ $sim->nombre }}</div>
                            <div class="text-[#facc15] font-bold text-base">L
                                {{ number_format($sim->precio_venta, 2) }}</div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
