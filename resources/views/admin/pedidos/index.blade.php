<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-[#1e40af]">Gestión de Pedidos</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-2 sm:px-4 bg-[#f9fafb] min-h-screen">

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
                <label class="text-sm font-medium">Estado</label>
                <select name="estado" class="border-gray-300 rounded w-full mt-1">
                    <option value="">Todos</option>
                    <option value="pendiente" @selected(request('estado')=='pendiente')>Pendiente</option>
                    <option value="confirmado" @selected(request('estado')=='confirmado')>Confirmado</option>
                    <option value="entregado" @selected(request('estado')=='entregado')>Entregado</option>
                    <option value="cancelado" @selected(request('estado')=='cancelado')>Cancelado</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit"
                    class="bg-[#1e40af] text-white px-4 py-2 rounded hover:bg-blue-800">Filtrar</button>
                <a href="{{ route('admin.pedidos.index') }}"
                    class="bg-[#facc15] text-[#1e40af] px-4 py-2 rounded hover:bg-yellow-400 font-semibold">Limpiar</a>
            </div>
        </form>

        @if (session('success'))
            <div class="mb-4 text-green-600">{{ session('success') }}</div>
        @endif

        <!-- Desktop Table -->
        <div class="hidden md:block">
            <table class="w-full text-sm text-left border mb-6 bg-white rounded shadow overflow-hidden">
                <thead class="bg-[#facc15] text-[#1e40af]">
                    <tr>
                        <th class="p-2">#</th>
                        <th class="p-2">Cliente</th>
                        <th class="p-2">Fecha</th>
                        <th class="p-2">Estado</th>
                        <th class="p-2">Total</th>
                        <th class="p-2">Entrega Estimada</th>
                        <th class="p-2">Comprobante</th>
                        <th class="p-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pedidos as $pedido)
                        <tr class="border-t bg-white hover:bg-[#f9fafb] transition">
                            <td class="p-2 font-bold">{{ $pedido->id }}</td>
                            <td class="p-2">{{ $pedido->user->name }}</td>
                            <td class="p-2">{{ $pedido->created_at->format('d/m/Y') }}</td>
                            <td class="p-2">
                                <span class="px-2 py-1 rounded text-xs font-semibold
                                    @if($pedido->estado=='pendiente') bg-gray-200 text-gray-700
                                    @elseif($pedido->estado=='confirmado') bg-blue-100 text-blue-700
                                    @elseif($pedido->estado=='entregado') bg-green-100 text-green-700
                                    @elseif($pedido->estado=='cancelado') bg-red-100 text-red-700
                                    @endif
                                ">
                                    {{ ucfirst($pedido->estado) }}
                                </span>
                            </td>
                            <td class="p-2 font-semibold">L {{ number_format($pedido->total, 2) }}</td>
                            <td class="p-2">
                                {{ $pedido->fecha_entrega_estimada ? \Carbon\Carbon::parse($pedido->fecha_entrega_estimada)->format('d/m/Y') : '-' }}
                            </td>
                            <td class="p-2">
                                @if ($pedido->comprobante)
                                    <a href="{{ asset('storage/' . $pedido->comprobante) }}" target="_blank"
                                        class="text-[#1e40af] hover:underline text-sm">Descargar</a>
                                @else
                                    <span class="text-gray-400 text-sm">No enviado</span>
                                @endif
                            </td>
                            <td class="p-2 flex gap-2">
                                <a href="{{ route('admin.pedidos.edit', $pedido) }}"
                                    class="bg-[#1e40af] text-white px-2 py-1 rounded text-xs hover:bg-blue-800">Editar</a>
                                <button type="button" onclick="toggleDetalle({{ $pedido->id }})"
                                    class="bg-[#facc15] text-[#1e40af] px-2 py-1 rounded text-xs font-semibold hover:bg-yellow-400">Ver Detalle</button>
                                {{-- Acciones extra: cambiar estado, subir comprobante, eliminar --}}
                            </td>
                        </tr>
                        <tr id="detalle-{{ $pedido->id }}" class="hidden bg-[#f9fafb] text-sm text-gray-700">
                            <td colspan="8" class="px-6 py-4">
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
                                                <td class="p-2">L {{ number_format($producto->pivot->precio_unitario, 2) }}</td>
                                                <td class="p-2">{{ $producto->pivot->comentario ?? '-' }}</td>
                                                <td class="p-2">
                                                    L {{ number_format($producto->pivot->precio_unitario * $producto->pivot->cantidad, 2) }}
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
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-4 text-center text-gray-500">No hay pedidos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Cards -->
        <div class="md:hidden flex flex-col gap-4">
            @forelse ($pedidos as $pedido)
                <div class="bg-white rounded shadow p-4">
                    <div class="flex justify-between items-center mb-2">
                        <div class="font-bold text-lg text-[#1e40af]">#{{ $pedido->id }}</div>
                        <span class="px-2 py-1 rounded text-xs font-semibold
                            @if($pedido->estado=='pendiente') bg-gray-200 text-gray-700
                            @elseif($pedido->estado=='confirmado') bg-blue-100 text-blue-700
                            @elseif($pedido->estado=='entregado') bg-green-100 text-green-700
                            @elseif($pedido->estado=='cancelado') bg-red-100 text-red-700
                            @endif
                        ">
                            {{ ucfirst($pedido->estado) }}
                        </span>
                    </div>
                    <div class="text-sm mb-1"><span class="font-semibold">Cliente:</span> {{ $pedido->user->name }}</div>
                    <div class="text-sm mb-1"><span class="font-semibold">Fecha:</span> {{ $pedido->created_at->format('d/m/Y') }}</div>
                    <div class="text-sm mb-1"><span class="font-semibold">Total:</span> L {{ number_format($pedido->total, 2) }}</div>
                    <div class="text-sm mb-1"><span class="font-semibold">Entrega Estimada:</span>
                        {{ $pedido->fecha_entrega_estimada ? \Carbon\Carbon::parse($pedido->fecha_entrega_estimada)->format('d/m/Y') : '-' }}
                    </div>
                    <div class="text-sm mb-1"><span class="font-semibold">Comprobante:</span>
                        @if ($pedido->comprobante)
                            <a href="{{ asset('storage/' . $pedido->comprobante) }}" target="_blank"
                                class="text-[#1e40af] hover:underline text-sm">Descargar</a>
                        @else
                            <span class="text-gray-400 text-sm">No enviado</span>
                        @endif
                    </div>
                    <div class="flex gap-2 mt-2">
                        <a href="{{ route('admin.pedidos.edit', $pedido) }}"
                            class="bg-[#1e40af] text-white px-2 py-1 rounded text-xs hover:bg-blue-800">Editar</a>
                        <button type="button" onclick="toggleDetalle({{ $pedido->id }})"
                            class="bg-[#facc15] text-[#1e40af] px-2 py-1 rounded text-xs font-semibold hover:bg-yellow-400">Ver Detalle</button>
                    </div>
                    <div id="detalle-{{ $pedido->id }}" class="hidden mt-3">
                        <div class="font-semibold mb-2">🛒 Detalle del Pedido:</div>
                        <div class="overflow-x-auto">
                            <table class="w-full border text-xs">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="p-1">Producto</th>
                                        <th class="p-1">Img</th>
                                        <th class="p-1">Cant</th>
                                        <th class="p-1">Precio</th>
                                        <th class="p-1">Comentario</th>
                                        <th class="p-1">Subtotal</th>
                                        <th class="p-1">Proveedor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pedido->productos as $producto)
                                        <tr class="border-t">
                                            <td class="p-1">{{ $producto->nombre }}</td>
                                            <td class="p-1">
                                                @if ($producto->imagenes->first())
                                                    <img src="{{ asset('storage/' . $producto->imagenes->first()->ruta) }}"
                                                        class="w-10 h-10 rounded object-cover">
                                                @endif
                                            </td>
                                            <td class="p-1">{{ $producto->pivot->cantidad }}</td>
                                            <td class="p-1">L {{ number_format($producto->pivot->precio_unitario, 2) }}</td>
                                            <td class="p-1">{{ $producto->pivot->comentario ?? '-' }}</td>
                                            <td class="p-1">
                                                L {{ number_format($producto->pivot->precio_unitario * $producto->pivot->cantidad, 2) }}
                                            </td>
                                            <td class="p-1">
                                                @if ($producto->link_compra)
                                                    <a href="{{ $producto->link_compra }}" target="_blank"
                                                        class="text-blue-600 hover:underline text-xs">
                                                        Proveedor
                                                    </a>
                                                @else
                                                    <span class="text-gray-400">No disp.</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded shadow p-4 text-center text-gray-500">No hay pedidos registrados.</div>
            @endforelse
        </div>
    </div>

    <script>
        function toggleDetalle(id) {
            const row = document.getElementById('detalle-' + id);
            if (row) {
                row.classList.toggle('hidden');
            }
        }
    </script>
</x-app-layout>
