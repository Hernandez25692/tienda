<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between py-3 px-3 sm:py-4 sm:px-6 bg-gradient-to-r from-yellow-400 via-yellow-300 to-yellow-200 rounded-b-xl shadow-lg">
            <h2 class="text-xl sm:text-3xl font-extrabold text-gray-900 flex items-center gap-2 sm:gap-3">
            <span class="inline-flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 bg-white rounded-full shadow">
                <i class="fas fa-bell text-yellow-500 text-lg sm:text-2xl"></i>
            </span>
            Notificaciones
            </h2>
            <span class="mt-2 sm:mt-0 text-xs sm:text-sm text-gray-700 font-medium">
            {{ now()->format('d M Y') }}
            </span>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto mt-6 sm:mt-10 px-2 sm:px-4">
        @forelse($notificaciones as $noti)
            <div class="relative bg-white border-l-8 @if(!$noti->leido) border-yellow-400 @else border-gray-200 @endif rounded-xl shadow-md mb-4 sm:mb-6 overflow-hidden transition hover:shadow-xl">
                <div class="flex items-start gap-3 sm:gap-4 p-4 sm:p-6">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-gradient-to-br from-yellow-300 to-yellow-500 flex items-center justify-center shadow">
                            <i class="fas fa-bell text-white text-lg sm:text-xl"></i>
                        </div>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center gap-2">
                            <span class="inline-block w-2 h-2 rounded-full @if(!$noti->leido) bg-yellow-400 @else bg-gray-300 @endif"></span>
                            <h3 class="text-base sm:text-lg font-bold text-gray-900">{{ $noti->titulo }}</h3>
                        </div>
                        <p class="mt-2 text-gray-700 text-sm sm:text-base leading-relaxed">{{ $noti->mensaje }}</p>
                        <div class="mt-3 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2">
                            <span class="text-xs text-gray-400">
                                <i class="far fa-clock mr-1"></i>
                                {{ $noti->created_at->diffForHumans() }}
                            </span>
                            @if(!$noti->leido)
                                <form method="POST" action="{{ route('notificaciones.leer', $noti->id) }}">
                                    @csrf
                                    <button class="inline-flex items-center px-3 sm:px-4 py-1.5 rounded-full text-xs sm:text-sm font-semibold text-white bg-gradient-to-r from-yellow-400 to-yellow-500 shadow hover:from-yellow-500 hover:to-yellow-600 transition">
                                        <i class="fas fa-check mr-2"></i> Marcar como leída
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
                @if(!$noti->leido)
                    <div class="absolute top-0 right-0 px-2 sm:px-3 py-1 bg-yellow-400 text-white text-xs font-bold rounded-bl-xl shadow">
                        Nuevo
                    </div>
                @endif
            </div>
        @empty
            <div class="flex flex-col items-center justify-center py-20 sm:py-24">
                <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-yellow-200 to-yellow-400 rounded-full flex items-center justify-center shadow-lg mb-4 sm:mb-6">
                    <i class="fas fa-inbox text-3xl sm:text-4xl text-white"></i>
                </div>
                <h4 class="text-lg sm:text-xl font-semibold text-gray-700 mb-1 sm:mb-2">¡Sin notificaciones!</h4>
                <p class="text-gray-500 text-sm sm:text-base text-center">No tienes notificaciones por el momento.<br>Vuelve más tarde.</p>
            </div>
        @endforelse
    </div>
</x-app-layout>
