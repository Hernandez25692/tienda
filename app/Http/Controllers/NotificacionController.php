<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notificacion;
use Illuminate\Support\Facades\Auth;

class NotificacionController extends Controller
{
    public function index()
    {
        $notificaciones = Notificacion::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('notificaciones.index', compact('notificaciones'));
    }

    public function marcarLeida($id)
    {
        $notificacion = Notificacion::findOrFail($id);
        if ($notificacion->user_id == Auth::id()) {
            $notificacion->leido = true;
            $notificacion->save();
        }
        return redirect()->route('notificaciones');
    }
}
