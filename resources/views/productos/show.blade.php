<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">
            Catálogo - {{ $producto->nombre }}
        </h2>
    </x-slot>

    <div class="max-w-6xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-xl rounded-2xl p-8 transition hover:shadow-2xl">
            <div class="flex flex-col lg:flex-row gap-10">
                <!-- Galería de imágenes -->
                <div class="flex-1">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5">
                        @foreach ($producto->imagenes as $img)
                            <div class="overflow-hidden rounded-xl border border-gray-200 bg-gray-50 hover:scale-105 transition-transform duration-200">
                                <img src="{{ asset('storage/' . $img->ruta) }}"
                                    class="w-full h-52 object-cover rounded-xl" alt="Imagen de {{ $producto->nombre }}">
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Detalles del producto -->
                <div class="flex-1 flex flex-col justify-center">
                    <h3 class="text-3xl font-bold text-gray-800 mb-3">{{ $producto->nombre }}</h3>
                    <p class="text-gray-600 text-lg mb-4">{{ $producto->descripcion }}</p>
                    <div class="mb-3">
                        <span class="text-gray-500 font-medium">Precio de Venta:</span>
                        <span class="text-2xl font-semibold text-green-600">L {{ number_format($producto->precio_venta, 2) }}</span>
                    </div>
                    <div class="mb-3">
                        <span class="text-gray-500 font-medium">Estado:</span>
                        <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                            {{ $producto->disponible ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $producto->disponible ? 'Disponible' : 'Agotado' }}
                        </span>
                    </div>
                    @if ($producto->link_compra)
                        <a href="{{ $producto->link_compra }}" target="_blank"
                            class="inline-block mt-5 px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-700 transition">
                            Ver producto en proveedor
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
