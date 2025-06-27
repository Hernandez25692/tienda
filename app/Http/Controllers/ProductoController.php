<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\ImagenProducto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $query = Producto::with('imagenes');

        // Si no es admin, mostrar solo productos disponibles y visibles
        if (!auth()->user()->esAdmin()) {
            $query->where('visible', true)->where('disponible', true);
        }


        if ($request->filled('nombre')) {
            $nombre = strtolower($request->nombre);
            $query->where(function ($q) use ($nombre) {
                $q->where('nombre', 'like', "%$nombre%")
                    ->orWhere('nombre', 'like', "%" . Str::plural($nombre) . "%")
                    ->orWhere('nombre', 'like', "%" . Str::singular($nombre) . "%");
            });
        }

        // Filtro: estado
        if ($request->filled('estado')) {
            if ($request->estado === 'disponible') {
                $query->where('disponible', true);
            } elseif ($request->estado === 'agotado') {
                $query->where('disponible', false);
            }
        }
        if ($request->filled('categoria_id')) {
            $query->where('categoria_id', $request->categoria_id);
        }

        // Filtro: precio
        if ($request->filled('precio_min')) {
            $query->where('precio_venta', '>=', $request->precio_min);
        }

        if ($request->filled('precio_max')) {
            $query->where('precio_venta', '<=', $request->precio_max);
        }

        // Ordenamiento dinámico
        switch ($request->ordenar) {
            case 'nombre_asc':
                $query->orderBy('nombre', 'asc');
                break;
            case 'nombre_desc':
                $query->orderBy('nombre', 'desc');
                break;
            case 'precio_asc':
                $query->orderBy('precio_venta', 'asc');
                break;
            case 'precio_desc':
                $query->orderBy('precio_venta', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        $productos = $query->paginate(20)->withQueryString();

        return view('productos.index', compact('productos'));
    }




    public function create()
    {
        if (!auth()->check() || !auth()->user()->esAdmin()) {
            abort(403, 'Acceso no autorizado');
        }
        $categorias = \App\Models\Categoria::all();
        return view('productos.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        if (!auth()->check() || !auth()->user()->esAdmin()) {
            abort(403, 'Acceso no autorizado');
        }
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
            'disponible' => $request->disponible,
            'categoria_id' => $request->categoria_id,
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
        if (!auth()->check() || !auth()->user()->esAdmin()) {
            abort(403, 'Acceso no autorizado');
        }
        $producto->load('imagenes');
        $categorias = \App\Models\Categoria::all();
        return view('productos.edit', compact('producto', 'categorias'));
    }

    public function update(Request $request, Producto $producto)
    {
        if (!auth()->check() || !auth()->user()->esAdmin()) {
            abort(403, 'Acceso no autorizado');
        }
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
            'categoria_id' => $request->categoria_id,
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
            ->take(100)
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
