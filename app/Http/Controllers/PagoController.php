<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Notificacion;


class PagoController extends Controller
{
    public function store(Request $request, Pedido $pedido)
    {
        $request->validate([
            'monto' => 'required|numeric|min:1',
            'comprobante' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $ruta = $request->file('comprobante')->store('comprobantes', 'public');

        Pago::create([
            'pedido_id' => $pedido->id,
            'monto' => $request->monto,
            'comprobante' => $ruta,
            'fecha_pago' => now(),
        ]);
        // Notificar a administradores
        $admins = \App\Models\User::where('role', 'admin')->get();

        foreach ($admins as $admin) {
            Notificacion::create([
                'user_id' => $admin->id,
                'titulo' => '💰 Nuevo pago registrado',
                'mensaje' => 'El usuario ' . auth()->user()->name . ' ha registrado un pago para el pedido #' . $pedido->id . '.',
            ]);
        }

        return redirect()->back()->with('success', 'Pago registrado correctamente. En espera de confirmación.');
    }

    public function confirmar(Pago $pago)
    {
        $pago->update(['confirmado' => true]);

        // Obtener el cliente del pedido
        $pedido = Pedido::find($pago->pedido_id);

        if ($pedido && $pedido->user_id) {
            Notificacion::create([
                'user_id' => $pedido->user_id,
                'titulo' => 'Pago confirmado',
                'mensaje' => 'Tu pago del pedido #' . $pedido->id . ' ha sido confirmado. Pronto comenzaremos con el despacho.',
            ]);
        }

        return redirect()->back()->with('success', 'Pago confirmado correctamente y cliente notificado.');
    }
}
