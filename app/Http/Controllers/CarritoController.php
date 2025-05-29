<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class CarritoController extends Controller
{
    public function verCarrito()
    {
        $carrito = session()->get('carrito', []);
        return view('carrito.index', compact('carrito'));
    }

    public function agregarProducto(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1|max:10',
        ]);

        $producto = Producto::with('imagenes')->findOrFail($request->producto_id);

        $carrito = session()->get('carrito', []);

        $key = 'producto_' . $producto->id;

        if (isset($carrito[$key])) {
            $carrito[$key]['cantidad'] += $request->cantidad;
        } else {
            $carrito[$key] = [
                'id' => $producto->id,
                'nombre' => $producto->nombre,
                'precio' => $producto->precio_venta,
                'cantidad' => $request->cantidad,
                'disponible' => $producto->disponible,
                'imagen' => $producto->imagenes->first() ? asset('storage/' . $producto->imagenes->first()->ruta) : null,
                'comentario' => $request->comentario ?? null,
            ];
        }

        session()->put('carrito', $carrito);

        return redirect()->route('carrito.index')->with('success', 'Producto agregado al carrito.');
    }

    public function actualizarProducto(Request $request, $key)
    {
        $request->validate([
            'cantidad' => 'required|integer|min:1|max:10',
        ]);

        $carrito = session()->get('carrito', []);

        if (isset($carrito[$key])) {
            $carrito[$key]['cantidad'] = $request->cantidad;
            session()->put('carrito', $carrito);
        }

        return redirect()->route('carrito.index')->with('success', 'Cantidad actualizada.');
    }

    public function eliminarProducto($key)
    {
        $carrito = session()->get('carrito', []);

        if (isset($carrito[$key])) {
            unset($carrito[$key]);
            session()->put('carrito', $carrito);
        }

        return redirect()->route('carrito.index')->with('success', 'Producto eliminado del carrito.');
    }

    public function guardarProducto($key)
    {
        // Simulación de "guardar para después"
        return redirect()->route('carrito.index')->with('success', 'Producto guardado para después (simulado).');
    }

    public function confirmarPedido()
    {
        $carrito = session()->get('carrito', []);

        if (empty($carrito)) {
            return redirect()->route('carrito.index')->with('error', 'El carrito está vacío.');
        }

        $total = 0;

        foreach ($carrito as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }

        // Crear el pedido
        $pedido = \App\Models\Pedido::create([
            'user_id' => auth()->id(),
            'total' => $total,
            'estado' => 'pendiente',
            'fecha_entrega_estimada' => now()->addDays(25),
        ]);
        // Generar código único tipo PED-20240527-00001
        $pedido->codigo = 'PED-' . now()->format('Ymd') . '-' . str_pad($pedido->id, 5, '0', STR_PAD_LEFT);
        $pedido->save();

        // Guardar productos en la tabla intermedia
        foreach ($carrito as $item) {
            $pedido->productos()->attach($item['id'], [
                'cantidad' => $item['cantidad'],
                'precio_unitario' => $item['precio'],
                'comentario' => $item['comentario'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Limpiar carrito
        session()->forget('carrito');

        return redirect()->route('carrito.index')->with('success', 'Pedido confirmado correctamente.');
    }
}
