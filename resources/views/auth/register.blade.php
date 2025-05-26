<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registro | EncargaYa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 text-gray-800 m-0 p-0">

    <section
        class="min-h-screen w-full flex items-center justify-center px-4 bg-gradient-to-br from-indigo-100 via-white to-blue-50 relative overflow-hidden">

        <!-- FONDO ANIMADO -->
        <div class="absolute inset-0 z-0">
            <div
                class="absolute top-[-100px] left-[-100px] w-[300px] h-[300px] bg-purple-400 rounded-full opacity-20 blur-3xl">
            </div>
            <div
                class="absolute bottom-[-100px] right-[-100px] w-[400px] h-[400px] bg-indigo-500 rounded-full opacity-20 blur-3xl">
            </div>
        </div>

        <!-- CONTENIDO -->
        <div
            class="relative z-10 w-full max-w-6xl grid grid-cols-1 md:grid-cols-2 bg-white rounded-2xl shadow-2xl overflow-hidden">

            <!-- LADO IZQUIERDO: PRESENTACIÓN -->
            <div class="relative bg-gradient-to-br from-indigo-600 via-purple-700 to-indigo-800 text-white flex flex-col justify-center p-10 overflow-hidden">
                <!-- Fondo animado con burbujas -->
                <div class="absolute inset-0 pointer-events-none z-0">
                    <div class="absolute top-10 left-10 w-32 h-32 bg-indigo-400 opacity-30 rounded-full blur-2xl animate-bounce-slow"></div>
                    <div class="absolute bottom-16 right-12 w-40 h-40 bg-purple-300 opacity-20 rounded-full blur-3xl animate-float"></div>
                    <div class="absolute top-1/2 left-1/2 w-24 h-24 bg-yellow-300 opacity-10 rounded-full blur-2xl animate-pulse"></div>
                    <div class="absolute bottom-4 left-1/3 w-16 h-16 bg-indigo-200 opacity-20 rounded-full blur-xl animate-float-reverse"></div>
                </div>
                <div class="relative flex justify-center mb-10">
                    <span class="absolute inset-0 flex items-center justify-center">
                        <span class="animate-spin-slow rounded-full border-4 border-yellow-300 border-t-indigo-500 border-b-purple-400 w-40 h-40"></span>
                    </span>
                    <img src="{{ asset('storage/logos/logo1.png') }}" alt="Logo"
                        class="relative z-10 h-36 w-auto max-w-[320px] drop-shadow-lg transition-transform duration-300 hover:scale-105 hover:drop-shadow-2xl">
                </div>
                <h1 class="relative z-10 text-3xl font-bold leading-snug drop-shadow-lg">Regístrate en <span class="text-yellow-300">EncargaYa</span>
                </h1>
                <p class="relative z-10 mt-4 text-base opacity-90">
                    Explora nuestro catálogo y disfruta de productos increíbles. Compra segura, rápida y sin
                    complicaciones.
                </p>
                <ul class="relative z-10 mt-6 space-y-3 text-sm">
                    <li class="flex items-center"><i class="fas fa-user-plus mr-2 text-yellow-300 animate-bounce"></i> Fácil registro</li>
                    <li class="flex items-center"><i class="fas fa-shield-alt mr-2 text-indigo-200 animate-spin-slow"></i> Seguridad garantizada</li>
                    <li class="flex items-center"><i class="fas fa-tags mr-2 text-pink-200 animate-pulse"></i> Ofertas exclusivas</li>
                </ul>
                <div class="relative z-10 mt-8 flex justify-center">
                    <a href="{{ route('login') }}"
                        class="inline-block bg-white text-indigo-700 px-4 py-2 rounded font-semibold hover:bg-gray-100 transition shadow">
                        ¿Ya tienes cuenta? Iniciar sesión
                    </a>
                </div>
                <!-- Animaciones personalizadas -->
                <style>
                    @keyframes bounce-slow {
                        0%, 100% { transform: translateY(0);}
                        50% { transform: translateY(-30px);}
                    }
                    .animate-bounce-slow {
                        animation: bounce-slow 4s infinite;
                    }
                    @keyframes float {
                        0%, 100% { transform: translateY(0) scale(1);}
                        50% { transform: translateY(20px) scale(1.05);}
                    }
                    .animate-float {
                        animation: float 6s ease-in-out infinite;
                    }
                    @keyframes float-reverse {
                        0%, 100% { transform: translateY(0) scale(1);}
                        50% { transform: translateY(-20px) scale(1.1);}
                    }
                    .animate-float-reverse {
                        animation: float-reverse 7s ease-in-out infinite;
                    }
                    @keyframes spin-slow {
                        0% { transform: rotate(0deg);}
                        100% { transform: rotate(360deg);}
                    }
                    .animate-spin-slow {
                        animation: spin-slow 10s linear infinite;
                    }
                </style>
            </div>

            <!-- LADO DERECHO: FORMULARIO -->
            <div class="p-10 bg-white flex items-center justify-center">
                <form id="registerForm" method="POST" action="{{ route('register') }}"
                    class="w-full max-w-sm space-y-5" autocomplete="off">
                    @csrf
                    <h2 class="text-2xl font-bold text-center text-gray-700 mb-4">Crear cuenta</h2>

                    <!-- Nombre -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nombre completo</label>
                        <input id="name" name="name" type="text" required
                            class="mt-1 w-full px-4 py-2 rounded border border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm"
                            value=""
                            oninput="
                                // Eliminar números y caracteres no permitidos
                                this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
                                // Formatear cada palabra: primera letra mayúscula, resto minúscula
                                this.value = this.value.replace(/\b\w+\b/g, function(word) {
                                    return word.charAt(0).toUpperCase() + word.slice(1).toLowerCase();
                                });
                            "
                            autocomplete="off">
                        <span id="nameError" class="text-red-500 text-xs"></span>
                    </div>

                    <!-- Correo -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
                        <input id="email" name="email" type="email" required
                            class="mt-1 w-full px-4 py-2 rounded border border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm"
                            value="" autocomplete="off">
                        <span id="emailError" class="text-red-500 text-xs"></span>
                    </div>

                    <!-- Celular -->
                    <div>
                        <label for="celular" class="block text-sm font-medium text-gray-700">Número de celular</label>
                        <input id="celular" name="celular" type="text" maxlength="9" placeholder="0000-0000"
                            required
                            class="mt-1 w-full px-4 py-2 rounded border border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm"
                            value="" autocomplete="off">
                        <span id="celularError" class="text-red-500 text-xs"></span>
                    </div>

                    <!-- Contraseña -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                        <div class="relative">
                            <input id="password" name="password" type="password" required
                                class="mt-1 w-full px-4 py-2 rounded border border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm pr-10"
                                autocomplete="new-password">
                            <button type="button" tabindex="-1"
                                onclick="togglePasswordVisibility('password', this)"
                                class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-400 hover:text-indigo-600 focus:outline-none"
                                aria-label="Mostrar/Ocultar contraseña">
                                <i class="fa fa-eye"></i>
                            </button>
                        </div>
                        <span id="passwordError" class="text-red-500 text-xs"></span>
                    </div>

                    <!-- Confirmar -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar
                            contraseña</label>
                        <div class="relative">
                            <input id="password_confirmation" name="password_confirmation" type="password" required
                                class="mt-1 w-full px-4 py-2 rounded border border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm pr-10"
                                autocomplete="new-password">
                            <button type="button" tabindex="-1"
                                onclick="togglePasswordVisibility('password_confirmation', this)"
                                class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-400 hover:text-indigo-600 focus:outline-none"
                                aria-label="Mostrar/Ocultar contraseña">
                                <i class="fa fa-eye"></i>
                            </button>
                        </div>
                        <span id="passwordConfirmationError" class="text-red-500 text-xs"></span>
                    </div>

                    <script>
                        function togglePasswordVisibility(fieldId, btn) {
                            const input = document.getElementById(fieldId);
                            const icon = btn.querySelector('i');
                            if (input.type === 'password') {
                                input.type = 'text';
                                icon.classList.remove('fa-eye');
                                icon.classList.add('fa-eye-slash');
                            } else {
                                input.type = 'password';
                                icon.classList.remove('fa-eye-slash');
                                icon.classList.add('fa-eye');
                            }
                        }
                    </script>

                    <!-- Botón -->
                    <div>
                        <button type="button"
                            onclick="showSummaryModal()"
                            class="w-full py-2 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded shadow transition">
                            Registrarse
                        </button>
                    </div>

                    <!-- Modal de resumen/confirmación -->
                    <div id="summaryModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
                        <div class="bg-white rounded-lg shadow-lg max-w-sm w-full p-6 relative">
                            <h3 class="text-lg font-bold mb-4 text-gray-700">Confirmar registro</h3>
                            <div id="summaryContent" class="mb-4 text-gray-600 text-sm"></div>
                            <div class="flex justify-end space-x-2">
                                <button onclick="closeSummaryModal()" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Cancelar</button>
                                <button onclick="submitRegisterForm()" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Confirmar</button>
                            </div>
                            <button onclick="closeSummaryModal()" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>

                    <script>
                    function showSummaryModal() {
                        // Limpiar errores previos
                        ['nameError', 'emailError', 'celularError', 'passwordError', 'passwordConfirmationError'].forEach(
                            id => { document.getElementById(id).textContent = ''; }
                        );

                        const name = document.getElementById('name').value.trim();
                        const email = document.getElementById('email').value.trim();
                        const celular = document.getElementById('celular').value.trim();
                        const pass = document.getElementById('password').value;
                        const passConfirm = document.getElementById('password_confirmation').value;

                        let missing = [];
                        if (name.length < 3) missing.push('Nombre (mínimo 3 caracteres)');
                        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) missing.push('Correo válido');
                        if (!/^\d{4}-\d{4}$/.test(celular)) missing.push('Celular (formato 0000-0000)');
                        if (pass.length < 6) missing.push('Contraseña (mínimo 6 caracteres)');
                        if (pass !== passConfirm) missing.push('Confirmar contraseña igual a la anterior');

                        let summary = '';
                        if (missing.length > 0) {
                            summary = `<div class="text-red-500 mb-2 font-semibold">Faltan o hay errores en:</div><ul class="list-disc pl-5">` +
                                missing.map(item => `<li>${item}</li>`).join('') + `</ul>`;
                        } else {
                            summary = `
                                <div class="mb-2">¿Deseas confirmar tu registro con estos datos?</div>
                                <ul class="pl-2">
                                    <li><b>Nombre:</b> ${name}</li>
                                    <li><b>Correo:</b> ${email}</li>
                                    <li><b>Celular:</b> ${celular}</li>
                                </ul>
                            `;
                        }
                        document.getElementById('summaryContent').innerHTML = summary;
                        document.getElementById('summaryModal').classList.remove('hidden');
                        // Si hay errores, deshabilitar el botón de confirmar
                        document.querySelector('#summaryModal button[onclick="submitRegisterForm()"]').disabled = missing.length > 0;
                        document.querySelector('#summaryModal button[onclick="submitRegisterForm()"]').classList.toggle('opacity-50', missing.length > 0);
                    }

                    function closeSummaryModal() {
                        document.getElementById('summaryModal').classList.add('hidden');
                    }

                    function submitRegisterForm() {
                        document.getElementById('registerForm').submit();
                    }
                    </script>
                </form>
                <script>
                    // Limpiar campos al cargar la página
                    window.addEventListener('DOMContentLoaded', function() {
                        document.getElementById('registerForm').reset();
                        ['name', 'email', 'celular', 'password', 'password_confirmation'].forEach(id => {
                            document.getElementById(id).value = '';
                        });
                    });
                </script>
            </div>
        </div>
    </section>

    <!-- Validación rápida -->
    <script>
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            let valid = true;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            const celularRegex = /^\d{4}-\d{4}$/;

            // Limpiar errores
            ['nameError', 'emailError', 'celularError', 'passwordError', 'passwordConfirmationError'].forEach(
            id => {
                document.getElementById(id).textContent = '';
            });

            const name = document.getElementById('name').value.trim();
            if (name.length < 3) {
                document.getElementById('nameError').textContent = 'Debe tener al menos 3 caracteres.';
                valid = false;
            }

            const email = document.getElementById('email').value.trim();
            if (!emailRegex.test(email)) {
                document.getElementById('emailError').textContent = 'Correo inválido.';
                valid = false;
            }

            const celular = document.getElementById('celular').value.trim();
            if (!celularRegex.test(celular)) {
                document.getElementById('celularError').textContent = 'Formato debe ser 0000-0000.';
                valid = false;
            }

            const pass = document.getElementById('password').value;
            const passConfirm = document.getElementById('password_confirmation').value;
            if (pass.length < 6) {
                document.getElementById('passwordError').textContent = 'Debe tener al menos 6 caracteres.';
                valid = false;
            }
            if (pass !== passConfirm) {
                document.getElementById('passwordConfirmationError').textContent = 'No coinciden.';
                valid = false;
            }

            if (!valid) e.preventDefault();
        });

        document.getElementById('celular').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 4) {
                value = value.slice(0, 4) + '-' + value.slice(4, 8);
            }
            e.target.value = value.slice(0, 9);
        });
    </script>

</body>

</html>
