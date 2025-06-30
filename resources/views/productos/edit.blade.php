<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-900 leading-tight tracking-tight">
            Editar Producto: <span class="text-blue-600">{{ $producto->nombre }}</span>
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 py-10">
        <div class="bg-white shadow-xl rounded-2xl p-8 border border-gray-100">

            {{-- FORMULARIO PRINCIPAL DE EDICIÓN --}}
            <form action="{{ route('productos.update', $producto->id) }}" method="POST" enctype="multipart/form-data"
                class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label class="block font-semibold text-gray-700 mb-1">Nombre</label>
                    <input type="text" name="nombre" value="{{ $producto->nombre }}" required
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition mt-1 px-4 py-2">
                </div>

                <div>
                    <label class="block font-semibold text-gray-700 mb-1">Descripción</label>
                    <textarea name="descripcion" rows="3"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition mt-1 px-4 py-2">{{ $producto->descripcion }}</textarea>
                </div>
                <div>
                    <label class="block font-semibold text-gray-700 mb-1">Categoría</label>
                    <select name="categoria_id"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition mt-1 px-4 py-2">
                        <option value="">Seleccione una categoría</option>
                        @foreach ($categorias as $cat)
                            <option value="{{ $cat->id }}"
                                {{ $producto->categoria_id == $cat->id ? 'selected' : '' }}>
                                {{ $cat->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block font-semibold text-gray-700 mb-1">Precio de Venta (L)</label>
                        <input type="number" name="precio_venta" step="0.01" value="{{ $producto->precio_venta }}"
                            required
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition mt-1 px-4 py-2">
                    </div>
                    <div>
                        <label class="block font-semibold text-gray-700 mb-1">Precio de Oferta (L)</label>
                        <input type="number" name="precio_oferta" step="0.01" value="{{ $producto->precio_oferta }}"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 transition mt-1 px-4 py-2"
                            placeholder="Ej. 399.99">
                        <p class="text-sm text-gray-500 mt-1">Si este campo se llena, se mostrará como precio
                            promocional.</p>
                    </div>
                    <div>
                        <label class="block font-semibold text-gray-700 mb-1">Válido hasta (oferta)</label>
                        <input type="datetime-local" name="oferta_expires_at"
                            value="{{ $producto->oferta_expires_at ? \Carbon\Carbon::parse($producto->oferta_expires_at)->format('Y-m-d\TH:i') : '' }}"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 transition mt-1 px-4 py-2">
                        <p class="text-sm text-gray-500 mt-1">La oferta será válida hasta esta fecha (opcional).</p>
                    </div>

                    <div>
                        <label class="block font-semibold text-gray-700 mb-1">Precio de Compra</label>
                        <input type="number" name="precio_compra" step="0.01"
                            value="{{ $producto->precio_compra }}"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition mt-1 px-4 py-2">
                    </div>
                </div>

                <div>
                    <label class="block font-semibold text-gray-700 mb-1">Link de Compra</label>
                    <input type="url" name="link_compra" value="{{ $producto->link_compra }}"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition mt-1 px-4 py-2">
                </div>

                <div>
                    <label class="block font-semibold text-gray-700 mb-1">Estado</label>
                    <select name="disponible"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition mt-1 px-4 py-2">
                        <option value="1" {{ $producto->disponible ? 'selected' : '' }}>Disponible</option>
                        <option value="0" {{ !$producto->disponible ? 'selected' : '' }}>Agotado</option>
                    </select>
                </div>

                <div>
                    <label class="block font-semibold text-gray-700 mb-1">Agregar nuevas imágenes</label>
                    <input type="file" name="imagenes[]" multiple
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition mt-1 px-4 py-2 bg-gray-50">
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-2 rounded-lg shadow transition duration-200">
                        Actualizar
                    </button>
                </div>
            </form>

            {{-- IMÁGENES ACTUALES CON BOTONES DE ELIMINACIÓN --}}
            <div class="mt-10">
                <label class="block font-semibold text-gray-700 mb-3">Imágenes actuales:</label>
                <div class="flex flex-wrap gap-6">
                    @foreach ($producto->imagenes as $img)
                        <div class="relative w-28 h-28 group">
                            <img src="{{ asset('storage/' . $img->ruta) }}"
                                class="w-28 h-28 object-cover rounded-lg shadow border border-gray-200 group-hover:opacity-70 transition">
                            <form action="{{ route('imagenes.forceDestroy', $img->id) }}" method="POST"
                                onsubmit="event.stopPropagation(); return confirm('¿Deseas eliminar esta imagen?')"
                                class="absolute top-1 right-1 z-10">
                                @csrf
                                <button type="submit"
                                    class="text-red-600 bg-white bg-opacity-90 hover:bg-red-100 rounded-full p-1 shadow-lg transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                                <script>
                                    document.querySelector('form').addEventListener('submit', function(e) {
                                        const venta = parseFloat(document.querySelector('input[name="precio_venta"]').value) || 0;
                                        const compra = parseFloat(document.querySelector('input[name="precio_compra"]').value) || 0;
                                        const oferta = parseFloat(document.querySelector('input[name="precio_oferta"]').value) || null;

                                        if (compra > venta) {
                                            alert('❌ El precio de compra no puede ser mayor que el precio de venta.');
                                            e.preventDefault();
                                            return;
                                        }

                                        if (oferta !== null && oferta >= venta) {
                                            alert('❌ El precio de oferta debe ser menor que el precio de venta.');
                                            e.preventDefault();
                                        }
                                    });
                                </script>

                            </form>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
