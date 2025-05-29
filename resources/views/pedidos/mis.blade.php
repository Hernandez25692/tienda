<x-app-layout>
    <x-slot name="header">
        <div class="bg-gray-50 py-6 px-4 rounded-b-xl shadow-sm">
            <h2 class="text-2xl font-bold text-[#1e40af] flex items-center gap-2">
                📦 Mis Pedidos
            </h2>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto py-8 px-2 sm:px-4 bg-gray-50 min-h-screen">
        @forelse ($pedidos as $pedido)
            @php
                $isCancelado = $pedido->estado === 'cancelado';
                $isEntregado = $pedido->estado === 'entregado';
                $estadoColors = [
                    'pendiente' => 'bg-yellow-100 text-yellow-700 border-yellow-300',
                    'confirmado' => 'bg-blue-100 text-blue-700 border-blue-300',
                    'entregado' => 'bg-green-100 text-green-700 border-green-300',
                    'cancelado' => 'bg-red-100 text-red-700 border-red-300',
                ];
                $estadoIconos = [
                    'pendiente' => '⏳',
                    'confirmado' => '🔒',
                    'entregado' => '✅',
                    'cancelado' => '⚠️',
                ];
                $totalConfirmado = $pedido->pagos->where('confirmado', true)->sum('monto');
                $saldoRestante = $pedido->total - $totalConfirmado;
                $pagoSugerido = $totalConfirmado == 0 ? $pedido->total / 2 : $saldoRestante;
            @endphp
            <div class="bg-white rounded-xl shadow-md mb-8 p-4 sm:p-6 border border-gray-100">
                {{-- Encabezado del pedido --}}
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2 mb-4 border-b pb-3">
                    <div>
                        <p class="text-lg font-semibold flex items-center gap-2 {{ $isCancelado ? 'text-red-700 line-through' : 'text-gray-800' }}">
                            <span class="ml-2 text-base font-normal text-gray-500">Pedido</span>
                            <span class="text-indigo-700">#{{ $pedido->codigo }}</span>
                            
                        </p>
                        <div class="flex flex-wrap gap-3 mt-2 text-sm text-gray-600">
                            <span class="flex items-center gap-1">
                                📅 <span>Fecha de Pedido: {{ $pedido->created_at->format('d/m/Y') }}</span>
                            </span>
                            @if ($pedido->fecha_entrega_estimada)
                                <span class="flex items-center gap-1">
                                    📅 <span>Entrega estimada: {{ \Carbon\Carbon::parse($pedido->fecha_entrega_estimada)->format('d/m/Y') }}</span>
                                </span>
                            @endif
                        </div>
                    </div>
                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full border text-sm font-medium {{ $estadoColors[$pedido->estado] ?? 'bg-gray-100 text-gray-700 border-gray-200' }}">
                        {{ $estadoIconos[$pedido->estado] ?? '' }}
                        {{ ucfirst($pedido->estado) }}
                    </span>
                </div>

                {{-- Tabla de productos --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left mb-2">
                        <thead>
                            <tr class="bg-gray-100 text-gray-700">
                                <th class="p-2 font-medium">Producto</th>
                                <th class="p-2 font-medium">Imagen</th>
                                <th class="p-2 font-medium">Precio</th>
                                <th class="p-2 font-medium">Cantidad</th>
                                <th class="p-2 font-medium">Subtotal</th>
                                <th class="p-2 font-medium">Comentario</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pedido->productos as $producto)
                                <tr class="border-b last:border-b-0 {{ $isCancelado ? 'line-through text-red-700' : '' }}">
                                    <td class="p-2">{{ $producto->nombre }}</td>
                                    <td class="p-2">
                                        @if ($producto->imagenes->first())
                                            <img src="{{ asset('storage/' . $producto->imagenes->first()->ruta) }}"
                                                class="w-14 h-14 rounded object-cover border border-gray-200 shadow-sm" alt="Imagen producto">
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="p-2">L {{ number_format($producto->pivot->precio_unitario, 2) }}</td>
                                    <td class="p-2">{{ $producto->pivot->cantidad }}</td>
                                    <td class="p-2">L {{ number_format($producto->pivot->cantidad * $producto->pivot->precio_unitario, 2) }}</td>
                                    <td class="p-2">{{ $producto->pivot->comentario ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="bg-gray-50 font-semibold">
                                <td colspan="4" class="p-2 text-right">Total del pedido:</td>
                                <td class="p-2 text-indigo-700">L {{ number_format($pedido->total, 2) }}</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                {{-- Resumen de abonos --}}
                <div class="bg-gray-50 rounded p-4 mt-4 mb-2 flex flex-col sm:flex-row sm:items-center gap-3 text-sm font-semibold">
                    <div class="flex-1 flex flex-col gap-1">
                        <span class="flex items-center gap-1">💰 Total del pedido: <span class="text-gray-800">L {{ number_format($pedido->total, 2) }}</span></span>
                        <span class="flex items-center gap-1">✅ Total abonado confirmado: <span class="text-green-700">L {{ number_format($totalConfirmado, 2) }}</span></span>
                        <span class="flex items-center gap-1">🔴 Saldo pendiente: <span class="text-red-600">L {{ number_format($saldoRestante, 2) }}</span></span>
                    </div>
                </div>

                {{-- Formulario de abono --}}
                @if ($pedido->estado === 'pendiente')
                    <div class="bg-yellow-50 border border-yellow-300 p-4 rounded-lg mt-2 mb-2">
                        <p class="font-medium mb-2 flex items-center gap-2">💡 Sugerencia: Abone al menos <span class="text-yellow-800 font-bold">L {{ number_format($pagoSugerido, 2) }}</span></p>
                        <form action="{{ route('pagos.store', $pedido) }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-3">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Monto a abonar:</label>
                                <input type="number" name="monto" step="0.01" min="1" required
                                    class="w-full rounded border-gray-300 focus:ring-blue-500 focus:border-blue-500 p-2 text-base">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Comprobante (PDF, JPG, PNG):</label>
                                <input type="file" name="comprobante" accept=".jpg,.jpeg,.png,.pdf" required
                                    class="w-full text-sm text-gray-600">
                            </div>
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white text-base px-4 py-2 rounded shadow font-semibold transition">
                                📤 Enviar abono
                            </button>
                        </form>
                    </div>
                @endif

                {{-- Historial de pagos --}}
                @if ($pedido->pagos->count())
                    <div class="mt-4">
                        <h3 class="font-semibold text-gray-800 mb-2 flex items-center gap-2">🧾 Historial de pagos</h3>
                        <ul class="text-sm text-gray-700 space-y-3">
                            @foreach ($pedido->pagos as $pago)
                                <li class="border-b last:border-b-0 pb-2 flex flex-col sm:flex-row sm:items-center sm:gap-6">
                                    <span class="flex items-center gap-1">💵 <strong>L {{ number_format($pago->monto, 2) }}</strong></span>
                                    <span class="flex items-center gap-1 mt-1 sm:mt-0">
                                        @if ($pago->confirmado)
                                            <span class="text-green-600 font-semibold">✔ Confirmado</span>
                                        @else
                                            <span class="text-yellow-600 font-semibold">⏳ En revisión</span>
                                        @endif
                                    </span>
                                    <a href="{{ asset('storage/' . $pago->comprobante) }}" target="_blank"
                                        class="text-blue-600 underline mt-1 sm:mt-0 flex items-center gap-1">
                                        📄 Ver comprobante
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        @empty
            <p class="text-gray-600 text-center mt-12">No tienes pedidos aún.</p>
        @endforelse
    </div>
</x-app-layout>
