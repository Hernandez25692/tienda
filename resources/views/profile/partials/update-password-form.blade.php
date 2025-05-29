<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Actualizar contraseña') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Asegúrate de que tu cuenta use una contraseña larga y aleatoria para mantenerla segura.') }}
        </p>
    </header>

    <form id="passwordForm" method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Contraseña actual')" />
            <x-text-input id="update_password_current_password" name="current_password" type="password"
                class="mt-1 block w-full" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('Nueva contraseña')" />
            <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full"
                autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirmar contraseña')" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password"
                class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <button type="button" onclick="openPasswordModal()"
                class="bg-[#1e3a8a] text-white px-5 py-2 rounded-lg hover:bg-[#facc15] hover:text-[#1e3a8a] border border-[#1e3a8a] hover:border-[#facc15]">
                Guardar
            </button>
        </div>
    </form>
    <!-- Modal de confirmación de cambio de contraseña -->
    <div id="passwordModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-md border border-gray-100 space-y-4">
            <h3 class="text-lg font-bold text-gray-800">¿Confirmar cambio de contraseña?</h3>
            <div class="text-sm text-gray-600">
                <p><strong>Contraseña actual:</strong> <span id="modalCurrentPassword"></span></p>
                <p><strong>Nueva contraseña:</strong> <span id="modalNewPassword"></span></p>
            </div>
            <div class="flex justify-end gap-3 pt-3">
                <button onclick="closePasswordModal()"
                    class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold">Cancelar</button>
                <button onclick="submitPasswordForm()"
                    class="px-4 py-2 rounded bg-[#facc15] hover:bg-[#1e3a8a] hover:text-white text-[#1e3a8a] font-semibold border border-[#facc15] hover:border-[#1e3a8a]">Confirmar</button>
            </div>
        </div>
    </div>
    <script>
        function openPasswordModal() {
            const currentPassword = document.getElementById('update_password_current_password').value;
            const newPassword = document.getElementById('update_password_password').value;

            document.getElementById('modalCurrentPassword').innerText = currentPassword ? '••••••••' : '(vacía)';
            document.getElementById('modalNewPassword').innerText = newPassword ? '••••••••' : '(vacía)';

            document.getElementById('passwordModal').classList.remove('hidden');
        }

        function closePasswordModal() {
            document.getElementById('passwordModal').classList.add('hidden');
        }

        function submitPasswordForm() {
            document.getElementById('passwordForm').submit();
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === "Escape") closePasswordModal();
        });
    </script>

</section>
