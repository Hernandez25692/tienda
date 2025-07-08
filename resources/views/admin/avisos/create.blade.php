<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Crear Aviso General</h2>
    </x-slot>

    <div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl shadow-lg mt-8" x-data="{
        titulo: '{{ old('titulo') }}',
        contenido: `{{ old('contenido') }}`,
        imagen: '',
        showModal: false,
        leerImagen(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.imagen = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }
    }">
        <form method="POST" action="{{ route('admin.avisos.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <label class="block font-semibold text-gray-700 mb-1">Título (opcional si hay imagen)</label>
                <input type="text" name="titulo"
                    class="form-input w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200/50 transition"
                    x-model="titulo">
                @error('titulo')
                    <span class="text-red-600 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block font-semibold text-gray-700 mb-1">Contenido del aviso (opcional si hay
                    imagen)</label>
                <textarea name="contenido" rows="5"
                    class="form-textarea w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200/50 transition"
                    x-model="contenido"></textarea>
                @error('contenido')
                    <span class="text-red-600 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block font-semibold text-gray-700 mb-1">Imagen (opcional, ideal para anuncios
                    visuales)</label>
                <input type="file" name="imagen"
                    class="form-input w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200/50 transition"
                    @change="leerImagen">
                @error('imagen')
                    <span class="text-red-600 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block font-semibold text-gray-700 mb-1">Mostrar desde</label>
                    <input type="datetime-local" name="mostrar_desde"
                        class="form-input w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200/50 transition"
                        value="{{ old('mostrar_desde') }}">
                    @error('mostrar_desde')
                        <span class="text-red-600 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block font-semibold text-gray-700 mb-1">Mostrar hasta</label>
                    <input type="datetime-local" name="mostrar_hasta"
                        class="form-input w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200/50 transition"
                        value="{{ old('mostrar_hasta') }}">
                    @error('mostrar_hasta')
                        <span class="text-red-600 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div>
                <label class="inline-flex items-center">
                    <input type="checkbox" name="activo" value="1" class="form-checkbox rounded text-blue-600"
                        checked>
                    <span class="ml-2 text-sm text-gray-700">Activo</span>
                </label>
            </div>

            <div class="flex justify-end gap-4 pt-4">
                <button type="button" @click="showModal = true"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg shadow transition">
                    Vista previa
                </button>
                <button type="submit"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-6 rounded-lg shadow transition">
                    Guardar Aviso
                </button>
            </div>
        </form>

        <!-- Modal de vista previa -->
        <div x-show="showModal" class="fixed inset-0 bg-black bg-opacity-40 z-50 flex items-center justify-center"
            x-transition>
            <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-2xl max-w-2xl w-full mx-4 relative"
                @click.away="showModal = false">
                <h3 class="text-2xl font-bold mb-4 text-gray-900 text-center">Vista previa del aviso</h3>

                <template x-if="imagen">
                    <img :src="imagen" alt="Vista previa"
                        class="rounded-xl w-full h-56 object-cover mb-6 border border-gray-300 shadow">
                </template>

                <template x-if="titulo">
                    <h4 class="text-xl font-semibold text-gray-800 mb-2" x-text="titulo"></h4>
                </template>

                <template x-if="contenido">
                    <p class="text-base text-gray-700 whitespace-pre-line" x-text="contenido"></p>
                </template>

                <div class="mt-6 text-center">
                    <button @click="showModal = false"
                        class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-6 py-2 rounded-lg transition">
                        Cerrar vista previa
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
