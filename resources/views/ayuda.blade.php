<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <span class="inline-flex items-center justify-center bg-yellow-400 text-white rounded-full w-10 h-10 shadow-md">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/>
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M12 16v-1m0-4a2 2 0 1 1 2 2c0 1-2 1-2 3"/>
                </svg>
            </span>
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight">
                Centro de Ayuda <span class="text-yellow-500">EncargaYa</span>
            </h1>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <!-- Video Tutorial -->
        <section class="mb-12 bg-white rounded-2xl shadow-lg p-6 md:p-10 flex flex-col gap-6">
            <h2 class="text-2xl font-semibold text-gray-900 flex items-center gap-2">
            <span class="inline-block bg-orange-400 text-white rounded-full p-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M15 10l4.553-2.276A1 1 0 0 1 21 8.618v6.764a1 1 0 0 1-1.447.894L15 14M4 6v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </span>
            ¿Cómo realizar un pedido en EncargaYa?
            </h2>
            <div class="aspect-w-16 aspect-h-9 rounded-xl overflow-hidden shadow-md bg-gray-100">
            <iframe src="https://www.youtube.com/embed/Tm6btPjWOUY?rel=0&modestbranding=1&showinfo=0&controls=1"
                title="Cómo realizar un pedido"
                frameborder="0"
                allowfullscreen
                class="w-full h-full"></iframe>
            </div>
        </section>

        <!-- Preguntas Frecuentes -->
        <section class="mb-12 bg-white rounded-2xl shadow-lg p-6 md:p-10">
            <h2 class="text-2xl font-semibold text-gray-900 mb-6 flex items-center gap-2">
                <span class="inline-block bg-yellow-400 text-white rounded-full p-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M8 10h.01M12 14h.01M16 10h.01M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
                Preguntas Frecuentes
            </h2>
            <ul class="space-y-6">
                <li class="border-l-4 border-yellow-400 pl-4">
                    <p class="font-bold text-gray-800">¿Qué pasa si el producto ya no está disponible?</p>
                    <p class="text-gray-600 mt-1">Recibirás una notificación y podrás elegir un reemplazo o cancelar.</p>
                </li>
                <li class="border-l-4 border-yellow-400 pl-4">
                    <p class="font-bold text-gray-800">¿Puedo pagar en efectivo?</p>
                    <p class="text-gray-600 mt-1">Sí, se coordina contra entrega.</p>
                </li>
                <li class="border-l-4 border-yellow-400 pl-4">
                    <p class="font-bold text-gray-800">¿Dónde veo el estado de mi pedido?</p>
                    <p class="text-gray-600 mt-1">En la sección “Mis pedidos” del menú.</p>
                </li>
            </ul>
        </section>

        <!-- Soporte / Contacto -->
        <section class="bg-gradient-to-r from-yellow-100 via-orange-50 to-yellow-50 rounded-2xl shadow-lg p-6 md:p-10 flex flex-col md:flex-row items-center justify-between gap-6">
            <div>
                <h2 class="text-2xl font-semibold text-gray-900 flex items-center gap-2 mb-2">
                    <span class="inline-block bg-orange-400 text-white rounded-full p-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                    ¿Aún tienes dudas?
                </h2>
                <p class="text-gray-700 mb-4">Nuestro equipo de soporte está listo para ayudarte. Pronto podrás escribirnos por chat en tiempo real o WhatsApp directamente desde aquí.</p>
            </div>
            <div>
                <button class="bg-yellow-400 hover:bg-orange-400 transition-colors text-white font-bold py-3 px-8 rounded-xl shadow-md text-lg flex items-center gap-2 cursor-not-allowed opacity-70" disabled>
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Chat próximamente
                </button>
            </div>
        </section>
    </div>

    <!-- Aspect Ratio Polyfill for older Tailwind versions -->
    <style>
        @media (max-width: 640px) {
            .text-3xl { font-size: 2rem; }
            .text-2xl { font-size: 1.25rem; }
        }
        .aspect-w-16.aspect-h-9 {
            position: relative;
            width: 100%;
            padding-bottom: 56.25%;
        }
        .aspect-w-16.aspect-h-9 > iframe {
            position: absolute;
            width: 100%;
            height: 100%;
            left: 0; top: 0;
        }
    </style>
</x-app-layout>
