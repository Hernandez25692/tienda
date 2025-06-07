<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Error del Servidor - EncargaYa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css'])
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen text-center px-4">

    <div class="max-w-xl bg-white p-8 rounded-xl shadow-lg border border-gray-200">
        <img src="{{ asset('storage/logos/logo2.png') }}" alt="EncargaYa" class="mx-auto w-24 mb-6">
        <h1 class="text-4xl font-extrabold text-yellow-500 mb-2">500</h1>
        <h2 class="text-2xl font-bold text-indigo-900 mb-4">¡Algo salió mal!</h2>
        <p class="text-gray-600 mb-6">Estamos trabajando para resolverlo. Por favor intenta nuevamente en unos minutos.
        </p>
        <a href="{{ route('productos.index') }}"
            class="inline-block bg-yellow-400 hover:bg-yellow-300 text-indigo-900 font-semibold px-6 py-2 rounded-lg shadow transition">
            Volver al inicio
        </a>
    </div>

</body>

</html>
