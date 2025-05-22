<?php

namespace App\Http\Controllers;

use App\Models\ImagenProducto;
use Illuminate\Support\Facades\Storage;

class ImagenProductoController extends Controller
{
    public function forceDestroy($id)
    {
        $imagen = ImagenProducto::find($id);

        if (!$imagen) {
            return redirect()->back()->with('error', 'Imagen no encontrada');
        }

        // Eliminar del disco si existe
        if (Storage::disk('public')->exists($imagen->ruta)) {
            Storage::disk('public')->delete($imagen->ruta);
        }

        $imagen->delete();

        // Redirigir a la página de edición del producto
        return redirect()->route('productos.edit', $imagen->producto_id)
            ->with('success', 'Imagen eliminada correctamente.');
    }
}
