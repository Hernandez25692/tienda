<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImagenProductoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\Admin\ClienteController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\DashboardController;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('clientes', ClienteController::class)->except(['show']);
    Route::resource('categorias', App\Http\Controllers\CategoriaController::class)->middleware('auth');
});
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

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
    Route::resource('categorias', App\Http\Controllers\CategoriaController::class)->except(['show']);
});

Route::post('/mis-pedidos/{pedido}/subir-comprobante', [PedidoController::class, 'subirComprobante'])
    ->name('pedidos.subirComprobante')
    ->middleware('auth');

Route::get('/catalogo', [App\Http\Controllers\ProductoController::class, 'catalogoPublico'])->name('catalogo.publico');
Route::get('/catalogo-libre', [App\Http\Controllers\ProductoController::class, 'vistaLibreCatalogo'])->name('catalogo.landing');

// Aquí van otras rutas relacionadas con el carrito
Route::middleware('auth')->group(function () {
    Route::get('/carrito', [CarritoController::class, 'verCarrito'])->name('carrito.index');
    Route::post('/carrito/agregar', [CarritoController::class, 'agregarProducto'])->name('carrito.agregar');
    Route::post('/carrito/actualizar/{key}', [CarritoController::class, 'actualizarProducto'])->name('carrito.actualizar');
    Route::post('/carrito/eliminar/{key}', [CarritoController::class, 'eliminarProducto'])->name('carrito.eliminar');
    Route::post('/carrito/guardar/{key}', [CarritoController::class, 'guardarProducto'])->name('carrito.guardar');
    Route::post('/carrito/confirmar', [CarritoController::class, 'confirmarPedido'])->name('carrito.confirmar');
});

require __DIR__ . '/auth.php';
