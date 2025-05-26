<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo | EncargaYa</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --color-primary: #f59e0b;
            --color-primary-dark: #d97706;
            --color-secondary: #4f46e5;
            --color-light: #f8fafc;
            --color-gray: #e2e8f0;
            --color-dark: #1e293b;
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--color-light);
            color: var(--color-dark);
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }
        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }
        .header {
            background: linear-gradient(135deg, #ffffff 0%, #fef3c7 100%);
            padding: 2rem 0;
            border-bottom: 1px solid var(--color-gray);
            margin-bottom: 2rem;
        }
        .header-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            gap: 1.5rem;
        }
        @media (min-width: 768px) {
            .header-content {
                flex-direction: row;
                justify-content: space-between;
                text-align: left;
            }
        }
        .title {
            color: var(--color-primary-dark);
            font-size: 2rem;
            font-weight: 700;
            margin: 0;
        }
        .subtitle {
            color: var(--color-dark);
            font-size: 1rem;
            font-weight: 400;
            opacity: 0.8;
            margin-top: 0.5rem;
        }
        .auth-buttons {
            display: flex;
            gap: 1rem;
        }
        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
        }
        .btn-login {
            border: 2px solid var(--color-primary);
            color: var(--color-primary-dark);
            background-color: transparent;
        }
        .btn-login:hover {
            background-color: rgba(245, 158, 11, 0.1);
        }
        .btn-register {
            background-color: var(--color-primary);
            color: white;
        }
        .btn-register:hover {
            background-color: var(--color-primary-dark);
        }
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1.5rem;
            padding: 1rem 0;
        }
        .product-card {
            background-color: white;
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        .product-image {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-bottom: 1px solid var(--color-gray);
        }
        .product-details {
            padding: 1.25rem;
        }
        .product-name {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--color-dark);
            margin-bottom: 0.5rem;
        }
        .product-price {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--color-primary-dark);
            margin-bottom: 0.75rem;
        }
        .product-status {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .status-available {
            background-color: #dcfce7;
            color: #166534;
        }
        .status-soldout {
            background-color: #fee2e2;
            color: #991b1b;
        }
        .cta-section {
            background-color: white;
            padding: 3rem 1rem;
            margin: 3rem 0;
            border-radius: 0.75rem;
            text-align: center;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .cta-title {
            font-size: 1.25rem;
            color: var(--color-dark);
            margin-bottom: 1.5rem;
        }
        .cta-button {
            background-color: var(--color-secondary);
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }
        .cta-button:hover {
            background-color: #4338ca;
        }
        .footer {
            background-color: var(--color-dark);
            color: white;
            padding: 2rem 0;
            text-align: center;
            margin-top: auto;
        }
        .footer-text {
            opacity: 0.8;
            font-size: 0.875rem;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <div class="header-content">
                <div>
                    <h1 class="title">Catálogo de Productos</h1>
                    <p class="subtitle">Descubre lo mejor de EncargaYa y haz tu pedido fácil y rápido</p>
                </div>
                <div class="auth-buttons">
                    <a href="{{ route('login') }}" class="btn btn-login">Iniciar Sesión</a>
                    <a href="{{ route('register') }}" class="btn btn-register">Registrarse</a>
                </div>
            </div>
        </div>
    </div>
    
    <main class="container">
        <div class="products-grid">
            @forelse ($productos as $producto)
                <div class="product-card" style="position:relative;">
                    @if ($producto->imagenes->first())
                        <div class="product-image-wrapper" style="position:relative;overflow:hidden;cursor:zoom-in;">
                            <img 
                                src="{{ asset('storage/' . $producto->imagenes->first()->ruta) }}"
                                alt="{{ $producto->nombre }}"
                                class="product-image zoomable-image"
                                style="transition: transform 0.3s cubic-bezier(.4,2,.6,1);"
                                loading="lazy"
                                data-full="{{ asset('storage/' . $producto->imagenes->first()->ruta) }}"
                                tabindex="0"
                            >
                        </div>
                    @else
                        <div class="product-image" style="display:flex;align-items:center;justify-content:center;background:#f3f4f6;color:#9ca3af;">
                            <span style="font-size:0.9rem;">Sin imagen</span>
                        </div>
                    @endif
                    <div class="product-details">
                        <h3 class="product-name">{{ $producto->nombre }}</h3>
                        <p class="product-price">L {{ number_format($producto->precio_venta, 2) }}</p>
                        @if ($producto->disponible)
                            <span class="product-status status-available">Disponible</span>
                        @else
                            <span class="product-status status-soldout">Agotado</span>
                        @endif
                    </div>
                </div>
            @empty
                <div style="grid-column: 1/-1; text-align:center; color:#64748b; font-size:1.1rem; padding:2rem 0;">
                    No hay productos disponibles en este momento.
                </div>
            @endforelse
        </div>
        <style>
            .product-image-wrapper {
                background: #fff;
                position: relative;
                overflow: hidden;
                border-bottom: 1px solid var(--color-gray);
                height: 180px;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .zoomable-image {
                width: 100%;
                height: 180px;
                object-fit: contain;
                transition: transform 0.3s cubic-bezier(.4,2,.6,1);
                will-change: transform;
                background: #fff;
                z-index: 1;
            }
            .product-image-wrapper:active .zoomable-image,
            .product-image-wrapper:focus .zoomable-image,
            .product-image-wrapper:hover .zoomable-image {
                transform: scale(1.5);
                z-index: 2;
                box-shadow: 0 8px 24px rgba(0,0,0,0.18);
            }
            @media (min-width: 768px) {
                .product-image-wrapper {
                    height: 220px;
                }
                .zoomable-image {
                    height: 220px;
                }
            }
            /* Modal styles */
            .modal-img-bg {
                display: none;
                position: fixed;
                z-index: 9999;
                left: 0; top: 0; right: 0; bottom: 0;
                background: rgba(30,41,59,0.85);
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
                box-shadow: 0 8px 32px rgba(0,0,0,0.25);
                background: #fff;
                position: relative;
                animation: modalIn 0.2s;
            }
            @keyframes modalIn {
                from { transform: scale(0.95); opacity: 0; }
                to { transform: scale(1); opacity: 1; }
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
                background: rgba(255,255,255,0.7);
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
        <!-- Modal HTML -->
        <div class="modal-img-bg" id="modalImgBg" tabindex="-1" aria-modal="true" role="dialog">
            <div class="modal-img-content">
                <button class="modal-img-close" id="modalImgClose" aria-label="Cerrar imagen">&times;</button>
                <img src="" alt="Vista ampliada" id="modalImgTag">
            </div>
        </div>
        <script>
            // Zoom on mouse move
            document.addEventListener('DOMContentLoaded', function () {
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
        
        <div class="cta-section">
            <h2 class="cta-title">¿Te gustaría hacer tu pedido con nosotros?</h2>
            <a href="{{ route('register') }}" class="btn cta-button">Crear cuenta gratuita</a>
        </div>
    </main>
    
    <footer class="footer">
        <div class="container">
            <p class="footer-text">&copy; {{ date('Y') }} EncargaYa. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>
</html>
