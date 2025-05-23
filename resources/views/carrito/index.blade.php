<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800">
            Mi Carrito de Pedido
        </h2>
    </x-slot>

    <div class="max-w-6xl mx-auto py-6 px-4">
        @if (session('success'))
            <div class="mb-4 text-green-600 font-semibold">{{ session('success') }}</div>
        @endif

        @if (count($carrito) > 0)
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-2">Imagen</th>
                        <th class="p-2">Producto</th>
                        <th class="p-2">Precio</th>
                        <th class="p-2">Cantidad</th>
                        <th class="p-2">Total</th>
                        <th class="p-2">Comentario</th>
                        <th class="p-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach ($carrito as $key => $item)
                        @php
                            $subtotal = $item['precio'] * $item['cantidad'];
                            $total += $subtotal;
                        @endphp
                        <tr class="border-t">
                            <td class="p-2">
                                @if ($item['imagen'])
                                    <img src="{{ $item['imagen'] }}" class="w-16 h-16 object-cover rounded">
                                @endif
                            </td>
                            <td class="p-2">{{ $item['nombre'] }}</td>
                            <td class="p-2">L {{ number_format($item['precio'], 2) }}</td>
                            <td class="p-2">{{ $item['cantidad'] }}</td>
                            <td class="p-2">L {{ number_format($subtotal, 2) }}</td>
                            <td class="p-2">{{ $item['comentario'] }}</td>
                            <td class="p-2">
                                <form action="{{ route('carrito.eliminar', $key) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="text-red-600 hover:text-red-800 text-sm font-bold">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    <tr class="bg-gray-100 font-bold">
                        <td colspan="4" class="p-2 text-right">Total:</td>
                        <td colspan="2" class="p-2">L {{ number_format($total, 2) }}</td>
                    </tr>

                </tbody>
            </table>

            <div class="mt-6 text-right">
                <form action="{{ route('carrito.confirmar') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg">
                        Confirmar Pedido
                    </button>
                </form>
            </div>
        @else
            <p class="text-gray-500">Tu carrito está vacío.</p>
        @endif
    </div>
</x-app-layout>
