<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between px-2 sm:px-0 py-2">
            <h2
                class="text-2xl sm:text-4xl font-extrabold text-[#1e3a8a] tracking-tight drop-shadow-sm flex items-center gap-2">
                <svg class="w-7 h-7 sm:w-9 sm:h-9 text-[#facc15]" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.35 2.7A2 2 0 0 0 7.5 19h9a2 2 0 0 0 1.85-1.3L17 13M7 13V6h13" />
                </svg>
                Mi Carrito
            </h2>
            <a href="{{ route('productos.index') }}"
                class="hidden sm:inline-flex items-center gap-2 px-4 py-2 bg-[#facc15] text-[#1e3a8a] rounded-lg font-bold shadow hover:bg-yellow-300 transition-all hover:scale-105 focus:outline-none focus:ring-2 focus:ring-[#1e3a8a] text-sm sm:text-base">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12h18M3 12l6-6M3 12l6 6"></path>
                </svg>
                Seguir comprando
            </a>
        </div>
    </x-slot>

    <div class="bg-gray-50 min-h-screen py-2 px-1 sm:px-4">
        {{-- Toast de éxito --}}
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 2500)"
                class="fixed top-4 right-4 z-50 flex items-center gap-2 bg-green-100 text-green-800 px-3 py-1.5 rounded shadow-lg transition-all text-sm">
                <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-8">
            {{-- Productos --}}
            <div class="lg:col-span-2">
                @if (isset($hay_ofertas_vencidas) && $hay_ofertas_vencidas)
                    <div
                        class="mb-4 bg-red-100 border border-red-300 text-red-800 px-4 py-2 rounded shadow text-sm font-semibold">
                        ⚠️ Algunos productos han cambiado de precio porque su oferta ya venció. Por favor, revisa antes
                        de confirmar tu pedido.
                    </div>
                @endif

                @if (count($carrito) > 0)
                    <div class="flex justify-end mb-2">
                        <a href="{{ route('productos.index') }}"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-[#facc15] text-[#1e3a8a] rounded-lg font-bold shadow hover:bg-yellow-300 transition-all hover:scale-105 focus:outline-none focus:ring-2 focus:ring-[#1e3a8a] text-sm sm:text-base">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12h18M3 12l6-6M3 12l6 6">
                                </path>
                            </svg>
                            Seguir comprando
                        </a>
                    </div>
                    <div class="bg-white rounded-xl shadow-lg p-2 sm:p-4">
                        <h3 class="text-lg sm:text-2xl font-bold mb-2 text-[#1e3a8a]">Productos</h3>
                        <ul class="overflow-y-auto max-h-[65vh] pr-4 sm:pr-6 transition-all space-y-3
                            scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100
                            hover:scrollbar-thumb-gray-400
                            lg:scrollbar-thumb-[#facc15] lg:scrollbar-track-[#fef9c3]
                            scrollbar-thumb-rounded-full scrollbar-track-rounded-full"
                            style="
                                scrollbar-width: thin;
                                scrollbar-color: #facc15 #fef9c3;
                                padding-bottom: 0.5rem;
                            ">
                            @php
                                $total = 0;
                                $totalProductos = 0;
                            @endphp
                            @foreach ($carrito as $key => $item)
                                @php
                                    $subtotal = $item['precio'] * $item['cantidad'];
                                    $total += $subtotal;
                                    $totalProductos += $item['cantidad'];
                                    $agotado = isset($item['disponible']) && !$item['disponible'];
                                    $stock = $item['stock'] ?? 20;

                                    // Calcular rebaja por producto si hay precio_venta y precio menor (oferta)
                                    $rebajaUnidad = 0;
                                    if (isset($item['precio_venta']) && $item['precio_venta'] > $item['precio']) {
                                        $rebajaUnidad = $item['precio_venta'] - $item['precio'];
                                    }
                                    $totalRebajas = ($totalRebajas ?? 0) + $rebajaUnidad * $item['cantidad'];
                                @endphp

                                <li>
                                    <div
                                        class="flex gap-2 sm:gap-4 bg-gray-100 rounded-xl shadow hover:shadow-xl transition-all hover:scale-[1.01] p-2 sm:p-3 items-center">
                                        <div
                                            class="flex-shrink-0 w-16 h-16 sm:w-24 sm:h-24 bg-white rounded-lg flex items-center justify-center overflow-hidden border border-gray-200">
                                            @if ($item['imagen'])
                                                <img src="{{ $item['imagen'] }}" alt="{{ $item['nombre'] }}"
                                                    class="object-contain w-full h-full transition-all duration-300"
                                                    loading="lazy">
                                            @else
                                                <div class="w-full h-full bg-gray-200 rounded"></div>
                                            @endif
                                        </div>
                                        <div class="flex-1 flex flex-col gap-0.5">
                                            <div class="flex items-center gap-1 flex-wrap">
                                                <a href="{{ route('productos.show', $item['id'] ?? 0) }}"
                                                    class="text-base sm:text-lg font-bold text-[#1e3a8a] hover:underline transition-all truncate max-w-[120px] sm:max-w-none">
                                                    {{ \Illuminate\Support\Str::limit($item['nombre'], 40) }}
                                                </a>
                                                @if ($agotado)
                                                    <span
                                                        class="ml-1 px-1 py-0.5 text-[10px] font-bold bg-red-100 text-red-700 rounded">Agotado</span>
                                                @else
                                                    <span
                                                        class="ml-1 px-1 py-0.5 text-[10px] font-bold bg-green-100 text-green-700 rounded">Disponible</span>
                                                @endif
                                            </div>
                                            <div class="flex flex-wrap items-center gap-2 mt-0.5">
                                                @php
                                                    $oferta_activa =
                                                        isset($item['precio_oferta'], $item['precio_venta']) &&
                                                        $item['precio_oferta'] < $item['precio_venta'] &&
                                                        (!isset($item['oferta_expires_at']) ||
                                                            \Carbon\Carbon::parse(
                                                                $item['oferta_expires_at'],
                                                            )->isFuture());

                                                    $oferta_vencida =
                                                        isset(
                                                            $item['precio_oferta'],
                                                            $item['precio_venta'],
                                                            $item['oferta_expires_at'],
                                                        ) &&
                                                        $item['precio_oferta'] < $item['precio_venta'] &&
                                                        \Carbon\Carbon::parse($item['oferta_expires_at'])->isPast();
                                                @endphp

                                                @if ($oferta_activa)
                                                    <div class="flex items-center gap-2 text-xs font-semibold">
                                                        <span class="text-red-600 font-bold">
                                                            L {{ number_format($item['precio_oferta'], 2) }}
                                                        </span>
                                                        <span class="line-through text-gray-400">
                                                            L {{ number_format($item['precio_venta'], 2) }}
                                                        </span>

                                                        <span class="flex items-center gap-1 flex-wrap">
                                                            <span
                                                                class="bg-red-100 text-red-700 px-1.5 py-0.5 rounded-full text-[10px] uppercase tracking-wide">Oferta</span>
                                                            @if (!empty($item['oferta_expires_at']))
                                                                <span
                                                                    class="cuenta-regresiva text-[10px] text-orange-500 font-semibold block sm:inline-block sm:ml-1 mt-0.5 sm:mt-0 max-w-[120px] truncate"
                                                                    data-expira="{{ \Carbon\Carbon::parse($item['oferta_expires_at'])->format('Y-m-d H:i:s') }}">
                                                                    ⏳ Cargando...
                                                                </span>
                                                            @endif
                                                        </span>
                                                    </div>
                                                @elseif ($oferta_vencida)
                                                    <div class="flex items-center gap-2 text-xs font-semibold">
                                                        <span class="text-gray-700 font-medium text-xs">
                                                            L <span
                                                                class="font-bold text-[#1e3a8a]">{{ number_format($item['precio'], 2) }}</span>
                                                        </span>
                                                        <span
                                                            class="bg-gray-100 text-red-600 px-1.5 py-0.5 rounded-full text-[10px] uppercase tracking-wide">
                                                            ⛔ Oferta finalizada
                                                        </span>
                                                        <span class="text-gray-400 line-through text-[11px]">
                                                            L {{ number_format($item['precio_venta'], 2) }}
                                                        </span>
                                                    </div>
                                                @else
                                                    <span class="text-gray-700 font-medium text-xs">
                                                        L <span
                                                            class="font-bold text-[#1e3a8a]">{{ number_format($item['precio'], 2) }}</span>
                                                    </span>
                                                @endif


                                                <span class="text-gray-500 text-xs">Subt: <span
                                                        class="font-bold text-[#1e3a8a]">L
                                                        {{ number_format($subtotal, 2) }}</span></span>
                                            </div>
                                            <div class="flex items-center gap-1 mt-1">
                                                <form action="{{ route('carrito.actualizar', $key) }}" method="POST"
                                                    class="flex items-center gap-1">
                                                    @csrf
                                                    <div
                                                        class="flex items-center gap-1 bg-white border border-gray-200 rounded-lg px-2 py-1 shadow-sm">
                                                        <label for="cantidad-{{ $key }}"
                                                            class="text-xs text-gray-600 font-semibold">Cantidad:</label>
                                                        <select name="cantidad" id="cantidad-{{ $key }}"
                                                            class="border-none bg-transparent text-xs font-bold text-[#1e3a8a] focus:ring-2 focus:ring-[#facc15] rounded transition-all px-1 py-0.5"
                                                            onchange="this.form.submit()"
                                                            @if ($agotado) disabled @endif>
                                                            @for ($i = 1; $i <= min(5, $stock); $i++)
                                                                <option value="{{ $i }}"
                                                                    @if ($item['cantidad'] == $i) selected @endif>
                                                                    {{ $i }}</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                    @if (isset($item['stock']) && $item['cantidad'] > $item['stock'])
                                                        <span class="ml-1 text-[10px] text-red-600 font-semibold">Stock
                                                            insuficiente</span>
                                                    @endif
                                                </form>
                                            </div>
                                            @if (!empty($item['comentario']))
                                                <div class="mt-0.5 text-[11px] text-gray-500 truncate">Comentario:
                                                    {{ $item['comentario'] }}</div>
                                            @endif
                                        </div>
                                        <div class="flex flex-col gap-1">
                                            <form action="{{ route('carrito.eliminar', $key) }}" method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="inline-flex items-center justify-center text-[#1e3a8a] hover:bg-red-100 hover:text-red-700 rounded-full p-2 transition-all focus:outline-none focus:ring-2 focus:ring-[#1e3a8a]"
                                                    title="Eliminar">
                                                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none"
                                                        stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                    <span class="sr-only">Eliminar</span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <div
                        class="bg-white rounded-xl shadow-lg p-6 text-center text-gray-500 flex flex-col items-center justify-center gap-2">
                        <svg class="w-12 h-12 mx-auto text-gray-300" fill="none" stroke="currentColor"
                            stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.35 2.7A2 2 0 0 0 7.5 19h9a2 2 0 0 0 1.85-1.3L17 13M7 13V6h13">
                            </path>
                        </svg>
                        <div class="text-base font-bold text-[#1e3a8a]">Tu carrito está vacío</div>
                        <div class="text-xs text-gray-400">¡Agrega productos para comenzar tu pedido!</div>
                        <a href="{{ route('productos.index') }}"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-[#facc15] text-[#1e3a8a] rounded-lg font-bold shadow hover:bg-yellow-300 transition-all hover:scale-105 mt-2 focus:outline-none focus:ring-2 focus:ring-[#1e3a8a] text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12h18M3 12l6-6M3 12l6 6">
                                </path>
                            </svg>
                            Ver productos
                        </a>
                    </div>
                @endif
            </div>

            {{-- Resumen de compra (desktop/tablet) --}}
            <div class="lg:col-span-1 hidden lg:block">
                <div class="sticky top-6">
                    <div class="bg-white rounded-xl shadow-lg p-4 mb-4">
                        <h3 class="text-base font-bold mb-2 text-[#1e3a8a]">Resumen</h3>
                        <div class="flex justify-between text-gray-700 mb-1 text-sm">
                            <span>Productos:</span>
                            <span class="font-bold">{{ $totalProductos ?? 0 }}</span>
                        </div>
                        @if (($totalRebajas ?? 0) > 0)
                            <div class="flex justify-between text-red-700 mb-1 text-sm font-semibold">
                                <span>Total Rebaja:</span>
                                <span>- L {{ number_format($totalRebajas ?? 0, 2) }}</span>
                            </div>
                        @endif

                        <div class="flex justify-between text-gray-700 mb-2 text-sm">
                            <span>Total:</span>
                            <span class="font-extrabold text-lg text-[#1e3a8a]">L
                                {{ number_format($total ?? 0, 2) }}</span>
                        </div>

                        @if (count($carrito) > 0)
                            <form x-data="{ showModal: false }" action="{{ route('carrito.confirmar') }}" method="POST"
                                @submit.prevent="showModal = true">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-yellow-400 via-yellow-300 to-yellow-500 hover:from-yellow-500 hover:to-yellow-400 text-[#1e3a8a] font-extrabold py-3 rounded-xl text-lg shadow-lg transition-all hover:scale-105 focus:outline-none focus:ring-2 focus:ring-[#1e3a8a]">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7">
                                        </path>
                                    </svg>
                                    Confirmar Pedido
                                </button>
                                <!-- Modal de confirmación estilo Amazon -->
                                <div x-show="showModal" x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                    x-transition:leave="transition ease-in duration-150"
                                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                    class="fixed inset-0 z-50 flex items-center justify-center px-2 sm:px-0"
                                    style="display: none;">
                                    <!-- Fondo oscuro -->
                                    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"
                                        @click="showModal = false"></div>
                                    <!-- Modal -->
                                    <div
                                        class="relative w-full max-w-lg mx-auto bg-white rounded-2xl shadow-2xl overflow-hidden flex flex-col sm:flex-row p-0 sm:p-0">
                                        <!-- Imagen de producto o icono -->
                                        <div
                                            class="hidden sm:flex flex-col items-center justify-center bg-gradient-to-b from-yellow-100 to-yellow-50 w-1/3 p-6">
                                            <svg class="w-16 h-16 text-yellow-400 mb-2" fill="none"
                                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.35 2.7A2 2 0 0 0 7.5 19h9a2 2 0 0 0 1.85-1.3L17 13M7 13V6h13">
                                                </path>
                                            </svg>
                                            <span class="text-yellow-700 font-bold text-sm text-center">¡Listo para tu
                                                pedido!</span>
                                        </div>
                                        <!-- Contenido -->
                                        <div class="flex-1 p-6 flex flex-col gap-4">
                                            <div class="flex items-center gap-2 mb-2">
                                                <svg class="w-7 h-7 text-[#1e3a8a]" fill="none"
                                                    stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M13 16h-1v-4h-1m1-4h.01M12 20.5C6.201 20.5 1.5 15.799 1.5 10S6.201-.5 12-.5 22.5 4.201 22.5 10 17.799 20.5 12 20.5z" />
                                                </svg>
                                                <h2 class="text-xl font-extrabold text-[#1e3a8a]">¿Listo para confirmar
                                                    tu pedido?</h2>
                                            </div>
                                            <div
                                                class="bg-gray-50 rounded-lg p-4 flex flex-col gap-2 border border-gray-100">
                                                <div class="flex justify-between items-center text-base">
                                                    <span class="text-gray-700">Productos:</span>
                                                    <span
                                                        class="font-bold text-[#1e3a8a]">{{ $totalProductos ?? 0 }}</span>
                                                </div>
                                                @if (($totalRebajas ?? 0) > 0)
                                                    <div class="flex justify-between items-center text-base">
                                                        <span class="text-red-700">Total Rebaja:</span>
                                                        <span class="font-bold text-red-700">- L
                                                            {{ number_format($totalRebajas ?? 0, 2) }}</span>
                                                    </div>
                                                @endif
                                                <div class="flex justify-between items-center text-lg">
                                                    <span class="text-gray-700 font-semibold">Total a pagar:</span>
                                                    <span class="font-extrabold text-2xl text-[#1e3a8a]">L
                                                        {{ number_format($total ?? 0, 2) }}</span>
                                                </div>
                                            </div>
                                            <div class="flex flex-col gap-2 mt-2">
                                                <button type="button" @click="showModal = false"
                                                    class="w-full py-3 rounded-lg bg-gray-100 text-gray-600 font-bold hover:bg-gray-200 transition-all focus:outline-none focus:ring-2 focus:ring-[#1e3a8a]">
                                                    ❌ Cancelar
                                                </button>
                                                <button type="button" @click="$el.closest('form').submit()"
                                                    class="w-full py-3 rounded-lg bg-gradient-to-r from-yellow-400 via-yellow-300 to-yellow-500 text-[#1e3a8a] font-extrabold hover:from-yellow-500 hover:to-yellow-400 transition-all focus:outline-none focus:ring-2 focus:ring-[#1e3a8a] flex items-center justify-center gap-2">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    Confirmar y Enviar Pedido
                                                </button>
                                            </div>
                                            <div class="text-xs text-gray-400 text-center mt-2">
                                                Al confirmar, recibirás un resumen de tu pedido y nos pondremos en
                                                contacto para definir fecha de entrega.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @else
                            <button disabled
                                class="w-full bg-yellow-100 text-gray-400 font-bold py-3 rounded-xl text-lg cursor-not-allowed flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Confirmar Pedido
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Resumen de compra (móvil) estilo Amazon --}}
        <div class="lg:hidden mt-4">
            <div class="bg-white rounded-2xl shadow-2xl p-4 border border-yellow-100">
            <div class="flex items-center gap-2 mb-3">
                <svg class="w-7 h-7 text-yellow-400" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.35 2.7A2 2 0 0 0 7.5 19h9a2 2 0 0 0 1.85-1.3L17 13M7 13V6h13">
                </path>
                </svg>
                <h3 class="font-extrabold text-[#1e3a8a] text-lg tracking-tight">Resumen de compra</h3>
            </div>
            <div class="bg-yellow-50 rounded-lg p-3 mb-2 border border-yellow-100">
                <div class="flex justify-between text-gray-700 mb-1 text-base">
                <span>Productos:</span>
                <span class="font-bold">{{ $totalProductos ?? 0 }}</span>
                </div>
                @if (($totalRebajas ?? 0) > 0)
                <div class="flex justify-between text-red-700 mb-1 text-sm font-semibold">
                    <span>Total Rebaja:</span>
                    <span>- L {{ number_format($totalRebajas ?? 0, 2) }}</span>
                </div>
                @endif
                <div class="flex justify-between text-gray-700 mb-2 text-base">
                <span>Total:</span>
                <span class="font-extrabold text-xl text-[#1e3a8a]">L {{ number_format($total ?? 0, 2) }}</span>
                </div>
            </div>
            @if (count($carrito) > 0)
                <form x-data="{ showModal: false }" action="{{ route('carrito.confirmar') }}" method="POST"
                @submit.prevent="showModal = true">
                @csrf
                <button type="submit"
                    class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-yellow-400 via-yellow-300 to-yellow-500 hover:from-yellow-500 hover:to-yellow-400 text-[#1e3a8a] font-extrabold py-3 rounded-xl text-lg shadow-lg transition-all hover:scale-105 focus:outline-none focus:ring-2 focus:ring-[#1e3a8a]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Confirmar Pedido
                </button>
                <!-- Modal de confirmación estilo Amazon -->
                <div x-show="showModal" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                    class="fixed inset-0 z-50 flex items-center justify-center px-2" style="display: none;">
                    <!-- Fondo oscuro -->
                    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="showModal = false"></div>
                    <!-- Modal -->
                    <div class="relative bg-white rounded-2xl shadow-2xl max-w-sm w-full mx-2 p-0 flex flex-col overflow-hidden">
                    <div class="flex items-center gap-2 bg-gradient-to-r from-yellow-100 to-yellow-50 px-6 py-4 border-b border-yellow-200">
                        <svg class="w-8 h-8 text-yellow-400" fill="none" stroke="currentColor"
                        stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.35 2.7A2 2 0 0 0 7.5 19h9a2 2 0 0 0 1.85-1.3L17 13M7 13V6h13">
                        </path>
                        </svg>
                        <h2 class="text-lg font-extrabold text-[#1e3a8a]">¿Listo para confirmar tu pedido?</h2>
                    </div>
                    <div class="p-6 flex flex-col gap-4">
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-100 flex flex-col gap-2">
                        <div class="flex justify-between items-center text-base">
                            <span class="text-gray-700">Productos:</span>
                            <span class="font-bold text-[#1e3a8a]">{{ $totalProductos ?? 0 }}</span>
                        </div>
                        @if (($totalRebajas ?? 0) > 0)
                            <div class="flex justify-between items-center text-base">
                            <span class="text-red-700">Total Rebaja:</span>
                            <span class="font-bold text-red-700">- L
                                {{ number_format($totalRebajas ?? 0, 2) }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between items-center text-lg">
                            <span class="text-gray-700 font-semibold">Total a pagar:</span>
                            <span class="font-extrabold text-2xl text-[#1e3a8a]">L
                            {{ number_format($total ?? 0, 2) }}</span>
                        </div>
                        </div>
                        <div class="flex gap-2 mt-2">
                        <button type="button" @click="showModal = false"
                            class="flex-1 py-3 rounded-lg bg-gray-100 text-gray-600 font-bold hover:bg-gray-200 transition-all focus:outline-none focus:ring-2 focus:ring-[#1e3a8a]">
                            ❌ Cancelar
                        </button>
                        <button type="button" @click="$el.closest('form').submit()"
                            class="flex-1 py-3 rounded-lg bg-gradient-to-r from-yellow-400 via-yellow-300 to-yellow-500 text-[#1e3a8a] font-extrabold hover:from-yellow-500 hover:to-yellow-400 transition-all focus:outline-none focus:ring-2 focus:ring-[#1e3a8a] flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                            stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M5 13l4 4L19 7"></path>
                            </svg>
                            Confirmar y Enviar Pedido
                        </button>
                        </div>
                        <div class="text-xs text-gray-400 text-center mt-2">
                        Al confirmar, recibirás un resumen de tu pedido y nos pondremos en contacto para definir fecha de entrega.
                        </div>
                    </div>
                    </div>
                </div>
                </form>
            @else
                <button disabled
                class="w-full bg-yellow-100 text-gray-400 font-bold py-3 rounded-xl text-lg cursor-not-allowed flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                </svg>
                Confirmar Pedido
                </button>
            @endif
            </div>
        </div>
    </div>
    @if (session('ajustes_carrito'))
        <div x-data="{ open: true }" x-show="open"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
            <div class="bg-white w-full max-w-md mx-auto rounded-xl shadow-lg p-6 text-center relative">
                <h2 class="text-lg font-bold text-[#1e3a8a] mb-4">
                    ⚠️ Se detectaron cambios en tu carrito
                </h2>

                <ul
                    class="text-sm text-gray-700 mb-4 text-left list-disc list-inside space-y-1 max-h-52 overflow-y-auto">
                    @foreach (session('ajustes_carrito') as $mensaje)
                        <li>{{ $mensaje }}</li>
                    @endforeach
                </ul>

                <button @click="open = false"
                    class="px-4 py-2 bg-[#facc15] text-[#1e3a8a] font-bold rounded-lg hover:bg-yellow-300 transition-all focus:outline-none focus:ring-2 focus:ring-[#1e3a8a]">
                    Aceptar
                </button>
            </div>
        </div>
    @endif

    @push('scripts')
        <script>
            function iniciarCountdowns() {
                const elementos = document.querySelectorAll('.cuenta-regresiva');

                elementos.forEach(el => {
                    const fechaLimite = new Date(el.dataset.expira.replace(/-/g, '/')).getTime();
                    const span = el;

                    function actualizar() {
                        const ahora = new Date().getTime();
                        const diferencia = fechaLimite - ahora;

                        if (diferencia < 0) {
                            span.innerText = '⛔ Oferta finalizada';
                            span.classList.add('text-red-500', 'font-semibold');
                            return;
                        }

                        const dias = Math.floor(diferencia / (1000 * 60 * 60 * 24));
                        const horas = Math.floor((diferencia % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        const minutos = Math.floor((diferencia % (1000 * 60 * 60)) / (1000 * 60));
                        const segundos = Math.floor((diferencia % (1000 * 60)) / 1000);

                        span.innerText = `⏳ ${dias}d ${horas}h ${minutos}m ${segundos}s`;
                    }

                    setInterval(actualizar, 1000);
                    actualizar();
                });
            }

            document.addEventListener('DOMContentLoaded', iniciarCountdowns);
        </script>
    @endpush


</x-app-layout>
