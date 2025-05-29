<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3 mb-2">
            <span class="text-3xl">✏️</span>
            <h2 class="text-2xl font-bold text-[#1e40af]">
                Editar Pedido #{{ $pedido->id }}
            </h2>
        </div>
        <div class="border-b border-gray-200 mt-2"></div>
    </x-slot>

    <div class="max-w-5xl mx-auto py-8 px-4">
        {{-- Historial de Abonos --}}
        @if ($pedido->pagos->count())
            <section class="mb-8">
                <h3 class="font-semibold text-lg text-[#1e40af] mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#1e40af]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8v4l3 3"></path><circle cx="12" cy="12" r="10"></circle></svg>
                    Historial de Abonos
                </h3>
                <div class="overflow-x-auto rounded shadow">
                    <table class="min-w-full bg-white text-sm rounded">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="p-3 text-left font-semibold">Fecha</th>
                                <th class="p-3 text-left font-semibold">Monto</th>
                                <th class="p-3 text-left font-semibold">Estado</th>
                                <th class="p-3 text-left font-semibold">Comprobante</th>
                                <th class="p-3 text-left font-semibold">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pedido->pagos as $pago)
                                <tr class="@if($loop->even) even:bg-gray-50 @endif hover:bg-gray-100 border-b last:border-b-0">
                                    <td class="p-3 whitespace-nowrap">{{ $pago->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="p-3 whitespace-nowrap">L {{ number_format($pago->monto, 2) }}</td>
                                    <td class="p-3 whitespace-nowrap">
                                        @if ($pago->confirmado)
                                            <span class="inline-flex items-center gap-1 text-green-700 font-semibold">
                                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"></path></svg>
                                                Confirmado
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 text-yellow-700 font-semibold">
                                                <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><path d="M12 8v4l2 2"></path></svg>
                                                Pendiente
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-3 whitespace-nowrap">
                                        <a href="{{ asset('storage/' . $pago->comprobante) }}" target="_blank"
                                            class="inline-flex items-center gap-1 text-blue-600 hover:underline">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M13 5l7 7-7 7M5 5v14"></path></svg>
                                            Ver
                                        </a>
                                    </td>
                                    <td class="p-3 whitespace-nowrap">
                                        @if (!$pago->confirmado)
                                            <form action="{{ route('pagos.confirmar', $pago) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button
                                                    class="inline-flex items-center gap-1 text-white bg-green-600 hover:bg-green-700 px-3 py-1 rounded text-sm shadow transition">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"></path></svg>
                                                    Confirmar
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-gray-400">—</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        @endif

        {{-- Formulario de Edición --}}
        <section>
            <form action="{{ route('admin.pedidos.update', $pedido) }}" method="POST" class="bg-white p-6 rounded shadow-lg max-w-xl mx-auto">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label class="block font-semibold text-gray-700 mb-2">Estado del Pedido</label>
                    <select name="estado" class="w-full border-gray-300 rounded mt-1 focus:ring-[#1e40af] focus:border-[#1e40af]">
                        <option value="pendiente" {{ $pedido->estado === 'pendiente' ? 'selected' : '' }}>
                            Pendiente
                        </option>
                        <option value="confirmado" {{ $pedido->estado === 'confirmado' ? 'selected' : '' }}>
                            Confirmado
                        </option>
                        <option value="entregado" {{ $pedido->estado === 'entregado' ? 'selected' : '' }}>
                            Entregado
                        </option>
                        <option value="cancelado" {{ $pedido->estado === 'cancelado' ? 'selected' : '' }}>
                            Cancelado
                        </option>
                    </select>
                </div>

                <div class="mb-6">
                    <label class="block font-semibold text-gray-700 mb-2">Fecha estimada de entrega</label>
                    <input type="date" name="fecha_entrega_estimada" value="{{ $pedido->fecha_entrega_estimada }}"
                        class="w-full border-gray-300 rounded mt-1 focus:ring-[#1e40af] focus:border-[#1e40af]">
                </div>

                <div class="text-right">
                    <button type="submit"
                        class="bg-[#1e40af] hover:bg-blue-800 text-white px-5 py-2 rounded shadow font-semibold transition">
                        Guardar cambios
                    </button>
                </div>
            </form>
        </section>
    </div>
</x-app-layout>
