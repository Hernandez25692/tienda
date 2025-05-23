<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800">Editar Cliente</h2>
    </x-slot>

    <div class="max-w-xl mx-auto py-6 px-4 bg-white shadow rounded">
        <form id="clienteForm" action="{{ route('admin.clientes.update', $cliente) }}" method="POST" novalidate>
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block font-medium text-sm text-gray-700">Nombre completo</label>
                <input type="text" name="name" value="{{ old('name', $cliente->name) }}" class="w-full border-gray-300 rounded mt-1" required>
                <span class="text-red-500 text-xs hidden" id="nameError">El nombre es obligatorio.</span>
            </div>

            <div class="mb-4">
                <label class="block font-medium text-sm text-gray-700">Correo</label>
                <input type="email" name="email" value="{{ old('email', $cliente->email) }}" class="w-full border-gray-300 rounded mt-1" required>
                <span class="text-red-500 text-xs hidden" id="emailError">Correo inválido.</span>
            </div>

            <div class="mb-4">
                <label class="block font-medium text-sm text-gray-700">Celular</label>
                <input type="text" name="celular" id="celular" maxlength="9" value="{{ old('celular', $cliente->celular) }}" class="w-full border-gray-300 rounded mt-1" placeholder="0000-0000">
                <span class="text-red-500 text-xs hidden" id="celularError">Formato: 0000-0000</span>
            </div>

            <div class="text-right">
                <button type="button" id="openModal" class="bg-blue-600 text-white px-4 py-2 rounded">Actualizar</button>
            </div>
        </form>
    </div>

    <!-- Modal -->
    <div id="confirmModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
        <div class="bg-white p-6 rounded shadow max-w-sm w-full">
            <h3 class="text-lg font-bold mb-4">¿Confirmar actualización?</h3>
            <div class="flex justify-end space-x-2">
                <button id="cancelModal" class="px-4 py-2 bg-gray-300 rounded">Cancelar</button>
                <button id="submitForm" class="px-4 py-2 bg-blue-600 text-white rounded">Sí, actualizar</button>
            </div>
        </div>
    </div>

    <script>
        // Celular input mask
        document.getElementById('celular').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 4) value = value.slice(0,4) + '-' + value.slice(4,8);
            e.target.value = value.slice(0,9);
        });

        // Validaciones
        function validateForm() {
            let valid = true;
            // Nombre
            const name = document.querySelector('[name="name"]');
            const nameError = document.getElementById('nameError');
            if (!name.value.trim()) {
                nameError.classList.remove('hidden');
                valid = false;
            } else {
                nameError.classList.add('hidden');
            }
            // Email
            const email = document.querySelector('[name="email"]');
            const emailError = document.getElementById('emailError');
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email.value.trim())) {
                emailError.classList.remove('hidden');
                valid = false;
            } else {
                emailError.classList.add('hidden');
            }
            // Celular
            const celular = document.getElementById('celular');
            const celularError = document.getElementById('celularError');
            const celularRegex = /^\d{4}-\d{4}$/;
            if (celular.value && !celularRegex.test(celular.value)) {
                celularError.classList.remove('hidden');
                valid = false;
            } else {
                celularError.classList.add('hidden');
            }
            return valid;
        }

        // Modal logic
        document.getElementById('openModal').addEventListener('click', function() {
            if (validateForm()) {
                document.getElementById('confirmModal').classList.remove('hidden');
            }
        });
        document.getElementById('cancelModal').addEventListener('click', function() {
            document.getElementById('confirmModal').classList.add('hidden');
        });
        document.getElementById('submitForm').addEventListener('click', function() {
            document.getElementById('clienteForm').submit();
        });
    </script>
</x-app-layout>
