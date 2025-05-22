<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImagenProductoController;
use App\Http\Controllers\ProductoController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/imagenes/eliminar/{id}', [ImagenProductoController::class, 'forceDestroy'])->name('imagenes.forceDestroy');
    Route::resource('productos', ProductoController::class);
    Route::post('/productos/{producto}/toggle-visibilidad', [ProductoController::class, 'toggleVisibilidad'])->name('productos.toggleVisibilidad');
});

require __DIR__ . '/auth.php';
