<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo | EncargaYa</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .zoomable-image {
            transition: transform 0.3s cubic-bezier(.4, 2, .6, 1);
            will-change: transform;
            background: #fff;
            z-index: 1;
        }

        .product-image-wrapper:active .zoomable-image,
        .product-image-wrapper:focus .zoomable-image,
        .product-image-wrapper:hover .zoomable-image {
            transform: scale(1.5);
            z-index: 2;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.18);
        }

        /* Modal styles */
        .modal-img-bg {
            display: none;
            position: fixed;
            z-index: 50;
            left: 0;
            top: 0;
            right: 0;
            bottom: 0;
            background: rgba(30, 41, 59, 0.85);
            align-items: center;
            justify-content: center;
            transition: opacity 0.2s;
        }

        .modal-img-bg.active {
            display: flex;
        }

        .modal-img-content {
            max-width: 90vw;
            max-height: 90vh;
            border-radius: 1rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.25);
            background: #fff;
            position: relative;
            animation: modalIn 0.2s;
        }

        @keyframes modalIn {
            from {
                transform: scale(0.95);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .modal-img-content img {
            display: block;
            max-width: 90vw;
            max-height: 80vh;
            border-radius: 1rem;
            margin: 0 auto;
        }

        .modal-img-close {
            position: absolute;
            top: 0.5rem;
            right: 0.8rem;
            font-size: 2rem;
            color: #1e293b;
            background: rgba(255, 255, 255, 0.7);
            border: none;
            border-radius: 50%;
            width: 2.5rem;
            height: 2.5rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s;
        }

        .modal-img-close:hover {
            background: #f1f5f9;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col overflow-x-hidden">
    <div class="w-full bg-gradient-to-br from-white to-yellow-100 border-b border-slate-200 mb-6">
        <div class="max-w-screen-xl mx-auto px-4 py-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="text-center md:text-left">
                    <h1 class="text-2xl sm:text-3xl font-bold text-amber-700 mb-1">Catálogo de Productos</h1>
                    <p class="text-base sm:text-lg text-slate-700 opacity-80">Descubre lo mejor de EncargaYa y haz tu
                        pedido fácil y rápido</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-2 w-full md:w-auto mt-4 md:mt-0">
                    <a href="{{ route('login') }}"
                        class="block w-full sm:w-auto text-center px-4 py-2 rounded-lg font-semibold border-2 border-amber-400 text-amber-700 bg-transparent hover:bg-amber-100 transition">
                        Iniciar Sesión
                    </a>
                    <a href="{{ route('register') }}"
                        class="block w-full sm:w-auto text-center px-4 py-2 rounded-lg font-semibold bg-amber-400 text-white hover:bg-amber-600 transition">
                        Registrarse
                    </a>
                </div>
            </div>
        </div>
    </div>

    <main class="flex-1 w-full max-w-screen-xl mx-auto px-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6 py-2">
            @forelse ($productos as $producto)
                <div class="bg-white rounded-xl overflow-hidden shadow hover:shadow-lg transition flex flex-col h-full">
                    @if ($producto->imagenes->first())
                        <div
                            class="product-image-wrapper relative overflow-hidden cursor-zoom-in bg-white aspect-square flex items-center justify-center">
                            <img src="{{ asset('storage/' . $producto->imagenes->first()->ruta) }}"
                                alt="{{ $producto->nombre }}" class="zoomable-image w-full h-full object-contain"
                                loading="lazy" data-full="{{ asset('storage/' . $producto->imagenes->first()->ruta) }}"
                                tabindex="0">
                        </div>
                    @else
                        <div class="flex items-center justify-center bg-slate-100 text-slate-400 aspect-square w-full">
                            <span class="text-xs sm:text-sm">Sin imagen</span>
                        </div>
                    @endif
                    <div class="flex flex-col flex-1 px-4 py-3 space-y-2">
                        <h3 class="font-semibold text-base sm:text-lg text-slate-800 truncate">{{ $producto->nombre }}
                        </h3>
                        @if ($producto->precio_oferta)
                            <div class="flex items-center gap-2">
                                <span class="text-red-500 font-bold text-lg sm:text-xl">
                                    L {{ number_format($producto->precio_oferta, 2) }}
                                </span>
                                <span class="line-through text-sm text-slate-400">
                                    L {{ number_format($producto->precio_venta, 2) }}
                                </span>
                            </div>
                            <span
                                class="inline-block px-2 py-0.5 rounded-full text-[10px] sm:text-xs font-bold bg-red-100 text-red-700 uppercase w-max tracking-wide">
                                ¡Oferta!
                            </span>
                        @else
                            <p class="font-bold text-amber-700 text-lg sm:text-xl">
                                L {{ number_format($producto->precio_venta, 2) }}
                            </p>
                        @endif

                        @if ($producto->disponible)
                            <span
                                class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700 w-max">Disponible</span>
                        @else
                            <span
                                class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700 w-max">Agotado</span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center text-slate-500 text-base py-8">
                    No hay productos disponibles en este momento.
                </div>
            @endforelse
        </div>

        <!-- Modal HTML -->
        <div class="modal-img-bg" id="modalImgBg" tabindex="-1" aria-modal="true" role="dialog">
            <div class="modal-img-content">
                <button class="modal-img-close" id="modalImgClose" aria-label="Cerrar imagen">&times;</button>
                <img src="" alt="Vista ampliada" id="modalImgTag">
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.product-image-wrapper').forEach(function(wrapper) {
                    const img = wrapper.querySelector('.zoomable-image');
                    wrapper.addEventListener('mousemove', function(e) {
                        const rect = wrapper.getBoundingClientRect();
                        const x = ((e.clientX - rect.left) / rect.width) * 100;
                        const y = ((e.clientY - rect.top) / rect.height) * 100;
                        img.style.transformOrigin = `${x}% ${y}%`;
                        img.style.transform = 'scale(1.7)';
                    });
                    wrapper.addEventListener('mouseleave', function() {
                        img.style.transformOrigin = 'center center';
                        img.style.transform = 'scale(1)';
                    });
                });

                // Modal logic
                const modalBg = document.getElementById('modalImgBg');
                const modalImg = document.getElementById('modalImgTag');
                const modalClose = document.getElementById('modalImgClose');

                document.querySelectorAll('.zoomable-image').forEach(function(img) {
                    img.addEventListener('click', function(e) {
                        modalImg.src = img.getAttribute('data-full');
                        modalBg.classList.add('active');
                        modalImg.alt = img.alt;
                        document.body.style.overflow = 'hidden';
                        modalClose.focus();
                    });
                    img.addEventListener('keydown', function(e) {
                        if (e.key === 'Enter' || e.key === ' ') {
                            img.click();
                        }
                    });
                });

                modalClose.addEventListener('click', function() {
                    modalBg.classList.remove('active');
                    modalImg.src = '';
                    document.body.style.overflow = '';
                });

                modalBg.addEventListener('click', function(e) {
                    if (e.target === modalBg) {
                        modalClose.click();
                    }
                });

                document.addEventListener('keydown', function(e) {
                    if (modalBg.classList.contains('active') && (e.key === 'Escape' || e.key === 'Esc')) {
                        modalClose.click();
                    }
                });
            });
        </script>

        <div class="cta-section bg-white rounded-xl shadow px-4 py-8 my-8 text-center max-w-2xl mx-auto">
            <h2 class="cta-title text-lg sm:text-xl font-semibold text-slate-800 mb-4">¿Te gustaría hacer tu pedido con
                nosotros?</h2>
            <a href="{{ route('register') }}"
                class="block w-full sm:w-auto mx-auto px-6 py-3 rounded-lg font-semibold bg-indigo-600 text-white hover:bg-indigo-700 transition text-center">
                Crear cuenta gratuita
            </a>
        </div>
    </main>

    <footer class="bg-slate-800 text-white py-6 mt-auto">
        <div class="max-w-screen-xl mx-auto px-4 text-center">
            <p class="opacity-80 text-xs sm:text-sm">&copy; {{ date('Y') }} EncargaYa. Todos los derechos
                reservados.</p>
        </div>
    </footer>
</body>

</html>
