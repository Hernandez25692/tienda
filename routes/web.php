<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImagenProductoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\Admin\ClienteController;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('clientes', ClienteController::class)->except(['show']);
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
    // Carrito de compras
    Route::get('/carrito', [PedidoController::class, 'verCarrito'])->name('carrito.ver');
    Route::post('/carrito/agregar', [PedidoController::class, 'agregarProducto'])->name('carrito.agregar');
    Route::post('/carrito/eliminar/{id}', [PedidoController::class, 'eliminarProducto'])->name('carrito.eliminar');
    Route::post('/carrito/confirmar', [PedidoController::class, 'confirmarPedido'])->name('carrito.confirmar');
    Route::get('/mis-pedidos', [PedidoController::class, 'misPedidos'])->name('pedidos.mis');
    Route::get('/admin/pedidos', [PedidoController::class, 'adminIndex'])->name('admin.pedidos.index');
    Route::get('/admin/pedidos/{pedido}/editar', [PedidoController::class, 'adminEdit'])->name('admin.pedidos.edit');
    Route::put('/admin/pedidos/{pedido}', [PedidoController::class, 'adminUpdate'])->name('admin.pedidos.update');
    Route::get('/carrito/index', [PedidoController::class, 'verCarrito'])->name('carrito.index');
});

Route::post('/mis-pedidos/{pedido}/subir-comprobante', [PedidoController::class, 'subirComprobante'])
    ->name('pedidos.subirComprobante')
    ->middleware('auth');


require __DIR__ . '/auth.php';
