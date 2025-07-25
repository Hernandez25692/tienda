<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class CarritoController extends Controller
{
    public function verCarrito()
    {
        $carrito = session()->get('carrito', []);
        $ahora = now();
        $hay_ofertas_vencidas = false;

        foreach ($carrito as $key => &$item) {
            if (!empty($item['oferta_expires_at']) && $ahora->greaterThan($item['oferta_expires_at'])) {
                $item['precio'] = $item['precio_venta'];
                $item['precio_oferta'] = null;
                $item['oferta_expires_at'] = null;
                $item['oferta_vencida'] = true;
                $hay_ofertas_vencidas = true;
            } else {
                $item['oferta_vencida'] = false;
            }
        }

        session()->put('carrito', $carrito);

        return view('carrito.index', compact('carrito', 'hay_ofertas_vencidas'));
    }



    public function agregarProducto(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1|max:10',
        ]);

        $producto = Producto::findOrFail($request->producto_id);

        $carrito = session()->get('carrito', []);

        $precioFinal = $producto->precio_venta;
        $ofertaActiva = false;

        if ($producto->precio_oferta && now()->lte($producto->oferta_expires_at)) {
            $precioFinal = $producto->precio_oferta;
            $ofertaActiva = true;
        }

        // Verificar si el producto ya está en el carrito (por id)
        $yaExiste = false;
        foreach ($carrito as &$item) {
            if ($item['id'] == $producto->id) {
                $item['cantidad'] += $request->cantidad;
                $item['comentario'] = $request->comentario ?? '';
                $yaExiste = true;
                break;
            }
        }

        // Si no está en el carrito, agregarlo como nuevo
        if (! $yaExiste) {
            $carrito[] = [
                'id' => $producto->id,
                'nombre' => $producto->nombre,
                'precio' => $precioFinal,
                'precio_venta' => $producto->precio_venta,
                'precio_oferta' => $ofertaActiva ? $producto->precio_oferta : null,
                'oferta_expires_at' => $ofertaActiva ? $producto->oferta_expires_at : null,
                'imagen' => $producto->imagenes->first() ? asset('storage/' . $producto->imagenes->first()->ruta) : null,
                'cantidad' => $request->cantidad,
                'comentario' => $request->comentario ?? '',
                'stock' => $producto->stock,
                'disponible' => $producto->disponible,
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
        $ahora = now();

        if (empty($carrito)) {
            return redirect()->route('carrito.index')->with('error', 'El carrito está vacío.');
        }

        $total = 0;
        $productos_ajustados = [];

        foreach ($carrito as $key => $valor) {
            $producto = Producto::find($valor['id']);

            // Producto eliminado
            if (!$producto) {
                unset($carrito[$key]);
                $productos_ajustados[] = 'Un producto fue eliminado del sistema.';
                continue;
            }

            // Verificar si está disponible
            if (!$producto->disponible) {
                unset($carrito[$key]);
                $productos_ajustados[] = "{$producto->nombre} está agotado y fue eliminado del carrito.";
                continue;
            }

            // Validar precios y ofertas
            $oferta_vigente = $producto->precio_oferta &&
                $producto->precio_oferta < $producto->precio_venta &&
                (!$producto->oferta_expires_at || $ahora->lte($producto->oferta_expires_at));

            if ($oferta_vigente) {
                if ($valor['precio'] != $producto->precio_oferta) {
                    $valor['precio'] = $producto->precio_oferta;
                    $valor['precio_oferta'] = $producto->precio_oferta;
                    $valor['oferta_expires_at'] = $producto->oferta_expires_at;
                    $productos_ajustados[] = "{$producto->nombre} tiene una nueva oferta activa.";
                }
            } else {
                if ($valor['precio'] != $producto->precio_venta) {
                    $valor['precio'] = $producto->precio_venta;
                    $valor['precio_oferta'] = null;
                    $valor['oferta_expires_at'] = null;
                    $productos_ajustados[] = "{$producto->nombre} ya no tiene oferta activa.";
                }
            }

            $valor['disponible'] = $producto->disponible;
            $carrito[$key] = $valor;
            $total += $valor['precio'] * $valor['cantidad'];
        }

        session()->put('carrito', $carrito);

        if (count($productos_ajustados) > 0) {
            return redirect()->route('carrito.index')->with([
                'ajustes_carrito' => $productos_ajustados,
            ]);
        }

        // Crear el pedido
        $pedido = \App\Models\Pedido::create([
            'user_id' => auth()->id(),
            'total' => $total,
            'estado' => 'pendiente',
            'fecha_entrega_estimada' => now()->addDays(25),
        ]);

        $pedido->codigo = 'PED-' . now()->format('Ymd') . '-' . str_pad($pedido->id, 5, '0', STR_PAD_LEFT);
        $pedido->save();

        foreach ($carrito as $item) {
            $pedido->productos()->attach($item['id'], [
                'cantidad' => $item['cantidad'],
                'precio_unitario' => $item['precio'],
                'comentario' => $item['comentario'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        session()->forget('carrito');

        return redirect()->route('pedidos.mis')->with('success', '✅ Pedido confirmado correctamente.');
    }
}
