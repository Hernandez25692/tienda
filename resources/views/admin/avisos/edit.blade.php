<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Editar Aviso</h2>
    </x-slot>

    <div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl shadow-lg mt-8"
         x-data="{
             titulo: '{{ old('titulo', $aviso->titulo) }}',
             contenido: `{{ old('contenido', $aviso->contenido) }}`,
             imagen: '{{ $aviso->imagen ? asset('storage/' . $aviso->imagen) : '' }}',
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
        <form method="POST" action="{{ route('admin.avisos.update', $aviso) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-semibold text-gray-700 mb-1">Título</label>
                <input type="text" name="titulo" class="form-input w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200/50 transition" x-model="titulo">
                @error('titulo')
                    <span class="text-red-600 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block font-semibold text-gray-700 mb-1">Contenido</label>
                <textarea name="contenido" rows="5" class="form-textarea w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200/50 transition" x-model="contenido"></textarea>
                @error('contenido')
                    <span class="text-red-600 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block font-semibold text-gray-700 mb-1">Imagen actual</label>
                <template x-if="imagen">
                    <img :src="imagen" class="w-full h-48 object-cover rounded-lg shadow mb-2 border border-gray-200">
                </template>
                <input type="file" name="imagen" class="form-input w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200/50 transition" @change="leerImagen">
                @error('imagen')
                    <span class="text-red-600 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block font-semibold text-gray-700 mb-1">Mostrar desde</label>
                    <input type="datetime-local" name="mostrar_desde" class="form-input w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200/50 transition"
                        value="{{ old('mostrar_desde', optional($aviso->mostrar_desde)->format('Y-m-d\TH:i')) }}">
                </div>

                <div>
                    <label class="block font-semibold text-gray-700 mb-1">Mostrar hasta</label>
                    <input type="datetime-local" name="mostrar_hasta" class="form-input w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200/50 transition"
                        value="{{ old('mostrar_hasta', optional($aviso->mostrar_hasta)->format('Y-m-d\TH:i')) }}">
                </div>
            </div>

            <div>
                <label class="inline-flex items-center">
                    <input type="checkbox" name="activo" value="1" class="form-checkbox rounded text-blue-600"
                        {{ $aviso->activo ? 'checked' : '' }}>
                    <span class="ml-2 text-sm text-gray-700">Activo</span>
                </label>
            </div>

            <div class="flex justify-end gap-4 pt-4">
                <button type="button"
                    @click="showModal = true"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg shadow transition">
                    Vista previa
                </button>
                <button type="submit"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-6 rounded-lg shadow transition">
                    Guardar cambios
                </button>
            </div>
        </form>

        <!-- Modal de vista previa -->
        <div x-show="showModal" class="fixed inset-0 bg-black bg-opacity-40 z-50 flex items-center justify-center"
             x-transition>
            <div class="bg-white p-8 rounded-2xl shadow-2xl max-w-md w-full mx-4 relative"
                 @click.away="showModal = false">
                <h3 class="text-2xl font-bold mb-4 text-gray-900 text-center">Vista previa del aviso</h3>

                <template x-if="imagen">
                    <img :src="imagen" alt="Vista previa" class="rounded-lg w-full h-48 object-cover mb-4 border border-gray-200 shadow">
                </template>

                <h4 class="text-lg font-semibold text-gray-800 mb-2" x-text="titulo"></h4>
                <p class="text-base text-gray-600 whitespace-pre-line" x-text="contenido"></p>

                <div class="mt-8 text-center">
                    <button @click="showModal = false"
                            class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-6 py-2 rounded-lg transition">
                        Cerrar vista previa
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
