<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        return redirect()->back()->with('success', 'Pago registrado correctamente. En espera de confirmación.');
    }

    public function confirmar(Pago $pago)
    {
        $pago->update(['confirmado' => true]);

        return redirect()->back()->with('success', 'Pago confirmado correctamente.');
    }
}
