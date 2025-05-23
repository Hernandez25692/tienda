<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800">Clientes</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4">
        @if (session('success'))
            <div class="mb-4 text-green-600 font-semibold">{{ session('success') }}</div>
        @endif

        <div class="mb-4">
            <a href="{{ route('admin.clientes.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">+ Nuevo Cliente</a>
        </div>

        <table class="w-full text-sm text-left border">
            <thead class="bg-gray-100 text-gray-600">
                <tr>
                    <th class="p-2">#</th>
                    <th class="p-2">Nombre</th>
                    <th class="p-2">Correo</th>
                    <th class="p-2">Celular</th>
                    <th class="p-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clientes as $cliente)
                    <tr class="border-t">
                        <td class="p-2">{{ $cliente->id }}</td>
                        <td class="p-2">{{ $cliente->name }}</td>
                        <td class="p-2">{{ $cliente->email }}</td>
                        <td class="p-2">{{ $cliente->celular ?? '-' }}</td>
                        <td class="p-2 flex gap-2">
                            <a href="{{ route('admin.clientes.edit', $cliente) }}"
                                class="text-blue-600 hover:underline text-sm">Editar</a>

                            <form action="{{ route('admin.clientes.destroy', $cliente) }}" method="POST"
                                onsubmit="return confirm('¿Eliminar este cliente?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="text-red-600 hover:underline text-sm">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
