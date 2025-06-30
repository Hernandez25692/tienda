<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl sm:text-2xl font-extrabold text-indigo-800 tracking-tight">Dashboard</h2>
                <p class="text-sm sm:text-base text-gray-500 mt-1">Resumen y estadísticas de tu cuenta</p>
            </div>
            <div class="hidden sm:block">
                <span
                    class="inline-flex items-center px-3 py-1 rounded-full bg-indigo-100 text-indigo-700 text-xs font-semibold">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z" />
                    </svg>
                    {{ ucfirst(auth()->user()->role) }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-4 px-2 sm:py-8 sm:px-4 max-w-full sm:max-w-7xl mx-auto">
        @if (auth()->user()->role === 'admin')
            {{-- ADMIN DASHBOARD --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-8">
                <div class="bg-white p-4 sm:p-6 rounded shadow text-center">
                    <div class="text-xs sm:text-sm text-gray-500">Pedidos totales</div>
                    <div class="text-2xl sm:text-3xl font-bold text-indigo-700">{{ $totalPedidos }}</div>
                </div>
                <div class="bg-white p-4 sm:p-6 rounded shadow text-center">
                    <div class="text-xs sm:text-sm text-gray-500">Pendientes</div>
                    <div class="text-2xl sm:text-3xl font-bold text-yellow-500">{{ $pendientes }}</div>
                </div>
                <div class="bg-white p-4 sm:p-6 rounded shadow text-center">
                    <div class="text-xs sm:text-sm text-gray-500">Entregados</div>
                    <div class="text-2xl sm:text-3xl font-bold text-green-600">{{ $entregados }}</div>
                </div>
                <div class="bg-white p-4 sm:p-6 rounded shadow text-center">
                    <div class="text-xs sm:text-sm text-gray-500">Ingresos (L)</div>
                    <div class="text-2xl sm:text-3xl font-bold text-blue-600">L {{ number_format($totalIngresos, 2) }}
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6 mb-6 sm:mb-8">
                <div class="bg-white p-4 sm:p-6 rounded shadow text-center">
                    <div class="text-xs sm:text-sm text-gray-500">Clientes Registrados</div>
                    <div class="text-2xl sm:text-3xl font-bold text-pink-600">{{ $clientesHoy }}</div>
                </div>
                <div class="bg-white p-4 sm:p-6 rounded shadow text-center">
                    <div class="text-xs sm:text-sm text-gray-500">Pedidos hoy</div>
                    <div class="text-2xl sm:text-3xl font-bold text-amber-600">{{ $pedidosHoy }}</div>
                </div>
                <div class="bg-white p-4 sm:p-6 rounded shadow text-center">
                    <div class="text-xs sm:text-sm text-gray-500">Promedio pedidos diarios</div>
                    <div class="text-2xl sm:text-3xl font-bold text-gray-700">{{ $promedioPedidosDiarios }}</div>
                </div>
            </div>

            <div class="bg-white p-4 sm:p-6 rounded shadow mb-6 sm:mb-8">
                <h3 class="text-base sm:text-lg font-semibold text-gray-800 mb-3 sm:mb-4">Ingresos últimos 6 meses</h3>
                <div class="overflow-x-auto">
                    <canvas id="ingresosChart" height="100"></canvas>
                </div>
            </div>

            @if ($productoTop)
                <div
                    class="bg-white p-4 sm:p-6 rounded shadow flex flex-col sm:flex-row items-center gap-4 sm:gap-6 mb-6 sm:mb-8">
                    <img src="{{ $productoTop->imagenes->first() ? asset('storage/' . $productoTop->imagenes->first()->ruta) : 'https://via.placeholder.com/100' }}"
                        class="w-16 h-16 sm:w-20 sm:h-20 object-cover rounded border">
                    <div class="text-center sm:text-left">
                        <div class="text-xs sm:text-sm text-gray-500">Producto más vendido</div>
                        <div class="text-base sm:text-lg font-bold text-indigo-800">{{ $productoTop->nombre }}</div>
                        <div class="text-xs sm:text-sm text-gray-600">Vendidos: {{ $productoTop->total_vendidos }}
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white p-4 sm:p-6 rounded shadow">
                <h3 class="text-base sm:text-lg font-bold text-gray-800 mb-3 sm:mb-4">Últimos pedidos</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-[600px] w-full text-xs sm:text-sm">
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
                                        <span
                                            class="px-2 py-1 rounded text-xs font-semibold
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
                                            class="text-xs sm:text-sm text-blue-600 hover:underline">Ver</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            {{-- CLIENTE DASHBOARD --}}
            <div
                class="bg-gradient-to-r from-indigo-50 to-white p-4 sm:p-6 rounded-xl shadow mb-6 sm:mb-8 flex flex-col sm:flex-row items-center gap-3 sm:gap-4">
                <div class="bg-indigo-100 rounded-full p-2 sm:p-3 mb-2 sm:mb-0">
                    <svg class="w-7 h-7 sm:w-8 sm:h-8 text-indigo-600" fill="none" stroke="currentColor"
                        stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M5.121 17.804A13.937 13.937 0 0112 15c2.485 0 4.797.607 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div class="text-center sm:text-left">
                    <h3 class="text-xl sm:text-2xl font-bold text-gray-800 mb-1">¡Hola, {{ auth()->user()->name }}!
                    </h3>
                    <p class="text-gray-600 text-sm sm:text-base">Bienvenido a <span
                            class="font-semibold text-indigo-600">EncargaYa</span>. Consulta tus pedidos recientes y
                        descubre productos recomendados para ti.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 sm:gap-8 md:grid-cols-2 mb-8 sm:mb-10">
                {{-- Tus últimos pedidos --}}
                <div>
                    <div class="flex items-center mb-3 sm:mb-4 gap-2">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-amber-500" fill="none" stroke="currentColor"
                            stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <h4 class="text-base sm:text-lg font-semibold text-gray-700">Tus últimos pedidos</h4>
                    </div>
                    @if ($misPedidos->count())
                        <div class="space-y-3 sm:space-y-4">
                            @foreach ($misPedidos as $pedido)
                                <div
                                    class="bg-white rounded-xl shadow flex flex-col sm:flex-row items-center gap-3 sm:gap-4 p-3 sm:p-4 border hover:shadow-lg transition">
                                    <div class="flex-shrink-0">
                                        <div class="bg-indigo-50 rounded-full p-2 sm:p-3">
                                            <svg class="w-6 h-6 sm:w-7 sm:h-7 text-indigo-500" fill="none"
                                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M9 17v-2a4 4 0 018 0v2M12 7a4 4 0 110 8 4 4 0 010-8z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-1 w-full">
                                        <div
                                            class="flex flex-col sm:flex-row justify-between items-center sm:items-start">
                                            <span
                                                class="font-bold text-indigo-700 text-sm sm:text-base">#{{ $pedido->codigo }}</span>
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
                                            <span
                                                class="inline-flex items-center px-2 sm:px-3 py-1 rounded-full text-xs font-semibold {{ $badge }} mt-2 sm:mt-0">
                                                @if ($icon === 'clock')
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                        stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                @elseif($icon === 'check-circle')
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                        stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M9 12l2 2l4-4m5 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                @elseif($icon === 'badge-check')
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                        stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M9 12l2 2l4-4m-7 8a9 9 0 1118 0 9 9 0 01-18 0z" />
                                                    </svg>
                                                @elseif($icon === 'x-circle')
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                        stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                @endif
                                                {{ ucfirst($pedido->estado) }}
                                            </span>
                                        </div>
                                        <div class="text-xs sm:text-sm text-gray-600 mt-1">
                                            <span class="font-medium">Total:</span> <span
                                                class="text-indigo-700 font-bold">L
                                                {{ number_format($pedido->total, 2) }}</span>
                                            <span class="mx-1 sm:mx-2 text-gray-300">|</span>
                                            <span class="font-medium">Fecha:</span>
                                            {{ $pedido->created_at->format('d/m/Y') }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-white rounded-xl shadow p-4 sm:p-6 text-center text-gray-500">
                            <svg class="w-8 h-8 sm:w-10 sm:h-10 mx-auto mb-2 text-gray-300" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            No tienes pedidos recientes.
                        </div>
                    @endif
                </div>

                {{-- Sugerencias de productos --}}
                <div>
                    <div class="flex items-center mb-3 sm:mb-4 gap-2">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-pink-500" fill="none" stroke="currentColor"
                            stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18M3 12h18M3 17h18" />
                        </svg>
                        <h4 class="text-base sm:text-lg font-semibold text-gray-700">Te puede interesar</h4>
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 sm:gap-4">
                        @foreach ($sugerencias as $producto)
                            <a href="{{ route('productos.show', $producto) }}"
                                class="group bg-white rounded-xl shadow p-3 sm:p-4 flex flex-col items-center hover:shadow-lg transition border hover:border-indigo-300">
                                <div
                                    class="w-20 h-20 sm:w-24 sm:h-24 mb-2 flex items-center justify-center bg-gray-50 rounded-lg overflow-hidden">
                                    <img src="{{ $producto->imagenes->first() ? asset('storage/' . $producto->imagenes->first()->ruta) : 'https://via.placeholder.com/150' }}"
                                        class="object-contain w-full h-full group-hover:scale-105 transition">
                                </div>
                                <div class="text-center w-full">
                                    <div class="text-sm sm:text-base font-semibold text-gray-800 truncate">
                                        {{ $producto->nombre }}</div>
                                    @if ($producto->precio_oferta)
                                        <div class="mt-1">
                                            <span class="text-red-500 font-bold text-xs sm:text-sm">
                                                L {{ number_format($producto->precio_oferta, 2) }}
                                            </span>
                                            <span class="line-through text-[10px] sm:text-xs text-gray-400 ml-1">
                                                L {{ number_format($producto->precio_venta, 2) }}
                                            </span>
                                            <span
                                                class="ml-1 bg-red-100 text-red-600 text-[10px] sm:text-xs px-1.5 py-0.5 rounded-full font-semibold uppercase">
                                                Oferta
                                            </span>
                                        </div>
                                    @else
                                        <div class="text-yellow-600 font-bold text-xs sm:text-sm mt-1">
                                            L {{ number_format($producto->precio_venta, 2) }}
                                        </div>
                                    @endif

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
                        responsive: true,
                        maintainAspectRatio: false,
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
