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

        <!-- Redes sociales -->
        <div>
            <h3 class="font-semibold text-lg mb-4 text-yellow-400">🌐 Síguenos</h3>
            <div class="flex space-x-4 text-white/80">
                <a href="https://facebook.com/encargaya" target="_blank" class="hover:text-yellow-400 transition">📘 Facebook</a>
                <a href="https://instagram.com/encargaya" target="_blank" class="hover:text-yellow-400 transition">📸 Instagram</a>
                <a href="https://tiktok.com/@encargaya" target="_blank" class="hover:text-yellow-400 transition">🎵 TikTok</a>
            </div>
        </div>
    </div>

    <div class="border-t border-white/10">
        <p class="text-center text-xs md:text-sm py-4 text-white/80">
            © {{ now()->year }} <strong>EncargaYa</strong> – Tu compra confiable al alcance de un clic.
        </p>
    </div>
</footer>

