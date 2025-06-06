<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-indigo-100 via-white to-blue-100 py-6 px-4 sm:py-8 sm:px-8 rounded-b-2xl shadow-md border-b border-indigo-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <h2 class="text-2xl sm:text-3xl font-extrabold text-indigo-800 flex items-center gap-3 tracking-tight drop-shadow">
                <span class="text-3xl sm:text-4xl">📦</span>
                <span>Mis Pedidos</span>
            </h2>
            <div class="flex gap-2 mt-2 sm:mt-0">
                <a href="{{ route('productos.index') }}"
                   class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-4 py-2 rounded-lg shadow transition text-sm sm:text-base">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12h18m-6-6l6 6-6 6"></path></svg>
                    Seguir comprando
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-full sm:max-w-4xl mx-auto py-4 sm:py-8 px-1 sm:px-4 bg-gray-50 min-h-screen">
        @forelse ($pedidos as $pedido)
            @php
                $isCancelado = $pedido->estado === 'cancelado';
                $isEntregado = $pedido->estado === 'entregado';
                $estadoColors = [
                    'pendiente' => 'bg-yellow-100 text-yellow-700 border-yellow-300',
                    'confirmado' => 'bg-blue-100 text-blue-700 border-blue-300',
                    'entregado' => 'bg-green-100 text-green-700 border-green-300',
                    'cancelado' => 'bg-red-100 text-red-700 border-red-300',
                ];
                $estadoIconos = [
                    'pendiente' => '⏳',
                    'confirmado' => '🔒',
                    'entregado' => '✅',
                    'cancelado' => '⚠️',
                ];
                $totalConfirmado = $pedido->pagos->where('confirmado', true)->sum('monto');
                $saldoRestante = $pedido->total - $totalConfirmado;
                $pagoSugerido = $totalConfirmado == 0 ? $pedido->total / 2 : $saldoRestante;
            @endphp
            <div class="bg-white rounded-xl shadow-md mb-6 sm:mb-8 p-2 sm:p-6 border border-gray-100">
                {{-- Encabezado del pedido --}}
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-1 sm:gap-2 mb-2 sm:mb-4 border-b pb-2 sm:pb-3">
                    <div>
                        <p class="text-base sm:text-lg font-semibold flex items-center gap-2 {{ $isCancelado ? 'text-red-700 line-through' : 'text-gray-800' }}">
                            <span class="ml-2 text-xs sm:text-base font-normal text-gray-500">Pedido</span>
                            <span class="text-indigo-700 break-words">#{{ $pedido->codigo }}</span>
                        </p>
                        <div class="flex flex-wrap gap-2 sm:gap-3 mt-1 sm:mt-2 text-xs sm:text-sm text-gray-600">
                            <span class="flex items-center gap-1">
                                📅 <span>Fecha: {{ $pedido->created_at->format('d/m/Y') }}</span>
                            </span>
                            @if ($pedido->fecha_entrega_estimada)
                                <span class="flex items-center gap-1">
                                    📅 <span>Entrega: {{ \Carbon\Carbon::parse($pedido->fecha_entrega_estimada)->format('d/m/Y') }}</span>
                                </span>
                            @endif
                        </div>
                    </div>
                    <span class="inline-flex items-center gap-1 px-2 sm:px-3 py-1 rounded-full border text-xs sm:text-sm font-medium {{ $estadoColors[$pedido->estado] ?? 'bg-gray-100 text-gray-700 border-gray-200' }}">
                        {{ $estadoIconos[$pedido->estado] ?? '' }}
                        {{ ucfirst($pedido->estado) }}
                    </span>
                </div>

                {{-- Botón de detalles --}}
                <div class="flex justify-end mb-2">
                    <button 
                        type="button"
                        class="text-blue-700 hover:underline text-xs sm:text-sm font-semibold flex items-center gap-1 focus:outline-none"
                        onclick="document.getElementById('detalles-{{ $pedido->id }}').classList.toggle('hidden')"
                        aria-expanded="false"
                        aria-controls="detalles-{{ $pedido->id }}"
                    >
                        <span>Más detalles</span>
                        <svg class="w-4 h-4 transition-transform inline-block" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                </div>

                <div id="detalles-{{ $pedido->id }}" class="hidden transition-all duration-300 ease-in-out">
                    {{-- Tabla de productos --}}
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[400px] text-xs sm:text-sm text-left mb-2">
                            <thead>
                                <tr class="bg-gray-100 text-gray-700">
                                    <th class="p-2 font-medium">Producto</th>
                                    <th class="p-2 font-medium">Imagen</th>
                                    <th class="p-2 font-medium">Precio</th>
                                    <th class="p-2 font-medium">Cantidad</th>
                                    <th class="p-2 font-medium">Subtotal</th>
                                    <th class="p-2 font-medium">Comentario</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pedido->productos as $producto)
                                    <tr class="border-b last:border-b-0 {{ $isCancelado ? 'line-through text-red-700' : '' }}">
                                        <td class="p-2 break-words max-w-[120px]">{{ $producto->nombre }}</td>
                                        <td class="p-2">
                                            @if ($producto->imagenes->first())
                                                <img src="{{ asset('storage/' . $producto->imagenes->first()->ruta) }}"
                                                    class="w-10 h-10 sm:w-14 sm:h-14 rounded object-cover border border-gray-200 shadow-sm" alt="Imagen producto">
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="p-2">L {{ number_format($producto->pivot->precio_unitario, 2) }}</td>
                                        <td class="p-2">{{ $producto->pivot->cantidad }}</td>
                                        <td class="p-2">L {{ number_format($producto->pivot->cantidad * $producto->pivot->precio_unitario, 2) }}</td>
                                        <td class="p-2 break-words max-w-[100px]">{{ $producto->pivot->comentario ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="bg-gray-50 font-semibold">
                                    <td colspan="4" class="p-2 text-right">Total:</td>
                                    <td class="p-2 text-indigo-700">L {{ number_format($pedido->total, 2) }}</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    {{-- Resumen de abonos --}}
                    <div class="bg-gray-50 rounded p-2 sm:p-4 mt-2 sm:mt-4 mb-2 flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-3 text-xs sm:text-sm font-semibold">
                        <div class="flex-1 flex flex-col gap-1">
                            <span class="flex items-center gap-1">💰 Total: <span class="text-gray-800">L {{ number_format($pedido->total, 2) }}</span></span>
                            <span class="flex items-center gap-1">✅ Abonado: <span class="text-green-700">L {{ number_format($totalConfirmado, 2) }}</span></span>
                            <span class="flex items-center gap-1">🔴 Pendiente: <span class="text-red-600">L {{ number_format($saldoRestante, 2) }}</span></span>
                        </div>
                    </div>
                    <!-- Modal trigger button -->
                    <div class="flex justify-end mb-2">
                        <button 
                            type="button"
                            class="bg-indigo-100 hover:bg-indigo-200 text-indigo-800 font-semibold px-3 py-1 rounded shadow text-xs sm:text-sm flex items-center gap-2 transition"
                            onclick="document.getElementById('modal-cuentas-{{ $pedido->id }}').classList.remove('hidden')"
                        >
                            🏦 Ver cuentas para depósito
                        </button>
                    </div>

                    <!-- Modal -->
                    <div id="modal-cuentas-{{ $pedido->id }}" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
                        <div class="bg-white rounded-lg shadow-lg max-w-md w-full mx-2 p-6 relative">
                            <button 
                                type="button"
                                class="absolute top-2 right-2 text-gray-400 hover:text-gray-700 text-xl font-bold"
                                onclick="document.getElementById('modal-cuentas-{{ $pedido->id }}').classList.add('hidden')"
                                aria-label="Cerrar"
                            >&times;</button>
                            <h3 class="text-lg font-bold text-indigo-800 mb-4 flex items-center gap-2">🏦 Detalles de cuentas para depósito</h3>
                            <ul class="space-y-2 text-sm text-gray-800">
                                <li><span class="font-semibold">Ficohsa:</span> <span class="font-mono">200013764987</span></li>
                                <li><span class="font-semibold">BAC:</span> <span class="font-mono">750215221</span></li>
                                <li><span class="font-semibold">Atlántida:</span> <span class="font-mono">70420171129</span></li>
                                <li><span class="font-semibold">Cuscatlan:</span> <span class="font-mono">216010183021</span></li>
                                <li><span class="font-semibold">Lafise:</span> <span class="font-mono">119504008808</span></li>
                            </ul>
                            <div class="mt-4 text-xs text-gray-600">
                                <span class="font-semibold">Titular:</span> JOSE DEL CARMEN HERNANDEZ MARTINEZ
                            </div>
                            <div class="mt-6 flex justify-end">
                                <button 
                                    type="button"
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded font-semibold text-xs sm:text-sm transition"
                                    onclick="document.getElementById('modal-cuentas-{{ $pedido->id }}').classList.add('hidden')"
                                >Cerrar</button>
                            </div>
                        </div>
                    </div>
                    {{-- Formulario de abono --}}
                    @if ($pedido->estado === 'pendiente' && $saldoRestante > 0)
                        @if (session('abono_error_' . $pedido->id))
                            <div class="bg-red-100 border border-red-300 text-red-700 rounded p-2 mb-2 text-xs sm:text-sm">
                                {{ session('abono_error_' . $pedido->id) }}
                            </div>
                        @endif
                        <div class="bg-yellow-50 border border-yellow-300 p-2 sm:p-4 rounded-lg mt-2 mb-2">
                            <p class="font-medium mb-2 flex items-center gap-2 text-xs sm:text-base">💡 Sugerencia: Abone al menos <span class="text-yellow-800 font-bold">L {{ number_format($pagoSugerido, 2) }}</span></p>
                            <form action="{{ route('pagos.store', $pedido) }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-2 sm:gap-3">
                                @csrf
                                <div>
                                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Monto a abonar:</label>
                                    <input 
                                        type="number" 
                                        name="monto" 
                                        step="0.01" 
                                        min="1" 
                                        max="{{ $saldoRestante }}" 
                                        required
                                        class="w-full rounded border-gray-300 focus:ring-blue-500 focus:border-blue-500 p-2 text-xs sm:text-base"
                                    >
                                    <small class="text-gray-500">Máximo: L {{ number_format($saldoRestante, 2) }}</small>
                                </div>
                                <div>
                                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Comprobante (PDF, JPG, PNG):</label>
                                    <div class="flex gap-2">
                                        <label class="flex-1">
                                            <input 
                                                type="file" 
                                                name="comprobante" 
                                                accept="image/*,.pdf"
                                                class="hidden"
                                                id="comprobante-galeria-{{ $pedido->id }}"
                                                required
                                            >
                                            <span class="block w-full text-center bg-green-100 hover:bg-green-200 text-green-700 rounded px-2 py-2 cursor-pointer text-xs sm:text-sm font-semibold border border-green-200 transition">🖼 Galería/Archivo</span>
                                        </label>
                                    </div>
                                    <div class="mt-2 text-yellow-700 text-xs sm:text-sm font-semibold flex items-center gap-2">
                                        ⚠️ Solo se permite seleccionar archivos desde la galería o archivos del dispositivo. No se permite tomar fotos directamente con la cámara.
                                    </div>
                                    <div id="preview-{{ $pedido->id }}" class="mt-2"></div>
                                </div>
                                <script>
                                    (function() {
                                        const form = document.currentScript.closest('form');
                                        const galeriaInput = form.querySelector('#comprobante-galeria-{{ $pedido->id }}');
                                        const preview = form.querySelector('#preview-{{ $pedido->id }}');
                                        let selectedFile = null;

                                        galeriaInput.addEventListener('change', function(e) {
                                            selectedFile = e.target.files[0] || null;
                                            preview.innerHTML = '';
                                            if (selectedFile) {
                                                if (selectedFile.type.startsWith('image/')) {
                                                    const img = document.createElement('img');
                                                    img.className = "max-h-32 rounded border mt-1";
                                                    img.src = URL.createObjectURL(selectedFile);
                                                    img.onload = () => URL.revokeObjectURL(img.src);
                                                    preview.appendChild(img);
                                                } else if (selectedFile.type === 'application/pdf') {
                                                    const span = document.createElement('span');
                                                    span.className = "text-gray-700 text-xs sm:text-sm";
                                                    span.textContent = '📄 ' + selectedFile.name;
                                                    preview.appendChild(span);
                                                }
                                            }
                                        });

                                        form.addEventListener('submit', function(e) {
                                            let file = galeriaInput.files[0];
                                            if (!file || file.size === 0) {
                                                e.preventDefault();
                                                alert('Por favor, seleccione un comprobante desde la galería o archivos antes de enviar.');
                                                return false;
                                            }
                                        });

                                        form.addEventListener('ajax:error', function(e) {
                                            alert('Ocurrió un error al enviar el comprobante. Intente de nuevo.');
                                        });
                                    })();
                                </script>
                                <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white text-xs sm:text-base px-3 sm:px-4 py-2 rounded shadow font-semibold transition">
                                    📤 Enviar abono
                                </button>
                            </form>
                        </div>
                    @endif

                    {{-- Historial de pagos --}}
                    @if ($pedido->pagos->count())
                        <div class="mt-2 sm:mt-4">
                            <h3 class="font-semibold text-gray-800 mb-2 flex items-center gap-2 text-xs sm:text-base">🧾 Historial de pagos</h3>
                            <ul class="text-xs sm:text-sm text-gray-700 space-y-2 sm:space-y-3">
                                @foreach ($pedido->pagos as $pago)
                                    <li class="border-b last:border-b-0 pb-2 flex flex-col sm:flex-row sm:items-center sm:gap-6">
                                        <span class="flex items-center gap-1">💵 <strong>L {{ number_format($pago->monto, 2) }}</strong></span>
                                        <span class="flex items-center gap-1 mt-1 sm:mt-0">
                                            @if ($pago->confirmado)
                                                <span class="text-green-600 font-semibold">✔ Confirmado</span>
                                            @else
                                                <span class="text-yellow-600 font-semibold">⏳ En revisión</span>
                                            @endif
                                        </span>
                                        <a href="{{ asset('storage/' . $pago->comprobante) }}" target="_blank"
                                            class="text-blue-600 underline mt-1 sm:mt-0 flex items-center gap-1">
                                            📄 Ver comprobante
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <p class="text-gray-600 text-center mt-12 text-base sm:text-lg">No tienes pedidos aún.</p>
        @endforelse
    </div>
    <script>
        // Opcional: Cerrar otros detalles al abrir uno (acordeón)
        document.querySelectorAll('[id^="detalles-"]').forEach(function(det) {
            det.classList.add('hidden');
        });
        document.querySelectorAll('button[onclick*="detalles-"]').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                const id = btn.getAttribute('onclick').match(/detalles-(\d+)/)[1];
                document.querySelectorAll('[id^="detalles-"]').forEach(function(det) {
                    if (!det.id.endsWith(id)) det.classList.add('hidden');
                });
            });
        });
    </script>
</x-app-layout>
