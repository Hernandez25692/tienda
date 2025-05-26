<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\ImagenProducto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    public function index()
    {
        if (auth()->check() && auth()->user()->esAdmin()) {
            // Admin ve todos
            $productos = Producto::all();
        } else {
            // Cliente ve solo visibles y disponibles
            $productos = Producto::where('visible', true)
                ->where('disponible', true)
                ->get();
        }

        return view('productos.index', compact('productos'));
    }


    public function create()
    {
        return view('productos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio_venta' => 'required|numeric',
            'imagenes.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);


        $producto = Producto::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio_venta' => $request->precio_venta,
            'precio_compra' => $request->precio_compra,
            'link_compra' => $request->link_compra,
            'disponible' => $request->disponible
        ]);

        if ($request->hasFile('imagenes')) {
            foreach ($request->file('imagenes') as $imagen) {
                $path = $imagen->store('productos', 'public');
                ImagenProducto::create([
                    'producto_id' => $producto->id,
                    'ruta' => $path
                ]);
            }
        }

        return redirect()->route('productos.index')->with('success', 'Producto creado correctamente.');
    }

    public function edit(Producto $producto)
    {
        $producto->load('imagenes');
        return view('productos.edit', compact('producto'));
    }

    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio_venta' => 'required|numeric',
            'imagenes.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $producto->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio_venta' => $request->precio_venta,
            'precio_compra' => $request->precio_compra,
            'link_compra' => $request->link_compra,
            'disponible' => $request->disponible,
        ]);

        if ($request->hasFile('imagenes')) {
            foreach ($request->file('imagenes') as $imagen) {
                $path = $imagen->store('productos', 'public');
                ImagenProducto::create([
                    'producto_id' => $producto->id,
                    'ruta' => $path
                ]);
            }
        }

        return redirect()->route('productos.index')->with('success', 'Producto actualizado');
    }

    public function show(Producto $producto)
    {
        $producto->load('imagenes');
        return view('productos.show', compact('producto'));
    }
    public function toggleVisibilidad(Producto $producto)
    {
        $producto->visible = !$producto->visible;
        $producto->save();

        return back()->with('success', 'Producto actualizado en el catálogo.');
    }

    public function catalogoPublico()
    {
        $productos = Producto::where('visible', true)
            ->where('disponible', true)
            ->latest()
            ->take(10)
            ->get();

        return view('productos.catalogo_publico', compact('productos'));
    }
    public function vistaCatalogoLibre()
    {
        $productos = Producto::with('imagenes')
            ->where('visible', true)
            ->where('disponible', true)
            ->latest()
            ->take(12)
            ->get();

        return view('catalogo_publico', compact('productos'));
    }
}
