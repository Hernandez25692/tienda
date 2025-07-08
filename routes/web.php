<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\Admin\ClienteController;
use App\Http\Controllers\ImagenProductoController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\AvisoController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
// ADMIN - Gestión de avisos
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/avisos', [AvisoController::class, 'index'])->name('avisos.index');
    Route::get('/avisos/crear', [AvisoController::class, 'create'])->name('avisos.create');
    Route::post('/avisos', [AvisoController::class, 'store'])->name('avisos.store');
    Route::get('/avisos/{aviso}/editar', [AvisoController::class, 'edit'])->name('avisos.edit');
    Route::put('/avisos/{aviso}', [AvisoController::class, 'update'])->name('avisos.update');
    Route::delete('/avisos/{aviso}', [AvisoController::class, 'destroy'])->name('avisos.destroy');
});

// CLIENTE - Marcar aviso como leído
Route::post('/avisos/{aviso}/leido', [AvisoController::class, 'marcarLeido'])
    ->name('avisos.marcarLeido')
    ->middleware('auth');



Route::get('/login', function (Request $request) {
    // 🔒 Forzar logout si hay sesión activa
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    // Mostrar la vista de login
    return app(AuthenticatedSessionController::class)->create();
})->name('login');

Route::get('/ayuda', function () {
    return view('ayuda');
})->name('ayuda');

// Página de inicio
Route::get('/', function () {
    return view('welcome');
})->name('inicio');

// Catálogo público
Route::get('/catalogo', [ProductoController::class, 'catalogoPublico'])->name('catalogo.publico');
Route::get('/catalogo-libre', [ProductoController::class, 'vistaLibreCatalogo'])->name('catalogo.landing');

// Dashboard general
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Rutas protegidas para usuarios autenticados
Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | PERFIL DE USUARIO
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', function () {
        return view('profile.index');
    })->name('profile.index');

    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //notificaciones
    Route::get('/notificaciones', [NotificacionController::class, 'index'])->middleware('auth')->name('notificaciones');
    Route::post('/notificaciones/{id}/leer', [NotificacionController::class, 'marcarLeida'])->middleware('auth')->name('notificaciones.leer');
    /*
    |--------------------------------------------------------------------------
    | CATEGORÍAS (ADMIN)
    |--------------------------------------------------------------------------
    */
    Route::resource('categorias', CategoriaController::class)->except(['show']);

    /*
    |--------------------------------------------------------------------------
    | PRODUCTOS
    |--------------------------------------------------------------------------
    */
    Route::resource('productos', ProductoController::class);
    Route::post('/productos/{producto}/toggle-visibilidad', [ProductoController::class, 'toggleVisibilidad'])
        ->name('productos.toggleVisibilidad');

    /*
    |--------------------------------------------------------------------------
    | IMÁGENES DE PRODUCTO
    |--------------------------------------------------------------------------
    */
    Route::post('/imagenes/eliminar/{id}', [ImagenProductoController::class, 'forceDestroy'])
        ->name('imagenes.forceDestroy');

    /*
    |--------------------------------------------------------------------------
    | PEDIDOS Y CARRITO
    |--------------------------------------------------------------------------
    */
    Route::get('/mis-pedidos', [PedidoController::class, 'misPedidos'])->name('pedidos.mis');
    Route::post('/mis-pedidos/{pedido}/subir-comprobante', [PedidoController::class, 'subirComprobante'])
        ->name('pedidos.subirComprobante');
    Route::post('/pedidos/{pedido}/pago', [PagoController::class, 'store'])->name('pagos.store');
    Route::patch('/pago/{pago}/confirmar', [PagoController::class, 'confirmar'])->name('pagos.confirmar');
    Route::get('/carrito', [CarritoController::class, 'verCarrito'])->name('carrito.index');
    Route::post('/carrito/agregar', [CarritoController::class, 'agregarProducto'])->name('carrito.agregar');
    Route::post('/carrito/eliminar/{key}', [CarritoController::class, 'eliminarProducto'])->name('carrito.eliminar');
    Route::post('/carrito/actualizar/{key}', [CarritoController::class, 'actualizarProducto'])->name('carrito.actualizar');
    Route::post('/carrito/guardar/{key}', [CarritoController::class, 'guardarProducto'])->name('carrito.guardar');
    Route::post('/carrito/confirmar', [CarritoController::class, 'confirmarPedido'])->name('carrito.confirmar');


    /*
    |--------------------------------------------------------------------------
    | ADMIN - CLIENTES Y PEDIDOS
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
        Route::resource('clientes', ClienteController::class)->except(['show']);

        Route::get('/pedidos', [PedidoController::class, 'adminIndex'])->name('pedidos.index');
        Route::get('/pedidos/{pedido}/editar', [PedidoController::class, 'adminEdit'])->name('pedidos.edit');
        Route::put('/pedidos/{pedido}', [PedidoController::class, 'adminUpdate'])->name('pedidos.update');
    });
});


// Rutas de autenticación generadas por Breeze o Fortify
require __DIR__ . '/auth.php';
