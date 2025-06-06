<footer class="bg-blue-900 text-white mt-12">
    <div class="max-w-7xl mx-auto px-6 py-10 grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Contacto -->
        <div>
            <h3 class="font-semibold text-lg mb-4 text-yellow-400">📞 Contáctanos</h3>
            <ul class="space-y-2 text-sm">
                <li class="flex items-start gap-2">
                    <span>📧</span>
                    <a href="mailto:encargayahn@gmail.com" class="hover:underline">encargayahn@gmail.com</a>
                </li>
                <li class="flex items-start gap-2">
                    <span>📱</span>
                    <a href="https://wa.me/message/BXFSGVY2YFRVI1" target="_blank" class="hover:underline">+504 9810-0695 (WhatsApp)</a>
                </li>
                <li class="flex items-start gap-2">
                    <span>📍</span>
                    <span>Choluteca, Honduras</span>
                </li>
            </ul>
        </div>

        <!-- Enlaces rápidos -->
        <div>
            <h3 class="font-semibold text-lg mb-4 text-yellow-400">🔗 Enlaces rápidos</h3>
            <ul class="space-y-2 text-sm">
                <li><a href="{{ route('dashboard') }}" class="hover:text-yellow-400 transition">🏠 Inicio</a></li>
                <li><a href="{{ route('productos.index') }}" class="hover:text-yellow-400 transition">📦 Catálogo</a></li>

            </ul>
        </div>

        <!-- Información sobre nosotros -->
        <div>
            <h3 class="font-semibold text-lg mb-4 text-yellow-400 flex items-center">
            <span class="mr-2">ℹ️</span>
            <button 
                type="button" 
                class="md:hidden bg-yellow-400 text-black px-2 py-1 rounded font-semibold shadow focus:outline-none focus:ring-2 focus:ring-yellow-300 transition text-xs"
                style="font-size: 0.85rem;"
                onclick="document.getElementById('about-info').classList.toggle('hidden')"
            >
                Sobre nosotros
            </button>
            <span class="hidden md:inline">Sobre nosotros</span>
            </h3>
            <div id="about-info" class="md:block hidden">
            <p class="text-xs text-white/80 mb-2">
                En EncargaYa nos dedicamos a facilitar tus compras en línea, ofreciendo productos de calidad y un servicio confiable en Choluteca y alrededores.
            </p>
            <p class="text-xs text-white/80">
                Nuestro compromiso es tu satisfacción y confianza en cada pedido.
            </p>
            </div>
        </div>
    </div>

    <div class="border-t border-white/10">
        <p class="text-center text-xs md:text-sm py-4 text-white/80">
            © {{ now()->year }} <strong>EncargaYa</strong> – Tu compra confiable al alcance de un clic.
        </p>
    </div>
</footer>

