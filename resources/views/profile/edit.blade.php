<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-extrabold text-gray-800 leading-tight">
            Mi Perfil
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        @if (session('status') === 'profile-updated')
            <div x-data="{ open: true }" x-show="open" class="mb-4 p-4 bg-green-100 text-green-700 rounded-md flex items-center justify-between">
                <span>Perfil actualizado correctamente.</span>
                <button @click="open = false" class="text-green-700 hover:text-green-900 font-bold text-lg">&times;</button>
            </div>
            <script>
                setTimeout(() => { document.querySelector('[x-data]').style.display = 'none'; }, 2500);
                window.location.href = "{{ route('productos.index') }}";
            </script>
        @endif

        <div class="bg-white shadow-xl rounded-2xl p-8 space-y-8 transition-all duration-300 hover:shadow-2xl">
            <h3 class="text-2xl font-bold text-indigo-700 border-b-2 border-indigo-100 pb-3">Información personal</h3>

            <form method="POST" action="{{ route('profile.update') }}" class="space-y-6" id="profileForm" autocomplete="off">
                @csrf
                @method('patch')

                <!-- Nombre -->
                <div>
                    <label class="block text-base font-semibold text-gray-700 mb-1">Nombre completo</label>
                    <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}"
                        class="mt-1 block w-full border-2 border-gray-200 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition"
                        required maxlength="100">
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-red-600" />
                </div>

                <!-- Correo -->
                <div>
                    <label class="block text-base font-semibold text-gray-700 mb-1">Correo electrónico</label>
                    <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                        class="mt-1 block w-full border-2 border-gray-200 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition"
                        required>
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
                </div>

                <!-- Celular -->
                <div>
                    <label class="block text-base font-semibold text-gray-700 mb-1">Número de celular</label>
                    <input type="text" name="celular" id="celular" value="{{ old('celular', auth()->user()->celular ?? '') }}"
                        class="mt-1 block w-full border-2 border-gray-200 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition"
                        pattern="\d{4}-\d{4}" maxlength="9" placeholder="0000-0000" required>
                    <x-input-error :messages="$errors->get('celular')" class="mt-2 text-sm text-red-600" />
                    <span id="celularError" class="text-sm text-red-500 hidden">Formato inválido. Debe ser 0000-0000.</span>
                </div>

                <div class="pt-6 flex justify-end">
                    <button type="button"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-2 rounded-lg shadow transition"
                        onclick="openConfirmModal()">
                        Guardar cambios
                    </button>
                </div>
            </form>
        </div>

        <div class="mt-10 bg-white shadow-xl rounded-2xl p-8 space-y-6 transition-all duration-300 hover:shadow-2xl">
            <h3 class="text-2xl font-bold text-indigo-700 border-b-2 border-indigo-100 pb-3">Cambiar contraseña</h3>
            @include('profile.partials.update-password-form')
        </div>
    </div>

    <!-- Modal de confirmación -->
    <div id="confirmModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-xl shadow-2xl p-8 max-w-sm w-full space-y-6">
            <h4 class="text-lg font-bold text-gray-800">¿Confirmar cambios?</h4>
            <p class="text-gray-600">¿Estás seguro de que deseas guardar los cambios en tu perfil?</p>
            <div class="flex justify-end space-x-3 pt-4">
                <button onclick="closeConfirmModal()" class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold">Cancelar</button>
                <button onclick="submitProfileForm()" class="px-4 py-2 rounded bg-indigo-600 hover:bg-indigo-700 text-white font-semibold">Confirmar</button>
            </div>
        </div>
    </div>

    <script>
        // Modal functions
        function openConfirmModal() {
            document.getElementById('confirmModal').classList.remove('hidden');
        }
        function closeConfirmModal() {
            document.getElementById('confirmModal').classList.add('hidden');
        }
        function submitProfileForm() {
            document.getElementById('profileForm').submit();
        }

        // Celular input mask and validation
        const celularInput = document.getElementById('celular');
        const celularError = document.getElementById('celularError');
        celularInput.addEventListener('input', function(e) {
            let value = celularInput.value.replace(/\D/g, '');
            if (value.length > 4) value = value.slice(0,4) + '-' + value.slice(4,8);
            celularInput.value = value.slice(0,9);
        });
        celularInput.addEventListener('blur', function() {
            const regex = /^\d{4}-\d{4}$/;
            if (!regex.test(celularInput.value)) {
                celularError.classList.remove('hidden');
            } else {
                celularError.classList.add('hidden');
            }
        });
        celularInput.addEventListener('focus', function() {
            celularError.classList.add('hidden');
        });

        // Responsive modal close on ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === "Escape") closeConfirmModal();
        });
    </script>

    <style>
        @media (max-width: 640px) {
            .max-w-4xl { max-width: 100% !important; }
            .p-8 { padding: 1.5rem !important; }
        }
        input:invalid {
            border-color: #f87171;
        }
        input:focus:invalid {
            outline: none;
            box-shadow: 0 0 0 2px #f87171;
        }
    </style>
</x-app-layout>
