<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <svg class="w-7 h-7 text-[#1e3a8a]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M12 12c2.7 0 8 1.34 8 4v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2c0-2.66 5.3-4 8-4zm0-2a4 4 0 100-8 4 4 0 000 8z"/>
            </svg>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-800 leading-tight">
                Mi Perfil
            </h2>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto py-8 px-2 sm:px-6 lg:px-8">
        @if (session('status') === 'profile-updated')
            <div 
                x-data="{ open: true }" 
                x-show="open" 
                x-transition.opacity.duration.500ms
                class="mb-6 flex items-center justify-between bg-green-100 border border-green-200 text-green-800 px-5 py-3 rounded-lg shadow-sm"
            >
                <div class="flex items-center gap-2">
                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span>Perfil actualizado correctamente.</span>
                </div>
                <button @click="open = false" class="text-green-700 hover:text-green-900 font-bold text-xl">&times;</button>
            </div>
            <script>
                setTimeout(() => { 
                    document.querySelector('[x-data]').style.display = 'none'; 
                }, 2200);
            </script>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Card: Datos personales -->
            <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all border border-gray-100 p-7 flex flex-col">
                <div class="flex items-center gap-2 mb-5 border-b border-gray-100 pb-3">
                    <svg class="w-6 h-6 text-[#1e3a8a]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 12c2.7 0 8 1.34 8 4v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2c0-2.66 5.3-4 8-4zm0-2a4 4 0 100-8 4 4 0 000 8z"/>
                    </svg>
                    <h3 class="text-xl font-bold text-[#1e3a8a]">Datos personales</h3>
                </div>
                <form method="POST" action="{{ route('profile.update') }}" class="space-y-6 flex-1" id="profileForm" autocomplete="off">
                    @csrf
                    @method('patch')

                    <!-- Nombre -->
                    <div>
                        <label class="block text-base font-semibold text-gray-700 mb-1">Nombre completo</label>
                        <input 
                            type="text" 
                            name="name" 
                            value="{{ old('name', auth()->user()->name) }}"
                            class="mt-1 block w-full border-2 border-gray-200 rounded-lg shadow-sm focus:ring-2 focus:ring-[#facc15] focus:border-[#facc15] transition text-gray-800"
                            required maxlength="100"
                            pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$"
                            title="Solo letras y espacios"
                            oninput="
                                // Solo letras y espacios
                                this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '');
                                // Formatear: primera letra de cada palabra mayúscula, resto minúscula
                                this.value = this.value
                                    .toLowerCase()
                                    .replace(/(^|\s)([a-záéíóúñ])/g, function(m) { return m.toUpperCase(); });
                            "
                        >
                        <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-red-600" />
                    </div>

                    <!-- Correo -->
                    <div>
                        <label class="block text-base font-semibold text-gray-700 mb-1">Correo electrónico</label>
                        <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                            class="mt-1 block w-full border-2 border-gray-200 rounded-lg shadow-sm focus:ring-2 focus:ring-[#facc15] focus:border-[#facc15] transition text-gray-800"
                            required>
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
                    </div>

                    <!-- Celular -->
                    <div>
                        <label class="block text-base font-semibold text-gray-700 mb-1">Número de celular</label>
                        <input type="text" name="celular" id="celular" value="{{ old('celular', auth()->user()->celular ?? '') }}"
                            class="mt-1 block w-full border-2 border-gray-200 rounded-lg shadow-sm focus:ring-2 focus:ring-[#facc15] focus:border-[#facc15] transition text-gray-800"
                            pattern="\d{4}-\d{4}" maxlength="9" placeholder="0000-0000" required autocomplete="off">
                        <x-input-error :messages="$errors->get('celular')" class="mt-2 text-sm text-red-600" />
                        <span id="celularError" class="text-sm text-red-500 hidden">Formato inválido. Debe ser 0000-0000.</span>
                    </div>

                    <div class="pt-4 flex justify-end">
                        <button type="button"
                            class="bg-[#1e3a8a] hover:bg-[#facc15] hover:text-[#1e3a8a] text-white font-semibold px-6 py-2 rounded-lg shadow transition-all duration-200 border-2 border-[#1e3a8a] hover:border-[#facc15]"
                            onclick="openConfirmModal()">
                            Guardar cambios
                        </button>
                    </div>
                </form>
            </div>

            <!-- Card: Cambiar contraseña -->
            <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all border border-gray-100 p-7 flex flex-col">
                <div class="flex items-center gap-2 mb-5 border-b border-gray-100 pb-3">
                    <svg class="w-6 h-6 text-[#facc15]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 17a2 2 0 002-2v-2a2 2 0 00-4 0v2a2 2 0 002 2zm6-6V9a6 6 0 10-12 0v2a2 2 0 00-2 2v6a2 2 0 002 2h12a2 2 0 002-2v-6a2 2 0 00-2-2z"/>
                    </svg>
                    <h3 class="text-xl font-bold text-[#facc15]">Cambiar contraseña</h3>
                </div>
                <div class="flex-1">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de confirmación -->
    <div id="confirmModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-xl shadow-2xl p-8 max-w-sm w-[95vw] space-y-6 border border-gray-100">
            <div class="flex items-center gap-2">
                <svg class="w-6 h-6 text-[#1e3a8a]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z"/>
                </svg>
                <h4 class="text-lg font-bold text-gray-800">¿Confirmar cambios?</h4>
            </div>
            <p class="text-gray-600">¿Estás seguro de que deseas guardar los cambios en tu perfil?</p>
            <div class="flex justify-end space-x-3 pt-4">
                <button onclick="closeConfirmModal()" class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold transition">Cancelar</button>
                <button onclick="submitProfileForm()" class="px-4 py-2 rounded bg-[#facc15] hover:bg-[#1e3a8a] hover:text-white text-[#1e3a8a] font-semibold transition border-2 border-[#facc15] hover:border-[#1e3a8a]">Confirmar</button>
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
        if (celularInput) {
            celularInput.addEventListener('input', function(e) {
                let value = celularInput.value.replace(/\D/g, '');
                if (value.length > 4) value = value.slice(0,4) + '-' + value.slice(4,8);
                celularInput.value = value.slice(0,9);
            });
            celularInput.addEventListener('blur', function() {
                const regex = /^\d{4}-\d{4}$/;
                if (!regex.test(celularInput.value)) {
                    celularError.classList.remove('hidden');
                    celularInput.classList.add('border-red-400');
                } else {
                    celularError.classList.add('hidden');
                    celularInput.classList.remove('border-red-400');
                }
            });
            celularInput.addEventListener('focus', function() {
                celularError.classList.add('hidden');
                celularInput.classList.remove('border-red-400');
            });
        }

        // Responsive modal close on ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === "Escape") closeConfirmModal();
        });
    </script>

    <style>
        @media (max-width: 900px) {
            .grid-cols-2 { grid-template-columns: 1fr !important; }
        }
        @media (max-width: 640px) {
            .max-w-5xl { max-width: 100% !important; }
            .p-7, .p-8 { padding: 1.2rem !important; }
        }
        input:invalid {
            border-color: #f87171;
        }
        input:focus:invalid {
            outline: none;
            box-shadow: 0 0 0 2px #f87171;
        }
        /* Custom scrollbar for cards */
        .rounded-2xl::-webkit-scrollbar {
            width: 6px;
            background: #f3f4f6;
        }
        .rounded-2xl::-webkit-scrollbar-thumb {
            background: #e5e7eb;
            border-radius: 6px;
        }
    </style>
</x-app-layout>
