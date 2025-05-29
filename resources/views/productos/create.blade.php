<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-[#1e3a8a] leading-tight tracking-tight flex items-center gap-2">
            <svg class="w-7 h-7 text-[#facc15]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M3 7V6a2 2 0 012-2h2a2 2 0 012 2v1m10 0V6a2 2 0 00-2-2h-2a2 2 0 00-2 2v1M5 7h14a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9a2 2 0 012-2z"/>
            </svg>
            Crear Nuevo Producto
        </h2>
    </x-slot>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

            {{-- Información del producto --}}
            <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 mb-4 border border-gray-100">
                <h3 class="text-lg font-semibold text-[#2563eb] mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#facc15]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 4v16m8-8H4"/>
                    </svg>
                    Información del producto
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block font-medium text-[#1e3a8a] mb-1" for="nombre">
                            Nombre <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nombre" id="nombre" required
                            placeholder="Ej: Camiseta básica"
                            class="peer mt-1 block w-full border border-gray-200 rounded-lg shadow-sm focus:ring-[#2563eb] focus:border-[#2563eb] transition placeholder-gray-400"
                            value="{{ old('nombre') }}">
                        @error('nombre')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="block font-medium text-[#1e3a8a] mb-1" for="descripcion">
                            Descripción
                        </label>
                        <textarea name="descripcion" id="descripcion" rows="2"
                            placeholder="Describe el producto brevemente"
                            class="peer mt-1 block w-full border border-gray-200 rounded-lg shadow-sm focus:ring-[#2563eb] focus:border-[#2563eb] transition placeholder-gray-400">{{ old('descripcion') }}</textarea>
                        @error('descripcion')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Precios --}}
            <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 mb-4 border border-gray-100">
                <h3 class="text-lg font-semibold text-[#2563eb] mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#facc15]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3zm0 0V4m0 16v-4"/>
                    </svg>
                    Precios
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block font-medium text-[#1e3a8a] mb-1" for="precio_venta">
                            Precio de Venta (L) <span class="text-red-500">*</span>
                            <span class="ml-1" title="Precio al que se venderá el producto">
                                <svg class="inline w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10"/><path d="M12 16v-4m0-4h.01"/>
                                </svg>
                            </span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-[#facc15]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3zm0 0V4m0 16v-4"/>
                                </svg>
                            </span>
                            <input type="number" name="precio_venta" id="precio_venta" step="0.01" required
                                placeholder="0.00"
                                class="peer pl-10 mt-1 block w-full border border-gray-200 rounded-lg shadow-sm focus:ring-[#2563eb] focus:border-[#2563eb] transition placeholder-gray-400"
                                value="{{ old('precio_venta') }}">
                        </div>
                        @error('precio_venta')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="block font-medium text-[#1e3a8a] mb-1" for="precio_compra">
                            Precio de Compra
                            <span class="ml-1" title="Solo visible para administradores">
                                <svg class="inline w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10"/><path d="M12 16v-4m0-4h.01"/>
                                </svg>
                            </span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-[#facc15]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3zm0 0V4m0 16v-4"/>
                                </svg>
                            </span>
                            <input type="number" name="precio_compra" id="precio_compra" step="0.01"
                                placeholder="0.00"
                                class="peer pl-10 mt-1 block w-full border border-gray-200 rounded-lg shadow-sm focus:ring-[#2563eb] focus:border-[#2563eb] transition placeholder-gray-400"
                                value="{{ old('precio_compra') }}">
                        </div>
                        @error('precio_compra')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="mt-6">
                    <label class="block font-medium text-[#1e3a8a] mb-1" for="link_compra">
                        Link de Compra
                        <span class="ml-1" title="Enlace externo para comprar el producto">
                            <svg class="inline w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10"/><path d="M12 16v-4m0-4h.01"/>
                            </svg>
                        </span>
                    </label>
                    <input type="url" name="link_compra" id="link_compra"
                        placeholder="https://ejemplo.com/producto"
                        class="peer mt-1 block w-full border border-gray-200 rounded-lg shadow-sm focus:ring-[#2563eb] focus:border-[#2563eb] transition placeholder-gray-400"
                        value="{{ old('link_compra') }}">
                    @error('link_compra')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Categoría y Disponibilidad --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 border border-gray-100">
                    <h3 class="text-lg font-semibold text-[#2563eb] mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#facc15]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        Categoría
                    </h3>
                    <label class="block font-medium text-[#1e3a8a] mb-1" for="categoria_id">
                        Selecciona una categoría <span class="text-red-500">*</span>
                    </label>
                    <select name="categoria_id" id="categoria_id"
                        class="peer mt-1 block w-full border border-gray-200 rounded-lg shadow-sm focus:ring-[#2563eb] focus:border-[#2563eb] transition"
                        required>
                        <option value="">Seleccione una categoría</option>
                        @foreach ($categorias as $cat)
                            <option value="{{ $cat->id }}" @if(old('categoria_id') == $cat->id) selected @endif>
                                {{ $cat->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('categoria_id')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 border border-gray-100">
                    <h3 class="text-lg font-semibold text-[#2563eb] mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#facc15]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/>
                        </svg>
                        Disponibilidad
                    </h3>
                    <label class="block font-medium text-[#1e3a8a] mb-1" for="disponible">
                        Estado del producto
                    </label>
                    <select name="disponible" id="disponible"
                        class="peer mt-1 block w-full border border-gray-200 rounded-lg shadow-sm focus:ring-[#2563eb] focus:border-[#2563eb] transition">
                        <option value="1" @if(old('disponible', '1') == '1') selected @endif>Disponible</option>
                        <option value="0" @if(old('disponible') == '0') selected @endif>Agotado</option>
                    </select>
                    @error('disponible')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Imágenes --}}
            <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 border border-gray-100">
                <h3 class="text-lg font-semibold text-[#2563eb] mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#facc15]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect width="20" height="14" x="2" y="5" rx="2"/><circle cx="8.5" cy="10.5" r="1.5"/>
                        <path d="M21 19l-5.5-5.5a2.121 2.121 0 00-3 0L3 19"/>
                    </svg>
                    Imágenes
                </h3>
                <label class="block font-medium text-[#1e3a8a] mb-1" for="imagenes-input">
                    Sube imágenes del producto
                </label>
                <div class="flex items-center gap-2">
                    <input type="file" name="imagenes[]" multiple
                        class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#facc15]/20 file:text-[#1e3a8a] hover:file:bg-[#facc15]/40 transition"
                        id="imagenes-input" accept="image/*">
                    <span class="text-gray-400" title="Puedes seleccionar varias imágenes">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M15 10l4.553-4.553a2 2 0 00-2.828-2.828L12 7.172 7.275 2.447a2 2 0 00-2.828 2.828L9 10"/>
                        </svg>
                    </span>
                </div>
                <small class="text-gray-500">Puedes seleccionar varias imágenes. Máx 5MB cada una.</small>
                <div id="preview" class="mt-4 flex flex-wrap gap-3"></div>

                <!-- Modal para mostrar la imagen en grande -->
                <div id="modal" class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50 hidden">
                    <span id="close-modal" class="absolute top-4 right-8 text-white text-3xl cursor-pointer">&times;</span>
                    <img id="modal-img" src="" class="max-h-[80vh] max-w-[90vw] rounded shadow-lg border-4 border-white" />
                </div>
                @error('imagenes')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const input = document.getElementById('imagenes-input');
                    const preview = document.getElementById('preview');
                    const modal = document.getElementById('modal');
                    const modalImg = document.getElementById('modal-img');
                    const closeModal = document.getElementById('close-modal');

                    input.addEventListener('change', function () {
                        preview.innerHTML = '';
                        Array.from(input.files).forEach(file => {
                            if (file.type.startsWith('image/')) {
                                const reader = new FileReader();
                                reader.onload = function (e) {
                                    const img = document.createElement('img');
                                    img.src = e.target.result;
                                    img.className = 'h-20 w-20 object-cover rounded border-2 border-[#facc15] shadow cursor-pointer hover:scale-105 transition';
                                    img.addEventListener('click', function () {
                                        modalImg.src = img.src;
                                        modal.classList.remove('hidden');
                                    });
                                    preview.appendChild(img);
                                };
                                reader.readAsDataURL(file);
                            } else {
                                const div = document.createElement('div');
                                div.textContent = file.name;
                                div.className = 'px-2 py-1 bg-gray-100 rounded text-xs';
                                preview.appendChild(div);
                            }
                        });
                    });

                    closeModal.addEventListener('click', function () {
                        modal.classList.add('hidden');
                        modalImg.src = '';
                    });

                    modal.addEventListener('click', function (e) {
                        if (e.target === modal) {
                            modal.classList.add('hidden');
                            modalImg.src = '';
                        }
                    });
                });
            </script>

            <div class="flex justify-end pt-6">
                <button type="submit"
                    class="bg-[#facc15] hover:bg-[#2563eb] text-[#1e3a8a] hover:text-white px-8 py-3 rounded-lg font-bold shadow-lg flex items-center gap-2 focus:outline-none focus:ring-2 focus:ring-[#2563eb] transition text-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M5 13l4 4L19 7"/>
                    </svg>
                    Guardar Producto
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
