<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800">Avisos Generales</h2>
    </x-slot>

    <div class="mb-4 flex justify-between items-center">
        <a href="{{ route('admin.avisos.create') }}"
            class="inline-flex items-center bg-yellow-500 text-white px-5 py-2 rounded-lg shadow-md hover:bg-yellow-600 transition font-semibold focus:outline-none focus:ring-2 focus:ring-yellow-400">
            <i class="fas fa-plus mr-2"></i> Crear nuevo aviso
        </a>
    </div>

    <div class="bg-white shadow-lg rounded-lg p-6 overflow-x-auto">
        @if ($avisos->count())
            <table class="min-w-full table-auto text-sm border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-left uppercase tracking-wider text-xs">
                        <th class="p-3 font-semibold">Título</th>
                        <th class="p-3 font-semibold">Visible desde</th>
                        <th class="p-3 font-semibold">Hasta</th>
                        <th class="p-3 font-semibold">Estado</th>
                        <th class="p-3 font-semibold">Creado</th>
                        <th class="p-3 font-semibold">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($avisos as $aviso)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="p-3 font-medium text-gray-800">{{ $aviso->titulo }}</td>
                            <td class="p-3">{{ $aviso->mostrar_desde ? \Carbon\Carbon::parse($aviso->mostrar_desde)->format('d/m/Y') : '-' }}</td>
                            <td class="p-3">{{ $aviso->mostrar_hasta ? \Carbon\Carbon::parse($aviso->mostrar_hasta)->format('d/m/Y') : '-' }}</td>
                            <td class="p-3">
                                <span class="inline-block text-xs px-3 py-1 rounded-full font-bold
                                    {{ $aviso->activo ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $aviso->activo ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td class="p-3 text-gray-500">{{ $aviso->created_at->diffForHumans() }}</td>
                            <td class="p-3 text-sm">
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.avisos.edit', $aviso) }}"
                                        class="inline-block text-blue-600 hover:text-blue-800 hover:underline font-semibold transition">
                                        <i class="fas fa-edit mr-1"></i>Editar
                                    </a>
                                    <form action="{{ route('admin.avisos.destroy', $aviso) }}" method="POST"
                                        onsubmit="return confirm('¿Seguro que deseas eliminar este aviso?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-block text-red-600 hover:text-red-800 hover:underline font-semibold transition">
                                            <i class="fas fa-trash mr-1"></i>Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-gray-600 text-center py-8">No hay avisos registrados.</p>
        @endif
    </div>
</x-app-layout>
