<x-app-layout>
    <div class="min-h-screen flex items-center justify-center bg-[#F9FAFB]">
        <div class="bg-white p-10 rounded-lg shadow-lg text-center max-w-md w-full">
            <img src="{{ asset('storage/logos/logo1.png') }}" alt="Encarga Ya" class="mx-auto mb-6 w-24 h-24">
            <h1 class="text-3xl font-extrabold text-[#FF4F00] mb-3">¡Sesión expirada!</h1>
            <p class="text-gray-700 mb-3">
                Por seguridad, tu sesión en <span class="font-semibold text-[#FF4F00]">Encarga Ya</span> ha finalizado.
            </p>
            <p class="text-gray-500 mb-6">
                Vuelve a iniciar sesión para continuar con tus pedidos. Si el problema persiste, escríbenos a <a href="mailto:encargayahn@gmail.com" class="text-[#FF4F00] underline">encargayahn@gmail.com</a>.
            </p>
            <a href="{{ route('login') }}" class="inline-block px-5 py-2 bg-[#FF4F00] text-white rounded-full font-semibold hover:bg-[#e04300] transition">
                Iniciar sesión
            </a>
        </div>
    </div>
</x-app-layout>
