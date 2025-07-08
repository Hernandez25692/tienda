<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aviso;
use Illuminate\Support\Facades\Storage;

class AvisoController extends Controller
{
    public function index()
    {
        $avisos = Aviso::latest()->get();
        return view('admin.avisos.index', compact('avisos'));
    }

    public function create()
    {
        return view('admin.avisos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'nullable|string|max:255',
            'contenido' => 'nullable|string',
            'imagen' => 'nullable|image|max:2048',
            'mostrar_desde' => 'nullable|date',
            'mostrar_hasta' => 'nullable|date|after_or_equal:mostrar_desde',
            'activo' => 'required|boolean',
        ]);

        // Validar que al menos uno de los tres exista
        if (
            !$request->filled('titulo') &&
            !$request->filled('contenido') &&
            !$request->hasFile('imagen')
        ) {
            return back()->withErrors(['imagen' => 'Debes ingresar un título, contenido o subir una imagen.'])->withInput();
        }

        $ruta = null;
        if ($request->hasFile('imagen')) {
            $ruta = $request->file('imagen')->store('avisos', 'public');
        }

        Aviso::create([
            'titulo' => $request->titulo,
            'contenido' => $request->contenido,
            'imagen' => $ruta,
            'mostrar_desde' => $request->mostrar_desde,
            'mostrar_hasta' => $request->mostrar_hasta,
            'activo' => $request->activo,
        ]);

        return redirect()->route('admin.avisos.index')->with('success', 'Aviso creado correctamente.');
    }

    public function edit(Aviso $aviso)
    {
        return view('admin.avisos.edit', compact('aviso'));
    }

    public function update(Request $request, Aviso $aviso)
    {
        $request->validate([
            'titulo' => 'nullable|string|max:255',
            'contenido' => 'nullable|string',
            'imagen' => 'nullable|image|max:2048',
            'mostrar_desde' => 'nullable|date',
            'mostrar_hasta' => 'nullable|date|after_or_equal:mostrar_desde',
            'activo' => 'required|boolean',
        ]);

        // Validar que al menos uno de los tres exista
        if (
            !$request->filled('titulo') &&
            !$request->filled('contenido') &&
            !$request->hasFile('imagen') &&
            !$aviso->imagen // en edición también hay que considerar si ya tiene imagen previa
        ) {
            return back()->withErrors(['imagen' => 'Debes mantener un título, contenido o imagen.'])->withInput();
        }

        if ($request->hasFile('imagen')) {
            if ($aviso->imagen) {
                Storage::disk('public')->delete($aviso->imagen);
            }
            $aviso->imagen = $request->file('imagen')->store('avisos', 'public');
        }

        $aviso->update([
            'titulo' => $request->titulo,
            'contenido' => $request->contenido,
            'mostrar_desde' => $request->mostrar_desde,
            'mostrar_hasta' => $request->mostrar_hasta,
            'activo' => $request->activo,
            'imagen' => $aviso->imagen, // actualizamos si hubo cambio, o mantenemos la anterior
        ]);

        return redirect()->route('admin.avisos.index')->with('success', 'Aviso actualizado correctamente.');
    }

    public function destroy(Aviso $aviso)
    {
        if ($aviso->imagen) {
            Storage::disk('public')->delete($aviso->imagen);
        }
        $aviso->delete();
        return back()->with('success', 'Aviso eliminado correctamente.');
    }

    public function marcarLeido(Request $request, Aviso $aviso)
    {
        $user = $request->user();

        if (!$aviso->usuarios()->where('user_id', $user->id)->exists()) {
            $aviso->usuarios()->attach($user->id, ['leido' => true]);
        }

        return response()->json(['success' => true]);
    }
}
