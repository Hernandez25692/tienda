<x-app-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="bg-white p-10 rounded shadow text-center">
            <h1 class="text-4xl font-bold text-red-600 mb-4">¡Oops! Sesión expirada</h1>
            <p class="text-gray-700 mb-4">
                Tu sesión ha caducado por inactividad o por un error de seguridad (token CSRF).
            </p>
            <p class="text-gray-600 mb-6">
                Por favor, vuelve a intentarlo. Si el problema persiste, contáctanos.
            </p>
            <a href="{{ route('login') }}" class="inline-block px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                Iniciar sesión nuevamente
            </a>
        </div>
    </div>
</x-app-layout>
