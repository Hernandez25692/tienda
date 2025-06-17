@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-100 via-gray-200 to-gray-300">
    <div class="bg-white/80 backdrop-blur-md shadow-xl rounded-2xl px-8 py-10 max-w-md w-full mx-4">
        <div class="flex justify-center mb-6">
            <img src="{{ asset('images/logo.png') }}" alt="EncargaYa Logo" class="h-14 w-auto">
        </div>
        <h1 class="text-3xl md:text-4xl font-extrabold text-center mb-4" style="color: #e3342f;">
            ¡Sesión Expirada!
        </h1>
        <p class="text-gray-700 text-center mb-8">
            Por motivos de seguridad, tu sesión ha caducado. Por favor, vuelve a iniciar sesión para continuar.
        </p>
        <div class="flex justify-center">
            <a href="{{ route('login') }}"
               class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2 rounded-lg shadow transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-green-400">
                Iniciar sesión nuevamente
            </a>
        </div>
    </div>
</div>
@endsection
