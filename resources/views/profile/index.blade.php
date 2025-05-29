<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-[#1e3a8a]">Mi Perfil</h2>
    </x-slot>

    <div class="max-w-3xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-lg rounded-2xl overflow-hidden border border-[#facc15]">
            <div class="flex flex-col sm:flex-row items-center p-6 bg-[#facc15]">
                <div class="flex-shrink-0">
                    <div class="w-20 h-20 rounded-full bg-[#1e3a8a] flex items-center justify-center text-white text-3xl font-bold shadow-inner">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                </div>
                <div class="mt-4 sm:mt-0 sm:ml-6 flex-1">
                    <h3 class="text-xl font-semibold text-[#1e3a8a] flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#1e3a8a]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        {{ auth()->user()->name }}
                        <span class="ml-2 px-2 py-0.5 rounded-full text-xs font-medium bg-[#1e3a8a] text-white capitalize">
                            {{ auth()->user()->role }}
                        </span>
                    </h3>
                    <div class="mt-2 flex flex-col gap-1 text-[#1e3a8a]">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-[#1e3a8a]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M16 12a4 4 0 01-8 0V8a4 4 0 018 0v4z"/>
                                <path d="M12 16v2m0 0h-2m2 0h2"/>
                            </svg>
                            <span>{{ auth()->user()->email }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-[#1e3a8a]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M3 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H5a2 2 0 01-2-2V5z"/>
                                <path d="M17 7h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V9a2 2 0 012-2z"/>
                                <path d="M7 17h2a2 2 0 012 2v2a2 2 0 01-2 2H7a2 2 0 01-2-2v-2a2 2 0 012-2z"/>
                                <path d="M17 17h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2a2 2 0 012-2z"/>
                            </svg>
                            <span>{{ auth()->user()->celular ?? 'No registrado' }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white">
                <div class="flex gap-3">
                    <a href="{{ route('profile.edit') }}"
                        class="inline-flex items-center px-4 py-2 bg-[#1e3a8a] text-white font-semibold rounded-lg shadow hover:bg-[#243fa1] transition">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M15.232 5.232l3.536 3.536M9 13l6-6m2 2l-6 6m-2 2H7v-2l6-6"/>
                        </svg>
                        Editar Perfil
                    </a>
                   
                </div>
            </div>
            <div class="bg-gray-50 px-6 py-5 border-t border-gray-200">
                <h4 class="text-[#1e3a8a] font-bold mb-2 flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#1e3a8a]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M3 7h18M3 12h18M3 17h18"/>
                    </svg>
                    Resumen de actividad
                </h4>
                @if(isset($orders) && $orders->count())
                    <ul class="divide-y divide-gray-200">
                        @foreach($orders->take(3) as $order)
                            <li class="py-2 flex items-center justify-between">
                                <div>
                                    <span class="font-medium text-gray-800">Pedido #{{ $order->id }}</span>
                                    <span class="ml-2 text-xs text-gray-500">{{ $order->created_at->diffForHumans() }}</span>
                                </div>
                                <span class="inline-block px-2 py-0.5 rounded-full text-xs font-semibold
                                    {{ $order->status === 'entregado' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                    <div class="mt-3 text-right">
                        <a href="{{ route('orders.index') }}" class="text-[#1e3a8a] font-semibold hover:underline text-sm">Ver todos los pedidos</a>
                    </div>
                @else
                    <p class="text-gray-500 text-sm">No hay actividad reciente.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
