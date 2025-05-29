<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-blue-900">Mi Carrito de Pedido</h2>
            <span class="text-lg font-semibold text-yellow-500">EncargaYa</span>
        </div>
    </x-slot>

    <div class="bg-gray-50 min-h-screen py-6 px-2 sm:px-4">
        {{-- Toast de éxito --}}
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 2500)"
                class="fixed top-6 right-6 z-50 flex items-center gap-2 bg-green-100 text-green-800 px-4 py-2 rounded shadow-lg transition-all">
                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M5 13l4 4L19 7"></path>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Productos (col-span-2 en desktop) --}}
            <div class="lg:col-span-2">
                @if (count($carrito) > 0)
                    <div class="flex justify-end mb-4">
                        <a href="{{ route('productos.index') }}"
                            class="inline-flex items-center gap-1 px-4 py-2 bg-yellow-100 text-blue-900 rounded-lg font-semibold shadow hover:bg-yellow-200 transition-all hover:scale-105">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 12h18M3 12l6-6M3 12l6 6"></path>
                            </svg>
                            Seguir comprando
                        </a>
                    </div>
                    <div class="bg-white rounded-lg shadow-md p-4">
                        <h3 class="text-xl font-bold mb-4 text-blue-900">Productos en tu carrito</h3>
                        <ul class="overflow-y-auto max-h-[70vh] pr-2 transition-all">
                            @php $total = 0; $totalProductos = 0; @endphp
                            @foreach ($carrito as $key => $item)
                                @php
                                    $subtotal = $item['precio'] * $item['cantidad'];
                                    $total += $subtotal;
                                    $totalProductos += $item['cantidad'];
                                    $agotado = isset($item['disponible']) && !$item['disponible'];
                                    $stock = $item['stock'] ?? 20;
                                @endphp
                                <li class="mb-4 last:mb-0">
                                    <div class="flex flex-col sm:flex-row bg-gray-100 rounded-lg shadow-md hover:shadow-lg transition-all hover:scale-[1.01] p-4 gap-4 items-center">
                                        <div class="flex-shrink-0 w-24 h-24 sm:w-28 sm:h-28 bg-white rounded-lg flex items-center justify-center overflow-hidden border">
                                            @if ($item['imagen'])
                                                <img src="{{ $item['imagen'] }}" alt="{{ $item['nombre'] }}"
                                                    class="object-cover w-full h-full transition-all duration-300">
                                            @else
                                                <div class="w-full h-full bg-gray-200 rounded"></div>
                                            @endif
                                        </div>
                                        <div class="flex-1 w-full flex flex-col gap-1">
                                            <div class="flex items-center gap-2">
                                                <a href="{{ route('productos.show', $item['id'] ?? 0) }}"
                                                    class="text-lg font-semibold text-blue-900 hover:underline transition-all">
                                                    {{ $item['nombre'] }}
                                                </a>
                                                @if($agotado)
                                                    <span class="ml-2 px-2 py-0.5 text-xs font-bold bg-red-100 text-red-700 rounded transition-all">Agotado</span>
                                                @else
                                                    <span class="ml-2 px-2 py-0.5 text-xs font-bold bg-green-100 text-green-700 rounded transition-all">Disponible</span>
                                                @endif
                                            </div>
                                            <div class="flex flex-wrap items-center gap-3 mt-1">
                                                <span class="text-gray-700 font-medium text-sm">Precio: <span class="font-semibold">L {{ number_format($item['precio'], 2) }}</span></span>
                                                <span class="text-gray-500 text-sm">Subtotal: <span class="font-semibold">L {{ number_format($subtotal, 2) }}</span></span>
                                            </div>
                                            <div class="flex items-center gap-2 mt-2">
                                                <form action="{{ route('carrito.actualizar', $key) }}" method="POST" class="flex items-center gap-1">
                                                    @csrf
                                                    <label for="cantidad-{{ $key }}" class="text-sm text-gray-600">Cantidad:</label>
                                                    <select name="cantidad" id="cantidad-{{ $key }}"
                                                        class="border rounded px-2 py-1 text-sm focus:ring-blue-500 transition-all"
                                                        onchange="this.form.submit()" @if($agotado) disabled @endif>
                                                        @for($i = 1; $i <= min(20, $stock); $i++)
                                                            <option value="{{ $i }}" @if($item['cantidad'] == $i) selected @endif>{{ $i }}</option>
                                                        @endfor
                                                    </select>
                                                    @if(isset($item['stock']) && $item['cantidad'] > $item['stock'])
                                                        <span class="ml-2 text-xs text-red-600 font-semibold">Stock insuficiente</span>
                                                    @endif
                                                </form>
                                            </div>
                                            @if (!empty($item['comentario']))
                                                <div class="mt-1 text-xs text-gray-500">Comentario: {{ $item['comentario'] }}</div>
                                            @endif
                                        </div>
                                        <div class="flex flex-col gap-2 mt-2 sm:mt-0">
                                            <form action="{{ route('carrito.eliminar', $key) }}" method="POST"
                                                onsubmit="return confirm('¿Seguro que deseas eliminar este producto?');">
                                                @csrf
                                                <button type="submit"
                                                    class="inline-flex items-center gap-1 text-blue-900 hover:underline font-semibold text-sm px-2 py-1 rounded hover:bg-blue-50 transition-all">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                    Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <div class="bg-white rounded-lg shadow-md p-8 text-center text-gray-500 flex flex-col items-center justify-center gap-4">
                        <svg class="w-16 h-16 mx-auto text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.35 2.7A2 2 0 0 0 7.5 19h9a2 2 0 0 0 1.85-1.3L17 13M7 13V6h13"></path>
                        </svg>
                        <div class="text-lg font-semibold text-blue-900">Tu carrito está vacío</div>
                        <div class="text-sm text-gray-400">¡Agrega productos para comenzar tu pedido!</div>
                        <a href="{{ route('productos.index') }}"
                            class="inline-flex items-center gap-1 px-4 py-2 bg-yellow-100 text-blue-900 rounded-lg font-semibold shadow hover:bg-yellow-200 transition-all hover:scale-105 mt-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 12h18M3 12l6-6M3 12l6 6"></path>
                            </svg>
                            Ver productos
                        </a>
                    </div>
                @endif
            </div>

            {{-- Resumen de compra --}}
            <div class="lg:col-span-1">
                <div class="sticky top-6">
                    <div class="bg-white rounded-lg shadow-md p-6 mb-4">
                        <h3 class="text-lg font-bold mb-2 text-blue-900">Resumen de compra</h3>
                        <div class="flex justify-between text-gray-700 mb-1">
                            <span>Total de productos:</span>
                            <span class="font-semibold">{{ $totalProductos ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between text-gray-700 mb-3">
                            <span>Total general:</span>
                            <span class="font-bold text-xl text-blue-900">L {{ number_format($total ?? 0, 2) }}</span>
                        </div>
                        <div class="text-xs text-gray-500 mb-4">El envío se calcula al confirmar.</div>
                        @if (count($carrito) > 0)
                            <form action="{{ route('carrito.confirmar') }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full bg-yellow-400 hover:bg-yellow-500 text-blue-900 font-bold py-3 rounded-lg text-lg shadow transition-all hover:scale-105">
                                    Confirmar Pedido
                                </button>
                            </form>
                        @else
                            <button disabled
                                class="w-full bg-yellow-200 text-gray-400 font-bold py-3 rounded-lg text-lg cursor-not-allowed">
                                Confirmar Pedido
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Responsive: resumen al final en móvil --}}
        <div class="lg:hidden mt-8">
            <details class="bg-white rounded-lg shadow-md">
                <summary class="px-4 py-3 font-bold text-blue-900 cursor-pointer">Resumen de compra</summary>
                <div class="p-4">
                    <div class="flex justify-between text-gray-700 mb-1">
                        <span>Total de productos:</span>
                        <span class="font-semibold">{{ $totalProductos ?? 0 }}</span>
                    </div>
                    <div class="flex justify-between text-gray-700 mb-3">
                        <span>Total general:</span>
                        <span class="font-bold text-xl text-blue-900">L {{ number_format($total ?? 0, 2) }}</span>
                    </div>
                    <div class="text-xs text-gray-500 mb-4">El envío se calcula al confirmar.</div>
                    @if (count($carrito) > 0)
                        <form action="{{ route('carrito.confirmar') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="w-full bg-yellow-400 hover:bg-yellow-500 text-blue-900 font-bold py-3 rounded-lg text-lg shadow transition-all hover:scale-105">
                                Confirmar Pedido
                            </button>
                        </form>
                    @else
                        <button disabled
                            class="w-full bg-yellow-200 text-gray-400 font-bold py-3 rounded-lg text-lg cursor-not-allowed">
                            Confirmar Pedido
                        </button>
                    @endif
                </div>
            </details>
        </div>
    </div>
</x-app-layout>
