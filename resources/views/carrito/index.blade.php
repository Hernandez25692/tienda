<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-blue-900">Mi Carrito de Pedido</h2>
            <span class="text-lg font-semibold text-yellow-500">EncargaYa</span>
        </div>
    </x-slot>

    <div class="bg-gray-50 min-h-screen py-6 px-2 sm:px-4">
        @if (session('success'))
            <div class="mb-4 text-green-600 font-semibold">{{ session('success') }}</div>
        @endif

        <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Productos (col-span-2 en desktop) --}}
            <div class="lg:col-span-2">
                @if (count($carrito) > 0)
                    <div class="bg-white rounded-lg shadow p-4">
                        <h3 class="text-xl font-bold mb-4 text-blue-900">Productos en tu carrito</h3>
                        <ul>
                            @php $total = 0; $totalProductos = 0; @endphp
                            @foreach ($carrito as $key => $item)
                                @php
                                    $subtotal = $item['precio'] * $item['cantidad'];
                                    $total += $subtotal;
                                    $totalProductos += $item['cantidad'];
                                    $agotado = isset($item['disponible']) && !$item['disponible'];
                                @endphp
                                <li class="flex flex-col sm:flex-row items-center gap-4 border-b py-4 last:border-b-0">
                                    <div class="w-20 h-20 flex-shrink-0">
                                        @if ($item['imagen'])
                                            <img src="{{ $item['imagen'] }}" alt="{{ $item['nombre'] }}" class="w-full h-full object-cover rounded">
                                        @else
                                            <div class="w-full h-full bg-gray-200 rounded"></div>
                                        @endif
                                    </div>
                                    <div class="flex-1 w-full">
                                        <a href="{{ route('productos.show', $item['id'] ?? 0) }}" class="text-lg font-semibold text-blue-900 hover:underline">
                                            {{ $item['nombre'] }}
                                        </a>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="text-gray-700 font-medium">L {{ number_format($item['precio'], 2) }}</span>
                                            @if($agotado)
                                                <span class="ml-2 px-2 py-0.5 text-xs font-bold bg-red-100 text-red-700 rounded">Agotado</span>
                                            @else
                                                <span class="ml-2 px-2 py-0.5 text-xs font-bold bg-green-100 text-green-700 rounded">Disponible</span>
                                            @endif
                                        </div>
                                        <div class="mt-2 flex items-center gap-3">
                                            <form action="{{ route('carrito.actualizar', $key) }}" method="POST" class="flex items-center gap-1">
                                                @csrf
                                                <label for="cantidad-{{ $key }}" class="text-sm text-gray-600">Cantidad:</label>
                                                <select name="cantidad" id="cantidad-{{ $key }}" class="border rounded px-2 py-1 text-sm focus:ring-blue-500" onchange="this.form.submit()" @if($agotado) disabled @endif>
                                                    @for($i = 1; $i <= 10; $i++)
                                                        <option value="{{ $i }}" @if($item['cantidad'] == $i) selected @endif>{{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </form>
                                            <span class="text-gray-500 text-sm">Subtotal: <span class="font-semibold">L {{ number_format($subtotal, 2) }}</span></span>
                                        </div>
                                        @if (!empty($item['comentario']))
                                            <div class="mt-1 text-xs text-gray-500">Comentario: {{ $item['comentario'] }}</div>
                                        @endif
                                    </div>
                                    <div class="flex flex-col gap-2 mt-2 sm:mt-0">
                                        <form action="{{ route('carrito.eliminar', $key) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este producto?');">
                                            @csrf
                                            <button type="submit" class="text-blue-900 hover:underline font-semibold text-sm">Eliminar</button>
                                        </form>
                                        <form action="{{ route('carrito.guardar', $key) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-blue-900 hover:underline font-semibold text-sm">Guardar para después</button>
                                        </form>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <div class="bg-white rounded-lg shadow p-8 text-center text-gray-500">
                        Tu carrito está vacío.
                    </div>
                @endif
            </div>

            {{-- Resumen de compra --}}
            <div class="lg:col-span-1">
                <div class="sticky top-6">
                    <div class="bg-white rounded-lg shadow p-6 mb-4">
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
                                    class="w-full bg-yellow-400 hover:bg-yellow-500 text-blue-900 font-bold py-3 rounded-lg text-lg shadow transition">
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
            <details class="bg-white rounded-lg shadow">
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
                                class="w-full bg-yellow-400 hover:bg-yellow-500 text-blue-900 font-bold py-3 rounded-lg text-lg shadow transition">
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
