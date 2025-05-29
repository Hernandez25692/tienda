<section class="max-w-xl mx-auto bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
    <header class="mb-6">
        <h2 class="text-2xl font-bold text-[#1e3a8a] flex items-center gap-2">
            <svg class="w-6 h-6 text-[#facc15]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 11c1.104 0 2-.896 2-2V7a2 2 0 10-4 0v2c0 1.104.896 2 2 2zm6 2v5a2 2 0 01-2 2H8a2 2 0 01-2-2v-5m12 0a2 2 0 00-2-2H8a2 2 0 00-2 2m12 0H6"></path></svg>
            {{ __('Actualizar contraseña') }}
        </h2>
        <p class="mt-2 text-gray-500">
            {{ __('Usa una contraseña larga y aleatoria para mantener tu cuenta segura.') }}
        </p>
    </header>

    <form id="passwordForm" method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Contraseña actual')" />
            <x-text-input id="update_password_current_password" name="current_password" type="password"
                class="mt-1 block w-full border-gray-300 focus:border-[#1e3a8a] focus:ring-[#1e3a8a]" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('Nueva contraseña')" />
            <x-text-input id="update_password_password" name="password" type="password"
                class="mt-1 block w-full border-gray-300 focus:border-[#1e3a8a] focus:ring-[#1e3a8a]" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirmar nueva contraseña')" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password"
                class="mt-1 block w-full border-gray-300 focus:border-[#1e3a8a] focus:ring-[#1e3a8a]" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end gap-4 pt-4">
            <button type="button" onclick="openPasswordModal()"
                class="bg-[#1e3a8a] text-white px-6 py-2 rounded-lg font-semibold shadow hover:bg-[#facc15] hover:text-[#1e3a8a] border border-[#1e3a8a] hover:border-[#facc15] transition">
                Guardar cambios
            </button>
        </div>
    </form>

    <!-- Modal de confirmación de cambio de contraseña -->
    <div id="passwordModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-lg border border-gray-100 space-y-5 relative">
            <button onclick="closePasswordModal()" class="absolute top-3 right-3 text-gray-400 hover:text-gray-700 text-xl">&times;</button>
            <h3 class="text-xl font-bold text-[#1e3a8a] mb-2">¿Confirmar cambio de contraseña?</h3>
            <div class="text-sm text-gray-700 space-y-1">
                <p><strong>Contraseña actual:</strong> <span id="modalCurrentPassword"></span></p>
                <p><strong>Nueva contraseña:</strong> <span id="modalNewPassword"></span></p>
                <p><strong>Confirmar nueva contraseña:</strong> <span id="modalConfirmPassword"></span></p>
            </div>
            <div id="modalErrors" class="text-red-600 text-sm space-y-1"></div>
            <div class="flex justify-end gap-3 pt-4">
                <button onclick="closePasswordModal()"
                    class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold">Cancelar</button>
                <button onclick="submitPasswordForm()"
                    class="px-4 py-2 rounded bg-[#facc15] hover:bg-[#1e3a8a] hover:text-white text-[#1e3a8a] font-semibold border border-[#facc15] hover:border-[#1e3a8a] transition">Confirmar</button>
            </div>
        </div>
    </div>
    <script>
        function openPasswordModal() {
            const currentPassword = document.getElementById('update_password_current_password').value;
            const newPassword = document.getElementById('update_password_password').value;
            const confirmPassword = document.getElementById('update_password_password_confirmation').value;

            document.getElementById('modalCurrentPassword').innerText = currentPassword ? '••••••••' : '(vacía)';
            document.getElementById('modalNewPassword').innerText = newPassword ? '••••••••' : '(vacía)';
            document.getElementById('modalConfirmPassword').innerText = confirmPassword ? '••••••••' : '(vacía)';

            // Validaciones
            let errors = [];
            if (!currentPassword) {
                errors.push('La contraseña actual es obligatoria.');
            }
            if (!newPassword) {
                errors.push('La nueva contraseña es obligatoria.');
            } else {
                if (newPassword.length < 8) {
                    errors.push('La nueva contraseña debe tener al menos 8 caracteres.');
                }
                if (newPassword === currentPassword && currentPassword) {
                    errors.push('La nueva contraseña debe ser diferente de la actual.');
                }
            }
            if (newPassword !== confirmPassword) {
                errors.push('La confirmación de la nueva contraseña no coincide.');
            }

            const errorDiv = document.getElementById('modalErrors');
            errorDiv.innerHTML = '';
            if (errors.length > 0) {
                errors.forEach(e => {
                    errorDiv.innerHTML += `<div>• ${e}</div>`;
                });
            }

            document.getElementById('passwordModal').classList.remove('hidden');
        }

        function closePasswordModal() {
            document.getElementById('passwordModal').classList.add('hidden');
        }

        function submitPasswordForm() {
            // Validaciones antes de enviar
            const currentPassword = document.getElementById('update_password_current_password').value;
            const newPassword = document.getElementById('update_password_password').value;
            const confirmPassword = document.getElementById('update_password_password_confirmation').value;

            let errors = [];
            if (!currentPassword) {
                errors.push('La contraseña actual es obligatoria.');
            }
            if (!newPassword) {
                errors.push('La nueva contraseña es obligatoria.');
            } else {
                if (newPassword.length < 8) {
                    errors.push('La nueva contraseña debe tener al menos 8 caracteres.');
                }
                if (newPassword === currentPassword && currentPassword) {
                    errors.push('La nueva contraseña debe ser diferente de la actual.');
                }
            }
            if (newPassword !== confirmPassword) {
                errors.push('La confirmación de la nueva contraseña no coincide.');
            }

            const errorDiv = document.getElementById('modalErrors');
            errorDiv.innerHTML = '';
            if (errors.length > 0) {
                errors.forEach(e => {
                    errorDiv.innerHTML += `<div>• ${e}</div>`;
                });
                return;
            }

            document.getElementById('passwordForm').submit();
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === "Escape") closePasswordModal();
        });
    </script>
</section>
