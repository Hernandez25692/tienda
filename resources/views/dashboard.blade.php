<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold">¡Hola, administrador!</h1>
        <p class="mt-2 text-gray-700">Aquí podés gestionar tu catálogo y pedidos.</p>
    </div>
</x-app-layout>
