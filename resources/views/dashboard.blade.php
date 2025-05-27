<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800">Dashboard</h2>
    </x-slot>

    <div class="py-8 px-4 max-w-7xl mx-auto">
        @if (auth()->user()->role === 'admin')
            {{-- ADMIN DASHBOARD --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white p-6 rounded shadow text-center">
                    <div class="text-sm text-gray-500">Pedidos totales</div>
                    <div class="text-3xl font-bold text-indigo-700">{{ $totalPedidos }}</div>
                </div>
                <div class="bg-white p-6 rounded shadow text-center">
                    <div class="text-sm text-gray-500">Pendientes</div>
                    <div class="text-3xl font-bold text-yellow-500">{{ $pendientes }}</div>
                </div>
                <div class="bg-white p-6 rounded shadow text-center">
                    <div class="text-sm text-gray-500">Entregados</div>
                    <div class="text-3xl font-bold text-green-600">{{ $entregados }}</div>
                </div>
                <div class="bg-white p-6 rounded shadow text-center">
                    <div class="text-sm text-gray-500">Ingresos (L)</div>
                    <div class="text-3xl font-bold text-blue-600">L {{ number_format($totalIngresos, 2) }}</div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded shadow text-center">
                    <div class="text-sm text-gray-500">Clientes Registrados</div>
                    <div class="text-3xl font-bold text-pink-600">{{ $clientesHoy }}</div>
                </div>
                <div class="bg-white p-6 rounded shadow text-center">
                    <div class="text-sm text-gray-500">Pedidos hoy</div>
                    <div class="text-3xl font-bold text-amber-600">{{ $pedidosHoy }}</div>
                </div>
                <div class="bg-white p-6 rounded shadow text-center">
                    <div class="text-sm text-gray-500">Promedio pedidos diarios</div>
                    <div class="text-3xl font-bold text-gray-700">{{ $promedioPedidosDiarios }}</div>
                </div>
            </div>

            <div class="bg-white p-6 rounded shadow mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Ingresos últimos 6 meses</h3>
                <canvas id="ingresosChart" height="100"></canvas>
            </div>

            @if ($productoTop)
                <div class="bg-white p-6 rounded shadow flex items-center gap-6 mb-8">
                    <img src="{{ $productoTop->imagenes->first() ? asset('storage/' . $productoTop->imagenes->first()->ruta) : 'https://via.placeholder.com/100' }}"
                        class="w-20 h-20 object-cover rounded border">
                    <div>
                        <div class="text-sm text-gray-500">Producto más vendido</div>
                        <div class="text-lg font-bold text-indigo-800">{{ $productoTop->nombre }}</div>
                        <div class="text-sm text-gray-600">Vendidos: {{ $productoTop->total_vendidos }}</div>
                    </div>
                </div>
            @endif

            <div class="bg-white p-6 rounded shadow">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Últimos pedidos</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-100 text-gray-600">
                            <tr>
                                <th class="p-2">Código</th>
                                <th class="p-2">Cliente</th>
                                <th class="p-2">Estado</th>
                                <th class="p-2">Fecha</th>
                                <th class="p-2">Total</th>
                                <th class="p-2">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ultimosPedidos as $pedido)
                                <tr class="border-t">
                                    <td class="p-2 font-medium text-indigo-700">{{ $pedido->codigo }}</td>
                                    <td class="p-2">{{ $pedido->user->name }}</td>
                                    <td class="p-2 capitalize">
                                        <span class="px-2 py-1 rounded text-xs font-semibold
                                            @class([
                                                'bg-gray-100 text-gray-800' => $pedido->estado === 'pendiente',
                                                'bg-blue-100 text-blue-700' => $pedido->estado === 'confirmado',
                                                'bg-green-100 text-green-700' => $pedido->estado === 'entregado',
                                                'bg-red-100 text-red-700' => $pedido->estado === 'cancelado',
                                            ])">
                                            {{ $pedido->estado }}
                                        </span>
                                    </td>
                                    <td class="p-2">{{ $pedido->created_at->format('d/m/Y') }}</td>
                                    <td class="p-2">L {{ number_format($pedido->total, 2) }}</td>
                                    <td class="p-2">
                                        <a href="{{ route('admin.pedidos.edit', $pedido) }}"
                                            class="text-sm text-blue-600 hover:underline">Ver</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            {{-- CLIENTE DASHBOARD --}}
            <div class="bg-gradient-to-r from-indigo-50 to-white p-6 rounded-xl shadow mb-8 flex items-center gap-4">
            <div class="bg-indigo-100 rounded-full p-3">
                <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 15c2.485 0 4.797.607 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            <div>
                <h3 class="text-2xl font-bold text-gray-800 mb-1">¡Hola, {{ auth()->user()->name }}!</h3>
                <p class="text-gray-600">Bienvenido a <span class="font-semibold text-indigo-600">EncargaYa</span>. Consulta tus pedidos recientes y descubre productos recomendados para ti.</p>
            </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
            {{-- Tus últimos pedidos --}}
            <div>
                <div class="flex items-center mb-4 gap-2">
                <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <h4 class="text-lg font-semibold text-gray-700">Tus últimos pedidos</h4>
                </div>
                @if ($misPedidos->count())
                <div class="space-y-4">
                    @foreach ($misPedidos as $pedido)
                    <div class="bg-white rounded-xl shadow flex items-center gap-4 p-4 border hover:shadow-lg transition">
                        <div class="flex-shrink-0">
                        <div class="bg-indigo-50 rounded-full p-3">
                            <svg class="w-7 h-7 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2a4 4 0 018 0v2M12 7a4 4 0 110 8 4 4 0 010-8z" />
                            </svg>
                        </div>
                        </div>
                        <div class="flex-1">
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-indigo-700 text-base">#{{ $pedido->codigo }}</span>
                            @php
                            $badge = match ($pedido->estado) {
                                'pendiente' => 'bg-gray-100 text-gray-700',
                                'confirmado' => 'bg-blue-100 text-blue-700',
                                'entregado' => 'bg-green-100 text-green-700',
                                'cancelado' => 'bg-red-100 text-red-700',
                            };
                            $icon = match ($pedido->estado) {
                                'pendiente' => 'clock',
                                'confirmado' => 'check-circle',
                                'entregado' => 'badge-check',
                                'cancelado' => 'x-circle',
                            };
                            @endphp
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $badge }}">
                            @if($icon === 'clock')
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            @elseif($icon === 'check-circle')
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2l4-4m5 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            @elseif($icon === 'badge-check')
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2l4-4m-7 8a9 9 0 1118 0 9 9 0 01-18 0z" />
                                </svg>
                            @elseif($icon === 'x-circle')
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            @endif
                            {{ ucfirst($pedido->estado) }}
                            </span>
                        </div>
                        <div class="text-sm text-gray-600 mt-1">
                            <span class="font-medium">Total:</span> <span class="text-indigo-700 font-bold">L {{ number_format($pedido->total, 2) }}</span>
                            <span class="mx-2 text-gray-300">|</span>
                            <span class="font-medium">Fecha:</span> {{ $pedido->created_at->format('d/m/Y') }}
                        </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="bg-white rounded-xl shadow p-6 text-center text-gray-500">
                    <svg class="w-10 h-10 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    No tienes pedidos recientes.
                </div>
                @endif
            </div>

            {{-- Sugerencias de productos --}}
            <div>
                <div class="flex items-center mb-4 gap-2">
                <svg class="w-6 h-6 text-pink-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18M3 12h18M3 17h18" />
                </svg>
                <h4 class="text-lg font-semibold text-gray-700">Te puede interesar</h4>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                @foreach ($sugerencias as $producto)
                    <a href="{{ route('productos.show', $producto) }}"
                    class="group bg-white rounded-xl shadow p-4 flex flex-col items-center hover:shadow-lg transition border hover:border-indigo-300">
                    <div class="w-24 h-24 mb-2 flex items-center justify-center bg-gray-50 rounded-lg overflow-hidden">
                        <img src="{{ $producto->imagenes->first() ? asset('storage/' . $producto->imagenes->first()->ruta) : 'https://via.placeholder.com/150' }}"
                        class="object-contain w-full h-full group-hover:scale-105 transition">
                    </div>
                    <div class="text-center">
                        <div class="text-base font-semibold text-gray-800 truncate">{{ $producto->nombre }}</div>
                        <div class="text-yellow-600 font-bold text-sm mt-1">L {{ number_format($producto->precio_venta, 2) }}</div>
                    </div>
                    </a>
                @endforeach
                </div>
            </div>
            </div>
        @endif
    </div>

    {{-- Chart.js --}}
    @push('scripts')
        @if (auth()->user()->role === 'admin')
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                const ctx = document.getElementById('ingresosChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($ingresosMensuales->pluck('mes')) !!},
                        datasets: [{
                            label: 'Ingresos (L)',
                            data: {!! json_encode($ingresosMensuales->pluck('total')) !!},
                            backgroundColor: '#4f46e5',
                            borderRadius: 8,
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            </script>
        @endif
    @endpush
</x-app-layout>
