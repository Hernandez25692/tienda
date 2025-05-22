<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Crear Nuevo Producto
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Nombre</label>
                        <input type="text" name="nombre"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Descripción</label>
                        <textarea name="descripcion" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                    </div>

                    <div>
                        <label class="block font-medium text-gray-700">Precio de Venta (L)</label>
                        <input type="number" name="precio_venta" step="0.01"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>

                    <div>
                        <label class="block font-medium text-gray-700">Precio de Compra (solo admin)</label>
                        <input type="number" name="precio_compra" step="0.01"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div>
                        <label class="block font-medium text-gray-700">Link de Compra</label>
                        <input type="url" name="link_compra"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div>
                        <label class="block font-medium text-gray-700">Estado</label>
                        <select name="disponible" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="1" selected>Disponible</option>
                            <option value="0">Agotado</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-medium text-gray-700">Imágenes del producto</label>
                        <input type="file" name="imagenes[]" multiple
                            class="mt-1 block w-full text-sm text-gray-500">
                        <small class="text-gray-500">Puedes seleccionar varias imágenes</small>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                            class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition">
                            Guardar Producto
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
