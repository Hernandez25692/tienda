<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-1 md:gap-2">
            <span class="inline-flex items-center justify-center bg-yellow-400 text-white rounded-full w-6 h-6 md:w-8 md:h-8 shadow-md">
            <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/>
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M12 16v-1m0-4a2 2 0 1 1 2 2c0 1-2 1-2 3"/>
            </svg>
            </span>
            <h4 class="text-base md:text-xl font-extrabold text-gray-900 tracking-tight">
                Centro de Ayuda </span>
            </h4>
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
                <li class="border-l-4 border-yellow-400 pl-4">
                    <p class="font-bold text-gray-800">¿Puedo pedir varios productos a la vez?</p>
                    <p class="text-gray-600 mt-1">Sí, podés agregar todos los productos al carrito y luego hacer un solo pedido combinado.</p>
                </li>
                <li class="border-l-4 border-yellow-400 pl-4">
                    <p class="font-bold text-gray-800">¿Cuánto tarda en llegar mi pedido?</p>
                    <p class="text-gray-600 mt-1">Depende del producto. Generalmente entre 8 a 15 días hábiles desde la confirmación del pago.</p>
                </li>
                <li class="border-l-4 border-yellow-400 pl-4">
                    <p class="font-bold text-gray-800">¿Hacen envíos a todo Honduras?</p>
                    <p class="text-gray-600 mt-1">Sí, hacemos envíos a todo el país mediante mensajería confiable.</p>
                </li>
                <li class="border-l-4 border-yellow-400 pl-4">
                    <p class="font-bold text-gray-800">¿Puedo modificar un pedido ya hecho?</p>
                    <p class="text-gray-600 mt-1">Solo si aún no ha sido procesado. Escribinos cuanto antes por WhatsApp.</p>
                </li>
            </ul>
        </section>
        <!-- WhatsApp Contact Section -->
        <section class="relative z-10 my-10">
            <div class="flex flex-col md:flex-row items-center justify-between bg-white rounded-2xl shadow-lg p-6 md:p-10 gap-6 border border-yellow-100">
            <div class="flex items-center gap-4">
                <span class="inline-flex items-center justify-center bg-yellow-400 rounded-full w-14 h-14 shadow-md">
                <!-- WhatsApp SVG Icon -->
                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 32 32">
                    <path d="M16 3C9.373 3 4 8.373 4 15c0 2.65.87 5.1 2.37 7.13L4 29l7.13-2.37A12.93 12.93 0 0 0 16 27c6.627 0 12-5.373 12-12S22.627 3 16 3zm0 22.5c-2.13 0-4.19-.62-5.95-1.8l-.42-.26-4.23 1.41 1.41-4.23-.26-.42A9.97 9.97 0 1 1 26 15c0 5.52-4.48 10-10 10zm5.13-7.47c-.28-.14-1.65-.81-1.9-.9-.25-.09-.43-.14-.61.14-.18.28-.7.9-.86 1.08-.16.18-.32.2-.6.07-.28-.14-1.18-.44-2.25-1.41-.83-.74-1.39-1.65-1.55-1.93-.16-.28-.02-.43.12-.57.13-.13.28-.32.42-.48.14-.16.18-.28.28-.46.09-.18.05-.34-.02-.48-.07-.14-.61-1.47-.84-2.01-.22-.53-.45-.46-.61-.47-.16-.01-.34-.01-.52-.01-.18 0-.48.07-.73.34-.25.27-.97.95-.97 2.32s.99 2.69 1.13 2.88c.14.18 1.95 2.98 4.73 4.06.66.23 1.18.37 1.58.47.66.17 1.26.15 1.73.09.53-.08 1.65-.67 1.89-1.32.23-.65.23-1.2.16-1.32-.07-.12-.25-.18-.53-.32z"/>
                </svg>
                </span>
                <div>
                <h3 class="text-xl md:text-2xl font-bold text-gray-900 mb-1">¿Necesitás ayuda?</h3>
                <p class="text-gray-700 text-base">Escribinos por WhatsApp y te responderemos lo antes posible.</p>
                </div>
            </div>
            <a href="https://wa.me/message/BXFSGVY2YFRVI1" target="_blank"
               class="inline-flex items-center gap-2 bg-yellow-400 hover:bg-yellow-500 active:bg-yellow-600 transition-all duration-200 text-white font-semibold py-3 px-7 rounded-xl shadow-lg text-lg focus:outline-none focus:ring-2 focus:ring-yellow-300 animate-pulse hover:animate-none">
                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 32 32">
                <path d="M16 3C9.373 3 4 8.373 4 15c0 2.65.87 5.1 2.37 7.13L4 29l7.13-2.37A12.93 12.93 0 0 0 16 27c6.627 0 12-5.373 12-12S22.627 3 16 3zm0 22.5c-2.13 0-4.19-.62-5.95-1.8l-.42-.26-4.23 1.41 1.41-4.23-.26-.42A9.97 9.97 0 1 1 26 15c0 5.52-4.48 10-10 10zm5.13-7.47c-.28-.14-1.65-.81-1.9-.9-.25-.09-.43-.14-.61.14-.18.28-.7.9-.86 1.08-.16.18-.32.2-.6.07-.28-.14-1.18-.44-2.25-1.41-.83-.74-1.39-1.65-1.55-1.93-.16-.28-.02-.43.12-.57.13-.13.28-.32.42-.48.14-.16.18-.28.28-.46.09-.18.05-.34-.02-.48-.07-.14-.61-1.47-.84-2.01-.22-.53-.45-.46-.61-.47-.16-.01-.34-.01-.52-.01-.18 0-.48.07-.73.34-.25.27-.97.95-.97 2.32s.99 2.69 1.13 2.88c.14.18 1.95 2.98 4.73 4.06.66.23 1.18.37 1.58.47.66.17 1.26.15 1.73.09.53-.08 1.65-.67 1.89-1.32.23-.65.23-1.2.16-1.32-.07-.12-.25-.18-.53-.32z"/>
                </svg>
                +504 9810-0695 (WhatsApp)
            </a>
            </div>
        </section>

        <!-- Floating WhatsApp Button (optional, can be reused elsewhere) -->
        <style>
            .whatsapp-float-btn {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            z-index: 50;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: #facc15;
            color: #fff;
            font-weight: 600;
            padding: 0.9rem 1.5rem;
            border-radius: 9999px;
            box-shadow: 0 4px 24px 0 rgba(250,204,21,0.15);
            transition: background 0.2s, transform 0.2s;
            cursor: pointer;
            text-decoration: none;
            }
            .whatsapp-float-btn:hover {
            background: #eab308;
            transform: translateY(-4px) scale(1.04);
            text-decoration: none;
            }
            @media (max-width: 640px) {
            .whatsapp-float-btn {
                right: 1rem;
                bottom: 1rem;
                padding: 0.7rem 1.1rem;
                font-size: 1rem;
            }
            }
        </style>
        <!--
        <a href="https://wa.me/message/BXFSGVY2YFRVI1" target="_blank" class="whatsapp-float-btn" aria-label="WhatsApp">
            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 32 32">
            <path d="M16 3C9.373 3 4 8.373 4 15c0 2.65.87 5.1 2.37 7.13L4 29l7.13-2.37A12.93 12.93 0 0 0 16 27c6.627 0 12-5.373 12-12S22.627 3 16 3zm0 22.5c-2.13 0-4.19-.62-5.95-1.8l-.42-.26-4.23 1.41 1.41-4.23-.26-.42A9.97 9.97 0 1 1 26 15c0 5.52-4.48 10-10 10zm5.13-7.47c-.28-.14-1.65-.81-1.9-.9-.25-.09-.43-.14-.61.14-.18.28-.7.9-.86 1.08-.16.18-.32.2-.6.07-.28-.14-1.18-.44-2.25-1.41-.83-.74-1.39-1.65-1.55-1.93-.16-.28-.02-.43.12-.57.13-.13.28-.32.42-.48.14-.16.18-.28.28-.46.09-.18.05-.34-.02-.48-.07-.14-.61-1.47-.84-2.01-.22-.53-.45-.46-.61-.47-.16-.01-.34-.01-.52-.01-.18 0-.48.07-.73.34-.25.27-.97.95-.97 2.32s.99 2.69 1.13 2.88c.14.18 1.95 2.98 4.73 4.06.66.23 1.18.37 1.58.47.66.17 1.26.15 1.73.09.53-.08 1.65-.67 1.89-1.32.23-.65.23-1.2.16-1.32-.07-.12-.25-.18-.53-.32z"/>
            </svg>
            WhatsApp
        </a>
        -->
        <br>
        <!-- Soporte / Contacto -->
        <section class="bg-gradient-to-r from-yellow-100 via-orange-50 to-yellow-50 rounded-2xl shadow-lg p-6 md:p-10 flex flex-col md:flex-row items-center justify-between gap-6">
            <div>
                <h2 class="text-2xl font-semibold text-gray-900 flex items-center gap-2 mb-2">
                    <span class="inline-block bg-orange-400 text-white rounded-full p-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                    
                </h2>
                <p class="text-gray-700 mb-4">Nuestro equipo de soporte está listo para ayudarte. Pronto podrás escribirnos por chat en tiempo real  directamente desde aquí.</p>
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
