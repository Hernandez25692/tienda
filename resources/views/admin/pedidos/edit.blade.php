<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800">
            Editar Pedido #{{ $pedido->id }}
        </h2>
    </x-slot>
    @if ($pedido->comprobante)
        <div class="mb-4">
            <label class="block font-semibold text-gray-700">Comprobante de pago:</label>
            <a href="{{ asset('storage/' . $pedido->comprobante) }}" target="_blank"
                class="text-blue-600 hover:underline">Ver archivo</a>
        </div>
    @endif

    <div class="max-w-5xl mx-auto py-6 px-4">
        <form action="{{ route('admin.pedidos.update', $pedido) }}" method="POST" class="bg-white p-6 rounded shadow">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block font-semibold text-gray-700">Estado del Pedido</label>
                <select name="estado" class="w-full border-gray-300 rounded mt-1">
                    <option value="pendiente" {{ $pedido->estado === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="confirmado" {{ $pedido->estado === 'confirmado' ? 'selected' : '' }}>Confirmado
                    </option>
                    <option value="entregado" {{ $pedido->estado === 'entregado' ? 'selected' : '' }}>Entregado</option>
                    <option value="cancelado" {{ $pedido->estado === 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block font-semibold text-gray-700">Fecha estimada de entrega</label>
                <input type="date" name="fecha_entrega_estimada" value="{{ $pedido->fecha_entrega_estimada }}"
                    class="w-full border-gray-300 rounded mt-1">
            </div>

            <div class="text-right">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
                    Guardar cambios
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
