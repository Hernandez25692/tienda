<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl md:text-3xl font-bold text-[#1e40af] flex items-center gap-2">
            <span class="text-3xl">📋</span> Gestión de Pedidos
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-2 sm:px-4 bg-[#f9fafb] min-h-screen">

        <!-- Filtros -->
        <form method="GET" class="mb-8 bg-white rounded-xl shadow flex flex-wrap gap-6 items-end px-6 py-4">
            <div class="flex flex-col w-full sm:w-48">
                <label class="text-xs font-semibold text-[#1e40af] mb-1">Cliente</label>
                <input type="text" name="cliente" value="{{ request('cliente') }}"
                    class="border-gray-300 rounded-lg w-full text-sm px-3 py-2 focus:ring-[#1e40af] focus:border-[#1e40af]">
            </div>
            <div class="flex flex-col w-full sm:w-40">
                <label class="text-xs font-semibold text-[#1e40af] mb-1">Fecha Desde</label>
                <input type="date" name="desde" value="{{ request('desde') }}"
                    class="border-gray-300 rounded-lg w-full text-sm px-3 py-2 focus:ring-[#1e40af] focus:border-[#1e40af]">
            </div>
            <div class="flex flex-col w-full sm:w-40">
                <label class="text-xs font-semibold text-[#1e40af] mb-1">Fecha Hasta</label>
                <input type="date" name="hasta" value="{{ request('hasta') }}"
                    class="border-gray-300 rounded-lg w-full text-sm px-3 py-2 focus:ring-[#1e40af] focus:border-[#1e40af]">
            </div>
            <div class="flex flex-col w-full sm:w-40">
                <label class="text-xs font-semibold text-[#1e40af] mb-1">Estado</label>
                <select name="estado" class="border-gray-300 rounded-lg w-full text-sm px-3 py-2 focus:ring-[#1e40af] focus:border-[#1e40af]">
                    <option value="">Todos</option>
                    <option value="pendiente" @selected(request('estado') == 'pendiente')>Pendiente</option>
                    <option value="confirmado" @selected(request('estado') == 'confirmado')>Confirmado</option>
                    <option value="entregado" @selected(request('estado') == 'entregado')>Entregado</option>
                    <option value="cancelado" @selected(request('estado') == 'cancelado')>Cancelado</option>
                </select>
            </div>
            <div class="flex gap-2 mt-4 sm:mt-0">
                <button type="submit"
                    class="bg-[#1e40af] text-white px-5 py-2 rounded-lg font-semibold hover:bg-blue-800 shadow transition">Filtrar</button>
                <a href="{{ route('admin.pedidos.index') }}"
                    class="bg-[#facc15] text-[#1e40af] px-5 py-2 rounded-lg font-semibold hover:bg-yellow-400 shadow transition">Limpiar</a>
            </div>
        </form>

        @if (session('success'))
            <div class="mb-4 text-green-600 font-semibold">{{ session('success') }}</div>
        @endif

        <!-- Desktop Table -->
        <div class="hidden md:block">
            <table class="w-full text-sm text-left border-separate border-spacing-0 mb-8 bg-white rounded-xl shadow overflow-hidden">
                <thead class="bg-[#facc15] text-[#1e40af]">
                    <tr>
                        <th class="p-3 font-semibold">#</th>
                        <th class="p-3 font-semibold">Código</th>
                        <th class="p-3 font-semibold">Cliente</th>
                        <th class="p-3 font-semibold">Fecha</th>
                        <th class="p-3 font-semibold">Estado</th>
                        <th class="p-3 font-semibold">Pagos</th>
                        <th class="p-3 font-semibold">Entrega</th>
                        <th class="p-3 font-semibold">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pedidos as $pedido)
                        <tr class="border-t bg-white hover:bg-[#e0e7ff] transition rounded-xl">
                            <td class="p-3 font-bold text-[#1e40af]">{{ $pedido->id }}</td>
                            <td class="p-3">
                                <span class="inline-block bg-[#1e40af] text-white px-3 py-1 rounded-full text-xs font-bold shadow-sm tracking-wide">
                                    🧾 {{ $pedido->codigo }}
                                </span>
                            </td>
                            <td class="p-3">{{ $pedido->user->name }}</td>
                            <td class="p-3 flex items-center gap-1">
                                <span class="text-[#1e40af] text-lg">📅</span>
                                {{ $pedido->created_at->format('d/m/Y') }}
                            </td>
                            <td class="p-3">
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                                    @if ($pedido->estado == 'pendiente') bg-gray-200 text-gray-700
                                    @elseif($pedido->estado == 'confirmado') bg-blue-100 text-blue-700
                                    @elseif($pedido->estado == 'entregado') bg-green-100 text-green-700
                                    @elseif($pedido->estado == 'cancelado') bg-red-100 text-red-700 @endif
                                ">
                                    @if($pedido->estado == 'pendiente')⏳@elseif($pedido->estado == 'confirmado')✅@elseif($pedido->estado == 'entregado')📦@elseif($pedido->estado == 'cancelado')⛔@endif
                                    {{ ucfirst($pedido->estado) }}
                                </span>
                            </td>
                            @php
                                $abonado = $pedido->pagos->where('confirmado', true)->sum('monto');
                                $saldo = $pedido->total - $abonado;
                            @endphp
                            <td class="p-3 font-semibold">
                                <div class="text-[#1e40af] text-xs flex items-center gap-1">
                                    <span class="font-bold">Total:</span> L {{ number_format($pedido->total, 2) }}
                                </div>
                                <div class="text-green-600 text-xs flex items-center gap-1">
                                    <span class="font-bold">Abonado:</span> L {{ number_format($abonado, 2) }}
                                </div>
                                <div class="text-red-600 text-xs flex items-center gap-1">
                                    <span class="font-bold">Pendiente:</span> L {{ number_format($saldo, 2) }}
                                </div>
                            </td>
                            <td class="p-3">
                                {{ $pedido->fecha_entrega_estimada ? '📦 ' . \Carbon\Carbon::parse($pedido->fecha_entrega_estimada)->format('d/m/Y') : '-' }}
                            </td>
                            <td class="p-3">
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.pedidos.edit', $pedido) }}"
                                        class="bg-[#1e40af] text-white px-3 py-1 rounded-lg text-xs font-semibold hover:bg-blue-800 shadow transition focus:outline-none focus:ring-2 focus:ring-[#1e40af]">Editar</a>
                                    <button type="button" onclick="toggleDetalle({{ $pedido->id }})"
                                        class="bg-[#facc15] text-[#1e40af] px-3 py-1 rounded-lg text-xs font-semibold hover:bg-yellow-400 shadow transition focus:outline-none focus:ring-2 focus:ring-[#facc15]">Ver Detalle</button>
                                </div>
                            </td>
                        </tr>
                        <tr id="detalle-{{ $pedido->id }}" class="hidden bg-[#f1f5f9] text-sm text-gray-700">
                            <td colspan="8" class="px-8 py-5 rounded-b-xl">
                                <div class="font-semibold mb-3 flex items-center gap-2 text-[#1e40af]">
                                    🛒 Detalle del Pedido:
                                </div>
                                <div class="overflow-x-auto">
                                    <table class="w-full border rounded-xl bg-white shadow">
                                        <thead class="bg-gray-100">
                                            <tr>
                                                <th class="p-2 font-semibold">Producto</th>
                                                <th class="p-2 font-semibold">Imagen</th>
                                                <th class="p-2 font-semibold">Cantidad</th>
                                                <th class="p-2 font-semibold">Precio</th>
                                                <th class="p-2 font-semibold">Comentario</th>
                                                <th class="p-2 font-semibold">Subtotal</th>
                                                <th class="p-2 font-semibold">Proveedor</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pedido->productos as $producto)
                                                <tr class="border-t">
                                                    <td class="p-2">{{ $producto->nombre }}</td>
                                                    <td class="p-2">
                                                        @if ($producto->imagenes->first())
                                                            <img src="{{ asset('storage/' . $producto->imagenes->first()->ruta) }}"
                                                                class="w-14 h-14 rounded-xl object-cover border shadow">
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
                                                                class="text-blue-600 hover:underline text-xs flex items-center gap-1">
                                                                🌐 Proveedor
                                                            </a>
                                                        @else
                                                            <span class="text-gray-400">No disponible</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-6 text-center text-gray-500">No hay pedidos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Cards -->
        <div class="md:hidden flex flex-col gap-4">
            @forelse ($pedidos as $pedido)
                @php
                    $abonado = $pedido->pagos->where('confirmado', true)->sum('monto');
                    $saldo = $pedido->total - $abonado;
                @endphp
                <div class="bg-white rounded-xl shadow p-5 flex flex-col gap-2">
                    <div class="flex justify-between items-center mb-2">
                        <div class="font-bold text-lg text-[#1e40af] flex items-center gap-1">
                            #{{ $pedido->id }}
                            <span class="inline-block bg-[#1e40af] text-white px-2 py-0.5 rounded-full text-xs font-bold ml-2 shadow-sm">🧾 {{ $pedido->codigo }}</span>
                        </div>
                        <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                            @if ($pedido->estado == 'pendiente') bg-gray-200 text-gray-700
                            @elseif($pedido->estado == 'confirmado') bg-blue-100 text-blue-700
                            @elseif($pedido->estado == 'entregado') bg-green-100 text-green-700
                            @elseif($pedido->estado == 'cancelado') bg-red-100 text-red-700 @endif
                        ">
                            @if($pedido->estado == 'pendiente')⏳@elseif($pedido->estado == 'confirmado')✅@elseif($pedido->estado == 'entregado')📦@elseif($pedido->estado == 'cancelado')⛔@endif
                            {{ ucfirst($pedido->estado) }}
                        </span>
                    </div>
                    <div class="text-sm mb-1"><span class="font-semibold">👤 Cliente:</span> {{ $pedido->user->name }}</div>
                    <div class="text-sm mb-1 flex items-center gap-1"><span class="font-semibold">📅 Fecha:</span> {{ $pedido->created_at->format('d/m/Y') }}</div>
                    <div class="text-sm mb-1"><span class="font-semibold">💰 Total:</span> L {{ number_format($pedido->total, 2) }}</div>
                    <div class="text-xs mb-1 text-green-600"><span class="font-semibold">✅ Abonado:</span> L {{ number_format($abonado, 2) }}</div>
                    <div class="text-xs mb-1 text-red-600"><span class="font-semibold">⛔ Pendiente:</span> L {{ number_format($saldo, 2) }}</div>
                    <div class="text-sm mb-1"><span class="font-semibold">📦 Entrega:</span> {{ $pedido->fecha_entrega_estimada ? \Carbon\Carbon::parse($pedido->fecha_entrega_estimada)->format('d/m/Y') : '-' }}</div>
                    <div class="flex gap-2 mt-2">
                        <a href="{{ route('admin.pedidos.edit', $pedido) }}"
                            class="bg-[#1e40af] text-white px-3 py-1 rounded-lg text-xs font-semibold hover:bg-blue-800 shadow transition focus:outline-none focus:ring-2 focus:ring-[#1e40af]">Editar</a>
                        <button type="button" onclick="toggleDetalle({{ $pedido->id }})"
                            class="bg-[#facc15] text-[#1e40af] px-3 py-1 rounded-lg text-xs font-semibold hover:bg-yellow-400 shadow transition focus:outline-none focus:ring-2 focus:ring-[#facc15]">Ver Detalle</button>
                    </div>
                    <div id="detalle-{{ $pedido->id }}" class="hidden mt-3">
                        <div class="font-semibold mb-2 flex items-center gap-2 text-[#1e40af]">🛒 Detalle del Pedido:</div>
                        <div class="overflow-x-auto">
                            <table class="w-full border rounded-xl text-xs bg-white shadow">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="p-1 font-semibold">Producto</th>
                                        <th class="p-1 font-semibold">Img</th>
                                        <th class="p-1 font-semibold">Cant</th>
                                        <th class="p-1 font-semibold">Precio</th>
                                        <th class="p-1 font-semibold">Comentario</th>
                                        <th class="p-1 font-semibold">Subtotal</th>
                                        <th class="p-1 font-semibold">Proveedor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pedido->productos as $producto)
                                        <tr class="border-t">
                                            <td class="p-1">{{ $producto->nombre }}</td>
                                            <td class="p-1">
                                                @if ($producto->imagenes->first())
                                                    <img src="{{ asset('storage/' . $producto->imagenes->first()->ruta) }}"
                                                        class="w-10 h-10 rounded-xl object-cover border shadow">
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
                                                        class="text-blue-600 hover:underline text-xs flex items-center gap-1">
                                                        🌐 Proveedor
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
                <div class="bg-white rounded-xl shadow p-6 text-center text-gray-500">No hay pedidos registrados.</div>
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
