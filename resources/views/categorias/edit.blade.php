<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Editar Categoría</h2>
    </x-slot>

    <div class="max-w-md mx-auto mt-10 bg-white p-6 rounded shadow">
        <form method="POST" action="{{ route('categorias.update', $categoria->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Nombre de categoría</label>
                <input type="text" name="nombre" value="{{ old('nombre', $categoria->nombre) }}" required
                       class="w-full rounded border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                @error('nombre')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded font-semibold">
                    Actualizar
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
