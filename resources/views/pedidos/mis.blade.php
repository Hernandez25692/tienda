<x-app-layout>
    

    <div class="max-w-7xl mx-auto px-2 sm:px-6 py-6">
        <div class="bg-white/80 border border-gray-200 rounded-2xl shadow-lg p-2 sm:p-6">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-indigo-700 mb-6 flex items-center gap-3">
                <span class="text-3xl sm:text-4xl">🛒</span> Tus pedidos en <span class="text-yellow-500">EncargaYa</span>
            </h1>
            <div class="flex gap-2 mt-2 sm:mt-0">
                <a href="{{ route('productos.index') }}"
                   class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-4 py-2 rounded-lg shadow transition text-sm sm:text-base">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12h18m-6-6l6 6-6 6"></path></svg>
                    Seguir comprando
                </a>
            </div>
            @if($pedidos->isEmpty())
                <div class="text-center py-24 text-gray-500 text-lg font-medium">
                    <span class="block text-4xl mb-2">🗂️</span>
                    ¡Aún no tienes pedidos! <br>
                    <a href="{{ route('productos.index') }}" class="inline-block mt-4 px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-semibold shadow transition">Explora productos</a>
                </div>
            @else
            <div class="flex flex-col gap-6 sm:gap-8 md:flex-row md:flex-wrap">
                @foreach($pedidos as $pedido)
                    @php
                        $isCancelado = $pedido->estado === 'cancelado';
                        $isEntregado = $pedido->estado === 'entregado';
                        $estadoColors = [
                            'pendiente' => 'bg-yellow-100 text-yellow-800 border-yellow-300',
                            'confirmado' => 'bg-indigo-100 text-indigo-700 border-indigo-300',
                            'entregado' => 'bg-emerald-100 text-emerald-700 border-emerald-300',
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
                    <section class="relative w-full md:w-[48%] bg-white border border-gray-100 rounded-2xl shadow-md flex flex-col mb-2">
                        <!-- Timeline bar -->
                        <div class="absolute left-0 top-6 bottom-6 w-1 bg-gradient-to-b from-indigo-200 via-yellow-100 to-emerald-100 rounded-full hidden md:block"></div>
                        <div class="p-4 sm:p-6 pl-6 md:pl-10 flex flex-col gap-2">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                                <div>
                                    <div class="flex items-center gap-2 text-lg font-bold {{ $isCancelado ? 'text-red-700 line-through' : 'text-gray-900' }}">
                                        <span class="text-gray-400 font-normal text-xs">Pedido</span>
                                        <span class="text-indigo-700">#{{ $pedido->codigo }}</span>
                                    </div>
                                    <div class="flex flex-wrap gap-3 mt-1 text-xs text-gray-500">
                                        <span class="flex items-center gap-1">
                                            📅 <span>{{ $pedido->created_at->format('d/m/Y') }}</span>
                                        </span>
                                        @if ($pedido->fecha_entrega_estimada)
                                            <span class="flex items-center gap-1">
                                                🚚 <span>Entrega: {{ \Carbon\Carbon::parse($pedido->fecha_entrega_estimada)->format('d/m/Y') }}</span>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full border text-xs font-semibold {{ $estadoColors[$pedido->estado] ?? 'bg-gray-100 text-gray-700 border-gray-200' }}">
                                    {{ $estadoIconos[$pedido->estado] ?? '' }}
                                    {{ ucfirst($pedido->estado) }}
                                </span>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mt-2">
                                <div class="flex items-center gap-2 text-sm">
                                    <span class="font-semibold text-indigo-700">Total:</span>
                                    <span class="text-indigo-900 font-bold">L {{ number_format($pedido->total, 2) }}</span>
                                    <span class="ml-3 font-semibold text-emerald-700">Abonado:</span>
                                    <span class="text-emerald-800 font-bold">L {{ number_format($totalConfirmado, 2) }}</span>
                                    <span class="ml-3 font-semibold text-red-600">Pendiente:</span>
                                    <span class="text-red-600 font-bold">L {{ number_format($saldoRestante, 2) }}</span>
                                </div>
                                <button
                                    type="button"
                                    class="text-indigo-600 hover:underline text-xs font-semibold flex items-center gap-1 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-400 rounded"
                                    onclick="document.getElementById('detalles-{{ $pedido->id }}').classList.toggle('hidden')"
                                    aria-expanded="false"
                                    aria-controls="detalles-{{ $pedido->id }}"
                                >
                                    <span>Ver detalles</span>
                                    <svg class="w-4 h-4 transition-transform inline-block" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                            </div>
                            <!-- Detalles desplegables -->
                            <div id="detalles-{{ $pedido->id }}" class="hidden transition-all duration-300 ease-in-out mt-4">
                                <!-- Tabla de productos -->
                                <div class="overflow-x-auto rounded-lg border border-gray-100 mb-4">
                                    <table class="min-w-[420px] w-full text-xs sm:text-sm text-left">
                                        <thead>
                                            <tr class="bg-gray-50 text-gray-700">
                                                <th class="p-2 font-semibold">Producto</th>
                                                <th class="p-2 font-semibold">Imagen</th>
                                                <th class="p-2 font-semibold">Precio</th>
                                                <th class="p-2 font-semibold">Cantidad</th>
                                                <th class="p-2 font-semibold">Subtotal</th>
                                                <th class="p-2 font-semibold">Comentario</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pedido->productos as $producto)
                                                <tr class="border-b last:border-b-0 {{ $isCancelado ? 'line-through text-red-700' : '' }}">
                                                    <td class="p-2 break-words max-w-[120px]">{{ $producto->nombre }}</td>
                                                    <td class="p-2">
                                                        @if ($producto->imagenes->first())
                                                            <img src="{{ asset('storage/' . $producto->imagenes->first()->ruta) }}"
                                                                class="w-12 h-12 sm:w-16 sm:h-16 rounded-lg object-cover border border-gray-200 shadow-sm" alt="Imagen producto">
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
                                <!-- Modal trigger -->
                                <div class="flex justify-end mb-2">
                                    <button
                                        type="button"
                                        class="bg-indigo-100 hover:bg-indigo-200 text-indigo-800 font-semibold px-3 py-1 rounded shadow text-xs flex items-center gap-2 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-400"
                                        onclick="document.getElementById('modal-cuentas-{{ $pedido->id }}').classList.remove('hidden')"
                                    >
                                        🏦 Ver cuentas para depósito
                                    </button>
                                </div>
                                <!-- Modal -->
                                <div id="modal-cuentas-{{ $pedido->id }}" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 hidden">
                                    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-2 p-6 relative border border-indigo-100">
                                        <button
                                            type="button"
                                            class="absolute top-2 right-2 text-gray-400 hover:text-gray-700 text-2xl font-bold focus:outline-none"
                                            onclick="document.getElementById('modal-cuentas-{{ $pedido->id }}').classList.add('hidden')"
                                            aria-label="Cerrar"
                                        >&times;</button>
                                        <h3 class="text-lg font-bold text-indigo-800 mb-4 flex items-center gap-2">🏦 Cuentas para depósito</h3>
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
                                                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded font-semibold text-xs transition"
                                                onclick="document.getElementById('modal-cuentas-{{ $pedido->id }}').classList.add('hidden')"
                                            >Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                                <!-- Formulario de abono -->
                                @if ($pedido->estado === 'pendiente' && $saldoRestante > 0)
                                    @if (session('abono_error_' . $pedido->id))
                                        <div class="bg-red-100 border border-red-300 text-red-700 rounded p-2 mb-2 text-xs">
                                            {{ session('abono_error_' . $pedido->id) }}
                                        </div>
                                    @endif
                                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg mt-2 mb-2 flex flex-col gap-2">
                                        <span class="inline-flex items-center gap-2 bg-yellow-200 text-yellow-900 px-3 py-1 rounded-full font-semibold text-xs w-fit mb-2">
                                            💡 Sugerencia: Abona al menos L {{ number_format($pagoSugerido, 2) }}
                                        </span>
                                        <form action="{{ route('pagos.store', $pedido) }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-3">
                                            @csrf
                                            <div>
                                                <label class="block text-xs font-medium text-gray-700 mb-1">Monto a abonar:</label>
                                                <input
                                                    type="number"
                                                    name="monto"
                                                    step="0.01"
                                                    min="1"
                                                    max="{{ $saldoRestante }}"
                                                    required
                                                    class="w-full rounded border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 p-2 text-xs"
                                                >
                                                <small class="text-gray-500">Máximo: L {{ number_format($saldoRestante, 2) }}</small>
                                            </div>
                                            <div>
                                                <label class="block text-xs font-medium text-gray-700 mb-1">Comprobante (PDF, JPG, PNG):</label>
                                                <label class="flex items-center gap-2 cursor-pointer">
                                                    <input
                                                        type="file"
                                                        name="comprobante"
                                                        accept="image/*,.pdf"
                                                        class="hidden"
                                                        id="comprobante-galeria-{{ $pedido->id }}"
                                                        required
                                                    >
                                                    <span class="bg-emerald-100 hover:bg-emerald-200 text-emerald-700 rounded px-3 py-2 text-xs font-semibold border border-emerald-200 transition">Seleccionar archivo</span>
                                                </label>
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
                                                                span.className = "text-gray-700 text-xs";
                                                                span.textContent = '📄 ' + selectedFile.name;
                                                                preview.appendChild(span);
                                                            }
                                                        }
                                                    });

                                                    form.addEventListener('submit', function(e) {
                                                        let file = galeriaInput.files[0];
                                                        if (!file || file.size === 0) {
                                                            e.preventDefault();
                                                            alert('Por favor, seleccione un comprobante antes de enviar.');
                                                            return false;
                                                        }
                                                    });
                                                })();
                                            </script>
                                            <button type="submit"
                                                class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs px-4 py-2 rounded shadow font-semibold transition focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-400">
                                                📤 Enviar abono
                                            </button>
                                        </form>
                                    </div>
                                @endif
                                <!-- Historial de pagos -->
                                @if ($pedido->pagos->count())
                                    <div class="mt-4">
                                        <h3 class="font-semibold text-gray-800 mb-2 flex items-center gap-2 text-xs">🧾 Historial de pagos</h3>
                                        <ol class="relative border-l-2 border-indigo-100 pl-4 space-y-4">
                                            @foreach ($pedido->pagos as $pago)
                                                <li class="ml-2">
                                                    <div class="flex items-center gap-2">
                                                        <span class="w-4 h-4 rounded-full flex items-center justify-center
                                                            {{ $pago->confirmado ? 'bg-emerald-400 text-white' : 'bg-yellow-300 text-yellow-900' }}">
                                                            {{ $pago->confirmado ? '✔' : '⏳' }}
                                                        </span>
                                                        <span class="font-bold text-indigo-700">L {{ number_format($pago->monto, 2) }}</span>
                                                        <span class="text-xs {{ $pago->confirmado ? 'text-emerald-700' : 'text-yellow-700' }}">
                                                            {{ $pago->confirmado ? 'Confirmado' : 'En revisión' }}
                                                        </span>
                                                        <a href="{{ asset('storage/' . $pago->comprobante) }}" target="_blank"
                                                            class="text-indigo-600 underline ml-2 text-xs flex items-center gap-1">
                                                            📄 Ver comprobante
                                                        </a>
                                                    </div>
                                                    <div class="ml-6 text-xs text-gray-500">
                                                        {{ $pago->created_at->format('d/m/Y H:i') }}
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ol>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </section>
                @endforeach
            </div>
            @endif
        </div>
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
