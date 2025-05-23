<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800">Gestión de Pedidos</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4">

        <!-- Filtros -->
        <form method="GET" class="mb-6 bg-white p-4 rounded shadow flex flex-wrap gap-4 items-end">
            <div>
                <label class="text-sm font-medium">Cliente</label>
                <input type="text" name="cliente" value="{{ request('cliente') }}"
                    class="border-gray-300 rounded w-full mt-1">
            </div>
            <div>
                <label class="text-sm font-medium">Desde</label>
                <input type="date" name="desde" value="{{ request('desde') }}"
                    class="border-gray-300 rounded w-full mt-1">
            </div>
            <div>
                <label class="text-sm font-medium">Hasta</label>
                <input type="date" name="hasta" value="{{ request('hasta') }}"
                    class="border-gray-300 rounded w-full mt-1">
            </div>
            <div>
                <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Filtrar</button>
            </div>
        </form>

        @if (session('success'))
            <div class="mb-4 text-green-600">{{ session('success') }}</div>
        @endif

        <table class="w-full text-sm text-left border mb-6">
            <thead class="bg-gray-100 text-gray-600">
                <tr>
                    <th class="p-2">#</th>
                    <th class="p-2">Cliente</th>
                    <th class="p-2">Estado</th>
                    <th class="p-2">Fecha Pedido</th>
                    <th class="p-2">Entrega Estimada</th>
                    <th class="p-2">Comprobante</th>
                    <th class="p-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pedidos as $pedido)
                    <tr class="border-t bg-white">
                        <td class="p-2 font-bold">{{ $pedido->id }}</td>
                        <td class="p-2">{{ $pedido->user->name }}</td>
                        <td class="p-2 capitalize">{{ $pedido->estado }}</td>
                        <td class="p-2">{{ $pedido->created_at->format('d/m/Y') }}</td>
                        <td class="p-2">
                            {{ $pedido->fecha_entrega_estimada ? \Carbon\Carbon::parse($pedido->fecha_entrega_estimada)->format('d/m/Y') : '-' }}
                        </td>
                        <td class="p-2">
                            @if ($pedido->comprobante)
                                <a href="{{ asset('storage/' . $pedido->comprobante) }}" target="_blank"
                                    class="text-blue-600 hover:underline text-sm">Ver</a>
                            @else
                                <span class="text-gray-400 text-sm">No enviado</span>
                            @endif
                        </td>
                        <td class="p-2">
                            <a href="{{ route('admin.pedidos.edit', $pedido) }}"
                                class="text-blue-600 hover:underline text-sm">Editar</a>
                        </td>
                    </tr>
                    <tr class="bg-gray-50 text-sm text-gray-700">
                        <td colspan="7" class="px-6 py-4">
                            <div class="font-semibold mb-2">🛒 Detalle del Pedido:</div>
                            <table class="w-full border">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="p-2">Producto</th>
                                        <th class="p-2">Imagen</th>
                                        <th class="p-2">Cantidad</th>
                                        <th class="p-2">Precio</th>
                                        <th class="p-2">Comentario</th>
                                        <th class="p-2">Subtotal</th>
                                        <th class="p-2">Proveedor</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pedido->productos as $producto)
                                        <tr class="border-t">
                                            <td class="p-2">{{ $producto->nombre }}</td>
                                            <td class="p-2">
                                                @if ($producto->imagenes->first())
                                                    <img src="{{ asset('storage/' . $producto->imagenes->first()->ruta) }}"
                                                        class="w-16 h-16 rounded object-cover">
                                                @endif
                                            </td>

                                            <td class="p-2">{{ $producto->pivot->cantidad }}</td>
                                            <td class="p-2">L
                                                {{ number_format($producto->pivot->precio_unitario, 2) }}</td>
                                            <td>{{ $producto->pivot->comentario ?? '-' }}</td>
                                            <td class="p-2">
                                                L
                                                {{ number_format($producto->pivot->precio_unitario * $producto->pivot->cantidad, 2) }}
                                            </td>
                                            <td class="p-2">
                                                @if ($producto->link_compra)
                                                    <a href="{{ $producto->link_compra }}" target="_blank"
                                                        class="text-blue-600 hover:underline text-sm">
                                                        Ver en proveedor
                                                    </a>
                                                @else
                                                    <span class="text-gray-400">No disponible</span>
                                                @endif
                                            </td>

                                        </tr>
                                    @endforeach
                                    <tr class="font-bold bg-white border-t">
                                        <td colspan="4" class="p-2 text-right">Total:</td>
                                        <td class="p-2">L {{ number_format($pedido->total, 2) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-4 text-center text-gray-500">No hay pedidos registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
