<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800">Nuevo Cliente</h2>
    </x-slot>

    <div class="max-w-xl mx-auto py-6 px-4 bg-white shadow rounded">
        <form id="clienteForm">
            @csrf

            <div class="mb-4">
                <label class="block font-medium text-sm text-gray-700">Nombre completo</label>
                <input type="text" name="name" class="w-full border-gray-300 rounded mt-1" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium text-sm text-gray-700">Correo</label>
                <input type="email" name="email" class="w-full border-gray-300 rounded mt-1" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium text-sm text-gray-700">Celular</label>
                <input 
                    type="text" 
                    name="celular" 
                    id="celular" 
                    maxlength="9" 
                    pattern="\d{4}-\d{4}" 
                    placeholder="0000-0000" 
                    class="w-full border-gray-300 rounded mt-1" 
                    required
                    oninput="this.value = this.value.replace(/[^0-9\-]/g, '').replace(/^(\d{4})(\d{0,4})/, (m, g1, g2) => g2 ? g1 + '-' + g2 : g1);"
                >
                <span id="celularError" class="text-red-500 text-xs hidden">Formato inválido. Debe ser 0000-0000.</span>
            </div>

            <div class="mb-4 relative">
                <label class="block font-medium text-sm text-gray-700">Contraseña</label>
                <input type="password" name="password" id="password" class="w-full border-gray-300 rounded mt-1 pr-10" required>
                <button type="button" onclick="togglePassword('password')" class="absolute right-2 top-8 text-gray-500">👁️</button>
            </div>

            <div class="mb-4 relative">
                <label class="block font-medium text-sm text-gray-700">Confirmar contraseña</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="w-full border-gray-300 rounded mt-1 pr-10" required>
                <button type="button" onclick="togglePassword('password_confirmation')" class="absolute right-2 top-8 text-gray-500">👁️</button>
                <span id="passwordError" class="text-red-500 text-xs hidden">Las contraseñas no coinciden.</span>
            </div>

            <div class="text-right">
                <button type="button" onclick="openModal()" class="bg-green-600 text-white px-4 py-2 rounded">Guardar</button>
            </div>
        </form>
    </div>

    <!-- Modal -->
    <div id="confirmModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
        <div class="bg-white p-6 rounded shadow max-w-sm w-full">
            <h3 class="text-lg font-bold mb-2">Confirmar registro</h3>
            <div id="modalErrors" class="mb-2 text-red-500 text-sm"></div>
            <p>¿Desea guardar este cliente?</p>
            <div class="mt-4 flex justify-end gap-2">
                <button onclick="closeModal()" class="px-4 py-2 bg-gray-300 rounded">Cancelar</button>
                <button onclick="submitForm()" class="px-4 py-2 bg-green-600 text-white rounded">Confirmar</button>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(id) {
            const input = document.getElementById(id);
            input.type = input.type === 'password' ? 'text' : 'password';
        }

        function openModal() {
            // Validaciones antes de mostrar el modal
            let errors = [];
            const celular = document.getElementById('celular').value;
            const celularPattern = /^\d{4}-\d{4}$/;
            const password = document.getElementById('password').value;
            const password_confirmation = document.getElementById('password_confirmation').value;

            // Validar celular
            if (!celularPattern.test(celular)) {
                document.getElementById('celularError').classList.remove('hidden');
                errors.push('El celular debe tener el formato 0000-0000.');
            } else {
                document.getElementById('celularError').classList.add('hidden');
            }

            // Validar contraseñas
            if (password !== password_confirmation) {
                document.getElementById('passwordError').classList.remove('hidden');
                errors.push('Las contraseñas no coinciden.');
            } else {
                document.getElementById('passwordError').classList.add('hidden');
            }

            // Mostrar errores en el modal si existen
            if (errors.length > 0) {
                document.getElementById('modalErrors').innerHTML = errors.join('<br>');
            } else {
                document.getElementById('modalErrors').innerHTML = '';
            }

            document.getElementById('confirmModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('confirmModal').classList.add('hidden');
        }

        function submitForm() {
            // Si hay errores, no enviar
            if (document.getElementById('modalErrors').innerHTML !== '') return;
            // Enviar el formulario
            document.getElementById('clienteForm').submit();
        }
    </script>
</x-app-layout>
