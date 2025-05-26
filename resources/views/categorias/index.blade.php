<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Categorías</h2>
    </x-slot>

    <div class="max-w-4xl mx-auto mt-6 bg-white p-6 rounded shadow">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-700">Lista de categorías</h3>
            <a href="{{ route('categorias.create') }}"
               class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">
                + Nueva Categoría
            </a>
        </div>

        @if (session('success'))
            <div class="mb-4 text-sm text-green-600 font-medium">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full border text-sm text-left">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2">#</th>
                    <th class="px-4 py-2">Nombre</th>
                    <th class="px-4 py-2 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categorias as $cat)
                    <tr class="border-b">
                        <td class="px-4 py-2">{{ $cat->id }}</td>
                        <td class="px-4 py-2">{{ $cat->nombre }}</td>
                        <td class="px-4 py-2 text-right">
                            <a href="{{ route('categorias.edit', $cat) }}"
                               class="text-blue-600 hover:underline mr-4">Editar</a>
                            <form action="{{ route('categorias.destroy', $cat) }}" method="POST" class="inline"
                                  onsubmit="return confirm('¿Eliminar esta categoría?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-4 py-6 text-center text-gray-500">No hay categorías registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $categorias->links() }}
        </div>
    </div>
</x-app-layout>
