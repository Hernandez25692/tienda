<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\PedidoProducto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Notificacion;


class PedidoController extends Controller
{

    public function agregarProducto(Request $request)
    {
        $producto = Producto::findOrFail($request->producto_id);

        $carrito = session()->get('carrito', []);

        $carrito[] = [
            'id' => $producto->id,
            'nombre' => $producto->nombre,
            'precio' => $producto->precio_venta,
            'cantidad' => 1,
            'comentario' => $request->comentario,
            'imagen' => $producto->imagenes->first() ? asset('storage/' . $producto->imagenes->first()->ruta) : null
        ];

        session()->put('carrito', $carrito);


        return redirect()->route('carrito.ver')->with('success', 'Producto agregado al carrito.');
    }

    public function verCarrito()
    {
        $carrito = session()->get('carrito', []);
        return view('carrito.index', compact('carrito'));
    }

    public function eliminarProducto($key)
    {
        $carrito = session()->get('carrito', []);

        if (isset($carrito[$key])) {
            unset($carrito[$key]);
            session()->put('carrito', $carrito);
        }

        return back()->with('success', 'Producto eliminado del carrito.');
    }


    public function confirmarPedido(Request $request)
    {
        $carrito = session()->get('carrito', []);

        if (empty($carrito)) {
            return back()->with('error', 'El carrito está vacío.');
        }

        DB::beginTransaction();

        try {
            // Crear el pedido
            $pedido = Pedido::create([
                'user_id' => Auth::id(),
                'total' => collect($carrito)->sum(fn($item) => $item['precio'] * $item['cantidad']),
                'estado' => 'pendiente',
                'fecha_entrega_estimada' => now()->addDays(25),
            ]);

            // Registrar cada producto en la tabla intermedia
            foreach ($carrito as $item) {
                $pedido->productos()->attach($item['id'], [
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['precio'],
                    'comentario' => $item['comentario'],
                ]);
            }


            DB::commit();

            // Vaciar el carrito
            session()->forget('carrito');

            return redirect()->route('carrito.ver')->with('success', 'Pedido confirmado correctamente.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error al confirmar el pedido: ' . $e->getMessage());
        }
    }
    /**
     * Muestra los pedidos del usuario autenticado.
     */
    public function misPedidos()
    {
        $pedidos = Pedido::with(['productos.imagenes', 'pagos'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pedidos.mis', compact('pedidos'));
    }

    // Muestra los pedidos en el panel de administración.
    public function adminIndex(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Acceso no autorizado');
        }

        $query = Pedido::with(['user', 'productos.imagenes', 'pagos']);

        if ($request->filled('cliente')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->cliente . '%');
            });
        }

        if ($request->filled('desde')) {
            $query->whereDate('created_at', '>=', $request->desde);
        }

        if ($request->filled('hasta')) {
            $query->whereDate('created_at', '<=', $request->hasta);
        }
        // ✅ Filtro por estado
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $pedidos = $query->latest()->get();

        return view('admin.pedidos.index', compact('pedidos'));
    }

    //Editar pedido
    public function adminEdit(Pedido $pedido)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Acceso no autorizado');
        }

        $pedido->load('productos.imagenes', 'user', 'pagos');

        return view('admin.pedidos.edit', compact('pedido'));
    }

    //Actualizar estado o fecha de entrega
    public function adminUpdate(Request $request, Pedido $pedido)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Acceso no autorizado');
        }

        $request->validate([
            'estado' => 'required|string',
            'fecha_entrega_estimada' => 'nullable|date',
        ]);

        $pedido->update([
            'estado' => $request->estado,
            'fecha_entrega_estimada' => $request->fecha_entrega_estimada,
        ]);

        // Notificar al cliente
        Notificacion::create([
            'user_id' => $pedido->user_id,
            'titulo' => 'Actualización de pedido',
            'mensaje' => 'El estado de tu pedido #' . $pedido->id . ' ha sido actualizado a "' . $pedido->estado . '".',
        ]);

        return redirect()->route('admin.pedidos.index')->with('success', 'Pedido actualizado y notificación enviada.');
    }
    // Subir comprobante de pago
    public function subirComprobante(Request $request, Pedido $pedido)
    {
        if ($pedido->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'comprobante' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        if ($pedido->comprobante && Storage::disk('public')->exists($pedido->comprobante)) {
            Storage::disk('public')->delete($pedido->comprobante);
        }

        $ruta = $request->file('comprobante')->store('comprobantes', 'public');

        $pedido->comprobante = $ruta;
        $pedido->save();

        return back()->with('success', 'Comprobante subido correctamente.');
    }

    public function index()
    {
        $carrito = session()->get('carrito', []);
        return view('carrito.index', compact('carrito'));
    }
}
