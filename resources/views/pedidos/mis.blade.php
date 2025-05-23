<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800">Mis Pedidos</h2>
    </x-slot>

    <div class="max-w-6xl mx-auto py-6 px-4">
        @forelse ($pedidos as $pedido)
            @php
                $isCancelado = $pedido->estado === 'cancelado';
                $isEntregado = $pedido->estado === 'entregado';
                $estadoColors = [
                    'pendiente' => 'bg-yellow-100 text-yellow-700',
                    'confirmado' => 'bg-blue-100 text-blue-700',
                    'entregado' => 'bg-green-100 text-green-700',
                    'cancelado' => 'bg-red-200 text-red-800',
                ];
            @endphp
            <div class="shadow rounded p-4 mb-6 {{ $isCancelado ? 'bg-red-100' : 'bg-white' }}">
                <div class="flex justify-between items-center mb-3">
                    <div>
                        <p
                            class="text-lg font-semibold {{ $isCancelado ? 'text-red-700 line-through' : 'text-gray-800' }}">
                            Pedido #{{ $pedido->id }}
                        </p>
                        @if (!$isCancelado)
                            <p class="text-sm text-gray-500">Fecha: {{ $pedido->created_at->format('d/m/Y') }}</p>
                        @endif
                    </div>
                    <span
                        class="text-sm px-3 py-1 rounded-full
                        {{ $estadoColors[$pedido->estado] ?? 'bg-gray-100 text-gray-700' }}">
                        {{ ucfirst($pedido->estado) }}
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead>
                            <tr
                                class="{{ $isCancelado ? 'bg-red-200 text-red-800 line-through' : 'bg-gray-100 text-gray-600' }}">
                                <th class="p-2">Producto</th>
                                <th class="p-2">Imagen</th>

                                <th class="p-2">Precio</th>
                                <th class="p-2">Cantidad</th>
                                <th class="p-2">Subtotal</th>
                                <th class="p-2">Comentario</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pedido->productos as $producto)
                                <tr class="border-t {{ $isCancelado ? 'line-through text-red-700' : '' }}">
                                    <td class="p-2">{{ $producto->nombre }}</td>
                                    <td class="p-2">
                                        @if ($producto->imagenes->first())
                                            <img src="{{ asset('storage/' . $producto->imagenes->first()->ruta) }}"
                                                class="w-16 h-16 rounded object-cover">
                                        @endif
                                    </td>

                                    <td class="p-2">L {{ number_format($producto->pivot->precio_unitario, 2) }}</td>
                                    <td class="p-2">{{ $producto->pivot->cantidad }}</td>
                                    <td class="p-2">L
                                        {{ number_format($producto->pivot->cantidad * $producto->pivot->precio_unitario, 2) }}
                                    </td>
                                    <td>{{ $producto->pivot->comentario ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr
                                class="font-bold {{ $isCancelado ? 'bg-red-200 text-red-800 line-through' : 'bg-gray-50' }}">
                                <td colspan="3" class="p-2 text-right">Total:</td>
                                <td class="p-2">L {{ number_format($pedido->total, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                @if ($pedido->estado === 'pendiente' && !$pedido->comprobante)
                    <form action="{{ route('pedidos.subirComprobante', $pedido) }}" method="POST"
                        enctype="multipart/form-data" class="mt-4">
                        @csrf
                        <label class="block text-sm font-medium text-gray-700 mb-1">Subir comprobante de pago (JPG, PNG,
                            PDF):</label>
                        <input type="file" name="comprobante" accept=".jpg,.jpeg,.png,.pdf"
                            class="block w-full mb-2 text-sm text-gray-600">
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded shadow">
                            Subir comprobante
                        </button>
                    </form>
                @elseif ($pedido->comprobante)
                    <a href="{{ asset('storage/' . $pedido->comprobante) }}" target="_blank"
                        class="mt-3 inline-block bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded shadow">
                        Ver comprobante
                    </a>
                @endif

                @if ($pedido->fecha_entrega_estimada && !$isCancelado && !$isEntregado)
                    <p class="mt-3 text-sm text-gray-500">
                        Entrega estimada: {{ \Carbon\Carbon::parse($pedido->fecha_entrega_estimada)->format('d/m/Y') }}
                    </p>
                @endif
            </div>
        @empty
            <p class="text-gray-600">No tienes pedidos aún.</p>
        @endforelse
    </div>
</x-app-layout>
