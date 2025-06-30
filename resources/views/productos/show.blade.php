<x-app-layout>
    <div x-data="{
        imagenSeleccionada: '{{ $producto->imagenes->first() ? asset('storage/' . $producto->imagenes->first()->ruta) : '' }}',
        lightbox: false,
        imagenLightbox: '',
        abrirLightbox(src) {
            this.imagenLightbox = src;
            this.lightbox = true;
        },
        cerrarLightbox() { this.lightbox = false; }
    }" class="bg-[#f9fafb] min-h-screen py-2 px-0 sm:px-2">
        <div
            class="max-w-full md:max-w-4xl mx-auto bg-white shadow-xl rounded-none md:rounded-2xl p-2 md:p-6 flex flex-col gap-4 md:gap-8">
            <!-- Galería de imágenes -->
            <div class="flex flex-col gap-2" x-data="{
                imagenes: [
                    @foreach ($producto->imagenes as $img)
                            '{{ asset('storage/' . $img->ruta) }}', @endforeach
                ],
                imagenSeleccionada: '{{ $producto->imagenes->first() ? asset('storage/' . $producto->imagenes->first()->ruta) : '' }}',
                indiceActual: 0,
                siguienteImagen() {
                    if (this.indiceActual < this.imagenes.length - 1) {
                        this.indiceActual++;
                        this.imagenSeleccionada = this.imagenes[this.indiceActual];
                    }
                },
                anteriorImagen() {
                    if (this.indiceActual > 0) {
                        this.indiceActual--;
                        this.imagenSeleccionada = this.imagenes[this.indiceActual];
                    }
                },
                actualizarIndice() {
                    this.indiceActual = this.imagenes.indexOf(this.imagenSeleccionada);
                },
                iniciarX: null,
                onTouchStart(e) {
                    this.iniciarX = e.touches[0].clientX;
                },
                onTouchEnd(e) {
                    if (this.iniciarX === null) return;
                    let finX = e.changedTouches[0].clientX;
                    let diff = finX - this.iniciarX;
                    if (Math.abs(diff) > 40) {
                        if (diff < 0) {
                            this.siguienteImagen();
                        } else {
                            this.anteriorImagen();
                        }
                    }
                    this.iniciarX = null;
                }
            }" x-init="actualizarIndice()">
                <div class="w-full aspect-square bg-gray-100 rounded-xl overflow-hidden border relative group cursor-zoom-in flex items-center justify-center mx-auto max-w-xs md:max-w-md"
                    @click="abrirLightbox(imagenSeleccionada)" @touchstart="onTouchStart($event)"
                    @touchend="onTouchEnd($event)">
                    <img :src="imagenSeleccionada" alt="Imagen principal de {{ $producto->nombre }}"
                        class="w-full h-full object-contain transition-transform duration-300 group-hover:scale-105">
                    <span
                        class="absolute bottom-2 right-2 bg-white/80 text-xs px-2 py-1 rounded text-gray-700 shadow hidden sm:block">
                        Toca para ampliar / desliza para cambiar
                    </span>
                    <!-- Flechas para escritorio -->
                    <button type="button" @click.stop="anteriorImagen()"
                        class="hidden md:flex absolute left-2 top-1/2 -translate-y-1/2 bg-white/70 hover:bg-white text-gray-700 rounded-full p-2 shadow"
                        :disabled="indiceActual === 0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button type="button" @click.stop="siguienteImagen()"
                        class="hidden md:flex absolute right-2 top-1/2 -translate-y-1/2 bg-white/70 hover:bg-white text-gray-700 rounded-full p-2 shadow"
                        :disabled="indiceActual === imagenes.length - 1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
                <div class="flex gap-1 mt-1 overflow-x-auto pb-1 scrollbar-thin scrollbar-thumb-indigo-200">
                    <template x-for="(img, idx) in imagenes" :key="img">
                        <img :src="img"
                            class="w-10 h-10 md:w-14 md:h-14 object-cover border-2 rounded-lg cursor-pointer transition
                                hover:ring-2 hover:ring-indigo-500"
                            :class="imagenSeleccionada === img ? 'ring-2 ring-[#facc15]' : ''"
                            @click="imagenSeleccionada = img; indiceActual = idx"
                            alt="Miniatura de {{ $producto->nombre }}">
                    </template>
                </div>
            </div>

            <!-- Lightbox -->
            <template x-if="lightbox">
                <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/80" x-show="lightbox"
                    x-transition @click.self="cerrarLightbox()">
                    <img :src="imagenLightbox"
                        class="max-h-[80vh] max-w-[95vw] md:max-h-[90vh] md:max-w-[90vw] rounded shadow-lg border-4 border-white"
                        alt="Imagen ampliada">
                    <button @click="cerrarLightbox()"
                        class="absolute top-4 right-4 md:top-6 md:right-8 text-white text-3xl font-bold bg-black/40 rounded-full w-10 h-10 flex items-center justify-center">
                        &times;
                    </button>
                </div>
            </template>

            <!-- Detalles del producto -->
            <div class="flex flex-col gap-2 md:gap-3">
                <h1 class="text-lg md:text-2xl font-bold text-indigo-900 mb-1 truncate">{{ $producto->nombre }}</h1>
                <div class="flex items-center gap-2 mb-1 flex-wrap">
                    @php
                        $ofertaVigente =
                            $producto->precio_oferta &&
                            $producto->precio_oferta < $producto->precio_venta &&
                            (!$producto->oferta_expires_at || now()->lte($producto->oferta_expires_at));
                    @endphp

                    @if ($ofertaVigente)

                        <span class="text-red-500 font-bold text-lg md:text-xl">
                            L {{ number_format($producto->precio_oferta, 2) }}
                        </span>
                        <span class="text-gray-400 line-through text-sm md:text-base">
                            L {{ number_format($producto->precio_venta, 2) }}
                        </span>
                        <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-2">
                            <span
                                class="bg-red-100 text-red-700 text-xs font-bold px-2 py-0.5 rounded-full uppercase tracking-wide">
                                🔥 ¡Oferta disponible!
                            </span>

                            @if ($producto->oferta_expires_at)
                                <span class="text-orange-600 text-xs font-semibold countdown-timer"
                                    data-expira="{{ \Carbon\Carbon::parse($producto->oferta_expires_at)->format('Y-m-d H:i:s') }}">
                                    ⏳ Cargando cuenta regresiva...
                                </span>
                            @endif
                        </div>
                    @else
                        <span class="text-[#facc15] font-semibold text-lg md:text-xl">
                            L {{ number_format($producto->precio_venta, 2) }}
                        </span>
                    @endif

                    <span
                        class="inline-block px-2 py-0.5 rounded-full text-xs md:text-sm font-semibold
        {{ $producto->disponible ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $producto->disponible ? 'Disponible' : 'Agotado' }}
                    </span>
                </div>

                <!-- Collapsibles para info secundaria en móvil -->
                <details class="block md:hidden mb-1">
                    <summary class="text-gray-500 font-medium cursor-pointer select-none text-sm">Detalles</summary>
                    <div class="pl-2 mt-1 space-y-1">
                        <div>
                            <span class="text-gray-500 font-medium">Categoría:</span>
                            <span class="text-indigo-700 font-semibold">
                                {{ $producto->categoria->nombre ?? 'Sin categoría' }}
                            </span>
                        </div>
                        @if ($producto->etiquetas && $producto->etiquetas->count())
                            <div class="flex flex-wrap gap-1">
                                @foreach ($producto->etiquetas as $etiqueta)
                                    <span class="bg-indigo-100 text-indigo-700 px-2 py-0.5 rounded text-xs font-medium">
                                        #{{ $etiqueta->nombre }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </details>
                <!-- Desktop info secundaria -->
                <div class="hidden md:flex items-center gap-4 mb-1">
                    <div>
                        <span class="text-gray-500 font-medium">Categoría:</span>
                        <span class="text-indigo-700 font-semibold">
                            {{ $producto->categoria->nombre ?? 'Sin categoría' }}
                        </span>
                    </div>
                    @if ($producto->etiquetas && $producto->etiquetas->count())
                        <div class="flex flex-wrap gap-2">
                            @foreach ($producto->etiquetas as $etiqueta)
                                <span class="bg-indigo-100 text-indigo-700 px-2 py-1 rounded text-xs font-medium">
                                    #{{ $etiqueta->nombre }}
                                </span>
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="text-gray-700 text-sm md:text-base mb-1 leading-relaxed">
                    {{ $producto->descripcion }}
                </div>
            </div>

            <!-- Botón de acción y formulario -->
            <form action="{{ route('carrito.agregar') }}" method="POST"
                class="mt-1 flex flex-col gap-2 sticky bottom-0 bg-white z-10 pt-2 pb-2 md:static md:bg-transparent md:pt-0 md:pb-0">
                @csrf
                <input type="hidden" name="producto_id" value="{{ $producto->id }}">
                <input type="hidden" name="cantidad" value="1">
                <label class="block text-xs md:text-sm font-medium text-gray-700 mb-0.5">Comentario <span
                        class="text-gray-400">(opcional)</span></label>
                <textarea name="comentario" rows="2" class="w-full border-gray-300 rounded-md shadow-sm mb-1 text-xs md:text-sm"
                    placeholder="Ej: Talla M, color negro, modelo ajustado"></textarea>
                @if ($producto->disponible)
                    <button type="submit"
                        class="w-full bg-[#facc15] hover:bg-yellow-400 text-indigo-900 font-bold py-2 md:py-3 px-4 rounded-lg shadow transition text-base md:text-lg active:scale-95">
                        Solicitar producto
                    </button>
                @else
                    <button type="button"
                        class="w-full bg-gray-300 text-gray-500 font-semibold py-2 md:py-3 px-4 rounded-lg shadow cursor-not-allowed text-base md:text-lg"
                        disabled>
                        Producto agotado
                    </button>
                @endif
            </form>

            @if (auth()->user()?->role === 'admin')
                <div class="border-2 border-blue-500 bg-blue-50 rounded-lg p-3 flex flex-col md:flex-row items-start md:items-center gap-2 md:gap-4 mt-2 shadow-sm">
                    <div class="flex items-center gap-2">
                        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 11c0-1.657 1.343-3 3-3s3 1.343 3 3-1.343 3-3 3-3-1.343-3-3z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.341A8 8 0 1 1 12 4v0" />
                        </svg>
                        <span class="text-blue-700 font-bold text-sm md:text-base">Panel de administrador</span>
                    </div>
                    <div class="flex flex-col md:flex-row gap-2 md:gap-3">
                        @if ($producto->link_compra)
                            <a href="{{ $producto->link_compra }}" target="_blank"
                                class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white font-semibold py-1.5 px-3 rounded-lg shadow text-xs md:text-sm transition focus:outline-none focus:ring-2 focus:ring-blue-400">
                                Ver en proveedor
                                <svg class="inline w-4 h-4 ml-1 -mt-0.5" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 3h7m0 0v7m0-7L10 14m-4 0v7h7" />
                                </svg>
                            </a>
                        @endif
                        <a href="{{ route('productos.edit', $producto) }}"
                            class="inline-flex items-center bg-yellow-400 hover:bg-yellow-300 text-indigo-900 font-bold px-3 py-1.5 rounded-lg shadow text-xs md:text-sm transition focus:outline-none focus:ring-2 focus:ring-yellow-400"
                            aria-label="Editar producto">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 13l6-6m2 2l-6 6m-2 2H7v-2l6-6z" />
                            </svg>
                            Editar
                        </a>
                    </div>
                </div>
            @endif
            
        </div>

        <!-- Más productos similares -->
        @if (isset($similares) && $similares->count())
            <div class="max-w-full md:max-w-4xl mx-auto mt-6">
                <h3 class="text-base md:text-lg font-bold text-indigo-900 mb-2">Más productos similares</h3>
                <div
                    class="flex gap-2 overflow-x-auto pb-2 scrollbar-thin scrollbar-thumb-indigo-200 md:grid md:grid-cols-4 md:gap-4 md:overflow-visible">
                    @foreach ($similares as $sim)
                        <a href="{{ route('productos.show', $sim) }}"
                            class="min-w-[120px] max-w-[140px] md:min-w-0 md:max-w-none bg-white rounded-xl shadow hover:shadow-lg transition p-2 flex flex-col items-center flex-shrink-0">
                            <img src="{{ $sim->imagenes->first() ? asset('storage/' . $sim->imagenes->first()->ruta) : 'https://via.placeholder.com/150' }}"
                                alt="{{ $sim->nombre }}" class="w-14 h-14 object-contain mb-1 rounded">
                            <div class="text-xs md:text-sm font-semibold text-gray-800 text-center truncate">
                                {{ $sim->nombre }}</div>
                            <div class="text-[#facc15] font-bold text-sm md:text-base">L
                                {{ number_format($sim->precio_venta, 2) }}</div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const timers = document.querySelectorAll('.countdown-timer');

            timers.forEach(el => {
                const fechaLimite = new Date(el.dataset.expira.replace(/-/g, '/'));

                function actualizar() {
                    const ahora = new Date();
                    const diff = fechaLimite - ahora;

                    if (diff <= 0) {
                        el.innerText = "⚠️ Oferta finalizada";
                        el.classList.remove("text-orange-600");
                        el.classList.add("text-gray-400", "line-through");
                        return;
                    }

                    const dias = Math.floor(diff / (1000 * 60 * 60 * 24));
                    const horas = Math.floor((diff / (1000 * 60 * 60)) % 24);
                    const minutos = Math.floor((diff / (1000 * 60)) % 60);
                    const segundos = Math.floor((diff / 1000) % 60);

                    el.innerText = `⏳ Finaliza en ${dias}d ${horas}h ${minutos}m ${segundos}s`;
                }

                actualizar();
                setInterval(actualizar, 1000);
            });
        });
    </script>

</x-app-layout>
