<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-indigo-900">Clientes</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4">
        @if (session('success'))
            <div class="mb-4 text-green-600 font-semibold bg-green-50 border border-green-200 rounded px-4 py-2 shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-between items-center mb-6 flex-wrap gap-2">
            <span class="text-lg font-semibold text-gray-700">Listado de clientes</span>
            <a href="{{ route('admin.clientes.create') }}"
                class="inline-flex items-center gap-2 bg-yellow-400 hover:bg-yellow-300 text-indigo-900 font-bold px-5 py-2 rounded-lg shadow transition-colors duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4v16m8-8H4" />
                </svg>
                Nuevo Cliente
            </a>
        </div>

        <div class="overflow-x-auto bg-white rounded-xl shadow border border-gray-100">
            <table class="min-w-[640px] w-full text-sm text-left">
                <thead class="bg-indigo-900 text-white">
                    <tr>
                        <th class="p-3 font-semibold">#</th>
                        <th class="p-3 font-semibold">Nombre</th>
                        <th class="p-3 font-semibold">Correo</th>
                        <th class="p-3 font-semibold">Celular</th>
                        <th class="p-3 font-semibold text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($clientes as $cliente)
                        <tr class="border-t hover:bg-indigo-50 transition-colors">
                            <td class="p-3">{{ $cliente->id }}</td>
                            <td class="p-3">{{ $cliente->name }}</td>
                            <td class="p-3">{{ $cliente->email }}</td>
                            <td class="p-3">{{ $cliente->celular ?? '-' }}</td>
                            <td class="p-3 text-right">
                                <div x-data="{ showEditModal: false, showDeleteModal: false }" class="flex justify-end gap-2">
                                    <!-- Botón Editar -->
                                    <button @click="showEditModal = true"
                                        class="inline-flex items-center px-2 py-1 text-indigo-700 hover:text-indigo-900 hover:bg-indigo-100 rounded transition"
                                        title="Editar">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536M9 13l6-6 3 3-6 6H9v-3z" />
                                        </svg>
                                        <span class="sr-only">Editar</span>
                                    </button>
                                    <!-- Modal Editar -->
                                    <div x-show="showEditModal" x-cloak
                                        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
                                        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-sm">
                                            <h3 class="text-lg font-bold mb-4 text-indigo-900">Confirmar edición</h3>
                                            <p class="mb-6 text-gray-700">¿Deseas editar el cliente <span class="font-semibold">{{ $cliente->name }}</span>?</p>
                                            <div class="flex justify-end gap-2">
                                                <button @click="showEditModal = false"
                                                    class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold">Cancelar</button>
                                                <a href="{{ route('admin.clientes.edit', $cliente) }}"
                                                    class="px-4 py-2 rounded bg-indigo-600 hover:bg-indigo-700 text-white font-semibold">Editar</a>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Botón Eliminar -->
                                    <button @click="showDeleteModal = true"
                                        class="inline-flex items-center px-2 py-1 text-red-600 hover:text-red-800 hover:bg-red-50 rounded transition"
                                        title="Eliminar">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        <span class="sr-only">Eliminar</span>
                                    </button>
                                    <!-- Modal Eliminar -->
                                    <div x-show="showDeleteModal" x-cloak
                                        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
                                        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-sm">
                                            <h3 class="text-lg font-bold mb-4 text-red-700">Confirmar eliminación</h3>
                                            <p class="mb-6 text-gray-700">¿Estás seguro de eliminar el cliente <span class="font-semibold">{{ $cliente->name }}</span>? Esta acción no se puede deshacer.</p>
                                            <div class="flex justify-end gap-2">
                                                <button @click="showDeleteModal = false"
                                                    class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold">Cancelar</button>
                                                <form action="{{ route('admin.clientes.destroy', $cliente) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="px-4 py-2 rounded bg-red-600 hover:bg-red-700 text-white font-semibold">Eliminar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-6 text-center text-gray-500">
                                No hay clientes registrados aún.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
